---
title: デザインテンプレートの基礎
keywords: design template search
tags: [design]
sidebar: home_sidebar
permalink: design_template
summary: デザインテンプレートの基本ルールについて説明します。
---

## デフォルトのテンプレートファイルの配置場所

EC-CUBEがインストールされているディレクトリを `ECCUBEROOT` とします。  
本体の標準のTwigファイルは以下のディレクトリに配置されています。

- フロント画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/default`

- 管理画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/admin`

- インストール画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/install`

## デザインカスタマイズ時のファイル配置

EC-CUBEでは、デフォルトのディレクトリとは別に、オリジナルのデザインテンプレートを配置可能です。  

新規にデザインを作成する場合、デフォルトのテンプレートを触るとバージョンアップで上書きされたりする恐れがあるため、デフォルトのテンプレートを直接触ることは推奨していません。  

- オリジナルのデザインテンプレート配置時の標準ディレクトリ  
`ECCUBEROOT/app/template/[template_code]`  
→ [template_code]とは、テンプレートを識別するためのコード。  
標準ではフロントの場合「default」、管理画面の場合「admin」が定義されている。

このディレクトリはデザインテンプレートを利用するときに適用されるためのディレクトリとなります。
デザインテンプレートはこのディレクトリ配下に保存されています。  

リソースファイルは `ECCUBEROOT/html/template/[template_code]` に配置されます。

## テンプレートの読み出し順序

テンプレートファイルが呼び出される順序は、以下の通りです。

- フロント

```
1. ECCUBEROOT/app/template/[template_code]
2. ECCUBEROOT/src/Eccube/Resource/template/[template_code]
3. ECCUBEROOT/app/Plugin
```

- 管理

```
1. ECCUBEROOT/app/template/admin
2. ECCUBEROOT/src/Eccube/Resource/template/admin
3. ECCUBEROOT/app/Plugin
```

先にオリジナルのテンプレートが存在するのか確認し、存在しなければデフォルトのテンプレートを呼び出します。


### 呼び出し例

* フロントの例  
template_codeが「MyDesign」のデザインテンプレートを利用しており、Controllerで `@Template("TemplateDir/template_name.twig")` とアノテーション定義されている場合

```
 1. app/template/MyDesign/TemplateDir/template_name.twig
 2. src/Eccube/Resource/template/default/TemplateDir/template_name.twig
 3. app/Plugin/[plugin_code]/Resource/template/TemplateDir/template_name.twig
```
という順番で表示されます。

* 管理画面の例  
`@Template("@admin/Product/index.twig")` 商品マスターのテンプレートをapp/template/admin配下に配置した場合、以下の順序で呼び出されます。

```
 1. app/template/admin/Product/index.twig
 2. src/Eccube/Resource/template/admin/Product/index.twig
 3. app/Plugin/[plugin_code]/Resource/template/admin/Product/index.twig
```

## 管理画面からデザイン編集した時のテンプレートファイルの挙動(ページ編集、ブロック編集)

* ページ詳細  
デフォルトの場合、 `ECCUBEROOT/src/Eccube/Resource/template/default` 配下の該当するファイルが表示されます。  
ページ詳細で修正を行った場合、新たに `ECCUBEROOT/app/template/default/` 配下に保存され、以降は `ECCUBEROOT/app/template/default/` 配下のファイルを修正するようになります。

* ブロック編集  
デフォルトの場合、 `ECCUBEROOT/src/Eccube/Resource/template/default/Block` 配下の該当するファイルが表示されます。  
ブロックを新規登録したり編集されたりすると、 `ECCUBEROOT/app/template/default/Block` 配下に保存され、以降は `ECCUBEROOT/app/template/default/Block` 配下のファイルを修正するようになります。
