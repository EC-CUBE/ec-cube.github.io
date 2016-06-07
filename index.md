---
layout: default
title: ホーム
---

---

# EC-CUBE 3 開発ドキュメント

<!--
## GitHub

[https://github.com/EC-CUBE/ec-cube](https://github.com/EC-CUBE/ec-cube)
-->

<!-- ## 目次 -->

## 開発ガイドライン
- 開発を行う際の、主なフローと、前提知識を提供します。

	- [開発作業全体概要](workflow-general-image.html)
	- [コーディング規約](coding_style.html)
	- [マイグレーションガイド](migration.html)
	- [開発環境の構築](development-environment.html)
	- [Gitを用いた開発手順](workflow.html)
	- [カスタマイズリファレンス](customize-reference.html)
        1. カスタマイズ時に作成・変更するファイル
        2. 外部コンポーネント

## EC-CUBE3で利用されている技術
- EC-CUBE3のコアとなる技術概要と、参考になるサイトの参照先を紹介しています。

	- [技術一覧](/architecture.html)
		1. Silex 
		1. Symfony2
		1. データーベース抽象化レイヤ 
		1. テンプレートエンジン 
		1. ライブラリ管理 

## EC-CUBE3仕様

- EC-CUBE3の仕様を「ディレクトリ構成」を元に、説明しています。

	- [ディレクトリ・ファイル構成](/spec-directory-structure.html)
    1. 主なディレクトリと役割
    1. 設定ファイル
    1. 定数
    1. 2系・3系置き換え早見表

	- [テーブル構成]()


## CookBook

- CookBookで最終的に作るもの

    - データーベースの「CRUD」が行える様に、簡易なBBS(意見箱)を作成します。

### URLを設定しよう

- [ルーティングとコントローラープロバイダー](cook-book-1.html)

### コントローラーからビューを表示してみよう

- [ビューのレンダリング](cook-book-2.html)

### 画面に変数を渡してみよう

- [Twig構文とView変数](cook-book-3.html)

### フォームを表示してみよう

- [Formとフォームビルダー](cook-book-4.html)

### フォーム情報を整理して入力値チェックも追加しよう

- [FormType](cook-book-5.html)

### データーベースを作成しよう

- 本章は「開発ガイドライン」で説明を行なっているために、本クックブックのテーブル定義のみ、記述します。

- 詳しい作成方法は以下を参照ください。
	- [マイグレーションガイド](migration.html)

	- [本クックブックのテーブル定義](cook-book-6.html)

### Doctrineのためにデーターベース構造を設定しよう

- [データーベーススキーマ定義](cook-book-7.html)

### Doctrineのためにエンティティファイルを作成しよう

- [エンティティ]()

### データーベースに登録してみよう

### データベースから情報を取り出してリストを表示しよう

### 登録部分をレポジトリに整理しよう

### リストを編集しよう

### いらない情報を削除してみよう

## CookBookを終えて

### Silex + Symfony2 + EC-CUBE3の関係

### Symfony2コンポーネント
<!--
## システム要件

## 開発ガイドライン

### EC-CUBE3仕様
-->

<!--
- [インストール方法](/install.html)
- [アップデート方法](/update.html)
- [システム要件](/requirement.html)
- ディレクトリ・ファイル構成
    - [ディレクトリ・ファイル構成](/directory.html)
    - [テンプレート探索順序](/template.html)
- プラグイン仕様
    - [プラグイン仕様・チュートリアル](/plugin.html)
    - [インストーラ仕様](/plugin_install.html)
    - [ハンドラによる優先制御仕様](/plugin_handler.html)
    - [php app/console plugin:develop を利用したプラグイン開発](/plugin_console.html)
- API仕様
    - [API開発指針](/api.html)
- 開発ガイドライン
    - [コーディング規約](/coding_style.html)
    - [マイグレーションガイド](/migration.html)
    - [ユニットテストガイド](/unittest.html)
    - [開発・デバッグTips](/tips.html)
    - [用語集(準備中)](/glossary.html)
- [FAQ(準備中)](/faq.html)
    - [TEST](http://www.google.co.jp)
-->
