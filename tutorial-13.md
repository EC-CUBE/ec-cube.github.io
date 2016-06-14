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

## 条件検索とアップデート処理

- 前章では、URLパラメータで受け取ったIDをもとに該当レコードを編集しました。

- 本章は、前章とほぼ同内容ですが、次はレコード削除する方法を説明します。

## 削除画面のルーティング

- まずはFrontControllerProviderにルーティングを定義します。

### ルーティングの設定

- **FrontControllerServiceProvider**を開きます。
    - /src/Eccube/ControllerProvider/FrontControllerProvider.php

    1. 以下を追記します。

        - **FrontControllerProvider.php**

```
        // Tutorial
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');
        $c->match('/tutorial/crud/edit/{id}', '\Eccube\Controller\Tutorial\CrudController::edit')->bind('tutorial_crud_edit')->assert('id', '^[1-9]+[0]?$');
        $c->match('/tutorial/crud/delete/{id}', '\Eccube\Controller\Tutorial\CrudController::delete')->bind('tutorial_crud_delete')->assert('id', '^[1-9]+[0]?$');

        return $c;
    }
}
```

- 上記の説明を行います。

    1. まず「Tutorial」を検索します。

    1. 以前追記した、チュートリアル削除画面用のルーティングが記述されています。

    1. その行をコピーし、ルーティング名、メソッド名を削除処理用のものに書き換えます。
        - 前章の説明と相違はありません。

### 画面へのルーティングの追加

- **crud_top.twig**に**削除ボタンを追加**し、**先程定義したルーティング名を設定**します。
- またあわせて**確認ダイアログ**を**Js**を記述します。
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
    <script type="text/javascript">
        (function($){ ★誤操作防止のためのダイアログをJsで定義します。
            $('#delete-btn').bind('click', function(){
                if(confirm('削除したデータは元に戻せません。よろしいですか?')){
                    return true;
                }else{
                    return false;
                }
            });
        })(jQuery);
    </script>
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
                                        <div class="td tutorial-td"><a id="delete-btn" class="btn btn-default btn-block btn-sm" href="｛｛ url('tutorial_crud_delete', {'id' : Crud.id}) ｝｝">
                                                削除
                                            </a></div> ★削除ボタンを追記します。誤操作防止のためのJsのためにidを付与します。
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

1. テーブルの見出しに削除の項目を追記します。
    - **本例ではテーブルタグを用いず、divタグ**に**tdクラスを追加**する事で、**テーブル形式の表示**を行なっています。

1. テーブル項目の最後に削除ボタンを追記します。
    - **「a」タグ**を用い、**CSSでボタン形状**に成形しています。

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

```
    /**
     * 削除画面
     * 引数を元に該当レコードを削除後、エラーがあれば、LogicExceptionをスロー
     * 問題がなければ、登録画面に遷移
     *
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Application $app, Request $request, $id)
    {
        $deleteResult = $app['eccube.repository.crud']->deleteDataById($id);

        if (!$deleteResult) {
            throw new \LogicException();
        }

        return $app->redirect($app->url('tutorial_crud'));
```

- 上記を説明します。

    1. メソッド名をルーティングで設定した「delete」とします。

    1. 引数は「$app・$request」に加え、**「id」を追記**します。
        - **遷移元のViewからURLパラメーターとして、渡ってきた値**です。
        - 今回の**削除対象レコード**の、**idを保持**しています。

    1. 処理冒頭で、レポジトリで定義した削除処理メソッドにidを渡し、処理を委譲しています。
        - 削除メソッドは後で記述します。

    1. 取得値のエラーハンドリングとして、レコードが削除出来なかった際は、不正なアクセス及びエラーとみなし、以下エラーをスローします。

    ```
    throw new \LogicException();
    ```

    1. **更新処理成功時**に、**登録画面に画面遷移**しています。
    - **画面遷移**をさせるために**redirectメソッド**を用いています。

    1. 本メソッドでは、画面をレンダリングしません。

## レポジトリに削除メソッドを追加する

- idをもとにdtb_crudからレコードを削除するメソッドを追記します。

### ファイルの修正

- CrudRepository.phpを開きます。
    - /src/Eccube/Repository/CrudRepository.php

        1. saveメソッドの下に以下の様にメソッドを追記します。

        - **CrudRepository.php**

```
   /**
     * deleteById
     * dtb_crudの値をIDで引き当て、削除
     *
     * @param null $id
     * @return bool|mixed
     */
    public function deleteDataById($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        $qb = $this->createQueryBuilder('dc');
        $qb->delete()
            ->where('dc.id = :Id')
            ->setParameter('Id', $id);

        return $qb->getQuery()->execute();
    }
```

- 上記説明を行います。

1. メソッドの引数として取得レコードのidを定義します。
    - ここで受け取る**id**は**URLパラメーター**から渡されてきた**削除対象レコード**の**id**です
    - idのデフォルト値として、nullを指定しています。
    - nullの指定はエラーハンドリングのために設定しています。

1. 引数のデフォルト値を利用して、エラーハンドリングを行なっています。
    - コントローラー側で判断するため、falseを返却するだけとしています。

1. 次にクエリビルダーでSQLを構築しています。
    - 今回新たに記述されている内容として、以下があります
    
    ```
    $qb->delete()
    ```

    - 上記は**通常のSQLのdelete構文と同義**です。
    - カラムに対して条件を付与しています。
    - 今回は、dtb_crudのカラムidに対して、引数のidが同じレコードを削除する条件を記述しています。
    - またクエリビルダーの条件指定では、**プリペアドステートメント**が用いらてます。

    - もうひとつ新たな記述があります。

    ```
    return $qb->getQuery()->execute();
    ```

    - 上記ですが、**取得系の処理以外**では、**execute**でSQLを**実行**します。

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
1. 削除処理用のコントローラーメソッドを追記しました。
1. 削除処理用コントローラーメソッドの引数で、URLパラメーターを取得する方法を説明しました。
1. ridirectの方法を説明しました。
1. コントローラーでもurlが利用出来る事を説明しました。
1. レポジトリに追加したメソッドでdelete句を用いたDQLの構築方法を説明しました。
1. DQLの実行ににexecuteを用いました。
1. クエリビルダーではプリアドステートメントが用いられていることを説明しました。
