---
title: 税率設定
keywords: tax 
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_tax
summary: EC-CUBEでは、税率の設定について、共通税率と商品ごとの個別税率を設定することができます。
---

## 共通税率設定

すべての商品で共通に適用される税率です。  
初期状態では、税率：8%、適用日時：インストール日時、が設定されています。  

![共通税率の初期状態](/images/img-tax-01.png)  

税率は、新たに追加することが可能です。  
適用日時および税率を設定することが出来ます。  

![共通税率の追加](/images/img-tax-02.png)  

税率を追加した場合、適用日時以降になると、新税率に自動的に切り替わります。  
適用日時以前の受注情報は、受注時点での税率/税額を保持しているため、過去に遡って変更されることはありません。  

## 個別税率設定

平成31年10月に、消費税率の10％への引上げ及び軽減税率制度の導入が予定されています。  
軽減税率制度が導入された場合、「飲食料品」とそれ以外の品目では異なった税率を適用する必要があります。  

消費税の軽減税率制度について  
[https://www.nta.go.jp/zeimokubetsu/shohi/keigenzeiritsu/](https://www.nta.go.jp/zeimokubetsu/shohi/keigenzeiritsu/)

個別税率設定を有効にすると、商品単位（正確には商品規格単位）で税率が登録できるようになります。  

<div style="background-color: #fdefef; margin: 2em 0 !important; padding: 1em;">
<b>注意</b>
<p>
商品別税率が反映されない不具合が報告されています。<br>
(EC-CUBE 3.0.0〜3.0.18までのバージョンが対象)<br>   
<a href = "https://github.com/EC-CUBE/ec-cube/issues/2251" target="_blank">https://github.com/EC-CUBE/ec-cube/issues/2251</a>
</p>
<p>
ソースコードの変更を行うことで修正が可能です。
</p>
<p>
修正ファイル：src/Eccube/Repository/TaxRuleRepository.php<br>   
修正内容：<a href="https://github.com/EC-CUBE/ec-cube/pull/4310/files#diff-9ebf9d0c89cef624ee2648733e557603" target="_blank">PullRequest #4310 の修正差分</a> をソースコードに反映
</p>
</div>

<div style="background-color: #fdefef; margin: 2em 0 !important; padding: 1em;">
<b>注意</b>
<p>
共通税率と商品別税率の設定順序によっては、商品別税率が正しく反映されないケースが報告されています。<br>
</p>
<p>
詳細は <a href="/workaround-product-tax-rule">商品別税率設定が適用されない不具合について</a> をご確認下さい。
</p>
</div>

![個別税率を有効にする](/images/img-tax-03.png)  

規格なし商品の登録例  
![規格なし商品の登録例](/images/img-tax-04.png)  

規格あり商品の登録例  
![規格あり商品の登録例](/images/img-tax-05.png)  

個別税率設定が有効時、税率を設定している商品はその税率で、それ以外の商品は共通税率で税額が計算されます。  

# 関連課題

税率機能について、以下のissueが登録されています。合わせてご確認ください。  

- [https://github.com/EC-CUBE/ec-cube/issues/1737](https://github.com/EC-CUBE/ec-cube/issues/1737)
- [https://github.com/EC-CUBE/ec-cube/issues/1738](https://github.com/EC-CUBE/ec-cube/issues/1738)
- [https://github.com/EC-CUBE/ec-cube/issues/1739](https://github.com/EC-CUBE/ec-cube/issues/1739)
- [https://github.com/EC-CUBE/ec-cube/issues/1740](https://github.com/EC-CUBE/ec-cube/issues/1740)
- [https://github.com/EC-CUBE/ec-cube/issues/1741](https://github.com/EC-CUBE/ec-cube/issues/1741)
