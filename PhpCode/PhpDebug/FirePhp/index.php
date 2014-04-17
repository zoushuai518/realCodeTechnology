<?php

	/**
	 * firephp
	 * http://www.firephp.org/ | https://getfirebug.com/
	 * Integrating FirePHP for Ajax Development:http://www.christophdorn.com/Blog/2009/04/03/how-to-integrate-firephp-for-ajax-development/
	 * http://www.firephp.org/Wiki/Libraries/
	 */
	#zs 测试可用
	require_once('./FirePHPCore/lib/fb.php');

	#zs 使用
	// call_user_func_array()

	//FirePHP
	$anotherTest = array('one','two','three');
	// FB::log($anotherTest);
	fb($anotherTest,FirePHP::TRACE);	//simple use
	// fb($anotherTest,FirePHP::LOG);	//simple use

	//  FirePHP Debug
	$options = array('maxObjectDepth' => 5,
                 'maxArrayDepth' => 5,
                 'maxDepth' => 10,
                 'useNativeJsonEncode' => true,
                 'includeLineNumbers' => true);
	fb($data,FirePHP::TRACE);
	fb($data,FirePHP::LOG);
	//  FirePHP Debug

?>