---
layout: default
title: リストを編集しよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. コントローラーに編集用のメソッドを追記します。

    1. FrontControllerServiceProviderに編集用のルーティングを設定します。

    1. ルーティングでURLパラメーターを取得します。

    1. フォームビルダーで既存フォーム項目の削除・追加を行います。

    1. フォームビルダーの追加時の設定項目でhtmlタグのオプションを設定します。

    1. エンティティマネージャーで登録・編集処理が共通で行われている事を確認します。

    1. 編集用の画面を作成します。

    1. リダイレクト利用します。

## 条件検索とアップデート処理

- 前章では、レポジトリを用いた、検索・登録について学びました。

- 本章では、ここまで学んだ事を応用して、更新処理を実装します。

## 編集ボタンの追加

1. まずは**crud_top.twig**に**編集ボタンを追加**します。
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

1. 現在テーブル表示項目の見出しの最後に編集用の項目を追加します。
    - **cssはBootStrapが利用**されているために、**divのクラスにtdを追加**する事で**テーブルのtdと同等**の表示を行なっています。

1. 現在テーブル表示項目の最後に編集ボタンを追加します。
    - ボタン表示もBootStrapを利用して構築しています。

- この定義によって、テーブル、エンティティ、テーブルとエンティティの関係、さらに今回のレポジトリで**データーベース操作**クラスの関連付けが行われています。

### レポジトリの作成

#### ファイルの作成

- 以下フォルダ内にレポジトリが保存されています。

1. /src/Eccube/Repository

1. 次に**CrudRepository.php**を作成します。

- AuthorityRoleRepository.phpをコピー、リネームします。

    - **CrudRepository.php**( 中身はAuthorityRoleRepository.phpのコピー )

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


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AuthorityRoleRepository ★リネーム
 * 
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AuthorityRoleRepository extends EntityRepository ★リネーム
{

    /**
     * 権限、拒否URLでソートする
     *
     * @return array
     */
    public function findAllSort()
    {
        return $this->findBy(array(), array('Authority' => 'ASC', 'deny_url' => 'ASC'));
    }
}
```

- 上記のソースを以下の様に修正します。

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


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CrudRepository ★コメントのクラス名を修正
 * 
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrudRepository extends EntityRepository ★クラス名を修正
{
    ★メソッドは一度全て削除
}
```


## サービスプロバイダへの登録

- 次にコントローラーからレポジトリを呼び出すために、サービスプロバイダに登録します。

- 以下のサービスプロバイダを修正していきます。
    - /src/Eccube/ServiceProvider/EccubeServiceProvider.php

    1. ファイルを開いて以下の様に修正します。

        - **EccubeServiceProvider.php**

    1. 次に「Repository」のコメントを検索します。

```
        // Repository
        $app['eccube.repository.master.authority'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Master\Authority');
        });
        $app['eccube.repository.master.tag'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Master\Tag');
        });
        $app['eccube.repository.master.pref'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Master\Pref');
        });
        ...
        ..
        .
```

- 上記を検索で見つけたら、次に「Repository」の一番最後の行に**CrudRepository**のサービスプロバイダへの登録をおこないます。

```
        $app['eccube.repository.help'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Help');
        });
        $app['eccube.repository.plugin'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\Plugin');
        });
        $app['eccube.repository.plugin_event_handler'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Eccube\Entity\PluginEventHandler');
        });

        $app['eccube.repository.crud'] = $app->share(function () use ($app) { ★この行を追加
            return $app['orm.em']->getRepository('Eccube\Entity\Crud');
        });

        // em
```

- 上記の追加で、**$app**が利用できれば、「**$app['eccube.repository.crud']**」で呼び出す事が可能となりました。


## Doctrine定義のマジックメソッドで情報取得

- レポジトリにはあらかじめ、以下の様な検索系メソッドが標準で容易されています。

    - **find ～**

