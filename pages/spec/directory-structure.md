---
title: ディレクトリ・ファイル構成
keywords: spec directory structure
tags: [spec, getting_started]
sidebar: home_sidebar
permalink: spec_directory-structure
---
---

## 特徴

1. EC-CUBE 3ではSilexフレームワークを採用しているため、**2系から大幅にディレクトリ構造が変化**しました。

1. **Symfony2のディレクトリ構造を参考**に、EC-CUBE 3**独自構成**となっています。

1. **公開ディレクトリについては２系をほぼ踏襲**しています。


## 主なディレクトリと役割

- 以下に主なフォルダとディレクトリ構成を示します。

1. app : 主に環境によって変更が入るものを配置。
1. html : Document Rootとなるフォルダ。外部から直接参照する物のみ配置。
1. src : EC-CUBEのCOREとなるソースを配置。

下記に各ディレクトリの詳細を説明します。


### app配下

- **設定ファイル**や**ログ・ファイル等**が配置、**プラグインは「Plugin」ディレクトリ**配下に配置


<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/spec_directory_structure/directory_app.txt"></script>


### html配下

- **公開ディレクトリ**となり、**リソースファイル**(cssや画像ファイル）を配置

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/spec_directory_structure/directory_html.txt"></script>


### src配下

- **アプリケーション本体**となり、phpファイルやTwigファイルを配置

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/spec_directory_structure/directory_src.txt"></script>



## 定数

- EC-CUBE 3で利用される定数は以下に保存されています

### 対象ファイル

1. Common/**Constant.php**
    - EC-CUBEのバージョンなど、基本情報の定数です。

2. Resource/config/**constant.yml.dist**
    - 主にプログラム上で利用する定数です。

## 2系・3系置き換え早見表

| 2系                    | 3系                                      |
|------------------------|------------------------------------------|
| SC_FormParam           | Eccube\Form\Type\                        |
| SC_Query               | Doctrine Orm                              |
| SC\_Helper\_Purchase     | Eccube\Service\PurchaseService           |
| LC\_Page\_Products\_Class | Eccube\Controller\ProductClassController |
| *.tpl                  | Eccube\Resouce\template\\*.twig                       |


## 参照元

- <a href="http://sssslide.com/speakerdeck.com/amidaike/ec-cube3kodorideingu-number-1" target="_blank">EC-CUBE 3コードリーディング #1</a>
