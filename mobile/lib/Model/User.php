<?php

namespace jigenji\Model;

//データベースとやりとりするためのモデル
// user_record table用　
class User extends \jigenji\Model {
  public function create($values){
    $userName = $values['username'];
    $hashPassword = password_hash(($values["password"]), PASSWORD_DEFAULT);
    $userId = password_hash(uniqid(rand(),1), PASSWORD_DEFAULT);
    $latitde = 35;
    $longitude = 135;
    $postal = $values['postal'];
    $prefecture = $values['prefecture'];
    $ward = $values['ward'];
    $address = $values['address'];
    $apartment = $values['apartment'];
    $phonenumber = $values['phonenumber'];


    $stmt = $this->db->prepare("insert into user_record (userName, userId, hashPassword, latitude, longitude, postal, prefecture, ward, address, apartment,phonenumber ,created) values (:userName, :userId, :hashPassword, :latitude, :longitude, :postal, :prefecture, :ward, :address, :apartment, :phonenumber,now())");
    $stmt->bindParam(":userName", $userName, \PDO::PARAM_STR);
    $stmt->bindParam(":userId", $userId, \PDO::PARAM_STR);
    $stmt->bindParam(":hashPassword", $hashPassword, \PDO::PARAM_STR);
    $stmt->bindParam(":latitude", $latitde, \PDO::PARAM_STR);
    $stmt->bindParam(":longitude", $longitude, \PDO::PARAM_STR);
    $stmt->bindParam(":postal", $postal, \PDO::PARAM_STR);
    $stmt->bindParam(":prefecture", $prefecture, \PDO::PARAM_STR);
    $stmt->bindParam(":ward", $ward, \PDO::PARAM_STR);
    $stmt->bindParam(":address", $address, \PDO::PARAM_STR);
    $stmt->bindParam(":apartment", $apartment, \PDO::PARAM_STR);
    $stmt->bindParam(":phonenumber", $phonenumber, \PDO::PARAM_STR);
    $res = $stmt->execute();
    // $stmt->execute([":userName"=>$userName,":userId"=>$userId, ":hashPassword"=>$hashPassword, ":latitude"=>$latitude, ":longitude"=>$longitude, ":postal"=>$postal, ":prefecture"=>$prefecture, ":ward"=>$ward, ":address"=>$address, ":apartment"=>$apartment, ":phonenumber"=>$phonenumber]);
    if($res===false){
      throw new \jigenji\Exception\DuplicateEmail();
    }
  }


  //ログインに関する処理
  public function login($values){
    $userName = $values['username'];
    $password = $values['password'];
    $stmt = $this->db->prepare("select * from user_record where userName like :userName");
    $stmt->bindParam(":userName", $userName, \PDO::PARAM_STR);
    $res = $stmt->execute();

    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    // もしユーザがいなかったら
    if(empty($user)){
      throw new \jigenji\Exception\UnmatchEmailOrPasssword();
    }
    //パスワードが違ったら
    if(!password_verify($password, $user->hashPassword)){
      throw new \jigenji\Exception\UnmatchEmailOrPasssword();
    }

    return $user;
  }


}
