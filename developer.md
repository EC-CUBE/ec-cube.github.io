---
layout: default
title: EC-CUBE3 開発者用ページ
---

---

# 概要

EC-CUBE3.0 では、デザインテンプレートのファイルを探す際に`render()`に渡されたファイルをいくつかのフォルダを順に探査し、該当するテンプレートファイルを発見次第、そのデザインテンプレートのファイルを利用する。  
なお、Pluginによるデザインテンプレートへの介入は許容するが、完全な上書きは認めない

### 探査順

* フロント
  * デフォルトのtemplate_nameは`Default`とする。  
```
  1. app/template/[template_name]
  2. src/Eccube/Resource/template/Default
  3. app/plugin/[plugin_name]/Resource/template/[template_name]
```

* 管理画面
  * 管理画面のtemplate_nameは`Admin`とする
```
1. app/template/Admin
2. src/Eccube/Resource/template/Admin
3. app/plugin/[plugin_name]/Resource/template/Admin/[template_name]
```

### 探査例

* フロントの例  
デザインテンプレート名「MyDesign」を利用しており、Controllerで
`$app['view']->render('TemplateDir/template_name.twig');`  とされている場合  
```
 1. app/template/MyDesign/TemplateDir/template_name.twig
 2. src/Eccube/Resource/template/Default/TemplateDir/template_name.twig
 3. app/plugin/[plugin_name]/Resource/template/TemplateDir/template_name.twig
```

* 管理画面の例  
`$app['view']->render('Product/index.twig');`  とされている、商品マスターのテンプレートをカスタマイズし、app/以下においている。

```
 1. app/template/Admin/Product/index.twig
 2. src/Eccube/Resource/template/Default/Admin/Product/index.twig
 3. app/plugin/[plugin_name]/Resource/template/Admin/Product/index.twig
```

## 管理画面での編集時の挙動（ブロック編集やページ詳細） 

