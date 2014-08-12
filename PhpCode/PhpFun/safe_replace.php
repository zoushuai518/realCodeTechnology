<?php

/**
  * 安全过滤函数
  *
  * @param $string
  * @return string
  */
 function safe_replace($string) {
     $string = str_replace('%20','',$string);
     $string = str_replace('%27','',$string);
     $string = str_replace('%2527','',$string);
     $string = str_replace('*','',$string);
     $string = str_replace('"','"',$string);
     $string = str_replace("'",'',$string);
     $string = str_replace('"','',$string);
     $string = str_replace(';','',$string);
     $string = str_replace('<','<',$string);
     $string = str_replace('>','>',$string);
     $string = str_replace("{",'',$string);
     $string = str_replace('}','',$string);
     return $string;
 }

?>