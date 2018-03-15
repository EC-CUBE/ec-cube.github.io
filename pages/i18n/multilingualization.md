---
title: 多言語化
keywords: multilingualization
tags: [i18n, multilingualization]
sidebar: home_sidebar
permalink: i18n_multilingualization
forder: i18n
---

# 概要

初期設定では日本語で表示されますが、英語やその他の言語で表示するための機構が組み込まれています。表示言語は、環境変数でロケールを指定することで切り替えられ、現時点では日本語または英語が利用できます。

# 言語の切り替え

環境変数でロケールを指定し、言語表示を切り替えることが出来ます。

EC-CUBEのルートディレクトリ直下に、`.env`ファイルを作成し、`ECCUBE_LOCALE`を設定します。

```bash
//.env

ECCUBE_LOCALE=en

```

環境変数設定後、画面をリロードすると、表示言語が切り替わります。
キャッシュの削除を行う必要はありません。

※ 現時点では、データベースに保持されているデータは翻訳されません。
※ ショップ画面/管理画面ともに表示言語が切り替わります。

# メッセージファイル(翻訳ファイル)

メッセージファイルは、`src/Eccube/Resouce/locale`以下に保存されています。
`ECCUBE_LOCALE`の値に応じて、

- messages.xxx.php
- validators.xxx.php

のファイルが読み込まれます。

メッセージファイルは単純な連想配列で定義されたphpファイルです。
連想配列のキーはメッセージのID、値は翻訳された文字列を表します。

```php
// messages.ja.php

<?php

return [

    //common
    'common.label.add' => '新規作成',
    'common.label.edit' => '編集',
    'common.label.delete' => '削除',
    'common.label.save' => '登録',
    ...
```

# trans関数とtransフィルタ

trans関数やtransフィルタを使用することで、翻訳された文字列を表示することができます。
php内で翻訳する場合はtrans関数を、twig内で翻訳する場合はtransフィルタを使用します。

## trans関数

trans関数にメッセージIDを指定することで、翻訳された文字列を取得できます。
基本的な使い方は以下のとおりです。

```php
<?php

// 'common.label.add' => '新規作成',

$message = trans('common.label.edit');
var_dump($message);

// 編集
```

メッセージがパラメータ付きで定義されている場合は、以下のように使用します。

```php
<?php

// 'admin.order.index.paginator_total_count' => '検索結果：%count%件が該当しました',

$message = trans('admin.order.index.paginator_total_count', ['%count%' => 10]);
var_dump($message);

// 検索結果：10件が該当しました

```

## transフィルタ

twig内で翻訳する場合は、transフィルタを使用します。
基本的な使い方は以下の通りです。

```twig

{{ 'common.label.add'|trans }}

{# 編集 #}

```

メッセージがパラメータ付きで定義されている場合は、以下のように使用します。

```twig

{{ 'admin.order.index.paginator_total_count'|trans({
    '' : 10
}) }}

{# 検索結果：10件が該当しました #}

```

# 参考

EC-CUBEの翻訳機構は、SymfonyのTranslationコンポーネントを利用しています。
より詳しく知りたい場合は、Symfonyの公式ドキュメントを参照してみてください。

Translations
http://symfony.com/doc/current/translation.html