- 本項ではまず、一覧データーを**エンティティーマネージャー**、**クエリビルダー**を利用して抽出していた箇所を、**レポジトリのマジックメソッド**に置き換えてみます。

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
        $app->clearMessage();

        $Crud = new \Eccube\Entity\Crud();

        $builder = $app['form.factory']->createBuilder('crud', $Crud);

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $app->addSuccess('データーが保存されました');
            $app['orm.em']->persist($Crud);
            $app['orm.em']->flush($Crud);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $app->addSuccess('入力内容をご確認ください');
        }

        $crudList = $app['eccube.repository.crud']->findAll(); ★クエリビルダーから置き換え

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'forms' => $form->createView(),
                'crudList' => $crudList,
            )
        );
    }
}
```

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. クエリビルダーで一覧情報を取得していた際と同じ結果が表示されています。
        - ※正確には、**order**を指定していないため、複数のレコードがある際は、表示順序が異なるかも知れません。

---

![レポジトリで一覧取得](/images/img-tutorial11-view-rendar-repository-findall.png)

---

### Doctine定義のマジックメソッド

- 本章ではレポジトリが保有しているメソッド**findAll**を使用して、一覧表示用のデーターを取得しました。
- findAllメソッドは**Doctrine定義のマジックメソッド**で他にも下記参照先の様な種類があります。
    - <a href="http://docs.symfony.gr.jp/symfony2/book/doctrine.html#id8" target="_blank">データベースからのオブジェクトのフェッチ</a>

- **マジックメソッドは便利**なため、**よく利用**しがちですが、**findBy～**などは、**オーバーライドによる、危険性**があるため、**EC-CUBE3では、推奨していません。**

## レポジトリのメソッド定義
  - 上記でレポジトリのマジックメソッドについて説明を行いました。
  - 簡易な情報であれば、**findAll**で問題ないかも知れませんが、複雑なクエリでの情報取得などの場合、またはケースバイケースにはなりますが、メンテナンス性を考慮し、通常はレポジトリ内に、データーベース操作のロジックを定義し、コントローラーは必要情報の取得、条件のを受け渡しのみとし構築する事が多いかと思います。
  - ここでは、一覧表示の情報取得、データーベースへの登録部分を、レポジトリにメソッドして定義していきます。

### レポジトリファイルの修正

1. 以下のファイルを開きます。
    - /src/Eccube/Repository/CrudRepository.php

    1. ファイルを開いて以下の様に修正します。

        - **CrudRepository.php**

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


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CrudRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrudRepository extends EntityRepository
{
    /**
     * getAllDataSortByUpdateDate
     * dtb_crudの値を全て返却、引数により更新日をソート
     *
     * @param string $order
     * @return array|bool
     */
    public function getAllDataSortByUpdateDate($order = 'asc') ★更新日付で昇順・降順でソートし全てのデーターを返却するメソッドを作成します。
    {
        $qb = $this->createQueryBuilder('dc'); ★クエリビルダーの取得

        $qb->select('dc') ★クエリ作成
            ->orderBy('dc.update_date', $order);

        $res = $qb->getQuery()->getResult(); ★一覧表示情報の取得

        return count($res) > 0 ? $res : false; ★取得情報の判定と対応値の返却
    }

    /**
     * save
     *
     * @param \Eccube\Entity\Crud $entity
     * @return bool
     */
    public function save(\Eccube\Entity\Crud $entity) ★引数のエンティティを保存するメソッド
    {
        $em = $this->getEntityManager(); ★エンティティマネージャーを取得

        try { ★リレーションをしていないため、トランザクションの必要性は低いがトランザクション定義
            $em->beginTransaction();
            $em->persist($entity);
            $em->flush($entity); ★エンティティの保存
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback(); ★予想外のエラーが発生した際はロールバック

            return false;
        }

        return true;
    }
}
```
- 上記の説明を行います。

### 一覧表示データーの取得

- 一覧表示データー用メソッドをレポジトリに定義します。

    1. まずメソッドを定義です。
        - 今回のメソッドは、**引数**で**更新日時の昇順・降順を指定**し、**データーがテーブルに一件でもあれば**、**ソート済みのオブジェクト配列を返却**します。

    1. クエリビルダーの取得。
        - **コントローラーでクエリビルダーを取得する際**は、**エンティティマネージャを取得**してから、**クエリビルダーを取得**していましたが、**レポジトリでは、$thisで取得可能**です。
        - その際の相違点として、**対象テーブルは、データベース構造定義ファイルで指定されている**ため、**fromメソッド**必要なく、**createQueryBuilderの引数**に**エイリアス**を定義します。

    1. **クエリ生成部は、コントローラー記述時とほとんど差異がなく**、**オーダーバイの条件を変数で渡している**箇所のみ**相違**があります。

    1. 最後に取得オブジェクト配列を返却していますが、その際にカウントでレコードがあるかどうか判定し、三項演算子で返却値を生成しています。

### 情報の保存

