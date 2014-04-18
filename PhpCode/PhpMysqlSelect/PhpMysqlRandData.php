<?php

// from b5m demo

//#zs注: mysql 随机取书记,建议 随机逻辑用PHP来进行处理.

class PhpMysqlRandData{

	//return rand data function	
	public static function getSeoRandData($arr,$length){
		if(count($arr)<=0 || !is_array($arr))
			return;
		$rand_data = '';
		$len = count($arr)<$length?count($arr):$length;
		$rand_keys = array_rand($arr,$len);
		foreach ($rand_keys as $k => $v) {
			$rand_data .= $arr[$v]['id'] . ',';
		}
		return trim($rand_data,',');
	}


	/**
	 * mysql 随机获取文章数据
	 */
	private function _getRandData($pro_table,$select,$num){
		$rand_data = null;
		$pro_table = 'cms_zdm_article';
		// $status = 'where status=1 and type=2 and category_id in(26,27,68)';
		$status_zdm = 'where channel_id>0 and status=1';

		$num = ($num>50) ? 50 : $num;
		$seo_kerword_sql = "SELECT id FROM $pro_table $status_zdm";

		// 按照条件 取出 一批符合条件的 id列表
		$keyword_id = Yii::app()->db->createCommand($seo_kerword_sql)->queryAll();

		$id_num = 16;
		// 数组 随机，返回 id 以供 sql in查询
		$in_select = self::getSeoRandData($keyword_id,$id_num);
		if(!empty($in_select)){
			// mysql id in() in查询
			$sql = "SELECT * FROM $pro_table WHERE id in($in_select)";
			$rand_data = Yii::app()->db->createCommand($sql)->queryAll();
		}


		// mysql ROUND 随机取数据,查询非常慢;此种写法,是垃圾中的 战斗机

		// $sql = "SELECT ".$select."
		// FROM `".$pro_table."` AS t1 JOIN (SELECT ROUND(RAND() *
		// ((SELECT MAX(id) FROM `".$pro_table."` $status)-
		// (SELECT MIN(id) FROM `".$pro_table."` $status))+
		// (SELECT MIN(id) FROM `".$pro_table."` $status)) AS id) AS t2
		// WHERE t1.id >= t2.id ".$status_e;

		return $rand_data;
	}

}


?>
