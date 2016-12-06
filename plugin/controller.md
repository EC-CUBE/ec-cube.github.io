---
layout: default
title: コントローラー
---

# {{ page.title }}

プラグインでもコントローラーを作成することで新たな画面を作成することが可能です。作成方法は基本的には本体側と同じです。

### コントローラーのルーティング定義

本体側ではルーティング定義は`FrontControllerProvider`や`AdminControllerProvider`に記述しますが、プラグインでは`ServiceProvider`に定義します。  
記述する内容は本体側と同じ内容となります。

```php
<?php

class XXXXServiceProvider implements ServiceProviderInterface
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
        $admin->match('/[URL]', 'Plugin\[プラグインコード]\Controller\ConfigController::index')->bind('plugin_[プラグインコード]_config');

        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        // フロント画面定義
        $front = $app['controllers_factory'];
        // 強制SSL
        if ($app['config']['force_ssl'] == Constant::ENABLED) {
            $front->requireHttps();
        }

        $front->match('/[URL]', 'Plugin\[プラグインコード]\Controller\XXXX::index')->bind('[プラグインコード]_xxxx');
        $front->match('/[URL]', 'Plugin\[プラグインコード]\Controller\YYYY::index')->bind('[プラグインコード]_yyyy');

        $app->mount('', $front);
```
ルーティングを作成する時の注意点として、

- 管理画面のルーティング定義をする場合、必ず`'/'.$app['config']['admin_route']`を記述
- URLやバインド名は必ずユニーク  
→基本的にURLやバインド名はプラグインコードをつけておけばユニークになります。
- プラグインの設定画面を定義する場合、

プラグインの設定画面を定義する場合、

- ルーティング定義  
$app->match('/plugin/[プラグインコード]/config',

- コントローラー  
Plugin/[プラグインコード]/Controller/ConfigController  

- バインド名  
->bind('plugin_[プラグインコード]_config');

- 設定画面の定義

```
$admin->match('/plugin/[プラグインコード]/config', 'Plugin\[プラグインコード]\Controller\ConfigController::index')->bind('plugin_[プラグインコード]_config');
```

と定義してください。詳しくは[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf){:target="_blank"}の「プラグインの設定画面の作成方法」を参照してください。

### 画面を表示する必要がないコントローラーを作成する場合

プラグインによっては画面を表示する必要がない処理の時でも必ずResponsを返すようにしてください。

- **NG** : 下記のような実装では、`exit`で終了するため、EC-CUBE側に処理が戻りません。

```php
<?php

namespace Plugin\XXXX\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;

class TopController extends AbstractController
{

    public function index(Application $app, Request $request)
    {

        if ($form->isSubmitted() && $form->isValid()) {
            // 処理...
        }

        exit;

    }

}
```

- **OK** ： Responsオブジェクトを生成し必ずResponseをreturnしてください。

```php
<?php

namespace Plugin\XXXX\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TopController extends AbstractController
{

    public function index(Application $app, Request $request)
    {

        if ($form->isSubmitted() && $form->isValid()) {
            // 処理...
        }

        return new Response(
            '返したい文字列(何も返す必要がなければ空文字)',
            Response::HTTP_OK,
            array('Content-Type' => 'text/plain; charset=utf-8')
        );
    }

}
```
