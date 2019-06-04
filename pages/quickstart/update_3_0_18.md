---
title: 3.0.18へのバージョンアップに関する注意点
keywords: howto update 3.0.18
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_update_3_0_18
summary : EC-CUBE本体の3.0.18へのバージョンアップの互換性についての技術的注意点を記載します。  
---


## 背景
Symfonyフレームワークのセキュリティ強化のため、後方互換性のないアップデートが含まれます。
そのため、プラグインや独自カスタマイズしている部分のコードについて、修正が必要になる可能性があります。

## 影響内容

### ログインに関する影響について

アップデートを適用すると、ログイン関連のセッションの仕様が変更されるため、管理画面やマイページでログインしているユーザは一度ログアウトされるため再度ログインが必要です。
RememberMeなどでログイン情報を保存している場合も、再度ログインが必要となります。

### 非会員のセッション情報取得について

Symfonyの仕様変更に伴い、ShoppingControllerでの非会員情報をセッションに保存をする箇所に修正が入っています。
  
詳しくは[こちら](#非会員のセッション情報取得の修正方法)をご確認ください。

### Entityを含んだクラスのデータの扱い方について

Symfonyの仕様変更に伴い、Entityを含むオブジェクトをそのまま `serialize` `unserialize` をした際にエラーが発生する可能性があります。  
  
詳しくは[こちら](#Entityを含んだクラスのデータの扱い方の修正)をご確認ください。


## 該当コードの修正方法

### 非会員のセッション情報取得の修正方法

Symfonyの仕様変更に伴い、ShoppingControllerでの非会員情報をセッションに保存をする箇所に修正が入っています。
ShoppingControllerのカスタマイズやプラグインでオーバーライドを行なっている場合は修正が必要となります。

ShoppingControllerで非会員情報を扱う場合は、`setNonMember`と`getNonMember`を使用してください。  
プラグインやカスタマイズで`getNonMember`を使用せずに非会員情報を取得している場合は、セッションの非会員情報を正しく取得できません。

旧バージョンでの非会員用セッションの作成方法(修正が必要なコード)
```php
　// 非会員用セッションを作成
　$nonMember = array();
　$nonMember['customer'] = $Customer;
　$nonMember['pref'] = $Customer->getPref()->getId();
　$app['session']->set($this->sessionKey, $nonMember);
```
3.0.18 以降での非会員用セッションの作成方法(修正後のコード)
```php
　// 非会員用セッションを作成
　$app['eccube.service.shopping']->setNonMember($this->sessionKey, $Customer);
```

参考：本体ソースコードの修正差分  
[https://github.com/EC-CUBE/ec-cube/pull/2865/files#diff-615c41c60c70bb3b6ddabc92fa58c67c](https://github.com/EC-CUBE/ec-cube/pull/2865/files#diff-615c41c60c70bb3b6ddabc92fa58c67c)

### Entityを含んだクラスのデータの扱い方の修正

Symfonyの仕様変更に伴い、Entityを含むオブジェクトをそのまま `serialize` `unserialize` をした際にエラーが発生する可能性があります。  
そのため、該当するコードがある場合は動作確認の上、下記修正方法に従って修正をする必要があります。

#### 旧バージョンでオブジェクトをそのままシリアライズしてセッションに保持する実装方法(修正が必要なコード)

クラスオブジェクトであるCustomerAddressをそのままserialize/unserializeしているため、エラーが発生する可能性のあるコードです。

セッションへの保持
```php
$CustomerAddress = new CustomerAddress();
$app['session']->set($this->sessionCustomerAddressKey, serialize($CustomerAddress));
```
セッションからの復元
```php
$CustomerAddress = unserialize($CustomerAddress);
```

#### オブジェクトを配列化してjson形式でセッションに保持する実装方法(推奨する修正方法)

クラスオブジェクトであるCustomerAddressを配列化してjson形式でセッションに保持しています。  
CustomerAddressに含まれるオブジェクトであるPrefも配列化しています。
復元時は逆にjson形式から配列に復元し、さらにそれをオブジェクトに復元しています。

セッションへの保持
```php
// CustomerAddressオブジェクトを配列化する
$CustomerAddress = new CustomerAddress();
$CustomerAddressArray = $CustomerAddress->toArray();                    // CustomerAddressを配列化
$CustomerAddressArray['Pref'] = $CustomerAddress->getPref()->toArray(); // CustomerAddressに含まれるPrefオブジェクトを配列化

// json形式でセッションに保持する
$json = json_encode($CustomerAddressArray);
$app['session']->set($this->sessionCustomerAddressKey, $json);
```

セッションからの復元
```php
// json形式でセッションから取得する
$json = $app['session']->get($this->sessionCustomerAddressKey);
$CustomerAddressArray = json_decode($json, true);

// CustomerAddressオブジェクトを復元する
$CustomerAddress = new CustomerAddress();
$CustomerAddress->setPropertiesFromArray($CustomerAddressArray); // 配列からCustomerAddressのデータを復元する
$CustomerAddress->setPref($app['eccube.repository.master.pref']->find($CustomerAddressArray['Pref']['id'])); // Prefオブジェクトの復元
```

参考：本体ソースコードの修正差分  
[https://github.com/EC-CUBE/ec-cube/pull/4167/files#diff-615c41c60c70bb3b6ddabc92fa58c67c](https://github.com/EC-CUBE/ec-cube/pull/4167/files#diff-615c41c60c70bb3b6ddabc92fa58c67c)





