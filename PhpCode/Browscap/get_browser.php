<?php

	//zs test enable
	/**
		get_browser()函数,需要 browscap.ini文件支持;
		在 php.ini中添加
		;browscap
		browscap = "/home/weiyan/zs_ubuntu/php/php_browscap.ini";
	*/
	//zs ext | test get_browser

	function browscap($user_agent=null){
		return get_browser($user_agent,true);	
	}

	var_dump(browscap());

?>
