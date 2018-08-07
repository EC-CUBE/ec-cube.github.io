---
title: ディレクトリ・ファイル構成
keywords: spec directory structure
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_directory-structure
---
---

## 特徴

1. [Symfony3系のディレクトリ構造](https://symfony.com/doc/3.4/quick_tour/the_architecture.html)を参考に、EC-CUBE 4.0独自構成となっています。

## 主なディレクトリと役割

### app/

- 設定ファイルやプラグイン、EC-CUBEをカスタマイズするPHPコードなど、アプリケーションごとに変更されるファイルを配置

```
app
├── Acme      カスタマイズ用PHPコードを配置
├── Plugin    インストールしたプラグインを配置
├── config    設定ファイルを配置
├── proxy     Entity拡張機能によって生成されたProxyクラスを配置
└── template  上書きされたテンプレートファイルを配置
```

### bin/

- `bin/console`など、開発に使用する実行ファイルを配置

### html/

- リソースファイル(jsやcssや画像ファイル）を配置

### src/

- EC-CUBE本体となり、phpファイルやTwigファイルを配置

### tests/

- テストコードを配置

### var/

- キャッシュやログファイルなど、実行時に生成されるファイルを配置

### vendor/

- サードパーティの依存ライブラリを配置
