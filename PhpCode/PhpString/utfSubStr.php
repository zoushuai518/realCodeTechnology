<?php


/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param string  $str    被截取的字符串
 * @param int     $length 截取的长度
 * @param bool    $append 是否附加省略号
 *
 * @return  string
 */
function utfSubStr( $str, $length = 0, $append = true ) {
    $str = trim( $str );
    $strlength = strlen( $str );

    if ( $length == 0 || $length >= $strlength ) {
        return $str;
    }
    elseif ( $length < 0 ) {
        $length = $strlength + $length;
        if ( $length < 0 ) {
            $length = $strlength;
        }
    }

    if ( function_exists( 'mb_substr' ) ) {
        $newstr = mb_substr( $str, 0, $length, EC_CHARSET );
    }
    elseif ( function_exists( 'iconv_substr' ) ) {
        $newstr = iconv_substr( $str, 0, $length, EC_CHARSET );
    }
    else {
        //$newstr = trim_right(substr($str, 0, $length));
        $newstr = substr( $str, 0, $length );
    }

    if ( $append && $str != $newstr ) {
        $newstr .= '...';
    }

    return $newstr;
}






?>
