
<?php

$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';
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
			}else if(strpos($text_get, "ห้อง") !== false){
				$ex_text_get = explode(" ", $text_get); // explode 
				$text_m = $ex_text_get[0]." ".$ex_text_get[1];
				$data = $gd->getDevision($ex_text_get[1]);
				if($data != "Province_NULL"){
					$text_m = "ข้อมูลห้อง : {$data['province']} 
					อาคาร : {$data['Buil']} 
					ชั้น : {$data['ID']} 
					ห้อง : {$data['room']} 
					ลายละเอียด : {$data['Devision']} 
					เบอร์โทร : {$data['tel']}
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
