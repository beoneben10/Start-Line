
<?php

$access_token = 'CVm19KJhT/H3jqz63wtllGGTBtoL8NNO1z4N2LjXPjNXU9ZArY6SWg6zOLwbj+WWk9utfeMETNuou56fWtLP6wJcRjM+gcS36u+bSYsyuHOrus+CsXf/aqRBF5VSya3yvB8gzxORHxHgzuYUq2Ly7gdB04t89/1O/w1cDnyilFU=';
require_once "Knowlege_Base.php";
require_once "GetDataJSON.php";
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);

$cm = new Knowlege_Base();
$gd = new GetData();

// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text_get = $event['message']['text'];
			//$text = $event['message']['text'];
			if($text_get == 'สวัสดี'){
				$text_m = 'สวัสดีจ๊ะ';
			}else if(strpos($text_get, "สภาพอากาศ") !== false){
				$ex_text_get = explode(" ", $text_get); // explode 
				$text_m = $ex_text_get[0]." ".$ex_text_get[1];
				$data = $gd->getWeatherToday($ex_text_get[1]);
				if($data != "Province_NULL"){
					$text_m = "ข้อมูลสภาพอากาศ : {$data['province']} 
					อุณภูมิ : {$data['temperature_current']} c
					อุณภูมิสูงสุด : {$data['temperature_max']} c
					อุณภูมิตำสุด : {$data['temperature_min']} c
					ความชื้นสัมพัทธ์ : {$data['relativeHumidity']} %
					ความเร็วลม : {$data['windSpeed']} km/h
					ปริมาณน้ำฝน : {$data['rainfall']} mm
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
			$messages = [
				'type' => 'text',
				'text' =>  $text_m
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK <br>";


?>
