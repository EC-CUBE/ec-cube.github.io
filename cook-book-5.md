---
layout: default
title: フォーム情報を整理して入力値チェックも追加しよう
---

---

# フォーム情報を整理して入力値チェックも追加しよう


## FormType

- 前章で作成した、フォーム定義の内容を、FormTypeに切り分けます。

- 目的としては、フォームの定義が一箇所に集まっているとメンテナンスが容易になるからです。

- EC-CUBE3でフォームを作成する際は、通常本章の方法を用います。

### FormTypeの作成

#### ファイルの作成

- 以下にFormTypeが保存されています。

1. /src/Eccube/Form/Type/Front
    - Typeフォルダまでは、「管理画面」「ユーザー画面」共通です
      1. 管理画面 : Admin
      1. ユーザー画面 : Front

#### ファイルのリネーム

- 次にBbsType.phpを作成します。

- ContactType.phpをコピー、リネームします。

- BbsType.php( 中身はContactType.phpのコピー )

```
<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Form\Type\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType  ☆名称の変更
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ☆以下を編集する
            ->add('name', 'name', array(
                'required' => true,
            ))
            ->add('kana', 'kana', array(
                'required' => false,
            ))
            ->add('zip', 'zip', array(
                'required' => false,
            ))
            ->add('address', 'address', array(
                'required' => false,
            ))
            ->add('tel', 'tel', array(
                'required' => false,
            ))
            ->add('email', 'email', array(
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ),
            ))
            ->add('contents', 'textarea', array(
                'help' => 'form.contact.contents.help',
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contact';  ☆名前を編集する
    }
}
```

- 上記を以下に変更します。

```
<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Form\Type\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BbsType extends AbstractType  ★BbsTypeに変更
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 投稿種別の配列
        $post_type = array(
                         '1' => '質問', '2' => '提案',
                     );

        $builder ★追加している項目を変更
            ->add(
            'reason',
            'choice',
            array(
                'label' => '投稿種別',
                'required' => true,
                'choices' => $post_type,
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
            )
        )
        ->add(
            'title',
            'text',
            array(
                'label' => '投稿のタイトル',
                'required' => true,
                'mapped' => false,
                'attr' => array(
                    'placeholder' => 'プラグイン作成について',
                ),
            )
        )
        ->add(
            'notes',
            'textarea',
            array(
                'label' => '内容',
                'required' => false,
                'mapped' => false,
                'attr' => array(
                    'style' => 'height:100px;',
                ),
            )
        )
        ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contact';☆名前を編集する
    }
}
```

- 上記でコントローラーに記述していた、フォーム構成を「FormType」に記述が完了いたしました。

- 次に、各項目のバリデーションの内容を追記していきます。


```
<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Form\Type\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert; ☆バリデーションを追加する際は、必ず必要となってきます。

class BbsType extends AbstractType  ★BbsTypeに変更
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 投稿種別の配列
        $post_type = array(
                         '1' => '質問', '2' => '提案',
                     );

        $builder ★追加している項目を変更
            ->add(
            'reason',
            'choice',
            array(
                'label' => '投稿種別',
                'required' => true,
                'choices' => $post_type,
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
            )
        )
        ->add(
            'title',
            'text',
            array(
                'label' => '投稿のタイトル',
                'required' => true,
                'mapped' => false,
                'attr' => array(
                    'placeholder' => 'プラグイン作成について',
                ),
            )
        )
        ->add(
            'notes',
            'textarea',
            array(
                'label' => '内容',
                'required' => false,
                'mapped' => false,
                'attr' => array(
                    'style' => 'height:100px;',
                ),
            )
        )
        ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contact';☆名前を編集する
    }
}
```

