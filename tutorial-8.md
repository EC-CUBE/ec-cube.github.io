---
layout: default
title: Doctrineのためにエンティティファイルを作成しよう
---

---

# {{ page.title }}

## 本章メニュー

- 本章では以下を行います。

    1. エンティティの説明を行います。

    1. エンティティとエンティティマネージャーについて説明しています。

    1. エンティティファイルの作成方法を説明しています。

    1. エンティティファイルをコマンドラインから自動作成出来る事を説明しています。

## エンティティ

- 前章では、データーベースとエンティティをマッピングするためのファイル**Eccube.Entity.[エンティティ名].dcm.yml**を作成しました。

- 本章では、エンティティファイルを作成していきます。

### エンティティの概要

- **エンティティファイル**は、データーベースのカラムを、クラスのメンバ変数として**private**スコープで作成し、それに対して、**「Setter・Getter」**を作成しただけのシンプルなファイルです。
- アソシエーション(リレーションオブジェクト)があれば、その設定も記述します。

- 前章での説明の通り、**エンティティマネージャー**が**エンティティを管理**し、エンティティ上に、プログラム中で発生した値を保持します。

- 開発者は、**簡単な条件の情報取得**であれば、**マジックメソッドで情報取得**、情報の保存であれば、**対象エンティティに値をセット**し、**保存のメソッドを呼び出すだけ**で実現できます。

- **エンティティ**はプログラム中で**persist**されて初めて、**エンティティマネージャーの管理下**におかれます。

- プログラム中で新しく**エンティティをインスタンス化**した際は、必ず**persist**を行い、**エンティティマネージャーの管理下**におきます。

#### ファイルの作成

- 以下フォルダに作成します。

    - /src/Eccube/Entity

    1. フォルダの中のファイル**AuthorityRole.php**をコピー・リネームします。


    1. ファイル名は**Crud.php**とします。
        - **Crud.php**(中身はAuthorityRole.php)

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_8/crud_entity_before.php"></script>

<!--
```
<?php

namespace Eccube\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorityRole
 */
class AuthorityRole extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $deny_url;

    /**
     * @var \DateTime
     */
    private $create_date;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * @var \Eccube\Entity\Master\Authority
     */
    private $Authority;

    /**
     * @var \Eccube\Entity\Member
     */
    private $Creator;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set deny_url
     *
     * @param string $denyUrl
     * @return AuthorityRole
     */
    public function setDenyUrl($denyUrl)
    {
        $this->deny_url = $denyUrl;

        return $this;
    }

    /**
     * Get deny_url
     *
     * @return string
     */
    public function getDenyUrl()
    {
        return $this->deny_url;
    }

    /**
     * Set create_date
     *
     * @param \DateTime $createDate
     * @return AuthorityRole
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param \DateTime $updateDate
     * @return AuthorityRole
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * Set Authority
     *
     * @param \Eccube\Entity\Master\Authority $authority
     * @return AuthorityRole
     */
    public function setAuthority(\Eccube\Entity\Master\Authority $authority = null)
    {
        $this->Authority = $authority;

        return $this;
    }

    /**
     * Get Authority
     *
     * @return \Eccube\Entity\Master\Authority
     */
    public function getAuthority()
    {
        return $this->Authority;
    }

    /**
     * Set Creator
     *
     * @param \Eccube\Entity\Member $creator
     * @return AuthorityRole
     */
    public function setCreator(\Eccube\Entity\Member $creator)
    {
        $this->Creator = $creator;

        return $this;
    }

    /**
     * Get Creator
     *
     * @return \Eccube\Entity\Member
     */
    public function getCreator()
    {
        return $this->Creator;
    }
}

```
-->

#### ファイルの修正

- エンティティファイルの場合流用出来る箇所がほとんどありません。
- 「create_date/update_date」に関する内容以外の記述をほとんど書き換えます。
- 以下が書き換えた内容です。

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_8/crud_entity_after.php"></script>

<!--
```
<?php

namespace Eccube\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Crud
 * @package Eccube\Entity
 */
class Crud extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \DateTime
     */
    private $create_date;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set reason
     *
     * @param $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set notes
     *
     * @param $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Set create_date
     *
     * @param \DateTime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param \DateTime $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
```
-->


### エンティティファイルをコマンドラインで作成

- **エンティティ**は**Eccube.Entity.[エンティティ名].dcm.yml**があれば、コマンドラインから自動生成ができます。

- 本章ではコマンドラインを使って**CrudEntity**を作成する方法も補足しておきます。

- 手動で作成するとヒューマンエラーが起こりうるために、出来るかぎり**コンソール**での**自動作成**をおすすめします。

- コマンドラインで**EC-CUBE 3のインストールディレクトリに移動**後、以下**コマンドを実行**してください。

※**PHPの実行パス**は、**環境変数に設定済み**とします。

```

vendor/bin/doctrine orm:generate:entities --extends="Eccube\\Entity\\AbstractEntity" src

```

- 参考ですが、テーブル作成も**Eccube.Entity.[エンティティ名].dcm.yml**があれば同様にコマンドラインから実行できます。

- 詳細は以下を参考にしてください。

<a href="http://sssslide.com/speakerdeck.com/amidaike/ec-cube3kodorideingu-number-3" target="_blank">EC-CUBE 3コードリーディング #3</a>

## 本章で学んだ事

1. Entityファイルの内部構造の概要を説明しました。
1. Entityファイルとエンティティマネージャーの関係を説明しました。
1. Entityファイルのコマンドラインを用いた作成方法を説明しました。
1. コマンドラインを用いたテーブルの作成方法を説明しました。