- **コントローラー**でサブミット値、入力値判定成功後に**エンティティマネージャーで保存**していた内容を、本**レポジトリに移設**します。

    1. まず**引数**ですが、**タイプヒンティング**を用い、**dtb_crudのエンティティしか受け付けない**様にしています。

    1. 次にエンティティマネージャーを取得します。
        - 情報**取得処理**とは**違い**、本メソッドでは、**エンティティマネージャーを利用**します。

    1. 次に、応用として、**トランザクション**処理のために、**try ～ catch**を利用しています。
        - 通常本ケースであれば、リレーションもないために、トランザクションの必要性は低いですが、**例題としてあえて利用**しています。

    1. トランザクションの開始です。
        - トランザクションの開始には、以下メソッドを利用します。
        
        ```
        $em->beginTransaction();
        ```

        - **エンティティマネージャー**から**上記メソッド**を呼び出すだけで、トランザクション処理が**開始**されます。

    1. 情報の保存
        - 情報の保存は、コントローラーで定義していた内容と、ほぼ同じで、**transaction**処理のためにに**$em->commit();**を呼び出し、コミットを行なっています。

    1. もし保存中に、不明なエラーが発生した時のために、catchでエラーを補足し、**$em->rollback()**を呼び出し、ロールバックを行なっています。

## コントローラーファイルからレポジトリメソッドを呼び出す
  - 上記でレポジトリにメソッドが定義しました。
  - 次にコントローラーファイルを修正して、**情報の取得、保存処理を完成**させます。

### コントローラーの修正

1. 以下のファイルを開きます。
    - /src/Eccube/Controller/Tutorial/CrudController.php

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
    const LIST_ORDER = 'desc'; ★ソート順切り替えに定数を宣言

    public function index(Application $app, Request $request)
    {
        $app->clearMessage();

        $Crud = new \Eccube\Entity\Crud(); ★フォーム生成部は処理かわらず

        $builder = $app['form.factory']->createBuilder('crud', $Crud);

        $form = $builder->getForm();

        $defaultForm = clone $form; ★処理成功時の画面で保持値をクリアするために、空のエンティティを格納したフォームを一時保存

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveStatus = $app['eccube.repository.crud']->save($Crud); ★サブミット値をエンティティマネージャーではなくレポジトリのメソッドに渡す

            if ($saveStatus) {
                $app->addSuccess('データーが保存されました');
                $form = $defaultForm; ★フォームオブジェクトを一時保存しておいた空エンティティのフォームオブジェクトで上書き
            } else {
                $app->addError('データーベースの保存中にエラーが発生しました'); ★登録後一覧情報が取得出来ない際は、エラーメッセージを表示
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $app->addError('入力内容をご確認ください');
        }

        $crudList = $app['eccube.repository.crud']->getAllDataSortByUpdateDate(self::LIST_ORDER); ★レポジトリに作成したメソッドで更新日時降順の全レコード取得

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'forms' => $form->createView(),
                'crudList' => $crudList,
            )
        );
    }
}
```

- 上記の説明を行います。

1. **フォーム生成部のロジックに変更はありません**。

1. 今回のレポジトリへのロジック移設とは直接関係ありませんが、**エンティティが空のフォームオブジェクトをクローン**します。
    - **保存成功時に、ユーザー入力データーをクリアするため**に、**new直後のエンティティ**と紐付いたフォームオブジェクトを一時保存しておきます。
    - 登録にはクローン元のフォームオブジェクトを利用します。

1. **エンティティマネージャーで保存**していた、ユーザー入力値を、**レポジトリのメソッドに置き換え**ます。

1. エラー判定を行い、以下を返却します。
    - 成功時
        - 成功メッセージ
        - 空エンティティフォーム
    - 失敗時
        - エラーメッセージ

1. **エンティティマネージャー**と**クエリビルダー**で取得していた**一覧表示用配列オブジェクト**を、**レポジトリのメソッドに置き換え**ます。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

#### 初期画面

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. レコードがあれば入力画面とリストが表示されているはずです。

---

![一覧画面](/images/img-tutorial11-view-rendar-default-has.png)

---

#### データー保存時

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 各項目に正しい値を入力して登録を行なってください。

1. 以下が表示されるはずです。

---

![データー保存後データ登録画面](/images/img-tutorial11-view-rendar-adddata.png)

---

#### エラー内容入力時

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

1. 投稿者ハンドルネームに「テスト3」を入力してください。

1. 以下が表示されるはずです。

---

![エラーデーター登録時データ登録画面](/images/img-tutorial11-view-rendar-error.png)

---

## 本章で学んだ事

1. データーベース構造定義ファイルのレポジトリ定義の確認
1. レポジトリファイルの作成
1. 作成レポジトリのサービスプロバイダへの登録
1. Doctrine定義のマジックメソッド(取得系)の説明
1. マジックメソッドを使ったコントローラーからの情報取得
1. レポジトリでのメソッド定義
1. レポジトリ内でのクエリビルダーの取得構築
1. レポジトリ内メソッドでの保存方法(エンティティマネージャー利用)
1. レポジトリ内メソッドでのトランザクション利用方法
1. コントローラーからレポジトリメソッドの呼び出し
