<?php

require_once './vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;

/**
 * selenium facebook-webdriver 実行のサンプル
 */
function demo()
{
    output(__LINE__,"selenium host",__METHOD__);
    // selenium
    $host = 'http://localhost:4444/wd/hub';
    output(__LINE__,"chromeDriver start",__METHOD__);
    // chrome ドライバーの起動
    $driver = RemoteWebDriver::create($host,DesiredCapabilities::chrome());
    output(__LINE__,"chromeDriver start",__METHOD__);
    // 指定URLへ遷移 (Google)
    $driver->get('https://www.google.co.jp/');
    // 検索Box
    $element = $driver->findElement(WebDriverBy::name('q'));
    // 検索Boxにキーワードを入力して
    $element->sendKeys('セレニウムで自動操作');
    // 検索実行
    $element->submit();
    output(__LINE__,"Serch Start",__METHOD__);

    // 検索結果画面のタイトルが 'セレニウムで自動操作 - Google 検索' になるまで10秒間待機する
    // 指定したタイトルにならずに10秒以上経ったら
    // 'Facebook\WebDriver\Exception\TimeOutException' がthrowされる
    $driver->wait(10)->until(
        WebDriverExpectedCondition::titleIs('セレニウムで自動操作 - Google 検索')
    );

    // セレニウムで自動操作 - Google 検索 というタイトルを取得できることを確認する
    if ($driver->getTitle() !== 'セレニウムで自動操作 - Google 検索') {
        throw new Exception('fail');
    }
    
    // キャプチャ
    $file = __DIR__ . '/' . __METHOD__ . "_chrome.png";
    $driver->takeScreenshot($file);

    // ブラウザを閉じる
    $driver->close();
}
/**
 * デバッグ出力メソッド
 */
function output($line,$msg="",$method=""){
    echo sprintf("%s:%s:%s",$line,$msg,$method) . PHP_EOL;
}
echo "==== Selenium Start ====" . PHP_EOL;
// 実行
demo();
echo "==== Selenium End ====" . PHP_EOL;