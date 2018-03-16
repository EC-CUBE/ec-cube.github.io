---
title: Service のカスタマイズ
keywords: core カスタマイズ Service
tags: [core, service]
sidebar: home_sidebar
permalink: customize_service
folder: customize
---


---

# Service のカスタマイズ

## カートのカスタマイズ [#2613](https://github.com/EC-CUBE/ec-cube/issues/2613)

`CartItemComparator` クラス、 `CartItemAllocator` クラスを実装することにより、カートに商品を投入した際の動作をカスタマイズ可能です。

![シーケンス図](http://www.plantuml.com/plantuml/png/hLNBRjD05DtFLyoobUY6PHP8A18IEoI-m3XJ6idDLAuBB3js7owrQ6cRD4MYfEJPHab3sqK90Jvc6CUVmSpu6JiHgOGLHHwFxxddtdFcUgLOG70PO-CLVWS0o2kwaSSbGyUQXdIuz0IA9o-H_gQeeXnK2WMnVcwWrGMtCg3ab98jj_fXV3TO140LGQfHnALrICqkjKRKil_SRtgjDYXX0q6z-7h5W7WvimlvzNXy-uEI3ZjqAAbIqwPaXv8ktIJUpIMhtumxVMOtnxqzyL3irYbfoS08Z9f7pEP17wcvHqs7clin33dZIu1A1IYO-8K6POagKuHo2L1ombbHqlVBzFT5feCA-tKAKe5mATsoP5YgHPmJ-SwhI843LKSAxzRC_GpvcIzg6Az1z_GhwrMZFN5J7W3PkXHGg6qUhwufkc9WFGTLUO_ISZzAmoxwYB7ESYckJFwEUttYZIm9r_Br3hUuK5T2Dy9_brAwVMOtt4hF5v1kcX4ijNQfLQRc9RMwKgSs9TUilCEEYTSwS6kZKBbk01wxOm8dMpIdolfVlFgs26bmmzcIqh54QtD7Hh4--Scat1pcb8n1kCDsX-xdPe93x4cnKZG3Jcq9gzsnGnjCq9x30w41EHTgdGkhclSB4ueXRHt1SNdWf_blMIi3qH3vpBjmlDy_sVjQAd6f083yapQDJfBVpZbi-bJJiEgxLF5lKPGXgMpqNlPqHaczNfMF5zOxdEdYe361fxA1lCFkjo7hVyfQrUsSkSDAR2jfrUWq9kTRPhY9Y_VKtJg8D8ap4jvNpgSS3BkfXlhNe0ldxRHo7Av2OsAy-aClvTIvWWb_qvp3KMb-qVH8G7Mdsadu-864hlWyUp0XwUnv2CtmT-3iCDVav_R5XgwkAElecORVyk6hQEg69dozcFBbb2zKrxiTiUsc68fMJvxq8-6t2oV--Fq5)


### 同じ商品・同じ商品規格でも別々の明細に分割する

標準の実装では、商品規格ごとにカートの明細が分割されます。
例えば、ギフトラッピングなどの商品オプションを追加するカスタマイズをした際、 `CartItemComparator` を実装することによって、同じ商品・同じ商品規格の場合でも、ギフトラッピングの有無によって、明細を分割することが可能です。

``` php
<?php
namespace Eccube\Service\Cart;


use Eccube\Entity\CartItem;

/**
 * 商品規格と商品オプションで明細を比較する CartItemComparator
 */
class ProductClassAndOptionComparator implements CartItemComparator
{
    /**
     * @param CartItem $Item1 明細1
     * @param CartItem $Item2 明細2
     * @return boolean 同じ明細になる場合はtrue
     */
    public function compare(CartItem $Item1, CartItem $Item2)
    {
        $ProductClass1 = $Item1->getProductClass();
        $ProductClass2 = $Item2->getProductClass();
        $product_class_id1 = $ProductClass1 ? (string) $ProductClass1->getId() : null;
        $product_class_id2 = $ProductClass2 ? (string) $ProductClass2->getId() : null;

        if ($product_class_id1 === $product_class_id2) {
            // 別途 ProductOption を追加しておく
            return $Item1->getProductOption()->getId() === $Item2->getProductOption()->getId();
        }
        return false;
    }
}

```

CartItemComparator を有効にするには、 `app/config/eccube/packages/cart.yaml` を作成し、CartItemComparator の定義を追加します。

```yaml
services:
    Eccube\Service\Cart\CartItemComparator:
      class: Eccube\Service\Cart\ProductClassAndOptionComparator

```


### 支払方法が異なる商品を同時にカートに入れられるようにする

例えば、配送方法A/B、商品A/Bがそれぞれある場合、

+ 配送方法
    + 配送方法A:  販売種別A/クレジットカード
    + 配送方法B:  販売種別A/代引き
+ 商品
    + 商品A: 販売種別A
    + 商品B: 販売種別B

EC-CUBE3.0 では、商品Aをカート入れ、次に商品Bをカートに入れようとすると「この商品は同時に購入することはできません。」というエラーになってしまう。

`CartItemAllocator` を実装することで、任意の基準で、カートを分けられるようになります。
例えば、予約商品など、 **同時にカートに投入したいが、別々に決済したい(注文を分けたい)** といったカスタマイズをすることができます。

``` php
<?php
namespace Eccube\Service\Cart;

use Eccube\Entity\CartItem;

/**
 * 販売種別と予約商品フラグごとにカートを振り分ける CartItemAllocator
 */
class SaleTypeAndReserveCartAllocator implements CartItemAllocator
{
    /**
     * 商品の振り分け先となるカートの識別子を決定します。
     *
     * @param CartItem $Item カート商品
     * @return string
     */
    public function allocate(CartItem $Item)
    {
        $ProductClass = $Item->getProductClass();
        if ($ProductClass && $ProductClass->getSaleType()) {
            $salesTypeId = (string) $ProductClass->getSaleType()->getId();
            // isReserveItem は別途追加カスタマイズをしておく
            if ($ProductClass->isReserveItem()) {
                return $salesTypeId.':R' ;
            }
            return $salesTypeId;
        }
        throw new \InvalidArgumentException('ProductClass/SaleType not found');
    }
}

```

CartItemAllocator を有効にするには、 `app/config/eccube/packages/cart.yaml` を作成し、CartItemAllocator の定義を追加します。

```yaml
services:
    Eccube\Service\Cart\CartItemAllocator:
      class: Eccube\Service\Cart\SaleTypeAndReserveCartAllocator

```


### 購入フローのカスタマイズ [#2424](https://github.com/EC-CUBE/ec-cube/pull/2424)

集計処理や、在庫チェックなどのバリデーションは、受注に関わる共通したロジックです。
従来は、CartService や ShoppingService など、利用される画面で個別に実装されており、カスタマイズ時の影響が読みづらい、再利用しにくいなどの課題がありました(たとえば、配送料の計算ロジックを変更する際には複数箇所を修正する必要があります)

集計フローを制御する PurchaseFlow と、各処理を行う Processor に分離し、ロジックを差し替えたり、新たなバリデーションを追加するカスタマイズが簡単になりました。

#### アクティビティ

全体のアクティビティは以下の通りです。

![purchaseflow-activity](https://user-images.githubusercontent.com/8196725/28450154-7bd307a0-6e20-11e7-8827-9ee85c81136d.png)

#### フローの制御の流れ

カートを例にすると、集計処理やバリデーションは以下のように実行されています。

- セッションからカートをロードする
- カート明細の、**現在の** 状態をチェックする(明細単位で整合性を担保する)
	- 商品の販売制限数のチェック
	- 商品の在庫切れのチェック
	- 公開・非公開ステータスのチェック
	- ...
- チェック結果に応じて、明細の丸め処理を行う
    - 販売制限数
    	- 販売制限数まで明細の個数を減らす
    - 商品の在庫切れ
    	- 明細を削除する(個数を0に設定)
    - 公開・非公開ステータス
    	- 明細を削除する(個数を0に設定)
    - ...
- 集計処理
    - 合計金額、配送料、手数料等の合計を集計する
- カートの、 **現在の** 状態をチェックする(明細全体で整合性を担保する)
    - 商品種別に矛盾が生じていないか
    - 支払い方法に矛盾が生じていないか
    - 購入金額上限を超えていないかどうか
- チェック結果に応じて、エラーを返す
- 集計処理
    - 合計金額、配送料、手数料等の合計を集計する

![default](https://user-images.githubusercontent.com/8196725/28610103-25570d30-7222-11e7-828c-a0a04e268df3.png)

#### クラス図

![default](https://user-images.githubusercontent.com/8196725/28611146-c9c6f83c-7225-11e7-9591-dc2e0e154cf5.png)

主要なクラスの役割は以下の通りです。

##### ItemIHoldernterface

明細一覧(明細のサマリ)を表すインターフェース。
Cart や Order が実装クラスとなります。

##### ItemInterface

明細を表すインターフェース。
CartItem や OrderItem が実装クラスとなります。

##### PurchaseFlow

明細処理や集計処理の全体のフローを制御するクラスです。
PurchaseFlow は、集計を行う [calculate()](https://github.com/EC-CUBE/ec-cube/pull/2424/files#diff-1d9b0d44b6269dc98b5c09f331ff0c41R48) と完了処理を行う [purchase()](https://github.com/EC-CUBE/ec-cube/pull/2424/files#diff-1d9b0d44b6269dc98b5c09f331ff0c41R80) メソッドを持っています。
メソッドが実行されると、Item や ItemHolder を Processor に渡し、Processor を順次実行していきます。また、Processor の実行結果を呼び出し元に返却します。

##### ItemHolderProcessor

ItemHolder(OrderやCart) に対して処理を実行する Processor です。
支払方法の整合性や、購入金額上限など、カートや注文全体の妥当性を検証します。

##### ItemProcessor

Item に 対して処理を実行する Processor です。
在庫や販売制限数など、明細の妥当性を検証します。

##### PurchaseProcessor

完了処理を行うタイミングで呼び出される Processor です。
ItemHolder に対して処理を行います。また、PurchaseContext を通じて、変更前の ItemHolderを取得することもできます。

##### PurchaseContext

実行時の状態を保持するクラスです。
呼び出し側のコントローラで、Context に情報を追加すると、各 Processor からアクセスすることができます。

##### PurchaseFlowResult

PurchaseFlow の実行結果を保持するクラスです。
ItemProcessor で発生したエラーは Warning, ItemHolderProcessor で発生したエラーは Error として扱います。

####  Processor の実装例

`EmptyProcessor::process()` がコールされると、情報ログを出力します。

``` php
<?php

namespace Plugin\PurchaseProcessors\Processor;

use Eccube\Entity\ItemInterface;
use Eccube\Service\PurchaseFlow\ItemProcessor;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\ProcessResult;

class EmptyProcessor implements ItemProcessor
{
    /**
     * @param ItemInterface $item
     * @param PurchaseContext $context
     * @return ProcessResult
     */
    public function process(ItemInterface $item, PurchaseContext $context)
    {
        log_info('empty processor executed', [__METHOD__]);
        return ProcessResult::success();
    }
}

```

`ValidatableEmptyProcessor::validate()` にて `Eccube\Service\PurchaseFlow\InvalidItemException` がスローされると、 `ValidatableEmptyProcessor::handle()` が実行され、 `PurchaseFlowResult::warn()` を返します。

``` php
<?php

namespace Plugin\PurchaseProcessors\Processor;

use Eccube\Entity\ItemInterface;
use Eccube\Service\PurchaseFlow\InvalidItemException;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\ValidatableItemProcessor;

class ValidatableEmptyProcessor extends ValidatableItemProcessor
{
    protected function validate(ItemInterface $item, PurchaseContext $context)
    {
        $error = false;
        if ($error) {
            throw new InvalidItemException('ValidatableEmptyProcessorのエラーです');
        }
    }

    protected function handle(ItemInterface $item, PurchaseContext $context)
    {
        $item->setQuantity(100);
    }
}

```

独自に作成した Processor を有効にするには、 `app/config/eccube/packages/purchaseflow.yaml` の定義を修正します。

```yaml
    eccube.purchase.flow.cart.item_processors:
        class: Doctrine\Common\Collections\ArrayCollection
        arguments:
            - #
                - '@Plugin\PurchaseProcessors\Processor\EmptyProcessor' # 追加
                - '@Eccube\Service\PurchaseFlow\Processor\DisplayStatusValidator'
                - '@Eccube\Service\PurchaseFlow\Processor\SaleLimitValidator'
                - '@Eccube\Service\PurchaseFlow\Processor\DeliverySettingValidator'
                - '@Eccube\Service\PurchaseFlow\Processor\StockValidator'
                - '@Eccube\Service\PurchaseFlow\Processor\ProductStatusValidator'
                - '@Plugin\PurchaseProcessors\Processor\ValidatableEmptyProcessor' # 追加

```
