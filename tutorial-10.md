---
layout: default
title: データベースから情報を取り出してリストを表示しよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. フラッシュメッセージの概念について学びます。

    1. クエリビルダーでのSQL構築方法について学びます。

    1. Twigでのループ処理について学びます。

    1. Twigでの基本的な構文について学びます。

## データーベース情報の取得とViewのループ処理

- 前章では、エンティティマネージャーを介して、データーベースに登録を行う方法を説明しました。

- この章では、画面アクセス時にデーターがある際は、テーブル形式でビューに表示します。

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
use Symfony\Component\HttpFoundation\Request;

class CrudController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        $app->clearMessage(); ★フラッシュメッセージをクリア

        $Crud = new \Eccube\Entity\Crud();

        $builder = $app['form.factory']->createBuilder('crud', $Crud);

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $app->addSuccess('データーが保存されました'); ★メッセージをフラッシュメッセージに変更
            $app['orm.em']->persist($Crud);
            $app['orm.em']->flush($Crud);
        } elseif($form->isSubmitted() && !$form->isValid()) {
            $app->addError('入力内容をご確認ください'); ★メッセージをフラッシュメッセージに変更
        }

        $qb = $app['orm.em']->createQueryBuilder(); ★エンティティマネージャーからクエリビルダーを取得
        $qb->select('cr') ★クエリ生成
            ->from('\Eccube\Entity\Crud', 'cr')
            ->orderBy('cr.update_date', 'desc');

        $crudList = $qb->getQuery()->getResult(); ★取得結果:結果がなければ空配列が返却

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'forms' => $form->createView(),
                'crudList' => $crudList, ★データーベース取得値をビューに渡す
            )
        );
    }
}
```

- 上記の説明を行なっていきます。

#### フラッシュメッセージ

1. 今まで保存の成功の有無を**$message**で画面へ受け渡していたのを、フラッシュメッセージに変更します。
      - **フラッシュメッセージ**は**セッション**に格納されるメッセージで、画面遷移が発生すると破棄されます。
      - EC-CUBE3では、主に管理画面で使用されています。
      - 処理結果メッセージの表示を行う際は、コントローラーから変数で画面にメッセージを渡す方法を基本的には用いずに、こちらを利用する事を推奨いたします。

1. フラッシュメッセージのクリア方法を説明します。

      ```
      $app->clearMessage()
      ```

      - 今回は画面遷移がないため、明示的にメッセージのクリアが必要です。
      - フラッシュメッセージを意図的にクリアしたい際は、上記をコールします。

1. 成功メッセージの表示方法を説明します。

      ```
      $app->addSuccess([メッセージ], [画面種別(デフォルトはユーザー画面)])
      ```

      - 前述の通り、主に管理画面で利用しますが、処理が成功した際に表示するメッセージを第一引数に渡します。
      - 管理画面では、自動で文字が装飾されて表示されます。
      - 第二引数には、以下画面種別を渡します。
        1. ユーザー画面 ( フロント画面 ) : front
        1. 管理画面 : admin
            - 画面種別はセッションのキーに利用されます。

1. エラーメッセージの表示方法を説明します。

      ```
      $app->addError([メッセージ], [画面種別(デフォルトはユーザー画面)])
      ```

      - こちらも管理画面で利用します。
      - 概要は成功メッセージと同様です。

#### クエリビルダーの取得とDQLの構築

1. EC-CUBE3では、SQLを直接記述する事は、あまり行わず、基本的にはここで説明する、**クエリビルダー**を利用します。
    - **クエリビルダー**は**Doctrine**が提供しており、**「SQL文構築」を補助**してくれるメソッドを多数、備えています。
    - クエリビルダーの**メリット**としては、**SQL構文の質の均一化**、**各データーベース毎のSQL方言の吸収**、**セキュリティ面の向上**などがあげられます。
    
    - 以下参考

    - <a href="http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/query-builder.html#the-querybuilder" target="_blank">The QueryBuilder</a>

1. $app['orm.em'] (エンティティマネージャー) から以下メソッドを呼び出し、クエリビルダーオブジェクトを取得します。
    
    ```
    $app['orm.em']->createQueryBuilder();
    ```
    
    - オブジェクトを取得後は、フォームビルダーと同じ様に、必要メソッドを呼び出し、SQLを作成していきます。
    - **作成したSQL**は**クエリビルダーオブジェクトで保持**されます。
    - **Doctrineのクエリビルダーで作成**していく**SQL文**を**DQL**と呼びます。


1. 次に**DQLで取得したい情報の条件**を作成します。
    
```
$qb->select([テーブルエイリアス及び、エイリアス + 取得カラム名])
    ->from([取得データーモデル該当エンティティパス], [エイリアス名])
    ->orderBy([エイリアス + 対象カラム名], [並び順指定]);
