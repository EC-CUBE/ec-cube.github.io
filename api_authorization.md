---
layout: default
title: Web API Authorization ガイド
---

---

# Web API Authorization ガイド

## 概要

EC-CUBE で Web API を実行する際、一般公開された情報を参照する場合は必要ありませんが、顧客情報を参照したり、受注情報を更新する場合などは認証が必要です。

EC-CUBE3 では、 [OpenID Connect](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html) を使用した認証をサポートしています。

## 対応するフロー

- [Authorization Code Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#CodeFlowAuth) - 主にWebアプリ向け
- [Implicit Flow](http://openid-foundation-japan.github.io/openid-connect-core-1_0.ja.html#ImplicitFlowAuth) - 主にJavaScript、 ネイティブアプリ向け

信頼性の確保された、プライベート環境で使用する場合は、 [OAuth2 Authorization](http://openid-foundation-japan.github.io/rfc6749.ja.html) も使用可能です。

## 設定方法

### 管理者権限での実行

1. 管理画面にログインし、メンバー管理画面へ遷移します。
2. **APIクライアント一覧** をクリックし、 APIクライアントを新規登録します。
    - **アプリケーション名** には任意の名称を入力します
    - **redirect_uri** には、Authorization Endpoint からのリダイレクト先の URL を入力します。
3. 登録が終わると、 `client_id`, `client_secret` などが発行されます。公開鍵は id_token を検証する際に使用します。

### 顧客(Customer)での実行

TODO

## サンプルクライアント

- [Symfony2 での実装例](https://github.com/nanasess/eccube3-oauth2-client)
