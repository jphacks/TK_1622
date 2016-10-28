<!DOCTYPE html >
<html>
<head>
  <title>書き込みマシン</title>
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

    function switchWard($wardname,$scale=1000){
        switch ($wardname) {
          case '千代田区':
            $lat = 35.694003;
            $lng = 139.753595;
            $ppl = (int)29393/$scale;
            return array(1,$lat,$lng,$ppl);
          case '中央区':
            $lat = 35.671034;
            $lng = 139.771861;
            $ppl = 74923/$scale;
            return array(2,$lat,$lng,$ppl);
          case '港区':
            $lat = 35.658456;
            $lng = 139.751599;
            $ppl = 132474/$scale;
            return array(3,$lat,$lng,$ppl);
          case '新宿区':
            $lat = 35.69608;
            $lng = 139.703549;
            $ppl = 198189/$scale;
            return array(4,$lat,$lng,$ppl);
          case '文京区':
            $lat = 35.710281;
            $lng = 139.752167;
            $ppl = 109314/$scale;
            return array(5,$lat,$lng,$ppl);
          case '台東区':
            $lat = 35.712607;
            $lng = 139.779996;
            $ppl = 105877/$scale;
            return array(6,$lat,$lng,$ppl);
          case '墨田区':
            $lat = 35.71294;
            $lng = 139.801497;
            $ppl = 133607/$scale;
            return array(7,$lat,$lng,$ppl);
          case '江東区':
            $lat = 35.675092;
            $lng = 139.81741;
            $ppl = 241052/$scale;
            return array(8,$lat,$lng,$ppl);
          case '品川区':
            $lat = 35.609604;
            $lng = 139.730186;
            $ppl = 200786/$scale;
            return array(9,$lat,$lng,$ppl);
          case '目黒区':
            $lat = 35.641846;
            $lng = 139.698171;
            $ppl = 147198/$scale;
            return array(10,$lat,$lng,$ppl);
          case '大田区':
            $lat = 35.561655;
            $lng = 139.716051;
            $ppl = 359776/$scale;
            return array(11,$lat,$lng,$ppl);
          case '世田谷区':
            $lat = 35.646972;
            $lng = 139.653247;
            $ppl = 448179/$scale;
            return array(12,$lat,$lng,$ppl);
          case '渋谷区':
            $lat = 35.662144;
            $lng = 139.704051;
            $ppl = 127587/$scale;
            return array(13,$lat,$lng,$ppl);
          case '中野区':
            $lat = 35.707792;
            $lng = 139.663835;
            $ppl = 185843/$scale;
            return array(14,$lat,$lng,$ppl);
          case '杉並区':
            $lat = 35.699933;
            $lng = 139.636438;
            $ppl = 299714/$scale;
            return array(15,$lat,$lng,$ppl);
          case '豊島区':
            $lat = 35.728331;
            $lng = 139.716605;
            $ppl = 161197/$scale;
            return array(16,$lat,$lng,$ppl);
          case '北区':
            $lat = 35.755021;
            $lng = 139.733481;
            $ppl = 178589/$scale;
            return array(17,$lat,$lng,$ppl);
          case '荒川区':
            $lat = 35.736446;
            $lng = 139.783369;
            $ppl = 105760/$scale;
            return array(18,$lat,$lng,$ppl);
          case '板橋区':
            $lat = 35.751533;
            $lng = 139.709244;
            $ppl = 279772/$scale;
            return array(19,$lat,$lng,$ppl);
          case '練馬区':
            $lat = 35.735623;
            $lng = 139.651658;
            $ppl = 344228/$scale;
            return array(20,$lat,$lng,$ppl);
          case '足立区':
            $lat = 35.775664;
            $lng = 139.804479;
            $ppl = 317001/$scale;
            return array(21,$lat,$lng,$ppl);
          case '葛飾区':
            $lat = 35.743946;
            $lng = 139.84718;
            $ppl = 213634/$scale;
            return array(22,$lat,$lng,$ppl);
          case '江戸川区':
            $lat = 35.708888;
            $lng = 139.868427;
            $ppl = 316606/$scale;
            return array(23,$lat,$lng,$ppl);
          default:
            return false;
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
      for($j=1;$j<=(2**$resultGauss);$j++){
        $binaryData += 0b00000000000000000000001;
      }
      return $binaryData;
    }

    function makeUserLatLng($lat,$lng){
      $latreturn = $lat + rand(0,10)/100;
      $lngreturn = $lng + rand(0,10)/100;
      $array = [$latreturn,$lngreturn];
      return $array;
    }
  }

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


  $Write = new RecordMachine();
  $Yam = new DaysRecordMachine();



