<?php
// publicのsignup.phpに対するController


namespace jigenji\Controller;

//親のControllerを継承
class Signup extends \jigenji\Controller{
  public function run() {
    // もしログインしていなかったら

    if($this->isLoggedIn()) {
      //loginしていたらホームに飛ばす
      header('Location: ' . SITE_URL.'/index.php');
      exit;
    }

    //新規登録を押された時の処理
    //このファイルにpostによって入ったら
    //不正に外部からこのプログラムに入ることを禁止する
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  //postが送信された時のメソッド
  protected function postProcess() {
    //　入力内容のチェック
    try {
      $this->_validate();

    // Emailエラーが出たら、error文を保存
    } catch (\jigenji\Exception\InvalidEmail $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('username',$e->getMessage());

    // Passwordエラーが出たら
    } catch (\jigenji\Exception\InvalidPassword $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('password',$e->getMessage());
    }

    // ユーザネームを保持しておくためのメッソド
    $this->setValues('username',$_POST['username']);


    // echo "success";
    // exit;

    //もし何かしらのエラーが存在したら、強制終了
    if($this->hasError()){
      return;//mainで終了

    }else{ //もしエラーがなかったら
      // create user
      // ユーザを登録
      try{
        // user_recordとやりとりするモデル
        $userModel = new \jigenji\Model\User();
        $userModel->create([
          'username' => $_POST['username'],
          'password' => $_POST['password'],
          'postal' => "113-0021",
          'prefecture' => "東京都",
          'ward' => "文京区",
          'address' => "本駒込3-13-10",
          'apartment' => "パインハイム203号",
          'phonenumber' => "09055557777"
        ]);
      }catch (\jigenji\Exception\DuplicateEmail $e) {
        $this->setErrors('username',$e->getMessage());
        return;
      }
      // redirect to login
      header('Location: '.SITE_URL.'/login.php');
      exit;
    }



  }

  // 記入値の検証メソッド
  private function _validate() {
    // 渡ってきたメールアドレスがおかしいかをfilter_varで判断
    //書式が正しくなかったら
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
      echo "Invalid Token!";
      exit;
    }
    if (($_POST['username'] == '')) {
      // エラーインスタンスを返す
      throw new \jigenji\Exception\InvalidEmail();
    }

    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      // パスワードのエラーインスタンスを返す
      throw new \jigenji\Exception\InvalidPassword();
    }
  }
}
