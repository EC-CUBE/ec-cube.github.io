<?php


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
        $Crud = new \Eccube\Entity\Crud(); ★前章で作成した、dtb_crud用のエンティティ(データモデルオブジェクト)をインスタンス化します。

        $builder = $app['form.factory']->createBuilder('crud', $Crud); ★ビルダーを取得する際に、第二引数にCrudのエンティティを渡します。

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
