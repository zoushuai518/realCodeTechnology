<?php
/**
* SF1 SCD解析类
* @weiyan
* @v1.1.0 原始版本
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
        return $column_array;
    }

    // 返回SCD数组
    public static function handleScd($scd_file,$count){
        $num=0;    //计数器
        $col_arr = self::_scdCloArr();
        $scd_arrs = array();
        $scd_arr = array();
        $col_str = '';
        // 只读方式打开
        $handle = fopen($scd_file,"rb");
        if($handle){
            while(!feof($handle))
            {
                $col_str = fgets($handle);  // 逐行读取
                $str_len = strpos($col_str,'>');    //判定读入行中是否包含 >
                ($str_len!==false) && $col_key = substr($col_str,1,$str_len-1);     //取出SCD栏位名
                // ($str_len!==false) && in_array(substr($col_str,1,$str_len-1),$col_arr) && $col_key = substr($col_str,1,$str_len-1);     //取出SCD栏位名
                (in_array($col_key,$col_arr) && $str_len!==false) && $scd_arr[$col_key] = str_replace('<'.$col_key.'>','',$col_str);    // 赋值给数组
                $str_len || $scd_arr[$col_key] .= $col_str;     //连接为上一个 SCD栏位的值
                (strpos($col_str,'City02')) && $scd_arrs[] = $scd_arr;      //拼接为二维数组
                (strpos($col_str,'City02')) && ++$num;
                // 每次向 mysql数据库 insert 1000条数据
                if($scd_arrs && $num%$count==0){
                    var_dump(self::_arrToString($scd_arrs));
                    unset($scd_arrs);
                    // unset($$scd_arr);
                }
            }
            // insert 最后小于 $count条数据
            $lg_num = self::_arrToString($scd_arrs);
            echo '剩余',$lg_num;
        }
        fclose($handle);    // close file handle
    }

    // array to string
    private static function _arrToString($arr = array()){
        $strs = '';
        foreach ($arr as $k => $v) {
            foreach ($v as $k_s => $v_s) {
                $str .= ',\''.addslashes(trim($v_s)).'\'';  //字符串处理,入库做准备
            }
            $strs .= ',('.ltrim($str,',').')';
            unset($str);
        }
        return self::_setDb(ltrim($strs,','));
    }

    // insert data for mysql
    private static function _setDb($scd_str){
        $b5m = dirname(__FILE__) . '/BDbConnection.php';
        require_once($b5m);
        $pdo_con = new BDbConnection();
        $fpdo = $pdo_con->_getPdo();
        $sql = "INSERT INTO `scd` (DOCID,Url,Brand05,Taste07,Service09,Brand18,Env08,Brand04,BusinessTime13,Label14,Area03,Menu15,Price06,Shangquan19,Score10,MenuImgs16,ShopName01,Telephone12,Address11,City02) VALUES ".$scd_str;
        $fpdo->exec($sql);
        if($fpdo->lastInsertId()){
            return '入库成功'.$fpdo->lastInsertId().'<br />';
        }else
            return '入库失败'.'<br />';
        unset($scd_str);
    }

}

error_reporting(E_ALL ^E_NOTICE);
set_time_limit(0);  //0为无限制
// init_set('memory_limit','256M')  //设置内存
$t1 = microtime(true);
$scd_file_path = dirname(__FILE__) . '/scd.SCD.bak';
$scd_str = ScdAnalytical::handleScd($scd_file_path,1000);
// $scd_str = ScdAnalytical::handleScd($scd_file_path,4000);
$t2 = microtime(true);

echo '<br />';
echo $scd_str;
$t = $t2-$t1;
echo '执行时间',$t;

