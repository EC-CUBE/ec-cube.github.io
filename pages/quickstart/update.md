---
title: EC-CUBE本体のバージョンアップ
keywords: howto update
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_update
summary : EC-CUBE本体のバージョンアップ手順について記載します。  
---


## ご注意
- 本番環境でバージョンアップを行う前に、テスト環境で事前検証を必ず行ってください。
- この手順では、ec-cube.netからダウンロードしたEC-CUBEのパッケージを利用していることを想定しています。
- EC-CUBE本体のコード(app/config/eccube, app/DoctrineMigrations, bin, src, htmlディレクトリ)をカスタマイズしている場合、ファイルが上書きされてしまうため、この手順ではバージョンアップできません。[各バージョンでの変更差分](#link13)を確認して必要な差分を取り込んでください。

## 作業の流れ
1. サイトのバックアップ
2. 共通ファイル差し替え
3. 個別ファイル差し替え
4. composer.json/composer.lockの更新
5. スキーマ更新/マイグレーション
6. テンプレートファイルの更新

## 手順詳細

### 1. サイトのバックアップ

EC-CUBEのデータベースとインストールディレクトリ以下をすべてバックアップしてください。

### 2. 共通ファイル差し替え

`app/config/eccube` `app/DoctrineMigrations` `bin` `src` `html` `vendor`ディレクトリを最新のファイルですべて上書きしてください。  

```
[root]
  │
  ├──[app/config/eccube]  
  ├──[app/DoctrineMigrations]
  ├──[bin]
  ├──[src]
  ├──[html]
  ├──[vendor]
  │
```

### 3. 個別ファイル差し替え

対象となるバージョンごとに、個別のファイル差し替えが必要です。  
下記から差し替え対象ファイルを確認して最新のファイルで上書きしてください。
上書き後、以下のコマンドでキャッシュの削除を行ってください。

```
bin/console cache:clear --no-warmup
```

| バージョンアップ対象 | 差し替え対象ファイル                                                                              |
|----------------------|---------------------------------------------------------------------------------------------------|
| 4.0.0 → 4.0.1        | .htaccess<br>index.php

※ 差し替え対象に、composer.json/composer.lockがある場合は 上書き後、`composer.json/composer.lockの更新の手順`を実施してください。
※ `4.0.0 → 4.0.2` のように複数バージョンをまたぐバージョンアップを行う場合は、`4.0.0 → 4.0.1`→`4.0.1 → 4.0.2` のように段階的なバージョンアップを行ってください。

### 4. composer.json/composer.lockの更新

この手順は、以下の条件をすべて満たす場合に必要です。そうでなければスキップしてください。

- `個別ファイル差し替え`の差し替え対象に、composer.json/composer.lockが含まれている
- プラグインをインストールしている

以下のコマンドを実行してください。

```
bin/console eccube:composer:require-already-installed
```

packagist等の外部ライブラリを独自にインストールしている場合は、再度requireしてください。
例えば、psr/http-messageをインストールしている場合は、以下のコマンドを実行してください。

```
composer require psr/http-message
```

### 5. スキーマ更新/マイグレーション

スキーマ更新およびマイグレーション機能を利用して、データベースのバージョンアップを行います。

以下のコマンドを実行してください。

スキーマ更新

```
bin/console doctrine:schema:update --force --dump-sql
```

マイグレーション

```
bin/console doctrine:migrations:migrate
```

### 6. テンプレートファイルの更新

対象となるバージョンごとに、テンプレートファイル(twig)の更新が必要です。  
管理画面のコンテンツ管理から、該当するページ/ブロックを編集してください。  

- 4.0.0 -> 4.0.1
  - Contact/index.twig
  - Entry/index.twig
  - Mypage/change.twig
  - Mypage/delivery_edit.twig
  - Shopping/index.twig
  - Shopping/nonmember.twig
  - Shopping/shipping_edit.twig
  - Shopping/shipping_multiple_edit.twig

### 7. その他

#### 4.0.0 -> 4.0.1

環境変数に以下を記載する必要があります。

```
ECCUBE_LOCALE=ja
ECCUBE_ADMIN_ROUTE=admin
ECCUBE_TEMPLATE_CODE=default

※設定値は記載例です。環境にあわせて変更してください。
```


EC-CUBEのバージョンアップ手順は以上です。

## 各バージョンでの変更差分

バージョンごとの詳細な変更差分は、以下のリンク先で確認することができます。

| バージョン      | 差分ページ                                                                                                             |
|-----------------|------------------------------------------------------------------------------------------------------------------------|
| 4.0.0 → 4.0.1   | [https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1](https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1?w=1)   |

