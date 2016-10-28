<?php

define('DB_DATABASE', 'jp_data');
define('DB_USERNAME', 'jigenjisk');
define('DB_PASSWORD', '41567sk');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname='.DB_DATABASE);

class ReadMachine
{
  protected $db = null;

  function __construct(){
    try{
      $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  function __destruct(){
    try{
      $this->db = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
}

class UserReadMachine extends ReadMachine
{
  //userのポジションを返す("Yamashita")
  public function getHashPassword($userName){
    try{
      // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("select hashPassword from user_record where userName like :username");
      $stmt->execute([":username"=>$userName]);
      $results = $stmt->fetch(PDO::FETCH_ASSOC);
      // $this->db = null;
      return $results[0];

    } catch (PDOException $e) {
      error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
      return null;
      exit;
    }
  }
}


class DaysReadMachine extends ReadMachine
{
  //userのポジションを返す("Yamashita")
  public function getUserPosition($userName,$wardnumber=7){
    try{
      // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("select latitude, longitude from delivery_record_".$wardnumber." where userName like :username");
      $stmt->execute([":username"=>$userName]);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // $this->db = null;
      return $results[0];

    } catch (PDOException $e) {
      error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
      return null;
      exit;
    }
  }
}

// $Yam = new ReadMachine();
// $Yam->setUserTimeValue("Yamashita",0,3);
// // $Yam -> resisterUser("Yamashita",1,35.0,139.0);
// var_dump($Yam->getUserPosition("Yamashita"));



class ReadBundleMachine extends ReadMachine
{
  function __construct() {
    parent::__construct();
  }

  function __destruct(){
    parent::__destruct();
  }

  public function getUserPositionArray($name){
    $pos = parent::getUserPosition($name);
    $arr = array(
            "user" => $name,
            "lat" => $pos["latitude"],
            'lng' => $pos["longitude"]
          );
    return $arr;
  }
}

$Yam = new ReadBundleMachine();
// $Yam->setUserTimeValue("Yamashita",0,3);
// $Yam -> resisterUser("Yamashita",1,35.0,139.0);
var_dump($Yam->getUserPositionArray("Yamashita"));
