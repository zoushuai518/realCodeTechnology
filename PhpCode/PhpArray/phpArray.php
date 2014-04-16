<?php 


/**
 *PHP判断数组的维数
 *
 *@return bollr
 */

function getmaxdim($vDim)

{

	if(!is_array($vDim)) return 0;

	else{

		$max1 = 0;

		foreach($vDim as $item1){

			$t1 = $this->getmaxdim($item1);

			if( $t1 > $max1) $max1 = $t1;

		}

		return $max1 + 1;

	}

}


?>