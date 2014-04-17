<?php

	/*
	 * PHP 验证码
	 * Error:防止浏览器输出 验证码失败
	 * Author:shuai zou <zoushuai518@126.com>
	 * ID:php_code_error.php 2013-09-05
	 */

	//验证码
	Header("Content-type: image/png");
	/*
	* 初始化
	*/
	$border = 1; //是否要边框 1要:0不要
	$how = 4; //验证码位数
	$w = $how*15; //图片宽度
	$h = 20; //图片高度
	$fontsize = 6; //字体大小
	$alpha = "abcdefghijkmnopqrstuvwxyz"; //验证码内容1:字母
	$number = "023456789"; //验证码内容2:数字
	$randcode = ""; //验证码字符串初始化
	srand((double)microtime()*1000000); //初始化随机数种子
	$im = ImageCreate($w, $h); //创建验证图片
	/*
	* 绘制基本框架
	*/
	$bgcolor = ImageColorAllocate($im, 255, 255, 255); //设置背景颜色
	ImageFill($im, 0, 0, $bgcolor); //填充背景色
	if($border)
	{
	$black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
	ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//绘制边框
	}
	/*
	* 逐位产生随机字符
	*/
	for($i=0; $i<$how; $i++)
	{ 
	$alpha_or_number = mt_rand(0, 1); //字母还是数字
	$str = $alpha_or_number ? $alpha : $number;
	$which = mt_rand(0, strlen($str)-1); //取哪个字符
	$code = substr($str, $which, 1); //取字符
	$j = !$i ? 4 : $j+15; //绘字符位置
	$color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //字符随即颜色
	ImageChar($im, $fontsize, $j, 3, $code, $color3); //绘字符
	$randcode .= $code; //逐位加入验证码字符串
	}
	//把验证码字符串写入session
	session_start();
	$_SESSION['authnum_session'] = $randcode;
	/*
	* 添加干扰
	*/
	for($i=0; $i<1; $i++)//绘背景干扰线
	{ 
	$color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰线颜色
	ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //干扰线
	} 
	for($i=0; $i<$how*40; $i++)//绘背景干扰点
	{ 
	$color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色
	ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); //干扰点
	}
	//关键代码，防止出现'图像因其本身有错无法显示'的问题
	ob_clean();
	/*绘图结束*/
	Imagegif($im);
	ImageDestroy($im);
	/*绘图结束*/


	// +++++++++++++++++++++++++++++++++++++++++ //

	// 默认配置下，php输出是先到输出缓冲区（output_buffering），只要数据还没有真正发送到浏览器（严格来说是tcp buffer），那么还是有机会清空先前的缓冲区里面的数据，使用内置的ob_clean函数即可。注意：ob_clean 只是清空当前缓冲区的数据，如果先前输出的数据大于缓冲区，那么一部分数据已经发送，发送的这部分数据是无法清空的。另外如果禁用php输出缓冲区，那么ob_clean起不到任何效果的。

	// ob_start,ob_clean函数的使用  
	/*ob_start();  #开启缓冲
	phpinfo(); 
	$phpinfo = ob_get_contents(); #该函数可以捕捉缓冲区的输出到一个变量里面
	//文件读写操作
	ob_clean();  #关闭缓冲
	print $phpinfo; #输出内容
	//phpinfo();

	ob是output buffering的简称，而不是output cache，ob用对了，是能对速度有一定的帮助，但是盲目的加上ob函数，只会增加CPU额外的负担。下面我说说ob的基本作用。
	1.防止在浏览器有输出之后再使用setcookie，或者header，session_start函数造成的错误。（我本以为最开始说的代码是这样的作用，但后来朋友说不是的），其实这样的用法少用为好，养成良好的代码习惯。
	2.捕捉对一些不可获取的函数的输出，比如phpinfo会输出一大堆的HTML，但是我们无法用一个变量例如$info=phpinfo();来捕捉，这时候ob就管用了
	3.对输出的内容进行处理，例如进行gzip压缩，例如进行简繁转换，例如进行一些字符串替换。
	4.生成静态文件，其实就是捕捉整页的输出，然后存成文件，经常在生成HTML，或者整页缓存中使用。
	对于刚才说的第三点中的GZIP压缩，可能是很多人想用，却没有真真用上的，其实稍稍修改下我朋友的代码，就可以实现页面的gzip压缩。*/

	// +++++++++++++++++++++++++++++++++++++++++ //


?>