<?php
.
..
...
    /**
     * 削除画面
     * 引数を元に該当レコードを削除
     * 問題がなければ、登録画面に遷移
     *
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Application $app, Request $request, $id)
    {
        $this->isTokenValid($app);

        $Crud = $app['orm.em']
            ->getRepository('Eccube\Entity\Crud')
            ->find($id);

       if (is_null($Crud)) {
            $app->addError('該当IDのデーターが見つかりません');
            return $app->redirect($app->url('tutorial_crud'));
       }

        $app['orm.em']->remove($Crud);
        $app['orm.em']->flush($Crud);

        return $app->redirect($app->url('tutorial_crud'));
     }
.
..
...
