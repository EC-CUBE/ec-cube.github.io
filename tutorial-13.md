---
layout: default
title: いらない情報を削除してみよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. FrontControllerProviderに削除用のルーティングを追記します。

    1. ルーティングから削除対象レコードのidを取得します。

    1. コントローラーに削除用のメソッドを追記します。

    1. レポジトリに削除用メソッドを追記します。

## 条件検索と削除処理

- 前章では、URLパラメータで受け取ったIDをもとに該当レコードを編集しました。

- 本章は、前章とほぼ同内容ですが、次はレコード削除する方法を説明します。

## 削除画面のルーティング

- まずはFrontControllerProviderにルーティングを定義します。

### ルーティングの設定

- **FrontControllerServiceProvider**を開きます。
    - /src/Eccube/ControllerProvider/FrontControllerProvider.php

    1. 以下を追記します。

        - **FrontControllerProvider.php**

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_13/FrontControllerProvider_add_crud_delete.php"></script>

<!--
```
        // Tutorial
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');
        $c->match('/tutorial/crud/edit/{id}', '\Eccube\Controller\Tutorial\CrudController::edit')->bind('tutorial_crud_edit')->assert('id', '^[1-9]+[0]?$');
        $c->delete('/tutorial/crud/delete/{id}', '\Eccube\Controller\Tutorial\CrudController::delete')->bind('tutorial_crud_delete')->assert('id', '^[1-9]+[0]?$');

        return $c;
    }
}
```
-->

- 上記の説明を行います。

    1. まず「Tutorial」を検索します。

    1. 以前追記した、チュートリアル編集画面用のルーティングが記述されています。

    1. その行をコピーし、ルーティング名、メソッド名を削除処理用のものに書き換えます。

    - 削除処理の際のルーティングメソッドですが、以下を指定します。

        ```
        $c->delete(...
        ```

    - 削除処理内で、**本来の画面以外からのリクエストを受け付ける**と、**必要なデーターが削除**されてしまいます。
    - 上記の様なセキュリティホールを作らないための措置の一つとして、リクエストメソッドを**delete**に限定します。
        - メソッドの指定は、後述しますが、Viewで行います。

### 画面へのルーティングの追加

- **crud_top.twig**に**削除ボタンを追加**し、**先程定義したルーティング名を設定**します。
- またあわせて**確認ダイアログ**の設定も行います。
- **セキュリティに対する設定**も行います。
- 以下のファイルを確認します。
    - /src/Eccube/Resource/template/default/Tutorial/crud_top.twig

    1. ファイルを開いて以下の様に修正します。

        - **crud_top.twig**

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_13/crud_top_add_delete.twig"></script>

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
                   ｛｛ form_widget(form._token) ｝｝★追加
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
                                        <div class="th tutorial-td">編集</div>
                                        <div class="th tutorial-td">削除</div> ★テーブル見出し項目に「削除」を追記します。
                                    </div>
                                    ｛％ for Crud in crudList ％｝
                                    <div class="item_box tr tutorial-tr">
                                        <div class="td tutorial-td">｛｛ Crud.id ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.reason ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.name ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.title ｝｝</div>
                                        <div class="td tutorial-td">｛｛ Crud.notes | nl2br ｝｝</div>
                                        <div class="td tutorial-td"><a class="btn btn-default btn-block btn-sm" href="｛｛ url('tutorial_crud_edit', {'id' : Crud.id}) ｝｝">
                                            編集
                                            </a></div>
                                        <div class="td tutorial-td">
                                            <a class="btn btn-default btn-block btn-sm" href="｛｛ url('tutorial_crud_delete', {'id' : Crud.id})  {{ csrf_token_for_anchor() }} data-method="delete" data-message="この会員情報を削除してもよろしいですか？"｝｝">削除</a>
                                            </div> ★削除ボタンを追記します。
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
-->

- 上記説明を行います。

1. テーブルの見出しに削除の項目を追記します。
    - **本例ではテーブルタグを用いず、divタグ**に**tdクラスを追加**する事で、**テーブル形式の表示**を行なっています。

1. テーブル項目の最後に削除ボタンを追記します。
    - **「a」タグ**を用い、**CSSでボタン形状**に成形しています。
    - さらにルーティング定義の際に説明した、セキュリティ対策のために**data-method="delete"**でメソッドを指定しています。
    - セキュリティ対策がもう一つ施されています。
    
        ```
        ｛｛ csrf_token_for_anchor() ｝｝
        ```

    - 上記メソッドで、トークンを発行しています。
    - トークンの説明については、後述のコントローラーで詳細な説明を行います。

1. **data-message**を記述する事で確認ダイアログが表示されます。

1. 先程追加した**「a」タグ**の**リンク部URL**ですが、以前利用した**Twig関数**の**url()**でを用いています。
    - 今回の**ルーティング先で削除処理**を行うため、**レコードの特定が行えるID**を、**URLパラメーター**として付与しています。
    - 詳細は前章で説明した通りです。

