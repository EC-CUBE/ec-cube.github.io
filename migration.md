---
layout: default
title: マイグレーションガイド
---

---

# {{page.title}}

## 概要

 - EC-CUBE3系のマイナーバージョンアップに伴って変更されたDB定義の稼働環境への反映を自動化します。
 - DB定義の変更とは、テーブルの作成、削除、フィールドの作成、削除、インデックスの作成、削除、レコードの挿入、更新、削除等です。
 - マイグレーション処理はDoctrime migrationモジュールを使用します。
 - Doctrime migrationモジュールを使用することで、EC-CUBEのソースコードに定義されたDB定義とDBサーバ上のDB定義を比較し、必要なDB定義の変更だけをDBサーバに適応します。

## DBマイグレーション処理の構成

 - migrationにはDoctrine-migrationモジュールを使用し、Silexから呼び出すためのServiceProvider(**https://github.com/dbtlr/silex-doctrine-migrations**)をラッパーとして使用します。
 - マイグレーション処理は当初はコンソールから起動する前提です。
 - Webインストーラ作成の際にはインストーラから起動可能にします
 - マイグレーションファイルはsrc/Eccube/Resource/doctrine/migrationに配置します。

## マイグレーションの作成手順

 - Doctrineのテーブル定義ファイル(src/Eccube/Resource/doctrine/)を修正します。
(テーブル定義を変更しない場合は不要です)

 - 空のマイグレーションファイルを作成します。

   $ php app/console migrations:generate

    Generated new migration class to "/var/www/html/ec-cube/src/Eccube/Resource/doctrine/migration/Version20150519204013.php"

 - 上で作成したマイグレーションファイルのupメソッド定義に変更内容を記述します。 変更の処理は以下の方法で記述が可能です。
   - SchemaManagerを使ったテーブル定義の操作($table=$schema->createTable("foo")など)
   - EntityManagerを使ったレコードの操作($em->persist($customer)など)
   - リテラルとして埋め込んだSQLを直接実行（非推奨）
 - 同様にdownメソッド定義にDB定義のロールバックに必要な処理を記述します。

## マイグレーションの受け入れ手順

 - EC-CUBEのソースコードを更新します。
 - 作成されたマイグレーションをDBに反映します。

   $ php app/console migrations:migrate

       Doctrine Database Migrations

       WARNING! You are about to execute a database migration that could result in schema changes and data lost. Are you sure you wish to continue? (y/n)y

   (何も出力されませんが反映されています。既にDB定義がソースコードに追従済みの場合は、Nothing to migrateと表示されます)

## マイグレーション状況の確認

 - 適応が必要なマイグレーションの有無や現状のDB定義のバージョンを確認するには、migrationのステータスを取得します。

   $ php app/console migrations:status

2系からのバージョンアップは別途検討します....

# EC-CUBE 開発者向けDBマイグレーションガイド

## テーブル定義の変更手順

### はじめに
マイグレーション機構の用途としては、DDL(テーブル定義変更)の実行とDML(初期レコード定義)の実行の二種類があります。
それぞれ作成手順を記載します

# DDL用のマイグレーションファイルの作成手順

1.マイグレーションファイルを作成
  (php app/console migrations:generate)
2.マイグレーションファイルのup,downメソッド内に変更手順を記述する
  ただし、既に予定の変更の内容が実施済みの場合は無視するように設定すること
  (クリーンインストール時のorm:schema-tool:createを実行した場合の動作と重複してしまうため)

    テーブル追加例
    if($schema->hasTable(TABLENAME)){
        return true;
    }
    $table=$schema->createTable(TABLENAME);

    フィールド追加例
    $t=$schema->getTable(TABLENAME);
    if(!$t->hasColumn(FIELDNAME)){
        $t->addColumn(FIELDNAME,'smallint',array('NotNull'=>true,'default'=>0));
    }

3.doctrineのテーブル定義ファイル(yml)を2の内容に合わせて作成又は編集する
4.doctineのentity、repositoryを3の内容に合わせて編集する
5.コマンドラインからマイグレーションを実行(php app/console migrations:migrate)し、想定したDB定義となることを確認する
6.Webインストーラからクリーンインストールを実行し、5と同じDB定義になることを確認する


# DML用のマイグレーションファイルの作成手順

1.マイグレーションファイルを作成
  (php app/console migrations:generate)
2.マイグレーションファイルのup,downメソッド内に変更手順を記述する
  DML用の場合はDDLと違い実施内容のチェックは必要なし

    $m = new \Eccube\Entity\MigrationTest();
    $m->setMemo0('a')->setMemo1(1)->setMemo2(new \DateTime());
    $em->persist($m);
    $em->flush();

3.コマンドラインからマイグレーションを実行(php app/console migrations:migrate)し、想定した初期データが挿入されることを確認する


# Doctrineを使ってのマイグレーション
## Entityファイル作成
yamlを更新後、下記を実行するとEntityが作成される。  
元のソースは削除されずに、存在しない項目のみ追記される。  

```
vendor/bin/doctrine orm:generate:entities --extend="Eccube\Entity\AbstractEntity" src
```

## DBへのマイグレーション

```
vendor/bin/doctrine orm:schema-tool:update
```

を実行してmigration可能かどうかを確認

```
vendor/bin/doctrine orm:schema-tool:update --dump-sql
```

を実行してsqlを確認

```
vendor/bin/doctrine orm:schema-tool:update --force
```

を実行してDBへマイグレーション
