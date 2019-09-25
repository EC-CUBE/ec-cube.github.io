---
title: session_handler.ymlの設定
keywords: session handler config file 
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_session-handler
summary: Doctrineのキャッシュの利用設定について解説します。
---


## ハンドラの種類

以下のハンドラで動作確認を行っています。  
利用するには、該当するPHP拡張をインストールしておく必要があります。  

- memcached
- memcache
- redis

##  ハンドラの設定

### memcached

[memcached](https://memcached.org/) にセッションを保存します。  
libmemcached を必要とします。 [PECL memcached](https://pecl.php.net/package/memcached){:target="_blank"} を入れておく必要があります。  
`save_handler: ` 及び `save_path: ` で memcached の接続先を指定します。  

```yml
session_handler:
    enabled: true
    save_handler: memcached
    save_path: 127.0.0.1:11211
```

### memcache

[memcached](https://memcached.org/) にセッションを保存します。 `save_handler: memcached` の場合と異なり、 libmemcached を必要としません。  
[PECL memcache](https://pecl.php.net/package/memcache) を入れておく必要があります。  
`save_handler: ` 及び `save_path: ` で memcached の接続先を指定します。  

- 設定例

```yml
session_handler:
    enabled: true
    save_handler: memcache
    save_path: 127.0.0.1:11211
```

### redis

[redis](http://redis.io/) にセッションを保持します。  
予め [PECL redis](https://pecl.php.net/package/redis){:target="_blank"} をインストールしておく必要があります。  
`save_handler: ` 及び `save_path: ` で redis-server の接続先を指定します。  

- 設定例

```yml
session_handler:
    enabled: true
    save_handler: redis
    save_path: 127.0.0.1:6379
```
