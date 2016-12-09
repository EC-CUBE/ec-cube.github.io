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

フォームをより詳しく理解するにはSymfony2のサイトをご確認ください。  
[http://docs.symfony.gr.jp/symfony2/book/forms.html](http://docs.symfony.gr.jp/symfony2/book/forms.html)

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

EC-CUBE3ではフォーム内容を出力するためのテンプレート`form_layout.twig`が用意されており、このファイルの内容を修正することでフォーム出力時のデザインを変更することが可能です。

フロントと管理画面のform_layout.twigの配置場所です。

- フロント用のform_layout.twig  
`ECCUBEROOT/src/Eccube/Resource/template/default/Form/form_layout.twig`

- 管理画面用のform_layout.twig  
`ECCUBEROOT/src/Eccube/Resource/template/admin/Form/form_layout.twig`

## フロント画面で利用しているdefault_frame.twigの構成

default_frame.twigの内容には`block`がそれぞれ定義されており、  
blockの後に続く`form_widget_compoud` `form_widget`がTwig関数と対応しています。  

例えば、form_errorsを使ってエラーメッセージ表示のデザインを変更したい場合、

```twig
{% raw %}{% block form_errors -%}
    {% if errors|length > 0 -%}
        {% if form.parent %}
            {%- for error in errors -%}
                <p class="errormsg text-danger">{{ error.message |trans }}</p>
            {%- endfor -%}
        {%- endif %}
    {%- endif %}
{%- endblock form_errors %}{% endraw %}
```
と記述されている箇所を、

```twig
{% raw %}{% block form_errors %}
    {% spaceless %}
        {% if errors|length > 0 %}
        <ul>
            {% for error in errors %}
                <li>{{ error.message }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endspaceless %}
{% endblock form_errors %}{% endraw %}
```
pタグをulタグに変更することでエラーメッセージ出力時の表示内容を変更できます。

他のtwig関数も同様に、blockで定義されている内容を変更することでデザイン変更が可能です。

フォームのカスタマイズをより詳しく知りたい方はSymfony2のサイトをご確認ください。  
[http://docs.symfony.gr.jp/symfony2/cookbook/form/form_customization.html](http://docs.symfony.gr.jp/symfony2/cookbook/form/form_customization.html)

