<?php


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class CrudController extends AbstractController
{

    public function index(Application $app)
    {
        $viewname = 'このビューは「Tutorial/crud_top.twig」が表示されています。';★追記

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'viewname' => $viewname,
            )
        );★連想配列を追記
    }
}
