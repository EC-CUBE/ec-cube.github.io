<?php

namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CrudController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
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
