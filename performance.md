---
layout: default
title: EC-CUBE3 パフォーマンス
---

# {{ page.title }}

EC-CUBE3.0.11以降のバージョンではパフォーマンス対応を行います。

パフォーマンス対応の内容として、

- doctrineキャッシュの有効化
- 設定ファイルであるymlファイルのキャッシュ化
- FormEventの無効化
- 不要なテーブル結合の削除
- httpキャッシュの有効化

を行います。

#### 関連Issue

- [https://github.com/EC-CUBE/ec-cube/issues/1638](https://github.com/EC-CUBE/ec-cube/issues/1638)
- [https://github.com/EC-CUBE/ec-cube/issues/1673](https://github.com/EC-CUBE/ec-cube/issues/1673)
- [https://github.com/EC-CUBE/ec-cube/issues/1684](https://github.com/EC-CUBE/ec-cube/issues/1684)
- [https://github.com/EC-CUBE/ec-cube/issues/1686](https://github.com/EC-CUBE/ec-cube/issues/1686)


### パフォーマンス比較

以下のサーバに環境を用意しパフォーマンス比較を行いました。

- さくらのレンタルサーバ スタンダード [http://www.sakura.ne.jp/standard.html](http://www.sakura.ne.jp/standard.html){:target="_blank"}  
MySQL 5.5.38  
Apache 2.2.31  
PHP 5.6.24

- さくらのクラウド  
サーバプラン : 4 GB / 4 仮想コア  
HDD : 100 GB SSDプラン  
ディスクイメージ : CentOS7.2 64bit  
MySQL 5.6.32  
Apache 2.4.6  
PHP 7.0.9

#### さくらのレンタルサーバでの比較

- 条件  
デフォルトインストールされた状態のままでトップページをApache Bench(v2.3)で計測  
ab -n 100 -c 10 http://xxx.xxx.xxx/  
と別サーバから測定対象のサーバへ計測  

- 計測対象  
EC-CUBE3.0.10と3.0.11に含まれる予定のパフォーマンス対応、EC-CUBE2.13.5を計測  
→パフォーマンス対応の内容 : httpキャッシュ以外を含めたEC-CUBE3

- EC-CUBE3.0.10

```
ab -n 100 -c 10 http://xxx.xxx.xxx/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking xxx.xxx.xxx (be patient).....done


Server Software:        Apache/2.2.31
Server Hostname:        xxx.xxx.xxx
Server Port:            80

Document Path:          /
Document Length:        18455 bytes

Concurrency Level:      10
Time taken for tests:   47.783 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      1876200 bytes
HTML transferred:       1845500 bytes
Requests per second:    2.09 [#/sec] (mean)
Time per request:       4778.331 [ms] (mean)
Time per request:       477.833 [ms] (mean, across all concurrent requests)
Transfer rate:          38.34 [Kbytes/sec] received

Connection Times (ms)
min  mean[+/-sd] median   max
Connect:        9    9   0.8      9      16
Processing:  2307 4511 1289.4   4312    9921
Waiting:     1979 4352 1233.1   4197    9763
Total:       2316 4521 1289.4   4321    9930

Percentage of the requests served within a certain time (ms)
50%   4321
66%   4682
75%   4901
80%   5204
90%   6238
95%   7515
98%   8266
99%   9930
100%   9930 (longest request)
```

- EC-CUBE3パフォーマンス対応

```
ab -n 100 -c 10 http://xxx.xxx.xxx/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking xxx.xxx.xxx (be patient).....done


Server Software:        Apache/2.2.31
Server Hostname:        xxx.xxx.xxx
Server Port:            80

Document Path:          /
Document Length:        18915 bytes

Concurrency Level:      10
Time taken for tests:   32.931 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      1922200 bytes
HTML transferred:       1891500 bytes
Requests per second:    3.04 [#/sec] (mean)
Time per request:       3293.058 [ms] (mean)
Time per request:       329.306 [ms] (mean, across all concurrent requests)
Transfer rate:          57.00 [Kbytes/sec] received

Connection Times (ms)
min  mean[+/-sd] median   max
Connect:        9    9   0.6      9      14
Processing:  1138 3096 1129.1   2921    7474
Waiting:      898 2965 1110.9   2833    7213
Total:       1147 3105 1129.1   2929    7485

Percentage of the requests served within a certain time (ms)
50%   2929
66%   3302
75%   3678
80%   3733
90%   4473
95%   5501
98%   7154
99%   7485
100%   7485 (longest request)
```

- EC-CUBE2.13.5

```
ab -n 100 -c 10 http://xxx.xxx.xxx/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking xxx.xxx.xxx (be patient).....done


Server Software:        Apache/2.2.31
Server Hostname:        xxx.xxx.xxx
Server Port:            80

Document Path:          /
Document Length:        15163 bytes

Concurrency Level:      10
Time taken for tests:   14.899 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      1559100 bytes
HTML transferred:       1516300 bytes
Requests per second:    6.71 [#/sec] (mean)
Time per request:       1489.934 [ms] (mean)
Time per request:       148.993 [ms] (mean, across all concurrent requests)
Transfer rate:          102.19 [Kbytes/sec] received

Connection Times (ms)
min  mean[+/-sd] median   max
Connect:        9    9   0.7      9      15
Processing:   415 1381 573.9   1295    4349
Waiting:      381 1345 574.7   1268    4322
Total:        424 1391 573.9   1304    4358

Percentage of the requests served within a certain time (ms)
50%   1304
66%   1522
75%   1656
80%   1745
90%   2047
95%   2489
98%   3248
99%   4358
100%   4358 (longest request)
```

#### さくらのクラウドでの比較

- 条件  
デフォルトインストールされた状態のままでトップページをApache Bench(v2.3)で計測  
ab -n 100 -c 10 http://xxx.xxx.xxx/  
と別サーバから測定対象のサーバへ計測  

- 計測対象  
EC-CUBE3.0.10と3.0.11に含まれる予定のパフォーマンス対応(EC-CUBE2系はphp7で動作しないため割愛)  
→パフォーマンス対応の内容 : httpキャッシュ以外を含めたEC-CUBE3
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js"></script>
※opcacheとapcuもインストールして測定


- EC-CUBE3.0.10

```
ab -n 100 -c 10 http://xxx.xxx.xxx/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking xxx.xxx.xxx (be patient).....done


Server Software:        Apache/2.4.6
Server Hostname:        xxx.xxx.xxx
Server Port:            80

Document Path:          /
Document Length:        18623 bytes

Concurrency Level:      10
Time taken for tests:   2.760 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      1896100 bytes
HTML transferred:       1862300 bytes
Requests per second:    36.24 [#/sec] (mean)
Time per request:       275.950 [ms] (mean)
Time per request:       27.595 [ms] (mean, across all concurrent requests)
Transfer rate:          671.01 [Kbytes/sec] received

Connection Times (ms)
min  mean[+/-sd] median   max
Connect:        0    1   0.5      1       3
Processing:   117  257  56.4    251     412
Waiting:      115  254  56.9    247     410
Total:        117  258  56.4    252     413

Percentage of the requests served within a certain time (ms)
50%    252
66%    283
75%    292
80%    299
90%    336
95%    349
98%    408
99%    413
100%    413 (longest request)
```

- EC-CUBE3パフォーマンス対応

```
ab -n 100 -c 10 http://xxx.xxx.xxx/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking xxx.xxx.xxx (be patient).....done


Server Software:        Apache/2.4.6
Server Hostname:        xxx.xxx.xxx
Server Port:            80

Document Path:          /
Document Length:        18735 bytes

Concurrency Level:      10
Time taken for tests:   1.659 seconds
Complete requests:      100
Failed requests:        0
Write errors:           0
Total transferred:      1907300 bytes
HTML transferred:       1873500 bytes
Requests per second:    60.27 [#/sec] (mean)
Time per request:       165.930 [ms] (mean)
Time per request:       16.593 [ms] (mean, across all concurrent requests)
Transfer rate:          1122.52 [Kbytes/sec] received

Connection Times (ms)
min  mean[+/-sd] median   max
Connect:        0    1   2.2      1      22
Processing:    76  153  37.0    153     265
Waiting:       74  146  34.2    147     250
Total:         77  154  36.8    153     265

Percentage of the requests served within a certain time (ms)
50%    153
66%    168
75%    174
80%    183
90%    201
95%    221
98%    263
99%    265
100%    265 (longest request)
```


