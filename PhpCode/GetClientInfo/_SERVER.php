<?php 

	echo '<pre>';
	print_r($_SERVER);



/*
	服务器变量 $_SERVER 详解：

1、$_SESSION['PHP_SELF'] -- 获取当前正在执行脚本的文件名

2、$_SERVER['SERVER_PROTOCOL'] -- 请求页面时通信协议的名称和版本。例如，“HTTP/1.0”。

3、$_SERVER['REQUEST_TIME'] -- 请求开始时的时间戳。从 PHP 5.1.0 起有效。和time函数效果一样。

4、$_SERVER['argv'] -- 传递给该脚本的参数。我试了下，get方法可以得到$_SERVER['argv'][0]；post方法无法给他赋值。

5、$_SERVER['SERVER_NAME'] -- 返回当前主机名。

6、$_SERVER['SERVER_SOFTWARE'] -- 服务器标识的字串，在响应请求时的头信息中给出。 如Microsoft-IIS/6.0

7、$_SERVER['REQUEST_METHOD'] -- 访问页面时的请求方法。例如：“GET”、“HEAD”，“POST”，“PUT”。

8、$_SERVER['QUERY_STRING'] -- 查询（query）的字符串（URL 中第一个问号 ? 之后的内容）。

9、$_SERVER['DOCUMENT_ROOT'] -- 当前运行脚本所在的文档根目录。在服务器配置文件中定义。 如E:\server

10、$_SERVER['HTTP_ACCEPT'] -- 当前请求的 Accept: 头信息的内容。

11、$_SERVER['HTTP_ACCEPT_CHARSET'] -- 当前请求的 Accept-Charset: 头信息的内容。例如：“iso-8859-1,*,utf-8”。

12、$_SERVER['HTTP_ACCEPT_ENCODING'] -- 当前请求的 Accept-Encoding: 头信息的内容。例如：“gzip”。

13、$_SERVER['HTTP_ACCEPT_LANGUAGE'] -- 当前请求的 Accept-Language: 头信息的内容。例如：“en”。

14、$_SERVER['HTTP_CONNECTION'] -- 当前请求的 Connection: 头信息的内容。例如：“Keep-Alive”。

15、$_SERVER['HTTP_HOST'] -- 当前请求的 Host: 头信息的内容。

16、$_SERVER['HTTP_REFERER'] -- 链接到当前页面的前一页面的 URL 地址。

17、$_SERVER['HTTP_USER_AGENT'] -- 返回用户使用的浏览器信息。也可以使用 get_browser() 得到此信息。

18、$_SERVER['HTTPS'] -- 如果通过https访问，则被设为一个非空的值，否则返回off.

19、$_SERVER['REMOTE_ADDR'] -- 正在浏览当前页面用户的 IP 地址。

20、$_SERVER['REMOTE_HOST'] -- 正在浏览当前页面用户的主机名。反向域名解析基于该用户的 REMOTE_ADDR。如本地测试返回127.0.0.1

21、$_SERVER['REMOTE_PORT'] -- 用户连接到服务器时所使用的端口。我在本机测试没通过，不知道什么原因。

22、$_SERVER['SCRIPT_FILENAME'] -- 当前执行脚本的绝对路径名。如返回E:\server\index.php

23、$_SERVER['SERVER_ADMIN'] -- 该值指明了 Apache 服务器配置文件中的 SERVER_ADMIN 参数。如果脚本运行在一个虚拟主机上，则该值是那个虚拟主机的值

24、$_SERVER['SERVER_PORT'] -- 服务器所使用的端口。默认为“80”。如果使用 SSL 安全连接，则这个值为用户设置的 HTTP 端口。

25、$_SERVER['SERVER_SIGNATURE'] -- 包含服务器版本和虚拟主机名的字符串。

26、$_SERVER['PATH_TRANSLATED'] -- 当前脚本所在文件系统（不是文档根目录）的基本路径。这是在服务器进行虚拟到真实路径的映像后的结果。 Apache 2 用 户可以使用 httpd.conf 中的 AcceptPathInfo On 来定义 PATH_INFO。

27、$_SERVER['SCRIPT_NAME'] -- 包含当前脚本的路径。这在页面需要指向自己时非常有用。__FILE__ 包含当前文件的绝对路径和文件名（例如包含文件）。

28、$_SERVER['REQUEST_URI'] -- 访问此页面所需的 URI。例如，“/index.html”。

29、$_SERVER['PHP_AUTH_DIGEST'] -- 当作为 Apache 模块运行时，进行 HTTP Digest 认证的过程中，此变量被设置成客户端发送的“Authorization”HTTP 头内容（以便作进一步的认证操作）。

30、$_SERVER['PHP_AUTH_USER']-- 当 PHP 运行在 Apache 或 IIS（PHP 5 是 ISAPI）模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的用户名。

31、$_SERVER['PHP_AUTH_PW'] -- 当 PHP 运行在 Apache 或 IIS（PHP 5 是 ISAPI）模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的密码。

32、$_SERVER['AUTH_TYPE']--当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是认证的类型。

*/


?>