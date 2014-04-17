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
            return true;
        }else{
            return file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'error_log'.date('Y-m-d',time()).'.txt',$scd_str,LOCK_EX);
        }
        unset($scd_str);
        $this->_close();
    }

    // query
    protected function _getRow(){
        $sql_count = 'SELECT t.id FROM scd as t order by id DESC limit 0,1';
        $rs = $this->_pdo->query($sql_count);
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $max_id = $rs->fetch();
        return $max_id['id']?$max_id['id']:$max_id;
    }

    // 关闭数据库连接
    private function _close() {
        return $this->_pdo = null;
    }

}
