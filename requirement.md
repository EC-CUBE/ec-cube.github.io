---
layout: default
title: システム要件
---

---

# システム要件

| 分類 | ソフトウェア|Version|動作確認済み|
|---|-------|---|-------|
|WebServer|IIS | 8.x | 8.0 |
|WebServer|Apache |2.2.x / 2.4.x <br> (mod_rewrite / mod_ssl 必須) | 2.2.15 |
|PHP | PHP | 5.3.9 ～ 7.0.x |5.4.39 / 7.0.9 |
|Database|PostgreSQL| 8.4.x / 9.x <br> (pg_settingsテーブルへの参照権限 必須) |8.4.20|
|Database|MySQL|5.1.x / 5.5.x / 5.6.x / 5.7.x <br> (InnoDBエンジン 必須) |5.1.73|
|Database|SQLite(開発用途向け) |3.x |3.6.20|

# PHPライブラリ

| 分類 | ライブラリ|
|---|---|
|必須ライブラリ|pgsql / mysql / mysqli (利用するデータベースに合わせること) <br> pdo_pgsql / pdo_mysql / pdo_sqlite (利用するデータベースに合わせること) <br> pdo <br> phar <br> mbstring <br> zlib <br> ctype <br> session <br> JSON <br> xml <br> libxml <br> OpenSSL <br> zip <br> cURL <br> fileinfo |
|推奨ライブラリ|hash <br> APCu / WinCache (利用する環境に合わせること) <br> Zend OPcache <br> mcrypt |

# 動作確認ブラウザ

管理画面と標準のフロントテンプレート

| OS | ブラウザ|
|---|-------|
|Windows(Windows7以降) | Internet Explorer10以降|
||FireFox 最新 |
|| Google Chrome 最新 |
|Mac(OS X以降)|Safari 最新|
|iOS (7以降)|Safari 最新|
|Android (4.1以降)| 標準ブラウザ 最新|
