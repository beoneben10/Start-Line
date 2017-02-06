<?php
$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';
$urlReply = 'https://api.line.me/v2/bot/message/reply';
require_once "dbconnect.php";
$sql = "SELECT * FROM test";
mysql_query("SET NAMES UTF8");
$result = mysql_query($sql);
$mem = mysql_fetch_array($result);

function Showdata($showdb){
  $db = "SELECT username FROM test";
  $db1 = explode(" ", $db);
  foreach ($db1 as $key => $value) {
      if($showdb == $value){
          return $key;
          }
        }
 }

 function postMessage($access_token,$packet,$urlReply){
 $dataEncode = json_encode($packet);
 $headersOption = array('Content-Type: application/json','Authorization: Bearer '.$access_token);
 $ch = curl_init($urlReply);
 curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 curl_setopt($ch,CURLOPT_POSTFIELDS,$dataEncode);
 curl_setopt($ch,CURLOPT_HTTPHEADER,$headersOption);
 curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
 $result = curl_exec($ch);
 curl_close($ch);
 }

// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text_get = $event['message']['text'];
			if(strpos($text_get, "tel") !== false){
				$ex_text_get = explode(" ", $text_get); // explode 
				$text_m = $ex_text_get[0]." ".$ex_text_get[1];
				$data = $gd->getWeatherToday($ex_text_get[1]);
				if($data != "Province_NULL"){
					$text_m = "เบอร์โทร : {$data['province']} 
          //ดึงข้อมูลมาแสดง sting 1 ชุด
          $tel = 
          ";
          }else {
					$text_m = "ไม่พบข้อมูล";
				  }
          }else {
				  $text_m = $cm->Check_message_from_user($text_get);
			    }
      // Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = ['type' => 'text','text' =>  $text_m];
      $data = ['replyToken' => $replyToken,'messages' => [$messages],];
      
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {


?>
