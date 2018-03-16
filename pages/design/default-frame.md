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
フロントと管理画面のdefault_frame.twigの配置場所は以下の通りです。  

- フロント用のdefault_frame.twig  
ECCUBEROOT/src/Eccube/Resource/template/default/default_frame.twig

- 管理画面用のdefault_frame.twig  
ECCUBEROOT/src/Eccube/Resource/template/admin/default_frame.twig


各ページからは、

{% highlight twig  %}
{% raw %}
{% extends 'default_frame.twig' %}

{% block main %}
    <div class="ec-sliderRole">
        <div class="main_visual">
            <div class="item"><img src="{{ asset('img/top/mv01.jpg') }}"></div>
            <div class="item"><img src="{{ asset('img/top/mv02.jpg') }}"></div>
            <div class="item"><img src="{{ asset('img/top/mv03.jpg') }}"></div>
        </div>
    </div>
{% endblock %}{% endraw %}
{% endhighlight %}

`{% raw %}{% extends 'default_frame.twig' %}{% endraw %}` を記述し、 `{% raw %}{% block main %}{% endraw %}` と `{% raw %}{% endblock %}{% endraw %}` の間へタグを記述することで表示されるようになります。


## default_frame.twigの構成

`default_frame.twig` には各ブロックを配置できるようにブロック枠が定義されており、この枠内にブロックを配置することでフロントのレイアウト変更が可能です。  
この枠に配置するブロックは[レイアウト管理](design_layout)で定義可能です。


## フロント用のdefault_frame.twigの内容

default_frame.twigに定義されている枠はそれぞれの枠毎で配置される場所が異なり、ブロックを設定するとその枠に表示されるようになります。

### headセクション  
`<head></head>`タグ内に記述する必要のあるタグを扱うときに使用します。

