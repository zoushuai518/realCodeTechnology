<?php


// require_once('./ChromePhp.php');
#zs 测试可用 | Chrome插件：Chrome Logger要开启 |http://craig.is/writing/chrome-logger

/** 
对于php调试，各位大牛想必都有自己的一套习惯，本人之前用得最多的就是var_dump，神马xdebug都是浮云，太繁琐了。
以前听说过FirePhp这个调试工具，可以将调试信息打印到firebug上，不过由于我不喜欢用firebug来调试，一般情况下，都是用chrome来开发，于是就找出了ChromePhp。
ChromePhp这个调试工具，总体上来说，还是挺好用的。
安装起来也比较简单，只需要为chrome添加一个扩展程序，然后下载ChromePhp类即可。
安装完成后，点亮chrome浏览器上的chromePhp图标后，就可以这么使用了：
*/

include './ChromePhp.php';
ChromePhp::log('hello world');
ChromePhp::log($_SERVER);
 
// using labels
foreach ($_SERVER as $key => $value) {
    ChromePhp::log($key, $value);
}
 
// warnings and errors
ChromePhp::warn('this is a warning');
ChromePhp::error('this is an error');
ChromePhp::info('this is an message');

?>