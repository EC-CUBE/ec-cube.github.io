---
layout: default
title: Web API Authorization ガイド
---

---

# Web API Authorization ガイド

## 概要

EC-CUBE で Web API を実行する際、一般公開された情報を参照する場合は必要ありませんが、顧客情報を参照したり、受注情報を更新する場合などは認証が必要です。

EC-CUBE3 では、 [OpenID Connect](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html) を使用した認証をサポートしています。
本認証を使用する場合は、[TLS をサポート](http://openid-foundation-japan.github.io/openid-connect-basic-1_0.ja.html#TLSRequirements)する必要があります。

## 対応するフロー

- [Authorization Code Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#CodeFlowAuth) - 主にWebアプリ向け
- [Implicit Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#ImplicitFlowAuth) - 主にJavaScript、 ネイティブアプリ向け

信頼性の確保された、プライベート環境で使用する場合は、 [OAuth2.0 Authorization](http://openid-foundation-japan.github.io/rfc6749.ja.html) も使用可能です。

## 設定方法

### 管理者権限での実行

1. 管理画面にログインし、メンバー管理画面へ遷移します。
2. **APIクライアント一覧** をクリックし、 APIクライアントを新規登録します。
    - **アプリケーション名** には任意の名称を入力します
    - **redirect_uri** には、Authorization Endpoint からのリダイレクト先の URL を入力します。
3. 登録が終わると、 `client_id`, `client_secret` などが発行されます。公開鍵は `id_token` を検証する際に使用します。

### 顧客(Customer)での実行

1. mypage にログインし、 `/mypage/api` へアクセスします。
2. **新規登録** をクリックし、 APIクライアントを新規登録します。
    - **アプリケーション名** には任意の名称を入力します
    - **redirect_uri** には、Authorization Endpoint からのリダイレクト先の URL を入力します。
3. 登録が終わると、 `client_id`, `client_secret` などが発行されます。公開鍵は `id_token` を検証する際に使用します。

### .htaccess の設定

一部のレンタルサーバーや SAPI CGI/FastCGI の環境では、認証情報(Authorization ヘッダ)が取得できず、 401 Unauthorized エラーとなってしまう場合があります。
この場合は、 `<ec-cube-install-path>/html/.htaccess` に以下を追記してください。

```.htaccess
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
```

## クライアント(OAuth 2.0 Client/Relying Party)の実装方法

*各言語のサンプルは[こちら](/api.html#section-14)*

### 実装する際の注意

#### state パラメータ

OAuth2.0 では CSRF を防ぐための state パラメータが[推奨となっています](http://openid-foundation-japan.github.io/rfc6749.ja.html#CSRF)。
しかし、多くの OAuth2.0 クライアントのサンプルは、 state パラメータに標準では対応していません。
EC-CUBE3 では、 **state パラメータは必須** ですので、ご注意ください。

### 実装チュートリアル

ここでは curl コマンドによって OpenID Connect Authorization code Flow を実装してみます。

#### 準備

[APIクライアントを作成](#section-2)しておきます。
この例では、 `redirect_uri` を `https://127.0.0.1:8080/Callback` に設定します。

#### 1. Authorization code の取得

以下の URL にブラウザでアクセスします。 **state パラメータは必須** です。

```
https://<eccube-host>/admin/OAuth2/v0/authorize?client_id=<client id>&redirect_uri=http%3A%2F%2F127.0.0.1%3A8080%2FCallback&response_type=code&state=<random_state>&nonce=<random_nonce>&scope=product_read%20product_write%20openid%20offline_access
```

ログイン画面が表示されますので、ログインします。
「このアプリ連携を許可しますか？」という画面が表示されますので、「許可する」をクリックすると、指定したリダイレクト先へリダイレクトします。

このとき、ブラウザのアドレスバーのクエリストリングに `code=<authorization code>` が付与されます。
CSRF 防止のため、リダイレクト前の **state** の値と、アドレスバーのクエリストリングに付与された `state=<state>` の値が同一かどうか確認します。

#### 2. アクセストークンの取得

1 で取得した Authorization code を使用して、アクセストークンを取得します。

```
curl -F grant_type=authorization_code \
     -F code=<authorization code> \
     -F client_id=<client id> \
     -F client_secret=<client secret> \
     -F state=<random_state> \
     -F nonce=<random_nonce> \
     -F redirect_uri=http%3A%2F%2F127.0.0.1%3A8080%2FCallback \
     -X POST https://<eccube-host>/OAuth2/v0/token
```

以下のようなアクセストークン及びリフレッシュトークン、 `id_token` が取得できます。

```
{
  "access_token":"e5b0a9a885eb2a5a4aacff3b3a11596e346b9703",
  "expires_in":3600,
  "token_type":"bearer",
  "scope":"product_read product_write openid offline_access",
  "refresh_token":"0e3f3741514240f48d180f3cbf03d53410f064ef",
  "id_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjU2LjEwMTo4MDgxIiwic3ViIjoiNG53c25ic3pJSDRYdVFuWHdpZ3RQOEhhS1FwamVHeDQ5OXMwQTlJMXFrbyIsImF1ZCI6IjJlODE1MzAyM2Q2YWZiMmZiMjk5MzFkYmY5YTI3NWVkNDcxNWYzODQiLCJpYXQiOjE0NjA1MzU1MjMsImV4cCI6MTQ2MDUzOTEyMywiYXV0aF90aW1lIjoxNDYwNTM1NTIzLCJub25jZSI6InJhbmRvbV9ub25jZSJ9.D3RE1i-Oc_bCANI28BwqT-6voLk645kqGZCs3PCOfDRATUX6_hvyBOc3PvfrH6BCaNfYX8m8sGQPD2g-GRUJ-j6OMCHp1KHcycsN5OS6QoZOucvM_gDKITivwW0q3BvLYsc-zK00DRlYuAhSW1pCqdWGRGk-3LWbqfasttYvx34KoSazfCsIyMqxC_zQ4qDoYaReeuCjiMX1xW3vXueEidMQ9_5s7SQgJwtwMnqOdDoEHUQce65wWa2yNXBHaohrGwXmg9Sbd5pD_Anhrh7WIAnYEbDoHc1rb40oUT-kye5cplYUTd4F9y88PnyXeWN3-vGRVxsvMRdJQmiTqzwVvA"
}
```

#### 3. id_token の検証

2 で取得した `id_token` を[検証](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#SelfIssuedValidation)します。
[tokeninfo](#tokeninfo) エンドポイントや [jwt.io](https://jwt.io/) を使用することができます。

#### 4. APIアクセス

アクセストークンを使用して APIアクセスします。

```
curl -H "Accept: application/json" \
     -H "Content-type: application/json" \
     -H 'Authorization: Bearer <access token>' \
     -X GET https://<eccube-host>/api/v0/product
```

#### 5. アクセストークンの更新

アクセストークンの有効期限が切れた場合は、リフレッシュトークンを使用して、アクセストークンを更新します。
`scope=openid` の場合は `offline_access` を scope に追加する必要があります。

```
curl -F grant_type=refresh_token \
     -F refresh_token=<refresh token> \
     -F client_id=<client id> \
     -F client_secret=<client secret> \
     -X POST https://<eccube-host>/OAuth2/v0/token
```

## 実装について

### EC-CUBE独自に実装しているもの

#### tokeninfo

`/OAuth2/tokeninfo?id_token=<id_token>` へ GET リクエストをすると、 `id_token` の詳細情報を JSON 形式で取得できます。

```json
{
  "iss":"https:\/\/example.com",
  "sub":"4nwsnbszIH4XuQnXwigtP8HaKQpjeGx499s0A9I1qko",
  "aud":"2e8153023d6afb2fb29931dbf9a275ed4715f384",
  "iat":1460535523,
  "exp":1460539123,
  "auth_time":1460535523,
  "nonce":"random_nonce"
}
```

- **iss** - ID トークンの発行元。
- **sub** - ユーザー識別子。 `id_token` の公開鍵から生成される。
- **aud** - ID トークンの想定されるオーディエンス。 OAuth2.0 Client ID が使用される。
- **iat** - ID トークン発行時刻の UNIX タイムスタンプ。
- **exp** - ID トークン有効期限の UNIX タイムスタンプ。
- **auth_time** - 認証の発生時刻の UNIX タイムスタンプ。
- **nonce** - クライアントセッションの識別子。リプレイスアタック防止のために使用する。

この情報を元に、以下のような内容を検証する必要があります。[参考](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#SelfIssuedValidation)

- **iss** の値が API の認証をしたホスト名と一致することを確認します。
- **sub** の値が `id_token` の公開鍵の *thumbprint* と一致することを確認します。[JOSE_JWK::thumbprint()](https://github.com/gree/jose/blob/master/src/JOSE/JWK.php#L35) などで検証できます。
- **aud** の値が Client ID と一致することを確認します。
- **iat** の値が、`現在のUNIXタイムスタンプ値 - 600秒` 以上であることを確認します。
- **exp** の値が、現在時刻のUNIXタイムスタンプ値より大きいことを確認します。
- **nonce** の値が、クライアントで保持している `nonce` の値と同一であることを確認します。リプレイスアタック防止のため、セッションで保持している `nonce` を破棄します。

#### Member/Customer と OAuth2.0 Client の関係

- ログイン中の Member/Customer と OAuth2.0 Client の ID が相違している場合は、認可リクエスト時に `access_denied` エラーとなります。

### 標準仕様に準拠しているもの

#### ID Token

[RFC7519 JSON Web Token](http://openid-foundation-japan.github.io/draft-ietf-oauth-json-web-token-11.ja.html) を使用しています。

#### OAuth2.0 Authorization Code Flow

[RFC6749 Authorization Code Grant](http://openid-foundation-japan.github.io/rfc6749.ja.html#grant-code) を使用しています。

- 本APIでは **state パラメータは必須** となっています。

#### OAuth2.0 Implicit Code Flow

[RFC6749 Implicit Grant](http://openid-foundation-japan.github.io/rfc6749.ja.html#grant-implicit) を使用しています。

- 本APIでは **state パラメータは必須** となっています。

#### OpenID Connect Authorization Code Flow

[OpenID Connect Core Authorization Code Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#CodeFlowAuth) を使用しています。

- 本APIでは **state パラメータは必須** となっています。

#### OpenID Connect Implicit Code Flow

[OpenID Connect Core Implicit Code Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#ImplicitFlowAuth) を使用しています。

- 本APIでは **state パラメータは必須** となっています。
- `response_type=id_token 及び response_type=id_token token` の場合、 **nonce パラメータは必須** となっています。

#### UserInfo Endpoint

[OpenID Connect UserInfo Endpoint](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#UserInfo) を使用しています。

- この Endpoint を使用する場合は `scope=openid` で認証する必要があります。
- 以下の scope を使用して、 [各種クレーム](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#Claims) の取得が可能です。
  - profile
  - email
  - address
  - phone
