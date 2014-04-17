<?php


    /**
     * 从数组中随机取数
     */    
    function getArrayRandData($arr,$length){
        if(count($arr)<=0 || !is_array($arr))
            return;
        $rand_data = array();
        $len = count($arr)<$length?count($arr):$length;
        $rand_keys = array_rand($arr,$len);
        foreach ($rand_keys as $k => $v) {
            $rand_data[] = $arr[$v];
        }
        return $rand_data;
    }

?>
