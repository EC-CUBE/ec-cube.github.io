<?php


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class CrudController extends AbstractController
{
    public function index(Application $app)
    {
        //$viewname = 'このビューは「Tutorial/crud_top.twig」が表示されています。';★コメントアウトします。

        $builder = $app['form.factory']->createBuilder('form', null, array())★ここからフォーム定義を追加

        $builder->add(
            'reason',
            'choice',
            array(
                'label' => '投稿種別',
                'choices' => array('1' => '質問', '2' => '提案'),
                'required' => false,
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
            )
        )
        ->add(
            'title',
            'text',
            array(
                'label' => '投稿のタイトル',
                'required' => false,
                'mapped' => false,
            )
        )
        ->add(
            'notes',
            'textarea',
            array(
                'label' => '内容',
                'required' => false,
                'mapped' => false,
                'empty_data' => null,
                'attr' => array(
                    'style' => 'height:100px;',
                ),
            )
        );

        $forms = $builder->getForm();

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                //'viewname' => $viewname,★コメントアウトします。
                'forms' => $forms->createView(),★追記
            )
        );
    }
}
