<?php
// Get POST body content
$content = file_get_contents('php://input');
//$access_token = $_SERVER['CHANNEL_ACCESS_TOKEN_ormcoin'];

// Parse JSON
$events = json_decode($content, true);

if (!is_null($events['events'])) {
	  $access_token = "6GXQOW+Hd+anHd0hF2YhAI/OiiKkBG1oy9ap7ZCkie9fagxHZTXDhQETDgyiIiK6ldDwArW1nG96PydpgAqiRBRqqpANljXTGMo6A9LJCV0UCKY/iHWWRQCnb5dBhlriXiWXyDrbcK18zDd+u/5l9AdB04t89/1O/w1cDnyilFU=";
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			//get Name
			$userId=$event['source']['userId'];	
			$arrProfile=fn_profile($userId);
			$name=$arrProfile['displayName'];
			//$arrProfile["userId"];
			//$pictureUrl=$arrProfile['pictureUrl'];
			//$pictureUrlsmall=$arrProfile['pictureUrl']."/small";
			
			switch($text){
				case "pay": case "Pay": case "PAY": 
				case "menu": case "Menu": case "MENU":
				$messages1 =['type' => 'text','text' => " ".$name." มาจ่ายบิลกันเถอะ \r\n"];	
				$messages2=['type' => 'template','altText' => 'Menu','template'=> ['type'=>'buttons','thumbnailImageUrl'=>'https://ormlinebot.herokuapp.com/ormpay/ormPay-logo.PNG','title'=>'เมนู','text'=>'เลือกรายการจ่าย?','actions'=>[['type'=>'postback','label'=>'จ่าย:ค่าไฟ','data'=>'action=pay&vendor=elec'],['type'=>'postback','label'=>'จ่าย:ค่าน้ำ','data'=>'action=pay&vendor=water'],['type'=>'postback','label'=>'จ่าย:ค่าโทรศัพท์','data'=>'action=pay&vendor=AIS'],['type'=>'postback','label'=>'จ่าย:ค่าบัตรเครดิต','data'=>'action=pay&vendor=creditcard']]]];
				break;

				case "help": case "Help": case "HELP":  
				$messages1 =['type' => 'text','text' => " สวัสดี ".$name." \r\n สั่งงานเราได้นะ \r\n pay : จ่ายบิล \r\n bal : เช็คยอดในบัญชี \r\n อื่นๆ รอเราอัพเดทให้นะ"];	
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>4 ];
				break;
				
				case "hi": case "Hi": case "Hello":  
				$messages1 =['type' => 'text','text' => $text." ".$name." \r\n สบายดีนะ จ่ายบิลบอกเราได้นะ "];		
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>11 ];
				break;
					
				case "bal": case "Bal": case "balance":  case "Balance":  
				$messages1 =['type' => 'text','text' => "Asset ".$name." \r\n Cash : 1,000 บาท \r\n Mutual Fund : 20,000 หน่วย "];		
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>12 ];
				break;
					
				default :
				$messages1 =['type' => 'text','text' => "Hi ".$name." \r\n เรียกเมนู พิมพ์คำว่า Menu ได้นะ \r\n ถ้าคิดอะไรไม่ออก พิมพ์ help ดูสิ"];		
				$intRand=rand(1,20);
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>$intRand ];
				break;
			
			// Build message to reply back
			//$messages1 = ['type' => 'text','text' => $text];	
			//$messages3=['type' => 'image','originalContentUrl' => $pictureUrl , 'previewImageUrl'=> $pictureUrlsmall ];
			//$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>1 ];
			//$messages3 = ['type' => 'template','altText' => 'ohno','template'=> ['type'=>'confirm','text'=>'Are you sure?','actions'=>[['type'=>'message','label'=>'yes','text'=>'yes_q1'],['type'=>'message','label'=>'no','text'=>'no_q1']]]];
			//$txt="Hello สบายดีนะ ".$name;
			
			//$messages=fn_response($text);			
			
			}//end switch
		}else if ($event['type'] == 'postback' ) {
			$replyToken = $event['replyToken'];
			$postbackdata=parse_str($event['postback']['data']);//&action=pay&vender=elec
			if($action=="pay"){
			switch($vendor){
				case "elec":
				$messages1 =['type' => 'text','text' =>" จะจ่ายค่าไฟเหรอ สบายๆ มาเลย \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>5 ];
				break;

				case "water":
				$messages1 =['type' => 'text','text' =>"  จะจ่ายน้ำ ชิวๆ จ่ายได้เลย \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>8 ];
				break;
					
				default:
				$messages1 =['type' => 'text','text' => " จ่าย ".$vendor."  \r\n"];
				$messages2 = ['type' => 'sticker','packageId' => 1,'stickerId'=>7 ];
				break;
			}//end switch
			}//end if
		}//end if
				
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			//$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2,$messages3]];
			$data = ['replyToken' => $replyToken,'messages' => [$messages1,$messages2]];

			$post = json_encode($data);
			//$post='{  "replyToken": "'.$replyToken.'","messages":{"type": "text","text": "Hello, world"}}';
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
		
	}//foreach
}//end if

		function fn_profile($userId){
		  global $access_token;
		//$url = 'https://api.line.me/v1/profile';
		$url="https://api.line.me/v2/bot/profile/".$userId;
		$headers = array('Authorization: Bearer ' . $access_token);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		  $arrProfile=json_decode($result,true);
		  return $arrProfile;
		  //return $result;
		  
		  /*
		  $arrProfile=fn_profile($userId);
		  $arrProfile["displayName"];
		  $arrProfile["userId"];
		  $arrProfile["pictureUrl"];
		  $arrProfile["statusMessage"];
		  */
		  
      }


echo "OK";
?>
