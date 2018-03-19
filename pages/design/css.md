---
title: Sassの利用
keywords: design 
tags: [design]
sidebar: home_sidebar
permalink: design_css
---

## Sassの利用

EC-CUBEのCSSは、[Sass](http://sass-lang.com) を使用して記述されています。
Sass のソースコードは `html/template/{admin,default}/assets/scss` にあります。

## Sassのビルド

前提として [https://nodejs.org/ja/] より、 Node.js をインストールしておいてください。

以下のコマンドでビルドすることで、 `html/template/{admin,default}/assets/css` に CSS ファイルが出力されます。

```shell
npm install # 初回のみ
npm run build # Sass のビルド
```

## スタイルガイドについて

EC-CUBEでは、CSSやHTMLの設計指針やコーディングルールを確認できるよう、`スタイルガイド`を用意しています。
詳しくは以下を参照ください。

- [フロント画面のスタイルガイド](https://github.com/EC-CUBE/Eccube-Styleguide)
- [管理画面のスタイルガイド](https://github.com/EC-CUBE/Eccube-Styleguide-Admin)