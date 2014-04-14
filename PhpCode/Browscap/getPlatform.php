<?php
//zs test enable

/**
	This is simple
*/

//zs-ext 使用 需要改进


/**
 * 获取浏览器平台。
 *
 * @return array
 */
//public function getPlatform($ua = '')
function getPlatform($ua = '')
{

	$ua = empty($ua) ? $_SERVER['HTTP_USER_AGENT'] : $ua;
	$data = array();

	if (strpos($ua, 'Windows NT 6.1') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'windows 7';
	}
	elseif (strpos($ua, 'Windows NT 5.1') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'windows xp';
	}
	elseif (strpos($ua, 'Windows NT 6.0') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'windows vista';
	}
	elseif (strpos($ua, 'Windows NT 5.2') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'windows 2003';
	}
	elseif (strpos($ua, 'Windows NT 5.0') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'windows 2000';
	}
	elseif (strpos($ua, 'Linux x86_64') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'linux';
	}
	elseif (strpos($ua, 'Linux i686') !== false)
	{
		$data['ispc'] = 1;
		$data['sys'] = 'linux';
	}
	elseif (strpos($ua, 'Linux') !== false && strpos($ua, 'Android') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'android';
	}
	elseif (strpos($ua, '(iPhone') !== false && strpos($ua, 'iPhone OS 4') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'iPhone4';
	}
	elseif (strpos($ua, '(iPhone') !== false && strpos($ua, 'iPhone OS 3') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'iPhone3';
	}
	elseif (strpos($ua, 'iPod') !== false && strpos($ua, 'iPhone OS') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'iPod';
	}
	elseif (strpos($ua, '/Adr') !== false && strpos($ua, '(Linux') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'android';
	}
	elseif (strpos($ua, 'Android') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'android';
	}
	elseif (strpos($ua, 'Windows Phone') !== false)
	{
		$data['ispc'] = 0;
		$data['sys'] = 'windows phone';
	}
	else
	{
		$data['ispc'] = 1;
		$data['sys'] = 'other';
	}

	return $data;

}

echo '<pre>';
var_dump(getPlatform());
echo '<br />';
var_dump($_SERVER);
die;
?>
