<?php
	/**
	 * XHTML出力用
	 */
	function xhtml_output(){
		header("Content-type: application/xhtml+xml");
	}

	// 携帯用文字列カット関数
	// 絵文字中間コードを含む文字列の長さを計り、カットします。
	//
	// @author  bane 2008/08/13 15:23:11
	// @param   $str      元の文字列
	// @param   $size     カットする文字長さ
	// @param   $rtrim    カットした語尾に付加する文字列（カットされた場合のみ付加されます）
	// @param   $encode   文字エンコーディング
	// @param   $tmp_code 一時コード※絶対に$strに含まれない必要があります
	function ktai_str_cut($str , $size , $rtrim = "…" , $encode="UTF-8" , $tmp_code="`"){
		$tmp_str = $str;

		//絵文字中間コード覧を取得、配列に格納
		preg_match_all( '/(\[%.*?%\]|<img.*?>)/is' , $tmp_str , $match);
		if($match[0]){
			//中間コードを「(1文字扱い)一時コード」に変換
			$tmp_str = str_replace($match[0] , $tmp_code, $str );
		}
		//指定文字長さでカット
		$tmp_str_cut =  mb_substr($tmp_str , 0 , $size  , $encode);

		$tmp_replace_str = $tmp_str_cut;
		$i = 0;

		//「一時コード」を順番に中間コードに戻す（「一時コード：絵文字中間コード」は「１：多」の為、str_replaceでは不可）
		while(true){
			if(!preg_match("/" . preg_quote($tmp_code) . "/is" , $tmp_replace_str)){
				break;
			}
			$tmp_replace_str = preg_replace('/'. preg_quote($tmp_code) .'/is' , $match[0][$i] , $tmp_replace_str , 1);
			$i++;
		}
		//もし文字がカットされていたら、語尾に$rtrimを付加する
		$tmp_replace_str .= (strlen($tmp_str_cut) != strlen($tmp_str)) ? $rtrim : "" ;

		return $tmp_replace_str;
	}

	/**
	 * IPアドレスからキャリアを取得する
	 *
	 */
	function getCareerByAddr($ip=null){
	
		if(!$ip) $ip = $_SERVER["REMOTE_ADDR"];
		$hostname = gethostbyaddr($ip);	// IPの場合はget Host By Addrする
		
		//Docomo docomo.ne.jp
		if(preg_match('/\.docomo\.ne\.jp$/', $hostname)){
			return 'i';
		}
		//Vodafone Softbank jp-t.ne.jp
		elseif(preg_match('/\.jp.*?\.ne\.jp$/', $hostname)){
			return 's';
		}
		//au  ezweb.ne.jp | ido.ne.jp
		elseif(preg_match('/\.(ido|ezweb)\.ne\.jp$/', $hostname)){
			return 'e';
		}
		//WillCom DDI Pocket
		elseif(preg_match('/pdxcgw\.pdx\.ne\.jp$/', $hostname)){
			return 'w';
		}
		//L-mode
		elseif(preg_match('/\.pipopa\.ne\.jp$/', $hostname)){
			return 'l';
		}
		else{
			return 'pc';
		}
	}


	/**
	 * ユーザーエージェントからキャリアを調べる
	 * 
	 * @param	string	$agent	ユーザーエージェントの文字列
	 * @return	string	キャリアの文字列( i/s/e/h 携帯でなければ"pc" )
	 * # 2010/07/13 16:33:33 [清沢]iPhone 追加 prototype.js 引用
	 */
	function getCareerByAgent($agent=null){
		
		if(!$agent) $agent = @$_SERVER["HTTP_USER_AGENT"];
		$docomoRegex    = "^DoCoMo/\d\.\d[ /]";
		$jphoneRegex    = "^(J-PHONE/\d\.\d)|(Vodafone/\d\.\d)|(MOT-)|(SoftBank/\d\.\d)";
		$ezwebRegex     = "(?:KDDI-[A-Z]+\d+ )?UP\.Browser\/";
		$airhphoneRegex = "^Mozilla/3\.0\(DDIPOCKET'";
		$iphoneRegex    = "Apple.*Mobile";
		$mobileRegex = "(?:($docomoRegex)|($jphoneRegex)|($ezwebRegex)|($airhphoneRegex)|($iphoneRegex))";
		$c_id = "pc";
		if( preg_match("!$mobileRegex!", $agent, $matches)) {
			$c_id = @$matches[1] ? 'i' :
		           (@$matches[2] ? 's' :
		           (@$matches[7] ? 'e' : (@$matches[9] ? 'a' : 'w')));		
		}
		return $c_id;
	}
	
	
	#■スマホか
	# @author Kiyosawa
	# @date 
	function isSp($agent=''){
		
		if(empty($agent)){
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		if(preg_match("/iphone|android|windows phone/i",$agent,$match)){
			return true;
		}
		return false;
	}

	# ■Ipadか
	# @author Kiyosawa 
	# @date 
	function isIpad($user_agent=''){
		
		if(empty($user_agent)){
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		preg_match("/ipad/i",$user_agent,$match);
		
		if(!empty($match[0])){
			return true;
		}
		return false;
	}
	
	
	# ■携帯か
	# @author Kiyosawa 
	# @date 
	function isMb($user_agent=''){
		
		if(empty($agent)){
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		if(isSp()){
			return false;
		}
		
		if(getCareerByAgent()=='pc'){
			return false;
		}
		return true;
	}
	
	/**
	 * ユーザーエージェントとキャリア識別子から機種判別
	 *
	 * @param string $agent ユーザエージェント
	 * @param string $c_id キャリアの文字列(i/s/e/h )
	 * @param stirng $dir キャリアの種類(i/ix/ex/e/s/h/pc)
	 */
	function getBrwTypeByAgent($agent=null,$c_id){
		if(!$agent) $agent = $_SERVER["HTTP_USER_AGENT"];
		
		//DoCoMoで
		if($c_id == "i"){
			//FOMAだったら
			if(strstr($agent,'DoCoMo/2.0')){
				$dir = "ix";
			//FOMA以外だったら
			}else{
				$dir = "i";
			}
		//auで
		}else if($c_id == "e"){
			//WINだったら
			if(strstr($agent,'KDDI-')){
				$dir = "ex";
			//WIN以外だったら
			}else{
				$dir = "e";
			}
		//SoftBankだったら
		}else if($c_id == "s"){
			$dir = "s";
		//willcom
		}else if($c_id == "w"){
			$dir = "w";
		//携帯じゃなさげだったら
		}else{
			$dir = "pc";
		}
		return $dir;
	}

	/**
	 * メールアドレスからキャリアを調べる
	 * 
	 * @access	private
	 * @param	String	$address	メールアドレス
	 * @return	String	キャリアの文字列( i/e/s 携帯でなければ"pc" )
	 */
	function getCareerByEmail($address)
	{
		list($account , $domainName) = explode("@" , $address);
		
		$c_id = 'pc';
		//docomo
		if(preg_match("/docomo/", $domainName) != 0){
			$c_id = 'i';
		}
		//ezweb
		if(preg_match("/ezweb/", $domainName) != 0){
			$c_id = 'e';
		}
		//softbank (disney含む)
		if(preg_match("/vodafone|softbank|jp-*\.ne\.jp/", $domainName) != 0 ){
			$c_id = 's';
		}

		//softbank (iPhone)
		if(preg_match("/i.softbank.jp/" , $domainName) != 0 ){
			$c_id = 's';
		}
		
		if($c_id == ""){
			$c_id = 'pc';
		}
		return $c_id;
	}
	
	
	# ■iPhoneに対応
	# @author Kiyosawa
	# @date 
	
	function _getCareerByEmail($address){

		list($account , $domainName) = explode("@" , $address);
				
		$c_id = 'pc';
		switch(true){
			case(preg_match("/docomo/", $domainName) != 0):
			$c_id = 'i';
		break;
			case(preg_match("/ezweb/", $domainName) != 0):
			$c_id = 'e';
		break;
			case(preg_match("/i.softbank.jp/" , $domainName) != 0):
			$c_id = 'pc';
		break;
			case(preg_match("/vodafone|softbank|jp-*\.ne\.jp/", $domainName) != 0):
			$c_id = 's';
		break;
			default:
			$c_id = 'pc';
		break;
		}
		return $c_id;
	}
		
	/**
	 *
	 * @author Kiyosawa 
	 * @date 
	 */
	function Isitpc($address = ''){
		return getCareerByEmail($address) == 'pc' ? true : false ;
	}
	
	/**
	 * 個体識別番号を取得する
	 * 
 	 * ■DoCoMo
	 *（例）個体識別情報
 	 *    DoCoMo/2.0 N2001(c10;serXXXXXXXXXXXXXXX; iccxxxxxxxxxxxxxxxxxxxx)
 	 *   （ser：固定、***********：製造番号）
	 *
	 * ■Softbank
 	 *（例）端末シリアル番号（製造番号）
 	 *  固体識別番号 : J-PHONE/4.0/J-SH51/SNxxxxxxxx	 
	 *
	 *  ■au
 	 *（例）サブスクライバID
 	 *    xxxxxxxxxx_xx.ezweb.ne.jp
	 */
	function getMobileKey($debug=0){
		
		if($debug AND is_bj()){
			return substr( $_SERVER["HTTP_USER_AGENT"] , 0 , 9);
		}//if
		
		$UA = $_SERVER['HTTP_USER_AGENT'];
		$HostName = @gethostbyaddr($_SERVER['REMOTE_ADDR']);

		//■DoCoMo
		if ( preg_match("/.docomo.ne.jp/", $HostName) ) {
			
			//iモードID
			if (!empty($_SERVER['HTTP_X_DCMGUID'])) {
				$MobileInfo = $_SERVER['HTTP_X_DCMGUID'];
			}
			//個体識別番号
			else{
				preg_match("/ser([a-zA-Z0-9]+)/",$UA, $dprg);
				if ( strlen($dprg[1]) === 11 ) {
					$MobileInfo = $dprg[1];
				} elseif ( strlen($dprg[1]) === 15 ) {
					$MobileInfo = $dprg[1];
					preg_match("/icc([a-zA-Z0-9]+)/",$UA, $dpeg);
					if ( strlen($dpeg[1]) === 20 ) {
						$MobileInfo = $dpeg[1];
					} else {
						$MobileInfo = false;
					}
				} else {
					$MobileInfo = null;
				}
			}
		}
		//■SoftBank
		elseif(	preg_match('/^J-PHONE.*/', $UA) or 
				preg_match('/^Vodafone.*/', $UA) or 
				preg_match('/^SoftBank.*/', $UA)
				){
					
					if($MobileInfo = $_SERVER['HTTP_X_JPHONE_UID']){
						return $MobileInfo;
					}elseif(preg_match("/SN([a-zA-Z0-9]+)/",$UA,$vprg)){
						$MobileInfo = $vprg[1];
						return $MobileInfo;
					}
					return null;
					
					/*
					if(preg_match("/SN([a-zA-Z0-9]+)/",$UA,$vprg)){
					        $MobileInfo = $vprg[1];
					}else{
						$MobileInfo = $_SERVER['HTTP_X_JPHONE_UID'];
						if(empty($MobileInfo)){
							$MobileInfo = null;
						}
			        	}
					*/
	    }
		//■au
		elseif ( preg_match("/.ezweb.ne.jp/", $HostName) ) {
	        $MobileInfo = $_SERVER['HTTP_X_UP_SUBNO'];

		//■others
	    }else{
			return null;
		}
	    return $MobileInfo;
	}


	if(!function_exists("agent_to_device")){
	function agent_to_device($agent=null){
		if(empty($agent)){
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		$career = getCareerByAddr();
		
		switch ($career){
		case "i":
			# ドコモ
			if(strpos($agent, "DoCoMo/1.0") >= 0 && strpos($agent, "/", 11) >= 0){
				$device = substr($agent, 11, (strpos($agent, "/", 11) - 11));
			}elseif(strpos($agent, "DoCoMo/2.0") >= 0 && strpos($agent, "(", 11) >= 0){
				$device = substr($agent, 11, (strpos($agent, "(", 11) - 11));
			}else{
				$device = substr($agent, 11);
			}
			break;
		case "e":
			# au（エージェントは、2タイプとも取得できる）
			$device = substr($agent, (strpos($agent, "-") + 1), (strpos($agent, " ") - strpos($agent, "-") - 1));
			break;
		case "s":
			# ソフトバンク（x-jphone-msnameで機種名だけ取得できる）
			$device = $_SERVER["HTTP_X_JPHONE_MSNAME"];
			if(empty($device)){
				$device = "softbak";
			}
			break;
		default:
			$device = "";
			break;
		}// switch
		return $device;
	}//function
	}


	# スマートフォン対応
	# ドキュメントが見つからないため暫定的な処理
	function _getSmartPhoneCareerByAgent($agent=''){
		
		if(!$agent) $agent = @$_SERVER["HTTP_USER_AGENT"];
		
		$docomoRegex    = "^DoCoMo/\d\.\d[ /]";
		$jphoneRegex    = "^(J-PHONE/\d\.\d)|(Vodafone/\d\.\d)|(MOT-)|(SoftBank/\d\.\d)";
		$ezwebRegex     = "(?:KDDI-[A-Z]+\d+ )?UP\.Browser\/";
		
		if(preg_match("#$ezwebRegex#",$agent,$match)){
			return 'ezweb';
		}
		
		# au スマートフォン IS0がふくまれているか
		if(preg_match("/IS[0]{1}[0-9]{1}|ISW11HT|SMT/",$agent,$match)){
			return 'smart_e';
		}
				
		if(preg_match("#$jphoneRegex#",$agent,$match)){
			return 'softbank';
		}
		
		if(preg_match("#iPhone#i",$agent,$match)){
			return 'iphone';
		}		

		if(preg_match("#$docomoRegex#",$agent,$match)){
			return 'docomo';
		}		
		
		if(preg_match("#Android#i",$agent,$match)){
			return 'smart_d';
		}		
		return 'pc';		
	}
	
	function _getType(){
		
		$type = _getSmartPhoneCareerByAgent();
		switch(true){
			case(in_array($type,array('smart_d','smart_e'))):
			return 'android';
		break;
			case($type == 'iphone'):
			return 'iphone';
		break;
			case(in_array($type,array('docomo','softbank','ezweb'))):
			return 'mobile';
		break;
			default:
			return 'pc';
		break;
		}
	}
	
	/**
	 * メールアドレスからキャリアを調べる
	 * 
	 * @access	private
	 * @param	String	$address	メールアドレス
	 * @return	String	キャリアの文字列( i/e/s 携帯でなければ"pc" )
	 */
	function getCareerSmartPhoneByEmail($address)
	{
		list($account , $domainName) = explode("@" , $address);
		
		$c_id = 'pc';	
		//docomo
		if(preg_match("/docomo/", $domainName) != 0){
			$c_id = 'i';
		}
		//ezweb
		if(preg_match("/ezweb/", $domainName) != 0){
			$c_id = 'e';
		}
		//softbank (disney含む)
		if(preg_match("/vodafone|softbank|jp-*\.ne\.jp/", $domainName) != 0 ){
			$c_id = 's';
		}

		//softbank (iPhone)
		if(preg_match("/i.softbank.jp/" , $domainName) != 0 ){
			$c_id = 'pc';
		}
		
		if($c_id == ""){
			$c_id = 'pc';
		}
		return $c_id;
	}	
	



	# ■AUスマートフォン
	# @author Kiyosawa
	# @date 
	function auSmartPhone($user_agent=''){
		
		if(empty($user_agent)) $user_agent = $_SERVER['HTTP_USER_AGENT'];
		
		# ■IS11CA カシオ計算機 ○
		$agent[] = "IS11CA Build";
		
		# ■ISW11HT HTC ○
		$agent[] = "ISW11HT Build";
		
		# ■IS06 Pantech ○
		# ■IS06 SIRIUS α IS06」
		$agent[] = "IS06 Build";
		
		# ■IS11S ソニー・エリクソン ○
		$agent[] = "SonyEricssonIS11S Build";
		
		# ■IS01 シャープ ○
		$agent[] = "IS01 Build";
		
		# ■IS03 シャープ ○ [Android 2.1,2.2]
		$agent[] = "IS03 Build";
		
		# ■IS05 シャープ ○
		$agent[] = "IS05 Build";
		
		# ■IS11SH シャープ ○
		$agent[] = "IS11SH Build";
		
		# ■IS12SH シャープ ○
		$agent[] = "IS12SH Build";
		
		# ■INFOBAR A01 シャープ ○
		$agent[] = "INFOBAR A01 Build";
		
		# ■IS04 富士通東芝モバイルコミュニケーションズ ○
		$agent[] = "IS04 Build";
		
		# ■IS11T 富士通東芝モバイルコミュニケーションズ　○
		$agent[] = "IS11T Build";
		
		# ■IS02 東芝 ○
		$agent[] = "KDDI-TS01";
		
		# ■E30HT HTC ○
		$agent[] = "KDDI-HT01";
		
		# ■IS12T 東芝 ○
		$agent[] = "IS12T";
		$agent[] = "XBLWP7";
		
		# ■XOOM
		$agent[] = "MZ604 Build";
		
		# ■SAMSUNG
		$agent[] = "SMT-i9100 Build";
		
		foreach($agent as $k=>$v){
			if(is_int(strpos($user_agent,$v))){
				return true;
			}
		}
		return false;
	}


?>