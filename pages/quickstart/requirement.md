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
|WebServer|IIS | 8.x |*TBD*|
|WebServer|Apache |2.4.x <br> (mod_rewrite / mod_ssl 必須) |*TBD*|
|PHP | PHP | 7.0.8 〜 |*TBD*|
|Database|PostgreSQL| 9.2.x 〜 <br> (pg_settingsテーブルへの参照権限 必須) |*TBD*|
|Database|MySQL|5.5.x / 5.6.x / 5.7.x <br> (InnoDBエンジン 必須) |*TBD*|
|Database|SQLite(開発用途向け) |3.x |*TBD*|

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
