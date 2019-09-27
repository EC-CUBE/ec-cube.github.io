---
title: インストール時にURLからhtmlを無くす
keywords: sample homepage
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_remove-html
folder: quickstart
---

一部のレンタルサーバなどDocumentRootを変更できない環境でも、インストール時に下記の手順を行うことで、URLからhtmlを無くした状態でインストールが可能です。  
  
例) `https://www.example.com/html/` → `https://www.example.com/`  

## 対応バージョン
EC-CUBE 3.0.11 以降  

## ご注意
下記の手順を行うことで、通常のEC-CUBEとは異なるファイル構成になります。  
そのため、一部のプラグインなどが正常に動作しない可能性があることをご理解ください。  
  
また、この方法でのインストールを行う前に、まずはDocumentRootの変更などサーバ設定での対応をご検討ください。  

## 作業手順
__インストールを行う前__ に、以下作業を実施します。  
1. ファイル配置場所の変更  
2. .htaccess / web.config の置き換え  
3. index.php / index_dev.php / install.php の変更  
4. autoload.php の変更  
5. EC-CUBEのインストール  

### 1. ファイル配置場所の変更
以下の6つのファイルを、htmlフォルダの中から一階層上に移動します。(コピーではありません)  

```
[root]
  ├──[html]
  │   ├── index.php
  │   ├── index_dev.php
  │   ├── install.php
  │   ├── robots.txt
  │   ├── .htaccess
  │   └── web.config
  │
```

↓  

```
[root]
  ├──[html]
  │
  ├── index.php
  ├── index_dev.php
  ├── install.php
  ├── robots.txt
  ├── .htaccess
  ├── web.config
```

### 2. .htaccess / web.config の置き換え
手順1で移動してきた`.htaccess``web.config`を削除します。  

```
[root]
  │
  ├── .htaccess   ← 削除
  ├── web.config  ← 削除
  ├── .htaccess.sample
  ├── web.config.sample
```

`.htaccess.sample``web.config.sample`をそれぞれ`.htaccess``web.config`にリネームします。  

```
[root]
  │
  ├── .htaccess.sample
  ├── web.config.sample
```

↓  

```
[root]
  │
  ├── .htaccess
  ├── web.config
```

### 3. index.php / index_dev.php / install.php の変更
それぞれのファイルで、以下のようにコメントアウトする行を変更します。  

- index.php
- index_dev.php
- install.php

```
//[INFO]index.php,install.phpをEC-CUBEルート直下に移動させる場合は、コメントアウトしている行に置き換える
require __DIR__.'/../autoload.php';
//require __DIR__.'/autoload.php';
```

↓  

```
//[INFO]index.php,install.phpをEC-CUBEルート直下に移動させる場合は、コメントアウトしている行に置き換える
//require __DIR__.'/../autoload.php';
require __DIR__.'/autoload.php';
```

index_dev.phpについては以下の部分も修正してください。
```
// Silex Web Profiler
$app->register(new \Silex\Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../app/cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
));
```

↓  

- cacheファイルディレクトリの指定場所を変更します。
```
// Silex Web Profiler
$app->register(new \Silex\Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/app/cache/profiler',
    'profiler.mount_prefix' => '/_profiler',
));
```




### 4. autoload.php の変更
autoload.php で、以下のようにコメントアウトする行を変更します。  

```
//[INFO]index.php,install.phpをEC-CUBEルート直下に移動させる場合は、コメントアウトしている行に置き換える
define("RELATIVE_PUBLIC_DIR_PATH", '');
//define("RELATIVE_PUBLIC_DIR_PATH", '/html');
```

↓  

```
//[INFO]index.php,install.phpをEC-CUBEルート直下に移動させる場合は、コメントアウトしている行に置き換える
//define("RELATIVE_PUBLIC_DIR_PATH", '');
define("RELATIVE_PUBLIC_DIR_PATH", '/html');
```

### 5. EC-CUBEのインストール
EC-CUBEを配置したサイトにアクセスするとインストール画面が表示されます。  
画面の指示に従ってインストールを進めてください。  
  
※インストール画面で大きなレイアウト崩れが発生している場合は、正常にインストールできない可能性があります。 再度、上記手順をご確認ください。  

### 6. .htaccessの設置
`src`、`vendor`、`tests`ディレクトリを外部から閲覧できないように、.htaccessを設置します。

以下の内容の.htaccessを、各ディレクトリに設定してください。

```
order allow,deny
deny from all
```

以下の配置になるよう、設置します。

```
[root]
  │
  ├──[src]
  │   ├── .htaccess
  ├──[tests]
  │   ├── .htaccess
  ├──[vendor]
      ├── .htaccess
```
設置後、各ディレクトリが閲覧できないことを確認してください。
