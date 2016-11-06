<?php

require_once(__DIR__.'/../config/config.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
    echo "Invalid Token";
    exit;

  }
  //セッションをからにする
  $_SESSION = [];

  //クッキーにセッションの名前があったら
  if(isset($_COOKIE[session_name()])){
    // セッションネームのクッキーを過去日付にする
    setcookie(session_name(), '', time() - 86400, '/');
  }

  //
  session_destroy();

}


header('Location: '.SITE_URL);
