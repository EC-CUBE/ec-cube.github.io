---
title: FormTypeのカスタマイズ
keywords: core カスタマイズ FormType
tags: [core, formtype]
sidebar: home_sidebar
permalink: customize_formtype
folder: customize
---


---

## FormExtensionを使った拡張

FormExtensionの仕組みを利用すれば、既存のフォームをカスタマイズすることができます。

### 拡張方法

`./app/Acme/Form/Extension/` に `AbstractTypeExtension` を継承したクラスファイルを作成することで、自動的にFormExtensionとして認識されます。

#### 拡張するフォーム種類の指定

getExtendedType関数は必ず実装し、拡張するフォームの種類を指定する必要があります。

```php
public function getExtendedType()
{
    return EntryType::class;
}
```

#### 拡張用の関数

以下の関数をオーバーライドし、引数で渡されるパラメータを変更することでフォームのカスタマイズが可能です。

- buildForm()
- buildView()
- configureOptions()
- finishView()

EC-CUBE 3.nでは、Symfonyの詳細はSymfonyのFormExtensionの仕組みを利用しています。  
拡張方法の詳細についてはSymfonyのドキュメントを参照してください。
https://symfony.com/doc/current/form/create_form_type_extension.html

### サンプル

会員登録ページのフォームを拡張して、会社名を入力必須項目に変更するサンプルです。

./app/Acme/Form/Extension/EntryTypeBirthdayExtension.php

```php
<?php

namespace Acme\Form\Extension;

use Eccube\Form\Type\Front\EntryType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntryTypeBirthdayExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = $builder->get('company_name')->getOptions();

        $options['required'] = true;
        $options['constraints'] = [ new NotBlank() ];
        $options['attr']['placeholder'] = '会社名';

        $builder->add('company_name', TextType::class, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return EntryType::class;
    }
}

```

## Entityからフォームを生成する拡張

Entityカスタマイズの頁を参照してください。  ## TODO リンクを貼る

