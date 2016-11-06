<?php
$arr = array(
	"yamato" => array(array("商品1" => "03/07/2016"), array("商品2" => "03/08/2016")),
	"sagawa" => array(array("商品3" => "03/13/2016")),
	"yubin" => null
);

echo json_encode($arr);
echo $_POST[format];
?>
