---
title: システム要件
keywords: sample homepage
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_requirement
---


# システム要件

| 分類 | ソフトウェア|Version|動作確認済み|
|---|-------|---|-------|
|WebServer|Apache |2.4.x <br> (mod_rewrite / mod_ssl 必須) |2.4.6|
|PHP | PHP | 7.1 〜 |7.1.20|
|Database|PostgreSQL| 9.2.x / 10.x <br> (pg_settingsテーブルへの参照権限 必須) |9.6.6|
|Database|MySQL|5.5.x / 5.6.x / 5.7.x <br> (InnoDBエンジン 必須) |5.6.33|
|Database|SQLite(開発用途向け) |3.x |-|

※ 4.0.0, 4.0.1 は、PHP7.3で動作いたしません。PHP7.3をご利用の場合、4.0.2以降のバージョンをご使用ください。

[4.0.0, 4.0.1をお使いの方はPHP7.3をご利用の前に4.0.2以降へアップデートください。](http://doc4.ec-cube.net/quickstart_update)

# PHPライブラリ

| 分類 | ライブラリ|
|---|---|
|必須ライブラリ|pgsql / mysqli (利用するデータベースに合わせること) <br> pdo_pgsql / pdo_mysql / pdo_sqlite (利用するデータベースに合わせること) <br> pdo <br> phar <br> mbstring <br> zlib <br> ctype <br> session <br> JSON <br> xml <br> libxml <br> OpenSSL <br> zip <br> cURL <br> fileinfo <br> intl |
|推奨ライブラリ|hash <br> APCu / WinCache (利用する環境に合わせること) <br> Zend OPcache |

# 動作確認ブラウザ

管理画面と標準のフロントテンプレート

| OS | ブラウザ|
|---|-------|
|Windows(Windows7以降) | Internet Explorer11以降|
||FireFox 最新 |
||Google Chrome 最新 |
|Mac(OS X以降)|Safari 最新|
|iOS (10以降)|Safari 最新|
|Android (4.4以降)| 標準ブラウザ 最新|
