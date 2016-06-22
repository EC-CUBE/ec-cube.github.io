<?php


namespace Eccube\Controller\Tutorial; ★フォルダのパスを追加

use Eccube\Application;
use Eccube\Controller\AbstractController; ★親コントローラーのパスを追加

class CrudController extends AbstractController ★クラス名を修正 + 親コントローラーを継承
{

    public function index(Application $app)
    {
        echo 'First Tutorial';★追記
        exit();★追記
        //return $app->render('index.twig');★一旦コメントアウト
    }
}
