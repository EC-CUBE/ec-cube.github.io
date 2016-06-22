<?php
.
..
...
        // Tutorial
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');
        $c->match('/tutorial/crud/edit/{id}', '\Eccube\Controller\Tutorial\CrudController::edit')->bind('tutorial_crud_edit')->assert('id', '^[1-9]+[0]?$');
        $c->delete('/tutorial/crud/delete/{id}', '\Eccube\Controller\Tutorial\CrudController::delete')->bind('tutorial_crud_delete')->assert('id', '^[1-9]+[0]?$');

        return $c;
    }
}
.
..
...
