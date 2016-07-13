---
layout: default
title: ホーム
description: EC-CUBEのドキュメントサイトです。開発ガイドラインや要素技術の概念、本体開発やプラグイン開発のチュートリアル、Cookbookなどの情報を提供しています。
---

---

# EC-CUBE 3 開発ドキュメント

## GitHub

- <a href="https://github.com/EC-CUBE/ec-cube" target="_blank">EC-CUBE 3 開発レポジトリ</a>
- <a href="https://github.com/EC-CUBE/ec-cube.github.io" target="_blank">EC-CUBE 3 開発ドキュメントレポジトリ</a>

## Quick Start

- [システム要件](/requirement.html)
- [開発環境の構築](development-environment.html)
- [インストール方法](/install.html)
- [アップデート方法](/update.html)

## EC-CUBE 3 仕様

- [ディレクトリ・ファイル構成](/spec-directory-structure.html)
  1. 主なディレクトリと役割
  1. 設定ファイル
  1. 定数
  1. 2系・3系置き換え早見表
- [テンプレート探索順序](/template.html)
- <a href="https://github.com/EC-CUBE/eccube3-doc/blob/master/feature_list.xls" target="_blank">機能一覧</a>
- <a href="https://github.com/EC-CUBE/eccube3-doc/tree/master/ER-D" target="_blank">テーブル・ER図</a>
- <a href="https://github.com/EC-CUBE/eccube3-doc/tree/master/IntegrationTest" target="_blank">結合試験項目書</a>

## プラグイン仕様

- [プラグイン仕様・チュートリアル](/plugin.html)
- [インストーラ仕様](/plugin_install.html)
- [ハンドラによる優先制御仕様](/plugin_handler.html) 
- [php app/console plugin:develop を利用したプラグイン開発](/plugin_console.html)
- [プラグインのテスト](plugin-test.html)

## Web API仕様

- [Web API β版 プラグインスタートアップガイド](/web-api-doc.html)
- [Web API開発指針](/api.html)
- [Web API認証 ( Authorization ) ガイド](/api_authorization.html)

## 開発ガイドライン
- 開発を行う際の、主なフローと、前提知識を提供します。

	- [開発作業全体概要](workflow-general-image.html)
	- [コーディング規約](coding_style.html)
	- [マイグレーションガイド](migration.html)
	- <a href="http://qiita.com/nanasess/items/350e59b29cceb2f122b3" target="_blank">ログ設計指針</a>
	- [Gitを用いた開発手順](workflow.html)
	- [カスタマイズリファレンス](customize-reference.html)
        1. カスタマイズ時に作成・変更するファイル
        2. 外部コンポーネント

## 開発の補助

- [デバッグ・Tips](tips.html)

## EC-CUBE 3で利用されている技術
- EC-CUBE 3のコアとなる技術概要と、参考になるサイトの参照先を紹介しています。

	- [技術一覧](/architecture.html)
		1. Silex 
		1. Symfony2
		1. データーベース抽象化レイヤ 
		1. テンプレートエンジン 
		1. ライブラリ管理 


## チュートリアル

- チュートリアルで最終的に作るもの

    - データーベースの「CRUD」を画面表示とあわせて作成します。

    - 本チュートリアルの完成ソースは以下から入手できます。
    
        - <a href="https://github.com/geany-y/ec-cube/tree/documents/tutorial" target="_blank">GitHub</a>

### チュートリアル一覧

- **URLを設定しよう**
    - [ルーティングとコントローラープロバイダー](tutorial-1.html)

- **コントローラーからビューを表示してみよう**
    - [ビューのレンダリング](tutorial-2.html)

- **画面に変数を渡してみよう**
    - [Twig構文とView変数](tutorial-3.html)

- **フォームを表示してみよう**
    - [Formとフォームビルダー](tutorial-4.html)

- **フォーム情報を整理して入力値チェックも追加しよう**
    - [FormType](tutorial-5.html)

- **データーベースを作成しよう**
    - 本章は「開発ガイドライン」で説明を行なっているために、本チュートリアルのテーブル定義のみ、記述します。
    - 詳しい作成方法は以下を参照ください。
        - [マイグレーションガイド](migration.html)
        - [本チュートリアルのテーブル定義](tutorial-6.html)

- **Doctrineのためにデーターベース構造を設定しよう**
    - [データーベーススキーマ定義](tutorial-7.html)

- **Doctrineのためにエンティティファイルを作成しよう**
    - [エンティティ](tutorial-8.html)

- **データーベースに登録してみよう**
    - [エンティティマネージャーを利用した情報の登録](tutorial-9.html)

- **データベースから情報を取り出してテーブルリストで表示してみよう**
    - [データーベース情報の取得とViewのループ処理](tutorial-10.html)

- **データーベース操作処理をレポジトリに整理しよう**
    - [レポジトリとデータベース操作](tutorial-11.html)

- **リストを編集しよう**
    - [条件検索とアップデート処理](tutorial-12.html)

- **いらない情報を削除してみよう**
    - [レコードの削除](tutorial-13.html)


## クックブック

- 本クックブックでは、チュートリアルとは違い、より実践的なカスタマイズ方法を説明していきます。

### 管理画面項目の追加

1. [本体カスタマイズ](cookbook-1-cube3-customize-admin-add.html)

### GoogleAnaliticsの追加方法

1. [管理機能ブロックを利用したJavaScriptの追加](cookbook-2-cube3-customize-js.html)

# EC-CUBE3利用ガイドライン

- **[EC-CUBE3利用ガイドライン](guideline)**