{% highlight twig  %}
{% raw %}
{# Layout: HEAD #}
{% if Page.Head %}
    {{ include('block.twig', {'Blocks': Page.Head}) }}
{% endif %}
{% endraw %}
{% endhighlight %}

### <body>タグ直後  
`<body>`タグ直後に記述する必要のあるタグを扱うときに使用します。

{% highlight twig  %}
{% raw %}
{# Layout: BodyAfter #}
{% if Page.BodyAfter %}
    {{ include('block.twig', {'Blocks': Page.BodyAfter}) }}
{% endif %}
{% endraw %}
{% endhighlight %}

### #header  
レイアウト管理での`#head`枠の箇所となり、ヘッダーとして表示したいブロックを設定します。

{% highlight twig  %}
{% raw %}
{# Layout: HEADER #}
{% if Page.Header %}
    <div class="ec-layoutRole__header">
        {{ include('block.twig', {'Blocks': Page.Header}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


### #contents_top  
レイアウト管理での`#contents_top`枠の箇所となり、コンテンツ上部に表示したブロックを設定します。

{% highlight twig  %}
{% raw %}
{# Layout: CONTENTS_TOP #}
{% if Page.ContentsTop %}
    <div class="ec-layoutRole__contentTop">
        {{ include('block.twig', {'Blocks': Page.ContentsTop}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


### #side_left、#side_right  
レイアウト管理での`#side_left`、`#side_right`枠の箇所となり、左サイトで表示したブロックを設定します。

{% highlight twig  %}
{% raw %}
{# Layout: SIDE_LEFT #}
{% if Page.SideLeft %}
    <div class="ec-ec-layoutRole__left">
        {{ include('block.twig', {'Blocks': Page.SideLeft}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


{% highlight twig  %}
{% raw %}
{# Layout: SIDE_RIGHT #}
{% if Page.SideRight %}
    <div class="ec-layoutRole__mainRight">
        {{ include('block.twig', {'Blocks': Page.SideRight}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


### #main_top、#main、#main_bottom  
レイアウト管理での`#main_top`、`#main`、`#main_bottom`枠の箇所となり、  
特に重要なのが`{% raw %}{% block main %}{% endblock %}{% endraw %}`になります。  
この記述で各ページのコンテンツがこの枠に表示されます。

{% highlight twig  %}
{% raw %}
<div class="{{ layoutRoleMain }}">
    {# Layout: MAIN_TOP #}
    {% if Page.MainTop %}
        <div class="ec-layoutRole__mainTop">
            {{ include('block.twig', {'Blocks': Page.MainTop}) }}
        </div>
    {% endif %}

    {# MAIN AREA #}
    {% block main %}{% endblock %}

    {# Layout: MAIN_Bottom #}
    {% if Page.MainBottom %}
        <div class="ec-layoutRole__mainBottom">
            {{ include('block.twig', {'Blocks': Page.MainBottom}) }}
        </div>
    {% endif %}
</div>
{% endraw %}
{% endhighlight %}


### #contents_bottom  
レイアウト管理での`#contents_bottom`枠の箇所となり、コンテンツ下部に表示したブロックを設定します。

{% highlight twig  %}
{% raw %}
{# Layout: CONTENTS_BOTTOM #}
{% if Page.ContentsBottom %}
    <div class="ec-layoutRole__contentBottom">
        {{ include('block.twig', {'Blocks': Page.ContentsBottom}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


### #footer  
レイアウト管理での`#footer`枠の箇所となり、フッターとして表示したブロックを設定します。

{% highlight twig  %}
{% raw %}
{# Layout: CONTENTS_FOOTER #}
{% if Page.Footer %}
    <div class="ec-layoutRole__footer">
        {{ include('block.twig', {'Blocks': Page.Footer}) }}
    </div>
{% endif %}
{% endraw %}
{% endhighlight %}


### #drawer  
レイアウト管理での`#drawer`枠の箇所となり、レスポンシブ利用時にスマホのドロワーメニューとして利用される枠になります。

{% highlight twig  %}
{% raw %}
{# Layout: DRAWER #}
{% if Page.Drawer %}
    {{ include('block.twig', {'Blocks': Page.Drawer}) }}
{% endif %}
{% endraw %}
{% endhighlight %}

### </body>タグ直前  
`</body>`タグ直前に記述する必要のあるタグを扱うときに使用します。

{% highlight twig  %}
{% raw %}
{# Layout: BodyBefore #}
{% if Page.BodyBefore %}
    {{ include('block.twig', {'Blocks': Page.BodyBefore}) }}
{% endif %}
{% endraw %}
{% endhighlight %}

## 管理画面用のdefault_frame.twigの内容

管理画面のdefault_frame.twigにはフロントのような枠は存在していませんが、  
`{% raw %}{% block main %}{% endblock %}{% endraw %}`は必須で、その部分に各管理画面の内容が表示されます。


## フロント用のdefault_frame.twigのカスタマイズ

標準のままだと、各枠は `<div class="ec-layoutRole">` というタグで囲まれています。もし独自でデザインを作成したいという方は、  
下記のように不要なタグを削除して定義し、それぞれのデザインに合わせてタグやCSSを記述することで好きなようにデザイン可能です。

{% highlight twig  %}
{% raw %}
・
・
・
    {# Layout: HEAD #}
    {% if Page.Head %}
        {{ include('block.twig', {'Blocks': Page.Head}) }}
    {% endif %}
</head>
<body id="page_{{ app.request.get('_route') }}" class="{{ body_class|default('other_page') }}">
    {# Layout: BodyAfter #}
    {% if Page.BodyAfter %}
        {{ include('block.twig', {'Blocks': Page.BodyAfter}) }}
    {% endif %}

    {# Layout: HEADER #}
    {% if Page.Header %}
        {{ include('block.twig', {'Blocks': Page.Header}) }}
    {% endif %}

    {# Layout: CONTENTS_TOP #}
    {% if Page.ContentsTop %}
        {{ include('block.twig', {'Blocks': Page.ContentsTop}) }}
    {% endif %}

    {# Layout: SIDE_LEFT #}
    {% if Page.SideLeft %}
            {{ include('block.twig', {'Blocks': Page.SideLeft}) }}
    {% endif %}

    {# Layout: MAIN_TOP #}
    {% if Page.MainTop %}
        {{ include('block.twig', {'Blocks': Page.MainTop}) }}
    {% endif %}

    {# MAIN AREA #}
    {% block main %}{% endblock %}

    {# Layout: MAIN_Bottom #}
    {% if Page.MainBottom %}
        {{ include('block.twig', {'Blocks': Page.MainBottom}) }}
    {% endif %}

    {# Layout: SIDE_RIGHT #}
    {% if Page.SideRight %}
        {{ include('block.twig', {'Blocks': Page.SideRight}) }}
    {% endif %}

    {# Layout: CONTENTS_BOTTOM #}
    {% if Page.ContentsBottom %}
        {{ include('block.twig', {'Blocks': Page.ContentsBottom}) }}
    {% endif %}

    {# Layout: CONTENTS_FOOTER #}
    {% if Page.Footer %}
        {{ include('block.twig', {'Blocks': Page.Footer}) }}
    {% endif %}

<div class="ec-overlayRole"></div>
<div class="ec-drawerRole"></div>
<div class="ec-blockTopBtn"></div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('js/function.js') }}"></script>
<script src="{{ asset('js/eccube.js') }}"></script>
{% block javascript %}{% endblock %}
{# Layout: BodyBefore #}
{% if Page.BodyBefore %}
    {{ include('block.twig', {'Blocks': Page.BodyBefore}) }}
{% endif %}
</body>
</html>
{% endraw %}
{% endhighlight %}


