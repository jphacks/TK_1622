<?php


require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';


//jsonファイルの受け取り
$json_string = file_get_contents('php://input');

$jsonflag = new FlagTransJson($json_string);

try{
  if($jsonflag->getFlag() === "RU"){
    $usermachine = new UserRecordMachine();
    $daysmachine = new DaysRecordMachine();
  }else{
    echo 401; //リクエストが違う
    throw new Exception('NOT RU');
  }
  $stack = $jsonflag->getFlagInstance();
  if($usermachine->checkUser($stack->getUsername()) === false){
    echo 402; //同一ユーザがいる
    throw new Exception('same username exists');
  }

  $reflag = $usermachine->resisterUser($stack->getUsername(),$stack->getUserId(),$stack->getHashPassword(),$stack->getLat(),$stack->getLng(),$stack->getPostal(),$stack->getPrefecture(),$stack->getWard(),$stack->getAddress(),$stack->getApartment(),$stack->getPhonenumber());
  if($reflag !== true){
    throw new Exception('resisterの登録ができなかった');
  }


  $deflag = $daysmachine->resisterUser($stack->getUsername(),$stack->getUserId(),$stack->getLat(),$stack->getLng());
  if($deflag !== true){
    throw new Exception('daysの登録ができなかった');
  }

  echo 100;
} catch(Exception $e){
  // echo $e->getMessage();
  exit;
}
