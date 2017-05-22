---
title: プラグインによるテーブルの追加
keywords: plugin form spec
tags: [plugin, tutorial]
sidebar: home_sidebar
permalink: plugin_tutorial-table
summary: プラグインでテーブルを新たに作成する際の手順について、解説します。
---

## 前提

プラグインジェネレータで、プラグインコードを「Customize」で作成したものとして、解説していきます。
プラグインジェネレータの利用方法については、[こちら](plugin_tutorial-generate)を参照してください。

今回は、以下のテーブルを作成します。

```sql
CREATE TABLE plg_customize_sample(
    id SMALLINT NOT NULL,
    name TEXT DEFAULT NULL,
    rank SMALLINT NOT NULL,
    PRIMARY KEY(id)
);
```

## config.ymlの修正

app/Plugin/Customize/config.ymlにdoctrineの定義ファイルのパスを設定します。
`orm.path`の定義を追加して下さい。

```yaml
name: カスタマイズ
code: Customize
version: 1.0.0
event: CustomizeEvent
service:
    - CustomizeServiceProvider
orm.path:
  - /Resource/doctrine
```

## dcm.ymlの作成

`app/Plugin/Resource/doctrine`以下に、定義ファイルを作成します。※ディレクトリがない場合は作成して下さい。
ファイル名は、`Plugin.Customize.Entity.Sample.dcm.yml`としてください。

```yaml
Plugin\Customize\Entity\Sample:
    type: entity
    table: plg_customize_sample
    repositoryClass: Plugin\Customize\Repository\SampleRepository
    id:
        id:
            type: smallint
            nullable: false
            unsigned: false
            id: true
    fields:
        name:
            type: text
            nullable: true
        rank:
            type: smallint
            nullable: false
            unsigned: false
    lifecycleCallbacks: {  }
```

doctrineのマッピング定義について詳しくは[こちら](http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/reference/yaml-mapping.html){:target="_blank"}をを参照してください。

## テーブルの作成

dcm.ymlの定義から、データベースのテーブルを生成します。
以下のコマンドを実行します。

```sh
$ ./vendor/bin/doctrine orm:schema-tool:update --dump-sql
```

以下のように、実行されるSQLを確認できます。

```
CREATE TABLE plg_customize_sample (id SMALLINT NOT NULL, name TEXT DEFAULT NULL,rank SMALLINT NOT NULL, PRIMARY KEY(id));
```

`--force`オプションで、SQL文を実行します。

```sh
$ ./vendor/bin/doctrine orm:schema-tool:update --force
```

以下のように表示されれば成功です。

```
Updating database schema...
Database schema updated successfully! "1" queries were executed
```

## Entityクラスの作成

Entityクラスを生成します。以下のコマンドを実行してください。

```sh
$ ./vendor/bin/doctrine orm:generate:entities --filter=Plugin\\Customize\\Entity\\Sample --extend=Eccube\\Entity\\AbstractEntity app/
```

以下のように表示されれば成功です。

```
Processing entity "Plugin\Customize\Entity\Sample"

Entity classes generated to "[EC-CUBEのインストールディレクトリ]/app"
```

`app/Plugin/Customize/Entity/Sample.php`ファイルが生成されています。

## Repositoryクラスの作成

Repositoryクラスを生成します。以下のコマンドを実行してください。

```sh
$ ./vendor/bin/doctrine orm:generate:repositories --filter=Plugin\\Customize\\Entity\\Sample app/
```

以下のように表示されれば成功です。

```
Processing entity "Plugin\Customize\Entity\Sample"

Entity classes generated to "[EC-CUBEのインストールディレクトリ]/app"
```

`app/Plugin/Customize/Repository/SampleRepository.php`ファイルが生成されています。

## ServiceProviderにRepositoryの定義を行う

`app/Plugin/Customize/ServiceProvider/CustomizeServiceProvider`に、Repositoryを定義します。
registerメソッド内に、以下のように記載をしてください。

```php
class CustomizeServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // Repository
        $app['plugin.customize.repository.sample'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\Customize\Entity\Sample');
        });

```

Contorollerからは、以下のように呼び出すことができます。

```php
$Samples = $app['plugin.customize.repository.sample']->findAll();
```
