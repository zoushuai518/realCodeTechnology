<?php
/**
* SF1 SCD解析
*/
class ScdAnalytical
{

    // SCD 字段列表
    private static function _scdCloArr(){
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
        // return array_flip($column_array);
        return $column_array;
    }

    // SCD 返回数组
    public static function handleScd($scd_file){
        $num;    //计数器
        $col_arr = self::_scdCloArr();
        $scd_strs = '';
        $scd_str = '';
        $scd_arrs = array();
        $scd_arr = array();
        $col_str = '';
        // 只读方式打开
        $handle = fopen($scd_file,"r");
        if($handle){
            while(!feof($handle))
            {
                $col_str = fgets($handle);  // 逐行读取
                $str_len = strpos($col_str,'>');    //判定读入行中是否包含 >
                ($str_len!==false) && $col_key = substr($col_str,1,$str_len-1);     //取出SCD栏位名
                (in_array($col_key,$col_arr) && $str_len!==false) && $scd_arr[$col_key] = str_replace('<'.$col_key.'>','',$col_str);    // 赋值给数组
                $str_len || $scd_arr[$col_key] .= $col_str;     //连接为上一个 SCD栏位的值
                (strpos($col_str,'City02')) && $scd_arrs[] = $scd_arr;      //拼接为二维数组
                (strpos($col_str,'City02')) && ++$num;
            }
        }
        // fclose($handle);
        if($scd_arrs)
            // 数组转换为字符
            // return $scd_arrs;
            return self::_arrToString($scd_arrs);
  }


  private static function _arrToString($arr = array()){
    echo '<pre>';
        $strs = '';
        foreach ($arr as $k => $v) {
            foreach ($v as $k_s => $v_s) {
                $str .= ',\''.addslashes(trim($v_s)).'\'';  //字符串处理,入库做准备
            }
           $strs .= ',('.ltrim($str,',').')';
           unset($str);
        }
        return ltrim($strs,',');
  }

}

error_reporting(E_ALL ^E_NOTICE);


$t1 = microtime(true);
$scd_file_path = dirname(__FILE__) . '/scd.SCD';
$scd_str = ScdAnalytical::handleScd($scd_file_path);
echo '<pre>';
// print_r($scd_str);
$t2 = microtime(true);
$t = $t2-$t1;
// db start
$b5m = dirname(__FILE__) . '/b5m/db/BDbConnection.php';
require_once($b5m);
$config = dirname(__FILE__) . DIRECTORY_SEPARATOR .'protected/config/config.php';
$config = require($config);
$pdo_con = new BDbConnection();
$fpdo = $pdo_con->_getPdo($config);
$sql = "INSERT INTO `scd` (DOCID,Url,Brand05,Taste07,Service09,Brand18,Env08,Brand04,BusinessTime13,Label14,Area03,Menu15,Price06,Shangquan19,Score10,MenuImgs16,ShopName01,Telephone12,Address11,City02) VALUES ".$scd_str;
// echo $sql;
$fpdo->exec($sql);
if($fpdo->lastInsertId())
    echo '入库成功'.$fpdo->lastInsertId().'-'.$t;
else
    echo '入库失败';
// db end