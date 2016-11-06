<?php

ini_set('display_errors',1);


define('DB_DATABASE', 'jp_data');
define('DB_USERNAME', 'jigenjisk');
define('DB_PASSWORD', '41567sk');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname='.DB_DATABASE);

define('SITE_URL', 'http://www.jigenji.biz');


// 便利な関数達を読み込み
require_once(__DIR__.'/../lib/functions.php');

// ファイルを自動で読み込む関数を読み込み
require_once(__DIR__.'/autoload.php');


//サーバ側でクライアントの値を保存しておく, cookieはクライアント側に保存
//セッションIDはクライアント側にクッキー名"PHPSESSID"で保存
session_start();
