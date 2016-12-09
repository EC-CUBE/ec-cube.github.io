---
title: デザインテンプレートの基礎
keywords: design template search
tags: [design]
sidebar: home_sidebar
permalink: design_template
summary: デザインテンプレートの基本ルールについて説明します。
---

## デフォルトのテンプレートの配置場所

EC-CUBEがインストールされているディレクトリを `ECCUBEROOT` とします。  
本体の標準のTwigファイルは以下のディレクトリに配置されています。

- フロント画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/default`

- 管理画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/admin`

- インストール画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/install`

## デザインのカスタマイズ時のファイル配置

EC-CUBEでは、デフォルトのディレクトリとは別に、オリジナルのデザインテンプレートを配置可能です。  

新規にデザインを作成する場合に、直接デフォルトのテンプレートを触るとバージョンアップで上書きされたりする恐れがあるため、デフォルトのファイルを直接変更することは推奨していません。  

- オリジナルのデザインテンプレート配置時の標準ディレクトリ  
`ECCUBEROOT/app/template/[template_code]`  
→ [template_code]とは、テンプレートを識別するためのコード。標準ではフロントの場合「default」、管理画面の場合「admin」が定義されている。

このディレクトリはデザインテンプレートを利用するときに適用されるためのディレクトリとなります。
デザインテンプレートはこのディレクトリ配下に保存されています。  
→リソースファイルは `ECCUBEROOT/html/template/[template_code]` に配置されます。

## 管理画面でのデザイン編集時の挙動（ブロック編集やページ詳細）

現在利用しているテンプレートを読み込み。なければデフォルトのテンプレート(src/Eccube/Resource/template/default/以下のファイル）をもってきて、新たにapp/template/default/以下に保存されます。  

## テンプレートの読み出し順序

テンプレートファイルが呼び出される順序は、以下の通り。

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

先にオリジナルのテンプレートが存在しないかを確認し、存在しなければデフォルトのテンプレートを呼び出します。


### 呼び出し例

* フロントの例
template_codeが「MyDesign」のデザインテンプレートを利用しており、Controllerで
`$app['view']->render('TemplateDir/template_name.twig');`  とされている場合

```
 1. app/template/MyDesign/TemplateDir/template_name.twig
 2. src/Eccube/Resource/template/default/TemplateDir/template_name.twig
 3. app/Plugin/[plugin_code]/Resource/template/TemplateDir/template_name.twig
```

* 管理画面の例
`$app['view']->render('Product/index.twig');`  とされている、商品マスターのテンプレートをカスタマイズし、app/以下においている。

```
 1. app/template/admin/product/index.twig
 2. src/Eccube/Resource/template/admin/product/index.twig
 3. app/Plugin/[plugin_code]/Resource/template/admin/product/index.twig
```



