---
layout: default
title: データーベースを作成しよう
---

---

# データーベースを作成しよう

## 本章メニュー

- 本章では以下を行います。

    1. テーブル定義を記述するマイグレーションファイルの作成方法を説明します。

    1. 本チュートリアルで利用するテーブルの定義を説明します。

    1. マイグレーションファイルの**schemaオブジェクト**を利用した、テーブル作成の方法を説明しています。

    1. テンプレートファイルの**ヘッダー・フッター表示**のために**dtb_page_layout**にデータの登録が必要な事を説明しています。

    1. **dtb_page_layout**への画面情報の登録方法について説明しています。

## 本チュートリアルのテーブル定義

- 本章メニューで示した様に、本章ではテーブル定義の内容についてのみ説明をおこいます。

- テーブル定義は**マイグレーションファイル**に記述していきます。

## マイグレーションファイルの準備

1. トップページに記述されている「マイグレーションガイド」の「マイグレーション作成手順」の内容に基づき、新しいマイグレーションファイルを作成します。

    - 内容に基づき生成を行うと以下フォルダに作成されます。
    - 保存フォルダ
      - /src/Eccube/Resource/doctrine/migration

1. 以下ファイルが出来ているか確認してください。
    - **Version20160607155514.php**

    - 下記に内容を記述します。
    - 「up」メソッドと「down」メソッドが記載されています。

```
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607155514 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        ★ここにテーブル定義を追記

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        ★ここのテーブル定義を削除

    }
}
```

## 今回チュートリアルのテーブル定義

- テーブル名 : dtb_crud

| 論理名 | 物理名 | フィールドタイプ | その他 |
|------|------|------|------|
| 投稿ID | id | int | NOT NULL PRIMARY AUTO_INCREMENT |
| 投稿種別 | reason | smallint | NOT NULL |
| 投稿者ハンドルネーム | name | varchar(255) | NOT NULL |
| 投稿のタイトル | title | varchar(255) | NOT NULL |
| 投稿種別 | notes | text | DEFAULT NULL |
| 投稿登録時間 | created_date | datetime | NOT NULL |
| 投稿編集時間 | updated_date | datetime | NOT NULL |

- 上記のテーブル定義を以下に記述していきます

```
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607155514 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (!$schema->hasTable('dtb_crud')) {
            $table = $schema->createTable('dtb_crud');
            $table->addColumn('id', 'integer', array(
                'autoincrement' => true,
            ));
            $table->addColumn('reason', 'smallint', array('NotNull' => true));
            $table->addColumn('name', 'string', array('NotNull' => true, 'length' => 255));
            $table->addColumn('title', 'string', array('NotNull' => true, 'length' => 255));
            $table->addColumn('notes', 'text', array('default' => 'null'));
            $table->addColumn('create_date', 'datetime', array('NotNull' => true));
            $table->addColumn('update_date', 'datetime', array('NotNull' => true));
            $table->setPrimaryKey(array('id'));
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if (!$schema->hasTable('dtb_crud')) {
            $schema->dropTable('dtb_crud');
        }
    }
}
```

- 上記の説明を行います。

- メソッドの引数に**$schema**変数が存在しますが、テーブル操作を行うためのオブジェクトです。

    1. はじめに、**hasTable**メソッドを用いて、**今回テーブルの有無**を確認しています。
    1. テーブルが存在しない場合のみ**createTable**メソッドで**テーブルを作成**します。
    1. テーブルを作成した後は、テーブルスキーマを確認しながら、**addColumn**メソッドでカラムを追加していきます。
    1. 最後に、**setPrimaryKey**でプライマリーキーを指定しています。
    1. 次に「down」メソッド時の**dropTable**メソッドでテーブルを削除しています。

## dtb_page_layoutへの画面情報の登録

- EC-CUBE3のテンプレートの**ヘッダー・フッター**は、**dtb_page_layout**に画面情報が**登録されていないと表示されません**。

- 以下に**dtb_page_layout**に保存する情報を記載します。

- テーブル名 : dtb_page_layout

| 物理名 | 登録情報 | 登録値 |
|------|------|------|
| device_type_id | 表示デバイスのタイプ | mtb_device_typeのキー10(PC)を取得し格納 |
| page_name | 画面のタイトル | チュートリアル/CRUD |
| url | 画面のルーティング名称 | tutorial_crud |
| file_name | 該当Twigのルートからのパスと名称 | Tutorial/crud_top |
| edit_flg | 管理画面から編集可能かどうか | 2 |

