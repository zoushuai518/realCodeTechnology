<?php
header("Content-type: text/html; charset=utf-8"); 

/**
* Read .SCD File
* @Author : CaoCao
*/
class SCD 
{

	private $db;

	private $block = '';
	private $handle;
	private $concated_sql_num = 2000;

	function __construct() {

	}

	public function db_connect($db_host, $db_user, $db_pass) {

		$con = mysql_connect($db_host, $db_user, $db_pass);

		if (!$con) {
			die('Could not connect: ' . mysql_error());
		} else {
			$this->db = $con;
		}

		$db_selected = mysql_select_db("test", $con);

		if (!$db_selected) {
			die ("Can\'t use test_db : " . mysql_error());
		}

		mysql_query("set names utf8"); 
	}

	public function open_file($file_name) {

		$this->handle = fopen($file_name, "r") or die("Couldn't get handle");	
	}

	protected function block_structure() {

		return array("<DOCID>","<Url>","<Brand05>","<Taste07>","<Service09>","<Brand18>","<Env08>","<Brand04>","<BusinessTime13>","<Label14>","<Area03>","<Menu15>","<Price06>","<Shangquan19>","<Score10>","<MenuImgs16>","<ShopName01>","<Telephone12>","<Address11>","<City02>");

	}

	protected function parse_block($block) {

    	$block = addslashes($block);    //slow

		$exploded = $this->multiexplode($this->block_structure(), $block);

		return $exploded;
	}

	protected function multiexplode($delimiters,$string) {

	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
	}

	public function read_file() {

		$start_time = microtime(true);

		$handle = $this->handle;
		$db = $this->db;
		$block_length = count($this->block_structure());
		$count = 0;
		$block = '';
		$sql_values = array();
		$error_log = array();

		if ($handle) {

		    while (!feof($handle)) {

		        $buffer = fgets($handle, 4096);

		        if($buffer == PHP_EOL) {

		        	$sql_value = '';

		            $parsed_block = $this->parse_block($block);		// $parsed_block is the block array

		            if(count($parsed_block) == $block_length+1) {	// Check if the items in the block is correct, +1 b/c 1st value of the block is empty

		                foreach ($parsed_block as $k => $v) {
		                    if($k == 0) continue;
		                    $sql_value .= "'".$v."',";
		                }

		                $sql_value = '('.rtrim($sql_value, ',').')';

		                if($count == $this->concated_sql_num) {		// e.g insert 2000 values in 1 sql

		                    $sql = implode(',', $sql_values);
		                    $sql = "INSERT INTO scd  (`DOCID`, `Url`, `Brand05`, `Taste07`, `Service09`, `Brand18`, `Env08`, `Brand04`, `BusinessTime13`, `Label14`, `Area03`, `Menu15`, `Price06`, `Shangquan19`, `Score10`, `MenuImgs16`, `ShopName01`, `Telephone12`, `Address11`, `City02`) VALUES ".$sql;
		                    $result = mysql_query($sql,$db);

		                    if($result == false) {		// Something is wrong with the query, log the DOCID:
		                        array_push($error_log, $sql_values[0][1]);
		                    }

		                    $sql_values = array();
		                    $count = 0;

		                } else {
		                    $count = array_push($sql_values, $sql_value); 	// Keep adding values for the sql
		                }
		            } else {
		                array_push($error_log, $parsed_block[1]);	// data fields number is not correct, e.g. 19 items instead of 20
		            }

					$block = '';
		        } else {
		        	$block .= trim($buffer);	
		        }
		    }

			// Last piece which less than 2000:
		    $sql = implode(',', $sql_values);
		    $sql = "INSERT INTO scd  (`DOCID`, `Url`, `Brand05`, `Taste07`, `Service09`, `Brand18`, `Env08`, `Brand04`, `BusinessTime13`, `Label14`, `Area03`, `Menu15`, `Price06`, `Shangquan19`, `Score10`, `MenuImgs16`, `ShopName01`, `Telephone12`, `Address11`, `City02`) VALUES ".$sql;
		    $result = mysql_query($sql,$db);

		    mysql_close($db);
		    fclose($handle);
		}

		$end_time = microtime(true);

		$result = array('Execution Time (seconds)' =>($end_time - $start_time), 'Error Log'=>$error_log);
		return $result;
	}

}


$db_user = 'root';
$db_pass = 'izene123';
$db_host = '172.16.11.218';

$SCD = new SCD();
$SCD->db_connect($db_host, $db_user, $db_pass);
$SCD->open_file("test.SCD");
$result = $SCD->read_file();

var_dump($result);
