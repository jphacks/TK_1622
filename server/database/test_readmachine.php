<?php

define('DB_DATABASE', 'jp_data');
define('DB_USERNAME', 'jigenjisk');
define('DB_PASSWORD', '41567sk');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname='.DB_DATABASE);

class ReadMachine
{
  protected $db = null;
  protected $dbusername;

  public function __construct(){
  }

  //ユーザ名、ユーザid,緯度,経度を登録
  public function resisterUser($userName, $userId, $latitude, $longitude)
  {
    try{
      $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("insert into delivery_record_6 (userName, userId, latitude, longitude ) values (:userName, :userId, :latitude, :longitude)");
      $stmt->execute([":userName"=>$userName,":userId"=>$userId,":latitude"=>$latitude,":longitude"=>$longitude]);
      echo "resistration success";
      $this->db = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //0時に値をセット("Yamashita,0,any")
  public function setUserTimeValue($userName, $time, $value)
  {
    try{
      $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("update delivery_record_6 set time0 = :value where userName = :userName");
      // $stmt->execute([":time"=>$time,":value"=>$value,":userName"=>$userName]);
      $stmt->execute([":value"=>$value,":userName"=>$userName]);
      $this->db = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //userのポジションを返す("Yamashita")
  public function getUserPosition($userName){
    try{
      $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("select latitude, longitude from delivery_record_6 where userName like :username");
      $stmt->execute([":username"=>$userName]);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // echo "get position success: ";
      $this->db = null;
      return $results[0];

    } catch (PDOException $e) {
      echo $e->getMessage();
      return null;
      exit;
    }
  }
}

// $Yam = new ReadMachine();
// $Yam->setUserTimeValue("Yamashita",0,3);
// $Yam -> resisterUser("Yamashita",1,35.0,139.0);
// var_dump($Yam->getUserPosition("Yamashita"));


// 引数は　"Yamashita",0
class ReadBundleMachine extends ReadMachine
{
  public function getUserPositionArray($name,$time){
    $pos = parent::getUserPosition($name);
    $arr = array(
            "user" => $name,
            "lat" => (float)$pos["latitude"],
            'lng' => (float)$pos["longitude"]
          );
    return $arr;
  }
}

// $Yam = new ReadBundleMachine("Yamashita",0);
// // // $Yam->setUserTimeValue("Yamashita",0,3);
// // // $Yam -> resisterUser("Yamashita",1,35.0,139.0);
// var_dump($Yam->getUserPositionArray("Yamashita",0));
