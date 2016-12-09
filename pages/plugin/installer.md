---
title: プラグインインストーラーの仕様
keywords: plugin installer spec
tags: [plugin, spec]
sidebar: home_sidebar
permalink: plugin_installer
---

## 概要

プラグインのインストール等の状態変化時の動作とデータ構造を規定する。  
また、プラグインのインストール、アンインストールに伴う初期化処理（個別プラグイン用テーブル、初期データ挿入）の実装方法を規定する

## データ構造

### プラグインマスタテーブル(dtb_pluginに相当)

 - id:int(サロゲートキー)
 - name:string not null
 - enable:smallint not null
 - delete_flg:smallint not null
 - code string
 - version:string
 - source:int

### ハンドラ優先度テーブル(dtb\_plugin\_hookpointに相当)

 - id:int (サロゲートキー)
 - event:string not null (イベント名)
 - priority:int not null (優先度)
 - plugin_id:int not null(プラグインID)
 - handler:string not null(ハンドラ名)
 - handler_type:string not null(ハンドラ種別)
 - delete_flg:smallint not null

※event,priorityの2フィールドでユニークキー

### (プラグイン毎の)config.yml

 - name:string  (必須)
 - event:string
 - service:string[]
 - orm.path:string[]
 - form:string[]
 - migration.path:string[]
 - code:string (必須)
 - version:string (必須)

code,eventは英数_ のみ

### (プラグイン毎の)event.yml

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


## (プラグイン毎の)状態変化ハンドラクラス(プラグインメインクラスに相当)
このクラスをプラグインへ同梱すると、各状態変化の際にメソッドがコールされる  
処理としてはプラグイン固有のテーブルやリソースファイルの作成、展開などを想定する  
インストール処理等の必要ない単純なプラグインの場合はハンドラクラスやメソッドを定義しなくてもよい  

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/plugin_install/PluginManager.php"></script>

(引数はconfig.ymlをパースした内容とEccube\Application)

## インストール、アップデート、アンインストール時の動作

 - アーカイブを展開してファイルを/app/pluginに展開
 - 対象プラグインのconfig.ymlに記載されたプラグインのメタデータがプラグインマスタテーブルに挿入/更新される
 - ハンドラ優先度テーブルにevent.ymlの内容が挿入される。priorityの設定は優先度制御のissue参照
 - PluginManager クラスのdisableメソッドが呼び出される(アンインストール時のみ)
 - PluginManager クラスのinstall/uninstall/updateの各メソッドが呼び出される
 - PluginManager クラスのenableメソッドが呼び出される(インストール時のみ)
 - ファイルのコピー、プラグイン固有のテーブルの作成、削除は上記のメソッドで実施する
 - プラグイン固有テーブルはorm.pathのymlリソース又はmigration.pathのマイグレーションファイルによる作成が可能

## プラグイン有効化、無効化時の動作

 - プラグインマスタテーブルのenableフラグが操作される
 - プラグインマスタテーブルのenableフラグがfalseの場合、ハンドラ優先度テーブルの該当プラグインのイベント定義は実行時に無視される
 - PluginManager クラスのenable/disableメソッドが呼び出される


## プラグイン固有設定画面

プラグイン一覧画面からプラグイン固有の設定画面を開きたい場合、以下の名前で定義すること

PATH：
/($app['config']['admin_route'])/plugin/$PLUGIN_CODE/config

コントローラ名：
Plugin\$PLUGIN_CODE\Controller\ConfigController

BIND：
plugin_$PLUGIN_CODE_config

ここでは名前だけを定義
（ルートの定義は各プラグインのServiceにて行う必要がある）

