<?php

function h($s){
  // 文字をただの文字として表示する/とか\とかの特殊なやつ
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}


// 郵便番号から区や市から
//zipcodenの位置に気をつけて、用意しとくこと
function getWard(){
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



// 区の名前を番号に変換
function switchWard($wardname){
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
