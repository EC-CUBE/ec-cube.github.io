---
title: プラグインジェネレータエンティティの利用方法
keywords: plugin generate spec entity repository
tags: [plugin, tutorial]
sidebar: home_sidebar
permalink: plugin_tutorial-generate-entity
summary: プラグイン用エンティティ、リポジトリクラスを簡単に作成できるプラグインジェネレータエンティティについて説明します。
---

## プラグインジェネレータエンティティについて

プラグインの雛形を作成するコマンドを[こちらで説明](plugin_tutorial-generate)しましたが、プラグインに対してエンティティやリポジトリ、マイグレーションファイルを自動で生成するコマンドも用意されています。  
このコマンドを利用することで、プラグイン用のEntityクラスやRepositoryクラス、マイグレーションファイルを自動で作成してくれます。


### プラグインジェネレータエンティティの使い方

プラグインの雛形を作成するためのプラグインジェネレータコマンドは

```
php app/console plugin:develop entity
```

を実行します。


## プラグインジェネレータエンティティコマンド実行時の内容について
`entity`コマンドを実行すると問い合わせ形式で、プラグイン作成時に必要となる情報が設定できます。

問い合わせ内容を以下に説明します。途中で終わらせたい場合、quitを入力してください。  
必須以外の箇所については何も入力せずにenterを押すとスキップします。

## ymlファイルからエンティティクラスを作成
EC-CUBE3本体の開発方法と同じく、先にymlファイルを作成しymlファイルからエンティティクラスを作成する方法を説明します。


### エンティティを作成する種別を選択
エンティティを作成する場合、ymlファイルから作成するか既存のテーブルから作成するか選択できます。`d`を選択すると既存のデータベース、`y`を選択するとyamlファイルを元に作成します。

```
[entity]How to generate entities from db schema or yml? [d => db, y => yml] : 
```

今回はymlファイルを選択します。

### プラグインコードの入力
エンティティを作成するプラグインコードを入力します。

```
------------------------------------------------------
---Plugin Generator for Entity
---[*]You need to create yml file first.
---[*]You can exit from Console Application, by typing quit instead of typing another word.
------------------------------------------------------

[+]Please enter Plugin Code (First letter is uppercase alphabet only. alphabet and numbers are allowed.)
Input[1] : 
```

### 対象となるymlファイルを選択
ymlファイルを入力します。

```
[+]Plese enter yml file name
Input[2] : 
```

対象となるymlファイルですが、以下のディレクトリに保存されている必要があります。

```
app/Plugin/[プラグインコード]/Resource/doctrine
```

例) Profileというdcmファイルを配置

```
app/Plugin/TestPlugin/Resource/doctrine/Plugin.TestPlugin.Entity.Profile.dcm.yml
```

また、dcmファイルは複数選択可能です。


### EC-CUBE3のサポート有無
EC-CUBE3.0.8以下と3.0.9以上でプラグイン機構に改修が入りました。3.0.8以下も対応するプラグインを作成する場合、`y`を入力し、古いEC-CUBE3はサポートしないのであれば `n` を入力してください。

```
[+]Do you want to support old versions too? [y/n]
Input[3] : 
```

### 確認
入力した内容を確認します。問題なければ`y`を入力します。


```
---Entry confirmation
[+]Plugin Code:  TestPlugin
[+]Yml file name: 
  Plugin.TestPlugin.Entity.Profile.dcm.yml
[+]Old version support:  No

[confirm] Do you want to proceed? [y/n] : 
```


### 完了
完了するとエンティティ、リポジトリ、マイグレーションの各ファイルが所定のディレクトリへとファイルが配置されます。

```
[+]File system

 this files and folders were created.
 - ECCUBEROOT/app/Plugin/TestPlugin/Entity
 - ECCUBEROOT/app/Plugin/TestPlugin/Repository
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine/migration
 - ECCUBEROOT/app/Plugin/TestPlugin/Entity/Profile.php
 - ECCUBEROOT/app/Plugin/Sample/Repository/ProfileRepository.php
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine/migration/Version20170313155859.php
```

以上でプラグイン用エンティティクラス等が完成します。


このコマンドはファイルを作成しただけなので、DBに対してテーブルは作成されません。  
テーブルを作成する場合、[PluginManager](http://127.0.0.1:4005/plugin_bp_pluginmanager){:target="_blank"}に対して処理を記述後に[プラグイン開発用コンソールコマンド](plugin_console)を利用すると便利です。


## 既存のテーブルからエンティティクラスを作成
先ほどまではymlファイルからエンティティクラスなどを作成する方法を説明しましたが、開発方法によっては先にテーブルを作成後にクラスを作成する方法もあるため、既存のテーブルからエンティティクラスを作成する方法を説明します。



### エンティティを作成する種別を選択
先ほどはymlファイルを選択しましたが、今回はdbを選択します。

```
[entity]How to generate entities from db schema or yml? [d => db, y => yml] : 
```

### プラグインコードの入力
エンティティを作成するプラグインコードを入力します。

```
------------------------------------------------------
---Plugin Generator for Entity
---[*]You need to create table schema first.
---[*]You can exit from Console Application, by typing quit instead of typing another word.
------------------------------------------------------

[+]Please enter Plugin Code (First letter is uppercase alphabet only. alphabet and numbers are allowed.)
Input[1] : 

```

### 対象となるテーブルを選択
テーブル名を入力します。

```
[+]Please enter table name
Input[2] : 
```

対象となるテーブルですが、テーブル名の命名規則として

```
plg_
```

から始まっているテーブル名以外は作成できません。  
そのため、テーブル名を作成するときは必ず`plg_xxx`をplgを先頭につけるようにしてください。
テーブル名は複数選択可能です。


### EC-CUBE3のサポート有無
EC-CUBE3.0.8以下と3.0.9以上でプラグイン機構に改修が入りました。3.0.8以下も対応するプラグインを作成する場合、`y`を入力し、古いEC-CUBE3はサポートしないのであれば `n` を入力してください。

```
[+]Do you want to support old versions too? [y/n]
Input[3] : 
```

### 確認
入力した内容を確認します。問題なければ`y`を入力します。


```
---Entry confirmation
[+]Plugin Code:  TestPlugin
[+]Table name: 
  plg_information
[+]Old version support:  No

[confirm] Do you want to proceed? [y/n] : 
```


### 完了
完了するとエンティティ、リポジトリ、マイグレーションの各ファイルが所定のディレクトリへとファイルが配置されます。

```
[+]File system

 this files and folders were created.
 - ECCUBEROOT/app/Plugin/TestPlugin/Entity
 - ECCUBEROOT/app/Plugin/TestPlugin/Repository
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine/migration
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine/Plugin.TestPlugin.Entity.Information.dcm.yml
 - ECCUBEROOT/app/Plugin/TestPlugin/Entity/Information.php
 - ECCUBEROOT/app/Plugin/TestPlugin/Repository/InformationRepository.php
 - ECCUBEROOT/app/Plugin/TestPlugin/Resource/doctrine/migration/Version20170313162547.php
```

以上でプラグイン用エンティティクラス等が完成します。







