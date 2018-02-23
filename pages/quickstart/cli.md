---
title: インストール方法
keywords: howto install 
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_install
forder: quickstart
---

## 事前準備

- 予めMySQLもしくはPostgreSQLでデータベースを作成しておいて下さい。
- サイトのDocumentRootが、EC-CUBEのhtmlのフォルダとなるように設定してください  

※DocumentRootが変更できない場合は、トップページのURLは「http://サイトURL/html/」となります。  
※ただし、3.0.11以降では[こちらの手順](/quickstart_remove-html)を行うことで、URLからhtmlを無くした状態でインストールできるようになりました。


## インストール方法

EC-CUBEのインストールは、以下の2種類の方法があります。

- インストールスクリプトでインストールする
- Webインストーラでインストールする

## インストールスクリプトを利用したインストール方法

`eccube_install.php`で、コマンドラインからインストールすることができます。

以下のように実行してください。

`php eccube_install.php [mysql|pgsql|sqlite3] [none] [options]`

以下はコマンドの実行例です。

PostgreSQLの場合

```
php eccube_install.php pgsql
```

MySQLの場合

```
php eccube_install.php mysql
```

データベースのホストやデータベース名を変更する場合は、環境変数で指定します。

以下は、DBSERVERとDBNAMEを設定する例です。

```
export DBSERVER=xxx.xxx.xxx.xxx
export DBNAME=eccube_dev_db

php eccube_install.php mysql
```

その他の設定やオプションは、`--help`で確認することができます

```
php eccube_install.php --help
```

インストール完了後、 `http://{インストール先URL}/admin`にアクセス
EC-CUBEの管理ログイン画面が表示されればインストール成功です。以下のID/Passwordにてログインしてください。

`ID: admin PW: password`

また、後述の Webインストーラーは不要なので削除してください。

```
rm html/install.php
```

## Webインストーラーを利用したインストール方法

- composerを利用してソースコードを取得する

```
curl -sS https://getcomposer.org/installer | php
php composer.phar create-project ec-cube/ec-cube ec-cube "^3.0"
```

- Webインストーラーにアクセスする

`http://{インストール先URL}/install.php`にアクセスし、表示されるインストーラーの指示にしたがってインストールしてください。
