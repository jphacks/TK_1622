<!DOCTYPE html >
<html>
<head>
  <title>サンプル</title>
</head>
<body>
  <?php

  define('DB_DATABASE', 'jp_data');
  define('DB_USERNAME', 'jigenjisk');
  define('DB_PASSWORD', '41567sk');
  define('PDO_DSN', 'mysql:dbhost=localhost;dbname='.DB_DATABASE);

  class RecordMachine
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

    public static function switchWard($wardname){
      switch ($wardname) {
        case '千代田区':
          return 1;
        case '中央区':
          return 2;
        case '港区':
          return 3;
        case '新宿区':
          return 4;
        case '文京区':
          return 5;
        case '台東区':
          return 6;
        case '墨田区':
          return 7;
        case '江東区':
          return 8;
        case '品川区':
          return 9;
        case '目黒区':
          return 10;
        case '大田区':
          return 11;
        case '世田谷区':
          return 12;
        case '渋谷区':
          return 13;
        case '中野区':
          return 14;
        case '杉並区':
          return 15;
        case '豊島区':
          return 16;
        case '北区':
          return 17;
        case '荒川区':
          return 18;
        case '板橋区':
          return 19;
        case '練馬区':
          return 20;
        case '足立区':
          return 21;
        case '葛飾区':
          return 22;
        case '江戸川区':
          return 23;
        default:
          return false;
      }

    }

    // function makeUserBinaryTime($resultGauss){
      // $binaryData = 0b000000000000000000000000;
      // for($j=1;$j<=(2**(23-$resultGauss));$j++){
        // $binaryData += 0b00000000000000000000001;
      // }
      // return $binaryData;
    // }
  // }


  //user_recordテーブル用クラス
  class UserRecordMachine extends RecordMachine
  {
    function __construct(){
      parent::__construct();
    }

    function __destruct(){
      parent::__destruct();
    }


    //会員登録メソッド
    public function resisterUser($userName, $userId, $hashPassword, $latitude, $longitude, $postal=null, $prefecture=null, $ward=null, $address=null, $apartment=null,$wardnumber=6)
    {
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->db->prepare("insert into user_record (userName, userId, hashPassword, latitude, longitude, postal, prefecture, ward, address, apartment, created) values (:userName, :userId, :hashPassword, :latitude, :longitude, :postal, :prefecture, :ward, :address, :apartment, now())");
        $stmt->execute([":userName"=>$userName,":userId"=>$userId, ":hashPassword"=>$hashPassword, ":latitude"=>$latitude, ":longitude"=>$longitude, ":postal"=>$postal, ":prefecture"=>$prefecture, ":ward"=>$ward, ":address"=>$address, ":apartment"=>$apartment]);
        return true;
        // $this->db = null;
      } catch (PDOException $e) {
        return false;
      }
    }

    //同一ユーザが存在するかチェック
    public function checkUser($userName)
    {
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($this->serchUser($userName)){
          return false;
        }else{
          return true;
        }

      } catch (PDOException $e) {
        return false;
      }
    }


    //userのhashパスワードを返す関数
    public function getHashPassword($userName){
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->db->prepare("select hashPassword from user_record where userName like :username");
        $stmt->execute([":username"=>$userName]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        $results = $stmt->fetch();
        // $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        // $this->db = null;
        return $results->hashPassword;

      } catch (PDOException $e) {
        error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
        return false;
        exit;
      }
    }

    //userのhashパスワードを返す関数
    public function serchUser($userName){
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $this->db->prepare("select * from user_record where userName = :username");
        $stmt->execute([":username"=>$userName]);
        $results = count($stmt->fetchAll());


        return $results;

      } catch (PDOException $e) {
        error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
        return false;
        exit;
      }
    }

  }


  //Delivery_recordテーブル操作用のクラス　
  class DaysRecordMachine extends RecordMachine
  {
    function __construct(){
      parent::__construct();
    }

    function __destruct(){
      parent::__destruct();
    }
    //ユーザ名、ユーザid,緯度,経度を登録
    public function resisterUser($userName, $userId, $latitude, $longitude,$wardnumber=6)
    {
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $this->db->prepare("insert into delivery_record_".$wardnumber." (userName, userId, latitude, longitude ) values (:userName, :userId, :latitude, :longitude)");
        $stmt->execute([":userName"=>$userName,":userId"=>$userId,":latitude"=>$latitude,":longitude"=>$longitude]);
        return true;
        // $this->db = null;
      } catch (PDOException $e) {
        return false;
      }
    }

    //0時に値をセット("Yamashita,0,any")
    public function setUserTimeValue($userName, $time, $value,$wardnumber=6)
    {
      $str = "update delivery_record_".$wardnumber;
      try{
        $stmt = $this->db->prepare($str." set time".$time." = :value where userName = :userName");
        // $stmt->bindParam(':str', $str, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, PDO::PARAM_INT);
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->execute();
        // $stmt->execute([":time"=>$time,":value"=>$value,":userName"=>$userName]);
        // $stmt->execute([":value"=>$value,":userName"=>$userName]);
        // $this->db = null;
        return true;
      } catch (PDOException $e) {
        return false;
      }
    }

    //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
    public function addUserTimeValue($userName, $select,$wardnumber=6)
    {
      $str = "delivery_record_".$wardnumber;
      try{
        for ($i=0; $i < 24; $i++) {
          //論理の評価は、入ってる数値を10進数だと思って、二進数に直す(勝手に二進数に直したら、その値からさらに2進数に直される2->10->1010)
          if(($select & pow(2,$i)) !== 0){
            $stmt = $this->db->prepare("update ".$str." set time".$i." = time".$i." + 1 where userName = :userName");
            $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
            $stmt->execute();
          }
        }

      } catch (PDOException $e) {
        return false;
      }
    }

    //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
    public function addUseAppDays($userName,$wardnumber=6)
    {
      $str = "delivery_record_".$wardnumber;
      try{
          $stmt = $this->db->prepare("update ".$str." set useAppDays = useAppDays + 1 where userName = :userName");
          $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
          $stmt->execute();

      } catch (PDOException $e) {
        return false;
      }
    }

    //二進数で指定した時間の値を1つ増やすに値をセット("Yamashita,0,any")
    public function addTotalDelivaryDays($userName,$wardnumber=6)
    {
      $str = "delivery_record_".$wardnumber;
      try{
          $stmt = $this->db->prepare("update ".$str." set totalDeliveryDays = totalDeliveryDays + 1 where userName = :userName");
          $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
          $stmt->execute();

      } catch (PDOException $e) {
        return false;
      }
    }


    public function getUserPosition($userName,$wardnumber=6){
      try{
        $stmt = $this->db->prepare("select latitude, longitude from delivery_record_".$wardnumber." where userName like :username");
        $stmt->execute([":username"=>$userName]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "get position success: ";
        return $results[0];

      } catch (PDOException $e) {
        return false;
      }
    }


     public function getUsersValueArray($time,$wardnumber=6){
      try{
        if($time < 0 && $time > 25){
          throw new Exception('NOT RU');
        }
        $stmt = $this->db->prepare("select latitude, longitude, useAppDays, totalDeliveryDays,time".$time." from delivery_record_".$wardnumber);

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        // $results = $stmt->fetch();

        //ここにかさみ付けアルゴリヅムを書く
        //weigtはtime3に格納
        foreach ($results as $key => $value) {
          if($value["useAppDays"] > 0){
            $results[$key]["time".$time] = $value["time".$time]*$value["time".$time]/$value["useAppDays"];
            $results[$key]["latitude"] = (float)$results[$key]["latitude"];
            $results[$key]["longitude"] = (float)$results[$key]["longitude"];

          }
          unset($results[$key]["useAppDays"]);
          unset($results[$key]["totalDeliveryDays"]);
        }


        return $results;

      } catch (PDOException $e) {
        return false;
      }
    }


    public function getUserPositionArray($userName,$wardnumber=6){
      $pos = $this->getUserPosition($userName,$wardnumber);
      $arr = array(
              "user" => $userName,
              "lat" => (float)$pos["latitude"],
              'lng' => (float)$pos["longitude"]
            );
      return $arr;
    }

  }


  //delivery_?テーブル操作用のクラス
  class DeliveryRecordMachine extends RecordMachine
  {
    function __construct(){
      parent::__construct();

    }

    function __destruct(){
      parent::__destruct();
    }

    //新商品の追加
    public function resisterDelivery($userName, $deliverynumber, $companyflag, $deliveryname,$scheduledday, $scheduletime=null,$wardnumber=6)
    {
      try{
        // $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $this->db->prepare("insert into delivery_".$wardnumber." (userName, companyflag , deliverynumber, deliveryname,scheduledday, scheduletime) values (:userName, :companyflag, :deliverynumber,:deliveryname, :scheduledday, :scheduletime)");
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':companyflag', $companyflag, PDO::PARAM_INT);
        $stmt->bindParam(':deliverynumber', $deliverynumber, PDO::PARAM_INT);
        $stmt->bindParam(':deliveryname', $deliveryname, PDO::PARAM_STR);
        $stmt->bindParam(':scheduledday', $scheduledday, PDO::PARAM_STR);
        $stmt->bindParam(':scheduletime', $scheduletime, PDO::PARAM_STR);
        $stmt->execute();

        return true;
        // $this->db = null;
      } catch (PDOException $e) {
        return false;
      }
    }

    //userのhashパスワードを返す関数
    public function setCompanyRequest($userName,$deliverynumber,$companyflag,$scheduledday,$scheduletime=null,$wardnumber=6){
      try{
        $str = "delivery_".$wardnumber;

        $stmt = $this->db->prepare("update ".$str." set scheduledday = :scheduledday, scheduletime = :scheduletime where userName = :userName and deliverynumber = :deliverynumber and companyflag = :companyflag");
        $stmt->bindParam(':scheduledday', $scheduledday, PDO::PARAM_INT);
        $stmt->bindParam(':scheduletime', $scheduletime, PDO::PARAM_STR);
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':deliverynumber', $deliverynumber, PDO::PARAM_INT);
        $stmt->bindParam(':companyflag', $companyflag, PDO::PARAM_STR);
        $stmt->execute();
        return true;
        // $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        // $this->db = null;

      } catch (PDOException $e) {
        error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
        return false;
        exit;
      }
    }

    //userのhashパスワードを返す関数
    public function setUserRequest($userName,$scheduleflag,$starttime,$endtime,$today,$wardnumber=6){
      try{
        $str = "delivery_".$wardnumber;

        $stmt = $this->db->prepare("update ".$str." set scheduleflag = :scheduleflag, starttime = :starttime, endtime = :endtime  where userName = :userName and scheduledday = :today");
        $stmt->bindParam(':scheduleflag', $scheduleflag, PDO::PARAM_INT);
        $stmt->bindParam(':starttime', $starttime, PDO::PARAM_STR);
        $stmt->bindParam(':endtime', $endtime, PDO::PARAM_STR);
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':today', $today, PDO::PARAM_STR);
        $stmt->execute();
        return true;
        // $results = $stmt->fetchall(PDO::FETCH_ASSOC);
        // $this->db = null;

      } catch (PDOException $e) {
        error_log("readmachine>ReadMchine>getUserPosition: ".($e->getMessage())."\n","3","/var/log/php/php_error.log");
        return false;
        exit;
      }
    }
  }

    function generate_norm($average = 0.0, $variance = 1.0) {
        static $z1, $z2, $mt_max, $ready = true;
        if ($mt_max === null) {
            $mt_max = mt_getrandmax();
        }
        $ready = !$ready;
        if ($ready) {
            return $z2 * $variance + $average;
        }
        $u1 = mt_rand(1, $mt_max - 1) / $mt_max;
        $u2 = mt_rand(1, $mt_max - 1) / $mt_max;
        $v1 = sqrt(-2 * log($u1));
        $v2 = 2 * M_PI * $u2;
        $z1 = $v1 * cos($v2);
        $z2 = $v1 * sin($v2);
        return (float)($z1 * $variance + $average);
    }

  function makeUserBinaryTime($resultGauss){
    $binaryData = 0b000000000000000000000000;
    for($j=1;$j<=(2**(23-$resultGauss));$j++){
      $binaryData += 0b00000000000000000000001;
    }
    return $binaryData;
  }

  function switchWard($wardname){
      switch ($wardname) {
        case '千代田区':
          $lat = 35.694003;
          $lng = 139.753595;
          return array(1,$lat,$lng);
        case '中央区':
          $lat = 35.671034;
          $lng = 139.771861;
          return 2;
        case '港区':
          $lat = 35.658456;
          $lng = 139.751599;
          return 3;
        case '新宿区':
          $lat = 35.69608;
          $lng = 139.703549;
          return 4;
        case '文京区':
          $lat = 35.710281;
          $lng = 139.752167;
          return 5;
        case '台東区':
          $lat = 35.712607;
          $lng = 139.779996;
          return 6;
        case '墨田区':
          $lat = 35.71294;
          $lng = 139.801497;
          return 7;
        case '江東区':
          $lat = 35.675092;
          $lng = 139.81741;
          return 8;
        case '品川区':
          $lat = 35.609604;
          $lng = 139.730186;
          return 9;
        case '目黒区':
          $lat = 35.641846;
          $lng = 139.698171;
          return 10;
        case '大田区':
          $lat = 35.561655;
          $lng = 139.716051;
          return 11;
        case '世田谷区':
          $lat = 35.646972;
          $lng = 139.653247;
          return 12;
        case '渋谷区':
          $lat = 35.662144;
          $lng = 139.704051;
          return 13;
        case '中野区':
          $lat = 35.707792;
          $lng = 139.663835;
          return 14;
        case '杉並区':
          $lat = 35.699933;
          $lng = 139.636438;
          return 15;
        case '豊島区':
          $lat = 35.728331;
          $lng = 139.716605;
          return 16;
        case '北区':
          $lat = 35.755021;
          $lng = 139.733481;
          return 17;
        case '荒川区':
          $lat = 35.736446;
          $lng = 139.783369;
          return 18;
        case '板橋区':
          $lat = 35.751533;
          $lng = 139.709244;
          return 19;
        case '練馬区':
          $lat = 35.735623;
          $lng = 139.651658;
          return 20;
        case '足立区':
          $lat = 35.775664;
          $lng = 139.804479;
          return 21;
        case '葛飾区':
          $lat = 35.743946;
          $lng = 139.84718;
          return 22;
        case '江戸川区':
          $lat = 35.708888;
          $lng = 139.868427;
          return 23;
        default:
          return false;
      }
    }


  function makeUserLatLng($lat,$lng){
    $latreturn = $lat + rand(0,10)/1000;
    $lngreturn = $lng + rand(0,10)/1000;
    $array = [$latreturn,$lngreturn];
    var_dump($array);
    return $array;
  }

