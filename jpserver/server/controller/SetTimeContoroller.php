<?php


require_once dirname(__FILE__).'/../database/RecordMachine.php';
require_once dirname(__FILE__).'/../json/fromjson.php';

//jsonファイルの受け取り
$json_string = file_get_contents('php://input');
$jsonflag = new FlagTransJson($json_string);

//
try
{
  // sendtimeの命令か確認
  if($jsonflag->getFlag() !== "ST"){
    echo 401;//リクエストが違う
    throw new Exception('NOT ST');
  }

  // SendTimeFromJsonインスタンスの生成
  $stack = $jsonflag->getFlagInstance();
  // user_recordを操作するインスタンスの生成　
  $usermachine = new UserRecordMachine();

  // もしユーザが登録されていなかったら
  if($usermachine->serchUser($stack->getUsername()) === 0){
    echo 402;//ユーザがいない
    throw new Exception("deferrent passwprd");
  }

  // パスワードが異なったら
  if(password_verify($stack->getPassword(),$usermachine->getHashPassword($stack->getUsername()))){
    $userrequest = new DeliveryRecordMachine();
    //スケージュールフラグ、スタートたいむ、エンドタイムの変更
    $result = $userrequest->setUserRequest($stack->getUsername(), $stack->getScheduleflag(), $stack->getStarttime(),$stack->getEndtime(),date("Y-m-d"));
    echo 100; //成功

  }else{
    echo 403;//ぱすわーどが違う
    throw new Exception("deferrent passwprd");
  }
} catch(Exception $e){
  exit;
}
