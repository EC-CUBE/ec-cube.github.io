---
layout: default
title: EC-CUBE3でのログ設定
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/10/20
```

# {{ page.title }}


EC-CUBE3のログ設計指針は以下の記事の内容を参考にしています。  
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
INFOログの内容が出力されてエラーが発生した場合、エラー発生直前のDEBUG情報の内容も出力されます。
但し、実行環境により出力されるDEBUG情報はどこまで出力されるかは未定です。

- 開発環境  
開発者が自由に設定可能ですが、基本的にはdebugの内容が出力されます。  
index_dev.phpを実行時はDEBUGログが出力されます。

ログ出力レベルは`log.yml`で変更可能です。

### ログローテーション

標準では日付毎にログファイルが作成され90個のログファイルが保存されます。
90個を超える場合、古いファイルから削除されます。

ログローテーションは`log.yml`で変更可能です。

### アプリケーション内でのログ出力内容

- INFOレベル
    - 関数開始ログ
    - 関数終了ログ
    - 会員や受注、商品管理などでDBの登録、更新などが行われた形跡が分かるようなログ、メール送信時の成功/失敗時のログ

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

- ログ専用クラス

```
src/Eccube/Monolog/EccubeLog
```


- ログ出力方法
`EccubeLog`クラスはどのクラスからでも利用できるように実装されており、

```php
\EccubeLog::info('ログ出力');
\EccubeLog::info('ログ出力', array('a', 'b'));
\EccubeLog::info('ログ出力', array('a' => 'b'));
```

とプログラム中に記述することで利用可能です。

また、ログレベルに応じた関数を用意していますので、用途に応じて使い分けてください。  
DEBUGレベルでログを出力したい場合、

```php
\EccubeLog::debug('ログ出力');
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
    action_level: DEBUG
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
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%]'
        front:
            name: front
            filename: front_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
        admin:
            name: admin
            filename: admin_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
        plugin:
            name: plugin
            filename: plugin_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
            log_format: '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]'
    exclude_keys:
        - password
        - app
```



### プラグインからのログ出力方法

プラグインからログ出力する場合、

```
\EccubeLog::info('ログ出力');
```

と同じ内容を記述することでログが出力されます。  
また、プラグイン独自のログファイルを出力したい場合、
プラグインのServiceProvider内に

```php
$app['monolog.logger.プラグインコード] = $app->share(function ($app) {
    $config = array(
        'name' => 'プラグインコード',
        'filename' => 'ログファイル名',
        'delimiter' => '_',
        'dateformat' => 'Y-m-d',
        'log_level' => 'INFO',
        'action_level' => 'DEBUG',
        'max_files' => '90',
        'log_dateformat' => 'Y-m-d H:i:s,u',
        'log_format' => '[%datetime%] %channel%.%level_name% [%session_id%] [%uid%] [%user_id%] [%class%:%function%:%line%] - %message% %context% %extra% [%method%, %url%, %ip%, %referrer%, %user_agent%]',
    );
    return $app['eccube.monolog.factory']($config);
});
```
と記述しプログラム内からは、

```
$app['monolog.logger.プラグインコード]->info('ログ出力')
```
と記述すれば`filename`で指定したファイルに出力されます。



### プラグインでの下位互換について
ログ機能の仕組みはEC-CUBE 3.0.12から用意されたものですが、
プラグイン側では以下のようにすれば下位互換が保たれたままログ出力が可能です。

但し、ログ出力先は`$app['monolog']`で指定されているログ出力先となります。



先ず、プラグインディレクトリ直下に`EccubeLog.php`ファイルを作成します。

```
PluginCode\EccubeLog.php
```

以下の内容を`EccubeLog.php`に記述します。

```php
<?php

if (version_compare(\Eccube\Common\Constant::VERSION, '3.0.12', '>=')) {
    return;
}

if (version_compare(\Eccube\Common\Constant::VERSION, '3.0.9', '>=')) {

    $app = \Eccube\Application::getInstance();

    if (isset($app['eccube.monolog.factory'])) {
        return;
    }

    EccubeLog::init($app);

}

class EccubeLog
{

    /** @var  \Monolog\Logger */
    protected static $logger;

    public static function init($app)
    {
        self::$logger = $app['monolog'];

        $app['eccube.monolog.factory'] = $app->protect(function ($config) use ($app) {
            return $app['monolog'];
        });

    }

    public static function emergency($message, array $context = array())
    {
        self::$logger->emergency($message, $context);
    }

    public static function alert($message, array $context = array())
    {
        self::$logger->alert($message, $context);
    }

    public static function critical($message, array $context = array())
    {
        self::$logger->critical($message, $context);
    }

    public static function error($message, array $context = array())
    {
        self::$logger->error($message, $context);
    }

    public static function warning($message, array $context = array())
    {
        self::$logger->warning($message, $context);
    }

    public static function notice($message, array $context = array())
    {
        self::$logger->notice($message, $context);
    }

    public static function info($message, array $context = array())
    {
        self::$logger->info($message, $context);
    }

    public static function debug($message, array $context = array())
    {
        self::$logger->debug($message, $context);
    }
}
```

ファイル作成後、`EccubeLog.php`ファイルを読み込む必要があるため、
`EccubeLog`を利用している環境では、

```
require_once(__DIR__.'/../EccubeLog.php');
```

と利用しているプログラムから`EccubeLog.php`をrequireする必要があります。  
読み込む位置はディレクトリの場所によって適宜変更してください。

EC-CUBE 3.0.8以下にも対応する場合、ServiceProvider内に`version_compare`部分のコードも記述してください。


```php
if (version_compare(Constant::VERSION, '3.0.8', '<=')) {
    \EccubeLog::init($app);
}

$app['monolog.logger.プラグインコード] = $app->share(function ($app) {
    $config = array(
        'name' => 'プラグインコード',
        ・
        ・
        ・
```

