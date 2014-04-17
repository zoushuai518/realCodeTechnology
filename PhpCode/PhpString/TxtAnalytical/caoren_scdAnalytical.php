<?php
// caoren V1.1
	class scdAnalytical{
		public $begin;
		public $currentKey; //记录当前的key

		public $count;
		public $tmp;  //临时数组
		public $tagArr; //标签数组
		public $rule;  //匹配规则
		public $sqlHead;
		public $sql;

		const limit = 1000;  //分块上限

		public function __construct(){
			$this->tmp = array();
			$this->begin = 0;
			$this->count = 0;
			$this->currentKey = '';
		}
		
		public function createInsSqlHead($tableName){
			if(!empty($this->tagArr)){
				$head = 'insert into '.$tableName.' ( ';
				end($this->tagArr);
				$l = key($this->tagArr);
				foreach($this->tagArr as $k=>$v){
					$head .= ($k!=$l)?$k.',':$k.') values ';
				}
				$this->sqlHead = $head;
			}
		}

		//设置键值数组,参数形式为array(key1,key2,key3...)
		public function setTagArr($arr = array()){
			$i = 0;
			foreach($arr as $v){
				$darr[$v] = $i++;
			}
			$hk = key($darr);
			$darr[$hk] = 'head';
			$this->tagArr = $darr;
		}

		public function analytical($fileName,$processMethod=''){
			$file = new SplFileObject($fileName,'rb');
			$this->sql = '';
			$pre = $this->rule;
			while(!$file->eof()){
				$line = $file->fgets();				
				preg_match($pre,$line,$match);
				if(isset($match[0])){
					$matchKey = $match[1];
					switch($this->tagArr[$matchKey]){
						case 'head':
							$this->sql .= (0==$this->count)?'(':'")';
							if(count($this->tmp)>self::limit){
								if($processMethod&&method_exists($this,$processMethod)){
									$this->$processMethod();  
								}
								unset($this->tmp); //清除数组，避免内存占用过大
								$this->sql = '(';
							}else{
								$this->sql .= ',(';
							}
							$this->begin++;
							$this->count++;
							$content = str_replace($match[0],'',$line);
							$this->tmp[$this->begin][$matchKey] = $content;
							$this->sql .= '"'.$content;
							$currentKey = $matchKey;
							break;
						default:
							if(isset($this->tagArr[$matchKey])){
								$content = str_replace($match[0],'',$line);
								$this->tmp[$this->begin][$matchKey] = $content;
								$currentKey = $matchKey;						
								$this->sql .= '",';
								$this->sql .= '"'.$content;
							}
							break;
						}
				}else{
					$this->tmp[$this->begin][$currentKey] .= $line;
					$this->sql .= $line;
				}
			}
			if(!empty($this->tmp)){
				$this->sql .= '")';
				if($processMethod&&method_exists($this,$processMethod)){
						$this->$processMethod();
				}
			}
		}

		public function tranTxt(){
			error_log(var_export($this->tmp,true)."\n",3,'tsql.log');
		}

	}

	set_time_limit(0);
	$t = new scdAnalytical();
	$tarr = array('DOCID','Url','Brand05','Taste07','Service09','Brand18','Env08','Brand04','BusinessTime13','Label14','Area03','Menu15','Price06','Shangquan19','Score10','MenuImgs16','ShopName01','Telephone12','Address11','City02');
	$t->setTagArr($tarr);
	$t->rule = '/<([^>]+)>/';
	$t->createInsSqlHead('readTest');
	$stime = microtime(true);
	$t->analytical('test.SCD','tranTxt');
	$etime = microtime(true);
	echo $etime - $stime."</br>";
	echo $t->count;
?>