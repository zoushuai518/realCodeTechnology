<?php

//header('Content-type: application/javascript;charset=utf-8');
/**
 * Function Desc 模拟http请求
 * Function name open
 * @Param Param $uri
 * @Param Param $type
 * @Param Param $post_data
 * @Returns Returns
 */
function http_request($uri, $type,$post_data= '', $cookie=false) {
	$user_agent = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; CIBA)";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	// 设置超时时间
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	//post
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	}
	switch ($type) {
		case "GET":
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			break;
		case "POST":
			curl_setopt($ch, CURLOPT_POST, 1);
			// json格式
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json;charset=utf-8"));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			break;
		case "PUT":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			break;
		default:
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
			break;
	}
	//$cookie = 'token='.$uid.'; login=true';
	if($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE , $cookie );
	}
	//默认ipv4
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
