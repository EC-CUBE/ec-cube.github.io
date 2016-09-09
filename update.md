---
layout: default
title: バージョンアップ方法
---

---

# EC-CUBE本体のバージョンアップ

EC-CUBE本体のバージョンアップ手順について記載します。  

## ご注意
- 本番環境でバージョンアップを行う前に、テスト環境で事前検証を必ず行ってください。
- この手順では、ec-cube.netからダウンロードしたEC-CUBEのパッケージを利用していることを想定しています。
- EC-CUBE本体のコード(src,htmlディレクトリ)をカスタマイズしている場合、ファイルが上書きされてしまうため、この手順ではバージョンアップできません。[各バージョンでの変更差分](#link13)を確認して必要な差分を取り込んでください。

## 作業の流れ
1. サイトのバックアップ
2. 共通ファイル差し替え
3. 個別ファイル差し替え
4. マイグレーション
5. テンプレートファイルの更新
6. 不要ファイルの削除


## 手順詳細
### 1. サイトのバックアップ

EC-CUBEのインストールディレクトリ以下をすべてバックアップしてください。

### 2. 共通ファイル差し替え

`src` `html` `vendor`ディレクトリを最新のファイルですべて上書きしてください。
```
[root]
  │
  ├──[src]
  ├──[html]
  ├──[vendor]
  │
```

### 3. 個別ファイル差し替え

対象となるバージョンごとに、個別のファイル差し替えが必要です。  
下記から差し替え対象ファイルを確認して最新のファイルで上書きしてください。

| バージョンアップ対象 | 差し替え対象ファイル                                                                              |
|----------------------|---------------------------------------------------------------------------------------------------|
| 3.0.2 → 3.0.3        | なし                                                                                              |
| 3.0.3 → 3.0.4        | なし                                                                                              |
| 3.0.4 → 3.0.5        | autoload.php                                                                                      |
| 3.0.5 → 3.0.6        | なし                                                                                              |
| 3.0.6 → 3.0.7        | なし                                                                                              |
| 3.0.7 → 3.0.8        | なし                                                                                              |
| 3.0.8 → 3.0.9        | app/console <br> cli-config.php <br> composer.json <br> composer.lock <br> eccube_install.sh      |
| 3.0.9 → 3.0.10       | autoload.php                                                                                      |
| 3.0.10 → 3.0.11      | 準備中                                                                                            |

※ `3.0.8 → 3.0.10` のように複数バージョンをまたぐバージョンアップを行う場合は、`3.0.8 → 3.0.9`→`3.0.9 → 3.0.10` のように段階的なバージョンアップを行ってください。

### 4. マイグレーション
マイグレーション機能を利用して、データベースのバージョンアップを行います。  
  
`http://インストール先/install.php/migration`  
にアクセスするとマイグレーション画面が表示されますので、ページの指示に従ってマイグレーションを行ってください。

### 5. テンプレートファイルの更新
対象となるバージョンごとに、テンプレートファイル(twig)の更新が必要です。  
管理画面のコンテンツ管理から、該当するページ/ブロックを編集してください。  

#### 3.0.10 → 3.0.11

| 編集対象                                                         | 変更差分 |
|------------------------------------------------------------------|----------|
| 商品詳細ページ(Product/detail.twig)                              | ・javascriptコードの追加 【[追加差分](https://github.com/EC-CUBE/ec-cube/blob/92d4043993b89ffb85611e7ba889d53fef9a59d2/src/Eccube/Resource/template/default/Product/detail.twig#L79-L81)】 <br> ・idの変更 【[変更前](https://github.com/EC-CUBE/ec-cube/blob/3.0.10/src/Eccube/Resource/template/default/Product/detail.twig#L219)】【[変更後](https://github.com/EC-CUBE/ec-cube/blob/92d4043993b89ffb85611e7ba889d53fef9a59d2/src/Eccube/Resource/template/default/Product/detail.twig#L222)】 |
| MYページ/お気に入り一覧(Mypage/favorite.twig)                    | ・twigのfor構文の変更 【[変更前](https://github.com/EC-CUBE/ec-cube/blob/3.0.10/src/Eccube/Resource/template/default/Mypage/favorite.twig#L40)】【[変更後](https://github.com/EC-CUBE/ec-cube/blob/7ba6375726065631803a82465f62f9ca48875d70/src/Eccube/Resource/template/default/Mypage/favorite.twig#L40-L41)】|

### 6. 不要ファイルの削除

アップデート後は以下のファイルを必ず削除してください。

- html/install.php
- html/index_dev.php (開発用途で使用する場合は残す)

EC-CUBEのバージョンアップ手順は以上です。


## 各バージョンでの変更差分

バージョンごとの詳細な変更差分は、以下のリンク先で確認することができます。

| バージョン      | 差分ページ                                                                                                             |
|-----------------|------------------------------------------------------------------------------------------------------------------------|
| 3.0.2 → 3.0.3   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.2...3.0.3](https://github.com/EC-CUBE/ec-cube/compare/3.0.2...3.0.3)   |
| 3.0.3 → 3.0.4   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.3...3.0.4](https://github.com/EC-CUBE/ec-cube/compare/3.0.3...3.0.49)  |
| 3.0.4 → 3.0.5   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.4...3.0.5](https://github.com/EC-CUBE/ec-cube/compare/3.0.4...3.0.5)   |
| 3.0.5 → 3.0.6   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.5...3.0.6](https://github.com/EC-CUBE/ec-cube/compare/3.0.5...3.0.6)   |
| 3.0.6 → 3.0.7   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.6...3.0.7](https://github.com/EC-CUBE/ec-cube/compare/3.0.6...3.0.7)   |
| 3.0.7 → 3.0.8   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.7...3.0.8](https://github.com/EC-CUBE/ec-cube/compare/3.0.7...3.0.8)   |
| 3.0.8 → 3.0.9   | [https://github.com/EC-CUBE/ec-cube/compare/3.0.8...3.0.9](https://github.com/EC-CUBE/ec-cube/compare/3.0.8...3.0.9)   |
| 3.0.9 → 3.0.10  | [https://github.com/EC-CUBE/ec-cube/compare/3.0.9...3.0.10](https://github.com/EC-CUBE/ec-cube/compare/3.0.9...3.0.10) |
| 3.0.10 → 3.0.11 | 準備中                                                                                                                 |
