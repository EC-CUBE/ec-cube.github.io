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

[EC-CUBE 4のパッケージ](http://downloads.ec-cube.net/src/eccube-4.0.0-beta2.zip)をダウンロードし、解凍してください。

FTP/SSHを使用し、ファイルをサーバへアップロードしてください。

※ファイル数が多いためエラーが発生することがございます。エラー発生時は分割してアップロードをお願いします。

データベースを作成してください。

webサーバを起動してください。

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
