---
title: コアコードカスタマイズ指針
keywords: core カスタマイズ 本体
tags: [core, tutorial]
sidebar: home_sidebar
permalink: customize_policy
summary: src/Eccube等の本体のコアコードのカスタマイズについて解説します。。
folder: customize
---

# {{ page.title }}


ここまで、EC-CUBEのカスタマイズ方法について、本体のソースコードを触らないカスタマイズ方法について解説してきました。
本体のソースコードを直接カスタマイズする場合の指針について解説していきます。

##  方針

- EC-CUBEの最新バージョンへ追随しやすいようにカスタマイズを行う
- 追随は、バージョン管理ツール(git)を利用してマージを行う

## twigテンプレートについて

- テンプレート読み込み順序の仕様を利用し、app/template以下にtwigファイルを配置する
- src/Eccube/Resource/template以下のtwigファイルは変更しない

twigテンプレートは、テンプレート読み込み順序の仕様に記載の通り、
- app/template
- src/Eccube/Resource/template
の順に読み込まれます。

既存のtwigテンプレートを変更する際は、src/Eccube/Resource/template以下のファイルは変更せず、app/template配下にtwigファイルをコピーし、変更するようにします。

## データベースの拡張について

新たな項目が必要な場合、[テーブルの追加](plugin-table)を参考に、プラグイン側でテーブルを作成します。
ただし、外部キーを使う必要がある場合（dtb_productに対してリレーションしたい場合など)、本体側のエンティティを直接編集します。

## 画面の作成、URLについて

新規ページを作成する際、静的ページの場合は、ページ管理機能を利用し、作成します。

ロジックが必要な場合は、[新規ページの追加](plugin-pageadd)を参考に、

- Controllerの作成
- twigテンプレートの作成
- ルーティング定義の追加

を行います。

既存ページのURLの変更や、無効化を行う場合は、[利用しないページの無効化](plugin-pagedelete)を参考に、既存のルーティングに対して設定を行います。

## Formの拡張について

新規フォームを作成する際、[FormTypeの追加](plugin-form)を参考に、FormTypeを追加します。
既存のフォームを拡張する場合、[Form Extensionを利用したForm拡張](plugin-form)を参考に拡張を行います。

## ディレクトリ構成

ここまで説明した内容でのディレクトリ構成は、以下のようなイメージです

| ディレクトリ |          |                   |                   | 役割                                         |
|--------------|----------|-------------------|-------------------|----------------------------------------------|
| app          | template | default           |                   | フロント画面のtwigテンプレートのカスタマイズ |
|              |          | admin             |                   | 管理画面のtwigテンプレートのカスタマイズ     |
|              | Plugin   | Customize(任意)   | Controller        | 新規ページの追加、既存ページの無効化         |
|              |          |                   | Entity            | 新規テーブルの追加                           |
|              |          |                   | Form/Extenstion   | 既存フォームの拡張                           |
|              |          |                   | Form/Type         | 新規フォームの追加                           |
|              |          |                   | Repository        | 新規レポジトリの追加                         |
|              |          |                   | Resource/doctrine | 新規テーブルの追加                           |
|              |          |                   | ServiceProvider   | ルーティング定義や、DIコンテナへの設定       |
| src          | Eccube   | Resource/doctrine |                   | 外部キーが必要な場合に編集                   |
|              |          | Resource/template |                   | 原則触らず、app/template以下で編集           |
|              |          | Entity            |                   | 外部キーが必要な場合に編集                   |


## バージョン管理と最新バージョンへのマージ

ソースコードは、gitを利用してバージョン管理を行います。

以下を参考に、ソースコードのバージョン管理や、マージを行うとよいでしょう。
http://qiita.com/nanasess/items/fe2a93ff64833d87eb19

## vendorの更新

EC-CUBEの変更差分は以下に記載がなされています。
http://ec-cube.github.io/update.html#link8

`composer.json`および`composer.lock`が更新されている場合は、vendor以下に配置されているライブラリも更新する必要があります。

以下のコマンドで更新することができます。

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --no-interaction --optimize-autoloader
```

※`--optimize-autoloader`オプションはパフォーマンスの向上につながるがるため、本番環境では必ずつける必要があります。

### マイグレーションの実行

データベースのマイグレーションは、以下のコマンドで実行できます。

```php app/console migrations:migrate```

参考：[マイグレーションガイド](/migration.html)

## セキュリティFIXが合った場合の対応

EC-CUBEに脆弱性が発見された場合、[脆弱性リスト](http://www.ec-cube.net/info/weakness/)で告知が行われます。
脆弱性の内容や差分の提供が行われるため、告知があればできるかぎり早急な対応が必要です。

## 参考情報

- [EC-CUBE3コードリーディング #5](https://speakerdeck.com/amidaike/ec-cube3kodorideingu-number-5)
- [Git を使って EC-CUBE を簡単アップデート](http://qiita.com/nanasess/items/fe2a93ff64833d87eb19)
