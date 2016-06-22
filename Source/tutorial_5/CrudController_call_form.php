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
