---
layout: default
title: フォームを表示してみよう
---

---

# {{ page.title }}


## Formとフォームビルダー

- 前章までは、ルーティング、レンダリングの簡単な例を示しました。

- 本章では、画面入力のためにフォームを作成します。

- EC-CUBE3ではフォームの作成はフォームビルダーを用いて行います。

### 本章メニュー

- 本章では以下を行います。

    1. コントローラーからフォームビルダを利用します。

    1. フォームビルダーでフォーム要素を構築します。

    1. フォームビルダーの概要を説明します。

    1. フォームビルダーからフォームビューを作成し、Twigに渡す方法を説明します。

    1. Twigで受け取ったフォームビューの表示方法を説明します。

## コントローラーファイルにForm定義を追加する

- まずコントローラーにFormを定義します。

- 以下の修正をコントローラーに行います。

    - CrudController.php

<script src="http://gist-it.appspot.com/https://github.com/geany-y/ec-cube.github.io/blob/renew/io/Source/tutorial_4/CrudController_add_form.php"></script>

<!--
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

class CrudController extends AbstractController
{
    public function index(Application $app)
    {
        //$viewname = 'このビューは「Tutorial/crud_top.twig」が表示されています。';★コメントアウトします。

        $builder = $app['form.factory']->createBuilder('form', null, array())★ここからフォーム定義を追加

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
            'Tutorial/crud_top.twig',
            array(
                //'viewname' => $viewname,★コメントアウトします。
                'forms' => $forms->createView(),★追記
            )
        );
    }
}
```
-->

### フォームビルダーを用いた項目の追加

- Silex(Symfony2)では前述の通り、**フォームビルダー**でフォーム項目を定義します。

#### フォーム項目追加メソッド

-  [フォームビルダー]->**add([name属性], [type属性], [オプション])**

#### 引数の説明

- addメソッドの引数の説明を行います。

    1. [name属性]
        - html上で識別される、フォームの項目名です。

    1. [type属性]
        - フォーム項目の種類です(text、checkbox、textareaなど)

    1. [オプション]は以下の内容を、適宜連想配列で設定します。

        1. 必須の設定
          - 項目の入力必須の設定

        1. デフォルト値
          - value値の初期値

        1. **バリデーション**(次章で説明)
          - 入力値の精査

        1. value属性の設定
          - ユーザー入力値(hiddenを除く)

        1. htmlでformに対して指定出来る属性全て
          - id、class、placeholderなど、htmlで指定出来るものは全て

#### エンティティとフォーム項目のマッピング

- 上記のオプション項目に以下が設定されていると思います。

```

'mapped' => false,

```

- 上記は後の章でてくるエンティティとフォーム項目を紐付けるかどうかを設定します。
- エンティティを用いない場合は必ず**false**を設定してください。
- 設定が**true**の場合、ビルダーが項目とエンティティのマッピングを行うためエラーとなります。

#### 特殊な項目

- 以下のフォーム項目については、通常のhtmlを作成する際と、概念が違います。

    1. セレクトボックス

    1. チェックボックス

    1. ラジオボックス

    - 上記に示したものは、選択値をフォームビルダーの設定項目によって設定します。

        - 上記の場合は、**addメソッド第二引数の[type属性]**に「choices」を指定し、連想配列を与える事で実現できます。

#### ビルダーの取得

- フォームビルダーは以下で取得が出来ます。

  - **$app['form.factory']**から以下メソッドを呼び出します。

    - **createBuilder([タイプ名称], [エンティティ(データーモデルオブジェクト)], [オプション])**

      1. [タイプ名称] : 次章で説明する「FormType」のメソッド**getName**で定義した名前を指定します。
        - あまりおすすめしませんが、FormTypeがなくビルダーのみで生成する際は、「form」を指定してください。

      1. [エンティティ(データーモデルオブジェクト)] : 通常は内部で利用するエンティティを設定します。
        - エンティティを用いない際は、「null」を指定してください。

      1. [オプション] : フォーム生成時オプションを設定します。
        - 使用頻度も少ないため、本チュートリアルでは割愛いたします。

### フォームビルダーからフォームのビューオブジェクトを取得する

- フォームビルダーで項目の定義が完了したら、以下の順で「フォームのビューオブジェクト」生成を行います。

    1. フォームの取得
        - [フォームビルダー]->getForm();

    1. フォームのビューオブジェクト取得
        - [フォームオブジェクト]->createView()

## Twigファイルでフォームビューオブジェクトの内容を表示する

- コントローラー側の実装が完了しました。

- 次はTwigに以下修正を加え、フォームのビューオブジェクトをhtmlとして表示出来る様にしましょう。

- 以下の様に**crud_test.twig**を修正します。

    - crud_test.twig


<script src="http://gist-it.appspot.com/https://github.com/geany-y/ec-cube.github.io/blob/renew/io/Source/tutorial_4/crud_top_add_form.twig"></script>


<!--
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
                <h1>CRUDチュートリアル</h1>
                <p>投稿を行なってください</p>
                <dl>
                    <dt>コントローラーから取得した変数です</dt>
                    <dd>
                        ｛＃｛｛ viewname ｝｝＃｝★コメントアウト
                    </dd>
                </dl>
            </div>
           <div id="form-wrapper">★追記
               ｛｛ form_widget(forms)｝｝
           </div>
        </div>
    </div>
｛％ endblock ％｝
```
-->

- ここで重要なのは以下です。

    - ｛｛ form_widget(forms)｝｝

- 上記の設定によって、フォームオブジェクトがビューに書きだされます。

    - 本当は1項目づつ表示すことも可能ですが、本チュートリアルでは全項目を一度に書き出しています。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. フォームビルダーで構築したフォームが表示されています。

---

![フォームのレンダリング](/images/img-tutorial4-view-rendar.png)

---


## この章のまとめ

1. コントローラーでFormを定義しました。
1. フォームビルダーでフォーム項目を構築しました。
1. フォームビルダーからフォームオブジェクト、そこからビューオブジェクトを取得しました。
1. フォームのビューオブジェクトをTwigで表示しました。
