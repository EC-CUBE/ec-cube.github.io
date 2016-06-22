<?php


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; ★リクエストを取得するため追加します。

class CrudController extends AbstractController
{
    public function index(Application $app, Request $request) ★リクエストを引数で取得するために追記します。
    {
        $builder = $app['form.factory']->createBuilder('crud', null); ★ビルダーからType名を指定して、CrudTypeを取得します。

        $form = $builder->getForm();

        $form->handleRequest($request); ★リクエストとフォーム入力を関連させるために、必要です。

        $message = array('default' => '');

        if ($form->isSubmitted() && $form->isValid()) { ★入力値のチェックです
            $message = array('success' => '入力値に問題はありません');
        } elseif($form->isSubmitted() && !$form->isValid()) {
            $message = array('error' => '入力値に誤りがあります');
        }

        $forms = $builder->getForm();

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'message' => $message,
                'forms' => $forms->createView(),
            )
        );
    }
}
