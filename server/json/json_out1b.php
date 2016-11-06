<?php
$arr1 = array(
	"company" => "yamato",
	"product" => "apple",
	"day" => "03/06/2016"
);

$arr2 = array(
	"company" => "yamato",
	"product" => "tomato",
	"day" => "03/08/2016",
);

$arr3 = array(
	"company" => "sagawa",
	"product" => "water",
	"day" => "03/13/2016",
);

// var_dump(mb_detect_encoding($arr1["company"]));
header('Content-type: application/json');
echo json_encode($arr1,JSON_UNESCAPED_UNICODE);


// echo json_encode($arr2,JSON_UNESCAPED_UNICODE);
// echo json_encode($arr3,JSON_UNESCAPED_UNICODE);


// var_dump(json_decode(json_encode($arr2)));
?>
