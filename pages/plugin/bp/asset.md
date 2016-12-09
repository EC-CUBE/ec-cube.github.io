---
layout: default
title: リソースファイル、ブロック
---

# {{ page.title }}

プラグインで画像ファイルやCSSファイルなどのリソースファイルを利用する場合、EC-CUBE本体の公開ディレクトリへリソースファイルをコピーする必要があります。


### リソースファイルの配置場所

```
[プラグインコード]
  ├── Resource
  │   ├── assets
  │   │   ├── css
  │   │   │   └── xxxx.css
  │   │   ├── img
  │   │   │   ├── xxxx.gif
  │   │   │   ├── xxxx.jpg
  │   │   │   └── xxxx.png
  │   │   └── js
  │   │       └── xxxx.js
```

`assets`ディレクトリ配下のものを本体側の公開ディレクトリへコピーします。


### 本体側へのコピー

本体側へコピーする方法はいくつかありますが、[プラグインマネージャー](pluginmanager)内で行うのが一番簡単です。

コピー先のディレクトリですが、

```
ECCUBEROOT
├── app
│   ├── Plugin
│   │   ├── [プラグインコード]
│   │   │   ├── Resource
│   │   │   │   ├── assets
│   │   │   │   │   ├── css
│   │   │   │   │   │   └── xxxx.css
│   │   │   │   │   ├── img
│   │   │   │   │   │   ├── xxxx.gif
│   │   │   │   │   │   ├── xxxx.jpg
│   │   │   │   │   │   └── xxxx.png
│   │   │   │   │   └── js
│   │   │   │   │       └── xxxx.js

〜
〜

├── html
│   ├── plugin
│   │   ├── [プラグインコード(全て小文字)]
│   │   │   └── assets
│   │   │   ├── css
│   │   │   │   └── xxxx.css
│   │   │   ├── img
│   │   │   │   ├── xxxx.gif
│   │   │   │   ├── xxxx.jpg
│   │   │   │   └── xxxx.png
│   │   │   └── js
│   │   │       └── xxxx.js
```


`html`ディレクトリ直下の`plugin`ディレクトリ内にプラグインコードでディレクトリを作成して配置します。ディレクトリを作成する場合、全て小文字でプラグインコードを作成した方が大文字を区別しなくて済むのでオススメです。


### ブロックの場合

リソースファイルではないのですが、プラグインでブロックを追加したい時があります。その場合、リソースファイルと同様に本体側へコピーする必要があります。
こちらも同様にプラグインマネージャー内でコピーを行う方法が簡単です。

```
ECCUBEROOT
├── app
│   ├── Plugin
│   │   ├── [プラグインコード]
│   │   │   ├─ Resource
│   │   │   │        └── template
│   │   │   │           ├── Block
│   │   │   │           │   └── XXXX.twig
│   │   │   │           ├── admin
│   │   │   │           │   └── XXXX.twig
│   │   │   │           └── XXXX.twig
│   ├── template
│   │   ├── default
│   │   │   ├─ Block
│   │   │   │      └── template
│   │   │   │         ├── admin
│   │   │   │         └── default
│   │   │   │             ├── Block
│   │   │   │             │         └── XXXX.twig
```

- ブロックファイルのコピー例

```
$file = new Filesystem();
// ブロックファイルをコピー
$file->copy('コピー元ファイル', $app['config']['block_realdir'] . '/' . 'コピー先ファイル名');
```


また、ブロック追加時は`dtb_block`テーブルへ追加する必要があります。

```php
$DeviceType = $app['eccube.repository.master.device_type']->find(DeviceType::DEVICE_TYPE_PC);

$Block = $app['eccube.repository.block']->findOrCreate(null, $DeviceType);

// Blockの登録
$Block->setName('ブロック名')
                ->setFileName('ブロックファイル名');
                ->setDeletableFlg(Constant::ENABLED);

$em->persist($Block);
$em->flush($Block);
```

※本体側でトランザクション制御をしれくれるため、ロールバック処理などは必要ありません。


### リソースファイルの削除

プラグインを削除する場合、リソースファイルを削除するのを忘れないでください。

