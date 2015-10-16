---
layout: default
title: 開発・デバッグTips
---

---

# {{ page.title }}

## デバッグモードの有効化

通常 / や/index.phpでアクセスしているところを /index_dev.php と書き換えてアクセスすることにより、デバッグモードが有効になります。 デバッグモードでは、開発の手助けになる、WebProfilerやDebug情報が出力されるようになります。

```You are not allowed to access this file. Check index_dev.php for more information.```
のようなエラーが表示される場合

index_dev.phpを開き、アクセス元のIPを以下の配列に追加してください。
```
$allow = array(
    '127.0.0.1',
    'fe80::1',
    '::1',
);
```

## 開発と本番でconfig.ymlを使い分ける
app/config/eccube 直下に config_dev.yml を用意することで開発環境だけの値を利用することができます。

https://github.com/EC-CUBE/ec-cube/issues/207

## メールの設定方法
インストール画面でsmtpのメールサーバ設定を行うと以下の内容が作成されます。  

```
mail:
    transport: smtp
    host: ドメイン名
    port: 587
    username: ユーザー名
    password: パスワード
    encryption: null
    auth_mode: null
```

この例ではportはOP25B対策しています。  
SSLを使われている場合、
```encryption```に```ssl```または```tls```を設定する必要があります。

Gmailの場合、

```
mail:
    transport: smtp
    host: smtp.gmail.com
    port: 465
    username: GMAILのユーザー名
    password: GMAILのパスワード
    encryption: ssl
    auth_mode: login
```

という設定で送信可能ですがGmail側で安全性の低いアプリへのアクセスを有効にする必要があります。


## メールの誤送信防止機能

config.ymlまたはconfig_dev.yml に delivery_addressを追加することで
メール誤送信を防ぐことが可能です。
delivery_addressにメールアドレスが設定されていればそのアドレスのみにメール送信されます。
但し、この機能はデバッグ環境(index_dev.phpからのみ)でしか有効になりませんのでご注意ください。

https://github.com/EC-CUBE/ec-cube/issues/195


## コンソールコマンドについて

ver3.0.1からコンソールコマンドとして、

```
php app/console router:debug
php app/console cache:clear
```
が用意されています。

```router:debug``` の方は現在登録されているrouting情報が一覧表示されます。
```cache:clear``` はapp/cache配下のキャッシュがsession情報を除いて削除され、
```cache:clear --all``` と ```--all``` を指定するとsessionのキャッシュも含めて全て削除されます。



