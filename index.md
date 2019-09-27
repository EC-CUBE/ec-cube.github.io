---
layout: default
title: EC-CUBE 4.0 開発ドキュメント・マニュアル
keywords: このサイトについて, QuickStart
tags: [quickstart]
sidebar: home_sidebar
permalink: /
---

# {{page.title}}

現在開発中のEC-CUBE 4.0 の開発ドキュメントサイトです。  
EC-CUBEのインストール方法、開発ガイドラインや要素技術の概念、本体開発やプラグイン開発のチュートリアル、Cookbookなどの情報を提供しています。  
ドキュメントへの追記、記載内容の修正についてはEC-CUBE本体と同様に[GitHub](https://github.com/EC-CUBE/ec-cube.github.io/tree/4.0){:target="_blank"}で受け付けております。

ドキュメント化に向けた情報、実装時参考にしたい情報については、随時[Issue](https://github.com/EC-CUBE/ec-cube/issues/3380){:target="_blank"}を更新しております。

運用者向けには以下のサイトをご覧ください。

+ [EC-CUBE 4管理・運用 マニュアル（株式会社シロハチ様）](https://www.shiro8.net/manual4/v40x/index.html){:target="_blank"}

## Topics

|掲載日|内容|
|---|---|
|2019/09/25|[Dockerを使用したインストール方法](quickstart_install#dockerを使用したインストール)が追加されました。| 
|2019/09/24|EC-CUBE4.0.3で商品別税率設定が適用されない不具合が確認されております。詳しくは、[こちら](workaround-product-tax-rule)をご確認ください。|
|2019/09/05|EC-CUBE4.0.3への[バージョンアップ手順](quickstart_update)と[注意点](quickstart_update_4_0_3)が追加されました。| 
|2019/09/02|[税率設定のページ](spec_tax)が追加されました。| 

## Quick Start

+ [システム要件](quickstart_requirement)
+ [インストール方法](quickstart_install)
+ バージョンアップ
	- [バージョンアップ方法](quickstart_update)
	- [4.0.3での注意点](quickstart_update_4_0_3)
+ [コマンドラインインターフェイス](quickstart_cli)

## 機能仕様

+ [機能一覧](https://www.ec-cube.net/product/functions.php){:target="_blank"}
+ [受注関連](spec_order)
+ [税率設定](spec_tax)

## 本体カスタマイズ
+ [ディレクトリ構成](spec_directory-structure)
+ [Controllerのカスタマイズ](customize_controller)
+ [Entityのカスタマイズ](customize_entity)
+ [Repositoryのカスタマイズ](customize_repository)
+ [FormTypeのカスタマイズ](customize_formtype)
+ [Serviceのカスタマイズ](customize_service)
+ [テンプレートのカスタマイズ](customize_template)
+ [Symfonyの機能を使った拡張](customize_symfony)

## デザインカスタマイズ

+ [フロント画面デザイン参考資料（スタイルガイド）](http://eccube4-styleguide.herokuapp.com/){:target="_blank"}
+ [管理画面デザイン参考資料（デザインガイド）](/pdf/ec-cube4_design-guide180930.pdf)

+ [デザインテンプレートの基礎](design_template)
+ [フォームレイアウトの変更](design_form)
+ [ブロックの利用](design_block)
+ [レイアウト管理の利用](design_layout)
+ [Sassの利用](design_css)
+ [フロント画面テンプレート for Adobe XD](http://downloads.ec-cube.net/manual/documents/eccube4_xd_front_template.zip?argument=2qpV46CP&dmai=a5bf51b05bacc5){:target="_blank"}
+ [管理画面テンプレート for Adobe XD](http://downloads.ec-cube.net/manual/documents/eccube4_xd_admin_template.zip?argument=2qpV46CP&dmai=a5bf51b05bacc5){:target="_blank"}

## プラグインカスタマイズ

+ [プラグイン仕様](plugin_spec)
+ [プラグインのインストール](plugin_install)
+ [プラグインサンプル](plugin_sample)

## 多言語化
+ [多言語化](i18n_multilingualization)
+ [通貨](i18n_currency)
+ [タイムゾーン](i18n_timezone)

## Supporters

EC-CUBEは以下のサポートを受けています。

+ [SAKURA internet](https://www.sakura.ad.jp/){:target="_blank"}  
[![SAKURA internet](/images/3-1-2line-rgb-whiteback.png)](https://www.sakura.ad.jp/){:target="_blank"}  

+ [VAddy](https://vaddy.net/ja/){:target="_blank"}  
[![VAddy](/images/VAddy_logo.png)](https://vaddy.net/ja/){:target="_blank"}
