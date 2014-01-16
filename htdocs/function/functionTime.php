<?php

	# ■秒を 時：分：秒へ変換します
	function second2minute($second=''){

		$minute = (int)($second / 60);
		$second = $second % 60;
		if($minute >= 60) {
			$hour = (int)($minute / 60);
			$minute = $minute % 60;
		}
	
		if(isset($hour)) {
			return sprintf("%02d:%02d:%02d",$hour,$minute,$second);
		}else if ($minute >= 1){
			return sprintf("00:%2d:%2d",$minute,$second);
		}else{
			return sprintf("00:00:%2d",$second);
		}
	}

	#指定した分の10分先 strtotime();
	function TenMinutesAgoByStartTo($time = null){
		list($year , $month , $day , $hour , $minutes) = explode(',' , date('Y,m,d,H,i' , $time));	
		$_minutes = (INT)(floor(round($minutes , 1) / 10) * 10);
		$minutes_ary = array('00' , '10' , '20' , '30' , '40' , '50');
		return strtotime('+' . ((in_array($minutes , $minutes_ary)) ? 0 : 10) . 'minutes'  , mktime($hour , $_minutes , 0 , $month , $day , $year));
	}


	//指定月が何日あるか
	function days_in_month($year, $month) { 
	    return( date( "t", strtotime(sprintf("%04d-%02d-%02d",$year,$month,1)) ) ); 
	} 
	
	/**
	 * ■指定月の日付を配列化
	 * @author Kiyosawa 
	 * @date 
	 */
	function _getMonthDays($month = NULL , $year = NULL){
		
		$day = days_in_month($year , $month);
		$mktime = strtotime(sprintf("%04d-%02d-%02d",$year,$month,$day));
		for($i=0;$i<$day;$i++){
			$days[] = date('Y-m-d' , strtotime("- {$i} day" , $mktime));
		}
		return $days;
		//return array_reverse($days);
	}	

	//指定月の日にちの配列	
	function MonthDays($year , $month){
		
		for($i=1;$i<=date( "t", strtotime(sprintf("%04d-%02d-%02d" , $year , $month , 1)));$i++){
			if(date('Ymd') >= $year . $month . sprintf("%02d" , $i)){
				$box[] = sprintf("%04d-%02d-%02d" , $year , $month , $i);
			}
		}
		return $box;
	}

	/**
	 * ■指定日から指定日までの日付を配列化
	 * @author Kiyosawa 
	 * @date 
	 */
	function getBetweenDays($start , $end){
		
		
		$UtcStart = strtotime($start);
		$UtcEnd = strtotime($end);
		
		if($UtcStart > $UtcEnd) return false;
		
		$days = array();
		while(true){
			$days[] = date('Y-m-d' , $UtcEnd);
			if(($UtcStart == $UtcEnd) OR ($UtcStart > $UtcEnd)) break;
			$UtcEnd = strtotime("-1 DAY" , $UtcEnd);
		}
		return $days;		
	}

	/**
	 *
	 * @author Kiyosawa 
	 * @date 
	 */
	function weekday2($date = NULL){#date === Y-m-d
	
		$status = array("<span style=\"color:red;\">日</span>" , 
						"<span style=\"color:DimGray;\">月</span>" , 
						"<span style=\"color:DimGray;\">火</span>" ,
						"<span style=\"color:DimGray;\">水</span>" , 
						"<span style=\"color:DimGray;\">木</span>" , 
						"<span style=\"color:DimGray;\">金</span>" , 
						"<span style=\"color:blue;\">土</span>"
						);
		return $status[date('w', strtotime($date))];
	}

	/**
	 *
	 * @author Kiyosawa 
	 * @date 
	 */
	function weekday($date = NULL){#date === Y-m-d
	
		$status = array("日" , 
						"月" , 
						"火" ,
						"水" , 
						"木" , 
						"金" , 
						"土"
						);
						
		return $status[date('w', strtotime($date))];
	}


	/**
	 * 日付を現在時刻から「何時間何分前」に変換します
	 * 一日以上前は日付で返します。
	 */
	function getTimeAgo($date)
	{
		$now = time();
		$dates = strtotime($date);
		$diff = $now - $dates;
		$ago = timetostr($diff);

		if($diff > 86399){
			$res = "<span class='blue'>" . $ago["day"]  . "日前</span>";
			return $res;
		}elseif(!empty($ago["hour"]) and $ago["hour"] > 0){
			$hour = (INT)($ago["hour"]);
			$res = "<span class='green'>" . $hour ."時間前</span>";
			return $res;
		}elseif(!empty($ago["minute"]) and $ago["minute"] > 0){
			$res = "<b><span class='red'>" . $ago["minute"]."分前</span></b>";
			return $res;
		}
		elseif(isset($ago["second"])){
			$ago["second"]++;
			return "<font color=red><b>" . $ago["second"]."秒前</font></b>";
		}
	}
	
    //日付整形
	function dd($date_format,$db_time){
		return date($date_format,strtotime($db_time));
	}
	/**
	 * カレンダー配列を返す
	 *
	 */
	function calender($month=null,$year=null){
		
		if(!$year AND preg_match("/(\d{4})-(\d{2})/" , $month , $match) ){
			$year = $match[1];
			$month = $match[2];
		}

		//月末日
		$lastday = date("d",mktime(0,0,0,$month+1,0,$year));

		//カレンダー生成処理
		for($i=0;$i<$lastday;$i++)
		{
			//for文で生成したカレンダー日付
			$roop_date = str_pad($i+1,2,"0",STR_PAD_LEFT);
		#	$calender["$year-$month-$roop_date"]["date"] = "$year-$month-$roop_date";
			$calender["$year-$month-$roop_date"]["youbi"] = youbi("$year-$month-$roop_date");
		
		}
		return $calender;
	}
	/**
	 * 曜日を返す
	 *
	 */
	function youbi($date)
	{
	    $sday = strtotime($date);
	    $res = date("w", $sday);
	    $day = array("<font color=red><b>日</b></font>", "月", "火", "水", "木", "金", "<font color=blue><b>土</b></font>");
	    return $day[$res];
	}	
	
	function isSunday($date)
	{
	    $sday = strtotime($date);
	    $res = date("w", $sday);
		return ($res==0);
	}

	function diff_time_str($to,$from=""){
		$time = timetostr(diff_time($to,$from));
		$diff_time = "";

		if(isset($time["after"])){
			$diff_time =  (isset($time["second"]) ? "<font color=green>{$time["second"]}秒後</font>" : $diff_time);
			$diff_time =  (isset($time["minute"]) ? "<font color=green>{$time["minute"]}分後</font>" : $diff_time);
			$diff_time =  (isset($time["hour"]) ? "<font color=green>{$time["hour"]}時間後</font>" : $diff_time);
			$diff_time =  (isset($time["day"]) ? "{$time["day"]}日後" : $diff_time);
		
		}else{
			$diff_time =  (isset($time["second"]) ? "<font color=green>{$time["second"]}秒前</font>" : $diff_time);
			$diff_time =  (isset($time["minute"]) ? "<font color=red>{$time["minute"]}分前</font>" : $diff_time);
			$diff_time =  (isset($time["hour"]) ? "<font color=blue>{$time["hour"]}時間前</font>" : $diff_time);
			$diff_time =  (isset($time["day"]) ? "{$time["day"]}日前" : $diff_time);
		}
		return $diff_time;
	}
	/***
	 * 時刻の差分を[秒]で返す。デフォルトの比較対象は現時刻
	 *
	 * @param  datetime  $to 前の時間
	 * @param  datetime  $from 後の時間
	 * @return int 差分の秒数
	 *
	 */
	function diff_time($to,$from=null)
	{
		if(!$from)
		{
			$from = "now";
		}
		return $diff= strtotime($from) - strtotime($to);
	}
	
	/**
	 * [秒]を[日]、[時間]、[分]、[秒]に変換する関数
	 * 
	 * @param int $second 秒
	 * @return array 日/時/分/秒
	 */
	function timetostr( $second )
	{
		if($second < 0){
			$res["after"] = true;
			$second = $second * -1;
		}
		
		$second_tmp = $second;

		//設定
		$day = 24 * 60 * 60;
		$hour = 60 * 60;
		$minute = 60;
		
		//日
		if ($second_tmp > $day )
		{
			$res["day"] = floor($second_tmp / $day);
			$second_tmp   = $second_tmp % $day;
		}
		//時
		if($second_tmp > $hour){
			$res["hour"] = floor($second_tmp / $hour);
			$second_tmp = $second_tmp % $hour;
		}
		//分
		if($second_tmp > $minute)
		{
			$res["minute"] = floor($second_tmp / $minute);
			$second_tmp = $second_tmp % $minute;
		}
		//秒
		$res["second"] = $second_tmp;
		return $res;
	}

?>
