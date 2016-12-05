---
layout: default
title: EC-CUBE開発ドキュメント
keywords: このサイトについて, QuickStart
tags: [quickstart]
sidebar: home_sidebar
permalink: /
---

# {{page.title}}

 EC-CUBEのドキュメントサイトです。  
 開発ガイドラインや要素技術の概念、本体開発やプラグイン開発のチュートリアル、Cookbookなどの情報を提供しています。  
 ドキュメントへの追記、記載内容の修正についてはEC-CUBE本体と同様に[GitHub](https://github.com/EC-CUBE/ec-cube.github.io/){:target="_blank"
}で受け付けております。

## Quick Start

+ [システム要件](/quickstart_requirement)
+ [インストール方法](/quickstart_install)
+ [urlからhtmlを無くす手順](/quickstart_remove-html)
+ [バージョンアップ方法](/quickstart_update)


## 本体の仕様

+ [ディレクトリ構成](/spec_directory-stracture)
+ 設定ファイル
	- [設定ファイルの概要](/spec_config)
	- [doctrine_cacheの設定](/spec_doctrine-cache)
	- [セッションハンドラの設定](/spec_session-handler)
+ 機能仕様
	- [複数配送](/spec_multi-shipping)
	- [税率設定](/spec_tax)
+ [パフォーマンス](/spec_performance)
+ [実験的実装](/spec_experimental)
+ [機能一覧](https://github.com/EC-CUBE/eccube3-doc/blob/master/feature_list.xls){:target="_blank"}
+ [テーブル・ER図](https://github.com/EC-CUBE/eccube3-doc/tree/master/ER-D){:target="_blank"}
+ [結合試験項目書](https://github.com/EC-CUBE/eccube3-doc/tree/master/IntegrationTest){:target="_blank"}

## Web API仕様

+ [Web API β版 プラグインスタートアップガイド](/api_startup-guide)
+ [Web API 開発指針](/api_policy)
+ [Web API認証(Authorization)ガイド](/api_authorization)

## 開発共通ガイドライン

+ [開発環境の構築](/guideline_development)
+ [コーディング規約](/guideline_coding-style)
+ [ログ出力設定](/guideline_log)
+ [開発の補助:デバッグ・Tips](/guideline_tips)
+ [EC-CUBE 3の利用技術](/guideline_architecture)


## デザインカスタマイズ

+ [デザインテンプレートの基礎](/design_template)
+ [デザインのフレーム構成](/design_default-frame)
+ [フォームレイアウトの変更](/design_form)
+ [ブロックの利用](/design_block)
+ [例:GoogleAnalyticsタグの設置](/design_analyticsbloc)

## プラグインカスタマイズ

+ [プラグインの導入方法](/plugin_install)
+ [プラグイン導入時のトラブルシューティング](/plugin_troubleshooting)
+ [プラグイン機構の仕様]
	- [プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf){:target="_blank"}
	- [インストーラーの仕様](/plugin_installer)
	- [ハンドラによる優先順位の制御仕様](/plugin_handler)
	- [プラグイン開発用コンソールコマンド](/plugin_console)
	- [CIを利用したプラグインのテスト](/plugin_test)
	- [EC-CUBE 3.0.11 の変更と影響](/plugin_update-for3011)
+ プラグインの開発方法
	- [プラグインジェネレータの利用方法](/plugin_tutorial-generate)
	- [新規ページの追加](/plugin_tutorial-pageadd)
	- [利用しないページの削除](/plugin_tutorial-pagedelete)
	- [フォームの追加、変更](/plugin_tutorial-form)
	- [プラグイン用テーブルの追加](/plugin_tutorial-table)
	- [チュートリアル](/plugin_tutorial)
+ [オーナーズストアへの公開](http://www.ec-cube.net/plugin/){:target="_blank"}

## コアコードのカスタマイズ

+ [カスタマイズ指針](/customize_policy)
+ [例:会員管理へ項目の追加](/customize_example-adminadd)

## 本体開発に参加する

+ [開発作業全体概要](/collaboration_workflow)
+ [Gitを用いた開発手順](/collaboration_githubflow)
+ [マイグレーションガイド](/collaboration_migration)
+ [外部Componentの利用](/collaboration_component)

## Supporters

+ [JetBrains](https://www.jetbrains.com/)  
[![JetBrains](/images/logo_JetBrains_4.png)](https://www.jetbrains.com/){:target="_blank"}  
EC-CUBEは JetBrains のサポートを受けています。