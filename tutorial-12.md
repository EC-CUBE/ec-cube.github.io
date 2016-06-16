---
layout: default
title: リストを編集しよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. FrontControllerProviderに編集用のルーティングを設定します。

    1. ルーティングでURLパラメーターを取得します。

    1. コントローラーに編集用のメソッドを追記します。

    1. フォームビルダーで既存フォーム項目の削除・追加を行います。

    1. フォームビルダーの追加時の設定項目でhtmlタグのオプションを設定します。

    1. エンティティマネージャーで登録・編集処理が共通で行われている事を確認します。

    1. 編集用の画面を作成します。

    1. リダイレクトを利用します。

## 条件検索とアップデート処理

- 前章では、レポジトリを用いた、検索・登録について学びました。

- 本章では、ここまで学んだ事を応用して、更新処理を実装します。

## 編集画面のルーティング

- まずは**FrontControllerProvider**に**ルーティングを定義**します。

### ルーティングの設定

- **FrontControllerServiceProvider**を開きます。
    - /src/Eccube/ControllerProvider/FrontControllerProvider.php

    1. 以下を追記します。

        - **FrontControllerProvider.php**

```
        // Tutorial
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');
        $c->match('/tutorial/crud/edit/{id}', '\Eccube\Controller\Tutorial\CrudController::edit')->bind('tutorial_crud_edit')->assert('id', '^[1-9]+[0]?$'); ★ルーティングとURLパラメーターの設定を追記

        return $c;
    }
}
```

- 上記の説明を行います。

    1. まず「Tutorial」を検索します。

    1. 以前追記した、チュートリアル登録画面用のルーティングが記述されています。

    1. その下に編集画面用のルーティングを追記します。

    1. 今回の**ルーティング**には、**コントローラー・メソッド名**のほか、**URLパラメーター名 + URLパラメーターバリデートが追記**されています。

    1. 以下で詳細を説明します。

```
$c->match('/[Twigで設定したルーティング名]/{id}', '[コントローラー名]::[メソッド名]')->bind('[ルーティング名(twigのurlで呼び出す値)]')->assert('[URLパラメーターキー名称]', '[バリデーション(正規表現)]');

```

- **match**メソッドの**第二引数**、**bind**メソッドの**ルーティング名**は、以前と同じです。
- **match**メソッドの**第一引数の最後**に**{id}**と記述しています。
    - これは、**URLパラメーターのキーの設定**で、ここで**View側で付与した値を受け取る**事を示しています。
    - **ルーティング定義したコントローラーメソッド内**で、今回の例であれば、**$id**でURLパラメーター値を利用します。
- 今回新たに**assert**メソッドが記述されています。
    - **assert**メソッドは、**URLパラメーター**に対して、**バリデーション設定**を行います。
    - 今回は正規表現で、**0以外で始まる正の整数のみ受け付け**る様にしています。

### 画面へのルーティングの追加

- **crud_top.twig**に**編集ボタンを追加**し、**先程定義したルーティング名を設定**します。
- 以下のファイルを確認します。
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
               ｛％ for message in app.session.getFlashBag.get('eccube.front.success') ％｝
                   <p class="text-success"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
               ｛％ for message in app.session.getFlashBag.get('eccube.front.error') ％｝
                   <p class="text-error"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
           </div>
           <div id="form-wrapper">
               <form name="bbs-top-form" method="post" action="｛｛ url('tutorial_crud') ｝｝">
                   ｛｛ form_widget(forms) ｝｝
               </form>
           </div>
           ｛％ set count = crudList | length ％｝
           ｛％ if count > 0 ％｝
           <div class="row tutorial-table ">
                <div class="col-md-12">
                    <div class="box tutorial-box-top">
                        <div class="box-header">
                            <h3 class="box-title"><span class="tutorial-table-caption">登録されいる情報は&nbsp;&nbsp;<strong>｛｛ count ｝｝</strong>&nbsp;&nbsp;件です</span></h3>
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
                                        <div class="th tutorial-td">編集</div> ★項目を追記します
                                    </div>
                                    ｛％ for Crud in crudList ％｝
                                    <div class="item_box tr tutorial-tr">
                                        <div class="td tutorial-td">｛｛ Crud.id ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.reason ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.name ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.title ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.notes | nl2br ｝｝</div>
                                        <div class="td tutorial-td"><a class="btn btn-default btn-block btn-sm" href="｛｛ url('tutorial_crud_edit', {'id' : Crud.id}) }}">
                                            編集
                                            </a></div> ★「a」タグで編集画面へのリンクを生成します。
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

