<?php

define('DB_DATABASE', 'jp_data');
define('DB_USERNAME', 'jigenjisk');
define('DB_PASSWORD', '41567sk');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname='.DB_DATABASE);

class UsersRecordMachine
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

  //ユーザ名、ユーザid,緯度,経度を登録
  public function resisterUser($userName, $userId, $latitude, $longitude)
  {
    try{
      // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $this->db->prepare("insert into delivery_record_6 (userName, userId, latitude, longitude ) values (:userName, :userId, :latitude, :longitude)");
      $stmt->execute([":userName"=>$userName,":userId"=>$userId,":latitude"=>$latitude,":longitude"=>$longitude]);
      echo "resistration success";
      // $this->db = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //0時に値をセット("Yamashita,0,any")
  public function setUserTimeValue($userId, $time, $value,$ward=6)
  {
    $str = "update delivery_record_".$ward;
    try{
      $stmt = $this->db->prepare($str." set time".$time." = :value where userId = :userId");
      // $stmt->bindParam(':str', $str, PDO::PARAM_STR);
      $stmt->bindParam(':value', $value, PDO::PARAM_INT);
      $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
      $stmt->execute();
      // $stmt->execute([":time"=>$time,":value"=>$value,":userName"=>$userName]);
      // $stmt->execute([":value"=>$value,":userName"=>$userName]);
      // $this->db = null;
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
  public function addUserTimeValue($userId, $select,$ward=6)
  {
    $str = "delivery_record_".$ward;
    try{
      for ($i=0; $i < 24; $i++) {
        //論理の評価は、入ってる数値を10進数だと思って、二進数に直す(勝手に二進数に直したら、その値からさらに2進数に直される2->10->1010)
        if(($select & pow(2,$i)) !== 0){
          $stmt = $this->db->prepare("update ".$str." set time".$i." = time".$i." + 1 where userId = :userId");
          $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
          $stmt->execute();
        }
      }

    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
  public function addUseAppDays($userId,$ward=6)
  {
    $str = "delivery_record_".$ward;
    try{
        $stmt = $this->db->prepare("update ".$str." set useAppDays = useAppDays + 1 where userId = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();

    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
  public function addTotalDelivaryDays($userId,$ward=6)
  {
    $str = "delivery_record_".$ward;
    try{
        $stmt = $this->db->prepare("update ".$str." set totalDeliveryDays = totalDeliveryDays + 1 where userId = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();

    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }


}


$Yam = new DaysRecordMachine();
// $Yam -> resisterUser("Yamashita",1,35.0,139.0);
// $Yam->appUserTimeValue("1",0b00000000000000000001);
$Yam->addTotalDelivaryDays(1);





// class ReadBundleMachine extends ReadMachine
// {
//   function __construct() {
//     parent::__construct();
//   }
//
//   public function getUserPositionArray($name){
//     $pos = parent::getUserPosition($name);
//     $arr = array(
//             "user" => $name,
//             "lat" => $pos["latitude"],
//             'lng' => $pos["longitude"]
//           );
//     return $arr;
//   }
// }

// $Yam = new ReadBundleMachine();
// // $Yam->setUserTimeValue("Yamashita",0,3);
// // $Yam -> resisterUser("Yamashita",1,35.0,139.0);
// var_dump($Yam->getUserPositionArray("Yamashita"));
