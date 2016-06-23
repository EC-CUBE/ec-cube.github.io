---
layout: default
title: 画面に変数を渡してみよう
---

---

# {{ page.title }}

## Twig構文とView変数

- 前章でコントローラー、Twigの作成・レンダリングを行いました。

- WEBアプリケーションの構築のためには、コントローラーから、ビューへ情報を渡す必要があります。本章ではその基本的な部分のみ扱います。

### 本章メニュー

- 本章では以下を行います。

    1. コントローラーにビュー変数を定義する説明を行います。

    1. コントローラーレンダリング時に、変数を渡す方法を説明します。

    1. Twigでコントローラーから受けた変数を表示する方法を説明します。

### コントローラーの修正

- コントローラー内で変数を定義し、「render」メソッドで定義済みの変数を、連想配列で引数として与えます。

- その際、「key」は任意の文字列となりますが、Twig側で変数を呼び出す際の、名称となります。

- 早速以下の様に**CrudController.php**を修正します。

    - /src/Eccube/Controller/Tutorial/CrudController.php

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_3/CrudController_add_var.php"></script>

<!--
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


namespace Eccube\Controller\Tutorial;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class CrudController extends AbstractController
{

    public function index(Application $app)
    {
        $viewname = 'このビューは「Tutorial/crud_top.twig」が表示されています。';★追記

        return $app->render(
            'Tutorial/crud_top.twig',
            array(
                'viewname' => $viewname,
            )
        );★連想配列を追記
    }
}
```
-->

- 修正の説明を行います。

    1. **render**メソッドの第二引数に連想配列を渡すと、**twig**内で渡した変数の操作が可能となります。その際、連想配列のキーを元に変数操作を行います。

    1. 連想配列のキーは任意です。

### Twigの修正

- コントローラで連想配列で引き渡した変数の表示をTwigに追記します。

- 以下の様に修正します。

	- Tutorial/crud_top.twig

<script src="http://gist-it.appspot.com/https://github.com/EC-CUBE/ec-cube.github.io/blob/master/Source/tutorial_3/crud_top_add_var.twig"></script>

<!--
```
｛＃
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
＃｝
｛％ extends 'default_frame.twig' ％｝

｛％ set body_class = 'front_page' ％｝

｛％ block javascript ％｝
｛％ endblock ％｝

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">
                <h1>CRUDチュートリアル</h1>
                <p>投稿を行なってください</p>
                <dl>★追記
                    <dt>コントローラーから取得した変数です</dt>
                    <dd>｛｛ viewname ｝｝</dd>★変数呼び出し部
                </dl>
            </div>
        </div>
    </div>
｛％ endblock ％｝
```
-->

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

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. コントローラーで定義した変数の内容が表示されています。

---

![View変数のレンダリング](/images/img-tutorial3-view-rendar.png)

---

### 本章のまとめ

- 本章では以下を学びました。

    1. コントローラー内、renderメソッドへのView変数追加の方法を説明しました。

    1. Twigの変数表示を行いました。

    1. Twigのブロックの種類を説明しました。

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

<a href="http://qiita.com/poego/items/81628dcd0f8e4d4a2d9d" target="_blank">EC-CUBE 3のTwigのタグ覚え書き（一部EC-CUBE2系のSmarty比較）<a/>
