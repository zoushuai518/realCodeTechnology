<?php

// PHP CURL 伪造HTTP_REFERER
// 首先确定php.ini
// extension=php_curl.dll 这个扩展是开启的

function forgetReferer(){
	$post_data = array (
		"nameuser" => "syxrrrr",
		"pw" => "123456"
	);
	$ch = curl_init();

	curl_setopt ($ch, CURLOPT_URL, 'http://localhost/2.PHP');
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch,CURLOPT_REFERER,'HTTP://www.baidu.com');
	curl_setopt ($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_exec ($ch);
	curl_close ($ch);

	$a=getenv('HTTP_REFERER');
	echo 'HTTP_REFERER=>'.$a;

}
