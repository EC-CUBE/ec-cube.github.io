---
layout: default
title: ディレクトリ・ファイル構成
---

---

# ディレクトリ・ファイル構成

* [コーディング規約](https://github.com/EC-CUBE/ec-cube/wiki/%E3%82%B3%E3%83%BC%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0%E8%A6%8F%E7%B4%84)

## ディレクトリ構成

以下に示すディレクトリ構成となるようにする。

```
[root]
├──app  （主に環境によって変更が入るものを配置）
|  ├── cache/
|  |    └──eccube/
|  ├── config/
|  |    └──eccube/
|  |         └── *.yml
|  ├──  log/
|  ├──  template/ （拡張したテンプレート・デザインテンプレート）
|  |    ├──  admin/
|  |    └──  default/
|  └──  .htaccess
|
├── html/ （Document Rootとなるフォルダ。外部から直接参照する物のみ配置)
|   ├── css/
|   ├── js/
|   ├── upload/
|   ├── .htaccess
|   ├── index.php
|   └── robots.txt
|
├── src/
|   └── Eccube/ （EC-CUBEのCOREとなるソースを配置）
|       └── Controller/
|       |   └── *Controller.php
|       ├── ControllerProvider/
|       |   ├── AdminControllerProvider.php
|       |   └── FrontControllerProvider.php
|       ├── Entity/
|       |   └── *.php
|       ├── Plugin/
|       ├── Form/
|       ├── Repository/
|       |   └── *Repository.php
|       ├── Resource/
|       |   └── doctrine/
|       |       └──*.orm.yml
|       |   └── template
|       |       └──*.twig
|       ├── Service/
|       |   └── *Service.php
|       ├── ServiceProvider/
|       |   └── EccubeServiceProvider.php
|       └── Application.php
|
└── vendor/
    ├── */
    └── autoload.php
```


### 置き換え早見表

| 2系                    | 3系                                      |
|------------------------|------------------------------------------|
| SC_FormParam           | Eccube\Form\Type\                        |
| SC_Query               | Doctrine Orm                              |
| SC\_Helper\_Purchase     | Eccube\Service\PurchaseService           |
| LC\_Page\_Products\_Class | Eccube\Controller\ProductClassController |
| *.tpl                  | Eccube\Resouce\template\\*.twig                       |


### リファクタ時に作成・変更するファイル
{$Hoge}ページを作る場合

| ファイル | コーディング内容 |
|-----|------|
| src\Eccube\ControllerPrivider\(Front or Admin)Controller\{$Hoge}Controller.php | ルーティングを追加・変更する |
| src\Eccube\Controller\{$Hoge}Controller.php  | リクエストを受けて、Viewを出し分けるロジックを書く、 ビジネスロジックをもたない |
| src\Eccube\Form\Type\{$Hoge}Type.php | フォーム項目とバリデーション定義を作成する |
| src\Eccube\Repository\{$Hoge}Repository.php |  EntityRepositoryをextendsしたClassを定義しておく |
| src\Eccube\Entity\{$Hoge}.php | Setter/Getterを記述, DBスキーマと紐づくため、型の定義などをしっかり記述する|
| src\Eccube\Service\{$Hoge}Service.php | ビジネスロジックを書く ビジネスロジックはちゃんとしたOOPとなるように記述する |
| src\Eccube\View\{$Hoge}.twig |  View |
| src\Eccube\ServiceProvider\EccubeServiceProvider.php | 作成したForm\Typeを$app['form.types']に記述する, 利用するRepositoryを$app['eccube.repository.{$hoge}']としてDICにいれる |

## 外部コンポーネント

### 選定基準

* できるだけ、テストが行われているものを利用する。
* ライブラリの採用時には事前に検討を行う。
* EC-CUBEの 3.0.X では基本的に外部ライブラリもAPIの変わらないバージョンを利用する。
* PEARを利用しているもので、SymfonyComponentに置き換えが可能なものは積極的に置き換える。

### 開発時には Composer による依存環境の解消を行う

* Composer を標準で採用し、autoloader も同様に Composer 付属のものを利用する。