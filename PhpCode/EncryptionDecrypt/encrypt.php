<?php
    //zs测试可用
    //加密/解密函数

    // $id = 132;
    $id = 'cheat_pay';
    
    $token = encrypt($id, 'E', 'nowamagic');
    
    echo '加密:'.encrypt($id, 'E', 'nowamagic');
    echo '<br />';
    
    echo '解密：'.encrypt($token, 'D', 'nowamagic');
    
    /*********************************************************************
    函数名称:encrypt
    函数作用:加密解密字符串
    使用方法:
    加密     :encrypt('str','E','nowamagic');
    解密     :encrypt('被加密过的字符串','D','nowamagic');
    参数说明:
    $string   :需要加密解密的字符串
    $operation:判断是加密还是解密:E:加密   D:解密
    $key      :加密的钥匙(密匙);
    *********************************************************************/
    function encrypt($string,$operation,$key='')
    {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return'';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }

    /*
    function encrypt($string,$operation,$key='')
    {
        $key          = md5($key);
        $key_length   = strlen($key);
        $string       = $operation == 'D' ? base64_decode($string) : substr(md5($string.$key), 0, 8).$string;
        $string_length= strlen($string);
        $rndkey       = $box = array();
        $result       = '';
        for ($i=0; $i <= 255; $i++) {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]   =$i;
        }
        for ($j=$i=0; $i < 256; $i++) {
            $j      =($j+$box[$i]+$rndkey[$i])%256;
            $tmp    =$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for ($a=$j=$i= 0; $i < $string_length; $i++) {
            $a      =($a+1)%256;
            $j      =($j+$box[$a])%256;
            $tmp    =$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8). $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return'';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }
    */
?>
