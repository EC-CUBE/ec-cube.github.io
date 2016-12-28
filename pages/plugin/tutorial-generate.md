---
title: プラグインジェネレータの利用方法
keywords: plugin generate spec
tags: [plugin, tutorial]
sidebar: home_sidebar
permalink: plugin_tutorial-generate
summary: プラグインの雛型を簡単に作成できるプラグインジェネレータについて説明します。
---

## プラグインジェネレータについて

EC-CUBE3.0.13よりプラグインの雛形を生成するプラグインジェネレータが搭載され、プラグイン開発者にとって手間となっていたファイルやフォルダの準備をコンソールコマンドを使って簡単に生成できるようになります。

## プラグインの雛形を作成する

### プラグインジェネレータコマンドについて
プラグイン開発する際に手助けをするために[プラグイン開発用コンソールコマンド](plugin_console)というものが用意されています。 プラグインジェネレータは

```
php app/console plugin:develop
```

に対して新たにパラメータを用意しています。
パラメータの種類    は`--help`で確認できます。

```
php app/console plugin:develop --help
```


### プラグインジェネレータの使い方

プラグインの雛形を作成するためのプラグインジェネレータコマンドは

```
php app/console plugin:develop genereate
```

を実行します。


## プラグインジェネレータコマンド実行時の内容について
`genereate`コマンドを実行すると問い合わせ形式で、プラグイン作成時に必要となる情報が設定できます。

問い合わせ内容を以下に説明します。途中で終わらせたい場合、quitを入力してください。  
必須以外の箇所については何も入力せずにenterを押すとスキップします。

### プラグイン名の入力
作成するプラグイン名を入力します。

```
------------------------------------------------------
---Plugin Generator
---[*]You can exit from Console Application, by typing quit instead of typing another word.
------------------------------------------------------

[+]Please enter Plugin Name
Input[1] : 
```

### プラグインコードの入力
作成するプラグインコードを入力します。英数字のみ入力可能で1文字目は必ず半角英字の大文字で入力してください。

```
[+]Please enter Plugin Name (only pascal case letters numbers are allowed)
Input[2] : 
```
→「Please enter Plugin Name」となっていますが正しくは「Please enter Plugin Code」の誤りです。

### プラグインバージョン
プラグインのバージョンを入力します。

```
[+]Please enter version (correct format is x.y.z)
Input[3] : 
```

### 作成者
ファイルヘッダに設定する作成者情報を入力します。

```
[+]Please enter author name or company
Input[4] : 
```

### EC-CUBE3のサポート有無
EC-CUBE3.0.8以下と3.0.9以上でプラグイン機構に改修が入りました。3.0.8以下も対応するプラグインを作成する場合、`y`を入力し、古いEC-CUBE3はサポートしないのであれば `n` を入力してください。

```
[+]Do you want to support old versions too? [y/n]
Input[5] : 
```

### 共通イベント設定
EC-CUBE3で用意している共通イベント名を指定します。イベント名は大量にあるため、イベント名の一部を入力してenterを押すと利用可能なイベントが画面上に表示されます。  
このコマンドでは一致するイベント名を入力しないと完了しません。


```
[+]Please enter site events(you can find documentation here http://www.ec-cube.net/plugin/)
Input[6] : 
```

`app`のみを入力し、enterを押します。

```
[+]Please enter site events(you can find documentation here http://www.ec-cube.net/plugin/)
Input[6] : app
[!] No results have been found
--- there are more then one search result
 - eccube.event.app.request
 - eccube.event.app.controller
 - eccube.event.app.response
 - eccube.event.app.exception
 - eccube.event.app.terminate

[+]Please enter site events(you can find documentation here http://www.ec-cube.net/plugin/)
Input[6] : 
```

イベント名にappが含まれているイベントが一覧表示されます。


例えば`eccube.event.app.request`を入力するとイベントが追加されます。イベントがこれ以上不要な時や必要ない場合、何も入力せずにenterを押してください。

```
[+]Please enter site events(you can find documentation here http://www.ec-cube.net/plugin/)
Input[6] : eccube.event.app.request
--- your entry list
 - eccube.event.app.request

--- Press Enter to move to the next step ---
[+]Please enter site events(you can find documentation here http://www.ec-cube.net/plugin/)
Input[6] : 
```


### フロント、管理イベント設定
フロント、管理画面で利用しているイベントを設定します。使い方は共通イベントと同様です。

```
[+]Please enter hook point, sample：front.cart.up.initialize
Input[7] : 
```


### 確認
入力した内容を確認します。問題なければ`y`を入力します。


```
---Entry confirmation
[+]Plugin Name:  サンプルプラグイン
[+]Plugin Code:  Sample
[+]Version:  1.0.0
[+]Author:  lockon
[+]Old version support:  No
[+]Site events: 
  eccube.event.app.request
[+]Hook points: 

[confirm] Do you want to proceed? [y/n] : 
```


### 完了
完了するとプラグインが`app/Plugin`配下に`プラグインコード`のディレクトリが作成され、そこに必要なファイルが配置されます。

```
[+]File system

 this files and folders were created.
 - ECCUBEROOT/app/Plugin/Sample
 - ECCUBEROOT/app/Plugin/Sample/ServiceProvider
 - ECCUBEROOT/app/Plugin/Sample/Controller
 - ECCUBEROOT/app/Plugin/Sample/Form/Type
 - ECCUBEROOT/app/Plugin/Sample/Resource/template/admin
 - ECCUBEROOT/app/Plugin/Sample/config.yml
 - ECCUBEROOT/app/Plugin/Sample/PluginManager.php
 - ECCUBEROOT/app/Plugin/Sample/ServiceProvider/SampleServiceProvider.php
 - ECCUBEROOT/app/Plugin/Sample/Controller/ConfigController.php
 - ECCUBEROOT/app/Plugin/Sample/Controller/SampleController.php
 - ECCUBEROOT/app/Plugin/Sample/Form/Type/SampleConfigType.php
 - ECCUBEROOT/app/Plugin/Sample/Resource/template/admin/config.twig
 - ECCUBEROOT/app/Plugin/Sample/Resource/template/index.twig
 - ECCUBEROOT/app/Plugin/Sample/event.yml
 - ECCUBEROOT/app/Plugin/Sample/SampleEvent.php
 - ECCUBEROOT/app/Plugin/Sample/LICENSE

[+]Database
 Plugin information was added to table [DB.Plugin] (id=54)
Plugin was created successfully
```

以上でプラグインの雛形が完成します。

プラグインの雛形を作成したら管理画面より、  
[オーナーズストア]->[プラグイン]->[プラグイン一覧]の「独自プラグイン」に作成したプラグインが表示されているか確認してください。

表示されていればプラグインが無事に完成されています。


EC-CUBE3.0.13未満をご利用の方にはプラグインジェネレータというプラグインの雛形を作成するプラグインもあります。  
そちらの説明は[こちら](plugin_tutorial-plugin-generate)を参照してください。

