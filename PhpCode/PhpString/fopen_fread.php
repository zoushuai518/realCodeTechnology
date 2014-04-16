<?php


/* feof()  如果文件读到了最后或者是文件读到EOF还有一种情况是文件读取错误的时候  返回的是true  否则是返回false
介绍一个循环读取文件的例子*/
$file = fopen("Test1.txt","r+");

       while(!feof($file))

       {

          echo "Cirle!";

     }
// 这个如果没有出意外的话会读到文件的结尾才会罢休