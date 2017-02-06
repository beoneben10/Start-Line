<?php

/*
Author : Wuttinan
*/

class Knowlege_Base
{
	
	public static function Check_message_from_user($message)
	{
		$text ='';
		switch ($message) {
			case 'hello':
				$text = 'Hello there เก่งภาษาอังกฤษสินะ  (-^〇^-)';
				break;
			case 'hi':
				$text = 'Hi there เก่งภาษาอังกฤษสินะ  (-^〇^-)';
				break;
			case 'หวัดดี':
				$text = 'หวัดดีจ๊ะ (::^ω^::)';
				break;
			case 'สวัสดี':
				$text = 'หวัดดีจ๊ะ (-^〇^-)';
				break;
			case 'ดีจ๊ะ':
				$text = 'หวัดดีจ๊ะ (-^*^-)';
				break;
			case 'ชื่ออะไร':
				$text = 'เค้ายังไม่มีชื่ออ่ะ (*^o^*)';
				break;
			default:
				$text = '>.<';
				break;
		}
		return $text;
	}
}

?>