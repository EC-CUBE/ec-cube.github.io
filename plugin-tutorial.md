---
layout: default
title: EC-CUBEのプラグインを作る(3.0.9～)
---

---

# {{ page.title }}

version 3.0.9でプラグインの機構が大きく拡張されました。
後方互換性はあるので、3.0.8のプラグインもそのまま動きますが、せっかくなので新しい機構でプラグインを作ってみます。

# はじめに

このドキュメントは、EC-CUBE 3.0.10、カテゴリコンテンツプラグイン 0.0.4 で作成しています。
github上のカテゴリコンテンツプラグインは、後方互換のためのメソッドや設定が含まれていますが、このドキュメントでは割愛して説明しています。

# 参考資料
- [プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf)
- [カテゴリコンテンツプラグイン](https://github.com/EC-CUBE/category-content-plugin)

## version 3.0.9～のプラグイン開発
version 3.0.9以前では以下のような手順でプラグインを作成していたと思います。

1. 必須ファイルの作成
2. パッケージング ( 圧縮 )
3. 本体管理画面からインストール
4. プラグインを有効にして、デバッグしながら、プラグインを仕上げる

version 3.0.9では、開発効率をあげるため、以下の機能が追加されています

1. 未インストールプラグインの一覧表示
2. コンソールコマンドによるプラグインのインストール操作全般

上記の機能により、プラグイン作成は、本体の所定の位置に、プラグイン必要ファイルを設置するだけで、開発を進めていくことができます。

以下がプラグインを設置する箇所です。

### **設置箇所**

EC-CUBE3ルートディレクトリ > app > Plugin

```
EC-CUBE3ルートディレクトリ
├──    app
│       ├── cache
│       ├── config
│       ├── console
│       ├── log
│       ├── Plugin ★設置フォルダ
│       │      ├── CategoryContent  ☆今回作成するプラグインフォルダ
```

そのため、今回は**本体の上記フォルダにプラグインフォルダを作成**し、**その中で作業**を行っていきます。

# 本チュートリアルで作成するプラグイン

カテゴリコンテンツを作ってみます。
仕様は以下のとおり。

```
管理画面：商品管理＞カテゴリ登録画面に、コンテンツを入力できるフォーム項目を追加する
フロント：商品一覧画面で、登録したカテゴリの場合、コンテンツを表示する
```

# プラグイン作成フロー

以下の手順で作成していきます。

### プラグインインストール ( フォルダの設置 )の準備

#### 基本設定
1. **ディレクトリ**を作る
1. **config.yml**をつくる
   - ※表示確認
1. その他のファイルをつくる(事前準備)

#### テーブルとテーブル定義情報の作成

1. **dcm.yml**をつくる
1. **config.yml**を修正する 
1. **エンティティ**をつくる
1. **マイグレーションファイル**を作る
1. **プラグインマネージャ**をつくる
1. **テーブル**を作る ( マイグレーションファイルの実行 )
   - ※データベース確認 

### プラグインの構築

#### イベントの作成

1. **config.yml**を修正する
1. **event.yml**をつくる
1. **イベントクラス**つくる
   - ※動作確認

#### フォームを作成してみる
1. **フォーム**に項目追加する
1. **event.yml**を修正
1. **イベントクラス**を修正( 登録処理追加 )
1. **サービスプロバイダ**をつくる
1. **config.yml**を修正
1. データの登録
   - ※動作確認

#### 商品一覧への表示

1. **event.yml**を修正
1. **イベントクラス**を修正( フロント画面表示処理追加 )
1. **Twigファイル**の作成
   - ※表示確認

## インストールまで

### 必要ファイルと、設定ファイルの作成

さっそくつくっていきましょう。
まず、プラグインのディレクトリと、config.ymlを作ってみましょう。

config.ymlには以下を記述します。

```yaml:config.yml
name: カテゴリコンテンツプラグイン
code: CategoryContent
version: 1.0.0
```

### 表示の確認

作成できたら、EC-CUBE3本体管理画面のオーナーズストア > プラグイン > プラグイン一覧を開きます。
「未登録プラグイン」が表示され、その中に「カテゴリコンテンツ」が表示されているはずです。

### その他のファイルの作成(事前準備)

その他ファイルを作成してしまいます。
今回は、勉強のため必要なファイルをコピーし、中身は空で作成していきます。

```yaml:event.yml
記述なし
```

```php:PluginManager.php
<?php

namespace Plugin\CategoryContent;

use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{

    public function install($config, $app)
    {
    }

    public function uninstall($config, $app)
    {
    }

    public function enable($config, $app)
    {
    }

    public function disable($config, $app)
    {
    }

    public function update($config, $app)
    {
    }
}

```
こちらもコピー、名前空間、クラス名のみ適宜書き換え、メソッドは空としてください。
※今後この作業を**初期化**と呼びます。

```php:ServiceProvider/CategoryContentServiceProvider.php
<?php

namespace Plugin\CategoryContent\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class CategoryContentServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
    }

    public function boot(BaseApplication $app)
    {
    }
}
```
こちらもコピー初期化

```yaml:Resource/doctrine/Plugin.CategoryContent.Entity.CategoryContent.dcm.yml
記述なし
```
こちらもコピー初期化

```php:Repository/CategoryContentRepository.php
<?php

namespace Plugin\CategoryContent\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryContentRepository extends EntityRepository
{
}
```
こちらもコピー初期化

```php:Resource/doctrine/migration/Version20150706204400.php
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20150706204400 extends AbstractMigration
{
    public function up(Schema $schema)
    {
    }

    public function down(Schema $schema)
    {
    }
}
```
こちらもコピー初期化

※マイグレーションのファイル名は、Version[yyyymmddHHiiss].phpとする必要があります。

```php:Entity/CategoryContent.php
<?php

namespace Plugin\CategoryContent\Entity;

class CategoryContent extends \Eccube\Entity\AbstractEntity
{
}
```
こちらもコピー初期化

```php:CategoryContentEvent.php
記述なし
```
こちらもコピー初期化


ここまでで以下のようなファイル構成になっています。事前準備はこれで完了です。

```
プラグインルートフォルダ
├── CategoryContentEvent.php
├── config.yml
├── Entity
│      └── CategoryContent.php
├── event.yml
├── PluginManager.php
├── Repository
│      └── CategoryContentRepository.php
├── Resource
│       └── doctrine
│              ├── migration
│              │       └── Version20160218160500.php
│              └── Plugin.CategoryContent.Entity.CategoryContent.dcm.yml
│
└── ServiceProvider
        └── CategoryContentServiceProvider.php
```

## テーブルとテーブルの定義情報の作成

今回のプラグインの仕様である、コンテンツの保存のためのテーブルを作成していきます。

EC-CUBEでは、Doctrine/OrmというO/Rマッパーを採用しており、エンティティを通じてデータの取得や更新などのテーブル操作を行います。

以下のテーブル定義をもとに、進めていきます。

- テーブル
    - plg_category_content
- カラム
    - category_id int not null primary key
    - content text 

### dcm.ymlの定義

dcm.ymlは、テーブルとエンティティをマッピングするための設定ファイルです。
以下のように記述を行います。

```yaml:Resource/doctrine/Plugin.CategoryContent.Entity.CategoryContent.dcm.yml
Plugin\CategoryContent\Entity\CategoryContent:
    type: entity
    table: plg_category_content
    repositoryClass: Plugin\CategoryContent\Repository\CategoryContentRepository
    id:
        id:
            type: integer
            nullable: false
            options:
                unsigned: false
            id: true
            column: category_id
            generator:
                strategy: NONE
    fields:
        content:
            type: text
            nullable: true
    lifecycleCallbacks: {  }
```

参考：http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/yaml-mapping.html

### config.ymlの修正

作成したdcm.ymlをDoctrineが読み込めるように、パスを記載します。

```yaml:config.yml
name: カテゴリコンテンツプラグイン
code: CategoryContent
version: 1.0.0
orm.path:                    ★orm.pathの設定を追加
    - /Resource/doctrine
```

### エンティティの作成

次に、エンティティを作成します。
テーブルの情報の取得、更新等は、このエンティティを通じて行います。

```php:Entity/CategoryContent.php
<?php

namespace Plugin\CategoryContent\Entity;

class CategoryContent extends \Eccube\Entity\AbstractEntity
{
    private $id;

    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
```
テーブルの項目をプロパティ ( private ) として定義し、それに対するゲッター・セッターを記述します。

### マイグレーションの作成

実際のデータベース上のテーブルの作成には、**マイグレーション**という機能を利用します。そのための、マイグレーションファイルを以下の様に定義しましょう。

```php:doctrine/migration/Version20150706204400.php
<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Eccube\Common\Constant;

class Version20150706204400 extends AbstractMigration
{
    // 対象のエンティティを指定
    protected $entities = array(
        'Plugin\CategoryContent\Entity\CategoryContent',
    );

    public function up(Schema $schema)
    {
        // テーブルの生成
        $app = \Eccube\Application::getInstance();
        $meta = $this->getMetadata($app['orm.em']);
        $tool = new SchemaTool($app['orm.em']);
        $tool->createSchema($meta);
    }

    public function down(Schema $schema)
    {
        $app = \Eccube\Application::getInstance();
        $meta = $this->getMetadata($app['orm.em']);

        $tool = new SchemaTool($app['orm.em']);
        $schemaFromMetadata = $tool->getSchemaFromMetadata($meta);

        // テーブル削除
        foreach ($schemaFromMetadata->getTables() as $table) {
            if ($schema->hasTable($table->getName())) {
                $schema->dropTable($table->getName());
            }
        }

        // シーケンス削除
        foreach ($schemaFromMetadata->getSequences() as $sequence) {
            if ($schema->hasSequence($sequence->getName())) {
                $schema->dropSequence($sequence->getName());
            }
        }
    }

    protected function getMetadata(EntityManager $em)
    {
        $meta = array();
        foreach ($this->entities as $entity) {
            $meta[] = $em->getMetadataFactory()->getMetadataFor($entity);
        }

        return $meta;
    }
}
```

### プラグインマネージャーの作成

マイグレーションファイルが作成出来たら、テーブルを作成するために、プラグインマネージャーを定義しましょう。

```php:PluginManager.php
<?php

namespace Plugin\CategoryContent;

use Eccube\Plugin\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{
    // インストール時に、指定の処理を実行できます。(今回はなし)
    public function install($config, $app)
    {
    }

    // アンインストール時にマイグレーションの「down」メソッドを実行します
    public function uninstall($config, $app)
    {
        $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code'], 0);
    }

    // プラグイン有効時に、マイグレーションの「up」メソッドを実行します
    public function enable($config, $app)
    {
         $this->migrationSchema($app, __DIR__.'/Resource/doctrine/migration', $config['code']);
    }

    // プラグイン無効時に、指定の処理 ( ファイルの削除など ) を実行できます。(今回はなし)
    public function disable($config, $app)
    {
    }

    // プラグインアップデート時に、指定の処理を実行できます。(今回はなし)
    public function update($config, $app)
    {
    }
}
```

### テーブルの作成

コンソールを起動し、プラグインのインストールと有効化をコマンドで行います。その際、プラグインマネージャー経由でテーブルが作成されます。

```shell-session
$ cd EC-CUBE3ルートディレクトリ
$ php app/console plugin:develop install --code CategoryContent
$ php app/console plugin:develop enable --code CategoryContent
```

### テーブルの確認

データーベースにアクセスして、**「plg_category_content」**テーブルが作成されているのを確認してください。

## プラグインの構築

### イベントの作成

管理画面の、商品管理 > カテゴリ登録に、コンテンツを入力できるよう、フォーム項目を追加します。ここから、3.0.9で新しく定義されたフックポイントをつかっていきます。
フックポイントを使うには、以下のように定義していきます。
    
- config.ymlでイベントクラスのクラス名を指定する
- event.ymlで、利用するフックポイントと、イベントクラスのメソッド名を指定する
- イベントクラスを作る

### config.ymlの修正

config.ymlにイベントクラス名を指定します。

```yaml:config.yml
name: カテゴリコンテンツプラグイン
code: CategoryContent
version: 1.0.0
orm.path:
    - /Resource/doctrine
event: CategoryContentEvent ★イベントクラスを指定
```

### event.ymlを作成

管理画面のカテゴリ登録のコントローラには、以下のフックポイントが定義されています。

- admin.product.category.index.initialize
- admin.product.category.index.complete

今回はフォームに項目を追加するので、initializeの方を使います。
event.ymlを以下のように記述します。

```yaml:event.yml
admin.product.category.index.initialize: ★カテゴリコントローラのフックポイト
    - [onAdminProductCategoryIndexInit, NORMAL]  ★メソッド名
```

注.) この際、メソッド名を記述している行ですが、スペースを4つの後に「-(ハイフン)」その後に、またスペースを1つ付与しないと、設定が読み込まれないため正しく記述してください

