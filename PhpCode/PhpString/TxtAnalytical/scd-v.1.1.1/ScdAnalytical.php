<?php
$config = require('config.php'); //载入配置
require_once('ScdDb.php');  //载入db操作类

//////////////////////////////////////////////
// scd解析程序可扩展性，不高。如果scd文件字段有增加，会需要修改程序，和表结构 //
//////////////////////////////////////////////

/**
* SF1 SCD解析类
* @weiyan
* @v1.1.1
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
    // SCD 字段列表
    private static function _scdCloArr() {
        $column_array = array(
                'DOCID',
                'Url',
                'Brand05',
                'Taste07',
                'Service09',
                'Brand18',
                'Env08',
                'Brand04',
                'BusinessTime13',
                'Label14',
                'Area03',
                'Menu15',
                'Price06',
                'Shangquan19',
                'Score10',
                'MenuImgs16',
                'ShopName01',
                'Telephone12',
                'Address11',
                'City02',
            );
        return $column_array;
    }

    // 返回SCD数组
    public function handleScd() {
        $num=0;    //计数器
        $col_arr = self::_scdCloArr();
        $scd_arrs = array();
        $scd_arr = array();
        $col_str = '';
        // 只读方式打开
        $handle = fopen($this->_config['scd_path'], "rb");
        if($handle) {
            while(!feof($handle))
            {
                $col_str = fgets($handle,$this->_config['col_lenth']);  // 逐行读取
                $str_len = strpos($col_str,'>');
                if($str_len && in_array(substr($col_str,1,$str_len-1), $col_arr)) {
                    $col_key = substr($col_str,1,$str_len-1);
                    $scd_arr[$col_key] = str_replace('<'.$col_key.'>','',$col_str);
                } else {
                     $scd_arr[$col_key] .= $col_str;
                }
                if(strpos($col_str, 'City02')) {
                    $scd_arrs[] = $scd_arr;
                    ++$num;
                }
                // 每次向 mysql数据库 insert $count条数据
                if($scd_arrs && $num%$this->_config['db_count']==0) {
                    var_dump($this->_arrToString($scd_arrs));
                    unset($scd_arrs);
                }
            }
            // insert 最后小于 $count条数据
            $lg_num = $this->_arrToString($scd_arrs);
            echo '剩余',$lg_num;
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
$t1 = microtime(true);
$scd = new ScdAnalytical($config);
$scd_str = $scd->handleScd();
$t2 = microtime(true);

echo '<br />';
echo $scd_str;
$t = $t2-$t1;
echo '执行时间',$t;

?>