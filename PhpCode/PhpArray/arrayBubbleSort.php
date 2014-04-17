<?php

#冒泡排序法
#思想，双层循环，每次循环都把最大值冒泡到最后一位，每次循环向前偏移一位，即实现 "冒泡排序"


$arr = array(12,45,89,3,24,55,223,76,22,11,89,2,4,5,28,112,20,434,23,65,65,765,6,8,23,5,33,553,45,423,64,77,84,23);

function arrayBubbleSort($arr=array()){

	// $tmp没有初始化值，最好初始化

	$tmp=array();
	for($i=0;$i<count($arr)-1;$i++ ){       
		for($j=0;$j<count($arr)-1-$i;$j++){ 
			if($arr[$j] > $arr[$j+1]){
				$tmp = $arr[$j];
				$arr[$j] = $arr[$j+1];
				$arr[$j+1] = $tmp;
			} 
		}
	}

}


$sort_array = arrayBubbleSort($arr);

echo '<pre>';
print_r($sort_array);
die;

?>
