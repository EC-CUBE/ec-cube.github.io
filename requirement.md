---
layout: default
title: システム要件
---

---

# システム要件

| 分類 | ソフトウェア|Version|動作確認済み|
|---|-------|---|-------|
|WebServer|IIS(windows系OS )| 8.0 以上| 8.0 |
|WebServer|Apache |2.2.x, 2.4.x| 2.2.15 |
|PHP | PHP   | 5.3.9 ～ 7.0 |5.4.39 / 7.0|
|Database|PostgreSQL| 8.4.x以降  9.x以降 ※pg_settingsテーブルへの参照権限が必要です|8.4.20|
|Database|MySQL|5.1.x以上、5.5.x 以降 ※InnoDBエンジンが必要です|5.1.73|

# PHPライブラリ

| 分類 | ライブラリ|
|---|---|
|必須ライブラリ|pdo pgsql又はmysql phar mbstring zlib ctype session JSON xml libxml OpenSSL zip cURL fileinfo |
|推奨ライブラリ|hash PC mcrypt |

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
