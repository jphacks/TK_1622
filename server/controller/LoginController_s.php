<?php

require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';
require_once dirname(__FILE__).'/../json/tojson.php';


//jsonファイルの受け取り
$json_string = file_get_contents('php://input');

$jsonflag = new FlagTransJson($json_string);

try{
  // LIのクラスの作成!!

  if($jsonflag->getFlag() === "LI"){
    $usermachine = new UserRecordMachine();
    $deliverymachine = new DeliveryRecordMachine();
  }else{
    echo 401; //リクエストが違う
    throw new Exception('NOT RU');
  }

  // jsonファイルを取得
  $stack = $jsonflag->getFlagInstance();
 if($usermachine->serchUser($stack->getUsername()) === 0){
    echo 402;//ユーザがいない
    throw new Exception("deferrent passwprd");
  }

  // パスワードの確認　
  if(password_verify($stack->getPassword(),$usermachine->getHashPassword($stack->getUsername()))){
    $result = $deliverymachine->getUserDelivery($stack->getUsername());
    echo (ToJson::getJson($result)); //成功
  }else{
    echo 403;//ぱすわーどが違う
    throw new Exception("deferrent passwprd");
  }


} catch(Exception $e){
  // echo $e->getMessage();
  exit;
}
