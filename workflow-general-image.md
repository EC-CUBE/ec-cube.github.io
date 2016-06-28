---
layout: default
title: 作業概念図
---

---

# 開発作業全体概要

![全体概要](/images/work-flow.png)

- 上の図がEC-CUBE 3開発で用いられているツールとワークフローです。

## 各ツールの主な役割

### 情報交換

- <a href="http://qiita.com/tags/EC-CUBE3" target="_blank">Qiita</a>
    - 開発時のTIPSなどを公開しています。
- <a href="https://gitter.im/" target="_blank">Gitter</a>
    - 開発者同士のコミュニケーションツールとして活用しています。
- <a href="https://github.com/EC-CUBE/ec-cube/issues" target="_blank">GitHubのIssues</a>
    - 「改善要望・実装アイデア・バグ報告」など、開発の核となる、情報が集まっています。

### バージョン管理

- <a href="https://github.com/" target="_blank">GitHub</a>
    - 前述した、Issuesでの情報共有のほか、ソースのバージョン管理・差分管理など、重要な役割を担います。

### 品質

- <a href="https://travis-ci.org/" target="_blank">Travis</a>
    - テストコードを指定した環境で、ユニットテストを行います。

- <a href="https://ci.appveyor.com/login" target="_blank">AppVeyor</a>
    - こちらはWindows環境テスト用のCIです。

- <a href="https://scrutinizer-ci.com/" target="_blank">Scrutinizer</a>
    - 静的コード解析を行います。
