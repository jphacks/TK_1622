<?php

require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';


//jsonファイルの受け取り
$json_string = file_get_contents('php://input');

$jsonflag = new FlagTransJson($json_string);

try{
  if($jsonflag->getFlag() === "CDD"){
    $usermachine = new UserRecordMachine();
  }else{
    echo 401; //リクエストが違う
    throw new Exception('NOT CDD');
  }

  // jsonファイルを取得
  $stack = $jsonflag->getFlagInstance();

  // 配達が存在するか
 if($usermachine->serchUser($stack->getUsername()) === false){
    echo 402;//ユーザがいない
    throw new Exception("not exist");
  }
  



  // ここに製品削除方法を記載　
  // $reflag = $usermachine->resisterUser($stack->getUsername(),$stack->getUserId(),$stack->getHashPassword(),$stack->getLat(),$stack->getLng(),$stack->getPostal(),$stack->getPrefecture(),$stack->getWard(),$stack->getAddress(),$stack->getApartment());
  // if($reflag !== true){
  //   throw new Exception('resisterの登録ができなかった');
  // }



  echo 100;
} catch(Exception $e){
  // echo $e->getMessage();
  exit;
}
