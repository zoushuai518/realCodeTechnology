<?php

// zs untest
/**
 * 商品历史浏览记录
 * $data 商品记录信息
 */

private function _history($data)
{
	if(!$data || !is_array($data))
	{
		return false;
	}

	//判断cookie类里面是否有浏览记录
	if($this->_request->getCookie('history'))
	{
		$history = unserialize($this->_request->getCookie('history'));
		array_unshift($history, $data); //在浏览记录顶部加入

		/* 去除重复记录 */
		$rows = array();
		foreach ($history as $v)
		{
			if(in_array($v, $rows))
			{
				continue;
			}
			$rows[] = $v;
		}

		/* 如果记录数量多余5则去除 */
		while (count($rows) > 5)
		{
			array_pop($rows); //弹出
		}

		setcookie('history',serialize($rows),time() + 3600 * 24 * 30,'/');
	}
	else
	{
		$history = serialize(array($data));

		setcookie('history',$history,time() + 3600 * 24 * 30,'/');
	}
}

?>
