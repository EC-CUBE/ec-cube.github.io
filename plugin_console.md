---
layout: default
title: php app/console plugin:develop を利用したプラグイン開発
---

---

# php app/console plugin:develop を利用したプラグイン開発


プラグイン開発時、一旦アーカイブした後プラグインのインストールを行う必要がありますが、  
EC-CUBE3.0.9からコマンドベースで開発の手助けを行う手順が提供されました。

```
php app/console plugin:develop
```

このコマンドを使うと、コマンドベースでプラグインのインストールや有効化が行えるようになり、
DBのマイグレーション等がお手軽に試せるようになります。


#### plugin:developの使い方


```plugin:develop``` はプラグインを画面からインストールしなくても、
インストール、アンインストール、有効、無効、アップデートをコマンドベースで行えます。


* example

```
php app/console plugin:develop install
php app/console plugin:develop uninstall
php app/console plugin:develop enable
php app/console plugin:develop disable
php app/console plugin:develop update
```


* コマンドの利用方法

オプション指定に ```--code[=CODE]``` が存在し、  
codeを指定した場合、指定したコードのPluginManager.phpの該当するメソッドが実行されます。

```
php app/console plugin:develop enable --code=plugincode
```
この例だとPluginManager.phpのenable関数が実行されます。


* ```plugin:develop install``` のみで利用できるコマンド

オプション指定に ```--path[=PATH]``` が存在し、  
pathを指定した場合、アーカイブされているプラグインをインストールします。  
また、 ```code``` の指定は必要ありません。

```
php app/console plugin:develop install --path=/aaa/bbb/plugin.tar.gz
```

* ```plugin:develop uninstall``` のみで利用できるコマンド

オプション指定に ```--uninstall-force[=UNINSTALL-FORCE]``` が存在し、  
```true``` を指定すると該当するプラグインのディレクトリが削除されます。  
デフォルトはfalseです。

```
php app/console plugin:develop install --code=plugincode --uninstall-force=true
```


