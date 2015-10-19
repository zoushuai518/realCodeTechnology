<?php

/*
Base64是网络上最常见的用于传输8Bit字节代码的编码方式之一，看好是编码，并不是加密。
编码过程不解释了，Base64要求把每三个8Bit的字节转换为四个6Bit的字节（3*8 = 4*6 = 24），然后把6Bit再添两位高位0，组成四个8Bit的字节，也就是说，转换后的字符串理论上将要比原来的长1/3。
php 用base64_encode() 编码的数据要比原始数据多占用 33% 左右的空间。

格式是大小写字母、数字、“=”号、“+”号和“/”号
但“=”等号最多只有两个
正则匹配就是 【 [a-zA-Z0-9=+/]+ 】
所以看到有大小写字母的字符串并且有一个或两个等号结束的。基本可以判断是base64编码
base64不适合直接放在URL里传输,发现base64编码中有“/” “=”符号。为解决此问题，可采用一种用于URL的改进Base64编码，它不在末尾填充'='号，并将标准Base64中的“+”和“/”分别改成了 “_”和“-”，这样就免去了在URL编解码和数据库存储时所要作的转换。
*/

//zs测试可用
//from dz

// 参数解释
// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙 
	$ckey_length = 4;

	// 密匙
	$key = md5($key ? $key : UC_KEY);
	// 密匙a会参与加解密 
	$keya = md5(substr($key, 0, 16));
	// 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
	// 密匙c用于变化生成的密文 
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	// 参与运算的密匙 
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
	//解密时会通过这个密匙验证数据完整性   
   	// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	// 加密的字符串可以在url中使用, zs
	// $string = $operation == 'DECODE' ? base64_decode(str_replace(['_', '-'], ['+', '/'], substr($string, $ckey_length))) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	// 产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	// 核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// 从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		// 验证数据有效性，请看未加密明文的格式
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码 
		return $keyc.str_replace('=', '', base64_encode($result));
		// 加密的字符串可以在url中使用, zs
		// return $keyc.str_replace(['+', '/', '='], ['_', '-', ''], base64_encode($result));
	}

}


var_dump(authcode(111,'ENCODE','zs'));
echo '<br />';
var_dump(authcode(authcode(111,'ENCODE','zs'),'DECODE','zs'));


?>