- 上記説明を行います。

1. テーブルの見出しに編集の項目を追記します。
    - **本例ではテーブルタグを用いず、divタグ**に**tdクラスを追加**する事で、**テーブル形式の表示**を行なっています。

1. テーブル項目の最後に編集ボタンを追記します。
    - **「a」タグ**を用い、**CSSでボタン形状**に成形しています。

1. 先程追加した**「a」タグ**の**リンク部URL**ですが、以前利用した**Twig関数**の**url()**でを用いています。
    - 今回の**ルーティング先で編集処理**を行うため、**レコードの特定が行えるID**を、**URLパラメーター**として付与しています。

    - 構文は以下の通りです。

    ```
    url([ル－ティング名, ['キー(ルーティングで定義した内容)' : [実際のID]])
    ```

    - 以前は第一引数のみの記述でしたが、今回は**第二引数に、URLパラメーターである対象レコードのID**を渡しています。

    - **IDはキーと値を「:(コロン)」で区切り、第二引数全体をブラケットで囲みます。**

## 編集処理用メソッドの定義

- **CrudController.php**に**編集処理用メソッドを定義**します。

### メソッドの追記

- **CrudController.php**を開きます。
    - /src/Eccube/Controller/CrudController.php

        1. **indexメソッドの下**に**以下を追記**します。

        - **CrudController.php**

```
    /**
     * 編集画面
     * @param $id
     */
    public function edit(Application $app, Request $request, $id) ★引数に「$id(URLパラメーター)」を追記
    {
        $Crud = $app['eccube.repository.crud']->getDataById($id); ★該当レポジトリから「id」をキーに編集対象レコードを取得

        if (!$Crud) { ★エラー判定、データーが一件もない場合は登録画面へ遷移
            return $app->redirect($app->url('tutorial_crud'));
        } 

        $builder = $app['form.factory']->createBuilder('crud', $Crud); ★取得エンティティをもとに、フォームビルダーを生成
        $builder->remove('save'); ★フォームタイプに設定した項目「save」ボタンを削除
        $builder->add( ★ビルダーに編集確定用ボタンを追加
            'update',
            'submit',
            array(
                'label' => '編集を確定する',
                'attr' => array(
                    'style' => 'float:left;',
                )
            )
        )
        ->add( ★ビルダーに「戻る」ボタンを追加
            'back',
            'button',
            array(
                'label' => '戻る',
                'attr' => array(
                    'style' => 'float:left;',
                    'onClick' => 'javascript:history.back();'
                )
            )
        );

        $form = $builder->getForm(); ★再構築したフォームビルダーからフォームを取得

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveStatus = $app['eccube.repository.crud']->save($Crud); ★サブミットデーターの更新(登録処理と同内容)

            if ($saveStatus) {
                $app->addSuccess('データーが保存されました');
                return $app->redirect($app->url('tutorial_crud')); ★更新成功時は、登録画面へ遷移
            } else {
                $app->addError('データーベースの保存中にエラーが発生いたしました');
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $app->addError('入力内容をご確認ください');
        }

        return $app->render(
            'Tutorial/crud_edit.twig',
            array(
                'forms' => $form->createView(),
                'crud' => $Crud,
            )
        );
    }
}
```

