<?php

class FieldSortComponent extends Component{

	#
	# @author Kiyosawa 
	# @date 
	function __construct(){
	}
	
 	public function initialize(Controller $controller){
		$this->controller=$controller;
  	}

	# 
	# @author Kiyosawa 
	# @date 
	static function getSameSearch($ary=array(),$search_num=1){
		
		$_getSameSearch=function($value)use($search_num){ 
  			return ($value==$search_num);
		};
		$ary=array_filter($ary,$_getSameSearch);
		return $ary;
	}
	
	# ■正規化
	# @author Kiyosawa 
	# @date 
	static function aryNormalization(&$ary=array(),$first_value=''){
		
		$first_value=(!empty($first_value))?$first_value:current($ary);
		ksort($ary);
		foreach($ary as $k=>$v){
			$ary[$k]=$first_value++;
		}
	}
	
	#
	# @author Kiyosawa 
	# @date 
	static function nextIndex($ary=array()){
		
		$end=end($ary);
		$end++;
		return $end;
	}

	# ■ソート処理
	# @author Kiyosawa 
	# @date 
	static function fieldSort($ary=array(),$next_sort_num=1){
		
		if(empty($ary)) return array();
		
		$res=array();
		for($i=1;$i<=max($ary);$i++){
			
			$ones_value=self::getSameSearch($ary,$i);
			if(empty($ones_value)) continue;
			
			self::aryNormalization($ones_value,$next_sort_num);
			
			$next_sort_num=self::nextIndex($ones_value);
			
			$res+=$ones_value;
		}
		return $res;
	}
	
	
	# ■並び順変更
	# @author Kiyosawa 
	# @date 
	static function update($ary=array(),$key,$val){
		
		if(!isset($ary[$key])) return false;
		
		# 同じ値
		if($ary[$key]==$val) return $ary;
		
		$isUpper=($ary[$key]>$val);
		unset($ary[$key]);
		
		foreach($ary as $k=>$v){
			if($isUpper AND $v>=$val) $v++;
			if(!$isUpper AND $v<=$val) --$v;
			$tmp[$k]=$v;
		}
		
		# 変更対象の番号が多き過ぎる
		if($val>(count($ary)+1)){
			$val=(string)(count($ary)+1);
		}
		
		$tmp[$key]=$val;
		return $tmp;
	}
	
	# ■挿入
	# @author Kiyosawa 
	# @date 
	static function insert($ary=array(),$key,$val){
		
		if(isset($ary[$key])) return false;
		
		foreach($ary as $k=>$v){
			if($v>=$val) $v++;
			$tmp[$k]=(string)$v;
		}
		
		# 変更対象の番号が多き過ぎる
		if($val>(count($ary)+1)){
			$val=(string)(count($ary)+1);
		}
		
		$tmp[$key]=$val;
		return $tmp;
	}
	
	# ■挿入
	# @author Kiyosawa 
	# @date 
	static function sortExec($ary=array(),$key,$val){
		
		# 正規化してから並び替える
		$ary=self::fieldSort($ary);
		
		if(array_key_exists($key,$ary)){
			return self::update($ary,$key,$val);
		}
		return self::insert($ary,$key,$val);
	}
	
}
?>
