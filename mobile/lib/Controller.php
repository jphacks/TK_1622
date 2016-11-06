<?php
//Controller全てに共通する処理

namespace jigenji;

class Controller{

  //errorMessageの格納クラス
  private $_errors;
  // emailの格納クラス
  private $_values;


  public function __construct(){
    //CSRF対策用token_nameの生成
    if(!isset($_SESSION['token'])){
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    // オブジェクト型のデータをさっと作れる
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
  }


  //エラー格納用メソッド
  protected function setErrors($key, $error){
    // _errorsの$keyプロパティに $errorsを代入
    $this->_errors->$key = $error;
  }

  //エラー出力用メソッド
  public function getErrors($key){
    //errorを返す
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  //values格納用メソッド
  protected function setValues($key, $value){
    // __valuesの$keyプロパティに $errorsを代入
    $this->_values->$key = $value;
  }

  //values出力用メソッド
  public function getValues(){
    //$_valuesオブジェクトを返す
    return $this->_values;
  }



  // エラーが存在するか判定メソッド
  protected function hasError(){
    // 指定したオブジェクトのプロパティを取得する
    return !empty(get_object_vars($this->_errors));
  }

  protected function isLoggedIn(){
    // sessionにmeというkeyで値を保存
    //もしセッションのmeに変数がセットされていてかつからでなかったら
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  public function me(){
    return $this->isLoggedIn() ? $_SESSION['me'] : null;
  }


}
