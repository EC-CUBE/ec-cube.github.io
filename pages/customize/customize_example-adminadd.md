---
title: コアコードのカスタマイズ例：会員管理への項目追加
keywords: core カスタマイズ  本体
tags: [core, tutorial]
sidebar: home_sidebar
permalink: customize_example-adminadd
summary: 管理画面の会員管理を例にコアコードをカスタマイズして項目を追加する方法を説明します。
folder: customize
---


---

## 本章で行うこと

1. 本章では、管理画面の「会員管理」の登録・編集項目に、項目を追記する方法を説明します。

1. 項目は「部署名」を追加したいと思います。

## カスタマイズで行うこと

1. 追加するページのURL確認

1. ルーティングの確認

1. コントローラーの特定

1. コントローラーの内容確認

1. 影響ファイルの特定

1. 追加項目のマイグレーションファイルの作成

1. データーベース関連ファイルの修正

1. フォームタイプの修正

1. レポジトリの修正

1. Twigの修正

1. 関連する箇所の確認

1. 関連箇所修正

### 追加するページのURL確認

- まず項目を追加したい画面がある場合は、その画面にアクセスし、URLを確認・メモしておきます。

1.今回対象画面の「会員登録・編集画面」にアクセスします。

---

![管理画面会員登録](images/customize/example1-view-cusomer-new.png)

---

2.ブラウザのURLを確認 ( メモ ) します。

- 今回対象の「会員登録・会員編集」であれば以下となります。
- URLの末尾に注目してください。

- 会員登録
  - http://localhost/ec-cube/html/index_dev.php**/admin/customer/new**

- 会員編集
  - http://localhost/ec-cube/html/index_dev.php**/admin/customer/1/edit**

### ルーティングの確認

1.確認したURLから該当コントローラーを特定するために、**ControllerProvider**を確認します。

- ControllerProvider保存箇所
  - /src/Eccube/ControllerProvider/

2.次にファイルを開きますが、管理画面かユーザー画面かで開くファイルが変わります。

  - 管理画面
    - AdminControllerProvider.php

  - ユーザー画面
    - FrontControllerProvider.php


### コントローラーの特定

- 今回は管理画面が対象のため、AdminControllerProvider.phpを開きます。

1.AdminControllerProvider.phpを開いたら、URL語尾の画面に関連した文字を検索します。

  - 今回であれば、**customer**を検索します。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/AdminControllerProvider_view.php"></script>

- 上記が検索でヒットした付近のソースです。

2.さらに絞りこむためにもう一度URLの語尾に注目します。

  - **new**と**edit**がキーワードになりそうです。

  - 上記抜粋を確認すると、上から4行目、5行目が、今回該当のコントローラーとなります。

  - 具体的には以下コントローラーです。
    - /src/Eccube/Controller/Admin/Customer/CustomerEditController[.php]

  - メソッドも確認すると、両方「index」のメソッドが該当となりそうです。

### コントローラーの確認

- コントローラーの特定ができたので、ファイルを開いていみます。

    - 該当コントローラー
      - /src/Eccube/Controller/Admin/Customer/CustomerEditController[.php]

    - 以下が抜粋した内容です。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/CustomerEditController_view.php"></script>


1.まずカスタマーにセットされているところでは、今回項目の関連も考えられますので、カスタマーのエンティティを追いかけていきます。

- EC-CUBE 3のコーディング規約でデーターモデルオブジェクトでは変数の初めが大文字で定義します。

2.上記理由から**$Customer**を検索してみます。

3.上記検索で複数ヒットしますが、その中でも、**set**メソッドを中心にソースを追いかけていくと以下関連のみセットされていることが判断できます。

  - パスワード関連
  - 合計金額、購入回数
  - **フォームはフォームタイプと紐付け**

- 上記調査の結果、会員登録・編集画面の登録機能においては、データーベース関連のファイルとフォームに関するファイルの修正で問題なさそうです。

### 関連ファイルの確認

#### フォーム関連ファイル

