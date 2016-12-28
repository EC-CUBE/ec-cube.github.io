---
title: プラグイン注意点
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_badknowhow
---

プラグインでは基本的に何でも出来ますが、本体に影響を与えたりするようなプラグインは推奨していません。

## 実装時の注意点

### 既存テーブルに対するカラム追加
例えば`dtb_customer`テーブルに対して新たに`nick_name`というカラムを追加するようなことは推奨していません。  
対応する場合、`dtb_member`に対して`dtb_profile`と関連するテーブルを作成してそこにカラムを追加する方が本体に影響がありません。

### DIで定義されている定数に対しプラグインから上書き
例えば、`EccubeServiceProvider`クラス等で$appに対し、

<pre>
$app['eccube.repository.customer'] = $app->share(function () use ($app) {
    return $app['orm.em']->getRepository('Eccube\Entity\Customer');
});</pre>
と宣言されているDI定数に対し、プラグインから

<pre>
$app['eccube.repository.customer'] = $app->share(function () use ($app) {
    return $app['orm.em']->getRepository('Eccube\Entity\Member');
});</pre>
と内容を上書きすると予期せぬ動作不良を起こします。

### EC-CUBE3本体のバージョンによるプラグイン対応について
EC-CUBE3.0.9から新しいプラグイン機構が用意されています。3.0.8以下と3.0.9以上に対応したプラグインを作成する場合、イベントに対する記述を考慮する必要があります。

参考)  
[EC-CUBE 3.0.9～のプラグイン開発](plugin_tutorial#ec-cube-309)  
[本体のバージョンチェック](plugin_bp_event#section-2)


## プラグインの競合について

### プラグインの競合が起きる条件
プラグインを複数インストールした時にプラグイン同士が影響しあって正常に動作しない時があります。競合が起きる条件ですが、

- 同じタグを参照していた場合
- 同じイベントが各プラグインで使用されており、考慮せずに実装していた場合

等があります。






