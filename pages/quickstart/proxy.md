---
title: プロキシサーバの設定
keywords: howto proxy 
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: quickstart_proxy
summary : プロキシサーバの設定について解説します。
---

リバースプロキシ、ロードバランサーを利用してサイトを構成する場合の設定方法について解説します。

この設定を行うことで、EC-CUBEへのリクエストをリバースプロキシ・ロードバランサーからのリクエストとして扱うようになります。

EC-CUBEのセキュリティオプションで「サイトへのアクセスを、SSL（https）経由に制限します」を有効してリダイレクトループが発生する場合は、この設定を行うことで回避できるようになります。


![サイト構成の例](/images/proxy_settings/network_diagram.png)  

## 対象
EC-CUBE 3.0.14 以降

## インストール時の設定方法

インストールの「サイトの設定」ページ  
`オプションを表示 > ロードバランサー、プロキシサーバの設定` で、Proxyサーバーの設定ができます。

![インストーラのオプション](/images/proxy_settings/install_options.png)  

サイトが信頼されたロードバランサー、プロキシサーバからのみアクセスされる  
- このオプションをONにした場合、全てのリクエストを信頼されるプロキシサーバからのリクエストとして扱うようになります。  
- 信頼されるプロキシサーバ以外からのトラフィックを防いだサーバー環境でのみ、このオプションを利用してください。
    
ロードバランサー、プロキシサーバのIP  
- 個別にプロキシサーバを指定する場合は、ここのIPアドレスを入力してください。  
- サブネットマスクを利用したCIDR表記も可能です。

## config.yml

インストール後は、config.ymlを編集することで設定を変更できます。

```yaml
[app/config/eccube/config.yml]

trusted_proxies_connection_only: true
trusted_proxies:
    - 127.0.0.1/8
    - '::1'
```

trusted_proxies_connection_only
- 「サイトが信頼されたロードバランサー、プロキシサーバからのみアクセスされる」オプション。

trusted_proxies
- 「ロードバランサー、プロキシサーバのIP」オプション。
- EC-CUBE自身からのサブリクエストを処理する必要があるため、ローカルループバックアドレスは削除しないでください。

## 制限事項

EC-CUBEがプロキシサーバからのリクエストを適切に処理するためには、プロキシサーバがリクエストに`X-Forwarded-*`ヘッダーを付与している必要があります。

## 参考情報

Symfony - How to Configure Symfony to Work behind a Load Balancer or a Reverse Proxy  
[http://symfony.com/doc/2.7/request/load_balancer_reverse_proxy.html](http://symfony.com/doc/2.7/request/load_balancer_reverse_proxy.html)

## 補足：さくらのレンタルサーバでの設定について

さくらのレンタルサーバーでSNI SSLを利用した場合、「https://」についてはプロキシとして動作しますが、制限事項にある`X-Forwarded-*`ヘッダーが付与されないため上記設定をしてもリダイレクトループが発生してしまいす。

html/.htaccess にある下記のコードを有効化して対処してください。

```.htaccess
# さくらのレンタルサーバでサイトへのアクセスをSSL経由に制限する場合の対応
RewriteCond %{HTTP:x-sakura-forwarded-for} !^$
RewriteRule ^(.*) - [E=HTTPS:on]
```
