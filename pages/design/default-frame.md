---
title: デザインのフレーム構成
keywords: design default frame
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: design_default-frame
summary: デザインのベースとなるデフォルトフレームについて説明します。
---

## EC-CUBEのサイト構成

EC-CUBEでは画面を構成するために基本となるテンプレートを用意しています。  
その基本となるテンプレートが **`default_frame.twig`**となります。

default_frame.twigにはサイトで使う共通要素(headタグやヘッダー、フッター等)を記述し、このテンプレートを継承することでサイト共通となるデザインが作成できます。  
フロントと管理画面のdefault_frame.twigの配置場所は以下です。  

- フロント用のdefault_frame.twig  
`ECCUBEROOT/src/Eccube/Resource/template/default/default_frame.twig`

- 管理画面用のdefault_frame.twig  
`ECCUBEROOT/src/Eccube/Resource/template/admin/default_frame.twig`


## default_frame.twigの構成

フロント画面のレイアウト変更は管理画面の[ページ管理] → [TOPページ] → [レイアウト編集]から可能ですが、
この画面にある`head``#header``contents_top`・・・と枠で構成されている箇所はdefault_frame.twigに枠が定義されており、
この枠内にブロックを配置することでフロントのレイアウト変更が可能です。

`main`枠については各コンテンツが表示される枠となります。

![レイアウト管理](/images/design/design-default-frame-01.png)



## フロント用のdefault_frame.twigの内容

- 51〜57行目  
レイアウト管理での`head`枠の箇所となります。<head></head>タグ内に記述する必要のあるタグ等を扱うときに使用します。

{% highlight twig  %}
・
・{% raw %}
<script>window.jQuery || document.write('<script src="{{ app.config.front_urlpath }}/js/vendor/jquery-1.11.3.min.js?v={{ constant('Eccube\\Common\\Constant::VERSION') }}"><\/script>')</script>

{# ▼Head COLUMN #}
{% if PageLayout.Head %}
    {# ▼上ナビ #}
    {{ include('block.twig', {'Blocks': PageLayout.Head}) }}
    {# ▲上ナビ #}
{% endif %}
{# ▲Head COLUMN #}

</head>{% endraw %}
・
・
{% endhighlight %}

- 64〜70行目  
レイアウト管理での`#header`枠の箇所となります。ヘッダー部分を記述するときに使用します。

{% highlight twig  %}
・
・{% raw %}
<header id="header">
    <div class="container-fluid inner">
        {# ▼HeaderInternal COLUMN #}
        {% if PageLayout.Header %}
            {# ▼上ナビ #}
            {{ include('block.twig', {'Blocks': PageLayout.Header}) }}
            {# ▲上ナビ #}
        {% endif %}
        {# ▲HeaderInternal COLUMN #}
        <p id="btn_menu"><a class="nav-trigger" href="#nav">Menu<span></span></a></p>
    </div>
</header>{% endraw %}
・
・
{% endhighlight %}

- 78〜84行目  
レイアウト管理での`#contents_top`枠の箇所となります。

{% highlight twig  %}
・
・{% raw %}
<div id="contents_top">
    {# ▼TOP COLUMN #}
    {% if PageLayout.ContentsTop %}
        {# ▼上ナビ #}
        {{ include('block.twig', {'Blocks': PageLayout.ContentsTop}) }}
        {# ▲上ナビ #}
    {% endif %}
    {# ▲TOP COLUMN #}
</div>{% endraw %}
・
・
{% endhighlight %}

- 88〜96行目  
レイアウト管理での`#side_left`枠の箇所となります。

{% highlight twig  %}
・
・{% raw %}
<div class="container-fluid inner">
    {# ▼LEFT COLUMN #}
    {% if PageLayout.SideLeft %}
        <div id="side_left" class="side">
            {# ▼左ナビ #}
            {{ include('block.twig', {'Blocks': PageLayout.SideLeft}) }}
            {# ▲左ナビ #}
        </div>
    {% endif %}
    {# ▲LEFT COLUMN #}{% endraw %}
・
・
{% endhighlight %}


- 99〜105行目、108行目、111〜117行目  
レイアウト管理での`#main_top``Main``main_bottom`枠の箇所となります。  
特に重要なのが`{% raw %}{% block main %}{% endblock %}{% endraw %}`であり、
この記述で各ページのコンテンツはこの箇所に表示されます。

{% highlight twig  %}
・
・{% raw %}
<div id="main">
    {# ▼メイン上部 #}
    {% if PageLayout.MainTop %}
        <div id="main_top">
            {{ include('block.twig', {'Blocks': PageLayout.MainTop}) }}
        </div>
    {% endif %}
    {# ▲メイン上部 #}

    <div id="main_middle">
        {% block main %}{% endblock %}
    </div>

    {# ▼メイン下部 #}
    {% if PageLayout.MainBottom %}
        <div id="main_bottom">
            {{ include('block.twig', {'Blocks': PageLayout.MainBottom}) }}
        </div>
    {% endif %}
    {# ▲メイン下部 #}
</div>{% endraw %}
・
・
{% endhighlight %}


- 120〜128行目  
レイアウト管理での`#side_right`枠の箇所となります。

{% highlight twig  %}
・
・{% raw %}
{# ▼RIGHT COLUMN #}
{% if PageLayout.SideRight %}
    <div id="side_right" class="side">
        {# ▼右ナビ #}
        {{ include('block.twig', {'Blocks': PageLayout.SideRight}) }}
        {# ▲右ナビ #}
    </div>
{% endif %}
{# ▲RIGHT COLUMN #}{% endraw %}
・
・
{% endhighlight %}


- 130〜138行目  
レイアウト管理での`#contents_bottom`枠の箇所となります。

{% highlight twig  %}
・
・{% raw %}
{# ▼BOTTOM COLUMN #}
{% if PageLayout.ContentsBottom %}
    <div id="contents_bottom">
        {# ▼下ナビ #}
        {{ include('block.twig', {'Blocks': PageLayout.ContentsBottom}) }}
        {# ▲下ナビ #}
    </div>
{% endif %}
{# ▲BOTTOM COLUMN #}

</div>{% endraw %}
・
・
{% endhighlight %}

- 143〜149行目  
レイアウト管理での`#footer`枠の箇所となります。

{% highlight twig  %}
・
・{% raw %}
<footer id="footer">
    {# ▼Footer COLUMN#}
    {% if PageLayout.Footer %}
        {# ▼上ナビ #}
        {{ include('block.twig', {'Blocks': PageLayout.Footer}) }}
        {# ▲上ナビ #}
    {% endif %}
    {# ▲Footer COLUMN#}

</footer>

</div>{% endraw %}
・
・
{% endhighlight %}


管理画面のdefault_frame.twigには`#main_top``Main``main_bottom`・・枠は存在していませんが、  
`{% raw %}{% block main %}{% endblock %}{% endraw %}`は必須で、その部分に各管理画面の内容が表示されます。






