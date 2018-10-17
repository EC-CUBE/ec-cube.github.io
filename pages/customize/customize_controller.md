---
title: コントローラのカスタマイズ
keywords: core カスタマイズ コントローラ
tags: [core, controller]
sidebar: home_sidebar
permalink: customize_controller
folder: customize
---


---

## 新しいルーティングの追加

`@Route` アノテーションを付与したクラスファイルを `./app/Customize/Controller/` 以下に配置することで、サイトに新しいルーティングを追加することが可能です。  

以下は最もシンプルなルーティング追加の例です。  
`http://サイトURL/samlple` にアクセスすると"Hello sample page !"と表示するルーティングを追加しています。

### Controllerファイル

./app/Customize/Controller/SamplePageController.php

```php
<?php

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SamplePageController
{
    /**
     * @Method("GET")
     * @Route("/sample")
     */
    public function testMethod()
    {
        return new Response('Hello sample page !');
    }
}
```

## テンプレートファイルの利用

`@Template` を利用することで、Twigのテンプレートファイルを利用することができます。  
以下のサンプルは、`http://サイトURL/samlple` にアクセスすると"Hello EC-CUBE !"と表示します。

### Controllerファイル

```php
<?php

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class SamplePageController
{
    /**
     * @Method("GET")
     * @Route("/sample")
     * @Template("Sample/index.twig")
     */
    public function testMethod()
    {
        return ['name' => 'EC-CUBE'];
    }
}
```


### Twigファイル

./app/template/default/Sample/index.twig

```twig

<h3>Hello {{ name }} !</h3>

```

## カスタマイズのヒント

### URLからパラメータを受け取る

`http://サイトURL/samlple/1` のようにURLに含まれるパラメータを変数の値として受け取ることができます。  
@Routeに含まれる `{id}` の部分を同名の変数 `$id` として受け取れます。

```php
    /**
     * @Method("GET")
     * @Route("/sample/{id}")
     */
    public function testMethod($id)
    {
        return new Response('Parameter is '.$id);
    }
```

### 追加したルーティングへのリンクをする

他のページのテンプレートファイルから、追加したルーティングにリンクをするには、ルーティングに名前をつける必要があります。  
@Routeアノテーションに `name` パラメータを追加することで名前をつけることができます。

```php
    /**
     * @Method("GET")
     * @Route("/sample/{id}", name="sample_page")
     */
    public function testMethod($id)
    {
        return new Response('Parameter is '.$id);
    }
```

 他のページのテンプレートファイルからリンクをする場合には、以下のように記述します。  
 パラメータを渡すことも出来ます。

```twig
{% raw %}
<a href="{{ url("sample_page", { id : 2}) }}">Sampleページへのリンク</a>
{% endraw %}
```

### EC-CUBE既存のルーティングを上書きする

EC-CUBE既存のルーティングを上書きするには、同じパスと名前でルーティングを定義します。  
下記のサンプルでは、「当サイトについて」のページを上書きしています。

```php
    /**
     * @Method("GET")
     * @Route("/help/about", name="help_about")
     */
    public function testMethod()
    {
        return new Response('Overwrite /help/about page');
    }
```

### 管理画面のルーティングを追加する

管理画面にログインしているユーザーのみがアクセスできるルーティングを追加する場合には、パスに `/%eccube_admin_route%` を利用します。

```php
    /**
     * @Method("GET")
     * @Route("/%eccube_admin_route%/sample")
     */
    public function testMethod()
    {
        return new Response('admin page');
    }
```

同様にUserDataへのルーティングは `/%eccube_user_data_route%` を指定します。

### リダイレクトを行う

AbstractControllerを継承して `redirectToRoute` 関数を利用することでリダイレクトが可能です。  
下記のサンプルでは、アクセスがあると「当サイトについて」のページへリダイレクトしています。

```php
    /**
     * @Method("GET")
     * @Route("/sample")
     */
    public function testMethod()
    {
        return $this->redirectToRoute('help_about');
    }
```

また `forwardToRoute` 関数を利用することで、リダイレクトではなく他のコントローラに処理を渡すことができます。

### Controller内でサービスを利用する

`AbstractController` を継承することで、よく利用するサービスのインスタンスを利用することができます。  
以下のサンプルでは、EntityManagerを利用して商品のEntityを取得しています。

```php
<?php

namespace Customize\Controller;

use Eccube\Controller\AbstractController;
use Eccube\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SamplePageController extends AbstractController
{
    /**
     * @Method("GET")
     * @Route("/sample")
     */
    public function testMethod()
    {
        /** @var Product $product */
        $product = $this->entityManager->getRepository('Eccube\Entity\Product')->find(1);

        return new Response('Product is '.$product->getName());
    }
}
```

EntityManger以外に、AbstractControllerを継承することで利用できるサービスは `./src/Eccube/Controller/AbstractController.php` を確認してください。  

#### AbstractControllerに無いサービスを利用する

インジェクションを利用することで、AbstractControllerに無いサービスのインスタンスも利用する事ができます。  
以下のサンプルでは、BaseInfoからショップ名を取得しています。

```php
<?php

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class SamplePageController
{
    /** @var \Eccube\Entity\BaseInfo */
    protected $BaseInfo;

    /**
     * SamplePageController constructor.
     * @param \Eccube\Repository\BaseInfoRepository $baseInfoRepository
     */
    public function __construct(\Eccube\Repository\BaseInfoRepository $baseInfoRepository)
    {
        $this->BaseInfo = $baseInfoRepository->get();
    }

    /**
     * @Method("GET")
     * @Route("/sample")
     */
    public function testMethod()
    {
        return new Response('Shop name is '.$this->BaseInfo->getShopName());
    }
}
```

### 画面を表示する必要がないコントローラーを作成する

画面を表示する必要のないコントローラの場合も必ずResponseオブジェクトを返してください。  
(`exit()` で処理を終了するとEC-CUBEが正常な動作を行えなくなります)  

Responseのレスポンスコードやヘッダーを指定することも可能です。

```php
    /**
     * @Method("GET")
     * @Route("/sample")
     */
    public function testMethod()
    {
        return new Response(
          '',
          Response::HTTP_OK,
          array('Content-Type' => 'text/plain; charset=utf-8')
        );
    }
```

```
$ curl -D - http://サイトURL/sample
HTTP/1.1 200 OK
Content-Type: text/plain; charset=utf-8
```

## 参考情報

EC-CUBE 4.0 ではSymfonyのController機構を利用しています。  
その他のカスタマイズ方法についてはSymfonyのドキュメントを参照してください。

https://symfony.com/doc/current/controller.html
