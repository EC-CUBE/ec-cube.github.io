---
layout: default
title: アップデート方法
---

---

# アップデート方法

EC-CUBE3.0.2から導入されたマイグレーションを利用したバージョンアップの方法を解説します

開発時のマイグレーションの用意に関しては[マイグレーションガイド](/development/migration.html)をご参考ください

## 手順

- 以下のディレクトリを上書きする
    - src/
    - html/
    - vendor/
+ `http://インストール先/install.php/migration`にアクセスしマイグレーションを実行
+ `html/install.php`を削除

## 備考

* composer.jsonに変更がない場合vendor/の上書きは不要です
* composerが利用可能な環境の場合vendorの上書きではなく以下でも可能です

```
> php composer.phar self-update
```

* htmlやappディレクトリ以下に変更がある場合、別途反映頂く必要があります。

## 各バージョンでの変更差分

### 3.0.2→3.0.3

https://github.com/EC-CUBE/ec-cube/compare/3.0.2...3.0.3

### 3.0.3→3.0,4

https://github.com/EC-CUBE/ec-cube/compare/3.0.3...3.0.4