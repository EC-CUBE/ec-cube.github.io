---
layout: default
title: プラグインマネージャー
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/11/27
```

# {{ page.title }}

プラグインのインストール、アンインストール、有効、無効、アップデートを行うときに呼び出される関数が定義されています。  
プラグインをインストール時に行っておきたい処理はプラグインマネージャーで記述しておきます。

```
[プラグインコード]
  ├── PluginManager.php
```


```php
<?php
namespace Plugin\[プラグインコード];

use Eccube\Application;
use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{

    /**
     * プラグインインストール時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function install($config, Application $app)
    {
    }

    /**
     * プラグイン削除時の処理
     *
     * @param $config
     * @param Application $app
     */
    public function uninstall($config, Application $app)
    {
    }

    /**
     * プラグイン有効時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function enable($config, Application $app)
    {
    }

    /**
     * プラグイン無効時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function disable($config, Application $app)
    {
    }

    /**
     * プラグイン更新時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function update($config, Application $app)
    {
    }

}
```

それぞれの関数で行う処理をまとめていきます。


### インストール(install)
プラグインをインストール時に実行される関数です。ここで行う主な処理として、

- 画像やcssファイルなどプラグインで使用するリソースファイルのコピー処理
- インストール時に1回だけ行いたい処理

等を記述します。

### アンインストール(uninstall)
プラグインをアンインストール時に実行される関数です。ここで行う主な処理として、

- アンインストール時に行いたい処理  
`$this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);`
- ブロック削除
- 画像やcssファイルなどプラグインで使用するリソースファイルの削除
- DBマイグレーション処理(プラグインで利用するテーブル削除)

等を記述します。


### 有効(enable)
プラグインを有効時に実行される関数です。ここで行う主な処理として、

- DBマイグレーション処理  
`$this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);`
- ブロックの追加

等を記述します。



### 無効(disable)
プラグインを無効時に実行される関数です。ここで行う主な処理として、

- ブロックの無効化

等を記述します。



### 更新(update)
プラグインを更新時に実行される関数です。ここで行う主な処理として、

- DBマイグレーション処理  
`$this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);`
- リソースファイルのコピー、削除
- 新規ブロックの追加

等機能を追加した時に実行したい処理を記述します。  
インストール時の処理とほぼ同じになります。


- 上記処理を考慮した例

```php
<?php
namespace Plugin\[プラグインコード];

use Eccube\Application;
use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\Filesystem\Filesystem;

class PluginManager extends AbstractPluginManager
{

    /**
     * @var string コピー元リソースディレクトリ
     */
    private $origin;

    /**
     * @var string コピー先リソースディレクトリ
     */
    private $target;

    public function __construct()
    {
        // コピー元のディレクトリ
        $this->origin = __DIR__.'/Resource/assets';
        // コピー先のディレクトリ
        $this->target = '/xxxxxx';
    }

    /**
     * プラグインインストール時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function install($config, Application $app)
    {
        // リソースファイルのコピー
        $this->copyAssets($app);
    }

    /**
     * プラグイン削除時の処理
     *
     * @param $config
     * @param Application $app
     */
    public function uninstall($config, Application $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);
        // リソースファイルの削除
        $this->removeAssets($app);
    }

    /**
     * プラグイン有効時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function enable($config, Application $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);
    }

    /**
     * プラグイン無効時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function disable($config, Application $app)
    {
    }

    /**
     * プラグイン更新時の処理
     *
     * @param $config
     * @param Application $app
     * @throws \Exception
     */
    public function update($config, Application $app)
    {
    }

    /**
     * リソースファイル等をコピー
     *
     * @param Application $app
     */
    private function copyAssets(Application $app)
    {
        $file = new Filesystem();
        $file->mirror($this->origin, $app['config']['plugin_html_realdir'].$this->target.'/assets');
    }

    /**
     * コピーしたリソースファイルなどを削除
     *
     * @param Application $app
     */
    private function removeAssets(Application $app)
    {
        $file = new Filesystem();
        $file->remove($app['config']['plugin_html_realdir'].$this->target);
    }
}
```


