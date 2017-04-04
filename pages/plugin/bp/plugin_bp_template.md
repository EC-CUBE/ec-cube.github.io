---
title: テンプレート
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_template
folder: plugin/bp
---


プラグインではテンプレートを差し込む場合、イベントを通じて差し込みます。  


### テンプレートファイルの配置場所
テンプレートファイルは本体と同じくResourceディレクトリ配下に置きます。

```
[プラグインコード]
  ├── Resource
  │   └── template
  │           ├── admin
  │           │   └── XXXX.twig
  │           └── XXXX.twig
```


### テンプレートイベント

EC-CUBE3.0.9からは既存画面に対して項目などの追加を行う場合、テンプレートイベントを利用します。

拡張を行いたい画面に対してイベントを指定するには、本体側のControllerにある

```php
return $app->render('Shopping/complete.twig', array(
```
とtwigファイルを指定している部分がそのままイベント名となります。  
event.ymlには、

```yaml
Shopping/index.twig:
    - [onShoppingIndexRender, NORMAL]
```
とイベント名を指定します。管理画面の場合、

```php
return $app->render('Order/index.twig', array(
```
とController側でtwigが指定されていた場合、  
event.ymlには

```yaml
Admin/Order/index.twig:
    - [onAdminOrderIndexRender, NORMAL]
```
と`Admin/`をつける必要があります。

### テンプレートイベントによる拡張
既存画面に対して拡張を行うにはテンプレートイベントに対する処理を実装する必要があります。 formを項目として追加したい場合、

- XXXXEvent.php
{% highlight php %}
public function onShoppingIndexRender(TemplateEvent $event)
{
    $parameters = $event->getParameters();
    $form = $parameters['form'];
    $parts = $app['twig']->getLoader()->getSource('[プラグインコード]/Resource/template/parts.twig');
    // twigコードに挿入
    // 要素箇所の取得
    $search = '<div id="xxxx">';
    $replace = $parts.$search;
    $source = str_replace($search, $replace, $event->getSource());
    $event->setSource($source);
}
{% endhighlight %}

- parts.twig
{% highlight twig %}
<h2 class="heading02">ニックネームの入力</h2>
<div>{% raw %}
    {{ form_widget(form.nickname) }}
    {{ form_errors(form.nickname) }}{% endraw %}
</div>
{% endhighlight %}

XXXXEvent.phpにparts.twigの内容も記述しても良いのですが、twigファイルとEvent部分を分離することで可読性がよくなります。

また、JavaSciptタグを追加したい場合、

- XXXXEvent.php
{% highlight php %}
public function onShoppingIndexRender(TemplateEvent $event)
{
    $source = $event->getSource();

    $tag = <<< EOT
{% raw %}{% block javascript %}
<script>
    $(function() {
        alert("hoge");
    });
</script>
{% endblock javascript %}{% endraw %}
EOT;

    $event->setSource($source . $tag);
}
{% endhighlight %}



と記述すると追加可能です。
