---
layout: default
title: Web API β版 プラグインスタートアップガイド
---

---

# Web API β版 プラグインスタートアップガイド

## 本章の内容

- C-CUBE API β版のインストール方法
    - Swaggerを利用した動作確認方法
    - 開発に必要なドキュメント

※また、AOuth2.0やOpenID Connectによる認証/APIの利用経験のある方を想定しています。
※（Facebook/Twitter/Google連携アプリの作成など）

## 基本要件

1. PHP5.4以降にて動作確認
1. PostgreSQL9.2, MySQL5.5, SQLite3 にて動作確認
1. 全テーブルの CRUD が可能なこと
    - DELETE は del_flg が存在するテーブルのみ
    - public アクセス可能なテーブル、Customer 認証時に参照/更新可能なテーブル、 フィールドは別途定める
    - API定義は、テーブル構成に依存する
    - パスワード等、暗号化されるデータは変換しない
1. 試験的な実装のため、正式リリースまでに仕様が変更される可能性あり
1. OAuth2.0, OpenID Connect に準拠した認証
    - 一部未サポートの仕様あり（今後サポート予定）
    - セキュティ強化のためOAuth2.0, OpenID Connectの仕様で「推奨→必須」に変更しているパラメータあり
    - 認証の安全性は SymfonySecurity, php-oauth2-server, EC-CUBE 3.0.0のプラグイン機構に依存
1. シングルサインオンの機能は未実装
1. API ドキュメント生成に使用している swagger は master ブランチの未リリースのものを使用
1. <a href="https://github.com/EC-CUBE/eccube-api/issues" target="_blank">現状把握している課題</a>

## インストール

- 以下オーナーズストアから入手してください。

- <a href="http://www.ec-cube.net/products/detail.php?product_id=1116" target="_blank">オーナーズストアからインストールできます。</a>


## APIへのアクセス ( public アクセス可能なAPIエンドポイントへのアクセス )

### public アクセス可能なAPIエンドポイントへのアクセス

- EC-CUBE APIβ版プラグインインストール後に、下記のURLにアクセスすることで、商品情報を取得できます。

```
URL：http://<サイトURL> /api/v0/product
```

- **レスポンス形式：JSON形式**
    - public アクセス可能なAPIの一覧については、**エンドポイント一覧**を参照してください。

### 認証が必要なAPIエンドポイントへのアクセス

- 以下に手順を示します
    1. **public アクセス不可のAPIエンドポイントを使用**する場合は、**クライアントの登録と認証**が**必要**です。
    1. **このドキュメント**では**Swaggerをクライアント**として使用して、**動作確認**を行います。

### APIクライアントの登録	

1.認証を行うにはクライアントの登録が必要です。

2.管理画面>設定>メンバー管理 から**APIクライアントの追加**を行ってください。

---

![EC-CUBE管理API登録画面1](/images/img-webapi-b-register-client-1.png)

---

---

![EC-CUBE管理API登録画面2](/images/img-webapi-b-register-client-2.png)

---

3.登録ボタンを押してクライアントの登録を完了します。

4.このドキュメントでは**Swagger**を**利用して動作確認**をするため、**「redirect_uri」の項目**は**登録画面の最下部**の説明のとおりに設定してください。

---

![EC-CUBE管理画面Swaggerリダイレクト](/images/img-webapi-b-swgger-redirect.png)

---

### クライアントとしてSwaggerを利用した動作確認

- EC-CUBE 3.0 では、**認証方法**として**OAuth2.0 Authorization** 及び **OpenID Connect**をサポートしています。
- この認証に対応したクライアントとして、**Swagger**を利用して動作確認を行います。

- 「APIドキュメントを開く」をクリックすると**Swagger**の画面にアクセスできます。
 
---

![EC-CUBE管理画面Swaggerリンク](/images/img-webapi-b-swgger-access.png)

---

#### 認証手順

1. 画面右上の「Authorize」ボタンを押下します。
1. **使用したいスコープのチェックボックスをON**にして**子画面内**の「Authorize」ボタンを押してください。EC-CUBEの管理画面に遷移するので、ここで「許可する」を選択すると、そのスコープにアクセスできるようになります。（**内部的にはアクセストークンを取得した状態**になります）
 

---

![Swagger認証](/images/img-webapi-b-swgger-authorize.png)

---

---

