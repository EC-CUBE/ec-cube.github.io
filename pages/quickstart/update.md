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
- EC-CUBE本体のコード(src,htmlディレクトリ)をカスタマイズしている場合、ファイルが上書きされてしまうため、この手順ではバージョンアップできません。[各バージョンでの変更差分](#link13)を確認して必要な差分を取り込んでください。

## 作業の流れ
1. サイトのバックアップ
2. 共通ファイル差し替え
3. 個別ファイル差し替え
4. composer.json/composer.lockの更新
5. マイグレーション
6. テンプレートファイルの更新

## 手順詳細

### 1. サイトのバックアップ

EC-CUBEのインストールディレクトリ以下をすべてバックアップしてください。

### 2. 共通ファイル差し替え

`src` `html` `vendor`ディレクトリを最新のファイルですべて上書きしてください。  

```
[root]
  │
  ├──[src]
  ├──[html]
  ├──[vendor]
  │
```

### 3. 個別ファイル差し替え

対象となるバージョンごとに、個別のファイル差し替えが必要です。  
下記から差し替え対象ファイルを確認して最新のファイルで上書きしてください。

| バージョンアップ対象 | 差し替え対象ファイル                                                                              |
|----------------------|---------------------------------------------------------------------------------------------------|
| 4.0.0 → 4.0.1        | .htaccess<br>app/DoctrineMigrations/Version20181017090225.php<br>app/DoctrineMigrations/Version20181109101907.php<br>app/config/eccube/bundles.php<br>app/config/eccube/packages/doctrine_migrations.yaml<br>app/config/eccube/services.yaml

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

packagist等の外部ライブラリを独自にインストール場合は、再度requireしてください。
例えば、psr/http-messageをインストールしている場合は、以下のコマンドを実行してください。

```
composer require psr/http-message
```

### 5. マイグレーション

マイグレーション機能を利用して、データベースのバージョンアップを行います。 
 
以下のコマンドを実行してください。

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


EC-CUBEのバージョンアップ手順は以上です。

## 各バージョンでの変更差分

バージョンごとの詳細な変更差分は、以下のリンク先で確認することができます。

| バージョン      | 差分ページ                                                                                                             |
|-----------------|------------------------------------------------------------------------------------------------------------------------|
| 4.0.0 → 4.0.1   | [https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1](https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1?w=1)   |