- フォーム関連のファイルは通常は以下のみとなります。

  1. FormType

  - /src/Eccube/Form/Type/Admin/CustomerType.php

#### データーベース関連のファイル

- データーベース関連のファイルですが、通常は以下となります。

  1. Eccube.Entity.[対象エンティティ名].dcm.yml
  1. エンティティファイル
  1. レポジトリファイル

- 今回のCustomerでは以下となります。

  1. Eccube.Entity.[対象エンティティ名].dcm.yml
    - /src/Eccube/Resource/doctrine/Eccube.Entity.Customer.dcm.yml

  1. エンティティファイル
    - /src/Eccube/Entity/Customer.php

  1. レポジトリファイル
    - /src/Eccube/Repository/CustomerRepository.php

## 関連ファイルの修正

- ここまでで修正対象ファイルが特定できました。
- 次は対象ファイルを修正していきます。

### 追加項目のデーター定義の確認

- 以下は追加する項目の詳細です。

- 対象テーブル名称 : drb_customer

| 論理名 | 物理名 | データー種別 | データオプション |
|------|------|------|------|
| 部署名 | department | varchar(255) | DEFAULT NULL |

### マイグレーションファイルの作成

- 次にまず対象データーベースにカラムを追加します。
- 操作はマイグレーションで行います。
- コンソールコマンドを開きEC-CUBE 3のインストールディレクトリに移動し、以下コマンドを実行します。

```
php app/console migrations:generate
```

- 上記を実行すると以下ディレクトリにマイグレーションファイルの雛形が作成されていると思います。
  - [EC-CUBE 3インストールディレクトリ]/src/Eccube/Resource/doctrine/migration

- 作成ファイル
  - **Version20160616144602.php**

  - 以下内容を記述します
  
<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/migration_view.php"></script>


- 上記内容を簡単に説明します。

1.雛形には「up/down」のメソッドが作成されています。

  - [upメソッド]
    - 本ファイルを基準としてDBを最新に更新する処理を記述

  - [downメソッド]
    - 本ファイルを基準としてDBを前の状態に戻すための処理を記述

2.upメソッドの引数「$schema」オブジェクトを用いて、テーブル操作を行います。

3以下がメソッドの説明一覧です。

---

| メソッド名称 | 引数 | 戻り値 | メソッド機能 |
|------|------|------|------|
| hasTable | 対象テーブル物理名称 | boolean | 引数で与えられたテーブルが存在するか確認 |
| getTable | 取得テーブルオブジェクト名 | テーブルオブジェクト | 引数で与えられたテーブルオブジェクトを取得する |
| addColumn | 作成カラム定義(連想配列) | - | 引数で与えられた情報でカラムを追加する |
| dropColumn | 削除カラム連想配列) | - | 引数で受け取った名称のカラムを削除する |

---

4.上記のメソッドを用い、前述のカラムを追加します。

5.テーブルの有無により「up/down」の処理でエラーが発生する可能性があるために、hasTableで確認後、処理を行なっています。

### マイグレーションファイルの実行

- 上記記述が完了したら、以下のフォルダに移動し、マイグレーションのコマンドで、テーブルを作成します。
  - [EC-CUBE 3インストールディレクトリ]/src/Eccube/Resource/doctrine/migration

  - コマンド

  ```
  php app/console migrations:migrate
  ```

  - マイグレーションが実行され、以下の様にテーブルが作成されているはずです。

  ---

  ![マイグレーションでカラム追加されたテーブル](images/customize/example1-view-cusomer-add-column.png)

  ---

## データーベース関連ファイルの修正

### Eccube.Entity.Customer.dcm.ymlの修正

- Eccube.Entity.Customer.dcm.ymlに作成したカラムを定義します。

- 以下ディレクトリに移動します。
  - /src/Eccube/Resource/doctrine

- 以下定義を追記します。
  - Eccube.Entity.Customer.dcm.yml

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/dcm_yml_add_column.yml"></script>


- 上記の説明を簡単に行います。

1. 最初に**company_name**を検索します。
  - company_nameの下にカラム定義を追記します。

### CustomerEntityの修正

