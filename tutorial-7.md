---
layout: default
title: Doctrineのためにデーターベース構造を設定しよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. ORMの概要とエンティティマネージャーの説明を行います。

    1. エンティティファイルとエンティティマネージャーの説明を行います。

    1. エンティティマネージャーとデーターベース構造定義ファイルの関係性を説明します。

    1. データーベース構造定義ファイル(Eccube.Entity.[エンティティ名].dcm.yml)の作成方法を説明します。


## データーベース構造定義ファイル

- 前章で、本チュートリアルのテーブルを作成しました。

- EC-CUBE 3ではデーターベース操作を**Doctine**という**ObjectRelationalMapping**を用いて透過的にデーターベースレコードを扱います。

- おおまかな概念は以下の通りです。

    - JPA/Hibernate の説明ですが、**Doctrineのエンティティマネージャーの概要**を理解しやすくなるかと思います。

        - <a href="http://builder.japan.zdnet.com/sp_oracle/weblogic/35067018/" target="_blank">初めてのJPA--シンプルで使いやすい、Java EEのデータ永続化機能の基本を学ぶ</a>


        - <a href="https://vladmihalcea.com/2014/07/30/a-beginners-guide-to-jpahibernate-entity-state-transitions/">A beginner’s guide to JPA/Hibernate entity state transitions</a>

- Doctrineでは、**エンティティマネージャー**がプログラム上の、**データモデルオブジェクト(エンティティ)を管理**し、レコードの差分を確認しながら、適切に登録、更新を行います。

- エンティティ構造は、エンティティクラスを実際に作成するため、構造をDoctrineに明示する必要はありませんが、**エンティティとテーブル**の関連は、**定義ファイル**を作成し、明示することではじめて、エンティティと**テーブルを対応(Mapping)**させる事が可能となります。

- この章では、Entityとテーブルの対応(Mapping)を定義するファイルを作成します。

### Eccube.Entity.[エンティティ名].dcm.ymlの作成

#### ファイルの作成

- 以下フォルダに作成します。

    - /src/Eccube/Resource/doctrine

    1. フォルダの中のファイル**Eccube.Entity.AuthorityRole.dcm.yml**をコピー・リネームします。

    2. ファイル名は**Eccube.Entity.Crud.dcm.yml**とします。
        - **Eccube.Entity.Crud.dcm.yml**(中身はEccube.Entity.AuthorityRole.dcm.yml)

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_7/dcm_yml_before.yml"></script>

<!--
```

Eccube\Entity\AuthorityRole:
    type: entity
    table: dtb_authority_role
    repositoryClass: Eccube\Repository\AuthorityRoleRepository
    id:
        id:
            type: integer
            nullable: false
            unsigned: false
            id: true
            column: authority_role_id
            generator:
                strategy: AUTO
    fields:
        deny_url:
            type: text
            nullable: false
        create_date:
            type: datetime
            nullable: false
        update_date:
            type: datetime
            nullable: false
    manyToOne:
        Authority:
            targetEntity: Eccube\Entity\Master\Authority
            joinColumn:
                name: authority_id
                referencedColumnName: id
                nullable: false
        Creator:
            targetEntity: Eccube\Entity\Member
            joinColumn:
                name: creator_id
                referencedColumnName: member_id
                nullable: false
    lifecycleCallbacks: {  }

```
-->

#### ファイルの修正

- 上記を以下の様に修正します。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_7/dcm_yml_after.yml"></script>


<!--
```

Eccube\Entity\Crud: ★エンティティのパスをCrudに変更します( ファイルは後で作成します )
    type: entity
    table: dtb_bbs  ★テーブル名をdtb_crudに修正します
    repositoryClass: Eccube\Repository\CrudRepository ★レポジトリをCrudに修正します( ファイルは後の章で作成します )
    id: ★プライマリーキーの設定を行います
        id:
            type: integer
            nullable: false
            unsigned: false
            id: true
            column: id ★カラム名を修正します
            generator:
                strategy: AUTO ★オートインクリメントを利用するためにAUTOを設定します
    fields: ★カラムの設定を行います
        reason:
            type: smallint
            nullable: false
        name:
            type: string
            lenght: 255
            nullable: false
        title:
            type: string
            lenght: 255
            nullable: false
        notes:
            type: text
            nullable: false
        create_date:
            type: datetime
            nullable: false
        update_date:
            type: datetime
            nullable: false
    lifecycleCallbacks: {  }

```
-->

- 上記の説明を行います

    1. [Eccube\Entity\Crud:]
    - エンティティファイルのパスを指定します。
    - ファイルの格納位置は決まっているため、ファイル名のみ変更となります。

    1. [table:]
    - 該当テーブルのテーブル名を指定します。

    1. [repositoryClass:]
     - 本テーブルに紐付けるレポジトリ名を指定します。
     - ビジネスロジックの記述や、データベース操作を行うためのクラスです。
     - 後の章で作成します。

    1. 「id:」に対してプライマリーキーの設定を行います。
     - 前章で定義したテーブル定義の内容に従います。

    1. 「id:」セクション内、オプション「**column:**」に対してプライマリキーの物理名を指定します。

    1. 「id:」セクション内「**generator:strategy**」には「AUTO」を設定します。
    - 本設定により、MySQL、PostgresSQLなどのオートインクリメントに自動で対応します。
    - 他にも、IDの採番方法は設定可能ですが、通常は「AUTO」で問題ありません。
    - <a href="http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html#identifier-generation-strategies" target="_blank">4.5.1. Identifier Generation Strategies</a>

    1. 「fields:」に対して、通常カラムの設定を行います。
    - 基本は「typeにはテーブルのフイールドタイプ」を、「nullableは**NOT NULL**であればfalse」と設定します。
    - その他にも今回例の「length」など設定できるオプションがあります。
    - <a href="http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html#property-mapping" target="_blank">4.3. Property Mapping</a>

    1. 本チュートリアルは初学者向けの内容のために、アソシエーション(リレーションの設定)は説明いたしません。

    1. 詳細な説明は以下を参考にしてください。
    - 設定ファイルのフィールドタイプは以下を参照ください

    <a href="http://docs.symfony.gr.jp/symfony2/book/doctrine.html#doctrine" target="_blank">http://docs.symfony.gr.jp/symfony2/book/doctrine.html#doctrine</a>


    - 基本的な設定の概要は以下を参照ください

    <a href="http://docs.symfony.gr.jp/symfony2/book/doctrine.html#doctrine-the-model" target="_blank">データベースと Doctrine (“The Model”)</a>

#### 備考

- 定義ファイルの最後に以下の内容が記述されています。

```

lifecycleCallbacks: {  }

```

- ここでは、Doctrineの処理に割り込む関数をコールバックとして指定できますが、通常用いる事はないため、説明は割愛いたします。
- 慣例的に記述し、削除を行わないでください。


## 本章で学んだ事

1. Doctrineの概要を説明しました。
1. Doctrineとエンティティマネージャーについて説明しました。
1. テーブル、データーベース定義ファイル、エンティティ、レポジトリの関係について説明しました。
1. Eccube.Entity.[エンティティ名].dcm.ymlの作成方法を説明しました。
1. Eccube.Entity.[エンティティ名].dcm.ymlの記述方法を説明しました。
