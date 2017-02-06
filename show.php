<?php
$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';
require_once "dbconnect.php";
$sql = "SELECT * FROM test";
mysql_query("SET NAMES UTF8");
$result = mysql_query($sql);
$mem = mysql_fetch_array($result);
echo $mem['uname'];
echo $mem['passwd'];
?>
