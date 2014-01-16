<?php
	
	/**
	 * �o�^������A����ۋ������Z�o����
	 * @author Akabane 
	 * @date 2009/07/13 08:26:14 
	 */
	function getSoftbankMonthlyDate($year="" , $month="" , $day=""){
		if(!$year){
			$year  = date("Y");
			$month = date("m");
			$day   = date("d");
		}
		$t = date("t" , strtotime("{$year}-{$month}-01")); # �Y����������
		
		//A) �\�����������ł͂Ȃ��A���A29 ���A�������́A30 ���̏ꍇ
		if(($day == 30 or $day == 29) AND $day != $t){
			# �\�����Ɠ��������݂��Ȃ����͖����ɉۋ������
			$tmp_date = date("Y-m-{$day}" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
			$tmp = explode("-" , $tmp_date);
			if( checkdate ( $tmp[1] , $tmp[2] , $tmp[0] )){
				$res = $tmp_date;
			}else{
				$res  = date("Y-m-t" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
			}
		}
		//(C)�����`28��
		elseif($day <= 28){
			$res = date("Y-m-{$day}" , strtotime("+1 month" , strtotime( date("{$year}-{$month}-01")  )));
		}
		//(B)���� 
		elseif($day == $t){
			$res = date("Y-m-t" , strtotime("+1 month" , strtotime("{$year}-{$month}-01")));
		}
		return $res;
	}

	/**
	 * Softbank���ۋ��F�؂��s���ăA�N�Z�X���������m�F����
	 * 2009/07/10 16:16:16 
	 */
	function isRegisterSB($reg=1){
		# $_GET["reg"] 0:�މ� 1:�o�^ 2:�L�����Z��
		if( !isset($_GET["reg"]) or $_GET["reg"] != $reg){
			return false;
		}
		# �o�^���s�������̂ݕ\�������B���_�C���N�g���g���ƕ\������Ȃ�
		if(isset($_SERVER["HTTP_X_JPHONE_REGISTERED"])){
			return true;
		}
		return false;
	}

	/**
	 * �v�����[�V������p���Z�o����
	 * @author Akabane 
	 * @date 2009/07/09 09:48:22 
	 */
	function getPromotionCost($promotion , $course){
		if(empty($promotion)){
			return 0;
		}
		$price = $course["OfEntryCourseSet"]["price"];
		
		switch( $promotion["OfPromotion"]["pb_type"]){
			//�ꗥ
			case 1:
				$return = $promotion["OfPromotion"]["price"];
				break;
			//�藦
			case 2:
				$return = number_format($promotion["OfPromotion"]["price_rate"] / 100 * $price );
				break;
			//�R�[�X�ʒ艿
			case 3:
				$price_list = unserialize($promotion["OfPromotion"]["price_list_ary"]);
				$return = $price_list[$price];
				break;
		}
		return $return;
	}

	/**
	 * ���グ�������`�F�b�N
	 * 2009/07/07 03:39:43  AU�� 2009-09*�̏ꍇ�́A09���͍�pt�t�^����Ȃ��B
	 * 2009/07/13 06:01:44  SB�� �މ�����ɂ��̊��Ԃ�j���������ɂȂ�A�ĉۋ������̂őS��true�ŕԂ�
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
	 * �v�����[�V�������ʂ�ʒm����
	 * @author Akabane 
	 * @date 2009/06/16 23:20:24 
	 */
	function fopen_promotion( $promotion_url , $p_opt1 , $p_opt2 , $course_price="" , $promotion_price=""){

		//�^�O�̒u��
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
			//���O�ۑ�
			v($url , 2 , "promotion.log" );
			@fopen($url , "r");
		}
	}

	/**
	 * API�Ń`�F�b�N��������
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