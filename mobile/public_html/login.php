<?php


require_once(__DIR__.'/../config/config.php');


//名前空間のクラスを呼び出し
$app = new jigenji\Controller\Login();

$app->run();


// echo "login screen";
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <title>Log In</title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body>
   <div id="login_container">

     <form action="" method="post" id="login">
       <p>
         <input type="text" name="username" placeholder="user name" value="<?=
          isset($app->getValues()->username) ? h($app->getValues()->username) : ''; ?>">
       </p>
       <p>
         <input type="password" name="password" placeholder="password">
       </p>
       <p class="errml"><?= h($app->getErrors('login')); ?></p>
       <div class="btn" onclick="document.getElementById('login').submit();">LogIn</div>
       <p class="fs12"><a href="/signup.php">Sign Up</a></p>
       <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">

     </form>
   </div>
 </body>
 </html>
