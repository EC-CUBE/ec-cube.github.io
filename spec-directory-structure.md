---
layout: default
title: ディレクトリ・ファイル構成
---

---

# ディレクトリ・ファイル構成

## ディレクトリ構成

### 特徴

1. EC-CUBE3ではSilexフレームワークを採用しているため、**2系から大幅にディレクトリ構造が変化**

1. **Symfony2のディレクトリ構造を参考**に、EC-CUBE3**独自構成**

1. **公開ディレクトリについては２系をほぼ踏襲**


### 主なディレクトリと役割

- 以下に主なフォルダとディレクトリ構成を示します

<!--
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
-->

#### app配下

- **設定ファイル**や**ログ・ファイル等**が配置、**プラグインは「Plugin」ディレクトリ**配下で作成

```
[EC-CUBE3インストールディレクトリ]
├── ■ app（主に環境によって変更が入るものを配置）
│   ├── cache
│   │   └── eccube
│   ├── config
│   │   └── eccube ■設定ファイル
│   │       ├── config.yml
│   │       ├── database.yml
│   │       ├── mail.yml
│   │       └── path.yml
│   ├── console
│   ├── log　■ログファイル
│   ├── Plugin
│   └── template　■拡張したテンプレート・デザインテンプレート
│       ├── admin
│       └── default
├── cache
│   └── plugin
│
・・続く
```

#### html配下

