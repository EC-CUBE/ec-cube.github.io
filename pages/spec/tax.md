---
title: 税率設定
keywords: tax 
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_tax
summary: EC-CUBEでは、税率の設定について、基本税率と商品ごとの商品別税率を設定することができます。
---

## 基本税率設定

`設定 -> 店舗設定 -> 税率設定` で税率の設定が可能です。
すべての商品で共通に適用される税率です。
初期状態では、税率 **8%** が設定されています。

![基本税率の初期状態](/images/img-tax-01.png)

税率は、新たに追加することが可能です。
適用日時および税率を設定することが出来ます。

![基本税率の追加](/images/img-tax-02.png)

税率を追加した場合、適用日時以降になると、新税率に自動的に切り替わります。
適用日時以前の受注情報は、受注時点での税率/税額を保持しているため、過去に遡って変更されることはありません。

## 商品別税率設定

2019年10月に、消費税率の10％への引上げ及び軽減税率制度の導入が始まります。
軽減税率制度が導入された場合、「飲食料品」などの軽減税率対象の品目は通常の品目とは異なった税率を適用する必要があります。

消費税の軽減税率制度について
[https://www.nta.go.jp/taxes/shiraberu/zeimokubetsu/shohi/keigenzeiritsu/index.htm](https://www.nta.go.jp/taxes/shiraberu/zeimokubetsu/shohi/keigenzeiritsu/index.htm)

`設定 -> 店舗設定 -> 基本設定` の商品別税率機能を有効にすると、商品単位（正確には商品規格単位）で税率が登録できるようになります。

![商品別税率を有効にする](/images/img-tax-03.png)

規格なし商品の登録例
![規格なし商品の登録例](/images/img-tax-04.png)

規格あり商品の登録例
![規格あり商品の登録例](/images/img-tax-05.png)

商品別税率設定が有効時、税率を設定している商品はその税率で、それ以外の商品は税率設定で設定されている税率で税額が計算されます。

# 関連課題

税率機能について、以下のissueが登録されています。合わせてご確認ください。  

- [https://github.com/EC-CUBE/ec-cube/issues/4183](https://github.com/EC-CUBE/ec-cube/issues/4183)
