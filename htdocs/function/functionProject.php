<?php
	
	/**
	 * 登録日から、次回課金日を算出する
	 * @author Akabane 
	 * @date 2009/07/13 08:26:14 
	 */
	function getSoftbankMonthlyDate($year="" , $month="" , $day=""){
		if(!$year){
			$year  = date("Y");
			$month = date("m");
			$day   = date("d");
		}
		$t = date("t" , strtotime("{$year}-{$month}-01")); # 該当月翌月末
		
		//A) 申込日が末日ではなく、かつ、29 日、もしくは、30 日の場合
		if(($day == 30 or $day == 29) AND $day != $t){
			# 申込日と同日が存在しない月は末日に課金される
			$tmp_date = date("Y-m-{$day}" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
			$tmp = explode("-" , $tmp_date);
			if( checkdate ( $tmp[1] , $tmp[2] , $tmp[0] )){
				$res = $tmp_date;
			}else{
				$res  = date("Y-m-t" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
			}
		}
		//(C)月初～28日
		elseif($day <= 28){
			$res = date("Y-m-{$day}" , strtotime("+1 month" , strtotime( date("{$year}-{$month}-01")  )));
		}
		//(B)月末 
		elseif($day == $t){
			$res = date("Y-m-t" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
		}
		return $res;
	}

	/**
	 * Softbankが課金認証を行ってアクセスした事を確認する
	 * 2009/07/10 16:16:16 
	 */
	function isRegisterSB($reg=1){
		# $_GET["reg"] 0:退会 1:登録 2:キャンセル
		if( !isset($_GET["reg"]) or $_GET["reg"] != $reg){
			return false;
		}
		# 登録を行った時のみ表示される。リダイレクトを使うと表示されない
		if(isset($_SERVER["HTTP_X_JPHONE_REGISTERED"])){
			return true;
		}
		return false;
	}

	/**
	 * プロモーション費用を算出する
	 * @author Akabane 
	 * @date 2009/07/09 09:48:22 
	 */
	function getPromotionCost($promotion , $course){
		if(empty($promotion)){
			return 0;
		}
		$price = $course["OfEntryCourseSet"]["price"];
		
		switch( $promotion["OfPromotion"]["pb_type"]){
			//一律
			case 1:
				$return = $promotion["OfPromotion"]["price"];
				break;
			//定率
			case 2:
				$return = number_format($promotion["OfPromotion"]["price_rate"] / 100 * $price );
				break;
			//コース別定価
			case 3:
				$price_list = unserialize($promotion["OfPromotion"]["price_list_ary"]);
				$return = $price_list[$price];
				break;
		}
		return $return;
	}

	/**
	 * 売上げが立つかチェック
	 * 2009/07/07 03:39:43  AUは 2009-09*の場合は、09月は再pt付与されない。
	 * 2009/07/13 06:01:44  SBは 退会した時にその期間を破棄した事になり、再課金されるので全てtrueで返す
	 *
	 */
	function isPointAvail($out_date , $career){
		$month = date("Y-m");
		$s = substr($out_date , 0 , 7);
		
		switch($career){
			case "i":
			case "e":
				if($month == $s){
					return false;
				}
				return true;
				break;
			case "s":
				return true;
				
				break;
		}
	}
	
	/**
	 * プロモーション成果を通知する
	 * @author Akabane 
	 * @date 2009/06/16 23:20:24 
	 */
	function fopen_promotion( $promotion_url , $p_opt1 , $p_opt2 , $course_price="" , $promotion_price=""){

		//タグの置換
		$before = array(
			"{OPT1}",
			"{OPT2}",
			"{MKEY}",
			"{NOTAXPRICE}",
			"{PRICE}",
			"{ADPRICE}",
		);
		
		$notax_course_price = 0;
		if($course_price){
			$notax_course_price = $course_price / 1.05;
		}

		$after = array(
			trim($p_opt1),
			trim($p_opt2),
			trim(getMobileKey()),
			trim($notax_course_price),
			trim($course_price),
			trim($promotion_price),
		);
		if($promotion_url){
			$url = r( $before , $after , trim($promotion_url));
			//ログ保存
			v($url , 2 , "promotion.log" );
			@fopen($url , "r");
		}
	}

	/**
	 * APIでチェックをかける
	 * @author Akabane 
	 * @date 2009/06/16 22:38:14 
	 */
	function CheckEzBlackApi($REFERER){
		$MOBILE_KEY = getMobileKey();
		$DEVICE_UA  =  agent_to_device($_SERVER["HTTP_USER_AGENT"]);
		
		if(!defined("MOBILECHECK_URL")){
			exit("<html><body>Error functionProject at Line" . __LINE__);
		}
		$url = sprintf(MOBILECHECK_URL , $MOBILE_KEY , $DEVICE_UA  , $REFERER);
		$check_res = trim(file_get_contents($url));
		return $check_res;
	}



?>