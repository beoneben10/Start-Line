<?php

$post = file_get_contents('php://input');
$urlReply = 'https://api.line.me/v2/bot/message/reply';
$token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';

function getSticker($replyToken){
 $sticker = array(
 'type' => 'sticker',
 'packageId' => '1',
 'stickerId' => '1'
 );
 $packet = array(
 'replyToken' => $replyToken,
 'messages' => array($sticker),
 );
   return $packet;
}
 
 $res = json_decode($post, true);
 if(isset($res['events']) && !is_null($res['events'])){
 foreach($res['events'] as $item){
 if($item['type'] == 'message'){
 switch($item['message']['type']){
 case 'text':
 break;
 case 'image':
 break;
 case 'video':
 
 break;
 case 'audio':
 
 break;
 case 'location':
 break;
 case 'sticker':
 $packet = getSticker($item[‘replyToken’]);
 postMessage($token,$packet,$urlReply);
 break;
 }
 
 function postMessage($token,$packet,$urlReply){
 $dataEncode = json_encode($packet);
 $headersOption = array('Content-Type: application/json','Authorization: Bearer '.$token);
 $ch = curl_init($urlReply);
 curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
 curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 curl_setopt($ch,CURLOPT_POSTFIELDS,$dataEncode);
 curl_setopt($ch,CURLOPT_HTTPHEADER,$headersOption);
 curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
 $result = curl_exec($ch);
 curl_close($ch);
}

