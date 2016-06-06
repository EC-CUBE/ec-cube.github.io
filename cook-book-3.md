---
layout: default
title: 画面に変数を渡してみよう
---

---

# 画面に変数を渡してみよう


## Twig構文とView変数

- 前章でコントローラー、Twigの作成・レンダリングを行いました。

- 本章では、コントローラーから変数を渡し、変数に格納した内容をTwigで表示してみましょう。

<!--
### Twigを用いるメリット

- 前章ではTwigをコントローラーでレンダリングしただけで、表示内容はTwigに静的に保存した内容を表示しただけですが、それだけであれば、Twigを利用せずに「html」だけで可能です。

- ではTwigを何故使うのか、「Twig」単体で様々な機能を提供してくれるのも、理由のひとつですが、実際はコントローラーからなんらかの変数を受け取り、その値を加工して表示出来る事が、テンプレートエンジンの有用性です。

- それでは、Twig利用の第一歩として、コントローラーから変数を渡し、その内容を表示したいと思います。
-->

### コントローラーの修正

- コントローラー内で変数を定義し、「render」メソッドで定義した変数を、連想配列で引数として与えます。
- その際、「key」は任意の文字列となりますが、Twig側で変数を呼び出す際の、名称となります。

- /default/CookBook/Bbs.php

```
<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Controller\CookBook;

use Eccube\Application;

class Bbs
{

    public function index(Application $app)
    {
        $viewname = 'このビューは「CookBook/bbs_top.twig」が表示されています。';☆追記

        return $app->render(
            'CookBook/bbs_top.twig',
            array(
                'viewname' => $viewname,
            )
        );☆連想配列を追記
    }
}
```

### Twigの修正

- コントローラで連想配列で引き渡した変数の表示をTwigに追記します。

	- CookBook/bbs_top.twig

```
{#
This file is part of EC-CUBE

Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.

http://www.lockon.co.jp/

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#}
｛％ extends 'default_frame.twig' ％｝

｛％ set body_class = 'front_page' ％｝

｛％ block javascript ％｝
｛％ endblock ％｝

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">
                <h1>ご意見箱</h1>
                <p>みなさんのご意見をかきこんでください</p>
                <dl>☆追記
                    <dt>コントローラーから取得した変数です</dt>
                    <dd>｛｛ viewname ｝｝</dd>☆変数呼び出し部
                </dl>
            </div>
        </div>
    </div>
｛％ endblock ％｝
```

- 今回追記内容について簡単な説明を行います。

1. ｛｛｝｝Twigにコントローラーで設定した変数を表示しています。

2. Twigのブロック(1.の｛｛｝｝)は3種類あります。

	---

	| ブロック種別 | 適用対象 | 凡例 |
	|------|------|
	| ｛｛｝｝ | 変数の中身を表示 | ｛｛ viewstr\|nl2b ｝｝ |
	| ｛％％｝ | ブロック内でロジックを記述する | ｛％ if myvar is ... ％｝ |
	| {##} | コメントアウト | {# DB取得内容を表示... #} |

	---

3. 上記の3種類を使い分けてViewを構築していきます。

### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/cookbook/Bbs」を入力してください。

1. コントローラーで定義した変数の内容が表示されています。

---

![View変数のレンダリング](/images/img-cookbook3-view-rendar.png)

---

### 本章のまとめ

- 本章では以下を学びました。

1. コントローラー内、renderメソッドへのView変数追加

1. Twigの変数表示

1. Twigのブロックの種類

### Viewのグローバル変数

- 以下の変数は「Application.php」で初期化、格納されているため、全てのTwigから直接呼び出す事が可能です。

| 変数名 | 詳細情報 |
|------ |-----|
| BaseInfo | 管理画面 > 設定 > 基本情報設定 > ショップマスターで保存した内容 |
| title | ページタイトル |

- 呼び出し方は以下の様に呼び出せます。

例. ｛｛ BaseInfo.カラム名 ｝｝

- 詳細なTwig構文については後の章で説明を行います。

### 参考

<a href="http://qiita.com/poego/items/81628dcd0f8e4d4a2d9d" target="_blank">EC-CUBE3のTwigのタグ覚え書き（一部EC-CUBE2系のSmarty比較）<a/>
