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
4. マイグレーション
5. テンプレートファイルの更新
6. 不要ファイルの削除


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
| 3.0.2 → 3.0.3        | なし                                                                                              |
| 3.0.3 → 3.0.4        | なし                                                                                              |
| 3.0.4 → 3.0.5        | autoload.php                                                                                      |
| 3.0.5 → 3.0.6        | なし                                                                                              |
| 3.0.6 → 3.0.7        | なし                                                                                              |
| 3.0.7 → 3.0.8        | なし                                                                                              |
| 3.0.8 → 3.0.9        | app/console <br> cli-config.php <br> composer.json <br> composer.lock <br> eccube_install.sh      |
| 3.0.9 → 3.0.10       | autoload.php                                                                                      |
| 3.0.10 → 3.0.11      | autoload.php <br> composer.lock <br> composer.json <br> eccube_install.sh <br> web.config.sample <br> .htaccess.sample |
| 3.0.11 → 3.0.12      | composer.json <br> composer.lock <br> eccube_install.php <br> web.config.sample <br> .htaccess.sample |
| 3.0.12 → 3.0.12-p1      | なし |

※ `3.0.8 → 3.0.10` のように複数バージョンをまたぐバージョンアップを行う場合は、`3.0.8 → 3.0.9`→`3.0.9 → 3.0.10` のように段階的なバージョンアップを行ってください。

### 4. マイグレーション
マイグレーション機能を利用して、データベースのバージョンアップを行います。  
  
`http://インストール先/install.php/migration`  
にアクセスするとマイグレーション画面が表示されますので、ページの指示に従ってマイグレーションを行ってください。

### 5. テンプレートファイルの更新
対象となるバージョンごとに、テンプレートファイル(twig)の更新が必要です。  
管理画面のコンテンツ管理から、該当するページ/ブロックを編集してください。  

#### 3.0.10 → 3.0.11

##### twigファイルの更新

| 編集対象                                                         | 変更差分 |
|------------------------------------------------------------------|----------|
| 商品詳細ページ(Product/detail.twig)                              | <a href="../documents/updatedoc/3.0.11/template-diff_Product_detail.twig.html" target = "_blank">差分を表示</a> |
| MYページ/お気に入り一覧(Mypage/favorite.twig)                    | <a href="../documents/updatedoc/3.0.11/template-diff_Mypage_favorite.twig.html" target = "_blank">差分を表示</a> |
  
##### eccube.jsの置き換え

`管理画面>オーナーズストア>テンプレート管理>テンプレート一覧`で、「デフォルト」以外のテンプレートを選択している場合は`eccube.js`の置き換えが必要です。  
  
`html/template/default/js/eccube.js`をコピーして、各テンプレートフォルダの`eccube.js`を置き換えてください。  
  
※テンプレートフォルダは、テンプレート一覧の「保存先」の列に表示してあります。　(例)  html/template/P3001

#### 3.0.11 → 3.0.12

##### twigファイルの更新

| 編集対象                                                         | 変更差分 |
|-----------------------------------------------------------------|----------|
| MYページ/ログイン(Mypage/login.twig)    | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-456fb9674d5c9c2912a57a8334441164" target="_blanl">変更差分を表示</a> |
| 商品詳細ページ(Product/detail.twig)     | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-3e2e5d1f9ba985b3723f5e0e030658fd" target="_blanl">変更差分を表示</a> |
| 商品購入/お届け先の複数指定(Shopping/shipping_multiple.twig)  |  <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-60d2cc7d335953e2b9f32099bed48b59" target="_blanl">変更差分を表示</a> |
| 商品購入ログイン(Shopping/login.twig)   | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-7ec450f2b624e21ef2d1f61793a6745e" target="_blanl">変更差分を表示</a> |

##### その他のファイルの置き換え

`管理画面>オーナーズストア>テンプレート管理>テンプレート一覧`で、「デフォルト」以外のテンプレートを選択している場合は以下のファイルの置き換えが必要です。  

| 対象ファイル                                                   |  配置先   | 変更差分 |
|----------------------------------------------------------------|-----------|----------|
| src/Eccube/Resource/template/default/Form/form_layout.twig | app/template/[テンプレートコード]/Form/form_layout.twig | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-0098ed669424c10911733e643a0646dd" target="_blanl">変更差分を表示</a> |
| src/Eccube/Resource/template/default/pagination.twig       | app/template/[テンプレートコード]/pagination.twig | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-6fef68f38234a15ce2570b56e36bbece" target="_blanl">変更差分を表示</a> |
| html/template/default/css/style.css                        | html/template/[テンプレートコード]/css/style.css | <a href="https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1#diff-5a6358cab0f1c0b89de8257c09313f4a" target="_blanl">変更差分を表示</a> |

※テンプレートフォルダは、テンプレート一覧の「保存先」の列に表示してあります。　(例)  html/template/P3001

### 6. 不要ファイルの削除

アップデート後は以下のファイルを必ず削除してください。

- html/install.php
- html/index_dev.php (開発用途で使用する場合は残す)

EC-CUBEのバージョンアップ手順は以上です。


## 各バージョンでの変更差分

バージョンごとの詳細な変更差分は、以下のリンク先で確認することができます。

| バージョン      | 差分ページ                                                                                                             |
|-----------------|------------------------------------------------------------------------------------------------------------------------|
| 3.0.2 → 3.0.3   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.2...3.0.3](https://github.com/EC-CUBE/ec-cube/compare/3.0.2...3.0.3?w=1)   |
| 3.0.3 → 3.0.4   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.3...3.0.4](https://github.com/EC-CUBE/ec-cube/compare/3.0.3...3.0.4?w=1)  |
| 3.0.4 → 3.0.5   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.4...3.0.5](https://github.com/EC-CUBE/ec-cube/compare/3.0.4...3.0.5?w=1)   |
| 3.0.5 → 3.0.6   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.5...3.0.6](https://github.com/EC-CUBE/ec-cube/compare/3.0.5...3.0.6?w=1)   |
| 3.0.6 → 3.0.7   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.6...3.0.7](https://github.com/EC-CUBE/ec-cube/compare/3.0.6...3.0.7?w=1)   |
| 3.0.7 → 3.0.8   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.7...3.0.8](https://github.com/EC-CUBE/ec-cube/compare/3.0.7...3.0.8?w=1)   |
| 3.0.8 → 3.0.9   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.8...3.0.9](https://github.com/EC-CUBE/ec-cube/compare/3.0.8...3.0.9?w=1)   |
| 3.0.9 → 3.0.10  | [https://github.com/EC-CUBE/ec-cube/compare/3.0.9...3.0.10](https://github.com/EC-CUBE/ec-cube/compare/3.0.9...3.0.10?w=1) |
| 3.0.10 → 3.0.11 | [https://github.com/EC-CUBE/ec-cube/compare/3.0.10...3.0.11](https://github.com/EC-CUBE/ec-cube/compare/3.0.10...3.0.11?w=1) |
| 3.0.11 → 3.0.12 | [https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12](https://github.com/EC-CUBE/ec-cube/compare/3.0.11...3.0.12?w=1) |
| 3.0.12 → 3.0.12-p1 | [https://github.com/EC-CUBE/ec-cube/compare/3.0.12...3.0.12-p1](https://github.com/EC-CUBE/ec-cube/compare/3.0.12...3.0.12-p1?w=1) |
