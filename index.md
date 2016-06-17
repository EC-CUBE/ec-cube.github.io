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

## 本体開発

### 開発ガイドライン
- 開発を行う際の、主なフローと、前提知識を提供します。

	- [開発作業全体概要](workflow-general-image.html)
	- [コーディング規約](coding_style.html)
	- [マイグレーションガイド](migration.html)
	- [ログ設計指針]()
	- [開発環境の構築](development-environment.html)
	- [Gitを用いた開発手順](workflow.html)
	- [カスタマイズリファレンス](customize-reference.html)
        1. カスタマイズ時に作成・変更するファイル
        2. 外部コンポーネント

### 開発の補助

- [デバッグ・Tips](tips.html)

### EC-CUBE3で利用されている技術
- EC-CUBE3のコアとなる技術概要と、参考になるサイトの参照先を紹介しています。

	- [技術一覧](/architecture.html)
		1. Silex 
		1. Symfony2
		1. データーベース抽象化レイヤ 
		1. テンプレートエンジン 
		1. ライブラリ管理 

### EC-CUBE3仕様

- EC-CUBE3の仕様を「ディレクトリ構成」を元に、説明しています。

	- [ディレクトリ・ファイル構成](/spec-directory-structure.html)
    1. 主なディレクトリと役割
    1. 設定ファイル
    1. 定数
    1. 2系・3系置き換え早見表

	- [テーブル構成]()


### チュートリアル

- チュートリアルで最終的に作るもの

    - データーベースの「CRUD」を画面表示とあわせて作成します。

#### チュートリアル一覧

1. **URLを設定しよう**
- [ルーティングとコントローラープロバイダー](tutorial-1.html)

1. **コントローラーからビューを表示してみよう**
- [ビューのレンダリング](tutorial-2.html)

1. **画面に変数を渡してみよう**
- [Twig構文とView変数](tutorial-3.html)

1. **フォームを表示してみよう**
- [Formとフォームビルダー](tutorial-4.html)

1. **フォーム情報を整理して入力値チェックも追加しよう**
- [FormType](tutorial-5.html)

1. **データーベースを作成しよう**
- 本章は「開発ガイドライン」で説明を行なっているために、本チュートリアルのテーブル定義のみ、記述します。
- 詳しい作成方法は以下を参照ください。
	- [マイグレーションガイド](migration.html)
	- [本チュートリアルのテーブル定義](tutorial-6.html)

1. **Doctrineのためにデーターベース構造を設定しよう**
- [データーベーススキーマ定義](tutorial-7.html)

1. **Doctrineのためにエンティティファイルを作成しよう**
- [エンティティ](tutorial-8.html)

1. **データーベースに登録してみよう**
- [エンティティマネージャーを利用した情報の登録](tutorial-9.html)

1. **データベースから情報を取り出してテーブルリストで表示してみよう**
- [データーベース情報の取得とViewのループ処理](tutorial-10.html)

1. **データーベース操作処理をレポジトリに整理しよう**
- [レポジトリとデータベース操作](tutorial-11.html)

1. **リストを編集しよう**
- [条件検索とアップデート処理](tutorial-12.html)

1. **いらない情報を削除してみよう**
- [レコードの削除](tutorial-13.html)

### クックブック

- 本クックブックでは、チュートリアルとは違い、より実践的なカスタマイズ方法を説明していきます。

#### 管理画面項目の追加

1. [本体カスタマイズ](cookbook-1-cube3-customize.html)

2. プラグイン作成

<!--
### チュートリアルを終えて

### Silex + Symfony2 + EC-CUBE3の関係

### Symfony2コンポーネント
-->

## プラグイン開発

### ユニットテスト

  - [プラグインのテスト](plugin-test.html)

  - 本章では以下を説明します。

    1. ユニットテストの作成
    1. プラグインテストのCI(継続的インテグレーション)設定

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
