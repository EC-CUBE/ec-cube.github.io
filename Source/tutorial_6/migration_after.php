<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

use Doctrine\ORM\Tools\SchemaTool; ★テーブルを作成するために利用します
use Eccube\Application; ★エンティティマネージャーの取得のために必要です

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
            $entities = array(
                'Eccube\Entity\Crud' ★テーブル作成を行うエンティティを指定します
            );
            $app = Application::getInstance(); ★エンティティマネージャーの取得のためにApplicationを取得します
            $em = $app['orm.em']; ★エンティティマネージャーを取得します
            $classes = array();
            foreach ($entities as $entity) {
                $classes[] = $em->getMetadataFactory()->getMetadataFor($entity); ★エンティティからカラム情報を取得します。
            }
            $tool = new SchemaTool($em); ★テーブル生成のためにスキーマツールをインスタンス化します
            $tool->createSchema($classes); ★テーブルを生成します
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
