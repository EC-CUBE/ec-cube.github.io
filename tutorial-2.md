---
layout: default
title: コントローラーからビューを表示してみよう
---

---

# {{ page.title }}


## ビューのレンダリング

- 前章でルーティングの設定が完了しました。

- 本章では、作成したルーティングに対してビューを表示してみましょう。

### 本章メニュー

- 本章では以下を行います。

    1. コントローラーの作成とビューのレンダリング方法

    1. ビュー ( Twig ) の作成と役割

### コントローラーの作成

#### フォルダの作成

- まずは以下フォルダを作成してください。

1. /src/Eccube/Controller/Tutorial
    - 関連するコントローラーは一つのフォルダにまとめます。
    - 作成方法はそれぞれの環境で異なると思いますので、割愛いたします。
    - 以下の様にディレクトリを作成してください。

---

![フォルダの作成](/images/img-tutorial2-make-dir.png)

---

#### ファイルの作成

- 次に**CrudController.php**を作成します。

- TopControllerをコピー、リネームします。

- **CrudController.php**( 中身はTopController.phpのコピー )

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


namespace Eccube\Controller;

use Eccube\Application;

class TopController
{

    public function index(Application $app)
    {
        return $app->render('index.twig');
    }
}
```

- 下記の様に修正を行います。

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


namespace Eccube\Controller\Tutorial; ★フォルダのパスを追加
namespace Eccube\Controller\AbstractController; ★親コントローラーのパスを追加

use Eccube\Application;

class CrudController extends AbstractController ★クラス名を修正 + 親コントローラーを継承
{

    public function index(Application $app)
    {
        echo 'First Tutorial';★追記
        exit();★追記
        //return $app->render('index.twig');★一旦コメントアウト
    }
}
```

#### ルーティングの確認

- 一度確認のためにブラウザにアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. 次はエラーではなく、以下が表示されているはずです。

---

![エコーで文字表示](/images/img-tutorial2-echo-str.png)

---

- ルーティングの設定とコントローラーには問題がなさそうです。

### ビューの作成

- 以下フォルダにTwigファイルを追加します。

    1. /src/Eccube/Resource/template/default/Tutorial

        - 関係するコントローラーのビューをフォルダ毎にまとめます。
        - 作成方法はそれぞれの環境で異なるため、割愛します。
        - 以下の様にディレクトリを作成してください。

---

![ビューフォルダの作成](/images/img-tutorial2-make-dir.png)

---

#### ファイルの作成

- 次に、**crud_top.twig**を作成します。

- index.twigをコピー、リネームします。

- **crud_top.twig**( 中身はindex.twigのコピー )

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
<script>
$(function(){
    $('.main_visual').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        speed: 300
    });
});
</script>
｛％ endblock ％｝

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_visual">
                <div class="item">
                  <img src="{{ app.config.front_urlpath }}/img/top/mv01.jpg">
                </div>
                <div class="item">
                  <img src="{{ app.config.front_urlpath }}/img/top/mv02.jpg">
                </div>
                <div class="item">
                  <img src="{{ app.config.front_urlpath }}/img/top/mv03.jpg">
                </div>
            </div>
        </div>
    </div>
｛％ endblock ％｝
```
- 下記の様に修正を行います。

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

｛％ block javascript ％｝★<sctipt> ～ </script>を削除
｛％ endblock ％」

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">★ID名称を変更「main_visual」→「main_wrap」、「main_visual」内を削除し新しく内容を追記
                <h1>CRUDチュートリアル</h1> ★追記
                <p>投稿を行なってください</p> ★追記
            </div>
        </div>
    </div>
｛％ endblock ％｝
```

#### コントローラーの修正

- コントローラーで「echo」していた箇所を以下の内容に修正します。

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
namespace Eccube\Controller\AbstractController;

use Eccube\Application;

class CrudController extends AbstractController
{

    public function index(Application $app)
    {
        return $app->render('Tutorial/crud_top.twig');★修正箇所(コメント部と、echo、exitを削除)
    }
}
```

- コントローラーとメソッドについて簡単な説明を行います。



    1. 引数 : $app
        - $appにはEC-CUBEで用いるあらゆるクラスが格納されています。
        - 正しくはApplication.php/ServiceProviderで設定した内容が、実行時にインスタンス化されて利用できる構造になっています。
        - ここでは詳細に解説は行いませんが、**「$app」からいろいろな機能を呼び出してアプリケーションを構築していく**とだけ覚えてください。

    1. 名前空間 : use Eccube\Application;
        - 1.で説明した「$app」を利用するためには、クラスのスコープ外に必ず、名前空間を指定しなければなりません。
        - 簡単にいうと、コントローラーに利用するクラスの保管場所を教えてあげるという事です。
        - 名前空間で指定するパスは、使用するクラスによって変わりますが、「/src/Eccube」以下にあるクラスを利用する場合は、「Eccube」からの相対パスを指定してください。(先頭に「\\」は必要ありません)

    1. 名前空間 : use Eccube\Controller\AbstractControler;
        - コントローラーの親クラスを上記と同じ理由により設定いたします。

    1. $app->render([表示したいTwigのパス])
        - 「render」にTwigのパスを引数として渡すと、対象のTwigが解析され、htmlに変換されます。
        - 通常はコントローラーのメソッドの戻り値として、renderの戻り値をそのまま「return」すると、変換されたhtmlが返却され、画面が表示されます。
        - 「引数」として指定するパスは「/src/Eccube/Resource/template/」がルートパスとして設定されています。
        - ルートパスはApplication.phpの初期化が終わった時点で設定されます。
        - 管理者側のコントローラーであれば、上記フォルダの「/admin/」が対象、ユーザー画面であれば「/default/」がルートフォルダになります。

#### 表示内容の確認

- 最後に確認のためにブラウザにアクセスしてみましょう。

    1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/tutorial/crud」を入力してください。

    1. Twigに記載した内容が表示されます。


	- ヘッダーやフッターが表示されていませんが、現状はこれで正しい状態です。
	- ヘッダーやフッターの表示設定は後で行います。

---

![twigで文字表示](/images/img-tutorial2-view-rendar.png)

---

### 本章のまとめ

- 内容量も増えてきたので、章の内容をまとめておきます。
- 本章で以下を行いました。

	1. 既存コントローラーをコピーして新しいコントローラーを作成
	1. 既存Twigをコピーして新しいTwigを作成
	1. コントローラー・Twigともに、関連するフォルダにまとめる
	1. $appは各コントローラーのメソッドの引数として渡され、いろいろな機能が格納されている
	1. renderでTwigをhtmlに変換しメソッドの戻り値とする事で画面が描画される
