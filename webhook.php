<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Get POST body content
$inputJSON = file_get_contents('php://input');
// Parse JSON
$events = json_decode($inputJSON, TRUE);
if (isset($events)) {

  $accessToken = "6GXQOW+Hd+anHd0hF2YhAI/OiiKkBG1oy9ap7ZCkie9fagxHZTXDhQETDgyiIiK6ldDwArW1nG96PydpgAqiRBRqqpANljXTGMo6A9LJCV0UCKY/iHWWRQCnb5dBhlriXiWXyDrbcK18zDd+u/5l9AdB04t89/1O/w1cDnyilFU=";
  // Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

      // Logic
      if ($text == "คนหน้าตาดี") {
        $text1 = "ก็นายไง";
        $text2 = "เราก็ด้วยนะ";
        replyWith2Messages($text1, $text2, $replyToken, $accessToken);
      } else if ($text == "ร้องเพลง") {
        $text1 = "ช้าง ช้าง ช้าง ...";
        $text2 = "ไปร้านเกะเอานะ";
        replyWith2Messages($text1, $text2, $replyToken, $accessToken);
      } else if ($text == "บทความ") {
        $text1 = "ติดตามได้ที่";
        $text2 = "https://medium.com/@puuga";
        replyWith2Messages($text1, $text2, $replyToken, $accessToken);
      } else if ($text == "ในหลวง") {
        $text1 = "เรารักในหลวง";
        replyWithMessage($text1, $replyToken, $accessToken);
      }else if ($text == "กินอะไรดี") {
        $data = [
          'type' => 'template',
          'altText' => "this is a carousel template",
          'template' => [
            "type" => "carousel",
            "columns" => [
              [
                "thumbnailImageUrl" => "https://www.google.co.th/images/nav_logo242.png",
                "title" => "Pizza",
                "text" => "Pizza description",
                "actions" => [
                  [
                    "type" => "uri",
                    "label" => "View detail",
                    "uri" => "https://www.pizza.co.th/Product/Pizza"
                  ]
                ]
              ],
              [
                "thumbnailImageUrl" => "https://www.google.co.th/images/nav_logo242.png",
                "title" => "ผัดไทย",
                "text" => "ผัดไทย description",
                "actions" => [
                  [
                    "type" => "uri",
                    "label" => "View detail",
                    "uri" => "http://cooking.kapook.com/view132305.html"
                  ]
                ]
              ]
            ]
          ]
        ];
        replyWithCarousel($data, $replyToken, $accessToken);
      } else {
        $text1 = "ไม่เข้าใจ";
        replyWithMessage($text1, $replyToken, $accessToken);
      }

		} else if ($event['type'] == 'follow') {
      // Get replyToken
			$replyToken = $event['replyToken'];

      $text1 = "Hello - สวัสดี";
      replyWithMessage($text1, $replyToken, $accessToken);
    }
	}
}

http_response_code(200);

function replyWithMessage($text, $replyToken, $accessToken) {
  $message = [
    'type' => 'text',
    'text' => $text
  ];

  // Make a POST Request to Messaging API to reply to sender
  $url = 'https://api.line.me/v2/bot/message/reply';
  $data = [
    'replyToken' => $replyToken,
    'messages' => [$message],
  ];
  $post = json_encode($data);
  $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $accessToken);

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_PROXY, $proxy);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
  $result = curl_exec($ch);
  curl_close($ch);
}

function replyWith2Messages($text1, $text2, $replyToken, $accessToken) {
  // Build message to reply back
  $message1 = [
    'type' => 'text',
    'text' => $text1
  ];

  // Build message to reply back
  $message2 = [
    'type' => 'text',
    'text' => $text2
  ];

  // Make a POST Request to Messaging API to reply to sender
  $url = 'https://api.line.me/v2/bot/message/reply';
  $data = [
    'replyToken' => $replyToken,
    'messages' => [$message1, $message2],
  ];
  $post = json_encode($data);
  $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $accessToken);

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_PROXY, $proxy);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
  $result = curl_exec($ch);
  curl_close($ch);
}

function replyWithCarousel($carousel, $replyToken, $accessToken) {

  // Make a POST Request to Messaging API to reply to sender
  $url = 'https://api.line.me/v2/bot/message/reply';
  $data = [
    'replyToken' => $replyToken,
    'messages' => [$carousel],
  ];
  $post = json_encode($data);
  $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $accessToken);

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_PROXY, $proxy);
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
  $result = curl_exec($ch);
  curl_close($ch);
}
?>
