---
layout: default
title: Doctrineのためにデーターベース構造を設定しよう
---

---

# Doctrineのためにデーターベース構造を設定しよう


## データーベース構造定義ファイル

- 前章で、本クックブックのテーブルを作成しました。

- EC-CUBE3ではデーターベース操作を「Doctine」という「 ObjectRelationalMapping」を用いて透過的にデーターベースレコードを扱います。

- おおまかな概念は以下の通りです。

    - JPA/Hibernate の説明ですが、Doctrineのエンティティマネージャーの概要を理解しやすくなるかと思います。

        - <a href="http://builder.japan.zdnet.com/sp_oracle/weblogic/35067018/" target="_blank">初めてのJPA--シンプルで使いやすい、Java EEのデータ永続化機能の基本を学ぶ</a>


        - <a href="https://vladmihalcea.com/2014/07/30/a-beginners-guide-to-jpahibernate-entity-state-transitions/">A beginner’s guide to JPA/Hibernate entity state transitions</a>

- Doctrineでは、EntityManagerがプログラム上の、テーブルオブジェクト(Entity)を管理し、データーベースとの差分を確認しながら、適切に登録、更新を行います。

- Entityの構造は、Entityクラスを実際に作成するため、構造をDoctrineに明示する必要はありませんが、Entityとテーブルの関連は、定義ファイルを作成し、明示することではじめて、Entityとテーブルを対応(Mapping)させる事が可能となります。

- この章では、Entityとテーブルを対応(Mapping)を定義するファイルを作成します。


