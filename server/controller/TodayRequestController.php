<?php


require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';
require_once dirname(__FILE__).'/../json/tojson.php';


//jsonファイルの受け取り
$json_string = file_get_contents('php://input');
$jsonflag = new FlagTransJson($json_string);

//
try
{
  // sendtimeの命令か確認
  if($jsonflag->getFlag() !== "SR"){
    echo 401;//リクエストが違う
    throw new Exception('NOT SR');
  }

  // SendTimeFromJsonインスタンスの生成
  $stack = $jsonflag->getFlagInstance();
  // user_recordを操作するインスタンスの生成　
  $usermachine = new UserRecordMachine();
  $deliverymachine = new DeliveryRecordMachine();

  // もしユーザが登録されていなかったら
  if($usermachine->serchUser($stack->getUsername()) === 0){
    echo 402;//ユーザがいない
    throw new Exception("deferrent passwprd");
  }
  
  $result = $deliverymachine->getTodayDelivery($stack->getUsername());
  echo (ToJson::getJson($result));
  // echo json_encode($result);
} catch(Exception $e){
  exit;
}
