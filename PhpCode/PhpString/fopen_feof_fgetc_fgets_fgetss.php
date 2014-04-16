<?php
/*然后介绍两个函数fgets()和fgetc()这两个在s和c的区别 很容易理解s代表的是string 而c代表的char
fgets()  三种情况下会遇到该情况：(1) 碰到换行符（包括在返回值中）.(2) 遇到 EOF 时会中断文件的读取工作.(3) 已经读取了 length - 1 字节后停止
fgetc()是逐个逐个读取文件中的内容读出一个就会中断
下面就展示示例程序
      test.txt是测试文件 里面的内容是abcdefghijk*/

/*fgets():从 handle 指向的文件中读取一行并返回长度最多为 length - 1 字节的字符串。碰到换行符（包括在返回值中）、EOF 或者已经读取了 length - 1 字节后停止（看先碰到那一种情况）。如果没有指定 length，则默认为 1K，或者说 1024 字节
-
注意: length 参数从 PHP 4.2.0 起成为可选项，如果忽略，则行的长度被假定为 1024。从 PHP 4.3 开始，忽略掉 length 将继续从流中读取数据直到行结束。如果文件中的大多数行都大于 8KB，则在脚本中指定最大行的长度在利用资源上更为有效。

注意: 从 PHP 4.3 开始本函数可以安全用于二进制文件。早期的版本则不行。

注意: 如果碰到 PHP 在读取文件时不能识别 Macintosh 文件的行结束符，可以激活 auto_detect_line_endings 运行时配置选项。
*/

    $file = fopen("Test.txt",r);
   while(! feof($file))
   {
       echo fgets($file). "<br />"; 
    }
  fclose($file); 
// 显示的结果是 abcdefghijk


    $file = fopen("Test.txt",r);
   while(! feof($file))
   {
       echo fgetc($file). "<br />"; 
    }
  fclose($file); 
// 显示的结果是a
// b
// c
// d
// e
// f
// j
// k