## 削除処理用メソッドの定義

- CrudController.phpに削除処理用メソッドを定義します。

### メソッドの追記

- 以下メソッドを追記します。

    - **CrudController.php**を開きます。
    - /src/Eccube/Controller/CrudController.php

        1. **editメソッドの下**に**以下を追記**します。

        - **CrudController.php**

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_13/CrudController_add_delete.php"></script>

<!--
```
    /**
     * 削除画面
     * 引数を元に該当レコードを削除
     * 問題がなければ、登録画面に遷移
     *
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Application $app, Request $request, $id)
    {
        $this->isTokenValid($app);

        $Crud = $app['orm.em']
            ->getRepository('Eccube\Entity\Crud')
            ->find($id);

       if (is_null($Crud)) {
            $app->addError('該当IDのデーターが見つかりません');
            return $app->redirect($app->url('tutorial_crud'));
       }

        $app['orm.em']->remove($Crud);
        $app['orm.em']->flush($Crud);

        return $app->redirect($app->url('tutorial_crud'));
     }
```
-->

- 上記を説明します。

    1.メソッド名をルーティングで設定した「delete」とします。

    2.引数は「$app・$request」に加え、**「id」を追記**します。

    - **遷移元のViewからURLパラメーターとして、渡ってきた値**です。
    - 今回の**削除対象レコード**の、**idを保持**しています。

    3.処理冒頭で、トークンのチェックを行なっています。

    - Viewで以下を記述しました。

        ```
        ｛｛ csrf_token_for_anchor() ｝｝
        ```

    - 上記の記述により**リクエストにトークン**がサーバーに送信されます。
    - 上記を冒頭の以下メソッドで確認しています。
    
        ```
        $this->isTokenValid($app);
        ```

    - 今回の**削除機能**は、画面のボタンのクリックで、コントローラーに直接アクセスします。
    - これは、フォームからサブミットされるのとは異なります。
    - 例えば、悪意のあるユーザーが、本URL記載したメールを誰かに送信した際に、受信者が何も知らずにクリックすると、大切なデータが削除されてしまいます。
    - これは編集画面においても同様ですが、編集画面に遷移するのとは違い、削除が行われると実害となります。
    - 上記の様な事を防ぐために、**画面からのトークンをリクエスト受け付け時にチェック**し、**正しい画面遷移**でリクエストが送られてきた事を確認します。

    4.次に以下の新しいメソッドが記述されています。

    ```
    $app['orm.em']->getRepository([エンティティ名])
    ```

    - 上記は与えられた引数名のエンティティを取得します。
    - 今回はエンティティのマジックメソッド**find**を用い、該当IDのレコードを取得しています。

    5.次は取得レコードの有無をチェックし、取得できない際はメッセージを表示し、元の画面にリダイレクトしています。

    6.レコードチェックで問題がなければ、該当レコードを以下メソッドを用い、エンティティマネージャーに削除依頼を行います。

    ```
    $app['orm.em']->remove($Crud);
    ```

    7.エンティティマネージャーに依頼が完了したら、**flush**で削除処理を実行します。

    8.**処理成功時**に、**登録画面に画面遷移**しています。

    - **画面遷移**をさせるために**redirectメソッド**を用いています。

    9.本メソッドでは、画面をレンダリングしません。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

#### 初期画面

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 登録画面の一覧リストに「削除ボタン」が表示されています。
    - レコードは必ず一件以上ある状態で確認してください。

---

![一覧画面削除ボタン](/images/img-tutorial13-view-rendar-crud-top.png)

---

#### 確認ダイアログの表示

1. 初期画面で表示されている、「削除ボタン」をクリックしてください。

1. 確認ダイアログが表示されます。

---

![一覧画面ダイアログ](/images/img-tutorial13-view-rendar-crud-top-confirm.png)

---

#### 登録画面へ遷移

1. 「OKボタン」をクリックすると、登録画面に画面遷移します。

1. 該当レコードが削除されています。

---

![削除完了](/images/img-tutorial13-view-rendar-crud-delete-complete.png)

---

## 本章で学んだ事

1. ルーティングでURLパラメーターを渡す方法を説明しました。
1. ルーティングでURLパラメーターのバリデーションを行う方法を説明しました。
1. Twigのurl関数の第二引数の設定でURLパラメーター付きリンクが作成出来る事を説明しました。
1. Twigで確認ダイアログを表示する方法を説明しました。
1. Twigでリンクに対してトークンを発行する方法を説明しました。
1. 削除処理用のコントローラーメソッドを追記しました。
1. 削除処理用コントローラーメソッドの引数で、URLパラメーターを取得する方法を説明しました。
1. ridirectの方法を説明しました。
1. コントローラーでもurlが利用出来る事を説明しました。
