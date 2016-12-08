---
layout: default
title: プラグインの設定、定義
---

# {{ page.title }}

プラグインを動作させるためには最低限必要な設定ファイルが存在し、そのファイルにプラグインの設定を記述します。

### プラグインの設定
プラグインを作成するには必ず`config.yml`ファイルが必要です。

```
[プラグインコード]
  └── config.yml
```

このconfig.ymlにプラグインの設定を記述します。記述する内容としては以下の通りです。  
この内容はすべての設定を記述していますが、必要のない設定は定義する必要はありません。

```
name: [プラグイン名]
code: [プラグインコード]
version: [バージョン(1.0.0や1.1.5など)]
service:
    - XXXXServiceProvider
event:
    - XXXXEvent
orm.path:
    - /Resource/doctrine
const:
    aaaa: true
    bbbb: 10000
    cccc: 決済可能
```
versionは数値(0.1や1.0.0等々)で定義します。  

プラグインを動作させる上でconfig.ymlで最低限必要な内容は、

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
[プラグインコード]
  ├── Resource
  │   └── locale
  │       └── message.ja.yml
```

プラグインから`message.ja.yml`を読み込むためには、`ServiceProvider`で以下のように定義します。(サービスプロバイダーについては[サービスプロバイダー](serviceprovider)で解説します)

```
// メッセージ登録
$file = __DIR__.'/../Resource/locale/message.'.$app['locale'].'.yml';
$app['translator']->addResource('yaml', $file, $app['locale']);
```

### 定数定義
プラグインでは滅多に変更しない値をオプションとして定義する場合、`config.yml`に定義して利用可能です。

```
const:
    aaaa: true
    bbbb: 10000
    cccc: 決済可能
```

プラグインからは、以下で呼び出すことが可能です。

```
$hoge  = $app['config']['プラグインコード']['const']['aaaa'];
```