![Swagger認証コールバック](/images/img-webapi-b-swgger-authorize-callback.png)

---

- ご注意
    - Swagger側で選択したスコープに関わらず、全てのスコープに対してリクエストが行われてしまいますが、これはSwagger不具合によるものです。EC-CUBE APIの認証の**不具合ではありません。**

1. **商品情報をGET（取得）する**
1. 「GET /api/v0/product」を選択します。
1. 「実際に実行」ボタンを押下すると、商品情報を取得できます。

---

![SwaggerGetSample](/images/img-webapi-b-swgger-get-sample.png)

---
 
1. **商品情報をPOST（作成）する**
1. 「POST /api/v0/product」を選択します。
1. 画面の①部分にパラメータのサンプルが表示されています。
1. 画面の①部分をクリックすると、②部分にサンプルが挿入されます。
1. 「実際に実行」ボタンを押下すると、商品情報を作成できます。

---

![SwaggerPostSample](/images/img-webapi-b-swgger-post-sample.png)

---


- 再度、商品情報をGET（取得）すると、**商品情報が追加できている事を確認**できます。

    - レスポンスコードが**401の場合は認証に失敗**しています。
       - **認証をやり直す**か、それでもうまくいかない場合は**本章のトラブルシューティング**を確認してください。
 
## クライアントの認証フローについて

- EC-CUBE 3.0の**認証が必要なAPIにアクセス**するためには、クライアントに**OAuth2.0, OpenID Connectの認証フローを実装**する必要あります。

- 詳細は下記のドキュメントをご確認ください。
     - 認証についての開発ドキュメント
         - <a href="http://ec-cube.github.io/api_authorization.html" target="_blank">Web API認証 ( Authorization ) ガイド</a>


### 実装サンプル

1. <a href="https://github.com/nanasess/eccube3-oauth2-client" target="_blank">PHP(Symfony2) での実装例</a>
1. <a href="https://github.com/nanasess/eccube3-oauth2-client-for-python" target="_blank">Python(Flask) での実装例</a>
1. <a href="https://github.com/nanasess/eccube3-oauth2-client-for-nodejs" target="_blank">Node.js(Express) での実装例</a>
1. <a href="https://github.com/nanasess/DotNetOpenAuth" target="_blank">C# での実装例(Web/Wpf)</a>
1. <a href="https://github.com/nanasess/eccube3-oauth2-client-for-java" target="_blank">Java での実装例</a>
1. <a href="https://developers.google.com/oauthplayground/" target="_blank">Google OAuth 2.0 Playground</a>
    - OAuth 2.0 Configuration -> OAuth endpoint -> Custom にて動作確認済み
    - Authorization Endpoint に ```?state=<random_state>``` を付与する必要があります

## 利用できるAPIエンドポイントについて

- EC-CUBE 3.0では、**RESTの原則に基づいたAPIの実装**を行っています。
    - 詳細は下記のドキュメントをご確認ください。

        1.API開発ドキュメント

        - <a href="http://ec-cube.github.io/api" target="_blank">API開発指針</a>

        2.APIエンドポイント一覧

        - <a href="https://github.com/EC-CUBE/ec-cube.github.io/blob/master/documents/api/EC-CUBE_API_Endpoint.pdf" target="_blank">GitHub</a>

## APIで取得できる情報について
- **β版**ではEC-CUBE 3.0.0の**各テーブル**に対して**CRUDアクセスを提供**しています。
- そのためAPIから**取得したデータの定義**は、**EC-CUBE 3.0のテーブル定義に依存**します。
- EC-CUBE 3.0.0のテーブル定義は下記を参照してください。
    - EC-CUBE 3.0.0テーブル定義
        - <a href="https://github.com/EC-CUBE/eccube3-doc/tree/master/ER-D" target="_blank">GitHub</a>

## トラブルシューティング

1. 認証したのにレスポンスが401となる

    - 一部のレンタルサーバーや SAPI CGI/FastCGI の環境では、認証情報(Authorization ヘッダ)が取得できず、 401 Unauthorized エラーとなってしまう場合があります。 
    - この場合は、 <ec-cube-install-path>/html/.htaccess に以下を追記してください。

        - <ec-cube-install-path>/html/.htaccess

            <pre>
            > RewriteCond %{HTTP:Authorization} ^(.*)
            > RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
            </pre>
