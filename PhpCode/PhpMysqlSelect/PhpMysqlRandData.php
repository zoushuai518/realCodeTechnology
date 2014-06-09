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


	/*
	// useing php mt_rand function, and mysql max_id
	public static function getRandKeywordsData($num = 30)
   	{
        $data = null;
        $time_ss = strtotime(date('Y-m-d',strtotime('-2 day')))+60*60*9+1800;
        // 为每个聚合页面生成独立的缓存，缓存24小时
        $list_id  = Yii::app()->request->getParam('id', null );
        $key = 'seo_topic_keywods_create_time_v1.1'.$list_id;
        if(Yii::app()->cache->get($key))
            return Yii::app()->cache->get($key);

        $sql_max_id = "SELECT max(id) max_id FROM cms_seotopic_keywords";
        $max_id_arr = Yii::app()->db->createCommand($sql_max_id)->queryRow();
        $max_id = isset($max_id_arr['max_id']) ? $max_id_arr['max_id'] : 100000;
        $tiaojian_id = mt_rand(100, $max_id);

        $sql_select ='WHERE status=1 and isexist=1 and create_time<' . $time_ss . ' and id < ' . $tiaojian_id;
        $limit = "limit $num";
        $order = "order by id DESC";
        $sql = "SELECT * FROM cms_seotopic_keywords $sql_select $order $limit";

        $keywords_rand_data = Yii::app()->db->createCommand($sql)->queryAll();

        !empty($keywords_rand_data) && Yii::app()->cache->set($key,$keywords_rand_data, 3600*24*15);
        return $keywords_rand_data;

        return $data;
   }
   */

}


?>
