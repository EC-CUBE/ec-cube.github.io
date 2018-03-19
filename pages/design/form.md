---
title: フォームレイアウトの変更
keywords: design 
tags: [design]
sidebar: home_sidebar
permalink: design_form
summary: フォームレイアウトを変更する方法を説明します。
---

## フォーム画面の構成
フォームを画面を作成する場合、`<input type="text" name="hoge">`とinputタグを直接記述せず、Twig関数を利用してフォーム画面を作成します。  

フォームをより詳しく理解するにはSymfonyのサイトをご確認ください。  
[https://symfony.com/doc/current/forms.html](https://symfony.com/doc/current/forms.html)  
[https://symfony.com/doc/current/best_practices/forms.html](https://symfony.com/doc/current/best_practices/forms.html)

## フォーム内容の出力方法
Twigではフォーム画面を作成する場合、専用の出力関数と変数を利用して作成します。

```twig
{% raw %}{{ form(form) }}{% endraw %}
→引数にあるformとは、Controllerから渡されたkey名
```
このように記述するとフォーム項目が表示されます。
また、指定したフィールドを出力したい場合、

```twig
{% raw %}{{ form_row(form.name) }}{% endraw %}
や
{% raw %}{{ form_widget(form.name) }}{% endraw %}
```
と記述します。

## フォームレイアウトの変更
フォーム画面を作成する場合、form関数を利用すると自動的にタグが付加されてフォーム画面が作成されるようになりますが、デザインによってはフォーム画面を変更したい時があります。

EC-CUBE3ではフォーム内容を出力するためのテンプレート`form_div_layout.twig`が用意されており、このファイルの内容を修正することでフォーム出力時のデザインを変更することが可能です。

フロントと管理画面のform_layout.twigの配置場所です。

- フロント用のform_layout.twig  
ECCUBEROOT/src/Eccube/Resource/template/default/Form/form_div_layout.twig

- 管理画面用のform_layout.twig  
ECCUBEROOT/src/Eccube/Resource/template/admin/Form/form_div_layout.twig

## フロント画面で利用しているform_div_layout.twigの内容

form_div_layout.twigの内容は `block` で定義されている関数(form_errorsやform_labelなど)を独自に上書きしています。  
blockの後に続く `form_errors` や `form_label` がTwig関数と対応しています。

### form_dev.layoutの中身

{% highlight twig  %}
{% raw %}
{#
 - form_div_layout.html.twig
 - https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig
#}
{%- extends 'form_div_layout.html.twig' -%}

{%- block form_errors -%}
    {%- if errors|length > 0 -%}
        {%- for error in errors -%}
            <p class="ec-errorMessage">{{ error.message|trans({}, translation_domain) }}</p>
        {%- endfor -%}
    {%- endif -%}
{%- endblock form_errors -%}

{%- block form_label -%}
    {{ parent() }}
    {%- if required -%}
        <span class="ec-required">{{'common.text.message.required'|trans}}</span>
    {%- endif -%}
{%- endblock form_label -%}

{% block choice_widget %}
    {% if type is defined and type == 'hidden' %}
        {{ block('form_widget_simple') }}
    {% else %}
        {{ parent() }}
    {% endif %}
{% endblock %}

{%- block textarea_widget -%}
    {% if type is defined and type == 'hidden' %}
        {{ block('form_widget_simple') }}
    {% else %}
        {{ parent() }}
    {% endif %}
{%- endblock textarea_widget -%}
{% endraw %}
{% endhighlight %}


例えば、form_errorsを使ってエラーメッセージ表示のデザインを変更したい場合、

```twig
{% raw %}{%- block form_errors -%}
    {%- if errors|length > 0 -%}
        <ul>
        {%- for error in errors -%}
            <li>{{ error.message|trans({}, translation_domain) }}</li>
        {%- endfor -%}
        </ul>
    {%- endif -%}
{%- endblock form_errors -%}{% endraw %}
```

pタグをulタグに変更することでエラーメッセージ出力時の表示内容を変更できます。

他のtwig関数も同様に、blockで定義されている内容を変更することでデザイン変更が可能です。

## フロント画面でのフォームデザインの使い方

フロント画面からformを利用する場合、 `{% raw %}{% form_theme form 'Form/form_div_layout.twig' %}{% endraw %}` を明示的に記述する必要があります。  
これはformに対してどのformテーマを利用するかを宣言するものです。

### 利用方法

```twig
{% raw %}{% extends 'default_frame.twig' %}

{% form_theme form 'Form/form_div_layout.twig' %}

{% block main %}
・
・
・
{{ form_widget(form.name.name01, {'attr': {'placeholder': 'signup.label.family_name'}}) }}
・
・
・
{% endblock %}{% endraw %}
```

上記にある、

```twig
{% raw %}{% form_theme form 'Form/form_div_layout.twig' %}{% endraw %}
```

や

```twig
{% raw %}{{ form_widget(form.name.name01, {'attr': {'placeholder': 'signup.label.family_name'}}) }}{% endraw %}
```

に出現する `form` はControllerから渡されるパラメータ名です。  
Controllerから `form1` として渡された場合、

```twig
{% raw %}{% form_theme form1 'Form/form_div_layout.twig' %}{% endraw %}
```

や

```twig
{% raw %}{{ form_widget(form1.name.name01, {'attr': {'placeholder': 'signup.label.family_name'}}) }}{% endraw %}
```

と記述する必要があります。

フォームのカスタマイズをより詳しく知りたい方はSymfonyのサイトをご確認ください。  
[http://symfony.com/doc/current/form/form_customization.html](http://symfony.com/doc/current/form/form_customization.html)