現在利用しているテンプレートを読み込み。なければ標準(src/Eccube/Resource/template/Default/以下のファイル）をもってきて、新たにapp/template/Default/以下に保存

### 読み込みイメージ

```
if (app/template/[TPL_CODE]/block/category.tpl) { 
    read(app/template/[TPL_CODE]/block/category.tpl); 
} else { 
    read(src/Eccube/Resource/template/Default/block/category.tpl) 
} 
```

### 保存 

save (app/template/[TPL_CODE]/block/category.tpl) 

---

# フックポイントの命名規則

`eccube.event.*.(before|after|finish)`  


### 現時点で、自動生成もしくは定義されているフックポイント一覧

* `eccube.event.app.before`
* `eccube.event.app.after`
* `eccube.event.controller.ROUTE.before`
* `eccube.event.controller.ROUTE.after`
* `eccube.event.controller.ROUTE.finish`
* `eccube.event.render.before`
    + `$app['view']->render()` のときにEventが走る。
    + 引数のEventObjectを利用することで、ソースコードを自由に触れる用にしてある

`ROUTE` は、 `$request->attributes->get('_route')` で取得できる、ルーティング名  
`->bind('ここ')`

---

# 概要

プラグインのインストール等の状態変化時の動作とデータ構造を規定する。
また、プラグインのインストール、アンインストールに伴う初期化処理（個別プラグイン用テーブル、初期データ挿入）の実装方法を規定する

**データ構造** 

プラグインマスタテーブル(dtb_pluginに相当)

 - id:int(サロゲートキー)
 - name:string not null
 - enable:smallint not null
 - delete_flg:smallint not null
 - code string
 - version:string
 - source:int

ハンドラ優先度テーブル(dtb\_plugin\_hookpointに相当)

 - id:int (サロゲートキー)
 - event:string not null (イベント名)
 - priority:int not null (優先度)
 - plugin_id:int not null(プラグインID)
 - handler:string not null(ハンドラ名)
 - handler_type:string not null(ハンドラ種別)
 - delete_flg:smallint not null

※event,priorityの2フィールドでユニークキー

(プラグイン毎の)config.yml

 - name:string  (必須)
 - event:string
 - service:string[]
 - orm.path:string[]
 - form:string[]
 - migration.path:string[]
 - code:string (必須)
 - version:string (必須)

code,eventは英数_ のみ

(プラグイン毎の)event.yml

- string(イベント名)
     - [ handler :string,type : string ]
     - [ handler :string,type : string ]
- string(イベント名)
     - [ handler :string,type : string ]
     - [ handler :string,type : string ]

※イベント名のキーに対応するvalueとして、handlerとtypeの二要素からなるハッシュ(ハンドラ定義)の配列が定義される。イベントとハンドラ定義は複数定義できる
※Typeは優先度定義(NORMAL FIRST LASTのいずれかの文字列を設定する)
※内容はgetSubscribedEvents()と同じですがオーナーズストア等でも使えるようymlへ移動
※handlerは英数_のみ許可
----------


**(プラグイン毎の)状態変化ハンドラクラス(プラグインメインクラスに相当)**
このクラスをプラグインへ同梱すると、各状態変化の際にメソッドがコールされる
処理としてはプラグイン固有のテーブルやリソースファイルの作成、展開などを想定する
インストール処理等の必要ない単純なプラグインの場合はハンドラクラスやメソッドを定義しなくてもよい

    namespace pluginname;
    use Eccube\Plugin\AbstractPluginManager;
    
    class PluginManager extends AbstractPluginManager {
    
      public function install($plugin,$app){}
    
      public function uninstall($config,$app){}
    
      public function enable($config,$app){}
    
      public function disable($config,$app){}
    
      public function update($config,$app){}
    }

(引数はconfig.ymlをパースした内容とEccube\Application)

**インストール、アップデート、アンインストール時の動作**

 - アーカイブを展開してファイルを/app/pluginに展開
 - 対象プラグインのconfig.ymlに記載されたプラグインのメタデータがプラグインマスタテーブルに挿入/更新される
 - ハンドラ優先度テーブルにevent.ymlの内容が挿入される。priorityの設定は優先度制御のissue参照
 - PluginManager クラスのdisableメソッドが呼び出される(アンインストール時のみ)
 - PluginManager クラスのinstall/uninstall/updateの各メソッドが呼び出される
 - PluginManager クラスのenableメソッドが呼び出される(インストール時のみ)
 - ファイルのコピー、プラグイン固有のテーブルの作成、削除は上記のメソッドで実施する
 - プラグイン固有テーブルはorm.pathのymlリソース又はmigration.pathのマイグレーションファイルによる作成が可能

**プラグイン有効化、無効化時の動作**

 - プラグインマスタテーブルのenableフラグが操作される
 - プラグインマスタテーブルのenableフラグがfalseの場合、ハンドラ優先度テーブルの該当プラグインのイベント定義は実行時に無視される
 - PluginManager クラスのenable/disableメソッドが呼び出される


**プラグイン固有設定画面**

プラグイン一覧画面からプラグイン固有の設定画面を開きたい場合、以下の名前で定義すること

PATH：
/($app['config']['admin_route'])/plugin/$PLUGIN_CODE/config

コントローラ名：
Plugin\$PLUGIN_CODE\Controller\ConfigController

BIND：
plugin_$PLUGIN_CODE_config

ここでは名前だけを定義
（ルートの定義は各プラグインのServiceにて行う必要がある）

---

# EC-CUBE3 Plugin間の優先度制御

## 課題
稼働環境に同じイベントをフックする複数のプラグインを同時にインストールし、各プラグインのイベントハンドラがパラメータを書き換える場合、書き換える順序によっては想定しない動作が発生する恐れがある。
さらに、監査、ロギング、デバッグ用等で他のプラグインより必ず先又は後で起動する必要のあるハンドラの起動順序を制御したい

##### 例
購入時のFormEventをカード決済プラグインと後払いプラグインのイベントハンドラが書き換える場合、後のハンドラが書き換えるフォーム要素を前のプラグインが削除している可能性がある

## 対策
管理画面からユーザが各イベントのハンドラの起動順を設定できるようにする
例：後払い(3)→カード決済(2) →監査(1)の順でFormEventのイベントハンドラが起動
起動順序は管理画面等からDB上のハンドラ優先度テーブル（仮）に保持する。
SymfonyのEventDispatcher の仕様に合わせて実行順は-511～+511の降順とする

### テーブル構成
ハンドラ優先度テーブルは以下のフィールドを保有する

* id:int    (サロゲートキー)
* event:string not null (イベント名)
* priority:int not null (優先度)
* plugin_id:int not null(プラグインID)
* handler:string not null(ハンドラ名)

    event,priorityの2フィールドでユニーク

## 起動優先度とハンドラ種別

* 優先度は+400～-399は**通常型ハンドラ**用とする
* 優先度-400～-499は**後発型ハンドラ**用とする(デバッグ、監査用を想定)
* 優先度+500～+401は**先発型ハンドラ**用とする(同上)
* 優先度0は実行時にハンドラを登録しない(ハンドラを無効化)

## プラグインインストール時の動作

* 各プラグインのgetSubscribedEvents内のイベントハンドラと優先度をハンドラ優先度テーブルに挿入する
* 当該イベントにハンドラが1件も登録されていない場合のデフォルト優先度は以下のとおり
* * 先発型:500
* * 通常型:400
* * 後発型:-400

* ハンドラが既に登録されている場合、既に存在する同型ハンドラ
のイベントの優先度の最大値-1を登録する
（ハンドラが既に400に登録されている場合に通常ハンドラを登録すると399に登録される）
* ハンドラ種別毎に決められた優先度枠に空きがない場合、プラグインのインストールは失敗する

## Webアプリケーション実行時の動作

* プラグインのイベンドハンドラをディスパッチャに登録する際(Application.php等)、優先度テーブルの優先度(昇順)に各ハンドラを登録する
* イベントが実際に発生すると登録された順にハンドラが起動する
* 優先度テーブルに登録されていないイベントハンドラがプラグインに定義されている場合、優先度-500(全てのハンドラの後)とみなされる

## ハンドラ優先度変更画面の動作
* 各ハンドラの優先度をユーザ入力に基づいてアップデートする
* ただし、優先度はハンドラ種別（通常、先発、後発）毎の範囲内に限定される

## プラグイン開発者への影響

* getSubscribedEventsはハンドラのメソッド名と優先度（数値）を返すが、メソッド名と種別（通常、先発、後発）を返すように変更
* （開発者向けの指針）通常型プラグインとの衝突を防ぐため、先発型、後発型のハンドラでは渡されたパラメータを書き換えないことが望ましい

---

# テストポリシー  

## 基本ルール 
* WebテストはSilexのWebテストを利用する。
* 単体テスト / Webテストを含め、カバレッジ100％を目指す。
* Service, Form/Type以下のビジネスロジックに密に関わる部分のテストを必須とする
* テストが落ちたPRについては、マージされない

## 開発時のテストコード条件

| テストコードとPRの処理                     |  対象                            | 
|------------------------------------------|----------------------------------|
| 必ずテストコードを同梱　　　　　　　　　　   | src\Eccube\Service\              |
| あることが望ましいが、βまでは省略可能       | src\Eccube\Form\Type\             |
| 省略可能                                  | src\Eccube\Controller\, src\Eccube\View\ |

## カバレッジ目標  

以下は、カバレッジ100%を目指す  
* 疎通確認（Routing）テスト
  + 全正常系を網羅
* src\Eccube\Service\に属するClassの単体・機能テスト
  + 単体テスト100%
  + 機能テスト100%
* src\Eccube\Form\Type\に属するClassの機能テスト
  + Validationチェック
* src\Eccube\Plugin\に属するClassの単体・機能テスト
  + ※検討中（Plugin仕様が決まり次第）

## 各種テスト方針

### 疎通確認（Routing）テスト

* ControllerProviderのルーティングルールをベースにテストを作成する
* 正しくルーティングされているかどうかは以下の基準で判定する
  + コントローラーのメソッドに対応するページが有る場合(newなど)は、レスポンスのステータスコードが 2xx であることを検証
  + コントローラーのメソッドに対応するページが無い場合(deleteなど)は、意図したページにリダイレクトされるかどうかを検証

### src\Eccube\Form\Type\に属するClassの機能テスト

* 以下の2つをベースにして、テストを作成する
  + 2系のバリデーションルール(eccube-2_13/data/class/pages 又は eccube-2_13/data/class/helper以下)
  + src\Eccube\Form\Type\ (既存のバリデーションに影響がある変更が発生した時、検知できるようにするため)
* MAXやMINの制限は、境界値テストをする

---

# 外部コンポーネント

## 選定基準

* できるだけ、テストが行われているものを利用する。
* ライブラリの採用時には事前に検討を行う。
* EC-CUBEの 3.0.X では基本的に外部ライブラリもAPIの変わらないバージョンを利用する。  
* PEARを利用しているもので、SymfonyComponentに置き換えが可能なものは積極的に置き換える。

## 開発時には Composer による依存環境の解消を行う

* Composer を標準で採用し、autoloader も同様に Composer 付属のものを利用する。

---

# 開発・デバッグ用のTips

## デバッグモードの有効化

通常 / や/index.phpでアクセスしているところを /index_dev.php と書き換えてアクセスすることにより、デバッグモードが有効になります。 デバッグモードでは、開発の手助けになる、WebProfilerやDebug情報が出力されるようになります。

```You are not allowed to access this file. Check index_dev.php for more information.```  
のようなエラーが表示される場合

index_dev.phpを開き、アクセス元のIPを以下の配列に追加してください。
```
$allow = array(
    '127.0.0.1',
    'fe80::1',
    '::1',
);
```

## 開発と本番でconfig.ymlを使い分ける
app/config/eccube 直下に config_dev.yml を用意することで開発環境だけの値を利用することができます。 

https://github.com/EC-CUBE/ec-cube/issues/207

## メールの誤送信防止機能

config.ymlまたはconfig_dev.yml に delivery_addressを追加することで
メール誤送信を防ぐことが可能です。
delivery_addressにメールアドレスが設定されていればそのアドレスのみにメール送信されます。
但し、この機能はデバッグ環境(index_dev.phpからのみ)でしか有効になりませんのでご注意ください。

https://github.com/EC-CUBE/ec-cube/issues/195


## コンソールコマンドについて

ver3.0.0には含まれていませんが、GitHubから最新版を取得するとコンソールコマンドとして、  
```
php app/console router:debug
php app/console cache:clear
```
が用意されています。

```router:debug``` の方は現在登録されているrouting情報が一覧表示されます。  
```cache:clear``` はapp/cache配下のキャッシュがsession情報を除いて削除され、  
```cache:clear --all``` と ```--all``` を指定するとsessionのキャッシュも含めて全て削除されます。





