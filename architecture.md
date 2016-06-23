---
layout: default
title: EC-CUBE 3のアーキテクチャ
---
<!--
---

## はじめに

### Symfony2 コンポーネント

- Symfony2の公式ページで、「Symfony2 コンポーネント」についての説明があります。


---

_“結局のところ、Symfony2 とはいったい何なのでしょうか？ **Symfony2 は、独立した 20 以上のライブラリの集合体で、それらの一つ一つは どんな PHP プロジェクトでも使用可能です。** それらを Symfony2 コンポーネントと呼んでいますが、どんな開発の場合でも、ほとんどすべてのシチュエーションで便利なものとなっています。 いくつか紹介しましょう。”_

[引用元 : スタンドアロンなツール: Symfony2 コンポーネント](http://docs.symfony.gr.jp/symfony2/book/http_fundamentals.html)

---

- 上記で「___Symfony2 は、独立した 20 以上のライブラリの集合体で、それらの一つ一つは どんな PHP プロジェクトでも使用可能です___」と表現されている通り、Symfony2とは独立したコンポーネントの集合体といえそうです。

では上記を踏まえて「Silex」、そして「EC-CUBE 3」との関係性を探ってみます。

### Symfony2 - 必須ではないコンポーネント = Silex?

では**「Silex」**とはなんでしょう?

- Silexの公式サイトを見るとイントロダクションの章の冒頭に以下の記述があります。

---

_“Silex は PHP 5.3 以上で動作する PHPマイクロフレームワークです。 **Symfony2 のコンポーネントと Pimple を利用して構築されており**、 Sinatra からもインスパイアされています。”_

[引用元: Silex公式サイト/イントロダクション (Introduction)](http://silex-users-jp.phper.jp/doc/html/intro.html)

---

- ここではSinatraはおいておきましょう、そこよりも強調表示した箇所に「_**Symfony2 のコンポーネントと** Pimple を利用して**構築**されており_」との記述がされています。

重要なヒントが記述されていますね。分かり易い様に、あえて間違った表現を行いますが、**「Silex」の基本構造は「Symfony2 のコンポーネント」**と捉える事ができます。

- 実際にSilexの公式サイトに以下の記述があります。

---

_“以下の Symfony2 コンポーネントが Silex で利用されています:_

_HttpFoundation: Request と Response のため._

_HttpKernel: なぜなら中枢部分が必要だから_

_Routing: 定義したルーティングと一致するかどうかを確認するため_

_EventDispatcher: HttpKernelにフックするため”_

[引用元: Silex公式サイト/内部の仕組み](http://silex-users-jp.phper.jp/doc/html/internals.html)

---

表現がわかりにくいかも知れませんが、WEBアプリの核となる「http」のリクエスト・レスポンス処理を、担っているようです。

と云う事は**EC-CUBE 3の構造を知る**には**「Symfony2 のコンポーネント」が鍵**となってきそうです。

### Silex + ? = EC-CUBE 3コア

- さて本題ですが、EC-CUBE 3の実際はどうなのでしょうか、EC-CUBE 3は公開情報にもある様に、「Silex」をベースとして、構築されているWEBアプリケーションです。

- では **EC-CUBE 3のコア = Silex** いう理解で正しいでしょうか？

- 確かに「**=**」となる箇所も多々ありますが、あえていいましょう**間違いです**。

- 正しくは **Silex + Symfony2コンポーネント + カスタマイズ = EC-CUBE 3コア** です。


## EC-CUBE 3のアーキテクチャ

- 前章の説明で理解いただけたでしょうか？

----

__Silex + Symfony2コンポーネント + カスタマイズ = EC-CUBE 3コア__

----

- みなさん「EC-CUBE 3」のコードに触れていき、疑問にぶつかった際は、「Silex」の情報を検索するのではないでしょうか？

- ですが、欲しい情報が見つかっても、コードの内容との相違に戸惑いませんか？

- 理由は、「Silex」の仕様よりも、「Symfony2コンポーネント」の仕様の方が、色濃く設計思想に反映されているからです。

- 「Silex」は必要最小限の機能だけで構築されているため、カスマイズの自由は高いですが、かわりにライブラリが不足してるとも、言い換える事ができます。

- 実際EC-CUBE 3の様なショッピングカートを構築するには、ライブラリ不足が目立ちます。

- そこで、「EC-CUBE 3」に必要な機能で「Silex」で不足しているものは「Symfony2コンポーネント」で実現されています。
	※当然全てではありません。

- そのために「EC-CUBE 3」独自のカスタマイズがコアに含まれている上、「Symfony2」の技術が多様されているために、「Silex」の情報を初めに検索しても、欲しい情報にたどり着けない事もあります。

- これまでの内容をまとめると、何か疑問があった際は、「Symfony2」の情報を検索した方が、望んだ情報にたどり着ける可能性が高くなります。

- 当然、カスタマイズも行われているため、たどり着いた情報で、全てが解決する訳ではないと思いますが、大きなヒントは得られるはずです。

### 必要情報を得るために

- 以下の順で技術情報をたどって行く事をおすすめします。

	1. EC-CUBE 3
	1. Symfony2
	1. Doctrine/Twig
	1. Silex

- では以下から各技術の参考先を記述します。

-->

<!--
# EC-CUBE 3で採用されている技術

- EC-CUBE 3では、**Silexをフレームワーク**として採用し、Silexで**補いきれない機能は「Symfon2コンポーネント」**を用いています。

### Symfony2 コンポーネント

- Symfony2の公式ページで、「Symfony2 コンポーネント」についての説明があります。


---

_“結局のところ、Symfony2 とはいったい何なのでしょうか？ **Symfony2 は、独立した 20 以上のライブラリの集合体で、それらの一つ一つは どんな PHP プロジェクトでも使用可能です。** それらを Symfony2 コンポーネントと呼んでいますが、どんな開発の場合でも、ほとんどすべてのシチュエーションで便利なものとなっています。 いくつか紹介しましょう。”_

[引用元 : スタンドアロンなツール: Symfony2 コンポーネント](http://docs.symfony.gr.jp/symfony2/book/http_fundamentals.html)

---

- 上記の説明の様に、「Symfony2コンポーネント」はライブラリと捉えてください。
-->

# EC-CUBE 3で利用されている技術

## Silex

1. <a href="http://silex-users-jp.phper.jp/" target="_blank">Silex ユーザーガイド</a>

	- Silexの日本語ドキュメント。


### Symfony2

1. <a href="http://docs.symfony.gr.jp/" target="_blank">日本Symfonyユーザ会</a>

	- Symfony2の翻訳ドキュメントが読める。
		とくに、Form Type リファレンスやバリデータリファレンスは必須です。

1. <a href="http://gihyo.jp/book/2012/978-4-7741-5082-6" target="_blank">効率的なWebアプリケーションの作り方</a>

	- タイトルがわかりにくいですが、Symfony2のサンプルが豊富にあり参考になります。

1. <a href="http://blog.asial.co.jp/669" target="_blank">Symfony 2のアプリケーション構成を読む</a>

	- 情報は古いですが、全体像の把握に参考にしてください。


<!--
## Symfony Components

- 保留
-->


## データーベース抽象化レイヤ

### Doctrine ORM

1. <a href="http://www.doctrine-project.org/projects/orm.html" target="_blank">公式サイト</a>

1. <a href="http://www.doctrine-project.org/api/orm/2.4/index.html" target="_blank">APIドキュメント</a>

1. 基本リファレンス

    - 基本事項として以下を確認してください。
    - エンティティマネージャ、レポジトリ、クエリビルダの説明です。

        - [EntityManager](http://www.doctrine-project.org/api/orm/2.4/class-Doctrine.ORM.EntityManager.html)

        - [EntityRepository](http://www.doctrine-project.org/api/orm/2.4/class-Doctrine.ORM.EntityRepository.html)

        - [QueryBuilder](http://www.doctrine-project.org/api/orm/2.4/class-Doctrine.ORM.QueryBuilder.html)



## テンプレートエンジン

### Twig

1. <a href="https://github.com/symfony-japan/twig-docs-ja" target="_blank">twig-docs-ja</a>
  - Twigの日本語翻訳。

1. <a href="http://twig.sensiolabs.org/documentation" target="_blank">原文</a>

## ライブラリ管理

### コンポーザー

<a href="https://kohkimakimoto.github.io/getcomposer.org_doc_jp/doc/00-intro.html" target="_blank">コンポーザー日本語ドキュメント</a>
