---
layout: default
title: デザインテンプレートが読み込まれる順序
---

# {{ page.title }}


### テンプレートの配置場所

EC-CUBEがインストールされているディレクトリを `ECCUBEROOT` とします。  
本体の標準のTwigファイルは以下のディレクトリに配置されています。

- フロント画面の標準ディレクトリ  
 `ECCUBEROOT/src/Eccube/Resource/template/default`

- 管理画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/admin`

- インストール画面の標準ディレクトリ  
`ECCUBEROOT/src/Eccube/Resource/template/install`


上記のディレクトリとは別に、EC-CUBEではデザインテンプレートを配置可能です。

- デザインテンプレート配置時の標準ディレクトリ  
`ECCUBEROOT/app/template/[template_code]`  
→ [template_code]とは、テンプレートを識別するためのコード。標準ではフロントの場合「default」、管理画面の場合「admin」が定義されている。

このディレクトリはデザインテンプレートを利用するときに適用されるためのディレクトリとなります。
デザインテンプレートはこのディレクトリ配下に保存されています。  
→リソースファイルは `ECCUBEROOT/html/template/[template_code]` に配置されます。

### テンプレートの反映順序

テンプレートが反映される順序は、以下の通り。

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

先にデザインテンプレート用のテンプレートが存在しないかを探索し、存在しなければ本体側のテンプレートを探索します。


### テンプレートの修正について

 デフォルトのデザインを利用せずに新規にデザインを作成される場合、直接本体のテンプレートを触るとバージョンアップで上書きされたりする恐れがあるため、直接本体のファイルを触るのは推奨していません。

