<?php

$m = new \Eccube\Entity\MigrationTest();
$m->setMemo0('a')->setMemo1(1)->setMemo2(new \DateTime());
$em->persist($m);
$em->flush();
