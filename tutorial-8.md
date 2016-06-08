---
layout: default
title: Doctrineのためにエンティティファイルを作成しよう
---

---

# Doctrineのためにエンティティファイルを作成しよう

## エンティティ

- 前章では、データーベースとエンティティをマッピングするためのファイル**Eccube.Entity.[エンティティ名].dcm.yml**を作成しました。

- 本章では、Entityファイルを作成していきます。

### エンティティの概要

- エンティティファイルは、アソシエーション(リレーションオブジェクト)がない限りは、データーベースのカラムを、クラスのメンバ変数として**private**スコープで作成し、それに対して、**「Setter・Getter」**を作成しただけのシンプルなファイルです。

- 前章での説明の通り、EntityManagerがエンティティを管理し、エンティティ上に、プログラム中に発生した値を保持します。それが、データーベースから与えられた値か、画面から与えられた値かは、EntityManagerが管理してくれます。

- 開発者は、簡易な情報の扱いであれば、該当メソッドで情報取得、情報の保存であれば、対象エンティティに値をセットし、保存のメソッドを呼び出すだけで行えます。

- Entityはプログラム中で**persist**されて初めて、**EntityManagerの管理下**におかれます。

- プログラム中で新しくEntityをインスタンス化した際は、必ず**persist**を行い、EntityManagerの管理下におきます。

#### ファイルの作成

- 以下フォルダに作成します。

    - /src/Eccube/Entity

1. フォルダの中のファイル「AuthorityRole.php」をコピー・リネームします。


2. ファイル名は「Bbs.php」とします。
    - Bbs.php(中身はAuthorityRole.php)

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

#### ファイルの修正

- Entityファイルの場合流用出来る箇所がほとんどありません。
- 「create_date/update_date」以外の記述をほとんど書き換えます。
- 以下が書き換えた内容です。
- ※ほとんど書き換えのため「★」は省略いたします。

```
<?php

namespace Eccube\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Bbs
 * @package Eccube\Entity
 */
class Bbs extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $parent_id;

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
     * Get parent_id
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set parent_id
     *
     * @param $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * Get parent_id
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
}
```


### エンティティファイルをコマンドラインで作成

- Entityは**Eccube.Entity.[エンティティ名].dcm.yml**があれば、コマンドラインから自動生成ができます。

- 本章ではコマンドラインを使って**BbsEntity**を作成する方法も補足しておきます。

- 手動で作成するとヒューマンエラーが起こりうるために、出来るかぎり**コンソール**での**自動作成**をおすすめします。

- コマンドラインでEC-CUBE3のインストールディレクトリに移動後、以下コマンドを実行してください。

※PHPの実行パスは、環境変数に設定済みとします。

```

vendor/bin/doctrine orm:generate:entities --extends="Eccube\\Entity\\AbstractEntity" src

```

- 参考ですが、テーブル作成も**Eccube.Entity.[エンティティ名].dcm.yml**があれば同様にコマンドラインから実行できます。

- 詳細は以下を参考にしてください。

<a href="http://sssslide.com/speakerdeck.com/amidaike/ec-cube3kodorideingu-number-3" target="_blank">EC-CUBE3コードリーディング #3</a>

## 本章で学んだ事

1. Entityファイルの内部構造の概要
1. EntityファイルとEntityManagerの関係
1. Entityファイルのコマンドラインを用いた作成
1. コマンドラインを用いたテーブルの作成
