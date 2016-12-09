---
title: app/console向けプラグイン
keywords: plugin console
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_console-plugin
folder: plugin
---

## コンソールプラグイン作成方法 

[3.0.13以降](https://github.com/EC-CUBE/ec-cube/pull/1952){:target="_blank"}からコンソールコマンドを拡張し、cronジョブやインポートなどのバッチジョブをプラグインで開発できます。  

### コンソールフォーマト

```
php app/console [グループ名]:[アクション名] [パラメター]
```

### ファイルとフォルダー作成方法

ファイルとフォルダーはapp/Pluginの以下に作成します

* example (商品インポート)

```
  app/Plugin/
    └── ProductImport
        ├── Import.php
        ├── ServiceProvider
        │  └── ProductImportServiceProvider.php
        └── config.yml
```
 - Import.phpこちらにビジネスロジックを書きます

```
 //Import.php
 // \Knp\Command\Command拡張する
 class Import extends \Knp\Command\Command
{
    protected function configure()
    {
        //コンソールパラメターと説明書きます
		//参考はこちらですhttp://docs.symfony.gr.jp/symfony2/cookbook/console.html
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Eccube\Application
        $app = $this->getSilexApplication();
        
		//こちらビジネスロジックを始まります
    }
}
 
```
 
 - ProductImportServiceProvider.php以下のソースご覧ください

```
 //ProductImportServiceProvider.php
 <?php
namespace Plugin\ProductImport\ServiceProvider;

class ProductImportServiceProvider implements \Silex\ServiceProviderInterface
{
    public function register(\Silex\Application $app)
    {
	    //コマンドライン以外STOPする
        if(!isset($app['console'])){
            return;
        }
        $app['console']->add(new \Plugin\ProductImport\Import());
    }

    public function boot(\Silex\Application $app)
    {
        ;
    }
}
```

- config.ymlプラグイン情報を書きます

```
 //config.yml
name: 商品インポート
code: ProductImport
version: 0.0.1
service:
    - ProductImportServiceProvider

```

### コンソールプラグインの確認

以下のコマンドを実行する

```
　php app/console

```

結果の中に追加したプラグイン表示すること確認します（Available commands:以下）

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
  product:import       Import products from csv file.
 router
  router:debug         Displays current routes for an application

```