- 上記を説明します。

    1. メソッド名をルーティングで設定した「edit」とします。

    1. 引数は「$app・$request」に加え、**「id」を追記**します。
        - **遷移元のViewからURLパラメーターとして、渡ってきた値**です。
        - 今回の**編集対象レコード**の、**idを保持**しています。

    1. 処理冒頭で、**渡されたid**を条件に**編集対象レコードを取得**しています。
        - レポジトリのメソッドは後で追記、説明します。

    1. **取得値のエラーハンドリング**として、**レコードが取得出来なかった際**は、不正なアクセス及びエラーとみなし、**登録画面へ強制遷移**します。

    1. **取得レコード、フォームタイプ**をもとに、**フォームを生成**します。
    - レコード情報がフォーム項目に紐付き、値が保持された状態となります。

    1. **登録時とボタンの文言を変えたい**ために、以下メソッドで、**登録ボタンをフォームビルダーから削除**します。

        ```
        [フォームビルダー]->remove([削除対象項目name属性]);
        ```

    1. 次に**addメソッド**を用い、**編集登録用のボタンと、戻るボタンを追加**しています。
        - addメソッドで以下の**新しい、オプション**が追加されています。

        ```
        'attr' => array(
            [htmlオプション名] => [設定値],
            'onClick' => 'javascript:history.back();'
        )
        ```

        - 上記のattrオプションでhtmlのオプション属性を設定します。
        - **htmlのオプション**であれば、**「id・class」など自由に設定**可能です。
        - 今回は戻るボタンのイベントとして、「onClick」属性を指定しています。
        - **※通常はJavaScriptのイベントをフォームビルダーで記述しません、あくまで参考としてください。**

    1. フォームビルダーで項目の削除・追加を終えた後で、フォームオブジェクトを生成しています。
    - フォームタイプで定義した内容を、この様に**動的に変更**する事も**可能**です。

    1. サブミット値・入力値判定後の成功処理内で、登録処理を行なっていましたが、**今回の更新でも処理は同一**です。
    - これは前述した通り、エンティティマネージャーが今回のフォームに紐付いたエンティティが更新対象と自動で判断したからです。
    - **エンティティマネージャー**が、登録か更新か**判断する基準**は、**「プライマリキー」に値が設定されているかどうか**で判断されます。

    1. レンダリングでは、**更新処理用のtwig**をレンダリングしています。

    1. **レンダリングメソッドの第二引数**に、**取得レコード**を渡しています 。

    1. 更新処理成功時に、登録画面に画面遷移しています。

    - 画面遷移をさせるためには、以下メソッドを利用します。

    ```
    return $app->redirect($app->url([ルーティング名]));
    ```

    - $appから**redirect**メソッドの引数に**url**を指定すると、指定URLに遷移が行われます。
    - **redirect**メソッドの前には必ず**return**を記述してください。
    - もう一つのメソッドとして**url**メソッドが利用されています。
    - これは、**Twig内で利用してたものと同様**で、**ルーティング名を引数**として渡すと、**該当URLが返却**されます。

## 編集用Twigの定義

- コントローラーメソッドのレンダリングで呼び出しているTwigを作成します。

### ファイルのコピーと作成

- **crud_top.twig**をコピー・リネームします
- /src/Eccube/Resource/template/default/Tutorial/crud_top.twig

    1. リネームしたcrud_edit.twigに以下を追記しています。

    - **crud_edit.twig**

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
                <p>編集を行なってください</p> ★編集画面を示すリード文
            </div>
           <div>
               ｛％ for message in app.session.getFlashBag.get('eccube.front.success') ％｝
                   <p class="text-success"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
               ｛％ for message in app.session.getFlashBag.get('eccube.front.error') ％｝
                   <p class="text-error"><bold>｛｛ message ｝｝</bold></p>
               ｛％ endfor ％｝
           </div>
           <div id="form-wrapper">
               <form name="bbs-top-form" method="post" action="｛｛ url('tutorial_crud_edit', {'id' : crud.id}) ｝｝"> ★actionを編集画面へ遷移する様に設定
                   ｛｛ form_widget(forms) ｝｝
               </form>
           </div>
        </div>
    </div>
｛％ endblock ％｝
```

- 上記を説明します。

1. 基本的な内容は、crud_top.twigと同様です。
    - 違いは、一覧表示がない事です。

1. **Formのaction属性値**は**編集画面に遷移**する様に設定しています。
    - **urlメソッド**を**利用**していますが、**第二引数**には**URLパラメーターを設定**しています。
    - **URLパラメーター**で**値を渡す**ため、**コントローラー**から受け取った**レコードのオブジェクトのid**を書き出しています。

## レポジトリに条件検索メソッドを追加する

- idをもとにdtb_crudからレコードを取得するメソッドを追記します。

### ファイルの修正

- CrudRepository.phpを開きます。
    - /src/Eccube/Repository/CrudRepository.php

        1. getAllDataSortByUpdateDateメソッドの下に以下の様にメソッドを追記します。

        - **CrudRepository.php**

```
   /**
     * getDataById
     * dtb_crudの値をIDで引き当て、返却
     *
     * @param string $order
     * @return array|bool
     */
    public function getDataById($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        try {
            $qb = $this->createQueryBuilder('dc');
            $qb->select('dc')
                ->where('dc.id = :Id')
                ->setParameter('Id', $id);

            return $qb->getQuery()->getSingleResult();
        } catch(\NoResultException $e) {
            return false;
        }
    }
