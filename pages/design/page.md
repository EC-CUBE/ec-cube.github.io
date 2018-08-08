---
title: 新規ページの作成
keywords: design page
tags: [design]
sidebar: home_sidebar
permalink: design_page
summary: ページ管理を利用したデザイン変更について説明します。
---

## ページ管理について
EC-CUBE 4.0では「ページ管理」はページの新規追加、編集のみとなっており、ブロックのページに対する配置は [レイアウト管理](design_layout) で行うようになりました。  
ページ管理では2系、3系と同じくページの編集が可能です。


### ページ管理の新規作成

管理画面にログイン後、  
[コンテンツ管理] -> [ページ管理] 画面より「新規入力」ボタンを押してページを作成します。

![ブロック管理](/images/design/design-block-01.png)

ページ名称、URL、ファイル名には任意の一意となる名称を入力し、コード編集には表示するタグをを記述し、「登録」ボタンを押すとページが作成されます。  
但し、既にあるファイル名と同じファイル名を設定すると既存のものに上書きされます。

ページを新たに作成する場合、

{% highlight twig  %}
{% raw %}
{% extends 'default_frame.twig' %}

{% block main %}
    ここにタグを記述する
{% endblock %}{% endraw %}
{% endhighlight %}

`{% raw %}{% extends 'default_frame.twig' %}{% endraw %}` 、 `{% raw %}{% block main %}{% endraw %}` 、 `{% raw %}{% endblock %}{% endraw %}` を記述しておかないとヘッダーなどが表示されませんので必ず記述する必要があります。


### ページの削除

デフォルトで用意されているページについては削除できず、新規作成されたページのみ削除可能です。
