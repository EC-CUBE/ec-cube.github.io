# EC-CUBE 3開発ドキュメント

github page of the [http://ec-cube.github.io/](http://ec-cube.github.io/)

EC-CUBE 3 の仕様や手順、開発Tipsに関するドキュメントを掲載しています。
修正や追記、新規ドキュメントの作成をいただく場合、本レポジトリへPullRequestをお送りください。


### 開発協力に関して

コードの提供・追加、修正・変更その他「EC-CUBE」への開発の御協力（Issue投稿、PullRequest投稿など、GitHub上での活動）を行っていただく場合には、
[EC-CUBEのコピーライトポリシー](https://github.com/EC-CUBE/ec-cube/blob/50de4ac511ab5a5577c046b61754d98be96aa328/LICENSE.txt)をご理解いただき、ご了承いただく必要がございます。
PullRequestを送信する際は、EC-CUBEのコピーライトポリシーに同意したものとみなします。

## 本ドキュメントサイトの構成について

github pageはJekyll Documentation themeを使っています。

windows環境の方は以下のURLを参考に環境を作成してください。
<a href="http://qiita.com/chihiro-adachi/items/99a82c902b4c8467aa4c" target="_blank">http://qiita.com/chihiro-adachi/items/99a82c902b4c8467aa4c</a>

Build the site to see the instructions for using it. Or just go here: [http://idratherbewriting.com/documentation-theme-jekyll/](http://idratherbewriting.com/documentation-theme-jekyll/)

## ローカル開発環境の構築

EC-CUBE 3開発ドキュメントはローカル開発環境を構築することにより、
ドキュメントを修正した場合にローカルPCで確認することができます。
Windows、Macの環境で動作確認済みです。


### 前提条件

1. ローカル環境にruby(バージョン：2.4.0以上)がインストールされている必要があります。
2. Windows環境の場合、Git Bash等のターミナルを利用して下さい。
3. ご自身のGithubアカウントが必要になります。

※ Rubyのバージョン確認方法

```
$ ruby -v
ruby 2.4.5p335 (2018-10-18 revision 65137) [x64-mingw32]
```

### 開発環境構築手順


#### ec-cube.github.ioをForkする

ec-cube.github.ioのリポジトリをご自身のGithubリポジトリにForkします。

#### 任意のディレクトリにクローンする

Forkしたご自身のリポジトリからソースを、`git clone` でローカルにコピーします。
```
$ git clone https://github.com/[ご自身のアカウント名]/ec-cube.github.io.git
```

#### リモートリポジトリに本家のリポジトリを登録する

本家のリポジトリの名前を`upstream`（任意）で登録します。

```
$ cd ec-cube.github.io/
$ git remote add upstream https://github.com/EC-CUBE/ec-cube.github.io.git
```

#### gem（rubyのライブラリ）のインストールを行う

`bundle install`により、gemfile.lockを元にgemのインストールを行います
。

```
$ bundle install
```

※ Windows環境では、gemfile.lockが更新されてしまいますが、git管理から無視するように下さい。（コミット対象から除外する）

```
eventmachine (1.2.7-x64-mingw32)
```
#### ローカルサーバーでサイトを立ち上げる

以下のコマンドでサイトが立ち上がります。

```
$ bundle exec jekyll serve
（省略）
Server address: http://127.0.0.1:4005
Server running... press ctrl-c to stop.
```

http://127.0.0.1:4005 にブラウザのURLでアクセスすると、
EC-CUBE 3開発ドキュメントのページが表示されます。

