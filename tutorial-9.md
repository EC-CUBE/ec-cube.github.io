---
layout: default
title: データーベースに登録してみよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. エンティティマネージャーの取得方法を説明します。

    1. エンティティにデーターを登録する方法を説明しています。

    1. エンティティマネージャーでエンティティを管理する方法を説明します。

    1. エンティティマネージャーで情報を登録する方法を説明します。

## エンティティマネージャーを利用した情報の登録

- 前章では、エンティティの概要と、ファイルの作成方法を説明しました。

- ここまでの章で、**dtb_crud**、**Eccube.Entity.Crud.dcm.yml**、**Crud.php**を作成しました。

- 作成物が揃ったために、この章では、エンティティマネージャーでデーターベースにデータを登録します。

## コントローラーの修正

- 以下のコントローラーを修正していきます。
    - /src/Controller/Default/CrudController.php

    1. ファイルを開いて以下の様に修正します。

        - **CrudController.php**

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


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Crud;
use Symfony\Component\HttpFoundation\Request;

class CrudController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        // Crudエンティティをインスタンス化
        $Crud = new \Eccube\Entity\Crud(); ★前章で作成した、Crud用のエンティティ(データモデルオブジェクト)をインスタンス化します。

        $builder = $app['form.factory']->createBuilder('crud', $Crud); ★ビルダーを取得する際に、第二引数にBbsのエンティティを渡します。

        $form = $builder->getForm();

        $form->handleRequest($request); ★リクエストオブジェクトとフォームオブジェクトを結びつける

        $message = array('default' => '');

        if ($form->isSubmitted() && $form->isValid()) {
            $message = array('success' => '入力値に問題はありません');
            $app['orm.em']->persist($Crud); ★エンティティマネージャーの管理下にCrudエンティティを登録します。
            $app['orm.em']->flush($Crud); ★エンティティマネージャーを通して、データーベースにエンティティの内容を登録します。
        } elseif($form->isSubmitted() && !$form->isValid()) {
            $message = array('error' => '入力値に誤りがあります');
        }

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'message' => $message,
                'forms' => $forms->createView(),
            )
        );
    }
}
```


- 上記の説明を行なっていきます。

#### 保存対象エンティティのインスタンス化

1. まず前章で作成したエンティティをインスタンス化します。
      - エンティティの作成では、**バックスラッシュ + Eccubeからの相対パス + ファイル名(拡張子なし)**を**new**します。
      - エンティティを**new**する際に、**ファイル名(拡張子)以外**を**名前空間で指定**する事が必要です。

      ```
      use Eccube\Entity\[該当エンティティ名(拡張子なし)]
      ```

1. **createBuilder**の第二引数にインスタンス化したエンティティを渡します。
    - 本操作によって、フォームがエンティティと紐付き**フォームデーターの保持が可能**になります。
    - ただし、後述する**FormTypeの修正**と**リクエストオブジェクトとの結びつけ**が必要です。

1. 次に「フォーム情報を整理して入力値チェックも追加しよう」で行なった、リクエストオブジェクトとフォームオブジェクトを結びつけます。
    - 説明済みのため、詳細な内容は割愛いたします。

1. 次に「フォーム情報を整理して入力値チェックも追加しよう」で行なった、サブミット・入力値判定を行います。
    - 説明済みのため、詳細な内容は割愛いたします。

#### エンティティマネージャーの呼び出しと保存

1. 判定結果に問題がなかった際は、エンティティマネージャーを呼び出します。
    - エンティティマネージャーの呼び出し
    
    ```
    $app['orm.em']
    ```

    - 上記でエンティティマネージャーが呼び出せます。
    - 正確にいうと、上記の中にエンティティマネージャーのインスタンスが格納されているため、上記の記述に対して、行いたい処理のメソッドを呼び出すだけとなります。

#### エンティティマネージャーの管理化にエンティティを登録

1. 次にエンティティマネージャーに、保存対象エンティティを登録します。
  - エンティティマネージャーへのエンティティ登録

  ```
  $app['orm.em']->persist([登録エンティティ名称]);
  ```

  - 上記でエンティティがエンティティマネージャーの管理下に入りました。
  - 後は後述する**flush**が呼び出される際に、Doctrineがデーターベースとの差分を保持しているため、その内容との比較から、登録・更新を自動で選択し処理されます。

#### データーの登録

1. エンティティマネージャーに登録が完了したため、後は**flush**を呼び出すだけで自動で保存されます。

  ```
  $app['orm.em']->flush([対象エンティティ名称]);
  ```

- 上記で保存が完了しますが、**flush**の引数に**対象エンティティ**を渡すと、**渡したエンティティのみ**が登録・更新判定の**対象**となります。

- **引数を渡さなければ**、登録されているエンティティ**全てが対象**となります。

- 今回は**リレーションのないデーターの保存**のために、あまり**Doctrineの利便性**は感じにくいかも知れませんが、**リレーションデーター(アソシエーションデーター)を扱う際**は、**定義ファイル**に関連を記述し、**該当エンティティを登録**して、**flush**するだけで、**外部キーも保存**されるために、その際には、**Doctrineの利便性を享受**出来るはずです。

### CrudTypeの修正

- 次にCrudTypeをエンティティに連動させるため、各項目のオプション値を変更します。

    1. 保存フォルダ

    - /src/Eccube/Form/Type

    1. 以下の様にファイルを修正します。

    - **CrudType.php**

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

class CrudType extends AbstractType
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
            '1' => '質問',
            '2' => '提案',
        );

        $builder->add(
            'reason',
            'choice',
            array(
                'label' => '投稿種別',
                'required' => true,
                'choices' => $post_type,
                'mapped' => true, ★trueに修正
                'expanded' => false,
                'multiple' => false,
            )
        )
        ->add(
            'name',
            'text',
            array(
                'label' => '投稿者ハンドルネーム',
                'required' => true,
                'mapped' => true, ★trueに修正
                'constraints' => array(
                    new Assert\Regex(array(
                        'pattern' => "/^[\da-zA-Z]+$/u",
                        'message' => '半角英数字で入力してください'
                    )),
                ),
            )
        )
        ->add(
            'title',
            'text',
            array(
                'label' => '投稿のタイトル',
                'required' => true,
                'mapped' => true, ★trueに修正
                'constraints' => array(
                    new Assert\Length(
                        array(
                            'min' => '0',
                            'max' => '100',
                            'maxMessage' => '100文字以内で入力してください',
                        )
                    )
                )
            )
        )
        ->add(
            'notes',
            'textarea',
            array(
                'label' => '内容',
                'required' => false,
                'mapped' => true, ★trueに修正
                'empty_data' => null,
                'attr' => array(
                    'style' => 'height:100px;',
                )
            )
        )
        ->add(
            'save',
            'submit',
            array(
                'label' => 'この内容で登録する'
            )
        )
        ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'crud';
    }
}
```

