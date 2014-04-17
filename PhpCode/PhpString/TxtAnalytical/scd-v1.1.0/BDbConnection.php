<?php
// 待完善
/**
* 数据库连接
* @ v1.0
*/
class BDbConnection
{

    public function _getPdo(){
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=b5m_scd','root','');
            // 设置编码
            $pdo->query("set names utf8");
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $pdo;
    }

    private static function _getMysql(){

    }

    private static function _getMysqli(){

    }

    // 连接数据库异常
    private static function _getError(){

    }

    // 关闭数据库连接
    private static function _close(){

    }

}