// 初期設定
  $Writeswitch = false; //書き込みモードならtrueを、デモモードならfalseを代入。
  $area = "台東区";      //区指定
  $scale = 1000;         //世帯数のスケール(1000でマックス440個のデータ)
  $average = 15;         //Gaussの平均値（宅配時間指定について)
  $variance = 3.0;     //Gaussの分散(時間について)
// 初期設定



  $wardNumber = $Write->switchWard($area,$scale);
  if($Writeswitch){
    echo "これは書き込みモードです。";
    for($j=1;$j<=((int)$wardNumber[3]);$j++){
      $userNamesha1 = sha1(uniqid(rand(),1));
      $latlng = $Write->makeUserLatLng($wardNumber[1],$wardNumber[2]); //正確な緯度軽度取得
      $Yam -> resisterUser($userNamesha1,$j,$latlng[0],$latlng[1]);
      for($i=0;$i<30;$i++){
          $NumberfromGauss = $Write->generate_norm($average=15,$variance=2.0); //ガウス分布の値を戻り値
          $result = $Write->makeUserBinaryTime($NumberfromGauss);               //分布の値を元に時間を生成
          $Yam->addUserTimeValue($userNamesha1,$result);
          $Yam->addTotalDelivaryDays("userNamesha1");
          $Yam->addUseAppDays("userNamesha1");
      }
    }
  }
  else{
    // 確認用にechoを多数用いているが気にしないでbyYamashitaKeisuke
    echo "DemoMode!DemoMode!DemoMode!DemoMode!DemoMode!";
    echo nl2br("\n");
    echo nl2br("\n");
    echo "地区番号\t";
    echo $wardNumber[0];
    echo nl2br("\n");
    echo "正確な緯度\t";
    echo $wardNumber[1];
    echo nl2br("\n");
    echo "正確な経度\t";
    echo $wardNumber[2];
    echo nl2br("\n");
    echo "書き込み予定回数\t";
    echo (int)$wardNumber[3];
    echo nl2br("\n");
    for($k=0;$k<=((int)$wardNumber[3]);$k++){
      for($j=0;$j<=(rand(1,10));$j++){
        $userNamesha1 = sha1(uniqid(rand(),1));
        echo "UserName:\t";
        echo $userNamesha1;
        echo nl2br("\n");
        $latlng = $Write->makeUserLatLng($wardNumber[1],$wardNumber[2]); //正確な緯度軽度取得
        echo "乱数的な緯度\t";
        echo $latlng[0];
        echo nl2br("\n");
        echo "乱数的な経度\t";
        echo $latlng[1];
        echo nl2br("\n");
          for($i=0;$i<30;$i++){
            $NumberfromGauss = $Write->generate_norm($average,$variance); //ガウス分布の値を戻り値
            $result = $Write->makeUserBinaryTime($NumberfromGauss);               //分布の値を元に時間を生成
            echo "二進数的な時間\t";
            echo sprintf('%024d', decbin($result));
            echo nl2br("\n");
          }
        echo nl2br("\n");
    }
  }
}

//   $ward = RecordMachine::switchWard('台東区');
//   $latlng = $Yam->makeUserLatlLng($ward);
//   $binaryNumber = $Yam->makeUserBinaryTime($ward);
//   for($i=0;$i<=(rand(1,100));$i++){
//     $Yam -> resisterUser($userNamesha1,j,36.0,140.0);
//     $Yam->addUserTimeValue($userNamesha1,0b00001111111111110000);
//     $Yam->addTotalDelivaryDays($userNamesha1);
//     $Yam->addUseAppDays($userNamesha1);
//   }
  ?>

</body>
</html>
