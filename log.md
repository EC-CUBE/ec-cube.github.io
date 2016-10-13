---
layout: default
title: EC-CUBE3でのログ設定
---

# {{ page.title }}

EC-CUBE3のログ設計指針は以下の記事の内容を参考にしています。  
<a href="http://qiita.com/nanasess/items/350e59b29cceb2f122b3" target="_blank">ログ設計指針</a>

### ログフォーマット
EC-CUBE3で出力されるログフォーマット内容は以下のように出力されます。

```
・出力フォーマット
[年-月-日 時:分:秒,ミリ秒] チャネル.ログレベル [セッションID] [プロセスID] [クラス名:関数名:ログ出力関数使用行番号] - メッセージ [context] [extra] [URL, IPアドレス, リファラー]

・出力例
[2016-10-01 12:12:12,132] front.INFO [83fdklt8] [1484] [TopController:index:34] - 処理を開始しました。 [/, 127.0.0.1, http://localhost]
```

- ログ出力内容
    - 年-月-日 時:分:秒,ミリ秒 : ログ実行時間
    - チャネル : チャネル(frontやadminなど)
    - ログレベル : ログの実行レベル(DEBUGやINFOなど)
    - セッションID : セッションID
    - プロセスID : サーバ実行した時のプロセスID
    - クラス名:関数名:ログ出力関数使用行番号 : ログ出力している行番号
    - メッセージ : ログメッセージ内容
    - context : メッセージオプション
    - extra : ログ拡張時の内容
    - URL : ログ呼び出し時のURL
    - IPアドレス : ユーザのIPアドレス
    - リファラー : ユーザのリファラー


### ログ出力レベル

- 本番環境  
INFOレベルで出力しエラーが発生した場合、エラー発生前のDEBUG情報の内容も出力されます。
但し、実行環境により出力されるDEBUG情報はどこまで出力されるかは未定です。

- 開発環境  
開発者が自由に設定可能ですが、基本的にはdebugの内容が出力されます。

ログ出力レベルは`log.yml`で変更可能です。

### ログローテーション

標準では日付毎にログファイルが作成され90日間ログファイルが保存されます。

ログローテーションは`log.yml`で変更可能です。

### アプリケーション内でのログ出力内容

- INFOレベル
    - 関数開始ログ
    - 関数終了ログ
    - 会員や受注、商品管理などでDBの登録、更新などが行われた形跡が分かるようなログ、メール送信時の成功/失敗時のログ

- ERRORレベル
    - Exception発生時のエラーの内容

- DEBUGレベル
    - HTTPの通信ログ
    - 開発時に出力したいログ

### ログ出力ファイル名

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

アプリケーション内でログを出力する場合、ログ出力専用関数が用意されておりそれを利用することでログが出力されます。

- ログ専用クラス

```
src/Eccube/Monolog/Log
```
`Monolog\Logger`クラスを継承しています。

- INFO内容出力関数  

```
public static function info($message, array $context = array())
{
    if ($this->app->isFrontRequest()) {
        // フロント画面アクセス時
        return $this->app['front.monolog']->addRecord(Logger::INFO, $message, $context);
    }
    return $this->app['admin.monolog']->addRecord(Logger::INFO, $message, $context);
}
```

- ログ出力利用方法

```
Log::info('ログ出力');
Log::info('ログ出力', array('a', 'b'));
Log::info('ログ出力', array('key' => 'value'));
```

※DIにするかどうか要検討

### ログ設定ファイル

ログの設定ファイルは
`ECCUBEROOT/src/Eccube/Resource/config/log.yml.dist`となります。個別で利用したい場合、
`ECCUBEROOT/app/config/eccube`までコピーし、ファイル名を`log.yml`としてください。

```
log:
    prefix: site_
    suffix:
    format: Y-m-d
    log_level: INFO
    action_level: DEBUG
    max_files: 90
    channel:
        monolog:
            filename: site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
        front:
            filename: front_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
        admin:
            filename: admin_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
        plugin:
            filename: plugin_site
            delimiter: _
            dateformat: Y-m-d
            log_level: INFO
            action_level: DEBUG
            max_files: 90
            log_dateformat: Y-m-d H:i:s,u
    exclude_keys:
        - password
        - app
```