```

- 基本は**SQL構文に近似**しています。

    1.**from**で指定する**データーモデルエンティティパス**は**以下ディレクトリ以降**を記述し、**必ずバックスラッシュ**からはじめます。

    - [EC-CUBE3インストールディレクトリ]/src/

    2.**from句には必ずエイリアスの指定 ( 任意 ) が必要**です。

    3.**orderBy句**には第一引数には**エイリアス + 対象カラム名**、第二引数には「desc/asc」をクォートで囲って指定してください。

    - 以下参考

    - <a href="http://qiita.com/chihiro-adachi/items/3901c8865f926d913e67" target="_blank">Doctrine QueryBuilder使い方メモ</a>

#### クエリビルダーの結果取得

- クエリビルダーの結果を取得するは、以下の手順で行います。

    1. クエリオブジェクトの取得
        - 以下メソッドで**クエリオブジェクトを取得**します。
        
        ```
        [クエリビルダーオブジェクト]->getQuery()
        ```

        - クエリビルダーのメソッドで構文を作成した後に、**getQuery**をコールすることで、クエリビルダーから、条件に基づき作成された**クエリオブジェクトが作成**されます。
        - 結果取得メソッドを呼び出すには**必ず必要**となります。
        - 本チュートリアルでは、**getQuery**の**戻り値を取得せず**、**チェーンメソッドで結果取得**まで処理を完了しています。

    1. 結果の取得
        - クエリオブジェクトの以下メソッドを呼び出し、結果を取得します。

        ```
        [クエリオブジェクト]->getResult();
        ```
        
        - 結果取得のメソッドは取得したい内容 ( 配列・オブジェクト配列・一件のみなど ) によって種類があります。
        - 今回は単純な内容として、結果をオブジェクト配列で取得しています。
        - **getResultメソッド**は**結果が取得できない**際は、戻り値として**「array()」を返却**します。

        - 参考

            - <a href="http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html" target="_blank">Query Result Formats</a>

#### 取得結果をViewに渡す

1. 本来はエラーハンドリングをViewに渡す前に行いますが、今回の場合取得結果がなくても、**array()**が必ず格納されているため、結果判定を行わず、**render**メソッドの第二引数に、取得結果変数を渡しています。

## Viewの修正

- 以下のTwigを修正していきます。
    - /src/Eccube/Resource/template/default/Tutorial/crud_top.twig

    1. ファイルを開いて以下の様に修正します。

        - **crud_top.twig**

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
    <style type="text/css">
        .tutorial-table {
            padding :100px 0 0 0;
        }
        .tutorial-td {
            border-right :1px dotted #aaaaaa;
        }
        .tutorial-box-top {
            border-top :1px dotted #aaaaaa;
        }
    </style>
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">
                <h1>CRUDチュートリアル</h1>
                <p>投稿を行なってください</p>
            </div>
           <div>
               ｛％ for message in app.session.getFlashBag.get('eccube.front.success') ％｝ ★フラッシュメッセージのチェックと書き出し ( 成功メッセージ )
                   <p class="text-success"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
               ｛％ for message in app.session.getFlashBag.get('eccube.front.error') ％｝ ★フラッシュメッセージのチェックと書き出す ( エラーメッセージ )
                   <p class="text-error"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
           </div>
           <div id="form-wrapper">
               <form name="bbs-top-form" method="post" action="｛｛ url('tutorial_crud') ｝｝">
                   ｛｛ form_widget(forms) ｝｝
               </form>
           </div>
           ｛％ set count = crudList | length ％｝ ★データーベース取得結果の配列長をカウント
           ｛％ if count > 0 ％｝ ★カウント結果が「0」であれば取得結果がないため、以下処理をキャンセル
           <div class="row tutorial-table ">
                <div class="col-md-12">
                    <div class="box tutorial-box-top">
                        <div class="box-header">
                            <h3 class="box-title"><span class="tutorial-table-caption">登録されいる情報は&nbsp;&nbsp;<strong>｛｛ count ｝｝</strong>&nbsp;&nbsp;件です</span></h3> ★カウントを利用して取得結果を表示
                        </div>
                        <div class="box-body no-padding">
                            <div class="item_list">
                                <div class="tableish">
                                    <div class="item_box tr tutorial-tr">
                                        <div class="th tutorial-td">投稿者ID</div>
                                        <div class="th tutorial-td">投稿種別</div>
                                        <div class="th tutorial-td">投稿者名</div>
                                        <div class="th tutorial-td">タイトル</div>
                                        <div class="th tutorial-td">投稿内容</div>
                                    </div>
                                    ｛％ for Crud in crudList ％｝ ★for in 構文でオブジェクト配列から一つづつオブジェクトを取り出し
                                    <div class="item_box tr tutorial-tr">
                                        <div class="td tutorial-td">｛｛ Crud.id ｝｝</div> ★オブジェクトのメンバを表示
                                        <div class="td tutorial-td">｛｛ Crud.reason ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.name ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.title ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.notes | nl2br ｝｝</div>
                                    </div>
                                    ｛％ endfor ％｝
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
           ｛％ endif ％｝
        </div>
    </div>
｛％ endblock ％｝
```

- 上記の説明を行います。

### フラッシュメッセージの判定と表示

- 以下で判定と表示を行なっています。

```
｛％ for message in app.session.getFlashBag.get('eccube.front.success') ％｝
   <p class="text-success"><bold>｛｛ message ｝｝</bold></p>
｛％ endfor ％｝
```

