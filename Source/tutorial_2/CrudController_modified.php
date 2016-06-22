<?php


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class CrudController extends AbstractController
{

    public function index(Application $app)
    {
        return $app->render('Tutorial/crud_top.twig');★修正箇所(コメント部と、echo、exitを削除)
    }
}
