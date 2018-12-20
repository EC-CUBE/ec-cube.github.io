---
title: インストール方法
keywords: install
tags: [quickstart, install]
sidebar: home_sidebar
permalink: quickstart_install
forder: quickstart
---

## インストール方法

EC-CUBEのインストールは、以下の2種類の方法があります。

- パッケージを使用してインストールする
- コマンドラインからインストールする
- Webインストーラでインストールする

## パッケージを使用したインストール

[EC-CUBE 4のパッケージ](http://downloads.ec-cube.net/src/eccube-4.0.0-rc.zip)をダウンロードし、解凍してください。

FTP/SSHを使用し、ファイルをサーバへアップロードしてください。  
※ファイル数が多いためエラーが発生することがございます。エラー発生時は分割してアップロードをお願いします。

データベースを作成し、webサーバを起動してください。

ブラウザからEC-CUBEにアクセスします。  
※3系ではEC-CUBEをアップロードしたディレクトリ配下のhtmlディレクトリへアクセスする必要がありましたが、4.0系ではEC-CUBEをアップロードしたディレクトリへ直接アクセスしてください。
- 3系の場合: `http://example.com/{EC-CUBEをアップロードしたディレクトリ}/html`
- 4系の場合: `http://example.com/{EC-CUBEをアップロードしたディレクトリ}`

webインストーラが表示されますので必要な情報を入力してインストールします。

## コマンドラインでのインストール

前提として、 [Composer のインストール](https://getcomposer.org/download/) が必要です。

```
php composer.phar create-project ec-cube/ec-cube ec-cube "4.0.x-dev" --keep-vcs
```

上記の例では、データベースに SQLite3 が選択されます。

ec-cube ディレクトリに移動し、 `bin/console server:run` コマンドを実行すると、ビルトインウェブサーバーが起動します。

```
cd ec-cube
bin/console server:run
```

[http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) にアクセスし、 EC-CUBE の管理ログイン画面が表示されればインストール成功です。以下の ID/Password にてログインしてください。

`ID: admin PW: password`

*終了する場合は Ctrl+C を押してください*

### データベースの種類を変更したい場合

インストール後、 `bin/console eccube:install` コマンドを実行し、 `Database Url` を以下のように設定してください。

```
## for MySQL
mysql://<user>:<password>@<host>/<database name>

## for PostgreSQl
postgres://<user>:<password>@<host>/<database name>
```

## Webインストーラーを利用したインストール

前提として、 [Composer のインストール](https://getcomposer.org/download/) が必要です。

```
php composer.phar create-project --no-scripts ec-cube/ec-cube ec-cube "4.0.x-dev" --keep-vcs
```

ec-cube ディレクトリに移動し、 `bin/console server:run` コマンドを実行すると、ビルトインウェブサーバーが起動します。

```
cd ec-cube
bin/console server:run
```

[http://127.0.0.1:8000/](http://127.0.0.1:8000/) にアクセスすると、 Webインストーラが表示されますので、指示にしたがってインストールしてください。

## 本番環境での .env ファイルの利用について

インストール完了後、インストールディレクトリにデータベースの接続情報等が設定された **.env** ファイルが生成されます。
**.env** ファイルは、開発用途での環境変数を設定するためのものであり、本番環境での使用は推奨されません。
本番環境では、環境変数をサーバー設定ファイルに設定することを推奨します。
サーバー設定ファイルに環境変数を設定することにより、環境変数が外部に暴露される危険性が減り、安全に運用できます。

### Apache での設定例

httpd.conf や、 .htaccess ファイルに設定します。

```
SetEnv APP_ENV prod
SetEnv APP_DEBUG 0
SetEnv DATABASE_URL pgsql://dbuser:password@127.0.0.1/cube4_dev
SetEnv DATABASE_SERVER_VERSION 10.5
SetEnv ECCUBE_AUTH_MAGIC 8PPlCHZVdH5vbMkIUKeuTeDHycQQMuaB
SetEnv ECCUBE_ADMIN_ALLOW_HOSTS []
SetEnv ECCUBE_FORCE_SSL false
SetEnv ECCUBE_ADMIN_ROUTE admin
SetEnv ECCUBE_COOKIE_PATH /
```

[参考: Apache HTTP サーバ バージョン 2.4 - SetEnv ディレクティブ](https://httpd.apache.org/docs/2.4/ja/mod/mod_env.html#setenv)

### IIS での設定例

ApplicationHost.config の environmentVariables セクションに設定します。このファイルは `C:\Windows\System32\Inetsrv\Config` にあります。
PHP実行ファイルのパスは適宜変更してください。

```
<fastCgi>
    <application fullPath="C:\Program Files\PHP\v7.2\php-cgi.exe" activityTimeout="600" requestTimeout="600" instanceMaxRequests="10000">
        <environmentVariables>
            <environmentVariable name="PHP_FCGI_MAX_REQUESTS" value="10000" />
            <environmentVariable name="PHPRC" value="C:\Program Files\PHP\v7.2" />
            <environmentVariable name="APP_ENV" value="prod" />
            <environmentVariable name="APP_DEBUG" value="0" />
            <environmentVariable name="DATABASE_URL" value="pgsql://dbuser:password@127.0.0.1/cube4_dev" />
            <environmentVariable name="DATABASE_SERVER_VERSION" value="10.5" />
            <environmentVariable name="ECCUBE_AUTH_MAGIC" value="8PPlCHZVdH5vbMkIUKeuTeDHycQQMuaB" />
            <environmentVariable name="ECCUBE_ADMIN_ALLOW_HOSTS" value="[]" />
            <environmentVariable name="ECCUBE_FORCE_SSL" value="false" />
            <environmentVariable name="ECCUBE_ADMIN_ROUTE" value="admin" />
            <environmentVariable name="ECCUBE_COOKIE_PATH" value="/" />
        </environmentVariables>
    </application>
<!-- /追加 -->
</fastCgi>
```

[参考: IIS コンフィギュレーション リファレンス](https://msdn.microsoft.com/ja-jp/library/ee431592.aspx#EDA)

### サーバー設定ファイルに環境変数を設定した場合の注意事項

サーバー設定ファイルに環境変数を設定した場合、 以下の機能を管理画面から設定することができません。

**サーバー設定ファイルの環境変数を変更し、キャッシュクリアする必要がありますのでご注意ください。**

- 管理画面→オーナーズストア→テンプレート
- 管理画面→設定→システム設定→セキュリティ管理

## パーミッションの設定について

EC-CUBE の便利な機能のいくつかは、webサーバーがファイルに書き込みできることに基づいています。
しかし、アプリケーションがファイルに書き込み権限を持つことは危険です。
セキュリティの観点からベストなのは、パーミッションを可能な限り制限して特定のディレクトリ・ファイルのみに書き込み権限を与えることです。

ここでは「管理画面の機能を全て使える」条件での推奨のパーミッション設定について記載します。

EC-CUBEでは以下のディレクトリ・ファイルにwebサーバからの書き込み権限が必要です。

```
[eccube_root/]
  │
  ├──[app/]
  │   ├──[Plugin/]
  │   ├──[PluginData/]
  │   ├──[proxy/]
  │   └──[template/]
  ├──[html/]
  ├──[var/]
  ├──[vendor/]
  ├──[composer.json]
  └──[composer.lock]
```

その他のディレクトリ・ファイルには読み取り権限が必要です。

### eccube_root/

EC-CUBEのルートディレクトリに書き込み権限が必要です。
ルートディレクトリ配下には `.env` ファイルや '.maintenance' ファイル等が配置されます。
**ルートディレクトリ配下は別の推奨権限がありますので一括権限変更しないようにご注意ください。**

### app/

ディレクトリに書き込み権限が必要です。
配下のディレクトリに書き込み権限が必要なためです。

### app/Plugin/

ディレクトリに書き込み権限が必要です。
プラグインのソースコードが配置されます。

### app/PluginData/

ディレクトリに書き込み権限が必要です。
プラグインのデータが配置されます。

### app/proxy/

ディレクトリ配下に書き込み権限が必要です。
Entity拡張で生成されるproxyファイルが配置されます。

### app/template/

ディレクトリ配下に書き込み権限が必要です。
テンプレートファイルが配置されます。

### html/

ディレクトリ配下に書き込み権限が必要です。
cssファイルやjsファイル等が配置されます。

### var/

ディレクトリ配下に書き込み権限が必要です。
キャッシュやログなどの一時ファイルが配置されます。

### vendor/

ディレクトリ配下に書き込み権限が必要です。
プラグインインストール時にライブラリがインストールされます。

### composer.json / composer.lock

ファイルに書き込み権限が必要です。
プラグインインストール時に更新されます。

### パーミッションの設定例

| ディレクトリ・ファイル | 必要な権限 | 設定例 |
|--------------------|----------|-------|
| eccube_root/ <br> app/ <br>  app/Plugin/ <br>  app/PluginData/ <br>  app/proxy/ <br>  app/template/ <br>  html/ <br>  var/ <br> vendor/ | 読み取り、書き込み | 707(rwx---rwx) |
| その他のディレクトリ | 読み取り | 705(rwx---r-x) |
| composer.json <br> composer.lock | 読み取り、書き込み | 706(rwx---rw-) |
| その他のファイル | 読み取り | 704(rwx---r--) |

権限が必要なロールはサーバの仕様によって異なります。

### 本体のバージョンアップについて

バージョンアッププラグインにてEC-CUBE本体をバージョンアップする場合は全ファイルにwebサーバからの書き込み権限が必要になります。
バージョンアップの際は一時的に書き込み権限を付与していただき、アップデート後は推奨のパーミッション設定に戻してください。

### bin/consoleについて

EC-CUBEのコマンドを利用する場合は `bin/console` に実行権限を付与してください。
