---
title: コマンドラインインターフェイス
keywords: CLI
tags: [quickstart, cli]
sidebar: home_sidebar
permalink: quickstart_cli
forder: quickstart
---

## コマンドラインインターフェイス

EC-CUBEでは、コマンドラインで実行できる各種ユーティリティコマンドを提供しています。
以下のように実行することができます。

```bash
$ cd [ec-cube ルートディレクトリ]
$ bin/console eccube:install
```

コマンド名は省略することも可能です。
コマンド名が`eccube:install`であれば、`e:i`でも実行できます。

```bash
$ bin/console e:i
```

## EC-CUBEが提供しているコマンド

EC-CUBEが提供しているコマンドの一覧と概要です。

| コマンド名               | 概要                                                               |
|--------------------------|--------------------------------------------------------------------|
| eccube:fixtures:generate | 商品や会員データのダミーデータを投入します。                       |
| eccube:fixtures:load     | 初期データを投入します。                                           |
| eccube:generate:proxies  | Entity拡張を利用している場合に、プロキシファイルの生成を行います。 |
| eccube:install           | EC-CUBEのインストールを行います。                                  |
| eccube:plugin:disable    | EC-CUBEのプラグインを無効化します。                                |
| eccube:plugin:enable     | EC-CUBEのプラグインを有効化します。                                |
| eccube:plugin:generate   | EC-CUBEのプラグインの雛形を生成します。                            |
| eccube:plugin:install    | EC-CUBEのプラグインをインストールします。                          |
| eccube:plugin:uninstall  | EC-CUBEのプラグインをアンインストールします。                      |

## SymfonyやDoctrineが提供しているコマンド

SymfonyやDoctrineが提供しているコマンドの一覧と概要です。
ここでは主要なコマンドを紹介します。

| コマンド名               | 概要                                                            |
|--------------------------|-----------------------------------------------------------------|
| cache:clear              | キャッシュを削除します。--no-warmupを指定するのが望ましいです。 |
| cache:warmup             | キャッシュの生成を行います。                                    |
| server:run               | 開発用のWebサーバを立ち上げます。                               |
| debug:router             | ルーティングの一覧を確認できます。                              |
| doctrine:database:create | データベースの作成を行います。                                  |
| doctrine:database:drop   | データベースの削除を行います。                                  |
| doctrine:schema:create   | Entityのマッピング定義を元にテーブルの生成を行います。          |
| doctrine:schema:drop     | Entityのマッピング定義を元にテーブルの削除を行います。          |
| doctrine:schema:update   | Entityのマッピング定義を元にテーブルの更新を行います。          |

## 参考

上記で紹介したコマンドの他にも、たくさんのコマンドが存在します。

コマンドの一覧は、

```bash
$ bin/console list
```

で確認できます。

また、

```bash
$ bin/console [command name] --help
```

で使い方を確認できます。
