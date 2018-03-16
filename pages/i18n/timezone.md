---
title: タイムゾーン
keywords: timezone
tags: [i18n, currency]
sidebar: home_sidebar
permalink: i18n_timezone
forder: i18n
---

# 概要

初期設定では、タイムゾーンはAsia/Tokyoに設定されています。
環境変数で指定することにより、Asia/Tokyo以外のタイムゾーンを使用することができます。

# タイムゾーンの切り替え

環境変数でタイムゾーンを指定し、タイムゾーンを切り替えることができます。

EC-CUBEのルートディレクトリ直下に、`.env`ファイルを作成し、`ECCUBE_TIMEZONE`を設定します。

```bash
//.env

ECCUBE_TIMEZONE=Asia/Tokyo
```

環境変数設定後、画面をリロードすると、タイムゾーンが切り替わります。
キャッシュの削除を行う必要はありません。

# 日時データの保存と表示

日時データは、データベースの内部的にはすべてUTCで保存されます。
フォーム等で入力されたデータは、データベースの登録時にUTCに変換され保存されます。
逆に、データベースから取得するデータは、取得時に`ECCUBE_TIMEZONE`で設定したタイムゾーンに変換されます。

# 参考

日時データ型の対応
https://github.com/EC-CUBE/ec-cube/pull/2308