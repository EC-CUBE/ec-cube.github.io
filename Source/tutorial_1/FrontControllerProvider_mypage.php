<?php
.
..
...
 // mypage
    $c->match('/mypage', '\Eccube\Controller\Mypage\MypageController::index')->bind('mypage');
    $c->match('/mypage/login', '\Eccube\Controller\Mypage\MypageController::login')->bind('mypage_login');
    $c->match('/mypage/change', '\Eccube\Controller\Mypage\ChangeController::index')->bind('mypage_change');
    $c->match('/mypage/change_complete', '\Eccube\Controller\Mypage\ChangeController::complete')->bind('mypage_change_complete');
.
..
...

