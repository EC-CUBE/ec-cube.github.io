---
layout: default
title: プラグインフックポイント仕様
---

---

# フックポイント仕様

## フックポイントの命名規則

`eccube.event.*.(before|after|finish)`


## 現時点で、自動生成もしくは定義されているフックポイント一覧

* `eccube.event.app.before`
* `eccube.event.app.after`
* `eccube.event.controller.ROUTE.before`
* `eccube.event.controller.ROUTE.after`
* `eccube.event.controller.ROUTE.finish`
* `eccube.event.render.before`
    + `$app['view']->render()` のときにEventが走る。
    + 引数のEventObjectを利用することで、ソースコードを自由に触れる用にしてある

`ROUTE` は、 `$request->attributes->get('_route')` で取得できる、ルーティング名
`->bind('ここ')`
