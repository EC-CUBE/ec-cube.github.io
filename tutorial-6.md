---
layout: default
title: データーベースを作成しよう
---

---

# データーベースを作成しよう


## 本クックブックのテーブル定義

- 目次で示した様に、マイグレーションの基本的な作成方法は、本章では、行いません。

- マイグレーションファイル内に、テーブル定義を記述したもののみを記載いたします。

## マイグレーションファイルの準備

- 「マイグレーションガイド」の「マイグレーション作成手順」で新しいマイグレーションファイルを作成する。

    - 以下を追記します。

- 保存フォルダ
    - /src/Eccube/Resource/doctrine/migration
    
- 上記フォルダに以下ファイルが出来ています。
- 内容を見ると、「up」メソッドと「down」メソッドが記載されています。
    - Version20160607155514.php

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

- テーブル名 : dtb_bbs

| 論理名 | 物理名 | フィールドタイプ | その他 |
|------|------|------|------|
| 投稿ID | id | int | NOT NULL PRIMARY AUTO_INCREMENT |
| 親投稿ID | parent_id | int | DEFAULT NULL |
| 投稿種別 | reason | smallint | NOT NULL |
| 投稿者ハンドルネーム | name | varchar(255) | NOT NULL |
| 投稿のタイトル | title | varchar(255) | NOT NULL |
| 投稿種別 | notes | text | DEFAULT NULL |
| 投稿登録時間 | created | datetime | NOT NULL |
| 投稿編集時間 | updated | datetime | NOT NULL |

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
        if (!$schema->hasTable('dtb_bbs')) {
            $table = $schema->createTable('dtb_bbs');
            $table->addColumn('id', 'integer', array(
                'autoincrement' => true,
            ));
            $table->addColumn('parent_id', 'integer', array('NotNull' => false, 'default' => 'null'));
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
        if (!$schema->hasTable('dtb_bbs')) {
            $schema->dropTable('dtb_bbs');
        }
    }
}
```

- 上記の説明を行います。

- メソッドの引数に「$schema」変数が存在しますが、テーブル操作を行うためのオブジェクトです。

1. はじめに、「hasTable」メソッドを用いて、今回テーブルの有無を確認しています。
1. テーブルが存在しない場合のみ「createTable」メソッドでテーブルを作成します。
1. テーブルを作成した後は、DBの定義にしたがって、「addColumn」メソッドでカラムを追加していきます。
1. 最後に、「setPrimaryKey」でプライマリーキーを指定しています。
1. 次に「down」メソッド時の「dropTable」メソッドでテーブルを削除しています。

- 上記が完了したら、「マイグレーションガイド」の「マイグレーション受け入れ手順」の章を参照ください。

- 成功すれば以下の様にテーブルが作成されているはずです。

---

![bbsテーブル](images/img-tutorial6-create-table.png)

---

## 本章で学んだこと

1. コンソールから空の「マイグレーションファイル」を作成しました。
1. テーブル構造を検討しました。
1. 「マイグレーションファイル」の「schemaオブジェクト」でデーターベース操作をおこないました。
1. 「schema」オブジェクトで「createTable」「hasTable」「addColumn」「setPrimaryKey」「dropTable」のメソッドを使いテーブルを構築しました。