※フックポイントの一覧は、[プラグイン仕様書](http://downloads.ec-cube.net/src/manual/v3/plugin.pdf)を参考にしてください。

### イベントクラスを作成

ここまでで、

- カテゴリコントローラのフックポイントが呼び出された時に
- CategoryContentEventクラス の
- onAdminProductCategoryIndexInitメソッド

が実行される、という定義ができました。
ではCategoryContentEventを作っていきます。

```php:CategoryContentEvent.php

<?php

namespace Plugin\CategoryContent;

use Eccube\Event\EventArgs;

class CategoryContentEvent
{
    /** @var \Eccube\Application $app */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function onAdminProductCategoryIndexInit(EventArgs $event)
    {
        dump(111);
    }
}
```

とりあえず空のメソッドを作って、動くかどうか確認をしてみます。

EC-CUBE3本体、管理画面の、商品管理 > カテゴリ登録に、コンテンツをクリックします。
画面上部に`111`と表示されていればイベントが稼働しています。

![dump.png](https://qiita-image-store.s3.amazonaws.com/0/72858/f539560c-f26d-d149-aa6a-0cdcb6f0eca7.png)

## フォームを作成してみる

### 拡張項目の定義

動作確認がとれたら、管理画面カテゴリ登録フォームに追加する項目を定義してみましょう。

```php:CategoryContentEvent.php
<?php

namespace Plugin\CategoryContent;

use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Entity\Category;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\CategoryContent\Entity\CategoryContent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CategoryContentEvent
{
    /**
     * プラグインが追加するフォーム名
     */
    const CATEGORY_CONTENT_TEXTAREA_NAME = 'plg_category_content';
    
    /** @var \Eccube\Application $app */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function onAdminProductCategoryIndexInit(EventArgs $event)
    {
        /** @var Category $target_category */
        $TargetCategory = $event->getArgument('TargetCategory');
        $id = $TargetCategory->getId();

        $CategoryContent = null;

        // IDの有無で登録か編集かを判断
        if ($id) {
            // カテゴリ編集時は初期値を取得
            $CategoryContent = $this->app['category_content.repository.category_content']->find($id);
        }

         // カテゴリ新規登録またはコンテンツが未登録の場合
        if (is_null($CategoryContent)) {
            $CategoryContent = new CategoryContent();
        }

        // フォームの追加
        /** @var FormInterface $builder */
        // FormBuildeの取得
        $builder = $event->getArgument('builder');
        // 項目の追加
        $builder->add(
            self::CATEGORY_CONTENT_TEXTAREA_NAME,
            'textarea',
            array(
                'required' => false,
                'label' => false,
                'mapped' => false,
                'attr' => array(
                    'placeholder' => 'コンテンツを入力してください(HTMLタグ使用可)',
                ),
            )
        );

        // 初期値を設定
        $builder->get(self::CATEGORY_CONTENT_TEXTAREA_NAME)->setData($CategoryContent->getContent());

    } 
}
```

作成できたら、EC-CUBE3本体管理画面の商品管理 > カテゴリ登録 を開きます。
画面を開くと追加した、テキストエリアが表示されているはずです。

注.) 項目に必ず、**'mapped' => false** を付与してください。
付与を忘れると、もとのフォームのエンティティに対して、項目を探索するために、
エラーが発生します。

![content.png](https://qiita-image-store.s3.amazonaws.com/0/72858/585c50fc-5f67-14bb-4add-5f47b7239e27.png)

### event.ymlを修正
次にフォーム登録のために、残り1つのフックポイントである`admin.product.category.index.complete`を使用して、登録処理を行います。
まずは、前例にならって、フックポイントに対する、メソッドを定義します。

```yaml:event.yml
admin.product.category.index.initialize: ★カテゴリコントローラのフックポイト
    - [onAdminProductCategoryIndexInit, NORMAL]  ★メソッド名
admin.product.category.index.complete:   ☆フォーム登録のために利用するフックポイント
    - [onAdminProductCategoryIndexComplete, NORMAL]   ☆フォーム登録処理メソッド
```

### イベントクラスを修正

次にイベントクラスに、登録メソッドを定義します。

CategoryContentEvent.phpに対して以下を追加します。

```php:CategoryContentEvent.php
    /**
     * 管理画面：カテゴリ登録画面で、登録処理を行う.
     *
     * @param EventArgs $event
     */
    public function onAdminProductCategoryIndexComplete(EventArgs $event)
    {
        /** @var Application $app */
        $app = $this->app;
        /** @var Category $target_category */
        $TargetCategory = $event->getArgument('TargetCategory');
        /** @var FormInterface $form */
        $form = $event->getArgument('form');

        // 現在のエンティティを取得
        $id = $TargetCategory->getId();
        // フォーム値のIDをもとに登録カテゴリ情報を取得
        $CategoryContent = $app['category_content.repository.category_content']->find($id);
        if (is_null($CategoryContent)) {
            $CategoryContent = new CategoryContent();
        }

        // エンティティを更新
        $CategoryContent
            ->setId($id)
            ->setContent($form[self::CATEGORY_CONTENT_TEXTAREA_NAME]->getData());

        // DB更新
        $app['orm.em']->persist($CategoryContent);
        $app['orm.em']->flush($CategoryContent);
    }
```

### サービスプロバイダをつくる

イベントクラスで追加した登録処理内で、レポジトリを使用している箇所があります。
レポジトリを利用するためには、サービスプロバイダ内で、レポジトリ定義を行う必要があります。
さっそくサービスプロバイダーに定義を追加しましょう。

```php:ServiceProvider/CategoryContentServiceProvider.php
<?php

namespace Plugin\CategoryContent\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class CategoryContentServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // Repository
        $app['category_content.repository.category_content'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\CategoryContent\Entity\CategoryContent');
        });

    }

    public function boot(BaseApplication $app)
    {
    }
}
```

### config.ymlの修正
サービスプロバイダーにレポジトリの定義が終わったら、config.ymlにサービスプロバイダーのファイル名を定義します。

以下をconfig.ymlに追加してください。

```yaml:config.yml
name: カテゴリコンテンツプラグイン
code: CategoryContent
version: 1.0.0
orm.path:
    - /Resource/doctrine
event: CategoryContentEvent
service:                                ★ServiceProviderの定義を追加
    - CategoryContentServiceProvider
```

### 登録確認

作成できたら、管理画面の商品管理 > カテゴリ登録 を開きます。

新規で**「カテゴリ名」**を入力し、テキストエリアに任意の文字を入力して、**「カテゴリ作成」**を行ってください。

**「カテゴリを保存しました」**のメッセージが画面に表示されれば成功です。

以上で管理画面の実装は完了です。

## 商品一覧への表示

登録したカテゴリのコンテンツ情報を、フロント画面で表示できる様に、処理を追加しましょう。
ここでは、Twigに対するフックポイントを利用します。
ここで記述するTwigを作成し、表示内容を記述します。

### event.ymlの修正

以下を追記します。

```yaml:event.yml
Product/list.twig:
    - [onRenderProductList, NORMAL]
```

注.) フックポイント名は、Twigファイル名を指定します。該当コントローラーの**「render」メソッド**の引数で定義されているので、確認してみてください。
ただし、管理画面には**「Admin/」**を先頭に付与してください。

### イベントクラスを修正(フロント画面表示処理追加)

次にイベントクラスに表示処理を実装します。

CategoryContentEvent.phpに以下を追記します。

```php:CategoryContentEvent.php
    /**
     * 商品一覧画面にカテゴリコンテンツを表示する.
     *
     * @param TemplateEvent $event
     */
    public function onRenderProductList(TemplateEvent $event)
    {
        $parameters = $event->getParameters();

        // カテゴリIDがない場合、レンダリングしない
        if (is_null($parameters['Category'])) {
            return;
        }

        // 登録がない、もしくは空で登録されている場合、レンダリングをしない
        $Category = $parameters['Category'];
        $CategoryContent = $this->app['category_content.repository.category_content']
            ->find($Category->getId());
        if (is_null($CategoryContent) || $CategoryContent->getContent() == '') {
            return;
        }

        // twigコードにカテゴリコンテンツを挿入
        $snipet = '<div class="row">{{ CategoryContent.content | raw }}</div>';
        $search = '<div id="result_info_box"';
        $replace = $snipet.$search;
        $source = str_replace($search, $replace, $event->getSource());
        $event->setSource($source);

        // twigパラメータにカテゴリコンテンツを追加
        $parameters['CategoryContent'] = $CategoryContent;
        $event->setParameters($parameters);
    }
```

### 表示確認

これで全ての実装が完了しました。
管理画面 > 商品管理 > 商品マスタ から任意の商品を検索し、カテゴリで、作成したカテゴリにチェックをつけてください。
フロント画面のトップで該当カテゴリをクリックし、商品の上に、コンテンツが表示されていれば、成功です。
