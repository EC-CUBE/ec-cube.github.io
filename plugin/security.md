---
layout: default
title: セキュリティ
---

```
対象バージョン : 3.0.12以降
更新日 : 2016/11/27
```

# {{ page.title }}

イベントを使って拡張を行った場合、画面によりセキュリティ制限を行う必要があります。
EC-CUBE3では管理画面及びマイページに関してはログインが必須となっており、利用するイベントによってログイン状態を判断する必要があります。


### セキュリティ対応が必要なイベント

- eccube.event.route.[route].request
- eccube.event.route.[route].response

テンプレートイベント、



プラグイン用のテーブル作成・削除を行う場合、マイグレーションという仕組みを使います。マイグレーションには極力テーブル追加、削除処理に止めておきます。  
但し、プラグインがバージョンアップされた時にしか実行されない処理があれば、マイグレーションで行う方が簡単です。

- マイグレーションではテーブル作成、削除を行う
- プラグインバージョンアップ時にPluginManagerのupdate関数で対処できないケースのみマイグレーションファイル内に記述  
→複数回バージョンアップが発生した時にupdate関数では対処し辛い等

### マイグレーションファイルの配置場所
マイグレーションファイルは本体と同じくResourceディレクトリ配下に置きます。

```
[プラグインコード]
  ├── Resource
  │   ├── doctrine
  │   │   └── Plugin.XXXX.Entity.XXXX.dcm.yml
  │   │   └── migration
  │   │       └── VersionYYYYMMDDHHMMSS.php
```
※本体ではマイグレーションファイルは  
```
php app/console migrations:generate
```
というコマンドを実行すれば自動的に作成されますが、プラグインの所定のディレクトリに対して作成する機能は提供されていません。  
上記コマンドを実行し、本体側に出来たマイグレーションファイルをプラグインの所定のディレクトリまでコピーするか、既存ファイルをコピーをしてクラス名等を置き換えて作成してください。


### マイグレーションでのテーブル作成・削除

プラグイン用テーブルの作成・削除の処理内容は(プラグイン仕様書)[http://downloads.ec-cube.net/src/manual/v3/plugin.pdf]の「3.プラグインを作る」の「マイグレーション」を参照してください。


### 項目の追加・削除

テーブルの追加・削除以外に項目追加、削除や制約変更も可能です。

```php
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class VersionYYYYMMDDHHMMSS extends AbstractMigration
{

    const NAME = 'テーブル名';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable(self::NAME)) {
            return true;
        }
        $table = $schema->getTable(self::NAME);
        $table->addColumn('nickname', 'string', array('notnull' => true, 'length' => 50));
        $table->changeColumn('email', 'string', array('notnull' => false, 'length' => 250));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable(self::NAME)) {
            return true;
        }
        $table = $schema->getTable(self::NAME);
        $table->dropColumn('nickname');
    }
}
```

