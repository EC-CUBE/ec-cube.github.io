---
layout: default
title: コントローラーからビューを表示してみよう
---

---

# コントローラーからビューを表示してみよう


## ビューのレンダリング

- 前章でルーティングの設定が完了しました。

- 本章では、作成したルーティングに対してビューを表示してみましょう。

### コントローラーの作成

#### フォルダの作成

- まずは以下フォルダを作成してください。

1. /src/Eccube/Controller/CookBook
    - フォルダ毎で関連機能のコントローラーをまとめます。
    - 作成方法はそれぞれの環境で異なると思いますので、割愛いたします。
    - 以下の様にディレクトリを作成してください。

---

![フォルダの作成](/images/img-cookbook2-make-dir.png)

---

#### ファイルの作成

- 次にBbs.phpを作成します。

- TopControllerをコピー、リネームします。

- Bbs.php( 中身はTopController.phpのコピー )

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


namespace Eccube\Controller;★

use Eccube\Application;

class TopController★
{

    public function index(Application $app)
    {
        return $app->render('index.twig');★
    }
}
```

- 上記の「★」マークの箇所を下記に修正します。

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


namespace Eccube\Controller\CookBook;★フォルダのパスを追加

use Eccube\Application;

class Bbs★クラス名を修正
{

    public function index(Application $app)
    {
        echo 'First CookBook';☆追記
        exit();☆追記
        //return $app->render('index.twig');★一旦コメントアウト
    }
}
```

#### ルーティングの確認

- 一度確認のためにブラウザにアクセスしてみましょう。

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/cookbook/Bbs」を入力してください。

1. 次はエラーではなく、以下が表示されているはずです。

---

![エコーで文字表示](/images/img-cookbook2-echo-str.png)

---

- ルーティングの設定とコントローラーには問題がなさそうです。

### ビューの作成

- 以下フォルダにTwigファイルを追加します。

1. /src/Eccube/Resource/template/default/CookBook
		
    - フォルダ毎で関するコントローラーのビューをまとめます。
    - 作成方法はそれぞれの環境で異なるため、割愛します。
    - 以下の様にディレクトリを作成してください。

---

![ビューフォルダの作成](/images/img-cookbook2-make-dir.png)

---

#### ファイルの作成

- 次に、bbs_top.twigを作成します。

- index.twigをコピー、リネームします。

- bbs_top.twig( 中身はindex.twigのコピー )

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
<script>★
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
            <div class="main_visual">★
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
- 上記の「★」マークの箇所を下記に修正します。

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

｛％ block javascript ％｝☆<sctipt> ～ </script>を削除
｛％ endblock ％」

｛％ block main ％｝
    <div class="row">
       <div class="col-sm-12">
            <div class="main_wrap">☆ID名称を変更「main_visual」→「main_wrap」、「main_visual」内を削除し新しく内容を追記
                <h1>ご意見箱</h1>☆追記
                <p>みなさんのご意見をかきこんでください</p>☆追記
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


namespace Eccube\Controller\CookBook;

use Eccube\Application;

class Bbs
{

    public function index(Application $app)
    {
        return $app->render('CookBook/bbs_top.twig');☆修正箇所(コメント部と、echo、exitを削除)
    }
}
```

- 簡単な説明を行います。

1. 引数 : $app
    - $appにはEC-CUBEで用いるあらゆるクラスが格納されています。
    - 正しくはServiceProviderで設定した内容が、実行時にインスタンス化されて利用できる構造になっています。
    - ここでは詳細に解説は行いませんが、**「$app」からいろいろな機能を呼び出してアプリケーションを構築していく**とだけ覚えてください。

2. $app->render([表示したいTwigのパス])
    - 「render」にTwigのパスを引数として渡すと、対象のTwigが解析され、Htmlに変換されます。
    - 通常はコントローラーのメソッドの戻り値として、上記の様に記述すると設定したルーティングと、設定したファイルにもとづき、画面が表示されます。

#### 表示内容の確認	

- 最後に確認のためにブラウザにアクセスしてみましょう。

1. ブラウザのURLに「http://[ドメイン + インストールディレクトリ]/cookbook/Bbs」を入力してください。

1. Twigに記載した内容が表示されます。


	- ヘッダーやフッターが表示されていませんが、現状はそれで正しいです。
	- ヘッダーやフッターの表示設定は後で行います。

---

![twigで文字表示](/images/img-cookbook2-view-rendar.png)

---

#### 本章のまとめ

- 内容量も増えてきたので、章の内容をまとめておきます。
- 本章で以下を行いました。

	1. 既存コントローラーをコピーして新しいコントローラーを作成
	1. 既存Twigをコピーして新しいTwigを作成
	1. コントローラー・Twigともに、関連するフォルダにまとめる
	1. $appは各コントローラーのメソッドの引数として渡され、いろいろな機能が格納されている
	1. renderでTwigをhtmlに変換する