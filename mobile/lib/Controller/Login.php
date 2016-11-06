<?php
// publicのlogin.phpに対するController


namespace jigenji\Controller;

//親のControllerを継承
class Login extends \jigenji\Controller{
  public function run() {
    // もしログインしていなかったら

    if($this->isLoggedIn()) {
      //loginしていたらホームに飛ばす
      header('Location: ' . SITE_URL.'/index.php');
      exit;
    }

    //ログインを押された時の処理
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
    } catch (\jigenji\Exception\EmptyPost $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('login',$e->getMessage());
    }

    // メールアドレスを保持しておくためのメッソド
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
        $user = $userModel->login([
          'username' => $_POST['username'],
          'password' => $_POST['password']
        ]);
      }catch (\jigenji\Exception\UnmatchEmailOrPasssword $e) {
        $this->setErrors('login',$e->getMessage());
        return;
      }

      //login処理
      session_regenerate_id(true);
      $_SESSION['me'] = $user;
      // var_dump($_SESSION['me']);

      // redirect to login
      header('Location: '.SITE_URL.'/index.php');
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
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
      // エラーインスタンスを返す
      echo "Invalid Form";
      exit;
    }
    if ($_POST['username']==='' || $_POST['password']==='') {
      // からだったらを返す
      throw new \jigenji\Exception\EmptyPost();
    }
  }
}
