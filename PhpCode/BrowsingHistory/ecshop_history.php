<?php

// zs untest

//利用COOKIE来实现用户商品历史浏览记录。

//如是COOKIE 里面不为空，则往里面增加一个商品ID
if (!empty($_COOKIE['SHOP']['history'])){

	//取得COOKIE里面的值，并用逗号把它切割成一个数组
	$history = explode(',', $_COOKIE['SHOP']['history']);
	//在这个数组的开头插入当前正在浏览的商品ID
	array_unshift($history, $id);
	//去除数组里重复的值
	$history = array_unique($history);
	// $arr = array (1,2,3,1,3);
	// $arr = array (1,1,2,3,3);
	// $arr = array (1,2,3);
	//当数组的长度大于5里循环执行里面的代码
	while (count($history) > 5){
		//将数组最后一个单元弹出，直到它的长度小于等于5为止
		array_pop($history);
	}
	//把这个数组用逗号连成一个字符串写入COOKIE，并设置其过期时间为30天
	setcookie('SHOP[history]', implode(',', $history), $cur_time + 3600 * 24 * 30);

}else{
	//如果COOKIE里面为空，则把当前浏览的商品ID写入COOKIE ，这个只在第一次浏览该网站时发生
	setcookie('SHOP[history]', $id, $cur_time + 3600 * 24 * 30);
}

//以上均为记录浏览的商品ID到COOKIE里,下面将讲到怎样用这样COOKIE里的数据

//取得COOKIE里的数据 ,格式为1,2,3,4 这样，当然也有可以为0
$history =isset ($_COOKIE['SHOP']['history']) ? $_COOKIE['SHOP']['history'] : 0;
//写SQL语句，用IN 来查询出这些ID的商品列表
$sql_history = "SELECT * FROM `goods` WHERE `goods_id` in ({$history})";
//执行SQL语句，返回数据列表
$goods_history = $db->getAll($sql_history);
if ($goods_history) {
	$tpl->assign ('goods_history',$goods_history);
}

?>
