<?php
$access_token = 'SmC479aBsZtxrVoqsqEW1KDMT6c/bP6woDbRg2BD56+k/NM86O4XKvG68KVShh4mImg9IQJbE+QaVdGlSUSAbhzuxYN60cRrWdrqa6eyTAf2aOZO2IxluB9A4tAFYjepYUVSX+R1OKfrl9JX2zlc3QdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
