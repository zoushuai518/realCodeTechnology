<?php
/**
* 数据库操作
*/
class ScdDb
{
    private $_pdo = null;

    public function __construct($db=array()) {
        $this->_pdo = $this->_getPdo($db);
    }

    // 数据库连接
    private function _getPdo($db) {
        try {
            $pdo = new PDO($db['dsn'],$db['username'],$db['passwd']);
            // 设置编码
            $pdo->query("set names {$db['charset']}");
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $pdo;
    }

    // insert data for mysql
    protected function _setDb($scd_str) {
        $sql = "INSERT INTO `scd` (DOCID,Url,Brand05,Taste07,Service09,Brand18,Env08,Brand04,BusinessTime13,Label14,Area03,Menu15,Price06,Shangquan19,Score10,MenuImgs16,ShopName01,Telephone12,Address11,City02) VALUES ".$scd_str;
        $this->_pdo->exec($sql);
        if($this->_pdo->lastInsertId()){
            return '入库成功'.$this->_pdo->lastInsertId().'<br />';
        }else
            return '入库失败'.'<br />';
        unset($scd_str);
        $this->_close();
    }

    // 关闭数据库连接
    private static function _close() {
        return $this->_pdo = null;
    }

}
