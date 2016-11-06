<?php


require_once(__DIR__.'/../config/config.php');


//user_recordの内容が入った連想配列
var_dump($_SESSION['me']);
// echo $_SESSION['me']->userId;

//名前空間のクラスを呼び出し
$app = new jigenji\Controller\Index();
//
// $app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="utf-8">
   <title>Home</title>
   <link rel="stylesheet" href="style.css">
 </head>
 <body>
   <div id="login_container">

     <!-- logout.phpに飛ぶように設定 -->
     <form action="/logout.php" method="post" id="logout">
       <?= h($app->me()->userName); ?><input type="submit" value="Log Out">
       <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
     </form>
     <h1>Users <span class="fs12">(3)</span></h1>

   </div>
 </body>
 </html>
