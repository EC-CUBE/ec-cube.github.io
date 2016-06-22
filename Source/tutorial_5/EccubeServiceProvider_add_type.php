<?php
.
..
...
// front
$types[] = new \Eccube\Form\Type\Front\EntryType($app['config']);
$types[] = new \Eccube\Form\Type\Front\ContactType($app['config']);
$types[] = new \Eccube\Form\Type\Front\NonMemberType($app['config']);
$types[] = new \Eccube\Form\Type\Front\ShoppingShippingType();
$types[] = new \Eccube\Form\Type\Front\CustomerAddressType($app['config']);
$types[] = new \Eccube\Form\Type\Front\ForgotType();
$types[] = new \Eccube\Form\Type\Front\CustomerLoginType($app['session']);
$types[] = new \Eccube\Form\Type\Front\CrudType($app['config']); ★追記
.
..
...
