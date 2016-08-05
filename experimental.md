---
layout: default
title: 実験的な実装
---

---

# 概要

以下は、EC-CUBEの実験的な機能、実装ついての解説です。

## 本体の拡張機構

この機構は、3.0.10で取り込まれます。

[issue #1642](https://github.com/EC-CUBE/ec-cube/issues/1642)

フックポイントを簡易に利用できる仕組みです。
主に、カスタマイズを行う際の一手段として利用されることを想定しています。

### 利用方法

`app/Ext/Event.php`を編集します。

このEventクラスに、フックポイントの定義や実行されるメソッドを記述します。
プラグインのイベントクラスとは、

- EventSubscriberInterfaceをimplementsしている
- フックポイントの定義はgetSubscribedEvents()メソッドに記述する

点を除いて、違いはありません。

### 例

`eccube.event.front.request`フックポイントで、`onFrontRequest`メソッドを呼び出す場合の記述例

```
    public static function getSubscribedEvents()
    {
        return array(
            'eccube.event.front.request' => 'onFrontRequest'
        );
    }

    public function onFrontRequest($event)
    {
        dump($event->getName());
    }

```

### 優先度の設定

getSubscribedEvents()メソッドでは、優先度も指定することが出来ます。
優先度を指定する場合は、以下のように記述します。

`array('eventName' => array('methodName', $priority))`

### プラグインの優先度との調整

プラグインの実行優先度は、先発、後発、通常で優先度範囲が定義されています。

参考：http://ec-cube.github.io/plugin_handler.html

すでにインストールされているプラグインと拡張機構とで優先度を調整したい場合は、優先度の範囲内で、priorityの値を調整してください。

※通常は、400(NORMAL)を指定していれば問題ありません。
