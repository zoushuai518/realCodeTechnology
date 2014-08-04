<?php
// zs 测试中
class timer { 
	var $StartTime = 0; 
	var $StopTime = 0; 
	var $TimeSpent = 0; 
	function start(){ 
		$this->StartTime = microtime(); 
	} 
	function stop(){ 
		$this->StopTime = microtime(); 
	} 
	function spent() { 
		if ($this->TimeSpent) { 
			return $this->TimeSpent; 
		} else { 
			$StartMicro = substr($this->StartTime,0,10); 
			$StartSecond = substr($this->StartTime,11,10); 
			$StopMicro = substr($this->StopTime,0,10); 
			$StopSecond = substr($this->StopTime,11,10); 
			$start = doubleval($StartMicro) + $StartSecond; 
			$stop = doubleval($StopMicro) + $StopSecond; 
			$this->TimeSpent = $stop - $start; 
			return substr($this->TimeSpent,0,8)."秒"; 
		} 
	}
}//end class timer;


$timer = new timer; 
$timer->start(); 
$temp=0; 
for($i=0;$i<10000;$i++) for($j=0;$j<$i;$j++) $temp ++; 
// 运行的程序
$timer->stop(); 
echo "循环 $temp 次，运行时间为 ".$timer->spent();

?>