```

- 上記説明を行います。

1. メソッドの引数として取得レコードのidを定義します。
    - ここで受け取る**id**は**URLパラメーター**から渡されてきた**編集対象レコード**の**id**です
    - **id**の**デフォルト値**として、**nullを指定**しています。
    - **nullの指定**は**エラーハンドリング**のために設定しています。

1. 引数のデフォルト値を利用して、エラーハンドリングを行なっています。
    - コントローラー側で判断するため、falseを返却するだけとしています。

1. 次にクエリビルダーでSQLを構築しています。
    - 今回新たに記述されている内容として、以下があります
    
    ```
    ->where('dc.id = :Id')
    ->setParameter('Id', $id);
    ```

    - 上記は**通常のSQLのwhere構文と同義**です。
    - カラムに対して条件判定を行なっています。
    - 今回は、dtb_crudのカラムidに対して、引数のidが同じレコードを取得する条件を記述しています。
    - また**クエリビルダーの条件指定**では、**プリペアドステートメント**が用いられており、以下の用に記述します。

    ```
    ->where('[エイリアス + カラム名] = :[任意の名称]')
    ->setParameter('[where句で設定した任意の名称]', [条件とする値(変数でも可)]);
    ```

    - もうひとつ新たな記述があります。

    ```
    return $qb->getQuery()->getSingleResult();
    ```

    - 上記ですが、以前の章で説明した通りDQLでの結果取得には複数のメソッドが用意されています。
    - 今回のメソッド「getSingleResult()」では、レコード取得時は、**該当レコードオブジェクトのみ(オブジェクト配列ではない)**が返却されます。
    - またレコードが見つからない際は、**NoResultException**がスローされます。
    - そのために **try ～ catch** を用い、レコードがない際は、**falseを返却**する様にしています。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

#### 初期画面

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 登録画面の一覧リストに「編集ボタン」が表示されています。
    - レコードは必ず一件以上ある状態で確認してください。

---

![一覧画面編集ボタン](/images/img-tutorial12-view-rendar-crud-top.png)

---

#### 編集画面の表示

1. 初期画面で表示されている、「編集ボタン」をクリックしてください。

1. 編集画面が表示され、フォームに値が保持されています。

1. フォーム項目値を適当に編集してみてください。

---

![編集画面トップ](/images/img-tutorial12-view-rendar-crud-edit.png)

---

#### 登録画面へ遷移

1. 「編集を確定するボタン」をクリックすると、登録画面に画面遷移します。

1. 該当レコードに編集内容が反映されています。

---

![編集完了](/images/img-tutorial12-view-rendar-crud-complete.png)

---

## 本章で学んだ事

1. ルーティングでURLパラメーターを渡す方法を説明しました。
1. ルーティングでURLパラメーターのバリデーションを行う方法を説明しました。
1. Twigのurl関数の第二引数の設定でURLパラメーター付きリンクが作成出来る事を説明しました。
1. 編集処理用のコントローラーメソッドを追記しました。
1. 編集処理用コントローラーメソッドの引数で、URLパラメーターを取得する方法を説明しました。
1. ridirectの方法を説明しました。
1. コントローラーでもurl関数が利用出来る事を説明しました。
1. テーブルから取得したデータモデルオブジェクトをフォームビルダーと紐付ける方法を説明しました。
1. フォームビルダーで動的にフォーム項目を変更できる事を説明しました。
1. フォーム項目のオプション値にattrでhtmlオプション属性を設定出来る事を説明しました。
1. レポジトリの登録処理にプライマリーキーがセットされたデーターモデルオブジェクトを渡すだけで自動で更新処理が行われる事を説明しました。
1. 編集画面用のTwigを作成しました。
1. レポジトリに追加したメソッドでwhere句を用いたDQLの構築方法を説明しました。
1. DQLの結果取得にgetSingleResultを用いました。
1. getSingleResultでは、データーモデルオブジェクト単体が返却される事を説明しました。
1. getSingleResultでは、該当レコードが存在しない場合NoResultExceptionがスローされる事を説明しました。
1. クエリビルダーのwhere句ではプリアドステートメントが用いられていることを説明しました。
