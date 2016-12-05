---
title: EC-CUBE 3.0.11 変更内容に伴うプラグインへの影響
keywords: plugin 3.0.11 変更内容
tags: [plugin, spec]
sidebar: home_sidebar
permalink: plugin_update-for3011
summary: EC-CUBE 3.0.11でプラグインによる拡張時の挙動の安定化を図るために変更された内容と、それに伴うプラグインへの影響について説明します。
---


## 変更内容

EC-CUBE 3.0.11にて、プラグインによる拡張時の挙動の安定化を図るためトランザクション管理をEC-CUBE本体側で一括して管理する修正が行われました。  

具体的には、トランザクションの挙動が以下のように変更になっています。  

- アプリケーションの開始/終了のタイミングでトランザクションのコントロールを行う
- プラグイン内でflushを行っても、DBには即時反映しない
- すべての処理が正常終了したときのみDBに反映する  
  (システムエラー等が発生した場合は、ロールバックを行い反映しない)

| 変更前(～3.0.10) | 変更後(3.0.11～) |
|------------------|------------------|
| ![変更前](/images/plugin/plugin-update-for-3.0.11_01.png) | ![変更後](/images/plugin/plugin-update-for-3.0.11_02.png) |

3.0.11以前にリリースされたプラグインの実装方法によっては、EC-CUBE 3.0.11以降で、正しく動作しない可能性があります。  

### exitによる処理の終了について

上記のようにEC-CUBE側でトランザクション終了してDBに反映するようになりました。  
そのため、`exit`で終了する処理を行っている場合、EC-CUBE側に処理が戻らないため、それ以前のDB操作が反映されません。  
  
EC-CUBE本体側でのDB操作も反映されなくなってしまうため、`exit`の使用は避けてください。  

![exitの例](/images/plugin/plugin-update-for-3.0.11_03.png)  


ご提供のプラグインに、影響を受ける実装(特にexitを使用している箇所)がないかどうか、いま一度ご確認をお願いいたします。  



また、EC-CUBE 3.0.9でフックポイントが多数追加されており、3.0.9からのプラグイン機構をご利用いただくとより安定したプラグインの開発が可能ですので、この機会に合わせて御確認ください。  

## 1) EC-CUBE 3.0.11 以降、不具合となる可能性がある実装と修正方法

影響を受ける実装から、代表的なものを例にして修正方法をご紹介します。  

### A) headerとexitを利用したリダイレクト処理

下記のような実装では、`exit`で終了するため、EC-CUBE側に処理が戻らず、それ以前でのDB操作が反映されません。  

```
header('Location: http://xxx');
exit;
```

#### A-1) コントローラー内に、`header`と`exit`を利用したリダイレクト処理がある場合

リダイレクトレスポンスをreturnするように修正してください。  

__修正前__

```
public function index(Application $app, Request $request)
{
    // 処理...

    header('Location: http://xxx');
    exit;
}
```

__修正後__ ： リダイレクトレスポンスをreturnしてください  

```
public function index(Application $app, Request $request)
{
    // 処理...

    $response = $app->redirect($app->url('xxx'));
    return $response
}
```

####  A-2) フックポイントで呼び出した関数内に、`header`と`exit`を利用したリダイレクト処理がある場合

$eventオブジェクトにリダイレクトレスポンスをセットし、リダイレクト処理を実装してください。  


__修正前__

```
public function onXxxBefore()
{
    // 処理...

    header('Location: http://xxx');
    exit;
}
```

__修正後__ ： $eventオブジェクトにリダイレクトレスポンスをセットしてください  

```
public function onXxxBefore($event = null)
{
    // 処理...

    $response = $this->app->redirect($this->app->url('xxx'));
    $event->setResponse($response);
    return;
}
```

##### 実装時の注意点  

以下のフックポイントは、EC-CUBE 3.0.11以降でのみ、引数で$eventオブジェクトが利用できます。  

```
- eccube.event.app.before
- eccube.event.controller.[route].before
- eccube.event.controller.[route].after
- eccube.event.app.after
- eccube.event.controller.[route].finish
```

そのため、EC-CUBE 3.0.10以前との互換を保つためには、$eventオブジェクトの有無に応じた分岐処理が必要となります。  

```
public function onXxxBefore($event = null)
{
    // 処理...

    if ($event) {
        // 3.0.11以降
        $response = $this->app->redirect($this->app->url('xxx'));
        $event->setResponse($response);
        return;
    } else {
        // 3.0.10以前
        header('Location: '.$this->app->url('xxx'));
        exit;
    }
}
```

### B) コントローラーの処理をexitで終了している場合

下記のような実装では、`exit`で終了するため、EC-CUBE側に処理が戻らず、それ以前でのDB操作が反映されません。  

__修正前__

```
public function index(Application $app, Request $request)
{
    // 処理...
    
    if ($request->getMethod() === 'POST') {
        // 処理...
    }

    exit;
}
```

__修正後__ ： Responsオブジェクトを生成するなど、必ずResponsをreturnしてください  

```
use Symfony\Component\HttpFoundation\Response;

public function index(Application $app, Request $request)
{
    // 処理...
    
    if ($request->getMethod() === 'POST') {
        // 処理...
    }

    return new Response( 
        'Content', 
        Response::HTTP_OK, 
        array('content-type' => 'text/html') 
    );
}
```

## 2) EC-CUBE 3.0.9以降のフックポイントを利用したリファクタリングポイント

3.0.9で追加されたフックポイントを利用している場合は、既に$eventオブジェクトが利用可能です。  
可能であれば、3.0.9で追加されたフックポイントを利用することをおすすめします。  
以下に、旧フックポイントと、新しいフックポイントとの対比表を記載します。  

|3.0.8                                  |          3.0.9以降                       |
|---------------------------------------|-----------------------------------------|
|eccube.event.app.before                |     eccube.event.front.request          |
|                                       |     eccube.event.admin.request          |
|eccube.event.controller.[route].before |     eccube.event.route.[route].request  |
|eccube.event.controller.[route].after  |     eccube.event.route.[route].response |
|eccube.event.app.after                 |     eccube.event.front.response         |
|                                       |     eccube.event.admin.response         |
|eccube.event.controller.[route].finish |     eccube.event.route.[route].terminate|

3.0.9で追加されたフックポイントの一覧については
「[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf){:target="_blank"}」の8ページもご参照ください。

## 3) プラグイン仕様書について

「[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf){:target="_blank"}」には、今回の変更点のほか、プラグイン実装時にあたっての注意事項等を記載しています。  
合わせてご確認ください。  

## 4) 変更更内容の詳細

本変更内容については、以下のIssueとPull Requestにて詳細なコードや仕様を御確認いただけます。  

+ Issue:　[https://github.com/EC-CUBE/ec-cube/issues/1518](https://github.com/EC-CUBE/ec-cube/issues/1518){:target="_blank"}
+ Pull Request：　[https://github.com/EC-CUBE/ec-cube/pull/1632](https://github.com/EC-CUBE/ec-cube/pull/1632){:target="_blank"}


