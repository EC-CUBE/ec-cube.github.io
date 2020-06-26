---
title: SameSite Cookie 対応
keywords: samesite
tags: [quickstart, getting_started]
permalink: hotfix_samesite_cookie
summary : EC-CUBE3系でのSameSite Cookieの対応方法について
---


### 概要
- 2020年2月にリリースされた Chrome 80 より、他サイトからEC-CUBEで構築されたサイトに遷移する場合に、条件によってはEC-CUBEのCookieが送信されなくなり、決済が完了しない等の現象が発生します。この問題に対応するために以下のHot-fixパッチを適用して頂く必要があります。

### 関連情報
- [Google Developers Japan: 新しい Cookie 設定 SameSite=None; Secure の準備を始めましょう](https://developers-jp.googleblog.com/2019/11/cookie-samesitenone-secure.html])
- [SameSite Updates - The Chromium Projects](https://www.chromium.org/updates/same-site)
- [Chrome80のSameSiteの影響で3Dセキュア等を利用する場合に購入に失敗する #4457](https://github.com/EC-CUBE/ec-cube/issues/4457)

### 更新
- 2020-06-25 更新
- 2020-02-13 作成

## Hot-fixパッチ

### __注意事項__
- 2020-02-13に公開したHot-fixパッチを適用している場合、[以下の手順](#2020-02-13に公開したhot-fixパッチの切り戻し手順)に従って切り戻しを行ってから適用してください。

### 修正内容
このパッチにより以下の修正が適用されます。

- 他サイトからPOSTされたときにもセッションキーを保持したCookieが送信されるように セッションキーのCookieに `SammeSite=None` を設定する。
- MacやiOSのsafariについては、`SammeSite=None`は付与されません。
- samesiteを有効にするには、管理画面の設定＞システム情報設定＞セキュリティ管理から、`SSL強制`を ON にする必要があります。

GitHub PR：[https://github.com/EC-CUBE/ec-cube3/pull/82](https://github.com/EC-CUBE/ec-cube3/pull/82)

### 適用方法

1.  `src/Eccube/Application.php` に以下の変更を適用する
    - [https://github.com/EC-CUBE/ec-cube3/pull/82/files#diff-f2c1693a4046ca58e8697fbf12d829c2](https://github.com/EC-CUBE/ec-cube3/pull/82/files#diff-f2c1693a4046ca58e8697fbf12d829c2)

### 2020-02-13に公開したHot-fixパッチの切り戻し手順

1.  `src/Eccube/Application.php` の以下の変更を切り戻す
    - [https://github.com/EC-CUBE/ec-cube3/compare/dd3017609..hotfix/samesite-cookie#diff-f2c1693a4046ca58e8697fbf12d829c2](https://github.com/EC-CUBE/ec-cube3/compare/dd3017609..hotfix/samesite-cookie#diff-f2c1693a4046ca58e8697fbf12d829c2)
1. 以下の2ファイルを削除する
    - [src/Eccube/EventListener/SameSiteCookieHotfixListener.php](https://raw.githubusercontent.com/EC-CUBE/ec-cube3/hotfix/samesite-cookie/src/Eccube/EventListener/SameSiteCookieHotfixListener.php)
    - [src/Eccube/Resource/template/default/error_samesite.twig](https://raw.githubusercontent.com/EC-CUBE/ec-cube3/hotfix/samesite-cookie/src/Eccube/Resource/template/default/error_samesite.twig)
