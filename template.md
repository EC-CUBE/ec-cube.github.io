---
layout: default
title: テンプレートの探索順序
---

---

# テンプレートの探索順序

## 概要

EC-CUBE 3.0 では、デザインテンプレートのファイルを探す際に`render()`に渡されたファイルをいくつかのフォルダを順に探査し、該当するテンプレートファイルを発見次第、そのデザインテンプレートのファイルを利用する。
なお、Pluginによるデザインテンプレートへの介入は許容するが、完全な上書きは認めない

### 探査順

* フロント
  * デフォルトのtemplate_codeは`default`とする。

```
  1. app/template/[template_code]
  2. src/Eccube/Resource/template/default
  3. app/Plugin/[plugin_code]/Resource/template/[template_code]
```

* 管理画面
  * 管理画面のtemplate_codeは`admin`とする

```
1. app/template/admin
2. src/Eccube/Resource/template/admin
3. app/plugin/[plugin_code]/Resource/template/admin/[template_admin]
```

### 探査例

* フロントの例
デザインテンプレート名「MyDesign」を利用しており、Controllerで
`$app['view']->render('TemplateDir/template_name.twig');`  とされている場合

```
 1. app/template/MyDesign/TemplateDir/template_name.twig
 2. src/Eccube/Resource/template/default/TemplateDir/template_name.twig
 3. app/Plugin/[plugin_code]/Resource/template/TemplateDir/template_name.twig
```

* 管理画面の例
`$app['view']->render('Product/index.twig');`  とされている、商品マスターのテンプレートをカスタマイズし、app/以下においている。

```
 1. app/template/admin/product/index.twig
 2. src/Eccube/Resource/template/admin/product/index.twig
 3. app/Plugin/[plugin_code]/Resource/template/admin/product/index.twig
```

## 管理画面での編集時の挙動（ブロック編集やページ詳細）

現在利用しているテンプレートを読み込み。なければ標準(src/Eccube/Resource/template/default/以下のファイル）をもってきて、新たにapp/template/default/以下に保存

### 読み込み時の挙動イメージ

```
if (app/template/[template_code]/block/category.tpl) {
    read(app/template/[template_code]/block/category.tpl);
} else {
    read(src/Eccube/Resource/template/default/block/category.tpl)
}
```

### 保存時の挙動イメージ

save (app/template/[template_code]/block/category.tpl)

