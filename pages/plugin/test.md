---
title: CIを利用したプラグインのテスト
keywords: plugin condole spec
tags: [plugin, spec]
sidebar: home_sidebar
permalink: plugin_test
summary: プラグインの単体テストの作成方法からTravis CIを用いたテストの自動実行まで説明します。
---
---

# {{ page.title }}

## 概要

- プラグイン作成においても、EC-CUBEのテストクラスの継承を行えば、単体テストを比較的容易に作成できます。

- 本章では、簡単なプラグインを例に「テストの作成・自身のレポジトリ上へプッシュ」した際の継続的インテグレーションの利用方法を説明します。

## テストの目的

- EC-CUBE本体のバージョンアップ時のプラグインの動作確認

- プラグイン改修時にEC-CUBEの各バージョンでの動作確認

## 単体テスト手順

1. ローカルでテストコードを作成する

1. ローカルでユニットテストを実行し、問題がないことを確認する。

1. 自身のGitHubレポジトリにプッシュ。

1. EC-CUBE 3の対象環境に適合しているか確認するために「Travis」を用いてテストを行う。

## テストサンプル

### 前提

1. プラグインは事前に作成されており、インストール・アンインストール、基本機能は動作確認済みとします。

1. 今回は以下に例としてのプラグインを作成しています。

1. 以下をクローンして、参考としてください。
  - [ExampleTestプラグイン](https://github.com/EC-CUBE/ExamleTest){:target="_blank"}

1. 今回のテスト対象は上記レポジトリの「ExampleService.php」というサービスクラスが対象となります。

### テスト対象ファイル機能

1. 「ExamleService.php」内のメソッド「getPluginInstallDateFormatJa」が対象メソッドです。

1. 引数にプラグインのコードを渡すと、そのプラグインがインストールされた日付を**dtb_plugin**から取得します。

1. 該当コードのプラグインが見つからない際は、falseを返却します。

### テストファイルの作成

1.以下の様にフォルダを作成してください。

  - /app/Plugin/[自身で作成したプラグインフォルダ名]/Tests/Service
  - フォルダの作成方法は環境で変わるため、割愛させていただきます。
  - フォルダ内もプラグインのルートディレクトリ構造と同様に、Serviceなどであれば、Serviceフォルダを生成してください。
  - 今回例では、以下フォルダ直下に作成しています。

  ---

  ![テストフォルダの作成](images/plugin/img-plugin-test-create-folder.png)

  ---

2.次にファイルを作成します。

  - 以下手順に添って作成してください。
  - 今回例ではサービスのテストのみ作成するため、以下のファイルをコピー・リネームしてください。
    - [EC-CUBEインストールディレクトリ]/tests/Eccube/Tests/Service/ShoppingServiceTest.php
  - コピー後setUpやtearDownなど初期化・終了時処理のメソッドを除き全て削除します。

3.以下のファイルを作成済みの**/app/Plugin/[自身で作成したプラグインフォルダ名]/Tests/Service**にコピーします。

  - 以下の様に修正・メソッドの追記を行います。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/plugin_test/ExampleServiceTest.php"></script>


- 上記の説明を行います。

    1. コピー後、編集ファイルの名前空間の修正を行います。
    - 今回作成するファイルの格納フォルダを指定してください。

    1. 今回テスト対象の、ExampleServiceの名前空間を指定します。

    1. クラス名を、今回テスト対象ファイルのあわせて変更します。

    1. メソッドを追加します。
    - はじめに正常系のエラーテストを追加しています。
    - 次に正常系のテストを追加しています。

#### 備考

  - 本章では、テストコードの書き方については、一切説明を行いません。
  - 以下を参考に作成を行なってください。
    - [EC-CUBE 3のメモ - ユニットテスト -](http://qiita.com/chihiro-adachi/items/f2fd1cbe10dccacb3631){:target="_blank"}

### ローカルでのテストの実行

- ここまでの作業でテストが作成できました。
- 一度ローカルで確認して、単一環境で機能として問題ないか確認をおこないます。

  1.コンソールを起動する。

  - ご自身の環境に合わせたコンソールを起動してください。
  - ※Windows環境であれば、環境パスに、PHPの実行パスは指定済みとします。

  2.以下の様に**EC-CUBE 3のインストールディレクトリ**に移動してください。

---

![EC-CUBE 3インストールディレクトリ](images/plugin/img-plugin-test-open-console.png)

---

  3.以下コマンドを実行します。

```
vendor/bin/phpunit ./app/Plugin/[自身で作成したプラグインのフォルダ名]
```

- 内容が正しければ、以下の様な内容が表示されるはずです。


---

![ユニットテスト結果](images/plugin/img-plugin-test-unit-result.png)

---

### 継続的インテグレーションを使った複数環境でのテスト

- 前項で問題がなければ、自身のGitHub環境にプッシュし、継続的インテグレーションを提供する、「Travis-CI」で複数環境でのテストをおこないます。

#### Travis-CI設定ファイルの作成

1.プラグインのルートディレクトリに**.travis.yml**を作成します。

2.今回の例では以下フォルダが該当です。

  - [EC-CUBE 3インストールディレクトリ]/app/Plugin/ExampleTest

3.フォルダ内にファイルを作成し、以下を記述します。

  - 変更が必要な箇所のみ★印を付与して説明しています。

  - .travis.yml

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/plugin_test/Travis.yml"></script>

- 上記の設定項目内容を以下に説明します。

1. [php：]
  - phpの各バージョンを設定します。
  - 組み合わせ数が多くなるため、5.3と5.6のみなど、ある程バージョンを絞る方が適切です。

1. [env：> global：]
  - PLUGIN_CODEの右辺に作成したプラグインのコードを指定します。

1. [env：> matrix：]
  - テストのマトリクスの指定です。
  - ここでEC-CUBEの各バージョンを設定します。

1. [before_script：]
  - プラグインのユニットテストを実行するまでの前準備です。
    - 処理フローは以下となります。
      - プラグインをパッケージング(tarでアーカイブ)
      - ec-cube本体をclone
      - envで指定したec-cube本体のバージョンにcheckout
      - ec-cube本体のインストール
      - プラグインのインストール

1. [script：]
  - phpユニットテストを実行しています。
  - ここでインストールされたプラグインに内包されているユニットテストが実行されます。

- 以下にTravisの設定ファイルの参考を記述しておきますので、参考としてください。

- <a href="https://github.com/EC-CUBE/coupon-plugin/blob/master/.travis.yml" target="_blank">.travis.yml(参考)</a>

#### Travis-CIとGitHubの連携

- GitHubにログイン済みの状態で以下にアクセスし、連携をONにします。

- `https://travis-ci.org/profile/[user]` 

- 表示されているレポジトリの一覧から、該当レポジトリのボタン表示をスライドさせ緑色でONの状態で連携完了です。


#### GitHubへのプッシュ

- 完了したら、自身のレポジトリにプッシュを行うと自動でTravis-CIが稼働し、テストを行います。

- テスト結果はGitHubとTravis-CIを設定したページで確認できます。
