<?php
.
..
...
 /**
     * 削除画面
     * 引数を元に該当レコードを削除後、エラーがあれば、LogicExceptionをスロー
     * 問題がなければ、登録画面に遷移
     *
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Application $app, Request $request, $id)
    {
        $deleteResult = $app['eccube.repository.crud']->deleteDataById($id);

        if (!$deleteResult) {
            throw new \LogicException();
        }

        return $app->redirect($app->url('tutorial_crud'));
.
..
...
