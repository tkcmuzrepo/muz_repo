<?php
/**
 * 携帯GPS関連関数
 * 2007/09/01
 */
/***
 * [メモ]
 * @googleローカル 
 * 		世界測地系 + degree
 *		ズーム値 = 画像の横幅 × (倍率 + 1)
 *
 * @ 幅200ピクセルの場合のZM指定値と縮尺・地図画像 ・ZMの指定値・１辺のおおよその長さ(m) 
 *   ─────────┬───────
 *   	0-599		   │200 
 *   	600-999		   │400 
 *   	1000-1799	   │800 
 *   	1800-3399	   │1600 
 *   	3400-6599	   │3200 
 *   	6600-12999	   │6400 
 *   	13000-25799	   │12800 
 *   	25800-60199	   │25600 
 *   	60200-200199   │50500 
 *   	200200- 100000 │100000 
 *   ─────────┴───────
 * @ezweb gps
 * 		datum : 0 測地系(WGS84)
 * 		unit  : 1 座標単位
 * 		<a href="device:gpsone?url=[URL]&ver=1&datum=0&unit=0&acry=0&number=0">GPS情報の取得</a>
 *		※gpsOneで位置情報を取得する際、URL内に独自のパラメータを含めると古い機種などでは正しく動作しないので、
 *      注意すること
 */

/**
 * DEGREEからDMSに変換
 * 
 * @param int $degree degree形式の経度or緯度
 * @return int $dms dms形式の経度or緯度
 * @author Akabane<akabane@banex.jp>
 */
function degreeToDms($degree)
{
	if(empty($degree)){ return null; }

	$d = floor($degree);
	$m = floor(($degree-$d)*60);
	$s = floor(($degree-$d-$m/60)*3600);
	$u = floor(($degree-$d-$m/60-$s/3600)*360000);
	return $dms = "$d.$m.$s.$u";
}

/*
 * DMSからDEGREEに変換する式
 *
 * @param int $dms dms形式の経度or緯度
 * @return int $degree degree形式の経度or緯度
 * @author Akabane<akabane@banex.jp>
 */
function dmsToDegree($dms)
{
	if(empty($dms)){ return null; }

	$arr = explode(".",$dms);
	$tmp = $arr[2] + ($arr[3]/100);
	$degree = $arr[0] + $arr[1]/60 + $tmp/3600;
	return $degree;
}

/**
 * ミリ秒から度分秒に変換
 *
 */
	function msToDms( $msec ){
		if ( (int)$msec <= 0) return "";
		
		//度の算出
		$d = (int) ($msec/3600000);
		$m = (int) ( ($msec - ($d * 3600000))/60000);
		$s = ((int) ((($msec - ( ($d * 3600000) + ($m * 60000) ))/1000) * 100)) /100;
		
		return "{$d}.{$m}.{$s}";
	}

/**
 * 緯度経度を日本測地系から世界測地系へ変換
 *
 * @param int lat 日本測地系(Tokyo)緯度
 * @param int lon 日本測地系(Tokyo)経度
 * @return int array 世界測地系経度,緯度
 * @author Akabane<akabane@banex.jp>
 */
function tokyoToWgs($lat, $lon) 
{
    return array($lat - $lat * 0.00010695 + $lon * 0.000017464 + 0.0046017, $lon - $lat * 0.000046038 - $lon * 0.000083043 + 0.010040);
}

/*
 * 緯度経度を世界測地系から日本測地系へ変換
 *
 * @param int lat 世界測地系(WGS84)緯度
 * @param int lon 世界測地系(WGS84)経度
 * @return int array 日本測地系経度,緯度
 * @author Akabane<akabane@banex.jp>
 */
function wgsToTokyo($lat, $lon)
{
    return array($lat + ($lat * 0.00010695 - $lon * 0.000017464 - 0.0046017), $lon + ($lat * 0.000046038 + $lon * 0.000083043 - 0.010040));
}

/**
 * 経度、緯度を用いて２点間の距離を測る
 *
 * @param int from緯度 ,int from経度,int to緯度,int to経度
 * @return int Km(キロメートル)
 * @author Akabane<akabane@banex.jp>
 */
function colLength($lat, $lon, $lat2, $lon2)
{
	$lat = pi() * $lat / 180;
	$lat2 = pi() * $lat2 / 180;
	$lon = pi() * $lon / 180;
	$lon2 = pi() * $lon2 / 180;
	$lat = $lat - ((11.55/60) * pi()/180) * sin(2 * $lat);
	$lat2 = $lat2 - ((11.55/60) * pi()/180) * sin(2 * $lat2);
	$c = cos($lat) * cos($lat2) * cos($lon-$lon2) + sin($lat) * sin($lat2);
	$s = sqrt(1 - $c * $c);
	$t = $s / $c;
	$z = atan($t);
	$z = 6378.137 * $z; // 地球の半径を6378.137kmで計算
	return $z;
}