- **公開ディレクトリ**となり、**リソースファイル**(cssや画像ファイルを配置）

```
・・続き
│
├── ■html（Document Rootとなるフォルダ。外部から直接参照する物のみ配置) 
│   ├── index.php
│   ├── index_dev.php
│   ├── install.php
│   ├── plugin
│   ├── robots.txt
│   ├── template
│   │   ├── admin ■管理画面用リソースファイル
│   │   │   └── assets
│   │   │       ├── css
│   │   │       │   └── *.css
│   │   │       ├── fonts
│   │   │       │   └── WEBフォント
│   │   │       ├── img 
│   │   │       │   └── svg/ico/画像
│   │   │       └── js
│   │   │           ├── *.js（EC-CUBE独自）
│   │   │           └── vendor（ライブラリ）
│   │   │               └── *.js
│   │   ├── default ■フロント画面用リソースファイル
│   │   │   ├── css
│   │   │   │   └── *.css
│   │   │   ├── img
│   │   │   │   ├── common
│   │   │   │   │   └── svg/ico
│   │   │   │   └── top
│   │   │   │       └── 画像
│   │   │   └── js
│   │   │       ├──  *.js（EC-CUBE独自）
│   │   │       └── vendor（ライブラリ）
│   │   │           └── *.js
│   │   └── install ■インストール画面用リソースファイル
│   │       ├── assets
│   │       │   ├── css
│   │       │   │   └── *.css
│   │       │   ├── img 
│   │       │   │   └── svg/画像
│   │       │   └── js
│   │       │       └── *.js（EC-CUBE独自）
│   │       ├── css
│   │       │   └── admin_contents.css (管理画面用共通CSS)
│   │       ├── dist（ライブラリ/BootStrapなど）
│   │       │   ├── css
│   │       │   │   └── *.css
│   │       │   ├── fonts
│   │       │   │   └── WEBフォント
│   │       │   └── js
│   │       │       └── *.js
│   │       └── img
│   │           └── common
│   │               └── favicon.ico
│   ├── upload ■アップロードファイル保存
│   │   ├── save_image
│   │   │   └── 画像
│   │   └── temp_image ■アップロードファイル一時保存
│   ├── user_data
│   └── web.config
│
・・続く
```

#### src配下

- **アプリケーション本体**となり、phpファイルやTwigファイルを配置

```
・・続き
│
├── README.md
├── src
│   └── Eccube ■EC-CUBEのCOREとなるソースを配置
│       ├── Application ■Application.phpの親クラスファイルが格納
│       │   └── ApplicationTrait.php
│       ├── Application.php ★ベースとなるクラス、必ずこのクラスから実行される
│       ├── Command ■Consoleコマンド用クラス群
│       │   └── *.php
│       ├── Common ■定数定義クラス
│       │   └── Constant.php
│       ├── Controller ■コントローラークラス群
│       │   ├── Admin
│       │   │   ├── AdminController.php
│       │   │   └── /*/
│       │   │       └── *.php
│       │   ├── /*/
│       │   │   └── *.php
│       │   ├── *.php
│       │   └── AbstractController.php
│       ├── ControllerProvider ■URLマッピング定義ファイル群
│       │   └── *.php
│       ├── Doctrine ■Doctrine拡張クラス群(特化機能)
│       │   └── /*/
│       │       └── *.php
│       ├── Entity ■DB連携用Entityクラス群
│       │   ├── Master
│       │   │   └── *.php
│       │   ├── *.php
│       │   └── *.php
│       ├── Event ■Formイベント定義用クラス群
│       │   └── *.php
│       ├── EventListener ■イベントリスナー用クラス群
│       │   └── *.php
│       ├── Exception ■業務エラークラス群
│       │   └── *.php
│       ├── Form ■Formタイプ(フォーム定義)クラス群
│       │   ├── DataTransformer
│       │   │   └── *.php
│       │   ├── Extension
│       │   │   └── *.php
│       │   └── Type
│       │       ├── /*/
│       │       │   └── *.php
│       │       ├── *.php
│       │       └── *.php
│       ├── InstallApplication.php
│       ├── Plugin ■プラグイン用Managerrクラス群
│       │   └── AbstractPluginManager.php
│       ├── Repository ■DBアクセス用レポジトリクラス群
│       │   ├── /*/
│       │   │   └── *.php
│       │   ├── *.php
│       │   └── *.php
│       ├── Resource ■doctrine用dcmファイルやtwigファイル等
│       │   ├── config
│       │   │   ├── config.yml.dist
│       │   │   ├── constant.yml.dist
│       │   │   ├── database.yml.dist
│       │   │   ├── database.yml.sqlite3.dist
│       │   │   ├── database.yml.sqlite3-in-memory.dist
│       │   │   ├── log.yml.dist
│       │   │   ├── mail.yml.dist
│       │   │   ├── nav.yml.dist
│       │   │   └── path.yml.dist
│       │   ├── doctrine ■doctrine用テーブルマッピング定義クラス群
│       │   │   ├── *.dcm.yml
│       │   │   ├── /*/
│       │   │   │   └── *.dcm.yml
│       │   │   └── migration ■マイグレーションファイル群
│       │   │       └── VersionYYYYMMDDSSMM.php
│       │   ├── locale ■表示メッセージ定義ファイル群
│       │   │   ├── message.ja.yml
│       │   │   └── validator.ja.yml
│       │   └── template ■Twigファイル群
│       │       ├── admin
│       │       │   ├── default_frame.twig
│       │       │   ├── index.twig
│       │       │   ├── login.twig
│       │       │   ├── login_frame.twig
│       │       │   ├── pager.twig
│       │       │   ├── nav.twig
│       │       │   ├── error.twig
│       │       │   └── /*/
│       │       │       └── *.twig
│       │       ├── default
│       │       │   ├── index.twig
│       │       │   ├── block.twig
│       │       │   ├── default_frame.twig
│       │       │   ├── error.twig
│       │       │   ├── pagination.twig
│       │       │   └── /*/
│       │       │       └── *.twig
│       │       ├── exception
│       │       │   └── *.twig
│       │       └── install
│       │           └── *.twig
│       ├── Security ■パスワードハッシュクラスや権限チェッククラス群
│       │   └── /*/
│       │       └── *.php
│       ├── Service ■サービスクラス群( カート処理等の特化クラス )
│       │   └── *.php
│       ├── ServiceProvider ■DI定義用クラス群
│       │   └── *.php
│       ├── Twig ■Twig拡張用クラス群
│       │   └── /*/
│       │       └── *.php
│       └── Util ■共通関数クラス群
│           └── *.php
└── vendor ■Silex本体・Symfony2コンポーネント群・Doctrine・PHPUnitなど利用技術群
    ├── /*/
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


<!--
→開発ガイドラインに移行
### リファクタ時に作成・変更するファイル
{$Hoge}ページを作る場合

| 種別 | ファイル | 詳細 |
|------ |-----|------|
| ルーター | src\Eccube\ControllerPrivider\(Front or Admin)Controller\{$Hoge}Controller.php | ルーティングを追加・変更する |
| コントローラー | src\Eccube\Controller\{$Hoge}Controller.php  | リクエストを受けて、Viewを出し分けるロジックを書く、 ビジネスロジックをもたない |
| フォームビルダー・バリデーター | src\Eccube\Form\Type\{$Hoge}Type.php | フォーム項目とバリデーション定義を作成する |
| レポジトリ | src\Eccube\Repository\{$Hoge}Repository.php |  EntityRepositoryをextendsしたClassを定義しておく |
| エンティティ | src\Eccube\Entity\{$Hoge}.php | Setter/Getterを記述, DBスキーマと紐づくため、型の定義などをしっかり記述する|
| サービス | src\Eccube\Service\{$Hoge}Service.php | ビジネスロジックを書く ビジネスロジックはちゃんとしたOOPとなるように記述する |
| ビュー | src\Eccube\View\{$Hoge}.twig |  View |
| DIコンテナ定義 | src\Eccube\ServiceProvider\EccubeServiceProvider.php | 作成したForm\Typeを$app['form.types']に記述する, 利用するRepositoryを$app['eccube.repository.{$hoge}']としてDICにいれる |

## 外部コンポーネント

### 選定基準

* できるだけ、テストが行われているものを利用する。
* ライブラリの採用時には事前に検討を行う。
* EC-CUBEの 3.0.X では基本的に外部ライブラリもAPIの変わらないバージョンを利用する。
* PEARを利用しているもので、SymfonyComponentに置き換えが可能なものは積極的に置き換える。

### 開発時には Composer による依存環境の解消を行う

* Composer を標準で採用し、autoloader も同様に Composer 付属のものを利用する。
-->
