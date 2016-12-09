---
title: インストール方法
keywords: howto install 
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_install
---

## 事前準備

- 予めMySQLもしくはPostgreSQLでデータベースを作成しておいて下さい。
- サイトのDocumentRootが、EC-CUBEのhtmlのフォルダとなるように設定してください  

※DocumentRootが変更できない場合は、トップページのURLは「http://サイトURL/html/」となります。  
※ただし、3.0.11以降では[こちらの手順](/remove_html.html)を行うことで、URLからhtmlを無くした状態でインストールできるようになりました。


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



