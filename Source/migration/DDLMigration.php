<?php
//テーブル追加例
if($schema->hasTable(TABLENAME)){
    return true;
}
$table=$schema->createTable(TABLENAME);

フィールド追加例
$t=$schema->getTable(TABLENAME);
if(!$t->hasColumn(FIELDNAME)){
    $t->addColumn(FIELDNAME,'smallint',array('NotNull'=>true,'default'=>0));
}
