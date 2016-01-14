<?php

//PHP面试题之驼峰字符串转换成下划线样式例子


    //ag 1:
    $str = 'OpenAPI';
    $length = mb_strlen($str);
    $new = '';
    for($i = 0; $i < $length; $i++)
    {
        $num = ord($str[$i]);
        $pre = ord($str[$i - 1]);
        $new .= ($i != 0 && ($num >= 65 && $num <= 90) && ($pre >= 97 && $pre <= 122)) ? "_{$str[$i]}" : $str[$i];
    }
echo strtolower($new) . PHP_EOL;



    //ag 2:
    $str = 'urlSgtsItsd';
    echo strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str)).'<br>';