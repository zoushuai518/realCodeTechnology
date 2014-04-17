<?php

// 配置文件
return array(
    'db'=>array(
        'dsn'=>'mysql:host=127.0.0.1;dbname=b5m_scd',
        'username'=>'root',
        'passwd'=>'',
        'charset'=>'utf8',
    ),
    'scd'=>array(
        'scd_path'=>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'scd.SCD.bak',
        'col_lenth'=>2048,
        'db_count'=>1000,
    ),

);

?>