---
title: プラグインのインストール
keywords: plugin install プラグイン
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: plugin_install
---

### プラグインの操作についての概要

- プラグインは、インストール後に有効化することで機能を利用できるようになります。  
- 機能を一時的に利用できなくしたい場合には、有効/無効を切り替えることができます。
- 不要になった場合にはプラグインを削除することができます。


### コマンドラインインターフェースを利用してインストールする

サンプルプラグイン(ProductReview)を `./app/Plugin/ProductReview` に展開後、以下のコマンドを実行してください。

1. インストール  
`bin/console eccube:plugin:install --code=ProductReview`
1. 有効化  
`bin/console eccube:plugin:enable --code=ProductReview`

#### その他の操作

プラグイン操作のために以下のコマンドラインインターフェースを提供しています。  
これらを利用することでコマンドベースでプラグインの操作を行うことができるようになります。

```
bin/console eccube:plugin:install            // インストール
bin/console eccube:plugin:uninstall          // 削除
bin/console eccube:plugin:enable             // 有効化
bin/console eccube:plugin:disable            // 無効化
```

##### 利用例

1. インストール  
`bin/console eccube:plugin:install --code=プラグインコード`
1. 有効化  
`bin/console eccube:plugin:enable --code=プラグインコード`
1. 無効化  
`bin/console eccube:plugin:disable --code=プラグインコード`
1. 削除  
`bin/console eccube:plugin:uninstall --code=プラグインコード`
1. 削除(プラグインのファイルも削除する場合)  
`bin/console eccube:plugin:uninstall --code=プラグインコード --uninstall-force=true`


### 管理画面を利用してインストールする

EC-CUBE 3.n 開発中のため利用することが出来ません。  
正式リリース時には、管理画面から以下のインストール方法を利用できるようになります。

- オーナーズストアで購入したプラグインのインストール
- 独自プラグイン(tar.gz/zip)をアップロードしてのインストール

