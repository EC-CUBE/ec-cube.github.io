---
layout: default
title: EC-CUBE3でのログ設定
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/10/27
```

# {{ page.title }}


EC-CUBE3のログ設計指針は以下の記事を参考にしています。  
<a href="http://qiita.com/nanasess/items/350e59b29cceb2f122b3" target="_blank">ログ設計指針</a>

### ログフォーマット
EC-CUBE3で出力されるログフォーマット内容は以下の通りです。

```
・出力フォーマット
[年-月-日 時:分:秒,ミリ秒] チャネル.ログレベル [セッションID] [ユニークID] [会員ID] [クラス名:関数名:ログ出力行番号] - メッセージ [context] [extra] [HTTPメソッド, URL, IPアドレス, リファラー, ユーザエージェント]

・出力例
[2016-10-19 16:17:43,998398] front.INFO  [3a6d1336] [94139743] [1] [Application:Eccube\{closure}:733] - 処理を開始しました ["homepage"]  [GET, /, ::1, http://localhost/, Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12]
[2016-10-19 16:17:46,617127] front.INFO  [3a6d1336] [94139743] [1] [Application:Eccube\{closure}:834] - 処理を終了しました ["homepage"]  [GET, /, ::1, http://localhost/, Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12]
```

- ログ出力内容
    - 年-月-日 時:分:秒,ミリ秒 : ログ実行時間
    - チャネル : チャネル名(frontやadminなど)
    - ログレベル : ログの実行レベル(DEBUGやINFOなど)
    - セッションID : セッションID
    - ユニークID : サーバ実行時のユニークID(uniqidを出力)
    - クラス名:関数名:ログ出力行番号 : ログ出力しているクラスと行番号
    - メッセージ : ログメッセージ内容
    - context : メッセージ出力時のオプション
    - extra : Processor使用時のログ拡張時の内容
    - HTTPメソッド : HTTPメソッド
    - URL : ログ呼び出し時のURL
    - IPアドレス : ユーザのIPアドレス
    - リファラー : リファラー
    - ユーザエージェント : ユーザエージェント


### ログ出力レベル

- 本番環境  
標準ではINFOログの内容が出力されます。  
エラーが発生した場合、`log_level`のレベルに応じてエラー発生直前の情報の内容も出力されます。
但し、実行環境により出力される情報はどこまで出力されるかは未定です。

- 開発環境  
開発者が自由に設定可能ですが、基本的にはdebugの内容が出力されます。  
index_dev.phpを実行時はDEBUGログが出力されます。

ログ出力レベルは`log.yml`で変更可能です。

### ログローテーション

標準では日付毎にログファイルが作成され、最大90個のログファイルが保存されます。
ファイルが90個を超えた場合、一番古いファイルから削除されます。

ログローテーション、ログファイルが作成される最大ファイル数は`log.yml`で変更可能です。

### アプリケーション内でのログ出力内容

- INFOレベル
    - 関数開始ログ
    - 関数終了ログ
    - 会員や受注、商品管理などでDBの登録、更新などが行われた形跡が分かるようなログ、メール送信時のログ

- ERRORレベル
    - Exception発生時のエラー内容

- DEBUGレベル
    - HTTPの通信ログ
    - 開発時に出力したいログ

### ログ出力先及び出力ファイル名
フロント画面、管理画面実行時のログ出力先を変更しており、それぞれ以下のファイル名で出力されます。

- フロント画面実行時のログ  
```
app/log/front_site_YYYY_MM_DD.log
```

- 管理画面実行時のログ  
```
app/log/admin_site_YYYY_MM_DD.log
```

- サイト全体でのログ  
```
app/log/site_YYYY_MM_DD.log
```

ログファイル名は`log.yml`の`channel`で変更可能です。


### ログ関数の利用

アプリケーション内でログ出力する場合、ログ出力専用関数が用意されておりそれを利用することでログが出力されます。

- ログ専用関数

```
src/Eccube/Resource/functions/log.php
```


- ログ出力方法

log関数はどのクラスからでも利用できるように実装されており、

```php
log_info('ログ出力');
log_info('ログ出力', array('a', 'b'));
log_info('ログ出力', array('a' => 'b'));
```

とプログラム中に記述することで利用可能です。

また、ログレベルに応じた関数を用意していますので、用途に応じて使い分けてください。  
DEBUGレベルでログを出力したい場合、

```php
log_debug('ログ出力');
```

とレベルごとの関数を使用してください。


### ログ設定ファイルについて

ログの設定ファイルは
`ECCUBEROOT/src/Eccube/Resource/config/log.yml.dist`となります。個別で利用したい場合、
`ECCUBEROOT/app/config/eccube`までコピーし、ファイル名を`log.yml`としてください。

`log.yml.dist`では標準で以下の設定が行われています。

```yml
log:
    suffix:
    filename: site
    delimiter: _
    dateformat: Y-m-d
    log_level: INFO
    action_level: ERROR
    passthru_level: INFO
    max_files: 90
    log_dateformat: Y-m-d H:i:s,u
    log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
    channel:
        monolog:
            name: eccube
            filename: site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: ERROR
            passthru_level: INFO
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
        front:
            name: front
            filename: front_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: ERROR
            passthru_level: INFO
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
        admin:
            name: admin
            filename: admin_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: ERROR
            passthru_level: INFO
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
    exclude_keys:
        - password
        - app
```


### ログ出力のレベル指定方法、出力タイミングについて

#### ログレベルの指定方法
デフォルトではINFOで常にログ出力するように設定していますが、
`log_level`、`action_level`、`passthru_level`の内容を変更する事でログ出力レベルを変更可能です。

ログレベルの指定方法は、PSR-3のルールに則っています。  
[http://www.php-fig.org/psr/psr-3/#5-psr-log-loglevel](http://www.php-fig.org/psr/psr-3/#5-psr-log-loglevel)

- ログ出力で指定できるレベル  

```
EMERGENCY
ALERT
CRITICAL
ERROR
WARNING
NOTICE
INFO
DEBUG
```

#### ログレベルの出力タイミング

ログを出力するためには`log_level`、`action_level`、`passthru_level`で指定されたレベルで出力されますがそれぞれの内容は、

- log_level  
action_levelで指定したレベルのログが実行されればlog_levelで指定したログも一緒に出力

- action_level  
ログ出力するレベルを設定

- passthru_level  
常にログ出力するレベルを設定(log_levelとは関連しない)


標準設定ではERRORレベルのログが実行された場合、エラー発生直前のINFOレベルのログ内容も出力されます。  
また、passthuru_levelにINFOを設定しており、INFOレベルのログが常に出力されます。

ERRORレベルのログが発生した時にDEBUGレベルの内容も出力したい場合、`log_level`に`DEBUG`を設定してください。  
ただし、DEBUGレベルのログを出力するとセキュリティが弱くなる内容が出力される可能性もあるため、運用時は十分ご注意ください。

### プラグインからのログ出力方法

プラグインからログ出力する場合、

```
log_info('ログ出力');
```

と同じ関数を記述することでログが出力されます。  
また、プラグイン独自のログファイルを出力したい場合、
プラグインのServiceProvider内に

```php
$app['monolog.logger.プラグインコード'] = $app->share(function ($app) {
    $config = array(
        'name' => 'プラグインコード',
        'filename' => 'ログファイル名',
        'delimiter' => '_',
        'dateformat' => 'Y-m-d',
        'log_level' => 'INFO',
        'action_level' => 'ERROR',
        'passthru_level' => 'INFO',
        'max_files' => '90',
        'log_dateformat' => 'Y-m-d H:i:s,u',
        'log_format' => '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]',
    );
    return $app['eccube.monolog.factory']($config);
});
```
と記述しプログラム内からは、

```
$app['monolog.logger.プラグインコード']->info('ログ出力')
```
と記述すれば`filename`で指定したファイル名で`app/log`ディレクトリに出力されます。



### プラグインでの下位互換について
ログ機能の仕組みはEC-CUBE 3.0.12から用意されたものですが、  
プラグイン側では以下のようにすれば下位互換が保たれたままログ出力が可能です。

但し、ログ出力先は`$app['monolog']`で指定されているログ出力先となります。



先ず、プラグインディレクトリ直下に`log.php`ファイルを作成します。

```
PluginCode\log.php
```

以下の内容を`log.php`に記述します。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/log/log.php"></script>

ファイル作成後、`log.php`ファイルを読み込む必要があるため、
`log_info`等を利用している環境では、

```
require_once(__DIR__.'/../log.php');
```

と利用しているプログラムから`log.php`をrequireする必要があります。  
読み込む位置はディレクトリの場所によって適宜変更してください。

プラグインのServiceProviderに定義しておけば他のクラスに宣言しなくても読み込まれるようになります。

EC-CUBE 3.0.8以下にも対応する場合、ServiceProvider内に`method_exists`部分のコードも記述してください。


```php
if (!method_exists('Eccube\Application', 'getInstance')) {
    eccube_log_init($app);
}

$app['monolog.logger.プラグインコード'] = $app->share(function ($app) {
    $config = array(
        'name' => 'プラグインコード',
        ・
        ・
        ・
```

