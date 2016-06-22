<?php

.
..
...
        // Tutorial
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');
        $c->match('/tutorial/crud/edit/{id}', '\Eccube\Controller\Tutorial\CrudController::edit')->bind('tutorial_crud_edit')->assert('id', '^[1-9]+[0]?$'); ★ルーティングとURLパラメーターの設定を追記

        return $c;
    }
}
.
..
...
