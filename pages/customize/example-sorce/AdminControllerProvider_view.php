<?php
.
..
...

        // customer
        $c->match('/customer', '\Eccube\Controller\Admin\Customer\CustomerController::index')->bind('admin_customer');
        $c->match('/customer/page/{page_no}', '\Eccube\Controller\Admin\Customer\CustomerController::index')->assert('page_no', '\d+')->bind('admin_customer_page');
        $c->match('/customer/export', '\Eccube\Controller\Admin\Customer\CustomerController::export')->bind('admin_customer_export');
        $c->match('/customer/new', '\Eccube\Controller\Admin\Customer\CustomerEditController::index')->bind('admin_customer_new');
        $c->match('/customer/{id}/edit', '\Eccube\Controller\Admin\Customer\CustomerEditController::index')->assert('id', '\d+')->bind('admin_customer_edit');
        $c->delete('/customer/{id}/delete', '\Eccube\Controller\Admin\Customer\CustomerController::delete')->assert('id', '\d+')->bind('admin_customer_delete');
        $c->put('/customer/{id}/resend', '\Eccube\Controller\Admin\Customer\CustomerController::resend')->assert('id', '\d+')->bind('admin_customer_resend');
.
..
...

