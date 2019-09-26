---
title: インストール方法
keywords: install
tags: [quickstart, install]
sidebar: home_sidebar
permalink: quickstart_install
forder: quickstart
---

## インストール方法

EC-CUBEのインストールは、以下の方法があります。

1. パッケージを使用してインストールする
1. コマンドラインからインストールする
1. Webインストーラでインストールする
1. Dockerを使用してインストールする

### パッケージを使用してインストールする

[EC-CUBE 4のパッケージ](https://www.ec-cube.net/download/)をダウンロードし、解凍してください。

FTP/SSHを使用し、ファイルをサーバへアップロードしてください。  
※ファイル数が多いためエラーが発生することがございます。エラー発生時は分割してアップロードをお願いします。

データベースを作成し、webサーバを起動してください。

ブラウザからEC-CUBEにアクセスします。  
※3系ではEC-CUBEをアップロードしたディレクトリ配下のhtmlディレクトリへアクセスする必要がありましたが、4.0系ではEC-CUBEをアップロードしたディレクトリへ直接アクセスしてください。
- 3系の場合: `http://example.com/{EC-CUBEをアップロードしたディレクトリ}/html`
- 4系の場合: `http://example.com/{EC-CUBEをアップロードしたディレクトリ}`

Webインストーラが表示されますので、指示にしたがってインストールしてください。

### コマンドラインからインストールする

**開発環境としておすすめの方法です。**

前提として、 [Composer のインストール](https://getcomposer.org/download/){:target="_blank"} が必要です。

```shell
php composer.phar create-project ec-cube/ec-cube ec-cube "4.0.x-dev" --keep-vcs
```

+ 初期状態では SQLite3 を使用します

ec-cube ディレクトリに移動し、 `bin/console server:run` コマンドを実行すると、ビルトインウェブサーバが起動します。

```shell
cd ec-cube
bin/console server:run
```

[http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) にアクセスし、 EC-CUBE の管理ログイン画面が表示されればインストール成功です。  
以下の ID/Password にてログインしてください。

`ID: admin PW: password`

*ビルトインウェブサーバを終了する場合は `Ctrl+C` を押してください*

#### データベースの種類を変更したい場合

インストール後、 `bin/console eccube:install` コマンドを実行し、 `Database Url` を以下のように設定してください。

```shell
## for MySQL
mysql://<user>:<password>@<host>/<database name>

## for PostgreSQl
postgres://<user>:<password>@<host>/<database name>
```

#### Windows 環境を使用する場合

`bin/console eccube:install` コマンドは使用できません。
代替として、以下のコマンド使用して下さい。

```shell
# (optional) データベース削除
bin/console doctrine:database:drop --force
# データベース作成
bin/console doctrine:database:create
# (optional) スキーマ削除
bin/console doctrine:schema:drop --force
# スキーマ生成
bin/console doctrine:schema:create
# 初期データ生成
bin/console eccube:fixtures:load
```

- *`bin/console eccube:install` コマンドでは、これらのコマンドを内部的に実行しています。*
- Symfony と Windows 環境の相性があまり良くないため、動作が大変遅くなる可能性があります。 [Dockerを使用したインストール](http://doc4.ec-cube.net/quickstart_install#docker%E3%82%92%E4%BD%BF%E7%94%A8%E3%81%97%E3%81%9F%E3%82%A4%E3%83%B3%E3%82%B9%E3%83%88%E3%83%BC%E3%83%AB) をおすすめします。

### Webインストーラでインストールする

前提として、 [Composer のインストール](https://getcomposer.org/download/){:target="_blank"} が必要です。

```shell
php composer.phar create-project --no-scripts ec-cube/ec-cube ec-cube "4.0.x-dev" --keep-vcs
```

ec-cube ディレクトリに移動し、 `bin/console server:run` コマンドを実行すると、ビルトインウェブサーバが起動します。

```shell
cd ec-cube
bin/console server:run
```

[http://127.0.0.1:8000/](http://127.0.0.1:8000/) にアクセスすると、 Webインストーラが表示されますので、指示にしたがってインストールしてください。

### Dockerを使用してインストールする

前提として、 [Docker Desktop のインストール](https://hub.docker.com){:target="_blank"} が必要です。

+ 初期状態では SQLite3 を使用します
+ コンテナ上のファイルを使用しても、VOLUME をマウントしても使用可能です

```shell
cd path/to/ec-cube
docker build -t eccube4-php-apache .

## コンテナ上のファイルを使用する場合
docker run --name ec-cube -p "8080:80" -p "4430:443" eccube4-php-apache

## ローカルディレクトリをマウントする場合
# var 以下をマウントすると強烈に遅くなるため、 src, html, app 以下のみをマウントする
docker run --name ec-cube -p "8080:80" -p "4430:443"  -v "$PWD/html:/var/www/html/html:cached" -v "$PWD/src:/var/www/html/src:cached" -v "$PWD/app:/var/www/html/app:cached" eccube4-php-apache
```

**2回目以降の起動時は、以下のコマンドを実行します。**

```shell
docker start --attach ec-cube
```

#### 設定ファイルを編集する場合

.env など、インストールディレクトリ直下のファイルを編集する場合は、コンテナ上のファイルを直接編集するか、個別にマウントする必要があります

```shell
docker exec -it ec-cube /bin/bash
root@de5372ce7139:/var/www/html# vi .env
```

#### メール送信を使用する場合

mailcatcher を使用します

```shell
## .env にて MAILER_URL=smtp://mailcatcher:1025 としておく
docker run -d -p 1080:1080 -p 1025:1025 --name mailcatcher schickling/mailcatcher
docker run --name ec-cube -p "8080:80" -p "4430:443"  --link mailcatcher:mailcatcher eccube4-php-apache
```

#### PostgreSQL を使用する場合

```shell
## .env にて DATABASE_URL=pgsql://postgres:password@db/cube4_dev としておく
docker run --name container_postgres -e POSTGRES_PASSWORD=password  -p 5432:5432 -d postgres
docker run --name ec-cube -p "8080:80" -p "4430:443" --link container_postgres:db eccube4-php-apache
```

#### MySQL を使用する場合

```shell
## .env にて DATABASE_URL=mysql://root:password@db/cube4_dev としておく
docker run --name container_mysql -e MYSQL_ROOT_PASSWORD=password  -d -p 3306:3306 mysql:5.7
docker run --name ec-cube -p "8080:80" -p "4430:443" --link container_mysql:db eccube4-php-apache
```

## 本番環境での .env ファイルの利用について

インストール完了後、インストールディレクトリにデータベースの接続情報等が設定された **.env** ファイルが生成されます。
**.env** ファイルは、開発用途での環境変数を設定するためのものであり、本番環境での使用は推奨されません。
本番環境では、環境変数をサーバ設定ファイルに設定することを推奨します。
サーバ設定ファイルに環境変数を設定することにより、環境変数が外部に暴露される危険性が減り、安全に運用できます。

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

```xml
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

### サーバ設定ファイルに環境変数を設定した場合の注意事項

サーバ設定ファイルに環境変数を設定した場合、 以下の機能を管理画面から設定することができません。

**サーバ設定ファイルの環境変数を変更し、キャッシュクリアする必要がありますのでご注意ください。**

- 管理画面→オーナーズストア→テンプレート
- 管理画面→設定→システム設定→セキュリティ管理

## パーミッションの設定について

EC-CUBE の便利な機能のいくつかは、webサーバがファイルに書き込みできることに基づいています。
しかし、アプリケーションがファイルに書き込み権限を持つことは危険です。
セキュリティの観点からベストなのは、パーミッションを可能な限り制限して特定のディレクトリ・ファイルのみに書き込み権限を与えることです。

### webサーバの書き込み権限

EC-CUBEの全ての機能を利用するためには以下のディレクトリ・ファイルにwebサーバからの書き込み権限が必要です。

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

#### eccube_root/

EC-CUBEのルートディレクトリにwebサーバの書き込み権限が必要です。
ルートディレクトリ配下には `.env` ファイルや `.maintenance` ファイル等が配置されます。
**ルートディレクトリ配下は別の推奨権限がありますので一括権限変更しないようにご注意ください。**

#### app/

ディレクトリにwebサーバの書き込み権限が必要です。
配下のディレクトリにwebサーバの書き込み権限が必要なためです。

#### app/Plugin/

ディレクトリにwebサーバの書き込み権限が必要です。
プラグインのソースコードが配置されます。

#### app/PluginData/

ディレクトリにwebサーバの書き込み権限が必要です。
プラグインのデータが配置されます。

#### app/proxy/

ディレクトリ配下にwebサーバの書き込み権限が必要です。
Entity拡張で生成されるproxyファイルが配置されます。

#### app/template/

ディレクトリ配下にwebサーバの書き込み権限が必要です。
テンプレートファイルが配置されます。

#### html/

ディレクトリ配下にwebサーバの書き込み権限が必要です。
cssファイルやjsファイル等が配置されます。

#### var/

ディレクトリ配下にwebサーバの書き込み権限が必要です。
キャッシュやログなどの一時ファイルが配置されます。

#### vendor/

ディレクトリ配下にwebサーバの書き込み権限が必要です。
プラグインインストール時にライブラリがインストールされ、クラスマップが更新されます。

#### composer.json / composer.lock

ファイルにwebサーバの書き込み権限が必要です。
プラグインインストール時に更新されます。

#### パーミッションの設定例

権限が必要なロールはサーバの仕様によって異なります。
例えば共有サーバ等の場合、ファイルを設置するFTPユーザとwebサーバの実行ユーザが異なる場合があります。
この場合、webサーバはOtherでの権限でアクセスすることになりますので、EC-CUBEの機能を利用するためにはOtherに対して適切に書き込み権限を設定する必要があります。

| ディレクトリ・ファイル | webサーバに必要な権限 | 設定例 |
|--------------------|----------|-------|
| eccube_root/ <br> app/ <br>  app/Plugin/ <br>  app/PluginData/ <br>  app/proxy/ <br>  app/template/ <br>  html/ <br>  var/ <br> vendor/ | 読み取り、書き込み | 707( `rwx---rwx` ) |
| その他のディレクトリ | 読み取り | 705( `rwx---r-x` ) |
| composer.json <br> composer.lock | 読み取り、書き込み | 606( `rw----rw-` ) |
| その他のファイル | 読み取り | 604( `rw----r--` ) |

#### 本体のバージョンアップについて

アップデートプラグインにてEC-CUBE本体をバージョンアップする場合は全ファイルにwebサーバからの書き込み権限が必要になります。
バージョンアップの際は一時的にwebサーバの書き込み権限を付与していただき、アップデート後は推奨のパーミッション設定に戻してください。

#### bin/consoleについて

EC-CUBEのコマンドを利用する場合は `bin/console` に実行権限を付与してください。

### 本番環境でのパーミッション設定

前項ではEC-CUBEの全ての機能を利用するためのwebサーバの書き込み権限について記載いたしました。
本番環境ではさらにパーミッションを制限することで、よりセキュリティリスクを下げることができます。
ただしパーミッションの制限を強くすると一部機能が制限され、利便性が落ちてしまいます。
それぞれのファイル・ディレクトリの役割と制限内容を理解した上でパーミッションの設定をお願いします。

以下のディレクトリ・ファイルにはセキュリティの観点からwebサーバの書き込み権限を付与しないほうが安全です。

```
[eccube_root/]
  │
  ├──[app/]
  │   ├──[Plugin/]
  │   ├──[proxy/]
  │   └──[template/]
  ├──[vendor/]
  ├──[.env]
  ├──[.htaccess]
  ├──[composer.json]
  └──[composer.lock]
```

上記のディレクトリ・ファイルのwebサーバの書き込み権限を制限した場合には以下の機能が制限されます。

- コンテンツ管理
  - ページ管理
  - ブロック管理
  - メンテナンス管理
- 設定
  - 店舗設定
    - 特定商取引法設定
    - 利用規約設定
    - メール設定
  - システム設定
    - セキュリティ管理
- オーナーズストア
  - プラグイン
    - プラグイン一覧
  - テンプレート
    - テンプレート一覧
    - アップロード
  - 設定

#### .env と .htaccess

`.env` はEC-CUBEのインストール時に作成され、EC-CUBEの重要な設定が記載されています。
また、 `.htaccess` にはwebサーバの設定や環境変数等の重要な設定が記載されています。
共に重要な設定が記載されたファイルですので、webサーバからの読み取り権限と書き込み権限のみに制限したほうが安全です。
ファイルの所有者をwebサーバのユーザに設定し、 `400(rw-------)` のパーミッションを設定してください。
本番環境の `.env` ファイルの利用については[本番環境での .env ファイルの利用について](#本番環境での .env ファイルの利用について)も合わせてご覧ください。

#### var/

キャッシュやログ等のEC-CUBEの稼働に必要なファイルが設置されます。
EC-CUBEが稼働するためにはwebサーバの書き込み権限が必要です。

#### app/PluginData/

プラグインのデータを配置するためのディレクトリです。
`app/PluginData/` を利用しているかどうかはプラグインによって異なります。
`app/PluginData/` を利用するプラグインがインストールされている場合にはwebサーバの書き込み権限が必要です。

#### html/

商品等の画像等をアップロードした際に `html/` に配置されます。
webサーバからの書き込み権限を制限すると以下の機能が制限されます。

- 商品管理
  - 商品登録
    - 商品画像
- コンテンツ管理
  - ファイル管理
- 設定
  - 店舗設定
    - 支払方法設定
      - ロゴ画像
