<?php
/**
 * 解析SCD数据并写到数据库
 * @author CuiLin <jingqing@b5m.com>
 * @since 2014.03.26
 * @package scdToDB
 */
$params = [
	'scd' => [
		'read_length' => 4096, //读取文件一行的字节数
		'insert_db_count' => 500, //当数组总数达到这个数目的时候再添加到DB
	],
	'db' => [
		'host' => 'localhost',
		'port' => 3306,
		'user_name' => 'root',
		'user_pass' => '123465',
		'db_name' => 'scd',
		'table_name' => 'dianping_data',
		'charset' => 'utf8', 
	],
	'file' => [
		'path' => '/data/document/',
		'name' => 'B-00-201403041536-46927-I-C.SCD',
	],
];

class SCD extends DB {
	protected $_params = [];
	protected $_key_array = [];
	
	public function __construct($params = []) {
		ini_set('memory_limit','256M');
		set_time_limit(0);
		if($params) {
			$this->_params = $params;
		}
		
		$this->_key_array = [
			'DOCID' 			=> 'doc_id',
			'Url' 				=> 'url',
			'Brand05' 			=> 'brand05',
			'Taste07' 			=> 'taste07',
			'Service09' 		=> 'service09',
			'Brand18' 			=> 'brand18',
			'Env08' 			=> 'env08',
			'Brand04' 			=> 'brand04',
			'BusinessTime13' 	=> 'business_time',
			'Label14' 			=> 'label14',
			'Area03' 			=> 'area03',
			'Menu15' 			=> 'menu15',
			'Price06' 			=> 'price06',
			'Shangquan19' 		=> 'shangquan19',
			'Score10' 			=> 'score10',
			'MenuImgs16' 		=> 'menu_imgs16',
			'ShopName01' 		=> 'shop_name01',
			'Telephone12' 		=> 'telephone12',
			'Address11' 		=> 'address11',
			'City02' 			=> 'city02',
		]; 
	}
	
	public function getSCDToArray() {
		$start_time = microtime(true);
		$file_name = $this->_get_real_file_name();
		if($file_name) {
			$fp = fopen($file_name,'r');
			if(!$fp) {
				return false;
			} 
			
			$i = $k = 1;
			$scd_data = [];
			while(!feof($fp)) {
				$content = fgets($fp);
				$content = preg_replace("/\s/","",$content);
				
				if($content) {
					$end_position = strpos($content,'>');
					if($end_position) {
						$scd_value = substr($content,$end_position + 1);
					} else {
						$scd_value .= '<br />'.$content;
						$k -= 1;
					}
					$scd_data[$i][$k] = addslashes($scd_value);
				} else {
					if($i == $this->_params['scd']['insert_db_count']) {
						$this->insert($scd_data);
						$scd_data = [];
						$i = 1;
					}
					$i++;
				}
				$k++;
			}
		}
		
		$end_time = microtime(true);
		return $end_time - $start_time;
	}
	
	private function _get_real_file_name() {
		$file_name = rtrim($this->_params['file']['path'],'/').'/'.ltrim($this->_params['file']['name'],'/');
		if(!file_exists($file_name)) {
			return false;
		}
		
		return $file_name;
	}
	
	
}

class DB {
	private $_connection = null;
	
	protected function insert($scd_data = []) {
		$this->_set_connection();
		
		if(!$this->_connection) {
			return false;
		}
		
		$sql = '';
		$keys = implode(',',array_values($this->_key_array));
		$sql_prefix = "INSERT INTO `{$this->_params['db']['table_name']}`({$keys}) VALUES ";
		
		foreach($scd_data as $scd_value) {
			$sql .= '(';
			foreach($scd_value as $scd) {
				$sql .= "'{$scd}',";
			}
			$sql = rtrim($sql,',');
			$sql .= '),';
		}
		$sql = rtrim($sql,',');
		
		$real_sql = $sql_prefix.rtrim($sql,',');
		
		$this->_connection->query($real_sql);
	}
	
	private function _set_connection() {
		if(!$this->_connection) {
			$this->_connection = new mysqli(
					$this->_params['db']['host'],
					$this->_params['db']['user_name'],
					$this->_params['db']['user_pass'],
					$this->_params['db']['db_name']
			);
			
			if(mysqli_connect_errno()) {
				return false;
			}
			
			$this->_connection->query("SET NAMES `{$this->_params['db']['charset']}`");
		}
	}
	
	protected function _log($data = []) {
		if(is_array($data) || is_object($data)) {
			$data = print_r($data,true);
		}
		
		file_put_contents('/data/log/'.date('Y-m-d').'.log',$data."\n\n",FILE_APPEND);
	}
}

$scd = new SCD($params);
var_dump($scd->getSCDToArray());
?>