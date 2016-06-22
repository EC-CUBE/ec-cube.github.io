<?php
.
..
...
        // チュートリアル
        $c->match('/tutorial/crud', '\Eccube\Controller\Tutorial\CrudController::index')->bind('tutorial_crud');

        return $c;
    }
}
.
..
...

