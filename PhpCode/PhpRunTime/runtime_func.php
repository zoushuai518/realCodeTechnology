<?php

	function start(){//程序运行开始
		$StartTime = 0;//程序运行开始时间
		$StartTime = microtime(true);
		return $StartTime;
	}
	function stop(){//程序运行结束
		$StopTime = 0;//程序运行结束时间
		$StopTime = microtime(true);
		return $StopTime;
	}
	function spent($StartTime, $StopTime){//程序运行花费的时间	
		$TimeSpent = 0;//程序运行花费时间
		$TimeSpent = $StopTime - $StartTime;
		echo number_format($TimeSpent*1000, 4).'毫秒'; //返回获取到的程序运行时间差

	}

	$StartTime = start();
	// 程序运行
	$StopTime = stop();

	// 程序执行时间
	spent($StartTime, $StopTime);



	#===========
	//脚本运行时间
	$start_time = array_sum(explode(" ",microtime())); 
	// 程序运行
	$run_time = array_sum(explode(" ",microtime())) - $start_time; 
	echo('<center>Script Run Time: '.$run_time.'</center>'); 

?>
