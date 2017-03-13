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
| 3.0.12-p1 → 3.0.13  	 | app/console <br> composer.json <br> composer.lock <br> eccube_install.php |
| 3.0.13 → 3.0.14  	 | app/console <br> composer.json <br> composer.lock <br> eccube_install.sh |

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



### 7. 税率設定の不具合について

EC-CUBE3.0.12からEC-CUBE3.0.13までのバージョンで、税率設定の課税規則に「切り捨て」「切り上げ」を設定されていた方は、共通税率設定により必ず「四捨五入」または「切り上げ」されるという不具合が発生しています。

こちらの不具合はEC-CUBE3.0.14で修正されています。

#### 影響があるEC-CUBEバージョン
3.0.12、3.0.12-p1、3.0.13


#### 対象者
上記のEC-CUBEのバージョンをお使いの方で、税率設定の課税規則を変更されている方。


#### 不具合発生機能箇所
- 商品購入時、管理画面の受注データ登録・更新時  
確認画面以降（メール、受注データも含む）において、価格の（端数）税率計算が全て四捨五入で計算される。


#### 現象内容
課税規則に「切り捨て」、消費税率を8%と設定していた場合、
商品A : 649円
という商品を購入すると701円として購入されてしまう。

例えば、
649 * 1.08 = 700.92円となり切り捨てであれば700円だが、
四捨五入されて701円になる。

商品一覧、商品詳細、カート画面では700円として表示されているが、
購入画面では701円で計算され、購入金額も701円で購入される。

#### 原因
[https://github.com/EC-CUBE/ec-cube/issues/2005](https://github.com/EC-CUBE/ec-cube/issues/2005)


#### 対応方法
本体の税率設定と異なる金額の受注明細データを抽出するプラグインが用意されています。

[税率設定確認プラグイン](http://downloads.ec-cube.net/plugin/tax-rule-problem/TaxRuleProblem-CheckerPlugin-1.0.0.tar.gz)


このプラグインは抽出のみ行っていますので、
誤りのある受注データを修正する場合、手動にて修正を行うようにしてください。


#### バージョンアップが出来ないとき

EC-CUBE3.0.12、EC-CUBE3.0.12-p1、EC-CUBE3.0.13のそれぞれのバッチファイルを用意しています。

[パッチファイル](http://downloads.ec-cube.net/plugin/tax-rule-problem/taxrule-patch.zip)

解凍後、それぞれお使いのバージョンに合わせて下記の比較内容を元に修正をお願い致します。

- EC-CUBE3.0.12、EC-CUBE3.0.12-p1  
src/Eccube/Controller/Admin/Order/EditController.php  
![課税規則](/images/img-tax3.0.12-controller.png)  
src/Eccube/Service/ShoppingService.php  
![課税規則](/images/img-tax3.0.12-service.png)

- EC-CUBE3.0.13  
src/Eccube/Service/ShoppingService.php  
![課税規則](/images/img-tax3.0.13-service.png)


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
| 3.0.12-p1 → 3.0.13 | [https://github.com/EC-CUBE/ec-cube/compare/3.0.12-p1...3.0.13](https://github.com/EC-CUBE/ec-cube/compare/3.0.12-p1...3.0.13?w=1) |
| 3.0.13 → 3.0.14 | [https://github.com/EC-CUBE/ec-cube/compare/3.0.13...3.0.14](https://github.com/EC-CUBE/ec-cube/compare/3.0.13...3.0.14?w=1) |