- 次はエンティティにカラム定義を追記します。

- 以下のファイルを修正します。
 - /src/Eccube/Entity/CustomerEntity.php

- 以下修正箇所です

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/CustomerEntity_mofdified.php"></script>


- メンバ変数の最後に**department**を追記します。

- メソッド**getZipcode**の次に、**department**のセッター・ゲッターを追記します。

- 追記内容は上記の引用コードを参考にしてください。

## フォームの項目追加

### フォームタイプの修正

- 会員管理登録・編集画面で利用されているフォームタイプに、部署名の項目を追加します。

- 以下が対象ファイルです。
 - /src/Eccube/Form/Type/Admin/CustomerType.php

- 下記の様に修正を加えます。
 - 今回は会社名の下に追記します。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/CustomerType_modified.php"></script>

- 上記の簡単な説明を行います。

1. フォームビルダーのaddメソッドで、name属性、type属性、必須、label名称、バリデーションを定義しています。

### レポジトリの修正

- 次はレポジトリを確認します。

- 以下が対象ファイルです。
 - /src/Eccube/Repository/CustomerRepository.php

1. データーを手動でセットしている箇所がないか確認します。

1. **set**をキーに検索します。

1. **初回購入時間、購入時間、購入回数、購入金額、パスワード関連**以外では、セットされている箇所がなさそうです。

- 上記の調査より今回レポジトリは修正対象外とします。

### Twigの修正

- 画面に追加カラムを表示させるために、Twigファイルを修正します。
- どのTwigを修正するかは、コントローラーのメソッド内、**render**メソッドを確認します。

- 以下が対象ファイルです。
 - /src/Eccube/Resource/template/admin/Customer/edit.twig

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/cookbook1_customize/customer_edit_modified.twig"></script>


1. 会社名の下にカラムを追加するために、**company_name**を検索します。

1. 上記の場所を特定できれば、その下に上記の様に部署名の項目表示設定を行います。

  - [**form_label**]
    - フォームの項目名を引数に渡すとFormTypeで設定した、ラベル名が表示されます。

  - [**form_widget**]
    - フォームの項目名を引数に渡すとFormTypeで設定した項目が表示されます。

  - [**form_errors**]
    - フォームの項目名を引数に渡すとバリデーションエラーがあった場合エラーが表示されます。

## 関連ファイルの確認

- 今回は管理画面への「登録・編集」が目的のために、ここまでの修正で完了ですが、本来であれば、EC-CUBE 3インストールディレクトリで確認し、関連箇所で不整合が発生しないか、確認してくだい。

- Linuxなどの環境であれば、以下で検索を行い、影響範囲を確認してみてください。

  - 検索対象トップディレクトリは以下から行なってください。
  - [EC-CUBE 3インストールディレクトリ]/src/Eccube/

```

$find -type f ｜ xargs egrep -n "Customer"

```

- また本来であれば、ユーザーの新規登録、購入情報、受注画面、メールなどに、表示・登録・編集を反映したいかと思いますが、そこに項目を追加する手順も本クックブックを参考に行なってみてください。

- 本クックブックを扱う範囲は、冒頭で述べた通り、「会員管理、登録・編集」のみとします。

## 登録確認

- では最後に正しく稼働するか確認してみましょう。

- 会員管理 > 会員マスター から、既存会員を検索し、名前をクリックし「登録・編集画面」を表示します。

---

![追加項目表示確認](images/customize/example1-view-cusomer-add-column-viewcheck.png)

---

- 次に「部署名」に任意の文字を入力し、「会員情報を登録」ボタンを押下ください。

- 成功メッセージが表示れ、部署名が保持されているはずです。

---

![追加項目表示確認](images/customize/example1-view-cusomer-add-column-insertcheck.png)

---

## 備考

- 最後に本クックブックのソースを以下のレポジトリに保存していますので、参考にしてください。

- <a href="https://github.com/geany-y/ec-cube/tree/cookbook/custom_column_add_to_admin_form" target="_blank">CookBook/管理画面項目の追加</a>
