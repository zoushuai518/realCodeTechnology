<?php


/** 
 * 将字符串转换为数组 
 * @param string $data 字符串 
 * @return array 返回数组格式，如果，data为空，则返回空数组 
 */ 
function string2array($data) {
	if($data == '') return array();
	@eval("\$array = $data;");
	return $array;
}

$data ='array("abc"=>123)';

echo '<pre>';
print_r(string2array($data));

?>
