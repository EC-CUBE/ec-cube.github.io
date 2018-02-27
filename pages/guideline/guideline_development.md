---
title: 開発環境構築
keywords: 開発環境の構築
tags: [quickstart, guideline]
sidebar: home_sidebar
permalink: guideline_development
summary: EC-CUBE 3を開発するための環境構築手順を説明します
folder: guideline
---

## 開発用環境の構築

### GitHub からソースコードを取得して開発を始める
GitHubからEC-CUBE3をダウンロードすると、ダウンロードした時点での最新状態のEC-CUBE3で開発が行えます。  
こちらはリリースにまだ含まれていない機能追加・修正が含まれていることがあります。

1. composer のインストール

こちら [https://getcomposer.org/download/](https://getcomposer.org/download/){:target="_blank"} を参考に、 composer をインストールしておきます。

2. ソースコードの取得

以下のコマンドを実行します。

```
composer create-project ec-cube/ec-cube ec-cube "dev-master"
```

最後に、

```
Do you want to remove the existing VCS (.git, .svn..) history? [Y,n]? 
```

と聞かれるので、 n と入力します。


以上で最新のEC-CUBE3が利用できる環境が整います。常にEC-CUBE3のバージョンへ追随したい場合、
[http://qiita.com/chihiro-adachi/items/f31c9d90b1bcc3553c20](http://qiita.com/chihiro-adachi/items/f31c9d90b1bcc3553c20){:target="_blank"} を参考にしてください。

### 公式サイトよりEC-CUBE3をダウンロードし開発を始める
EC-CUBE3の公式サイトからダウンロードして開発を始めるにはアカウントを作成する必要があります。
アカウントを作成されていない方は、[こちら](https://www.ec-cube.net/entry/){:target="_blank"} より新規会員登録をお願いします。  
既にアカウントを作成されている方は、普段お使いのアカウントをご利用ください。


1. 公式サイトからダウンロード  
[http://www.ec-cube.net/download/](http://www.ec-cube.net/download/){:target="_blank"} から最新のEC-CUBE3をダウンロードします。

1. 必要なライブラリをインストール  
公式サイトよりダウンロードしたEC-CUBE3には開発時に便利なライブラリが含まれておらず、
開発する際には色々と不便なため、 GitHubからダウンロードし開発を始めるの2、3を参考にしてcomposerのインストール、実行を行ってください。

## 実行環境の構築

### ビルトインウェブサーバを利用した実行環境構築

php5.4から[ビルトインウェブサーバ](http://php.net/manual/ja/features.commandline.webserver.php){:target="_blank"}と呼ばれる機能が提供されており、この機能を使用することで簡単にEC-CUBE3の実行環境が作成できます。

ビルトインウェブサーバを実行するには以下のコマンドを実行します。

```
php -S localhost:8000 -t html html/index.php
```

これだけで、ブラウザから`http://localhost:8000/`にアクセスするとEC-CUBE3が動作します。

また、インストール時にデータベースとして SQLite を選択することで、MySQLやPostgreSQLを用意せず開発環境が作成可能です。

※ ビルトインウェブサーバやSQLLiteは本番環境では推奨されておらず、開発環境のみでご利用ください。

### 他の実行環境構築
- MAMPを利用した環境構築  
[http://amidaike.hatenablog.com/entry/2015/07/02/015914](http://amidaike.hatenablog.com/entry/2015/07/02/015914){:target="_blank"}

- XAMPPを利用した環境構築  
[http://qiita.com/chihiro-adachi/items/5fb2175454d3bfa047ac](http://qiita.com/chihiro-adachi/items/5fb2175454d3bfa047ac){:target="_blank"}


