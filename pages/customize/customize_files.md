---
title: カスタマイズ時に作成・変更するファイル
keywords: カスタマイズ時に作成・変更するファイル 
tags: [collaboration, guideline]
sidebar: home_sidebar
permalink: customize_files
summary: guideline_カスタマイズ時に作成・変更するファイル
folder: customize
---
---
## カスタマイズ時に作成・変更するファイル
{$Hoge}ページを作る場合

| 種別 | ファイル | 詳細 |
|------ |-----|------|
| ルーター | src\Eccube\ControllerPrivider\(Front or Admin)Controller\{$Hoge}Controller.php | ルーティングを追加・変更する |
| コントローラー | src\Eccube\Controller\{$Hoge}Controller.php  | リクエストを受けて、Viewを出し分けるロジックを書く、 ビジネスロジックをもたない |
| フォームビルダー・バリデーター | src\Eccube\Form\Type\{$Hoge}Type.php | フォーム項目とバリデーション定義を作成する |
| レポジトリ | src\Eccube\Repository\{$Hoge}Repository.php |  EntityRepositoryをextendsしたClassを定義しておく |
| エンティティ | src\Eccube\Entity\{$Hoge}.php | Setter/Getterを記述, DBスキーマと紐づくため、型の定義などをしっかり記述する|
| サービス | src\Eccube\Service\{$Hoge}Service.php | ビジネスロジックを書く ビジネスロジックはちゃんとしたOOPとなるように記述する |
| ビュー | src\Eccube\View\{$Hoge}.twig |  View |
| DIコンテナ定義 | src\Eccube\ServiceProvider\EccubeServiceProvider.php | 作成したForm\Typeを$app['form.types']に記述する, 利用するRepositoryを$app['eccube.repository.{$hoge}']としてDICにいれる |
