---
title: Gitを用いた開発手順
keywords: Githubflow
tags: [collaboration, guideline]
sidebar: home_sidebar
permalink: collaboration_githubflow
summary: EC-CUBE本体開発の流れはGitHub Flowに基づいています。
folder: collaboration
---


## 開発スタイルの基盤

- EC-CUBE本体の開発はGitHub Flowにもとづいて行なっています。

    - 以下はGitHub Flowの説明です。
       - <a href="https://gist.github.com/Gab-km/3705015" target="_blank">GitHub Flow</a>

    - 以下はGitHub Flowの概念図の参考です。
       - <a href="http://qiita.com/tbpgr/items/4ff76ef35c4ff0ec8314" target="_blank">GitHub Flow 図解</a>

## Gitワークフロー概要

![ワークフロー概念図](/images/collaboration/git-work-flow.png)

## Gitワークフロー作業手順

- 以下にワークフロー概要図の番号に添って、操作方法を説明します。

### レポジトリのコピー ( 本家→個人 )

① まず本家のレポジトリをフォークします

 - <a href="https://github.com/EC-CUBE/ec-cube" target="_blank">本家のレポジトリ</a>で、右上のForkボタンをクリックします。


### ローカルレポジトリの構築

② フォークしたレポジトリをクローンします

- 自分のレポジトリからcloneします。

```
$ git clone https://github.com/[GitHubUser(ご自身のアカウント)]/ec-cube.git
```

- ブランチの状態を確認してみます。  
※gitコマンドを実行するために、事前にcloneしたリポジトリのディレクトリ直下に移動してください。  
例：`cd ec-cube`

```
$ git branch -a

* master
remotes/origin/HEAD -> origin/master
remotes/origin/master
```
- これでまずはソースコードをローカルに持ってきました。


③ 次に本家レポジトリの追従を行います。

③-① 本家が更新されても追従できるように、本家レポジトリをupstreamとして登録

```
$ git remote add upstream https://github.com/EC-CUBE/ec-cube.git
$ git remote -v
origin https://github.com/[GitHubUser(ご自身のアカウント)]/ec-cube.git (fetch)
origin https://github.com/[GitHubUser(ご自身のアカウント)]/ec-cube.git (push)
upstream https://github.com/EC-CUBE/ec-cube.git (fetch)
upstream https://github.com/EC-CUBE/ec-cube.git (push)
```

- originには自分のが、upstreamには本家が登録されてるのがわかります。

- この状態ではまだupstreamの情報を取得していないので一度fetchしておきます。

```
$ git fetch upstream
```

### 開発用ブランチの作成

③-② ローカルに開発用ブランチを作成

```
$ git checkout -b user_branch( 任意 ) upstream/master
```

GitHubの自分のレポジトリに反映

```
$ git push origin user_branch( 任意 )
```

- 開発する
	...

- 完了したらコミット

```
$ git add /path/to/file
$ git add /path/to/file
$ git commit -m "コメント"
```

④ 自分のレポジトリにプッシュ

```
$ git push origin admin_basis_point
```

### プルリクエストを送る

⑤プルリクを送る

- GitHubの自分のレポトリから、PullRequestする

### プルリクエストのマージ条件

- 以下がクリアされる事で本体の「Master」にマージされます。

	1. 開発者・コミッターのレビュー

	2. CIのチェック
		- Travis			 : ユニットテスト
		- AppVeyor		 : ユニットテスト( Win環境 )
		- Scritinizer	: 静的コード解析

### プルリクエストを送る際に行ってもらいたいこと

不要なコミットログはまとめてください。
対象は`git rebase`について把握している方ですので、必須ではありません。

- 以下のようなコミットを行った場合は、`112233445`から`334455667`はまとめてください。
```
$ git log --pretty=format:"%h - %an : %s"
334455667 - myself : 機能A修正
223344556 - myself : 機能A修正
112233445 - myself : 機能A追加
001122334 - other_user : 別ユーザーのコミット
```
`git rebase`を実行し、まとめてください。
```
$ git rebase -i 001122334
pick 112233445 機能A追加
squash 223344556 機能A修正
squash 334455667 機能A修正
```
以下のようになったらプルリクエストを上げてください。
```
$ git log --pretty=format:"%h - %an : %s"
445566778 - myself : 機能A追加
001122334 - other_user : 別ユーザーのコミット
$ git push origin master
$ ...
```

- ただし、コメントに対して修正を加えた場合は履歴がわかるようにするためにまとめすぎないようにしてください。
```
$ git log --pretty=format:"%h - %an : %s"
667788990 - myself : 修正に間違いがあったため修正
556677889 - myself : レビュー結果を反映
445566778 - myself : 機能A追加
001122334 - other_user : 別ユーザーのコミット
```
`445566778`のコミット後にプルリクエストを上げ、レビューされた内容を反映するために修正した場合、`556677889`と`667788990`はまとめますが、`445566778`はまとめないでください。

- マージ済みのコミットはまとめないでください。

### 参照元

- <a href="http://qiita.com/chihiro-adachi/items/f31c9d90b1bcc3553c20" target="_blank">EC-CUBE 3のメモ - GitHub/Git使い方 -</a>
