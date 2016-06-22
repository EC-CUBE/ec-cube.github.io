<?php

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
