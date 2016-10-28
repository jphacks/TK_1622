<?php


class ToJson
{

  function __construct(){
  }

  static public function getJson($arr){
    header("Content-Type: application/json; charset=UTF-8");
    return json_encode($arr,JSON_UNESCAPED_UNICODE);
  }

}
