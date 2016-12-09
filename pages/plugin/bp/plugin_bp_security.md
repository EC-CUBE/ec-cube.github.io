---
title: セキュリティ
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_security
---


イベントを使って拡張を行った場合、画面によりセキュリティ制御を行う必要があります。
EC-CUBE3では管理画面及びマイページに関してはログインが必須となっており、利用するイベントによってログイン状態を判断する必要があります。

ログイン必須かどうかの指定は`\Eccube\Application.php`内で行っています。

```php
$this['security.access_rules'] = array(
    array("^/{$this['config']['admin_route']}/login", 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array("^/{$this['config']['admin_route']}/", 'ROLE_ADMIN'),
    array('^/mypage/login', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/mypage/withdraw_complete', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/mypage/change', 'IS_AUTHENTICATED_FULLY'),
    array('^/mypage', 'ROLE_USER'),
);
```

### セキュリティ対応が必要なイベント

- eccube.event.render.[route].before
- eccube.event.route.[route].request (3.0.9以降)
- eccube.event.route.[route].response (3.0.9以降)


これらのイベントを利用する場合、画面によってはログインされているかどうかの確認が必要になります。

- 管理画面の場合  
全ての画面に対してチェックが必要になります。イベント実行時の最初に、

{% highlight php %}
if (!$this->app->isGranted('ROLE_ADMIN')) {
    return;
}
{% endhighlight %}

とログインしている人をチェックする必要があります。このチェックがないと、ログインしていないにも関わらずイベントの中身が実行されてしまいます。


- フロント画面の場合  
マイページなどの画面に対してチェックが必要になります。イベント実行時の最初に、

{% highlight php %}
if (!$this->app->isGranted('ROLE_USER')) {
    return;
}
{% endhighlight %}

と管理画面と同様にチェックする必要があります。



