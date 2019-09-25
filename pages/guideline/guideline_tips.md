---
title: 開発の補助：デバッグ・Tips
keywords: tips debug 
tags: [guideline]
sidebar: home_sidebar
permalink: guideline_tips
summary: 開発やデバッグ時に便利なTipsを紹介します
folder: guideline
---
---
## デバッグモードの有効化

通常 / や/index.phpでアクセスしているところを /index_dev.php と書き換えてアクセスすることにより、デバッグモードが有効になります。  
デバッグモードでは、開発の手助けになる、WebProfilerやDebug情報が出力されるようになります。

- **/index.php**を付与してアクセスを行なった際は、以下のエラーが表示されると思います。

``` You are not allowed to access this file. Check index_dev.php for more information. ```

- その際は、index_dev.phpを開きアクセス元のIPを以下の配列に追加してください。

- 設定例

```
$allow = array(
    '127.0.0.1',
    'fe80::1',
    '::1',
);
```

- 上記はアクセス制限の設定です。

- 上記設定後に、もう一度アクセスしすると、下部にプロファイラーが表示されると思います。

---

![プロファイラー](images/tips-profiler.png)

---

- プロファイラーはSymfony2の機能です。

- 表示されたプロファイルラー上にマウスを持っていったり、クリックする事で開発に役立つ情報が確認できます。

- 以下にプロフィラーの左から順に、どういう情報を確認できるか説明を行います。

---

| 画面左からの順番 | マウスオーバー | クリック |
|------|------|------|
| 1 | シンフォニーのバージョン | symfonyのサイトに遷移 |
| 2 | PHPのバージョン | phpinfo()の内容 |
| 3 | x-debugのトークン | PHPなどの基本設定内容 |
| 4 | httpステータスコード | httpヘッダー情報 |
| 5 | レスポンスタイム | ビュー毎のレスポンスタイムのグラフ |
| 6 | メモリ使用量 | - |
| 7 | - | form関連情報 |
| 8 | Viewのレンダリングタイム | 呼びだされたView一覧 |
| 9 | 発行クエリ数 | 発行SQL一覧 |

---

#### 備考

- 以下の作業はEC-CUBE 3.0.8以上の方のみが対象となります。

* EC-CUBE 3.0.8からdump用ライブラリを導入したことにより、パッケージ版だと index\_dev.php がそのままだと使えません。  
index\_dev.php を使えるようにするためにはEC-CUBEディレクトリ直下で、以下のコマンドを入力してください。  

``` curl -sS https://getcomposer.org/installer | php ```  

を実行後、  

``` php composer.phar update symfony/var-dumper symfony/debug-bundle ```  

を入力してください。これで必要なライブラリが導入されます。

## オブジェクトの中身を確認する

- 前述した通りEC-CUBE 3.0.8からdump用の以下Symfony Componentが導入されました。
- 以下が該当コンポーネントです。

- <a href="http://symfony.com/doc/current/components/var_dumper/introduction.html" target="_blank">VarDumper Component</a>

### 利用方法

- 開発中にオブジェクトの中身を確認する際に、以下関数を呼び出してください。

```
dump([中身を確認したいオブジェクトのインスタンス]);
```

- 上記で以下の様にオブジェクトの詳細な内容が表示されます。

![dump関数の表示内容](images/tips-dump-image.png)

### 画面が真っ白になった場合の対応

- index_dev.phpからアクセスして**デバッグモード**になっていると、PHPエラーの場合は表示されますが、サーバー側のエラーの場合は、内容が表示されない事もあり、画面が真っ白になってしまうことがあります。

- その際は、以下フォルダのログを参考にデバッグを行なってください。

- **/[EC-CUBE 3のインストールディレクトリ]/app/log**

- あわせて、**PHPのログ**、**Webサーバーのログ**も参考の対象としてくだい。

- **PHPのログ**、**Webサーバーのログ**は環境により保存場所が異なりますので、ここでの詳細な説明は割愛させていただきます。

## 開発と本番でconfig.ymlを使い分ける
app/config/eccube 直下に config_dev.yml を用意することで開発環境だけの値を利用することができます。

https://github.com/EC-CUBE/ec-cube/issues/207


## メールの設定方法
インストール画面でsmtpのメールサーバ設定を行うと以下の内容が作成されます。  

```
mail:
    transport: smtp
    host: ドメイン名
    port: 587
    username: ユーザー名
    password: パスワード
    encryption: null
    auth_mode: null
```

この例ではportはOP25B対策しています。  
SSLを使われている場合、
```encryption```に```ssl```または```tls```を設定する必要があります。

Gmailの場合、

```
mail:
    transport: smtp
    host: smtp.gmail.com
    port: 465
    username: GMAILのユーザー名
    password: GMAILのパスワード
    encryption: ssl
    auth_mode: login
```

という設定で送信可能ですがGmail側で安全性の低いアプリへのアクセスを有効にする必要があります。


## メールの誤送信防止機能

config.ymlまたはconfig_dev.yml に delivery_addressを追加することで
メール誤送信を防ぐことが可能です。
delivery_addressにメールアドレスが設定されていればそのアドレスのみにメール送信されます。
但し、この機能はデバッグ環境(index_dev.phpからのみ)でしか有効になりませんのでご注意ください。

https://github.com/EC-CUBE/ec-cube/issues/195


## コンソールコマンドについて

ver3.0.1からコンソールコマンドとして、

```
php app/console router:debug
php app/console cache:clear
php app/console plugin:develop (3.0.9からパラメータを追加)
```
が用意されています。


#### router:debugの使い方
```router:debug``` の方は現在登録されているrouting情報が一覧表示されます。
ルーティングは探しやすいように、

引数の文字列でフィルタ  
sortオプション：並び順  
orderbyオプション：nameかpathのどちらかで並び替え  

が可能です。

* example:

```
php app/console router:debug
php app/console router:debug product
php app/console router:debug --orderby=name --sort=desc
php app/console router:debug --orderby=path --sort=asc
php app/console router:debug product --orderby=path
```


#### cache:clearの使い方

```cache:clear``` はapp/cache配下のキャッシュがsession情報を除いて削除され、
```cache:clear --all``` と ```--all``` を指定するとsessionのキャッシュも含めて全て削除されます。



#### plugin:developの使い方

[php app/console plugin:develop を利用したプラグイン開発](/plugin_console.html)
を参照してください。
