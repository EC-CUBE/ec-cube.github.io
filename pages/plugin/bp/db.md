---
title: エンティティ、リポジトリ
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_db
---

プラグインでDBを扱うには本体と同じくエンティティクラスを作ります。

### エンティティファイルの配置場所
エンティティファイルは本体と同じくEntityディレクトリ配下に置きます。

```
[プラグインコード]
  ├── Entity
  │   └── XXXX.php
  ├── Repository
  │   └── XXXXRepository.php
```
※本体ではエンティティクラスは

```
./vendor/bin/doctrine orm:generate:entities --extend="Eccube\\Entity\\AbstractEntity" src
```
というコマンドを実行すれば自動的に作成されますが、プラグインの場合でもオプションを追加することでエンティティクラスを自動で所定のディレクトリに作成してくれます。

```
./vendor/bin/doctrine orm:generate:entities --filter="Plugin\\[プラグインコード]\\Entity\\[エンティティ名]" --extend="Eccube\\Entity\\AbstractEntity" app
```

filterオプションを追加し、最後のパラメータをappと指定することで所定のディレクトリにエンティティクラスを作成してくれます。


### リポジトリクラス

作成したエンティティに対してリポジトリクラスも作成できます。

リポジトリを作成する場合、ServiceProviderにリポジトリ定義が必要になります。

```php
// Repository
$app['sample.repository.[エンティティ名]'] = $app->share(function () use ($app) {
    return $app['orm.em']->getRepository('Plugin\[プラグインコード]\Entity\[エンティティ]');
});
```

本体の既存のリポジトリに対して関数の追加を行いたい場合、プラグインからリポジトリに対して直接追加することはできませんが、リポジトリクラスを継承することで対応することは可能です。


```php
// 既存Repositoryを継承したRepository定義
$app['[プラグインコード].repository.category'] = $app->share(function () use ($app) {
    return new XXXXRepository($app['orm.em'], $app['orm.em']->getMetadataFactory()->getMetadataFor('Eccube\Entity\Category'));
});
```

こうすることでプラグインから新たにエンティティ定義をする必要なく、そのエンティティに対するリポジトリが定義可能です。上記の例だとCategoryクラスに対してリポジトリから操作可能となります。


### 既存テーブルに対する拡張

基本的に既存テーブルに対してプラグインからカラムを追加するような拡張は推奨していません。

既存テーブルに対して、例えば`dtb_customer`テーブルに`ニックネーム`を追加したい時は、プラグイン側で`plg_profile`というようなテーブルを作成して関連付けをします。


- plg_profile

```yml
Plugin\[プラグインコード]\Entity\Profile:
    type: entity
    table: plg_profile
    repositoryClass: Plugin\[プラグインコード]\Repository\ProfileRepository
    id:
        id:
            type: integer
            nullable: false
            id: true
            column: profile_id
            generator:
                strategy: AUTO
            options:
                unsigned: true
    fields:
        nickname:
            type: string
            nullable: true
            length: 100
    oneToOne:
        Customer:
            targetEntity: Eccube\Entity\Customer
            inversedBy: Profile
            joinColumn:
                name: customer_id
                referencedColumnName: customer_id
                nullable: false
                options:
                  unsigned: true
    lifecycleCallbacks: {  }
```

このように関連付けを行います。但し、`plg_profile`テーブルへは各自で実装が必要になrます。

よく行う方法は、completeイベント内でフォームの値を取得して登録する方法です。

```php
/* front.entry.index.complete */
public function onEntryIndexComplete(EventArgs  $event)
{
    $form = $event->getArgument('form');

    $nickname = $form->get('nickname')->getData();

    $Profile = $this->app['xxxx.profile']->find(zzz);

    $Profile->setNickname($nickname);

    $this->app['orm.em']->persist($Profile);
    $this->app['orm.em']->flush($Profile);
}
```
