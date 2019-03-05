---
title: プラグインでコンソールコマンドを作成する
keywords: plugin console
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_console-plugin
folder: plugin
---

## 概要

[3.0.13以降](https://github.com/EC-CUBE/ec-cube/pull/1952){:target="_blank"}からコンソールコマンドを拡張し、cronジョブやインポートなどのバッチジョブをプラグインで開発できます。  

### コンソールプラグインの実行方法

コンソールプラグインを開発することで、以下のように実行することができます。

```
php app/console [グループ名]:[アクション名] [パラメータ]
```

開発中は、`display_errors`をオンにしておくとデバッグが行いやすいです。

```
php -d display_errors app/console [グループ名]:[アクション名] [パラメータ]
```

### コンソールプラグインの実装方法

例として、引数として渡された商品IDから商品情報を出力するコマンドを作成します。

ファイルとフォルダはapp/Plugin以下に作成します

* ファイル・ディレクトリ構造

```
  app/Plugin/
    └── ProductDisplay
        ├── Display.php
        ├── ServiceProvider
        │  └── ProductDisplayServiceProvider.php
        └── config.yml
```
 - Display.phpに、ロジックを実装します。

```
<?php
namespace Plugin\ProductDisplay;

use Knp\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Display extends Command
{
    protected function configure()
    {
        // コマンド名やパラメータの設定を行います。
        // 参考：http://docs.symfony.gr.jp/symfony2/cookbook/console.html

    	$this
            ->setName('product:display')
    	    ->setDescription('Display product info by product id')
    	    ->addArgument('id', InputArgument::REQUIRED, 'Product ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Eccube\Application
        $app = $this->getSilexApplication();

        // 以下にロジックを実装していきます。
        // サンプルとして、引数で指定したIDの商品情報を表示します。
        $output->writeln('<info>Product Info.</info>');
        dump($app["eccube.repository.product"]->find( $input->getArgument('id')));
    }
}
 
```
 
 - ProductDisplayServiceProvider.php では、コマンドをEC-CUBEに登録する処理を記述します。

```
<?php
namespace Plugin\ProductDisplay\ServiceProvider;

class ProductDisplayServiceProvider implements \Silex\ServiceProviderInterface
{
    public function register(\Silex\Application $app)
    {
        // コマンドライン以外ではコマンドの登録はスキップする
        if (!isset($app['console'])) {
            return;
        }
        $app['console']->add(new \Plugin\ProductDisplay\Display());
    }

    public function boot(\Silex\Application $app)
    {
        ;
    }
}
```

- config.ymlにプラグイン情報を記述します。

```
name: 商品情報表示コマンド
code: ProductDisplay
version: 0.0.1
service:
    - ProductDisplayServiceProvider
```

### コンソールプラグインの確認

プラグインが無効状態の場合は有効化してください。

以下で、コマンドの一覧を確認します。

```
php app/console
```

結果の中に、追加したプラグインのコマンドが表示されることを確認します（Available commands:以下）

```
$ php app/console
EC-CUBE version 3.0.13

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help                 Displays help for a command
  list                 Lists commands
 cache
  cache:clear          Clear the cache of Application.
 debug
  debug:config         Shows a list of config file
 migrations
  migrations:diff      Generate a migration by comparing your current database to your mapping information.
  migrations:execute   Execute a single migration version up or down manually.
  migrations:generate  Generate a blank migration class.
  migrations:migrate   Execute a migration to a specified version or the latest available version.
  migrations:status    View the status of a set of migrations.
  migrations:version   Manually add and delete migration versions from the version table.
 plugin
  plugin:develop       plugin commandline installer.
 product
  product:display      Display product info by product id.
 router
  router:debug         Displays current routes for an application

```

コマンドを実行します。

```
php app/console product:display 1
```

指定した商品のdump結果が表示されたら成功です。