// for($j=0;$j<=(rand(1,10));$j++){
//   $userNamesha1 = sha1(uniqid(rand(),1));
//   $ward = RecordMachine::switchWard('台東区');
//   $latlng = $Yam->makeUserLatlLng($ward);
//   $binaryNumber = $Yam->makeUserBinaryTime($ward);
//   for($i=0;$i<=(rand(1,100));$i++){
//     $Yam -> resisterUser($userNamesha1,j,36.0,140.0);
//     $Yam->addUserTimeValue($userNamesha1,0b00001111111111110000);
//     $Yam->addTotalDelivaryDays($userNamesha1);
//     $Yam->addUseAppDays($userNamesha1);
//   }
// }
  $wardNumber = switchWard("千代田区");


  for($i=0;$i<30;$i++){
    echo $wardNumber[0];
    echo nl2br("\n");
    echo $wardNumber[1];
    echo nl2br("\n");
    echo $wardNumber[2];
    echo nl2br("\n");
    $latlng = makeUserLatLng($wardNumber[1],$wardNumber[2]);
    $latlngrand = makeUserLatLng($latlng[0],$latlng[1]);
    $NumberfromGauss = generate_norm($average=15,$variance=2.0);
    $result = makeUserBinaryTime($NumberfromGauss);
    echo sprintf('%024d', decbin($result));
    echo nl2br("\n");
}
  ?>

</body>
</html>
