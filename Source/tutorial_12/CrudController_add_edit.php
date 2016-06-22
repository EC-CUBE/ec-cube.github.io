<?php
.
..
...
   /**
     * 編集画面
     * @param $id
     */
    public function edit(Application $app, Request $request, $id) ★引数に「$id(URLパラメーター)」を追記
    {
        $Crud = $app['eccube.repository.crud']->getDataById($id); ★該当レポジトリから「id」をキーに編集対象レコードを取得

        if (!$Crud) { ★エラー判定、データーが一件もない場合は登録画面へ遷移
            return $app->redirect($app->url('tutorial_crud'));
        } 

        $builder = $app['form.factory']->createBuilder('crud', $Crud); ★取得エンティティをもとに、フォームビルダーを生成
        $builder->remove('save'); ★フォームタイプに設定した項目「save」ボタンを削除
        $builder->add( ★ビルダーに編集確定用ボタンを追加
            'update',
            'submit',
            array(
                'label' => '編集を確定する',
                'attr' => array(
                    'style' => 'float:left;',
                )
            )
        )
        ->add( ★ビルダーに「戻る」ボタンを追加
            'back',
            'button',
            array(
                'label' => '戻る',
                'attr' => array(
                    'style' => 'float:left;',
                    'onClick' => 'javascript:history.back();'
                )
            )
        );

        $form = $builder->getForm(); ★再構築したフォームビルダーからフォームを取得

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $saveStatus = $app['eccube.repository.crud']->save($Crud); ★サブミットデーターの更新(登録処理と同内容)

            if ($saveStatus) {
                $app->addSuccess('データーが保存されました');
                return $app->redirect($app->url('tutorial_crud')); ★更新成功時は、登録画面へ遷移
            } else {
                $app->addError('データーベースの保存中にエラーが発生いたしました');
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $app->addError('入力内容をご確認ください');
        }

        return $app->render(
            'Tutorial/crud_edit.twig',
            array(
                'forms' => $form->createView(),
                'crud' => $Crud,
            )
        );
    }
}
.
..
...
