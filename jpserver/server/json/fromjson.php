<?php


// josnを連想配列に格納するクラス
class TransJson
{
  protected $decoded;

  function __construct($json_string){
    $this->decoded = json_decode($json_string,true);

    if (json_last_error() === JSON_ERROR_NONE) {
      error_log("Fromjson succeeded decode: "."\n","3","/var/log/php/php_error.log");
    }
    else {
      error_log("Fromjson failed decode: "."\n","3","/var/log/php/php_error.log");
      $this->decoded = null;
        // PHP 5.5以上はこちらがわかりやすい
        // echo "エラーメッセージ: ".json_last_error_msg().PHP_EOL;
    }

  }

  public function getFlag(){
    return $this->decoded["flag"];
  }

}


// 翻訳したjosnの連想配列に格納するクラス
class FromJArray
{
  protected $decoded;

  function __construct($decoded_value){
      $this->decoded = $decoded_value;
  }

  public function getFlag(){
    return $this->decoded["flag"];
  }

}



//基本的にこのクラスから各インスタンスを生成する
class FlagTransJson extends TransJson
{
  // 大元の情報(外部から参照不可)

  function __construct($json_string){
    parent::__construct($json_string);
  }


  function getFlagInstance(){
    switch (parent::getFlag()) {
    case "RU":
        return (new ResisterFromJson($this->decoded));
    case "ST":
        return (new SendTimeFromJson($this->decoded));
    case "LI":
        return (new LoginFromJson($this->decoded));
    case "SR":
        return (new UserRequestFromJson($this->decoded));
    case "CRD":
        return (new CompanyResisterFromJson($this->decoded));

    default:
        error_log( "fromjson>FlagTranJson:flag error\n","3","/var/log/php/php_error.log");
        return null;
    }
  }

}


//登録情報用json変換クラス(flag:RU)
class ResisterFromJson extends FromJArray
{
  // 大元の情報(外部から参照不可)
  private $userId;

  function __construct($json_string){
    parent::__construct($json_string);
    $this->userId = password_hash(uniqid(rand(),1), PASSWORD_DEFAULT);
    error_log( $this->userId,"3","/var/log/php/php_error.log");
    $post = ($this->decoded["prefecture"]).($this->decoded["address"]);
    $apiurl = "https://maps.googleapis.com/maps/api/geocode/json?address=";
    $this->json = json_decode(@file_get_contents($apiurl.$post),false);
    // echo "resister form created";
  }

  public function getUsername(){
    return $this->decoded["username"];
  }

  public function getPassword(){
    return $this->decoded["password"];
  }

  public function getHashPassword(){
    return password_hash(($this->decoded["password"]), PASSWORD_DEFAULT);
  }

  public function getUserId(){
    return $this->userId;
  }

  public function getPostal(){
    return $this->decoded["postal"];
  }

  public function getPrefecture(){
    return $this->decoded["prefecture"];
  }
  public function getPhonenumber(){
    return $this->decoded["phonenumber"];
  }


  //
  public function getWard(){
    $zipcode = $this->decoded["postal"];

    $dir = __DIR__ . '/zipcode';
    $zipcode = mb_convert_kana($zipcode, 'a', 'utf-8');
    $zipcode = str_replace(array('-','ー'),'', $zipcode);

    $result = array();

    $file = $dir . DIRECTORY_SEPARATOR . substr($zipcode, 0, 1) . '.csv';
    if(file_exists($file)){
        $spl = new SplFileObject($file);
        while (!$spl->eof()) {
            $columns = $spl->fgetcsv();
            if(isset($columns[0]) && $columns[0] == $zipcode){
                $result = array($columns[1], $columns[2], $columns[3]);
                break;
            }
        }
    }

    if(!empty($result)){
        return $result[1];
    } else {
        return 'Not Found';
    }

  }

  public function getAddress(){
    return $this->decoded["address"];
  }

  public function getApartment(){
    return $this->decoded["apartment"];
  }

  public function getLat(){
    if($this->json !== false){
      $lat = $this->json->results[0]->geometry->location->lat;
      return (float)$lat;
    }else{
      return null;
    }
  }

  public function getLng(){
    if($this->json !== false){
      $lng = $this->json->results[0]->geometry->location->lng;
      return (float)$lng;
    }else{
      return null;
    }
  }

}


// マップ用json変換クラス
class MapFromJson extends FromJArray
{
  private $json;
  function __construct($json_string){
    parent::__construct($json_string);
    $post = ($this->decoded["prefecture"]).($this->decoded["address"]);
    $apiurl = "https://maps.googleapis.com/maps/api/geocode/json?address=";
    $this->json = json_decode(@file_get_contents($apiurl.$post),false);
  }

  public function getLat(){
    if($this->json !== false){
      $lat = $this->json->results[0]->geometry->location->lat;
      return (float)$lat;
    }else{
      return null;
    }
  }

  public function getLng(){
    if($this->json !== false){
      $lng = $this->json->results[0]->geometry->location->lng;
      return (float)$lng;
    }else{
      return null;
    }
  }

}


// 顧客が送信した時間データ(flag:ST)
class SendTimeFromJson extends FromJArray
{
  private $json;
  function __construct($json_string){
    parent::__construct($json_string);
  }


  public function getUsername(){
    return $this->decoded["username"];
  }

  public function getPassword(){
    return $this->decoded["password"];
  }

  public function getHashPassword(){
    return password_hash(($this->decoded["password"]), PASSWORD_DEFAULT);
  }

  public function getScheduleflag(){
    return $this->decoded["scheduleflag"];
  }

  public function getDeliveryFlag(){
    return $this->decoded["deliveryflag"];
  }

  public function getStarttime(){
    return $this->decoded["starttime"];
  }

  public function getEndtime(){
    return $this->decoded["endtime"];
  }

}

class LoginFromJson extends FromJArray
{
  function __construct($json_string){
    parent::__construct($json_string);
  }

  public function getUsername(){
    return $this->decoded["username"];
  }

  public function getPassword(){
    return $this->decoded["password"];
  }

}

class CompanyResisterFromJson extends FromJArray
{
  function __construct($json_string){
    parent::__construct($json_string);
  }

  public function getUsername(){
    return $this->decoded["username"];
  }

  public function getDeliverynumber(){
    return $this->decoded["deliverynumber"];
  }

  public function getCompanyflag(){
    return $this->decoded["companyflag"];
  }

  public function getDeliveryname(){
    return $this->decoded["deliveryname"];
  }

  public function getScheduledday(){
    return $this->decoded["scheduledday"];
  }

  public function getScheduletime(){
    return $this->decoded["scheduletime"];
  }

  public function getWardnumber(){
    return $this->decoded["wardnumber"];
  }
}

class UserRequestFromJson extends FromJArray
{
  function __construct($json_string){
    parent::__construct($json_string);
  }

  public function getUsername(){
    return $this->decoded["username"];
  }

  public function getPassword(){
    return $this->decoded["password"];
  }

  public function getHashPassword(){
    return password_hash(($this->decoded["password"]), PASSWORD_DEFAULT);
  }

  public function getWardnumber(){
    return $this->decoded["wardnumber"];
  }
}
