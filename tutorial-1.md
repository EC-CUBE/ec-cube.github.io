---
layout: default
title: URLを設定しよう
---

---

# {{ page.title }}


## ルーティングとコントローラープロバイダ

- まずは、基本となるルーティングの設定方法について説明します。

### EC-CUBE3の各設定の基本的な考え方

- EC-CUBE3の設定は非常にシンプルです。基本的に設定ファイルへ設定内容を記述する事で、アプリケーションを構築していきます。

- 設定ファイルには、「.php .yml」が用いられています。

### 本章メニュー

- 本章では以下を行います。

    1. URLとコントローラーを紐付ける際に、設定するファイルの説明

    1. ルーティングの設定
        - コントローラーとURLの紐付け方を説明します。

### URLとコントローラーの紐付けを設定するファイルの説明

- URLとコントローラーの紐付けを設定する(ルーティング)ファイルは、**ControllerProvider**と呼ばれているファイルに設定されています。

#### コントローラープロバイダーの保存ディレクトリ

- コントローラープロバイダは以下のディレクトリに保存されています。

```
/[インストールディレクトリ]/src/Eccube/ControllerProvider
```

#### コントローラープロバイダーファイルの種類

- ディレクトリ内に以下のファイルが保存されています。

    1. AdminControllerProvider.php
        - 管理画面のルーティングが設定されています。

    1. FrontControllerProvider.php
        - ユーザー画面(フロント画面)のルーティングが設定されています。

    1. InstallControllerProvider.php
        - インストール画面のルーティングが設定されています。
        - カスタマイズにおいて**本設定ファイルを使用することはありません。**

### ルーティングの設定

#### FrontControllerProviderの設定

- ユーザー画面のルーティングの設定は、**FrontControllerProvider**に行なっていきますので、前項で説明した場所から、該当ファイルを開いてください。

#### **FrontControllerProvider**の中身

- ファイルを開いたら、分かり易い項目を例としますので、まず「mypage」を検索してみてください。

- mypageのルーティングの設定を下記に抜粋しました。

```
    // mypage
    $c->match('/mypage', '\Eccube\Controller\Mypage\MypageController::index')->bind('mypage');
    $c->match('/mypage/login', '\Eccube\Controller\Mypage\MypageController::login')->bind('mypage_login');
    $c->match('/mypage/change', '\Eccube\Controller\Mypage\ChangeController::index')->bind('mypage_change');
    $c->match('/mypage/change_complete', '\Eccube\Controller\Mypage\ChangeController::complete')->bind('mypage_change_complete');

```

#### メソッドについての説明

- 引数部を日本語で記述すると以下の様になります。

```
$c->match([ドキュメントルートからのurl], [紐付けるコントローラーのパス])->bind([ルーティング名称])
```

1. ドキュメントルートからのURL
    - /(スラッシュ)ではじめ、任意のURL名称を作成します。
        - 名前からページでの処理が推測しやすい名前をつけます。

1. 紐付けるコントローラーのパス
    - /src/Eccube/Controller内に作成した、コントローラーのファイル名(クラス名)とメソッド名を、インストールディレクトリからのフルパスで指定します。
    - クラス名とメソッド名の間は「::」コロン２つでつなぎます。

1. ルーティング名称
    - 設定したルーティング名称に「名前」をつけておきます。
    - リダイレクトの際などに、「名前」を利用します。

#### 実際の記述内容

1. **FrontControllerProvider**へのソースの追記

- ファイル内最下部の「return」の前に以下の様に追記します。

```
        // チュートリアル
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');

        return $c;
    }
}
```

- 以上でルーティングの設定は完了です。

### ブラウザでアクセス

- ルーティングの設定が終わったのでブラウザでアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. エラーメッセージの表示

- 以下のエラーメッセージが表示されれば成功です。
- エラーの内容はルーティングで指定している、コントローラーが見つからないエラーです。
- 現状ではコントローラーを作成していないため、正しい挙動です。
- コントローラーとメソッドは次章で作成します。

---

![tutorial1-error1](/images/img-tutorial1-error1.png)

---