- 上記の説明

    - ソース上に★印で示した様に、**mapped**オプションを**true**にする事で、初めてエンティティにフォーム項目がマッピングされます。

### 表示内容の確認

#### エラー表示

- 最後に確認のためにブラウザにアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. 「投稿ハンドルネーム」に「テスト」を入力

    1. 「投稿のタイトル」に「テスト」を入力

    1. 「内容」に「テスト」を入力

    1. この内容で登録するボタンを押下

    1. 以下の内容が表示されます。

---

![入力値を間違えて登録](/images/img-tutorial9-view-rendar-error.png)

---

#### 正常登録時

- 正常登録時の表示を確認します。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. 「投稿ハンドルネーム」に「test」を入力

    1. 「投稿のタイトル」に「テスト」を入力

    1. 「内容」に「テスト」を入力

    1. この内容で登録するボタンを押下

    1. 以下の内容が表示されます。

---

![入力値を間違えて登録](/images/img-tutorial9-view-rendar-success.png)

---

#### データーベースの内容

- テーブルにデーターが保存されています。

---

![dtb_bbsの内容](/images/img-tutorial9-insert-database.png)

---

## 本章で学んだ事

1. エンティティのインスタンス化の説明
1. フォームタイプとエンティティの紐付け方の説明
1. フォームタイプファイルの修正箇所の説明
1. リクエストオブジェクトとフォームオブジェクトの紐付け方の説明
1. サブミット・入力値判定の説明
1. エンティティマネージャーへのエンティティの登録の仕方の説明
1. エンティティマネージャーでの保存の方法の説明
1. データ登録時の各画面の確認
1. 登録データーの確認
