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
- EC-CUBE本体のコード(app/config/eccube, app/DoctrineMigrations, bin, src, htmlディレクトリ)をカスタマイズしている場合、ファイルが上書きされてしまうため、この手順ではバージョンアップできません。[各バージョンでの変更差分](#各バージョンでの変更差分)を確認して必要な差分を取り込んでください。

## 作業の流れ
1. サイトのバックアップ
2. メンテナンスモードを有効にする
3. 共通ファイル差し替え
4. 個別ファイル差し替え
5. composer.json/composer.lockの更新
6. スキーマ更新/マイグレーション
7. テンプレートファイルの更新
8. メンテナンスモードを無効にする
9. その他

## 手順詳細

### 1. サイトのバックアップ

EC-CUBEのインストールディレクトリ以下をすべてバックアップしてください。

お使いのデータベースも全てバックアップしてください。

### 2.メンテナンスモードを有効にする（バージョン4.0.1以降）

EC-CUBEの管理画面へアクセスし、「コンテンツ管理」の「メンテナンス管理」から、メンテナンスモードを有効にしてください。

または、EC-CUBEのルートディレクトリに「.maintenance」ファイルを設置することでメンテナンスモードを有効にすることもできます。

```
[root]
  │
  ├──.maintenance
  │
```

※ メンテナンスモード使用時は、管理画面以外のページにアクセスするとメンテナンス画面が表示されます。

※ この機能は、EC-CUBEのバージョンが「4.0.1」以上でないと使用できません。

### 3. 共通ファイル差し替え

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

### 4. 個別ファイル差し替え

対象となるバージョンごとに、個別のファイル差し替えが必要です。
  
下記から差し替え対象ファイルを確認して最新のファイルで上書きしてください。

上書き後、以下のコマンドでキャッシュの削除を行ってください。

```
bin/console cache:clear --no-warmup
```

| バージョンアップ対象 | 差し替え対象ファイル                                                                              |
|----------------------|---------------------------------------------------------------------------------------------------|
| 4.0.0 → 4.0.1        | composer.json<br>composer.lock<br>.htaccess<br>index.php<br>maintenance.php

※ 差し替え対象に、composer.json/composer.lockがある場合は 上書き後、`composer.json/composer.lockの更新の手順`を実施してください。

※ `4.0.0 → 4.0.2` のように複数バージョンをまたぐバージョンアップを行う場合は、`4.0.0 → 4.0.1`→`4.0.1 → 4.0.2` のように段階的なバージョンアップを行ってください。

### 5. composer.json/composer.lockの更新

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

### 6. スキーマ更新/マイグレーション

スキーマ更新およびマイグレーション機能を利用して、データベースのバージョンアップを行います。 
 
以下のコマンドを実行してください。

**※ 4.0.0 → 4.0.1 へのアップデートでは、スキーマ更新は必要ありません。**

参考：[プラグインが無効の状態だと Doctrine SchemaTool でエンティティ拡張が認識されない](https://github.com/EC-CUBE/ec-cube/issues/4056)


スキーマ更新

```
bin/console doctrine:schema:update --force --dump-sql
``` 

マイグレーション

```
bin/console doctrine:migrations:migrate
```

### 7. テンプレートファイルの更新

対象となるバージョンごとに、テンプレートファイル(twig)の更新が必要です。  

管理画面のコンテンツ管理から、該当するページ/ブロックを編集してください。  

#### 4.0.0 → 4.0.1

変更対象の差分は、以下リンクからご確認いただくが[各バージョンでの変更差分](#各バージョンでの変更差分)からご確認いただけます。

|ページ名                               |ファイル名|
|--------------------------------------|---------------|
|会員登録(入力ページ)                     |<a href="../documents/updatedoc/4.0.1/Contact_index_twig.htm" target = "_blank">Contact/index.twig</a>|
|会員登録(入力ページ)                     |<a href="../documents/updatedoc/4.0.1/Entry_index_twig.htm" target = "_blank">Entry/index.twig</a>|
|MYページ/会員登録内容変更(入力ページ)     |<a href="../documents/updatedoc/4.0.1/Mypage_change_twig.htm" target = "_blank">Mypage/change.twig</a>|
|MYページ/お届け先追加                   |<a href="../documents/updatedoc/4.0.1/Mypage_delivery_edit_twig.htm" target = "_blank">Mypage/delivery_edit.twig</a>|
|商品購入                               |<a href="../documents/updatedoc/4.0.1/Shopping_index_twig.htm" target = "_blank">Shopping/index.twig</a>|
|非会員購入情報入力                      |<a href="../documents/updatedoc/4.0.1/Shopping_nonmember_twig.htm" target = "_blank">Shopping/nonmember.twig</a>|
|商品購入/お届け先の追加                  |<a href="../documents/updatedoc/4.0.1/Shopping_shipping_edit_twig.htm" target = "_blank">Shopping/shipping_edit.twig</a>|
|商品購入/お届け先の複数指定(お届け先の追加)|<a href="../documents/updatedoc/4.0.1/Shopping_shipping_multiple_edit_twig.htm" target = "_blank">Shopping/shipping_multiple_edit.twig</a>|

### 8.メンテナンスモードを無効にする（バージョン4.0.1以降）

EC-CUBEの管理画面へアクセスし、「コンテンツ管理」の「メンテナンス管理」から、メンテナンスモードを無効にしてください。

または、EC-CUBEのルートディレクトリに「.maintenance」ファイルを削除することでメンテナンスモードを無効にすることもできます。

※ この機能は、EC-CUBEのバージョンが「4.0.1」以上でないと使用できません。

### 9. その他

#### 4.0.0 -> 4.0.1

4.0.1で実装された[メンテナンス機能](https://github.com/EC-CUBE/ec-cube/pull/3998)を利用する場合, .envに以下を記載するか、環境変数として以下の値を定義する必要があります。

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
| 4.0.0 → 4.0.1   | [https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1#files_bucket](https://github.com/EC-CUBE/ec-cube/compare/4.0.0...4.0.1?w=1)   |