- 上記のレコード追加を以下に記述していきます

```
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Eccube\Entity\PageLayout;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607155514 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (!$schema->hasTable('dtb_crud')) {
            $table = $schema->createTable('dtb_crud');
            $table->addColumn('id', 'integer', array(
                'autoincrement' => true,
            ));
            $table->addColumn('reason', 'smallint', array('NotNull' => true));
            $table->addColumn('name', 'string', array('NotNull' => true, 'length' => 255));
            $table->addColumn('title', 'string', array('NotNull' => true, 'length' => 255));
            $table->addColumn('notes', 'text', array('default' => 'null'));
            $table->addColumn('create_date', 'datetime', array('NotNull' => true));
            $table->addColumn('update_date', 'datetime', array('NotNull' => true));
            $table->setPrimaryKey(array('id'));
        }

        $app = \Eccube\Application::getInstance(); ★EC-CUBEのアプリケーションクラスを取得
        $em = $app['orm.em']; ★エンティティマネージャーを取得
        $qb = $em->createQueryBuilder(); ★クエリビルダーを取得

        $qb->select('pl') ★該当情報が登録済みかどうかを確認するためのSQLを構築
            ->from('\Eccube\Entity\PageLayout', 'pl')
            ->where('pl.url = :Url')
            ->setParameter('Url', 'tutorial_crud');

        $res = $Point = $qb->getQuery()->getResult(); ★SQL結果を取得

        if(count($res) < 1){ ★結果がなければ、以下情報を書き込み
            $PageLayout = new PageLayout(); ★登録するためのエンティティをインスタンス化
            $DeviceType = $em->getRepository('\Eccube\Entity\Master\DeviceType')->find(10); ★格納するデバイスタイプをDBから取得
            $PageLayout->setDeviceType($DeviceType); ★以下登録エンティティに必要情報を格納
            $PageLayout->setName('チュートリアル/CRUD');
            $PageLayout->setUrl('tutorial_crud');
            $PageLayout->setFileName('Tutorial/crud_top');
            $PageLayout->setEditFlg(2);

            $em->persist($PageLayout); ★エンティティマネージャーの管理化に登録エンティティ追加
            $em->flush($PageLayout); ★登録エンティティを対象に保存
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if (!$schema->hasTable('dtb_crud')) {
            $schema->dropTable('dtb_crud');
        }

        $app = \Eccube\Application::getInstance(); ★EC-CUBEのアプリケーションクラスを取得
        $em = $app['orm.em']; ★エンティティマネージャーを取得
        $qb = $em->createQueryBuilder(); ★クエリビルダーを取得

        $qb->select('pl') ★該当画面情報が保存されているかを確認するためのSQLを生成
            ->from('\Eccube\Entity\PageLayout', 'pl')
            ->where('pl.url = :Url')
            ->setParameter('Url', 'tutorial_crud');

        $res = $Point = $qb->getQuery()->getResult(); ★情報取得

        if(count($res) > 0){ ★該当情報が保存されていれば、削除処理
            $qb->delete() ★該当画面情報を削除するための、SQLを生成
                ->from('\Eccube\Entity\PageLayout', 'pl')
                ->where('pl.url = :Url')
                ->setParamater('Url', 'tutorial_crud');
            $res = $Point = $qb->getQuery()->execute(); ★削除処理実行
        }
    }
}
```

- 上記の内容はこれ以降の章で習う内容がほとんどです。

- そのため本章では説明を割愛させていただきます。

- ただ参考のために、ソース内に★印で何を行なっているかは記述しました。

- 上記が完了したら、「マイグレーションガイド」の「マイグレーション受け入れ手順」の章を参照しその内容を実行してください。

- 成功すれば以下の様にテーブルが作成されているはずです。


---

![bbsテーブル](images/img-tutorial6-create-table.png)

---

## 本章で学んだこと

1. コンソールから空の「マイグレーションファイル」を作成しました。
1. テーブル構造を検討しました。
1. 「マイグレーションファイル」の「schemaオブジェクト」でデーターベース操作をおこないました。
1. 「schema」オブジェクトで「createTable」「hasTable」「addColumn」「setPrimaryKey」「dropTable」のメソッドを使いテーブルの構築・削除を行いました。
1. dtb_page_layoutに画面情報を登録しない限り作成した画面には、ヘッダー・フッターなどが表示されない事を説明しました。
1. dtb_page_layoutへ登録する情報の説明を行いました。
1. dtb_page_layoutに情報の登録を行いました。
