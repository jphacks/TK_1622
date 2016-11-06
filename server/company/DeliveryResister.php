<?php

require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';


//jsonファイルの受け取り
$json_string = file_get_contents('php://input');

$jsonflag = new FlagTransJson($json_string);

try{
  if($jsonflag->getFlag() === "CRD"){
    $usermachine = new UserRecordMachine();
    $deliverymachine = new DeliveryRecordMachine();
  }else{
    echo 401; //リクエストが違う
    throw new Exception('NOT CRD');
  }

  // jsonファイルを取得
  $stack = $jsonflag->getFlagInstance();

  // ユーザが存在するか確認

 if($usermachine->serchUser($stack->getDeliverynumber()) === false){
    echo 402;//ユーザがいない
    throw new Exception("deferrent password");
  }

// var_dump($stack->getUsername());
// var_dump($stack->getDeliverynumber());

if($deliverymachine->checkDeliveryNumber($stack->getDeliverynumber(),$stack->getCompanyflag()) === false){
   echo 403;//同一商品情報がある
   throw new Exception("same delivery exists");
 }



  // ここに製品登録方法を記載　
  $reflag = $deliverymachine->resisterDelivery($stack->getUsername(),$stack->getDeliverynumber(),$stack->getCompanyflag(),$stack->getDeliveryname(),$stack->getScheduledday());

  if($reflag !== true){
    echo 404;
    throw new Exception('resisterの登録ができなかった');
  }
  echo '100';



} catch(Exception $e){
  // echo $e->getMessage();
  exit;
}
