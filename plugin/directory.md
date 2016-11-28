---
layout: default
title: ディレクトリ
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/11/27
```

# {{ page.title }}

プラグインのディレクトリ構成ですが、極力EC-CUBE3本体のディレクトリ構成に合わせる事を推奨します。
但し、全てのディレクトリが必要ではなく必要に応じてディレクトリをプラグイン側に作成してください。

### 標準的なディレクトリ構成について

一般的には以下のようなディレクトリ構成になります。

- ディレクトリ例

```
[プラグイン名]
  ├── Controller
  │   └── XXXXController.php
  ├── Entity
  │   └── XXXX.php
  ├── Form
  │   └── Type
  │       └── XXXXType.php
  ├── Migration
  │   └── VersionYYYYMMDDHHMMSS.php
  ├── Repository
  │   └── XXXXRepository.php
  ├── Resource
  │   ├── doctrine
  │   │   └── Plugin.XXXX.Entity.XXXX.dcm.yml
  │   └── locale
  │       └── message.ja.yml
  ├── Service
  │   └── XXXXService.php
  ├── ServiceProvider
  │   └── XXXXServiceProvider.php
  ├── View
  │   ├── admin
  │   │   └── XXXX.twig
  │   └── XXXX.twig
  ├── PluginManager.php
  ├── LICENSE.txt
  ├── XXXXEvent.php
  ├── config.yml
  └── event.yml
```

共通関数をまとめたクラス等が必要になった場合、

```
[プラグイン名]
  ├── Common
  │   └── XXXX.php
  ├── Util
  │   └── XXXX.php
```
と本体側と極力合わせるようにディレクトリを作成してください。

本体側に存在しないようなものについては自由に作成しても問題ありません。





