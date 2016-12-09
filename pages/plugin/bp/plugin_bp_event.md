---
title: イベント
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_event
---

プラグインを作成する時に理解する内容の一つにイベントがあります。

このイベントはSymfony2のイベントと同義の意味なのですが、EC-CUBE3ではSymfony2のイベントをラップしたフックポイントというものを3.0.9から用意しています。


### イベント定義

プラグインでイベントを利用する場合、`config.yml`と`event.yml`に定義する必要があります。

- `config.yml`にイベントクラスを定義

```
event:
    - XXXXEvent
```

- `event.yml`にイベントを定義

```
eccube.event.app.request:
  - [onAppRequest, NORMAL]

eccube.event.route.homepage.controller:
  - [onRouteHomepageController, NORMAL]

front.cart.index.initialize:
    - [onFrontCartIndexInitialize, NORMAL]

Shopping/index.twig:
    - [onShoppingIndexRender, NORMAL]
```

イベントクラス、event.ymlは下記に配置します。

```
[プラグインコード]
  ├── XXXXEvent.php
  └── event.yml
```

イベントクラスには、event.ymlに定義したイベント名の関数を記述します。


```php
<?php

namespace Plugin\XXXX;

use Eccube\Application;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class XXXXEvent
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onAppRequest(GetResponseEvent $event)
    {

    }

    public function onRouteHomepageController(FilterControllerEvent $event)
    {

    }

    public function onFrontCartIndexInitialize(EventArgs $event)
    {

    }

    public function onShoppingIndexRender(TemplateEvent $event)
    {

    }

}
```

### イベント関数名について
定義しているイベントと極力同じ名前になるように関数名をつけることを推奨しています。

- contorollerイベントの場合  
onRouteXXXXController

- テンプレートイベントの場合  
onXxxxxIndexRenderやonXxxxxCompleteRender

- フックポイントイベントの場合  
onXxxxxInitializeやonXxxxxComplete

### 本体のバージョンチェック

本体のバージョンによりサポートするイベントが異なります。その場合、EC-CUBEのバージョンチェックを行い、イベントを2回実行させないようにします。

- `event.yml`にイベントを定義

```
Shopping/index.twig:
    - [onShoppingIndexRender, NORMAL]

eccube.event.render.product_detail.before:
    - [onRenderProductDetailBefore, NORMAL]
```

- イベントクラス

```php
<?php

namespace Plugin\XXXX;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Event\TemplateEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class XXXXEvent
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onShoppingIndexRender(TemplateEvent $event)
    {

    }

    public function onRenderProductDetailBefore(FilterResponseEvent $event)
    {
        if ($this->isSupportVersion() {
            return;
        }

        // add code
    }

    /**
     * 本体のバージョンチェック
     * 指定されたバージョン以上かチェック
     *
     * @param string $version
     * @return mixed
     */
    private function isSupportVersion($version = '3.0.9')
    {
        return version_compare(Constant::VERSION, $version, '>=');
    }
}
```

※バージョン毎にサポートする必要がなければバージョンチェックは不要です。



### イベントの肥大化を防ぐ

設定するイベントが増えると当然イベントクラスの中身が肥大化してきます。その場合、イベント毎にクラスを分割して管理する方法をお勧めします。

- イベント用クラスを作成

```
[プラグインコード]
  ├── Event
  │   ├── XXXXEvent.php
  │   └── YYYYEvent.php
````


- ServiceProviderにイベントクラスを定義

```php
// Event
$app['[プラグインコード].event.xxxx'] = $app->share(function () use ($app) {
    return new XXXXEvent($app);
});

$app['[プラグインコード].event.yyyy'] = $app->share(function () use ($app) {
    return new YYYYEvent($app);
});
```

- Eventクラスの作成

```php
<?php

namespace Plugin\XXXX;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Event\TemplateEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class XXXXEvent
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onShoppingIndexRender(TemplateEvent $event)
    {
        $this->app['xxxx.event.xxxx']->onShoppingIndexRender($event);

    }

    public function onRenderProductDetailBefore(FilterResponseEvent $event)
    {
        if ($this->isSupportVersion() {
            return;
        }

        $this->app['xxxx.event.yyyy']->onRenderProductDetailBefore($event);
    }

    /**
     * 本体のバージョンチェック
     * 指定されたバージョン以上かチェック
     *
     * @param string $version
     * @return mixed
     */
    private function isSupportVersion($version = '3.0.9')
    {
        return version_compare(Constant::VERSION, $version, '>=');
    }
}
```


- XXXXEvent

```php
<?php

namespace Plugin\XXXX\Event;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Event\TemplateEvent;

class XXXXEvent
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onShoppingIndexRender(TemplateEvent $event)
    {
        // add code
    }
}
```


- YYYYEvent

```php
<?php

namespace Plugin\XXXX\Event;

use Eccube\Application;
use Eccube\Common\Constant;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class YYYYEvent
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onRenderProductDetailBefore(FilterResponseEvent $event)
    {
        // add code
    }
}
```

作成するイベントクラスは業務に応じて分割してください。
