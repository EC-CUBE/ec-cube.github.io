---
title: プラグイン仕様
keywords: plugin spec プラグイン 仕様
tags: [quickstart, getting_started]
sidebar: home_sidebar
permalink: plugin_spec
---

## 概要

プラグイン仕様の概要を記載します。

## ディレクトリ構成

プラグインの一般的なディレクトリ構成を示します。

```
app/Plugin/SamplePlugin/
├── Command
├── Common
│   └── Nav.php
├── Controller
├── Doctrine
│   └── Query
├── Entity
├── EventListener
│   └── EventListener.php
├── Form
│   ├── Extension
│   └── Type
├── PluginManager.php
├── Repository
├── Resource
│   ├── config
│   ├── locale
│   └── template
└── config.yml
```

上記のすべてのディレクトリ、ファイルが必要なわけではありません。
必須となるのは、`config.yml`のみです。

## 設定ファイル

プラグインの情報を記述する`config.yml`と、コンテナの定義を行う`services.yaml`があります。

### config.yml

プラグインの情報を記述します。
`[プラグインディレクトリ]/config.yml`に設置します。

設定項目は以下のとおりです。

- name: プラグイン名
    - プラグインの名称です。
- code: プラグインコード
    - プラグインの識別子となるコードです。
    - 英数の文字列のみ利用できます。
    - プラグインのディレクトリ名と同じである必要があります。
    - 他のプラグインと重複しないよう、vender名などをprefixとすることを推奨します。
- version: バージョン
    - プラグインのバージョン番号です。
    - phpのバージョンフォーマットに合わせることを推奨します。

記載例は以下の通りです。

```yaml
name: 商品レビュー
code: ProductReview
version: 1.0.0
```

### services.yaml

コンテナの定義を行います。
`[プラグインディレクトリ]/Resouce/services.yaml`に設置します。
yamlフォーマットの他に、phpやxmlでも記述可能です。

コンテナの定義については、Symfonyの公式ドキュメントを参照してください。
https://symfony.com/doc/current/service_container.html

## プラグインのパッケージング

開発したプラグインを配布したり、オーナーズストアに申請する際は、アーカイブする必要があります。
アーカイブの方式は、tar.gzで行ってください。
また、以下の点に注意してアーカイブを作成してください。
- フォルダごと圧縮しないようにする
- `.git` ディレクトリや `.DS_Store` ファイル等をアーカイブに含めないようにする

```bash
$ cd app/[PluginDir]
$ tar --exclude  ".git" --exclude ".DS_Store" -cvzf ../[PluginDir].tar.gz *
```

## 3.0.xからの変更点

3.0.xからの主な変更点を記載します。

- ServiceProviderの廃止
    - ServiceProviderで行っていたコンテナ定義は、Symfonyの機構を利用するようになりました。
- マイグレーション機構の変更
    - マイグレーションは、doctrine:schema:updateを利用するようになりました。
    - PluginManagerではマイグレーションは行わず、初期データの投入・更新・削除のみ行うようにしてください。
- フックポイントの非推奨化
    - `eccube.event.admin.request`など、リクエストの実行前後に動作するフックポイントは非推奨となりました。
    - twigファイルにパーツを差し込むために利用している場合は、スニペットを用意し、ユーザに貼り付けてもらう方式になります。
    - https://github.com/EC-CUBE/ec-cube/issues/2440
- ファイル設置のみのプラグインはロードされない
    - dtb_pluginにレコードが登録されている必要があります。
