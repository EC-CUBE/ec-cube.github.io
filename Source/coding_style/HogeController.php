<?php
// HogeController

class HogeController
{
    protected $title;

    protected $subTitle;

    public function index(Application $app, $id)
    {
        $Product = $app['eccube.repository.product']->find($id);

        $totalCount = 1;

        // ...

        $app->render('path/to/hoge.twig', array(
            'form' => $form->createView(),
            'Product' => $Product,
            'total_count' => $totalCount,
        ))
    }
}

// hoge.twig
