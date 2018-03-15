---
title: 通貨
keywords: currency
tags: [i18n, currency]
sidebar: home_sidebar
permalink: i18n_currency
forder: i18n
---

# 概要

初期設定では、通貨の表示は日本円で表示されます。
環境変数で指定することにより、日本円以外の通貨を表示することができます。

# 通貨表示の切り替え

環境変数でロケール/通貨コードを指定し、通貨表示を切り替えることができます。

EC-CUBEのルートディレクトリ直下に、`.env`ファイルを作成し、`ECCUBE_LOCALE`および`ECCUBE_CURRENCY`を設定します。

```bash
//.env

ECCUBE_LOCALE=en
ECCUBE_CURRENCY=USD
```

環境変数設定後、画面をリロードすると、通貨表示が切り替わります。
キャッシュの削除を行う必要はありません。

# PriceType

金額の入力項目について、`MoneyType`を拡張した、`PriceType`を実装しています。
`PriceType`は`ECCUBE_CURRENCY`の設定値にもとづいて、scaleを動的に判定します。

例えば、JPYが指定されている場合はscaleは0です。
EURであればscaleは2が設定され、小数点2桁まで入力が可能になります。
※scaleを超える値を入力した場合は四捨五入されます。

以下は、locale: de_DE, currency: EURの設定時の表示です。

![通貨の入力フォーム](https://user-images.githubusercontent.com/8196725/28563341-a97be788-7160-11e7-886c-96bbe3c79566.png)

# priceフィルタ

twig上で金額を表示する際は、priceフィルタを利用することができます。
通貨の表示文字や表示方向を制御してくれます。

以下のように使用します。

```
{{ 123|price }}
```

![通貨の表示](https://user-images.githubusercontent.com/8196725/28563890-5e370800-7162-11e7-9015-b2eab14ab726.png)


# 参考

通貨の切り替え機構を追加
https://github.com/EC-CUBE/ec-cube/pull/2431