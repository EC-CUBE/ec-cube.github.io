---
layout: default
title: EC-CUBE 3.0.11 変更内容に伴うプラグインへの影響内容
---

# {{ page.title }}

EC-CUBE 3.0.11にて、プラグインによる拡張時の挙動の安定化を図るため
トランザクション管理をEC-CUBE本体側で一括して管理する修正が行われます。

具体的には、トランザクションの挙動が以下のように変更になります。

- アプリケーションの開始/終了のタイミングでトランザクションのコントロールを行う
- プラグイン側でシステムエラー等が発生した場合は、本体側も含めロールバックを行う


これに伴いご提供いただいているプラグインの実装方法によっては、EC-CUBE 3.0.11以降で、正しく動作しない可能性がございますので、ご提供のプラグインに該当の実装がないか御確認をお願いいたします。
また、EC-CUBE 3.0.9でフックポイントが多数追加されており、3.0.9からのプラグイン機構をご利用いただくとより安定したプラグインの開発が可能ですので、この機会に合わせて御確認ください。

御確認いただきたい点は以下になります。

## 1) EC-CUBE 3.0.11 以降、不具合となる可能性が高い実装と修正方法

** プラグインのフックポイントやコントローラー内で、header関数を用いたリダイレクト処理を行っている場合、EC-CUBE 3.0.11以降でリダイレクト以前に実行されたデータベス処理が反映されません。**

```
header('Location: http://xxx');
exit;
```
各修正方法は以下のようになります。

###  1-1) プラグインのフックポイントでリダイレクトを行っている場合の修正方法

フックポイント内でリダイレクトを行う場合、$eventオブジェクトにリダイレクトレスポンスをセットし、リダイレクト処理を実装してください。


+ 修正前 ： header関数を利用したリダイレクト
```
public function onXxxBefore()
{
    // 処理...

    header('Location: http://xxx');
    exit;
}
```
+ 修正後 ： $eventオブジェクトを利用したリダイレクト
```
public function onXxxBefore($event = null)
{
    // 処理...

    $response = $this->app->redirect($this->app->url('xxx'));
    $event->setResponse($response);
    return;
}
```

+ EC-CUBE 3.0.8以前のフックポイント利用時の注意点  

EC-CUBE 3.0.8以前から利用されている以下のフックポイントは、EC-CUBE3.0.11以降でのみ引数に$eventオブジェクトが利用できます。

```
- eccube.event.app.before
- eccube.event.controller.[route].before
- eccube.event.controller.[route].after
- eccube.event.app.after
- eccube.event.controller.[route].finish
```

これらのフックポイントを利用したプラグインで、3.0.10以前では$eventオブジェクトが利用できないため、3.0.10以前の後方互換を保つためには、$eventオブジェクトの有無に応じた分岐処理が必要となります。


```
public function onXxxBefore($event = null)
{
    // 処理...

    if ($event) {
        $response = $this->app->redirect($this->app->url('xxx'));
        $event->setResponse($response);
        return;
    } else {
        header('Location: '.$this->app->url('xxx'));
        exit;
    }
}
```

+ EC-CUBE 3.0.9以降のフックポイントを利用したリファクタリングポイント

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
「[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf
)」の8ページもご参照ください。


### 1-2) コントローラ内で、header/exitの実装を行っている場合の修正方法

コントローラ内でリダイレクトを行っている場合は、リダイレクトレスポンスをreturnするように修正してください。

+ 修正前 ： header関数を利用したリダイレクト
```
public function index(Application $app, Request $request)
{
    // 処理...

    header('Location: http://xxx');
    exit;
}
```
+ 修正後 ： リダイレクトレスポンスをreturnする
```
public function index(Application $app, Request $request)
{
    // 処理...

    $response = $app->redirect($app->url('xxx'));
    return $response
}
```

## 2) プラグイン仕様書について

「[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf
)」には、今回の変更点のほか、プラグイン実装時にあたっての注意事項等を記載しています。  
この機会に、合わせて御確認ください。

## 3) 変更更内容の詳細

本変更内容については、以下のIssueとPull Requestにて詳細なコードや仕様を御確認いただけます。

+ Issue:　[https://github.com/EC-CUBE/ec-cube/issues/1518](https://github.com/EC-CUBE/ec-cube/issues/1518)
+ Pull Request：　[https://github.com/EC-CUBE/ec-cube/pull/1632](https://github.com/EC-CUBE/ec-cube/pull/1632)


