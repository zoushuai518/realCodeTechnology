<?php
$config = require('config.php'); //载入配置
require_once('ScdDb.php');  //载入db操作类

/**
* SF1 SCD解析类
* @weiyan
*/
class ScdAnalytical extends ScdDb
{
    private $_config = array();
    public function __construct($db=array()) {
        ini_set('memory_limit','256M');
        set_time_limit(0);
        parent::__construct($db['db']);
        $this->_config = $db['scd'];
    }

    // 返回SCD数组
    public function handleScd() {
        $num      = 0;    //计数器
        $scd_arrs = array();
        $scd_arr  = array();
        $col_str  = '';
        // 只读方式打开
        $handle = fopen($this->_config['scd_path'], "rb");
        if($handle) {
            while(!feof($handle))
            {
                $col_str = fgets($handle,$this->_config['col_lenth']);  // 逐行读取
                $str_l_len = strpos($col_str,'<');
                $str_r_len = strpos($col_str,'>');
                if($str_l_len===0 && ($str_r_len!==0 && $str_r_len!=false)){
                    $col_key = substr($col_str,$str_l_len+1,$str_r_len-1);
                    $scd_arr[$col_key] = str_replace('<'.$col_key.'>','',$col_str);
                }else{
                    $scd_arr[$col_key] .= $col_str;
                }
                if($col_str===PHP_EOL) {
                    $scd_arrs[] = $scd_arr;
                    ++$num;
                }
                // 每次向 mysql数据库 insert $count条数据
                if(isset($scd_arrs['0']) && $num%$this->_config['db_count']==0) {
                    ($num == $this->_config['db_count']) && $min_row_id = $this->_getRow();     //不是友好的写法,仅仅debug使用
                    $this->_arrToString($scd_arrs);
                    unset($scd_arrs);
                }
            }
            $this->_arrToString($scd_arrs);
            $max_row_id = $this->_getRow();     //不是友好的写法,仅仅debug使用
            $zengjia_row = !empty($max_row_id)?($max_row_id - (empty($min_row_id)?0:$min_row_id)):'data no insert';
            return '数据库增加：' . $zengjia_row . '行<br / >' . 'SCD文件记录数：' . $num .'行';
        }

        fclose($handle);    // close file handle
    }

    // array to string
    private function _arrToString($arr = array()) {
        $strs = '';
        foreach ($arr as $k => $v) {
            foreach ($v as $k_s => $v_s) {
                $str .= ',\''.addslashes(trim($v_s)).'\'';  //字符串处理,入库做准备
            }
            $strs .= ',('.ltrim($str,',').')';
            unset($str);
        }
        return $this->_setDb(ltrim($strs,','));
    }

}

error_reporting(E_ALL ^E_NOTICE);
$t1      = microtime(true);
$scd     = new ScdAnalytical($config);
$scd_str = $scd->handleScd();
$t2      = microtime(true);
echo '<br />',$scd_str;
$t = $t2-$t1;
echo '<br />执行时间',$t;

?>