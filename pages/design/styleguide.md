---
title: スタイルガイドの利用
keywords: design 
tags: [design]
sidebar: home_sidebar
permalink: design_styleguide
summary: スタイルガイドを利用したデザインの変更方法を説明します。
---

## EC-CUBE4のリソース用ディレクトリ

EC-CUBE4ではcssや画像ファイル等のリソースファイルは以下のディレクトリに配置されています。

- フロント画面のリソース用ディレクトリ  
ECCUBEROOT/html/template/default/assets

- 管理画面のリソース用ディレクトリ  
ECCUBEROOT/html/template/admin/assets


## フロントのCSS反映手順

### CSSの対応方針

* EC-CUBE本体側のリポジトリにはコンパイル済みの`style.css`および`style.min.css`のみを管理し、  
SCSSファイルは [https://github.com/EC-CUBE/Eccube-Styleguide](https://github.com/EC-CUBE/Eccube-Styleguide) で管理するようにします。

### Styleguide環境作成
[https://github.com/EC-CUBE/Eccube-Styleguide](https://github.com/EC-CUBE/Eccube-Styleguide) より最新のスタイルガイドを取得し、該当のSCSSを修正していきます。

* 作業方法について  
前提条件としてnodeが利用できる環境が必要ですが、nodeのバージョンはv7まで対応となっています。v8、v9だとコンパイルエラーとなりますのでご注意ください。  
nodeのダウンロードはこちらから該当のv7のバージョンをダウンロードしてください。  
 [https://nodejs.org/en/download/releases/](https://nodejs.org/en/download/releases/)  
StyleGuideの最新のモジュールは [https://qiita.com/chihiro-adachi/items/f31c9d90b1bcc3553c20](https://qiita.com/chihiro-adachi/items/f31c9d90b1bcc3553c20) を参考に、  
[https://github.com/EC-CUBE/Eccube-Styleguide](https://github.com/EC-CUBE/Eccube-Styleguide) を自分のリポジトリにフォークしてから作業を行ってください。

フォークしたリポジトリからclone後、以下の作業を行います。

* 必要となるモジュールをインストール  
```
npm i
```

* styleguide用ビルドを実施  
```
npm run build
```

* moc用ビルドを実施  
```
npm run build:moc
```

* 開発サーバの起動  
```
npm run dev
```

サーバを起動後、`http://localhost:3000/`に接続するとstyleguide用画面が表示されます。  
また、`http://localhost:3000/moc`に接続するとmoc用画面が表示されます。


### CSS変更方法

サーバを起動しておくと自動でブラウザのリロードがされるため、対象となるscssを変更することで即時反映されます。

* ヘッダー見出しのフォントサイズ変更方法  
例えば、「EC-CUBE3 STYLEGUIDE」という見出しを変更したい場合、  
`assets/scss/project/11.2.header.scss` の264行目にある`40px`を`80px`に変更することで適用されます。

scss反映後、問題なければ

```
npm run clean
```

を行い一度コンパイルされたcssファイルを削除後、再度

```
npm run build
```

を実行して本体側へ反映させるための`public/style.css`を作成し、そのファイルを本体側へPull requestをします。

本体側へPull requestをするのと同時に、[https://github.com/EC-CUBE/Eccube-Styleguide](https://github.com/EC-CUBE/Eccube-Styleguide) に対して修正したscssファイルもPull requestをします。


### CSS設計方針
[https://github.com/EC-CUBE/Eccube-Styleguide/blob/master/assets/styleguide.md](https://github.com/EC-CUBE/Eccube-Styleguide/blob/master/assets/styleguide.md) を参照


### その他
新たにアイコンが必要な場合、[https://github.com/EC-CUBE/Eccube-Styleguide](https://github.com/EC-CUBE/Eccube-Styleguide) に対してIssueを作成し、必要となるアイコン依頼を行なってください。

