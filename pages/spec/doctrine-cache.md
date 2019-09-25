---
title: doctrine_cache.ymlの設定
keywords: doctrine cache config file 
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_doctrine-cache
summary: Doctrineのキャッシュの利用設定について解説します。
---

## キャッシュタイプ  

キャッシュタイプとしては以下を設定できます。

|  キャッシュタイプ    |  概要                          |
|--------------------|---------------------------------------------------|
| metadata_cache | Doctrine のメタデータ(Entity Yaml ファイルの情報等)をキャッシュします。|
| query_cache    | ORM から SQL の変換結果をキャッシュします。                      |
| result_cache   | DQL の検索結果をキャッシュします。                              |
| hydration_cache| 連想配列から、 Entity への変換結果をキャッシュします。              |


## result_cache の追加設定

後述のドライバの設定のほか、以下の設定を利用可能です(3.0.12以降)  
- lifetime
  - キャッシュの有効期限（秒）
  - デフォルト値は3600
- clear_cache
  - キャッシュされたエンティティが更新される際に、キャッシュを削除するかどうか
  - デフォルト値はtrue
  - falseの場合、管理画面で編集を行った際にもキャッシュの削除を行いません
  - キャッシュの削除タイミングをコントロールしたい場合に利用してください

## キャッシュドライバ

キャッシュドライバとしては以下を設定できます。

### array

デフォルトの設定です。リクエストごとに PHP array でキャッシュを生成します。開発環境向け。

- 設定例

```yml
  <cachename>_cache:
    driver: array
    path:
    host:
    port:
    password:
```

### filesystem

キャッシュファイルをファイルシステムに保存します。  
SSD など、高速なストレージを使用している場合に効果を期待できます。  
`path: ` パラメータでキャッシュの保存先を指定します。  

- 設定例

```yml
  <cachename>_cache:
    driver: filesystem
    path: /path/to/ec-cube/app/cache/doctrine/<cachename>
    host:
    port:
    password:
```

### apc

[APC User Cache](https://pecl.php.net/package/APCU) を利用して、キャッシュをメモリ上に保持します。  
予め [apcu](https://pecl.php.net/package/APCU){:target="_blank"} をインストールしておく必要があります。  

```
pecl install apcu
```

- 設定例

```
  <cachename>_cache:
    driver: apc
    path:
    host:
    port:
    password:
```

### xcache

[xCache](https://xcache.lighttpd.net/) を利用して、キャッシュをメモリ上に保持します。  
予め [xCache](https://xcache.lighttpd.net/){:target="_blank"} をインストールしておく必要があります。  

```
## for ubuntu
sudo apt-get install php5-xcache

## for centos7
sudo rpm -iUvh http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
sudo yum --enablerepo=epel install php-xcache

## for macos x
brew install php56-xcache
```

- 設定例

```
  <cachename>_cache:
    driver: xcache
    path:
    host:
    port:
    password:
```

### memcached

[memcached](https://memcached.org/) にキャッシュを保存します。  
libmemcached を必要とします。 [PECL memcached](https://pecl.php.net/package/memcached){:target="_blank"} を入れておく必要があります。  
`host: ` 及び `port: ` で memcached の接続先を指定します。  

```
## for ubuntu
sudo apt-get install memcached

## for centos7
sudo yum install memcached

## for macos x
brew install memcached
```

```
pecl install memcached
```

- 設定例

```yml
  <cachename>_cache:
    driver: memcached
    path:
    host: localhost
    port: 11211
    password:
```

### memcache

[memcached](https://memcached.org/) にキャッシュを保持します。 `driver: memcached` の場合と異なり、 libmemcached を必要としません。  
[PECL memcache](https://pecl.php.net/package/memcache) を入れておく必要があります。  
`host: ` 及び `port: ` で memcached の接続先を指定します。  

- 設定例

```yml
  <cachename>_cache:
    driver: memcache
    path:
    host: localhost
    port: 11211
    password:
```

### redis

[redis](http://redis.io/) にキャッシュを保持します。  
予め [PECL redis](https://pecl.php.net/package/redis){:target="_blank"} をインストールしておく必要があります。  
`host: ` 及び `port: ` で redis-server の接続先を指定します。  

- 設定例

```
pecl install redis
```

```yml
  <cachename>_cache:
    driver: redis
    path:
    host: localhost
    port: 6379
    password:
```