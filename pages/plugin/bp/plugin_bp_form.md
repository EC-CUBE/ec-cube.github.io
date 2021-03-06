---
title: フォーム
keywords: plugin 
tags: [plugin]
sidebar: home_sidebar
permalink: plugin_bp_form
---


プラグインではフォームとしての扱い方は2種類存在しており、
- 既存のフォームに対しての拡張
- 新規フォームの作成

となります。新規フォームの作成については[フォームを表示してみよう](/tutorial-4)を参照してください。

### 既存のフォームに対しての拡張

EC-CUBE3.0.8までは`FormExtension`というイベントを使ってFormに対して拡張を行えましたが、  
3.0.9からは新たなイベントが用意されたため、そのイベントでフォームの拡張を行います。

```php
/* admin.product.edit.initialize */
public function onAdminProductEditInitialize(EventArgs $event)
{
    $builder = $event->getArgument('builder');
    $builder->add('nickname', 'text', array(
        'label' => 'テスト項目',
        'mapped' => false,
    ));
}
```

※`$builder->add('nickname' 'text', array(`の`nickname`部分に`plg_`とつけて定義するとテンプレートを拡張することなく画面にフォーム項目が表示されるようになります。  
詳しくは[フォームの追加と拡張フォームの追加と拡張](/guideline/plugin-form)を参照してください。


### フォームの入力チェックについて
イベントを使ってフォームの拡張を行うと、POST時のフォームチェックはEC-CUBE本体側にある  

```
if ($form->isSubmitted() && $form->isValid()) {
```

という処理で行われるようになります。そのため、プラグイン側での検証は不要になります。


### 拡張したフォームのDB保存処理
フォーム要素を追加したのであれば、POST時にDBに保存などの処理を行うことがよくあります。  
その場合、`complete`イベントにて処理を行いフォームで入力された値を処理する必要があります。

```php
/* admin.product.edit.complete */
public function onAdminProductEditComplete(EventArgs  $event)
{
    $form = $event->getArgument('form');

    $nickname = $form->get('nickname')->getData();

    $Profile = $this->app['xxxx.profile']->find(zzz);

    $Profile->setNickname($nickname);

    $this->app['orm.em']->persist($Profile);
    $this->app['orm.em']->flush($Profile);
}
```

プラグイン側でDBの登録/更新処理を行うことでフォームに拡張した項目が登録できます。

