---
layout: default
title: フォームを表示してみよう
---

---

# フォームを表示してみよう


## Formとフォームビルダー

- 前章までは、ルーティング、レンダリングの簡単な例を示しました。

- 本章では、画面入力のためにフォームを作成します。

- EC-CUBE3ではフォームの作成はフォームビルダーを用いて行います。

## コントローラーファイルにForm定義を追加する

- まずコントローラーにFormを定義します。

- 以下の修正をコントローラーに行います。

    - Bbs.php

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


namespace Eccube\Controller\CookBook;

use Eccube\Application;

class Bbs
{
    public function index(Application $app)
    {
        //$viewname = 'このビューは「CookBook/bbs_top.twig」が表示されています。';★コメントアウトします。

        $builder = $app['form.factory']->createBuilder('form', null, array())☆以下フォーム定義を追加

        $builder->add(
            'reason',
            'choice',
            array(
                'label' => '投稿種別',
                'choices' => array('1' => '質問', '2' => '提案'),
                'required' => false,
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
                'required' => false,
                'mapped' => false,
            )
        )
        ->add(
            'notes',
            'textarea',
            array(
                'label' => '内容',
                'required' => false,
                'mapped' => false,
                'empty_data' => null,
                'attr' => array(
                    'style' => 'height:100px;',
                ),
            )
        );

        $forms = $builder->getForm();

        return $app->render(
            'CookBook/bbs_top.twig',
            array(
                //'viewname' => $viewname,★コメントアウトします。
                'forms' => $forms->createView(),☆追記
            )
        );
    }
}
```

### フォームビルダー

- Silex(Symfony2)では前述の通り、「FormBuilder」でForm項目を定義します。
	- FormBuilderでは主に以下の内容を定義します。

1. Formのname属性
  - html上で識別される、フォームの項目名です。

1. Form部品のtype属性
  - フォーム項目の種類です(text、checkbox、textareaなど)

1. 必須の設定
  - 項目の入力必須の設定

1. デフォルト値
  - value値の初期値

1. **バリデーション**(次章で説明)
  - 入力値の精査

1. value属性の設定
  - ユーザー入力値です(hiddenを除く)

1. htmlでformに対して指定出来る属性全て
  - id、class、placeholderなど、htmlで指定出来るものは全て

#### ビルダーの取得

- フォームビルダーは以下で取得が出来ます。

  - $app['form.factory']から以下メソッドを呼び出します。
    - createBuilder([タイプ名称], [フォーム自体のタイプ], [オプション])

  1. タイプ名称 : 次章で説明する「FormType」の定義済み名称を指定します。
    - FormTypeがなくビルダーのみで生成する際は、「form」を指定してください。

  1. フォームタイプで使用するオブジェクト : 通常は内部で利用するエンティティを設定します。
    - 通常は「null」を指定してください。

  1. フォーム生成時オプションを設定します。
    - 使用頻度も少ないため、本CookBookでは割愛いたします。

#### フォーム項目の追加

- フォームビルダーでは、ビルダーに対して以下メソッドで、項目を追加します。

-  [フォームビルダー]->add([name属性], [type属性], [オプション])
    - オプションで指定出来る範囲が大きいため、次章で説明いたします。

#### 特殊な項目

- 以下のフォーム項目については、通常のhtmlを作成する際と、概念が違います。

1. セレクトボックス

1. チェックボックス

1. ラジオボックス

- 上記に示したものは、選択肢がフォーム項目によって与えられます。

    - 上記の場合は、「choices」を指定し、連想配列を与えます。

### フォームビルダーからフォームのビューオブジェクトを取得する

- フォームビルダーで項目の定義が完了したら、以下の順で「フォームのビューオブジェクト」生成を行います。

1. フォームの取得
    - [フォームビルダー]->getForm();

1. フォームhtmlの取得
    - [フォームオブジェクト]->createView()

## Twigファイルでフォームビューオブジェクトの内容を表示する

- コントローラー側の実装が完了しました。

- 次はTwigに以下修正を加え、フォームのビューオブジェクトをhtmlとして表示出来る様にしましょう。

    - bbs_test.twig

```
｛＃
This file is part of EC-CUBE

Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.

http://www.lockon.co.jp/

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
＃｝
｛％ extends 'default_frame.twig' ％｝

｛％ set body_class = 'front_page' ％｝

｛％ block javascript ％｝
｛％ endblock ％｝

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">
                <h1>ご意見箱</h1>
                <p>みなさんのご意見をかきこんでください</p>
                <dl>
                    <dt>コントローラーから取得した変数です</dt>
                    <dd>
                        ｛＃｛｛ viewname ｝｝＃｝★コメントアウト
                    </dd>
                </dl>
            </div>
           <div id="form-wrapper">☆追記
               ｛｛ form_widget(forms)｝｝
           </div>
        </div>
    </div>
｛％ endblock ％｝

```

- ここで重要なのは以下です。

    - ｛｛ form_widget(forms)｝｝

- 上記の設定によって、フォームオブジェクトがビューに書きだされます。

    - 本当は1項目づつ表示すことも可能ですが、本章は全項目を一度に書き出しています。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/cookbook/Bbs」を入力してください。

1. フォームビルダーで構築したフォームが表示されています。

---

![フォームのレンダリング](/images/img-cookbook4-view-rendar.png)

---


## この章のまとめ

1. コントローラーでFormを定義しました。
1. フォームビルダーでフォーム項目を構築しました。
1. フォームビルダーからフォームオブジェクト、そこからビューオブジェクトを取得しました。
1. フォームのビューオブジェクトのTwigでの表示を行いました。
