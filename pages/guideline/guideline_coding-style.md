---
title: コーディング規約
keywords: コーディング規約 
tags: [collaboration, guideline]
sidebar: home_sidebar
permalink: guideline_coding-style
summary: EC-CUBE 3系のコーディング規約について
folder: guideline
---

## 標準規約

以下の規約に準じる

* PSR-0 - オートローディング規約
* PSR-1 - 基本コーディング規約
* PSR-2 - コーディングスタイルガイド
* [Silexの作法](http://silex-users-jp.phper.jp/){:target="_blank"}
* [Symfony2の作法](http://docs.symfony.gr.jp/symfony2/){:target="_blank"}に従う
* twigテンプレート及びjsファイルのインデントは、Symfony2に合わせて4スペースで記述する

## EC-CUBEの独自規約

### 命名規則

* URL：末尾に `/` をつけない
  + `https://example.com`
  + `https://example.com/product`
  + `https://example.com/product/new`
  + `https://example.com/product/2/edit`
    - newの場合、内部的には同じControllerを利用し、引数のデフォルト値をnullで適用して対応
    - editで引数が指定されていない場合は、Exception(BadRequest)を投げる
    - editで引数が指定されているが、存在しない場合は、Exception(NotFound)を投げる
  + 以下は[こちらの理由](https://github.com/EC-CUBE/ec-cube/issues/181){:target="_blank"}から例外とする
    - `https://example.com/mypage/`
    - `https://example.com/admin/`

* ControllerProviderのRouting定義
  + RequestMethodを限定したいときは`match()`ではなく適切なRequestMethodを指定する
    ex: getでのアクセスを許容したくない場合は`post()`を利用する、など

* ディレクト名、ファイル名
  + ディレクトリ名は単数形とする
    - ただし、`data`は例外として許容する
  + `DirName`
    - ただし以下は例外とする
    　　`RootDir`の`src`や`app`
  + `ControllerClassName.php`
  + `FormNameType.php`
  + `EntityName.php` `Master/EntityName.php`  : `EntityName`はdtbやmtbを除いたテーブル名のUpperCamel

* テンプレートファイル
  + `TemplateDir/template_name.twig`

* PHPソース内
  + [Symfonyコーディング規約](http://symfony.com/doc/current/contributing/code/standards.html){:target="_blank"}に従う
  + EC-CUBEの独自規約として、以下を定める
    + entity変数をアッパーキャメルとする
    + twigのスカラ値のアクセスは、スネークケースとする
  + コード例

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/coding_style/HogeController.php"></script>

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/coding_style/hoge.twig"></script>

* データベース
  + https://github.com/EC-CUBE/ec-cube/issues/210 に従う

* セミコロンの位置

```php
$builder
　　->add('name')
　　->add('age'); // ココ
```

```php
$array = array(
　　'name' => 'shinichi',
　　'age' => '26',
); // ココ
```

* 名前空間の`\`をつかうとこ、つかわないとこ
    + つかうとこ
        - useしてない名前空間を利用するとき
        - PHP標準のClassを利用するとき `new \Datetime()`
    + つかわないとこ
        - `use Namespace`
        - `Eccube\Entity\Xxx` を利用するところ
          ex: `$app['orm.em']->getRepository('Eccube\Entity\Xxx');`

* TwigからRouting定義されたURLを取得する際は、` url('route_name')  ` をつかう
  + HTTPSを確実にコントロールするため

* `form_errors`の表示位置
  * 入力欄の下にエラーを表示する

```
    form_widget(form.name)
    form_errors(form.name)
```

  + key名は、意味の伝わる英語の文章となるようにすること
    ex: `File copying failed.`

* FlashMessage
  + フロント・管理画面それぞれでnamespaceを切り替えて使用する
    (第2引数で指定/デフォルトはfront)
  + 以下の４つ(errorとdangerは同等)のレベルに応じたフラッシュメッセージを適切に表示すること
      - `$app->addSuccess('It works!');` // front.success
      - `$app->addInfo('You got a new message!');` // front.info
      - `$app->addWarning('Check your mail address');` // front.warning
      - `$app->addDanger('Error occured!!', 'admin');` // admin.danger
      - `$app->addError('Can't delete this section', 'admin');` // admin.error

## どこに何かくか

EC-CUBEのソースはすべて`src/Eccube`以下にある。

| どこ | なに | 2.13のなに |
|------|------|------|
| ControllerProvider | Routingの定義。リクエストをControllerにわたす | html/以下の各ページの毎のphp |
| Controller | リクエストを受けて、処理を各所に委譲。Viewを返す | LC_Page_Xxx |
| Service | ビジネスロジックを記述。if文とかfor文とかはこの中にかくことになりがち | SC_Xxx |
| ServiceProvider | DIコンテナにつっこむものたち。Form\TypeとかRepositoryとかをここで格納する | SC_InitialとかRequire_base的なもの |
| Resource/doctrine | doctrineの定義ファイル置き場。YAMLでかく | (なし) |
| Entity | DoctrineによってマッピングされるObject。こいつをコネコネする | (なし) |
| Repository | Entityをコネコネする郡。`findBy()`とかはこの中に | SC_Query |
| Form/Type | Formを構成するパーツをかく。Validatorもいっしょに | SC_FormParam |
| View | びゅー。Twigでかく | Xxx.tpl |


## ControllerをFatにしないために
Controllerでは以下に挙げる振る舞い以外を許容しない
* Requestを受ける
* FormにRequestをBindする
* Repositoryに処理を委譲する
* Serviceに処理を委譲する
* データを変換する
* ViewをRenderする


以下で規定したものをそれぞれ適した場所に記述することにより、FatControllerになることを避ける

### Controller
* 新規登録と編集で異なるEntityを取得する際は、Controllerでわかるように明示する

### Repository
* QueryBuilderを使った複雑なクエリを実行したい場合
* `findByXxx()`は利用しないこと
* `findByXxx()`を作成しないこと

### FormType
* FormEvent / FormExtensionを使った拡張
* DataTransformerを使った変換

### Service
* ビジネスロジックの実装

## テストの書き方
* Web、Service、Repository、FormTypeのテストを必須とする
* WebTestは、`AbstractWebTestCase.php` を継承して作成する
* RequestMethodが指定されたテストの場合は、それ以外が失敗することを確認する
