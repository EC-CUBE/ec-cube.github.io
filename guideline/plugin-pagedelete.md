---
layout: default
title: 利用しないページの無効化
---

# {{ page.title }}

EC-CUBE本体で定義されているページを、利用しない場合もあるかと思います。
その場合は、利用できないようにしておくほうが安全です。
ここでは、利用しないページで404エラーを返す手順について解説します。

プラグインジェネレータで、プラグインコードを「Customize」で作成したものとして、解説していきます。
プラグインジェネレータの利用方法については、[こちら](plugin-generate)を参照してください。

## Controllerの作成

app/Plugin/Customize/Contoroller配下に、Controllerを作成します。
ファイル名は、`NotFoundController.php`としてください。

```php
<?php

namespace Plugin\Customize\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundController
{
    public function index(Application $app, Request $request)
    {
        // 常にNotFoundHttpExceptionをthrowする.
        throw new NotFoundHttpException();
    }
}
```

## ServiceProviderでルーティングを定義する

`app/Plugin/Customize/ServiceProvider/CustomizeServiceProvider`に、ルーティングを定義します。
例えば、お問い合わせページを無効化したい場合、registerメソッド内に、以下のように記載をしてください。

```php
class CustomizeServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // お問い合わせページの削除
        $app->match('/contact', 'Plugin\Customize\Controller\NotFoundController::index')->bind('contact');
```

`http://[EC-CUBEインストール先]/contact`にアクセスし、`ページがありません`のエラー画面が表示されれば成功です。

## ルーティングの確認方法

EC-CUBE本体で定義されているルーティング/URLを確認する場合は、`router:debug`コマンドで確認できます。
詳しくは[router:debugの使い方](/tips.html#link12)を参考にしてください。
