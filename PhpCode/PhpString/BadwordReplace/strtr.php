<?php
// #zs
// 敏感词替换算法，效率比str_replace高4倍（附6仟个敏感词）

require('badword.src.php');
$badword1 = array_combine($badword,array_fill(0,count($badword),'*'));
$bb = '我今天开着张三丰田上班';
$str = strtr($bb, $badword1);



//有兴趣的朋友可以研究一下
function strtr_array(&$str,&$replace_arr) {
	$maxlen = 0;$minlen = 1024*128;
	if (empty($replace_arr)) return $str;
	foreach($replace_arr as $k => $v) {
		$len = strlen($k);
		if ($len < 1) continue;
		if ($len > $maxlen) $maxlen = $len;
		if ($len < $minlen) $minlen = $len;
	}
	$len = strlen($str);
	$pos = 0;$result = '';
	while ($pos < $len) {
		if ($pos + $maxlen > $len) $maxlen = $len - $pos; 
		$found = false;$key = '';
		for($i = 0;$i<$maxlen;++$i) $key .= $str[$i+$pos]; //原文：memcpy(key,str+$pos,$maxlen)
		for($i = $maxlen;$i >= $minlen;--$i) {
			$key1 = substr($key, 0, $i); //原文：key[$i] = '\0'
			if (isset($replace_arr[$key1])) {
				$result .= $replace_arr[$key1];
				$pos += $i;
				$found = true;
				break;
			}
		}
		if(!$found) $result .= $str[$pos++];
	}
	return $result;
}


?>