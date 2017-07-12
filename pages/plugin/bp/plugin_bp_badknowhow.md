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

### 管理画面の検索機能に関連する修正について（3.0.14以上対象）

- 概要  
3.0.14, 3.0.15において、EC-CUBE本体の修正として、管理画面の検索機能について、  
検索条件のセッションへの保存形式を変更しております。  
（不具合につながる恐れのある実装のため、本修正を実施しております。）  
上記対応の結果、既存プラグイン及び本体カスタマイズされているサイトに対して、  
一部修正が必要となります。

- 影響機能  
以下、対象となる機能のプラグイン及び本体カスタマイズをされている場合のみ影響がございます。  
・商品検索（/admin/product）  
・受注検索（/admin/order）  
・会員検索（/admin/customer）

  上記機能で以下のカスタマイズを行っている場合、影響が想定さます。  
・検索条件追加  
・CSV出力機能の拡張  

- 詳細  
検索条件について、セッションへEntityとして保存していたものを、  
postされたデータをセッションに保存、利用時に復元する形に修正しております。  
https://github.com/EC-CUBE/ec-cube/pull/2113  
https://github.com/EC-CUBE/ec-cube/pull/2319  

  今回対応を実施いたしました理由として、  
検索結果のページング時、エラーが発生する場合があるため対応を実施しております。  
https://github.com/EC-CUBE/ec-cube/issues/1680  
https://github.com/EC-CUBE/ec-cube/issues/2112  

- 推奨対応方法  
バージョン判別を行い、3.0.13以前については既存ロジックのまま、
3.0.14以降については追加対応の実施をお願い致します。  
具体的な対応方法としては、以下PullRequestを参照ください。  
https://github.com/EC-CUBE/listing-ad-plugin/pull/4/files?w=1  

## プラグインの競合について

### プラグインの競合が起きる条件
プラグインを複数インストールした時にプラグイン同士が影響しあって正常に動作しない時があります。競合が起きる条件ですが、

- 同じタグを参照していた場合
- 同じイベントが各プラグインで使用されており、考慮せずに実装していた場合

等があります。






