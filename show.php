<?php 
header("Content-type:text/json;charset=UTF-8");
$jsondata = file_get_contents("https://www.namo.xyz/lineben/myfile.json");
$json = json_decode($jsondata,true);
var_dump($json);
?>
