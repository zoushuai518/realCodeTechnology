<?php 
/*
编码真是一个让人头痛的事情，尤其像我这种基础功太差的人。UTF-8和GBK的编码也看过好长时间，不过一直在重复着看了忘，忘了看，看了再忘，忘了就忘了的轨迹。
今天要写一个小功能，前端和后台都要检测字符串是否全是汉字，前端呢就是js，后端就是PHP，于是就有了本文，PHP，JS汉字正则匹配。js取汉字的正则，网上还是不少的，我是从别人的站那里扒下来的，呵呵。而PHP的虽然也多，但是大多数不正确，找的头都痛了。好不容易找到能用的，要是不记录在这里的话，以后想找可就太困难了。所以摘录至此，惠人惠己。
 */



//php版

$action = trim($_GET['action']);
if($action == "sub"){    
	$str = $_POST['dir'];      
	//if(!preg_match("/^[".chr(0xa1)."-".chr(0xff)."A-Za-z0-9_]+$/",$str)) 
	//GB2312汉字字母数字下划线正则表达式    
	if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$str))   //UTF-8汉字字母数字下划线正则表达式    
	{          
		echo "<font color=red>您输入的[".$str."]含有违法字符</font>";      
	}else{
		echo "<font color=green>您输入的[".$str."]完全合法,通过!</font>";      
	}
}


//当然如果要想字符串全是汉字的GBK2312编码匹配为：
$str = "小小子";
if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str)){
	print($str."确实全是汉字");
} else {
	print($str."这个真 TMD不全是汉字");
}
 

//其实只要了解了各个编码的高位与低位的开始与结束，那么自然就可以写出正则，而且直接是十六位的，有啥困难？呵呵。不过要注意，在php里面，表示十六位是用的\x。
//所以如上，我们还可以用该正则表达式来判断是否是GB2312的汉字

$str = "小小子";
if(preg_match("/^[\xb0-\xf7][\xa0-\xfe]+$/",$str)){
	print($str."确实全是汉字");
} else {
	print($str."这个真 TMD不全是汉字");
}
 

/*
+$/u 的意思：
+ 表示重复1次或多次；$ 表示匹配末尾；/ 表示定界符；u 表示模式字符串被当成 UTF-8；U 表示第一次匹配后即停止搜索。
要匹配2-4 个，用{2，4}表示。/^[\x{4e00}-\x{9fa5}]{2,4}$/u
*/
?>