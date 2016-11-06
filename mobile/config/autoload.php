<?php
//jigenji\Contoller\Index(名前空間)
//->lib/Controller/Index.php
// クラスが呼ばれた時に自動的に実行
spl_autoload_register(function($class) {
  $prefix = 'jigenji\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePath)) {

      // $classFilePath = "/var/www/html/jpserver/mobile/lib/Controller/Signup.php";
      // var_dump($classFilePath);
      require $classFilePath;
    }
  }
});
