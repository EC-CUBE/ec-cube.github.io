---
layout: default
title: プラグインの設定、定義
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/11/27
```

# {{ page.title }}

プラグインを最低限動作させる上で必要なファイルが存在しており、そのファイルにプラグインの設定を記述する必要があります。

### プラグインの設定
プラグインを作成するには必ず`config.yml`ファイルが必要です。

```
[プラグイン名]
  └── config.yml
```

このconfig.ymlにプラグインの設定を記述します。記述する内容としては以下の通りとなります。
こちらも必要な設定のみ定義するようにしてください。

```
name: [プラグイン名]
code: [プラグインコード]
version: x.x.x
service:
    - XXXXServiceProvider
event:
    - XXXXEvent
orm.path:
    - /Resource/doctrine
const:
    AAAA_BBBB: true
    CCCC_DDDD: 10000
    EEEE_FFFF: 決済可能
```
バージョンは数値(0.1や1.0.0等々)で定義します。


config.ymlで最低限必要な内容は、

```
name: [プラグイン名]
code: [プラグインコード]
version: x.x.x
```
となります。


### メッセージの設定
EC-CUBE3本体ではエラーメッセージは極力ソースコードには記述せず、  
`ECCUBEROOT/src/Eccube/Resource/locale/message.ja.yml` に定義して利用しています。  
プラグイン側でも同様にメッセージ定義が必要になった場合、本体側にメッセージを追加できないため以下のディレクトリに配置して定義します。

```
[プラグイン名]
  ├── Resource
  │   └── locale
  │       └── message.ja.yml
```

プラグインから`message.ja.yml`を読み込むためには、`ServiceProvider`で以下のように定義します。(サービスプロバイダーについては[サービスプロバイダー](serviceprovider)で詳しく解説します)

```
// メッセージ登録
$file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
$app['translator']->addResource('yaml', $file, $app['locale']);
```

### 定数定義
プラグインでは滅多に変更しない値をオプションとして定義する場合、`config.yml`に定義して利用します。

```
const:
    AAAA_BBBB: true
    CCCC_DDDD: 10000
    EEEE_FFFF: 決済可能
```

プラグインからは、以下で呼び出すことが可能です。

```
$hoge  = $app['config']['プラグインコード']['const']['AAAA_BBBB'];
```
