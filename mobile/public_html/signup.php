<?php
//新規登録program

// ファイルの構造
// Signup Controller
// signup html



require_once(__DIR__.'/../config/config.php');


//名前空間のクラスを呼び出し
//Signupを仕切るコントローラの呼び出し
$app = new jigenji\Controller\Signup();

//
$app->run();


// echo "login screen";
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <title>Sign Up</title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body>
   <div id="login_container">

     <!-- 自分自身に送信:Signup.phpを読み込んでいるからそれが処理 -->
     <form action="" method="post" id="signup">
       <p>
         <input type="text" name="username" placeholder="user name" value="<?=
          isset($app->getValues()->username) ? h($app->getValues()->username) : ''; ?>">
       </p>
       <!-- htmlspecialcharsのfanction(libs/functionsに定義済み) -->
       <p>
         <input type="password" name="password" placeholder="password">
       </p>
       <!-- htmlspecialcharsのfanction(libs/functionsに定義済み) -->
       <div class="btn" onclick="document.getElementById('signup').submit();" >Sign Up</div>

       <p class="errml"><?= h($app->getErrors('username')); ?></p>
       <p class="errpw"><?= h($app->getErrors('password')); ?></p>
       <p class="fs12"><a href="/login.php">Log In</a></p>
       <!-- 不正対策用トークンの送信 -->
       <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
   </div>
 </body>
 </html>
