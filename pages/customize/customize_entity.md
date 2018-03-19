---
title: Entityのカスタマイズ
keywords: core カスタマイズ Entity
tags: [core, entity]
sidebar: home_sidebar
permalink: customize_entity
folder: customize
---


---

# Entityのカスタマイズ

## Entity拡張 [#2267](https://github.com/EC-CUBE/ec-cube/pull/2267)

### 基本の拡張方法

trait と `@EntityExtension` アノテーションを使用して、 Entity のフィールドを拡張可能です。
継承を使用せずに Proxy クラスを生成するため、複数のプラグインや、独自カスタマイズからの拡張を共存できます。

``` php
<?php

namespace Acme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
  * @EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $maker_name;
}
```

`@EntityExtension` アノテーションの引数には、 trait を適用したいクラスを指定します。
trait には、追加したいフィールドを実装します。
`@ORM\Column` など、 Doctrine ORM のアノテーションを使用して、データベース定義を設定します。

trait の実装ができたら、 `bin/console eccube:generate:proxies` コマンドで Proxy クラスを生成します。

```
bin/console eccube:generate:proxies
```

Proxy を生成できたら、 `bin/console doctrine:schema:update` コマンドで、定義をデータベースに反映します。

```
## 実行する SQL を確認
bin/console doctrine:schema:update --dump-sql

## SQL を実行
bin/console doctrine:schema:update --dump-sql --force
```

#### コントローラや Twig での利用

コントローラや Twig で利用する際は、特に何も意識せずに利用可能です。


``` php
// コントローラでの使用例
public function index()
{
    $Product = $this->productRepository->find(1);
    dump($Product->maker_name);

    $Product->maker_name = 'あああ';
    $app['orm.em']->persist($Product);
    $app['orm.em']->flush();
    ...
```

``` twig
{# twig での使用例 #}
{{ Product.maker_name }}
```

### Entity からフォームを自動生成する

`@EntityExtension` アノテーションで拡張したフィールドに `@FormAppend` アノテーションを追加することで、フォームを自動生成できます。

``` php
<?php

namespace Acme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Eccube\EntityExtension("Eccube\Entity\BaseInfo")
 */
trait BaseInfoTrait
{
    /**
     * @ORM\Column(name="company_name_vn", type="string", length=255, nullable=true)
     * @Eccube\FormAppend
     * @Assert\NotBlank(message="にゅうりょくしてくださいね！！！")
     */
    public $company_name_vn;
}

```

`@FormAppend` アノテーションを追加すると、対象のエンティティを使用しているフォームに、追加したフィールドのフォームが追加されます。
入力チェックを使用したい場合は、 `@NotBlank` など [Symfony 標準のアノテーション](https://symfony.com/doc/current/reference/constraints.html) を使用できます。

フォームを詳細にカスタマイズしたい場合は、 `auto_render=false` を指定し、 `form_theme` や `type`, `option` を個別に指定します。

``` php
<?php

namespace Acme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Eccube\EntityExtension("Eccube\Entity\BaseInfo")
 */
trait BaseInfoTrait
{
    /**
     * @ORM\Column(name="company_name_vn", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="入力してください")
     * @Eccube\FormAppend(
     *     auto_render=false,
     *     form_theme="Form/company_name_vn.twig",
     *     type="\Symfony\Component\Form\Extension\Core\Type\TextType",
     *     options={
     *          "required": true,
     *          "label": "会社名(VN)"
     *     })
     */
    public $company_name_vn;
}
```
