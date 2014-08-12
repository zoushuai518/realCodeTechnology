<?php


/**
* 将数组转换为字符串
* @param    array    $data        数组
* @param    bool     $isformdata    如果为0，则不使用new_stripslashes处理，可选参数，默认为1
* @return   string   返回字符串，如果，data为空，则返回空
*/
function array2string($data, $isformdata = 1) {
	if($data == '') return '';
	if($isformdata) $data = stripslashes($data);
	return addslashes(var_export($data, TRUE));
}

$data =array('abc'=>123);

echo array2string($data, 0);
//echo array2string($data, 1);

?>
