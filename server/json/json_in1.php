<?php

require_once(dirname(__FILE__)."/fromjson.php");

$json_string = file_get_contents('php://input'); ##今回のキモ

$jsontrans = new FlagTransJson($json_string);
$stack = $jsontrans->getFlagInstance();


if($jsontrans->getFlag() === "RU"){
  $some = $stack->getWard();
  error_log( "RU: ".$some,"3","/var/log/php/php_error.log");
}else if($jsontrans->getFlag() === "ST"){
  $some = $stack->getstartTime();
  error_log( "ST: ".$some,"3","/var/log/php/php_error.log");
}

echo $some;
// $decoded = json_decode($json_string,true);
// error_log("json_in1 decodeding file: ".$json_string."\n","3","/var/log/php/php_error.log");
// echo($decoded);

// if (json_last_error() === JSON_ERROR_NONE) {
//   error_log("json_in1 succeeded decode: ".json_encode($decoded)."\n","3","/var/log/php/php_error.log");
//   echo "success :".json_encode($decoded);
// }
// else {
//   error_log("json_in1 failed decode: ".json_last_error()."\n","3","/var/log/php/php_error.log");
//   echo "false";
//     // PHP 5.5以上はこちらがわかりやすい
//     // echo "エラーメッセージ: ".json_last_error_msg().PHP_EOL;
// }
