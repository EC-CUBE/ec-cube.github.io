<?php

namespace Plugin\ExampleTestPlugin\Tests\Service; ★テストファイルの名前空間を記述

use Eccube\Tests\EccubeTestCase;
use Plugin\ExampleTestPlugin\ServiceProvider\ExampleTestServiceProvider; ★テスト対象ファイルの名前空間定義

class ExampleServiceTest extends EccubeTestCase ★クラス名称を修正
{
    public function setUp() ★テスト開始時に行う処理があれば記述
    {
        parent::setUp();
    }

    /**
     * プラグインのインストール時間取得メソッド失敗パターンのテスト
     * ・インストールされていないコードをサービスに渡す
     * ・戻り値としてfalseが返却される
     */
    public function testGetPluginInstallDateFormatJaFromErrorCode() ★まず正常系エラーのメソッドを追記します
    {
        $errorCode = 'Test'; ★インストールされていないプラグインコードを設定
        $this->actual = $this->app['eccube.plugin.service.example']->getPluginInstallDateFormatJa($errorCode); ★取得値はactualに格納

        $this->assertFalse($this->actual); ★falseが返却される事を定義
    }

    /**
     * プラグインのインストール時間取得メソッド成功パターンのテスト
     * ・インストールされているコードをサービスに渡す
     * ・事前にメソッドと同じ条件でデーターベースからインストール日付を取得しておく
     * ・戻り値としてインストール日付が返却される
     */
    public function testGetPluginInstallDateFormatJaFromSuccessCode() ★次は正常系の正常値テストのメソッドを追記します
    {
        $successCode = 'ExampleTest'; ★今回インストールしたプラグインのコードを記述します

        $qb = $this->app['orm.em']->createQueryBuilder(); ★テスト対象のサービスで取得する値を手動で取得します。
        $qb->select('p.create_date')
            ->from('\Eccube\Entity\Plugin', 'p')
            ->where('p.code = :Code')
            ->setParameter('Code', $successCode);

        try {
            $date = $qb->getQuery()->getSingleResult();
            $this->expected = $date['create_date']->format('Y年m月d日 H時i分s秒'); ★比較値をexpectedに格納します
        } catch (\NoResultException $e) {
            throw new \NoResultException();
        }

        $this->actual = $this->app['eccube.plugin.service.example']->getPluginInstallDateFormatJa($successCode); ★取得値をactualに格納します

        $this->assertEquals($this->actual, $this->expected); ★actualとexpectedが同一である事を定義
    }
}
