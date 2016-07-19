---
layout: default
title: 新規ページの追加
---

# {{ page.title }}

ページを新たに作成する際の手順について、解説します。
プラグインジェネレータで、プラグインコードを「Customize」で作成したものとして、解説していきます。
プラグインジェネレータの利用方法については、[こちら](plugin-generate)を参照してください。

## Controllerの作成

app/Plugin/Customize/Contoroller配下に、Controllerを作成します。
ファイル名は、`SampleController.php`としてください

```php
<?php

namespace Plugin\Customize\Controller;

use Eccube\Application;
use Symfony\Component\HttpFoundation\Request;

class SampleController
{
    public function index(Application $app, Request $request)
    {
        return $app->render('Customize/Resource/template/sample.twig', array());
    }
}
```

## twigテンプレートの作成

`app/Plugin/Customize/Resource/template`配下に、twigテンプレートを作成します。
ファイル名は、`sample.twig`としてください。

```
{% extends 'default_frame.twig' %}

{% set body_class = 'Customize_sample_page' %}

{% block main %}
    <div class="row">
        <div class="col-md-12">
            <p class="text-danger">こんにちわ</p>
        </div>
    </div>
{% endblock %}
```

## ServiceProviderでルーティングを定義する

`app/Plugin/Customize/ServiceProvider/CustomizeServiceProvider`に、ルーティングを定義します。
registerメソッド内に、以下のように記載をしてください。


```php
class CustomizeServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // コントローラ：サンプルページ
        $app->match('/customize/sample', 'Plugin\Customize\Controller\SampleController::index')->bind('customize_sample');
```

一度画面を確認します。

`http://[EC-CUBEインストール先]/customize/sample`にアクセスします。

![新規ページの追加](/images/guideline/plugin-pageadd-01.png) 
上のように表示されていれば成功です。

## dtb_page_layoutへのデータ登録

ヘッダー・フッターなど、ブロックが表示されていませんので、ページレイアウトにページ情報を登録します。

データベースに接続し、`dtb_page_layout`テーブルにデータを登録します。
以下のINSERT文を実行してください。

```sql
INSERT INTO dtb_page_layout(
device_type_id,
page_name,
url,
edit_flg,
create_date,
update_date
) VALUES (
10,
'サンプルページ',
'customize_sample',
2,
CURRENT_TIMESTAMP,
CURRENT_TIMESTAMP
);
```

データ登録後、再度画面にアクセスし、以下のように表示されれば成功です。
![新規ページの追加](/images/guideline/plugin-pageadd-02.png) 
