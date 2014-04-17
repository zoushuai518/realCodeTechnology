<?php
header("Content-type: text/html; charset=utf-8");
$start_time = time();

class Scd {
	private $_mysql_link;
	/**
	 * 创建MYSQL链接
	 * @param string  $host
	 * @param string $user
	 * @param string $pass
	 * @param string $db
	 */
	public function createMysqlLink( $host, $user, $pass, $db) {
		$this->_mysql_link = mysql_connect( $host, $user, $pass);
		if (!$this->_mysql_link)
		{
			die('连接数据库失败: ' . $this->get_mysql_error());
		}
		mysql_select_db( $db, $this->_mysql_link);
	}
	
	/**
	 * 创建要插入的表
	 */
	private function crateTable() {
		$sql = "CREATE TABLE IF NOT EXISTS `t_scd` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `DOCID` char(32) NOT NULL,
				  `Url` varchar(200) NOT NULL,
				  `Brand05` varchar(100) NOT NULL DEFAULT '',
				  `Taste07` varchar(100) NOT NULL,
				  `Service09` varchar(100) NOT NULL,
				  `Brand18` varchar(100) NOT NULL,
				  `Env08` varchar(100) NOT NULL,
				  `Brand04` varchar(100) NOT NULL,
				  `BusinessTime13` varchar(300) NOT NULL,
				  `Label14` varchar(300) NOT NULL,
				  `Area03` varchar(100) NOT NULL,
				  `Menu15` varchar(100) NOT NULL,
				  `Price06` varchar(100) NOT NULL,
				  `Shangquan19` varchar(100) NOT NULL,
				  `Score10` varchar(100) NOT NULL,
				  `MenuImgs16` varchar(200) NOT NULL,
				  `ShopName01` varchar(100) NOT NULL,
				  `Telephone12` varchar(100) NOT NULL,
				  `Address11` varchar(200) NOT NULL,
				  `City02` varchar(100) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=ARCHIVE  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
		$this->query( $sql);
	}
	
	private function query( $sql) {
		mysql_query( $sql);
	}
	
	private function close() {
		mysql_close( $this->_mysql_link);
	}
	
	private function get_mysql_error() {
		return mysql_error();
	}
	
	public function run( ) {
		$file_path = './B-00-201403041536-46927-I-C.SCD';	//文件路径
		$host = "localhost";
		$user = "root";
		$pass = "3231615";
		$db = "b5m_adrs_20140313";
		
		$str = file_get_contents( './B-00-201403041536-46927-I-C.SCD');
		preg_match_all( '/([\s\S]+)\n\n/U', $str, $out, PREG_PATTERN_ORDER);
		unset($str);
		if ( isset($out[1])) {
			$sql_tmp = "INSERT INTO `t_scd` (`DOCID`, `Url`, `Brand05`, `Taste07`, `Service09`, `Brand18`, `Env08`, `Brand04`, `BusinessTime13`, `Label14`, `Area03`, `Menu15`, `Price06`, `Shangquan19`, `Score10`, `MenuImgs16`, `ShopName01`, `Telephone12`, `Address11`, `City02`) VALUES ";
			$sql_value_list = "";
			$i=0;
			$this->createMysqlLink($host, $user, $pass, $db);
			$this->crateTable();
			foreach ( $out[1] as $v) {
				$i++;
				preg_match_all( '/(<.+>)([^<>]*)/', $v, $out_v, PREG_PATTERN_ORDER);
				$out0 = rtrim( $out_v[2][0], "\n");
				$out1 = rtrim( $out_v[2][1], "\n");
				$out2 = rtrim( $out_v[2][2], "\n");
				$out3 = rtrim( $out_v[2][3], "\n");
				$out4 = rtrim( $out_v[2][4], "\n");
				$out5 = rtrim( $out_v[2][5], "\n");
				$out6 = rtrim( $out_v[2][6], "\n");
				$out7 = rtrim( $out_v[2][7], "\n");
				$out8 = addslashes( rtrim( $out_v[2][8], "\n"));
				$out9 = rtrim( $out_v[2][9], "\n");
				$out10 = rtrim( $out_v[2][10], "\n");
				$out11 = rtrim( $out_v[2][11], "\n");
				$out12 = rtrim( $out_v[2][12], "\n");
				$out13 = rtrim( $out_v[2][13], "\n");
				$out14 = rtrim( $out_v[2][14], "\n");
				$out15 = rtrim( $out_v[2][15], "\n");
				$out16 = addslashes( rtrim( $out_v[2][16], "\n"));
				$out17 = rtrim( $out_v[2][17], "\n");
				$out18 = addslashes( rtrim( $out_v[2][18], "\n"));
				$out19 = rtrim( $out_v[2][19], "\n");
				
				$sql_value_list .= "('$out0','$out1','$out2','$out3','$out4','$out5','$out6','$out7','$out8','$out9','$out10','$out11','$out12','$out13','$out14','$out15','$out16','$out17','$out18','$out19'),";
				if ( $i % 2000 == 0) {
					$this->query( rtrim( $sql_tmp . $sql_value_list, ",") . ";");
					if ( mysql_error()) {
						echo rtrim( $sql_tmp . $sql_value_list, ",") . ";";
						echo $this->get_mysql_error();
					}
					$sql_value_list = "";
				}
			}
			$sql = rtrim( $sql_tmp . $sql_value_list, ",") . ";";
			$this->query($sql);
			echo $this->get_mysql_error();
			$this->close();
		}
	}
}
$scd = new Scd();
$scd->run();

echo "耗时" . (time() - $start_time) . "秒";
