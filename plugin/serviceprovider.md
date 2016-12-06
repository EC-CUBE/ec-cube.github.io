---
layout: default
title: サービスプロバイダー
---

# {{ page.title }}

プラグイン側でルーティング定義やFormの定義等々プラグインに対しての設定を行う場合、`ServiceProvider`で行います。  
プラグインコードが`SampleTest`とした場合、サービスプバイダーのファイル名とディレクトリの配置は以下の通りです。

- ファイル名

```
SampleTestServiceProvider.php
```
ファイル名は`[プラグインコード]ServiceProvider.php`という命名規則で作成します。  
厳密には`config.yml`で定義した`service`の値に合わせます。

- サービスプロバイダーファイル配置場所

```
SampleTest
  ├── ServiceProvider
  │   └── SampleTestServiceProvider.php
```

### サービスプロバイダーの全体像
よく利用されるであろう内容を記載しています。下記はプラグインを`Sample`というプラグインコードで作成しています。

```php
<?php

namespace Plugin\Sample\ServiceProvider;

use Eccube\Common\Constant;
use Plugin\Sample\Form\Type\SampleConfigType;
use Plugin\Sample\Form\Type\Extension\EntryTypeExtension;
use Plugin\Sample\Service\XXXXService;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

require_once(__DIR__.'/../log.php');

class SampleServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app)
    {
        // 管理画面定義
        $admin = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $admin->requireHttps();
        }

        // プラグイン用設定画面
        $admin->match('/plugin/Sample/config', 'Plugin\Sample\Controller\ConfigController::index')->bind('plugin_Sample_config');

        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        // フロント画面定義
        $front = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $front->requireHttps();
        }

        $front->match('/plugin/sample/hello', 'Plugin\Sample\Controller\SampleController::index')->bind('plugin_Sample_hello');

        $app->mount('', $front);

        // Form
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new SampleConfigType();

            return $types;
        }));

        // Form Extension
        $app['form.type.extensions'] = $app->share($app->extend('form.type.extensions', function ($extensions) use ($app) {
            $extensions[] = new EntryTypeExtension($app);

            return $extensions;
        }));

        // Repository
        $app['sample.repository.[エンティティ名]'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\Sample\Entity\[エンティティ]');
        });

        // 既存Repositoryを継承したRepository定義
        $app['sample.repository.category'] = $app->share(function () use ($app) {
            return new XXXXRepository($app['orm.em'], $app['orm.em']->getMetadataFactory()->getMetadataFor('Eccube\Entity\Category'));
        });

        // Service
        $app['sample.service.[サービス名]'] = $app->share(function () use ($app) {
            return new XXXXService($app);
        });

        // メッセージ登録
        $file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
        $app['translator']->addResource('yaml', $file, $app['locale']);

        // 管理画面メニュー追加
        $app['config'] = $app->share($app->extend('config', function ($config) {
            $config['nav'][1]['child'][] = array(
                'id' => 'sample',
                'name' => 'サンプル',
                'url' => 'plugin_Sample_hello',
            );
            $config['nav'][] = array(
                'id' => 'sample2',
                'name' => 'サンプル',
                'has_child' => true,
                'icon' => 'cb-shopping-cart',
                'child' => array(
                    array(
                        'id' => 'sample3',
                        'name' => 'サンプル',
                        'url' => 'plugin_Sample_hello',
                    )
                )
            );

            return $config;
        }));

        // ログファイル設定
        if (!method_exists('Eccube\Application', 'getInstance')) {
            eccube_log_init($app);
        }

        $app['monolog.logger.sample'] = $app->share(function ($app) {
            $config = array(
                'name' => 'sample',
                'filename' => 'sample',
                'delimiter' => '_',
                'dateformat' => 'Y-m-d',
                'log_level' => 'INFO',
                'action_level' => 'ERROR',
                'passthru_level' => 'INFO',
                'max_files' => '90',
                'log_dateformat' => 'Y-m-d H:i:s,u',
                'log_format' => '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]',
            )

            return $app['eccube.monolog.factory']($config);
        });

    }

    public function boot(BaseApplication $app)
    {
    }

}
```
