<?php
	
	
	#
	# @author Kiyosawa 
	# @date 
	function j($ary=array(),$flg=false){
		
		if(!is_bj()) return;
		header("Content-Type:application/json;charset=utf-8");
		echo json_encode($ary);
		if($flg) return;
		exit;
	}
	
	# ■開発者か
	# @author Kiyosawa 
	# @date 
	function isDev($admin_level=''){
		
		if(empty($admin_level)) return false;
		if(!defined('DEVELOPER')) return false;
		if($admin_level!=DEVELOPER) return false;
		return true;
	}
	
	# ■サイトのディレクトリ名を取得
	# @author Kiyosawa 
	# @date 
	function getSiteDirectory(){
		
		$request_directory=trim($_SERVER['REQUEST_URI'],'/');
		
		if(empty($request_directory)){
			
			$request_directory='pc';
		}else{
			$explode=explode("/",$request_directory);
			$request_directory=$explode[0];
		}
                return $request_directory;
	}
	
	
	# ■テスト環境課
	# @author Kiyosawa 
	# @date 
	function isTestSite(){
		
		$directory=getSiteDirectory();
		$index=stripos($directory,'dev');
		if(is_int($index)){
			return true;
		}
		return false;
	}
	
	function strip_between_tag($str,$tag){
		
		$pattern = sprintf("!<%s.*?>.*?</%s>!ims",$tag,$tag);
		preg_match_all($pattern,$str,$match);
		return $match;
	}


	function encrypt($msg)
	{
	  //初期化ベクトルを生成
	  $ivSize = mcrypt_get_iv_size(CIPHER, MODE);
	  $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
	  $dummyIV = str_repeat("x", $ivSize);
	  
	  //メッセージの暗号化 ... (3)
	  $cryptMsg = mcrypt_encrypt(CIPHER, KEY, base64_encode($msg), MODE, $iv);
	  
	  //初期化ベクトルの暗号化 ... (4)
	  $cryptIV = mcrypt_encrypt(CIPHER, KEY, base64_encode($iv), MODE, $dummyIV);
	  
	  return array($cryptMsg, $cryptIV);
	}
	
	function decrypt($cryptMsg, $cryptIV)
	{
	  //ダミーの初期化ベクトルを生成
	  $ivSize  = mcrypt_get_iv_size(CIPHER, MODE);
	  $dummyIV = str_repeat("x", $ivSize);
	  
	  //初期化ベクトルの復号
	  $iv = _decryptSupport($cryptIV, $dummyIV);
	  
	  //メッセージの復号
	  $msg = _decryptSupport($cryptMsg, $iv);
	  
	  return $msg;
	}
		
	#
	# @author Akabane 
	# @date 
	function getProvincesArrays($pref_tsv=''){
		
		ksort($pref_tsv);
		
		$list[] = '北海道・東北';
		$list[] = '関東';
		$list[] = '北陸';
		$list[] = '中部';
		$list[] = '関西';
		$list[] = '中国';
		$list[] = '四国';
		$list[] = '九州・沖縄';
		
		$pref_list = array(range(1,7),
		                   range(8,14),
			           range(15,18),
				   range(19,24),
				   range(25,30),
				   range(31,35),
				   range(36,39),
				   range(40,47));
		$i=0;
		foreach($pref_tsv as $k=>$v){
		
			if(in_array($k,$pref_list[$i])){
				$pref[$list[$i]][$k] = $v;
				array_shift($pref_list[$i]);
				if(empty($pref_list[$i])){
					$i++;
				}
			}
		}
		return $pref;	
	}
	

	function checkDir($dir){
		$dir_ary = explode("/" , $dir);
		$new_ary = array();
		foreach($dir_ary as $k=>$v){
			if($v){
				$new_ary[] = $v;
				# cakePHP用。変なディレクトリを生成しないように
				$tmp = "/" . implode("/" , $new_ary) ;
				if(eregi(ROOT.DS , $tmp )){
					if(!file_exists($tmp)){
						mkdir($tmp);
						chmod($tmp , 0777);
					}
				}
			}
		}//foreach	
	}
	
	
	/**
	 * 最大値に対するセットした値の割合(30%など)をグラフにして返します
	 *
	 * $target_num : 対象となる数字 (int)
	 * $max        : 比較対象となる最大値 (int)
	 * $rate_num   : 何段階評価か (int)
	 * $color      : メータに使用する色 (str)
	 *
	 * @author Akabane 
	 * @date 2009/06/17 13:32:25 
	 */
	function toGraph( $target_num , $max , $rate_num=10 , $color="blue" , $space=false ){
		@$rate = $target_num / $max * 100;
		$per = 100 / $rate_num;
	
		$return = "";
		$c = 0;
		for($i=0;$i<$rate_num;$i++){
			$c += $per;
			if($rate < $c){
				//四捨五入
				$up   = ($rate - $c ) * -1;
				$down = $rate - $c  + $per;
				if($up <= $down AND !isset($end_flg)){
					$return .= "<span style='color:{$color};'>■</span>";
					$end_flg = true;
					$i++;
				}
				if(!$space){
					break;
				}else{
					$return .= "<span style='color:{$space};'>■</span>";
					continue;
				}
			}
			$return .= "<span style='color:{$color};'>■</span>";
		}//for
		return $return;
	}
	/**
	 * http://x.jp/hoge.html → http://x.jp/
	 * @author Akabane 
	 * @date 2009/06/17 11:32:56 
	 */
	function toDomain($url){
		$list = explode("/" , $url);
		for($i=0;$i<count($list);$i++){
			if($i==3) break;
			$res[] = $list[$i];
		}//for
		$return = implode("/" , $res);
		return $return;
	}
	
	function if_echo($str){
		if(is_bj()){
			$data = debug_backtrace();
			echo basename($data[0]["file"]) .  "{$data[0]["line"]}行目 <font color=red>";
			echo $str . "</font><br>\n";
		}
	}
	
	/**
	 * 最大値/最小値を取得する
	 * 
	 * $return されるまでに挿入された key の最大値/最小値を保有し、 return された段階で最大値/最小値を返します
	 * 
	 * @author Akabane 
	 * @date 2009/04/27 21:35:06 
	 */
	function getLimit($key , $data , $type="MAX" , $return = false){
		static $buffer;
		
		if($return){
			return (isset($buffer[$key])) ? $buffer[$key] : 0;
		}
		
		if(!isset($buffer[$key])){
			$buffer[$key] = $data;
		}
		else{
			if(up($type)=="MAX"){
				if( $data  > $buffer[$key] ){
					$buffer[$key] = $data;
				}
			}
			elseif(up($type)=="MIN"){
				if( $data  < $buffer[$key] ){
					$buffer[$key] = $data;
				}
			}
			return true;
		}
	}

	/**
	 * DB保存
	 * @author Akabane 
	 * @date 2009/04/25 12:12:51 
	 */
	function vx(){
		$db = ClassRegistry::init('Bj');
		$data = debug_backtrace();

		switch(1){
			//コントローラ
			case (eregi("controller" , $data[0]["file"])):
				$insert["type"] = "CONTROLLER";
				break;
			//モデル
			case (eregi("model" , $data[0]["file"])):
				$insert["type"] = "MODEL";
				break;
			//ビュー
			case (eregi("view" , $data[0]["file"])):
				$insert["type"] = "VIEW";
				break;
			//デフォルト
			default:
				$insert["type"] = "OTHER";
				break;
		}

		$insert["file"] = r( APP , "" , $data[0]["file"]);
		$insert["line"] = $data[0]["line"];
		$insert["data"] = print_r($data[0]["args"][0] , 1);
		
		array_shift($data);
		$v = array_shift($data);
		@$insert["class"] = $v["class"];
		
		$insert["function"] = "";
		if($insert["type"] !="VIEW"){
			@$insert["function"] = $v["function"];
		}
		$db->insertVx($insert);
	}

	/**
	 * number_formatのラッパー
	 * @author Akabane 
	 * @date 2009/03/17 01:10:23 
	 */
	function no($str , $per=0){
		if($str < 0){
			return "<span class='s-red'>" . number_format($str) . "</span>";
		}else{
			return number_format($str,$per);
		}
	}
	
	/**
	 * 絵文字でのNoを返す
	 *
	 * $nameが空の場合
	 * [1]→[2]→[3]
	 *
	 * @author Akabane 
	 * @date 
	 */
	function emoji_no($name=""){
		static $roop_name = "";
		static $put_number = 0;
		
		if($name){
			if($roop_name!=$name){
				$put_number = 0;
			}
			$roop_name = $name;
		}
		$array = array(
			"[%180%]",
			"[%181%]",
			"[%182%]",
			"[%183%]",
			"[%184%]",
			"[%185%]",
			"[%186%]",
			"[%187%]",
			"[%188%]",
		);
		
		$return = $array[$put_number];
		$put_number++;
		return $return;
	}


	//改行区切りで配列展開
	//2009/01/19 17:57:47 
	function nlexplode($data){
		$return = ( explode("\n" , r("\r" , "" , $data))); //改行区切りで配列に展開
		return $return;
	}

	/**
	 * 同一文字コードの時はエンコーディングしない
	 * @author Akabane 
	 * @date 
	 */
	function enc($str , $to_encode = "UTF-8", $encode = null){
		mb_language("Japanese");
		if(!$encode) $encode = mb_detect_encoding($str);
		if($encode != $to_encode){
			$str =  mb_convert_encoding($str , $to_encode , $encode);
		}
		return $str;
	}
	
	
	/**
	 * 弊社のIPならtrue
	 */
	function is_bj($ip=null){
		
		if(!$ip) $ip = @$_SERVER['REMOTE_ADDR'];
		
		$ip_list[]='125.99.186.58';
		$ip_list[]='122.216.15.202';
		$ip_list[]='114.147.193.126';
		$ip_list[]='223.230.219.139';
		$ip_list[]='223.230.223.190';
		$ip_list[]='122.177.81.35';
		$ip_list[]='122.177.150.249';
		$ip_list[]='114.147.193.126';
		$ip_list[]='204.11.58.97';
		$ip_list[]='122.177.196.208';
		if(in_array($ip,$ip_list) or ereg("192.168|127.0.0" , $ip)){
			return true;
		}
		return false;
	}
	
	/**
	 * 弊社のIPならtrue
	 */
	function is_ai(){
	
		$ip = @$_SERVER['REMOTE_ADDR'];
		if($ip == "210.154.182.102"){
			return true;
		}
		return false;
	}
	
	/**
	 * var_dump拡張変数出力用デバッカー
	 *
	 * $date 出力するデータ
	 * $type 0:出力してexit 1:出力してexitしない　2: tmp/logs/v.txtに書き込み
	 * $fname $typeが2の時、ファイル名を指定して出力
	 * 3 IPに関係無く強制終了
	 */
	if(defined("LOGS")){
		define("OUTPUT_FILE_PATH" , LOGS );
	}else{
		define("OUTPUT_FILE_PATH" , dirname(__FILE__) . "/" );
	}
	function v($_data , $type=0 , $fname="v.log"){
		$data = debug_backtrace();
		switch($type){
			//■出力 exitする
			case 0:
			//■出力 exitしない
			case 1:
				if(is_bj()){
					if (!headers_sent()) header("Content-Type: text/html; charset=UTF-8");
					echo str_repeat("\n" , 5);

					// 呼び出しもと出力
					echo "<div style=\"color:green;font-weight:bold;\">\n";
					echo "{$data[0]["file"]} {$data[0]["line"]}行目\n";
					echo "</div>\n";
		
					// 引数出力
					echo "<pre style=\"background:#FFFF99;padding:5px;\">";
					var_dump($data[0]["args"][0]);
					echo "</pre>\n";
		
					unset($data[0]);

					//呼び出しもとのコール元一覧を出力
					echo "<div style=\"color:green;font-weight:bold;\">\n";
					foreach($data as $k=>$v){
						if(!empty($v["file"]) and !empty($v["line"]))
						echo "{$v["file"]} {$v["line"]}行目<br>\n";
					}//foreach
					echo "</div>\n";
					echo str_repeat("\n" , 5);
		
					// 1の時はexitしない
					if($type===0){
						exit;
					}
				}
				if($type===3){
					exit;
				}
				break;

			//■ログ出力
			case 2:
				//「■2009/01/03 20:16;18 --- C:\xampp\htdocs\CAKEPROJECT\aqua\mb\app_model.php at line 8 ---------------」
				$pre = "\n■" . date("Y/m/d H:i;s") ." ". str_repeat("-" , 3) . " ";
				$debug_info = "{$data[0]["file"]} at line {$data[0]["line"]} " .str_repeat("-" , 15) . "\n\n";
				$output = $pre . $debug_info .  var_export($data[0]["args"][0] , 1);
				file_put_contents(OUTPUT_FILE_PATH . $fname , $output , FILE_APPEND | LOCK_EX);
		
		}//switch
	}//v


	/*
	 * @author seki
	 * ベーシック認証をかけます。
	 */
	if(!function_exists("basic_auth")){
		function basic_auth($id = "" , $pass = ""){
			if(isset($_SERVER["PHP_AUTH_USER"]) and $_SERVER["PHP_AUTH_PW"] == $pass and $_SERVER["PHP_AUTH_USER"] == $id){
				return true;
			}
			header("WWW-Authenticate: Basic realm=\"Please Enter Your Password\"");
			header("HTTP/1.0 401 Unauthorized");
			exit;
		}
	}

	/**
	 *
	 * @author seki
	 * @date 2008/04/09
	 *
	 * 配列とか見やすく出力
	 *
	 */
	function table($arr){
		echo "<table class='sheet'>\n";
		__Roop($arr);
		echo "</table>";
	}
	function __Roop($arr){
		foreach($arr as $k=>$v){
			if(is_array($v) or is_object($v)){
				$row = __Row($v);
				echo "<tr valign=\"top\">\n";
				echo "\t<th rowspan=\"{$row}\" >[{$k}]</td>\n";
				echo "</tr>\n";
				__Roop($v);
			}
			else{
				echo "<tr>\n";
				echo "\t<td>[{$k}]</td>\n";
				echo "\t<td>{$v}</td>\n";
				echo "</tr>\n";
			}
		}//foreach
	}
	function __Row($arr, &$row=null){
		if(!isset($row)){
			$row = 1;
		}
		$row = $row + count($arr);
		foreach($arr as $k=>$v){
			if(is_array($v) or is_object($v)){
				__Row($v,$row);
			}
		}//foreach
		return $row;
	}

	# 拡張子取得
	# @ editor bane 2008/08/05 18:58:02 
	if(!function_exists("get_ext")){
		function get_ext($str){
			$ary = explode("." , $str);
			return strtolower(end($ary));
		}
	}

	/**
	 * ファイルをダウンロードさせる
	 */
	function download($filepath=""){
		
		header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filepath));
		exit;
	}

	//エラー表示
	function err($msg){
		$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . "\n";
		$html .= '<html lang="ja">'. "\n";
		$html .= '<head>'. "\n";
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=Shift_jis">'. "\n";
		$html .= '<meta http-equiv="Content-Language" content="ja" />'. "\n";
		$html .= '<body>'. "\n";
		$html .= $msg. "\n";
		$html .= '</body>'. "\n";
		$html .= '</html>'. "\n";
		echo enc($html , "SJIS");
		exit;
	}
?>