/*
 * 指定した地点からnメートルはなれた地点の
 * 緯度と経度を返す。<br />
 * 現在地点を中心とし、北へは+$lat_m、南へは-$lat_m、<br />
 * 東へは+$lon_m、西へは-$lon_mを指定する。
 */
 /*	$lat =  35.607451;
 *  $lon =  139.685637;
 *  $leave_point = LeavePoint($lat,$lon, 100,-100);
 */
function leavePoint($lat , $lon , $lat_m = null, $lon_m = null)
{
	$equator = 6378137;	// 赤道半径
	$point[1] = ($lon_m / ($equator * cos($lat * (pi() / 180))) + $lon * (pi() / 180)) * (180 / pi());	// 経度
	$point[0] = ($lat_m / $equator + $lat * (pi() / 180)) * (180 / pi());	// 緯度
	if(empty($lat_m)){
		$point[0] = $lat;
	}
	if(empty($lon_m)){
		$point[1] = $lon;
	}
	if($point[0] < 0){
		$point[0] = $point[0] * -1;
	}
	if($point[1] < 0){
		$point[1] = $point[1] * -1;
	}
	return $point;
}

//googleMapでのzoomレベル変更
function googleMapZoomParam($zoom_level,$width)
{
	for($i=0;$i<$zoom_level;$i++)
	{
		if($i == 0){$res = 2;}
		if($i  > 0){
			$kaijo = pow(2,$i-1);
			$res = $res + $kaijo;
		}
	}
	$zoom = $res * $width;
	return $zoom;
}
//URL整形
function makeGooglePoint($lat,$lon)
{
	$lat = str_replace(".","",$lat);
	$lon = str_replace(".","",$lon);
	$lat = substr($lat,0,8);
	$lon = substr($lon,0,9);
	
	$point = array("lat"=>$lat,"lon"=>$lon);
	return $point;
}
//googlemap マーキング
function googleMapMarker($lat,$lon,$icon_id=15)
{
	return "&Point=b&Point.latitude_e6={$lat}&Point.longitude_e6={$lon}&Point.iconid={$icon_id}&Point=e";
}
//
function makeDmsDocomo(){
	$iareadatafile = TXT_DIR ."iareadata/iarea{$_REQUEST["AREACODE"]}.txt";
	$contents = file_get_contents( $iareadatafile );
	mb_convert_variables("EUC-JP","Shift_Jis", $contents);
	$data = preg_split ( '/(?<!\\\\),/', $contents );
	$areaname = $data[2]; //iエリア名
	$longitude1 = $data[3]; //西端経度(ミリ秒)
	$latitude1  = $data[4];
	$longitude2 = $data[5]; //東端経度(ミリ秒)
	$latitude2  = $data[6]; //北端緯度(ミリ秒)
	//エリアの中心部の 緯度・経度を(適当に)計算
	$res["latitude"]  = (int)( ($latitude1 + $latitude2)/2 ); //経度
	$res["longitude"] = (int)( ($longitude1+ $longitude2)/2); //緯度
	return $res;
}


/**
 * 逆ジオコーディング
 * @author Akabane
 * @date
 */
function reverseGeocoding($lat , $lon){

	ini_set('default_socket_timeout',3);

	//クネヒト http://api.knecht.jp/reverse_geocoding/
	$xml_url = "http://refits.cgk.affrc.go.jp/tsrv/jp/rgeocode.php?v=1&lat={$lat}&lon={$lon}";
	if(@$xml = simplexml_load_file($xml_url)){
		$res["pref"] = (String)$xml->prefecture->pname;
		$res["mname"] = (String)$xml->municipality->mname; //ex.渋谷区
		$res["section"] = (String)$xml->local->section;
		$res["homenumber"] = (String)$xml->local->homenumber;
		$res["gps_addr"] = $res["pref"] . $res["mname"].$res["section"].$res["homenumber"];
		//v($res);
		return $res;
	}

	//Yahoo Map 逆ジオコーディング ID afinfo1 PASS kenken
	$appid = "JAunTmqxg640sSf9xWqCIQe.DfnwqKC_Q6MJkE53xB21D_2aiycgm3f.2iAXbg--";
	$xml_url = 'http://map.yahooapis.jp/LocalSearchService/V1/LocalSearch?'
	  . 'appid={$appid}'
	  . '&lat='.urlencode($lat)
	  . '&lon='.urlencode($lon)
	  . '&dist=3' // 上記指定座標からの検索範囲（km）
	  . '&category=address' // 地名のみ検索
	  . '&n=1' // 検索結果は1つだけ取得
	  . '&datum=wgs' // 世界測地系を使う
	  . '&al=3'; // 丁目、字レベルまで取得

	if(@$xml = simplexml_load_file($xml_url)){
		$res["gps_addr"] = (String)$xml->Item->Title;
		$res["pref"] = $res["mname"] = $res["section"] = $res["homenumber"] = "";
		return $res;
	}
	return $res;
}


	/**
	 * 都道府県IDを返す
	 * @author Akabane 
	 * @date 2009/05/07 12:41:13 
	 */
	function getPrefNo($addr){
		$prefs = tsv("pref.tsv");
		foreach($prefs as $k=>$v){
			if(ereg($v , $addr)){
				return $k;
				break;
			}
		}// foreach
		
	}



?>