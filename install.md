---
layout: default
title: インストール方法
---

---

# インストール方法

## 事前準備

- 予めMySQLもしくはPostgreSQLでデータベースを作成しておいて下さい。
- htmlのフォルダが、DocumentRootとなるように設置してください
- htmlがDocumentRootでない場合は、http://{DocumentRoot}/{htmlへのパス} となります。

## インストール方法

EC-CUBEのインストールは、以下の2種類の方法があります。

- シェルスクリプトインストーラー
- Webインストーラー

## シェルスクリプトインストーラーを利用したインストール方法

`eccube_install.sh`の51行目付近、Configuration以下の設定内容を、環境に応じて修正し、実行してください。

- PostgreSQLの場合

```
eccube_install.sh pgsql
```

- MySQLの場合

```
eccube_install.sh mysql
```

インストール完了後、 `http://{インストール先URL}/admin`にアクセス
EC-CUBEの管理ログイン画面が表示されればインストール成功です。以下のID/Passwordにてログインしてください。

`ID: admin PW: password`

## Webインストーラーを利用したインストール方法

- composerを利用して外部ライブラリをインスールする

```
curl -sS https://getcomposer.org/installer | php
php ./composer.phar install --dev --no-interaction
```

- Webインストーラーにアクセスする

`http://{インストール先URL}/install/`にアクセスし、表示されるインストーラーの指示にしたがってインスールしてください。




