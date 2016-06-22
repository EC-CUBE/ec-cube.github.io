<?php


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