1. Twig内でも、コントローラーで利用していた**app($app)**を呼び出し、いろいろな機能を利用する事ができます。

1. 今回は、**セッション**オブジェクトから、フラッシュメッセージの内容を取得しています。

1. フラッシュメッセージは画面遷移(URLの変更)があれば、削除されると前述しましたが、情報が格納されているのは、**セッション**です。

1. 具体的にフラッシュメッセージを取得しているメソッドは以下です。

    ```
    セッションオブジェクト.getFlashBag
    ```

    - 上記で**フラッシュメッセージオブジェクト**から**getメソッドを使って**該当情報を取り出しています。
    - **getメソッドの引数**には、**セッション保存時の情報のキー**を指定します。
    - フラッシュメッセージの対応キーは以下です。
      1. 成功メッセージ
        - eccube.front.success
      2. エラーメッセージ
        - eccube.front.error

      - 上記の**front**は管理画面では、**admin**に変わります。

      - フラッシュメッセージがあれば、**「for ～ in」構文**でフラッシュメッセージ(配列が格納)を**全て書き出しています。**
      - **for ～ in**については後述します。

### 参考

- twigではメソッドの呼び出し方がかわります。
- コントローラーでは「->(アロー)」だったものが「.(ピリオド)」に変わります。

### データーベース取得結果の判定

1. データーベースの取得結果は、コントローラーの項で説明した通り、取得結果がない際は、**空配列(array())**が返却されます。

1. そのため、**配列長を調べて「0」であれば、結果がない**ということになります。

1. 結果がない際に**余計なhtmlを表示しないため**に、「if」で判定を行なっています。

1. 配列長の調査には以下**Twig関数を利用**しています。

    ```
    length
    ```

    - **length関数**は与えられた配列の**配列長を返却**します。
    - lengthへ配列を渡すために、「｜(パイプ)」を用います。
    - パイプは、**パイプの左の結果**を**パイプの右へ渡します**。

#### twig内での変数定義

1. データベースの取得結果の配列長を変数に格納し、後で判定を行なっていますが、**twigでは以下の方法**で、**変数の定義・格納を行えます。**

1. 変数の定義と格納方法は以下となります。

```
｛％ set 任意の変数名 = 値 ％｝
```

- 変数だけの宣言では以下となります。

```
｛％　set 任意の変数名 ％｝
```

### データーベース取得結果の表示(オブジェクト配列)

1. **「if」判定で問題がなければ**、**「if」以降のhtmlに処理が移ります**。

1. データーベースの取得結果はオブジェクト配列で「crudList」に格納されています。

1. 配列を全て走査するために「for ～ in」構文を用います。

#### for ～ in 構文

- 以下が構文です。

```
｛％ for 任意の変数名 in [配列(オブジェクト配列)] ％｝
｛％ endfor ％｝
```

1. 上記の通りですが、**配列**に対して、**任意の変数名**を**「in」の前に記述**します。

1. **inの前に記述した変数**には、**配列の要素が一つ格納**され、**配列の要素がなくなるまで、「endfor」の間の処理・htmlの表示が行われます。**

1. 今回は、**任意の変数名**の中に、**データモデルオブジェクトが格納**されています。

1. 後はループ内で、データモデルオブジェクトの**getter**を使用して、**必要な箇所でhtmlに書き出し**を行なっています。

- 前述の通り、Twig内ではメソッドの呼び出し方が変わります。
- 以下が書き出し例です。

```
｛｛[データーモデルオブジェクト].[メンバ変数名]｝｝
```

- 以下の書き方でも可能です。
- 今回ソースを例として説明します。

- 通常

```
｛｛ crudList.id ｝｝
```
- 例1.

```
｛｛ crudList.getId() ｝｝
```

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

#### データー投入前

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. データーがなければ以下が表示されるはずです。

---

![データー投入前データ登録画面](/images/img-tutorial10-view-rendar-default.png)

---

#### データー投入時

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 各項目に正しい値を入力して登録を行なってください。

1. 以下が表示されるはずです。

---

![データー投入後データ登録画面](/images/img-tutorial10-view-rendar-adddata.png)

---

#### エラー内容入力時

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 投稿者ハンドルネームに「テスト1」を入力してください。

1. 以下が表示されるはずです。

---

![エラーデーター登録時データ登録画面](/images/img-tutorial10-view-rendar-error.png)

---

## 本章で学んだ事

1. フラッシュメッセージの概要の説明
1. フラッシュメッセージの表示方法の説明
1. クエリビルダーの利用方法の説明
1. クエリビルダーでのSQL構築方法の説明
1. クエリビルダーからクエリオブジェクトを取得する方法の説明
1. クエリオブジェクトから結果を取得する方法の説明
1. クエリビルダーの構文の説明
1. 結果取得メソッドの種類・概要の説明
1. Viewでのappの利用方法の説明
1. Viewでのメソッドの呼び出し方法の説明
1. twig関数(length / for ～ in / set)の説明
1. ループ中のデーターモデルオブジェクトの値取得方法の説明
