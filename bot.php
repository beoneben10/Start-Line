<?php
include 'msg.php';
$access_token = 'GkoOxRvFydfEqIwtmWNXpibqEjD6BntdOLAIriC/YtmbdrLiIqCTZrYKKnZW2Scmz5p8pR11GUJ1g2AxZJ8lKnOgVGwzZAP3ti+vivJJ7rIX9t7eGHiwi66UX3lK889nY7vAdGoKGk11l7292Ah59wdB04t89/1O/w1cDnyilFU=';
$mm = new msg();
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			//$text = $event['message']['text'];
			$mm->showMSG($event['replyToken'],$event['source']['userId'],$event['message']['text']);
		}
	}
}
echo "OK";
