<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160616155605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if ($schema->hasTable('dtb_customer')) { ★会員テーブルの存在確認
            $table = $schema->getTable('dtb_customer'); ★テーブルオブジェクトを取得
            $table->addColumn('department', 'string', array('NotNull' => false, 'length' => '255')); ★カラムを追加
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('dtb_customer')) { ★会員テーブルの確認
            $table = $schema->getTable('dtb_customer'); ★テーブルオブジェクトの取得
            $table->dropColumn('department'); ★カラムの削除
        }
    }
}
