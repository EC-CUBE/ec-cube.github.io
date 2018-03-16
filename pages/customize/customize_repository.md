---
title: リポジトリのカスタマイズ
keywords: core カスタマイズ リポジトリ
tags: [core, repository]
sidebar: home_sidebar
permalink: customize_repository
folder: customize
---


---

# リポジトリのカスタマイズ

## QueryBuilderの拡張 [#2285](https://github.com/EC-CUBE/ec-cube/pull/2285), [#2298](https://github.com/EC-CUBE/ec-cube/pull/2298)

リポジトリクラスで QueryBuilder を生成しているメソッドに対して、ソート順や検索条件をカスタマイズできます。
以下のメソッドで使用できます。

- `ProductRepository::getQueryBuilderBySearchData()`
- `ProductRepository::getQueryBuilderBySearchDataForAdmin()`
- `ProductRepository::getFavoriteProductQueryBuilderByCustomer`
- `CustomerRepository::getQueryBuilderBySearchData()`
- `OrderRepository::getQueryBuilderBySearchData()`
- `OrderRepository.getQueryBuilderBySearchDataForAdmin()`
- `OrderRepository::getQueryBuilderByCustomer()`

カスタマイズするためのインターフェイスとしては以下を提供しています。

| インターフェイス/クラス | 概要                       |
|-------------------------|----------------------------|
| QueryCustomizer         | QueryBuilderを自由に変更   |
| OrderByCustomizer       | ソート順を変更する         |
| WhereCustomizer         | 検索条件を追加する         |
| JoinCustomizer          | 結合するテーブルを追加する |

### 実装例

`ProductRepository::getQueryBuilderBySearchDataForAdmin()` において、常に商品IDでソートするサンプルです。
`getQueryKey()` メソッドで、適用したいメソッドを指定することで、自動的に有効になります。

```php
<?php


namespace Acme\Entity;


use Eccube\Doctrine\Query\OrderByClause;
use Eccube\Doctrine\Query\OrderByCustomizer;
use Eccube\Repository\QueryKey;

class AdminProductListCustomizer extends OrderByCustomizer
{
    /**
     * 常に商品IDでソートする。
     *
     * @param array $params
     * @param $queryKey
     * @return OrderByClause[]
     */
    protected function createStatements($params, $queryKey)
    {
        return [new OrderByClause('p.id')];
    }

    /**
     * ProductRepository::getQueryBuilderBySearchDataForAdmin に適用する.
     *
     * @return string
     * @see \Eccube\Repository\ProductRepository::getQueryBuilderBySearchDataForAdmin()
     * @see QueryKey
     */
    public function getQueryKey()
    {
        return QueryKey::PRODUCT_SEARCH_ADMIN;
    }
}
```

