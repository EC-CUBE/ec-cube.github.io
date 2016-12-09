---
title: 外部Componentの利用
keywords: 外部Componentの利用 
tags: [collaboration, guideline]
sidebar: home_sidebar
permalink: collaboration_component
summary: EC-CUBE本体開発の流れはGitHub Flowに基づいています。
folder: collaboration
---

## 外部コンポーネント

### 選定基準

* できるだけ、テストが行われているものを利用する。
* ライブラリの採用時には事前に検討を行う。
* EC-CUBEの 3.0.X では基本的に外部ライブラリもAPIの変わらないバージョンを利用する。
* PEARを利用しているもので、SymfonyComponentに置き換えが可能なものは積極的に置き換える。

### 開発時には Composer による依存環境の解消を行う

* Composer を標準で採用し、autoloader も同様に Composer 付属のものを利用する。
