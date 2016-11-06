<?php
$url = "https://fcm.googleapis.com/fcm/send";
$api_key = "AIzaSyAD08IM9TRuQ9oJ54zdKKNIfsi3q9H2yRU";
$ids = "fnU6GHExEsc:APA91bFZiyOLV3uLScjESpDY9FG0qhxJPuooqc-ZMuZI1buwkobp6BNVoH_R9E73sK3Vaz_cQVxWlBJSyBVWOqjUY8q1AcJuVfQE6g9M6qZnw8XUgHqIfZDeo5d4qdS-oPw7OeRgS_fS";
$msg_url = "http://msg.com";
$msg_title = "message_title";
// $arr = array(
// 	"to" => "topics/news",
//   "priority" => "high",
//   "notification" => array("title" => "fromphp")
// );
//
// // header('Content-type: application/json');
// $arr1 = json_encode($arr);
// echo $arr1;
// $options = array(
//   'http' => array(
//     'method'  => 'POST',
//     'header'=>  "Content-Type: application/json\r\n".
//                 "Authorization: key=AIzaSyBByQPgMXfnp1u1nnVbY-m2LrMwvSoXzCo\r\n"
//     )
// );
// $options = stream_context_create($options);
// $result = file_get_contents($url, false, $options);
// echo($result);

//これで行けた!!
$message = array("msg_url" => $msg_url, "msg_title" => $msg_title);

//表示の核心部分
$fields = array(
  //基本high normalも
  'priority' => 'high',
  //携帯がアクティブになるまで送信をまつ
  "delay_while_idle" => true,

  "icon" => "icon_x",
  //表示する部分
  'notification'=> array( 'body'=>'本日配送予定の商品があります','title' => 'MY宅配',"icon"=> "myicon" ),
  //データとして渡す部分
  'data'=> array( 'Nick'=>'MARIO','body' => 'great match',"Room"=> "PortugalVSDenmark" ),
  //宛先
  'to' => $ids,
);

// $fieldsdata = array(
//   'priority' => 'high',
//   'data'=> array( 'Nick'=>'MARIO','body' => 'great match',"Room"=> "PortugalVSDenmark" ),
//   'to' => $ids,
// );

$headers = array('Authorization: key=' . $api_key,'Content-Type: application/json');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'=> $headers ,
        'method'  => 'POST',
        'content' => json_encode($fields),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

var_dump($result);
