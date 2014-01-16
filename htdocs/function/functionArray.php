<?php

function array_values_recursive($ary)
{
   $lst = array();
   foreach( array_keys($ary) as $k ){
      $v = $ary[$k];
      if (is_scalar($v)) {
         $lst[] = $v;
      } elseif (is_array($v)) {
         $lst = array_merge( $lst,
            array_values_recursive($v)
         );
      }
   }
   return $lst;
}

/**
 * ■配列の指定したキーの合計を求める
 * ■
 */
function array_sum_keys( $arr = array() , $index = null ){
    if(!is_array( $arr ) || sizeof( $arr ) < 1){
        return 0;
    }
    $ret = 0;
    foreach( $arr as $id => $data ){
        if( isset( $index )  ){
            $ret += (isset( $data[$index] )) ? $data[$index] : 0;
        }else{
            $ret += $data;
        }
    }
    	return $ret;
}

function array_remove(array $array = array() , $value = NULL , $strict=false)
{	
	static $ary = array();
	
	if(is_array($value)){
		foreach($value as $k=>$v){
			if(empty($ary)){
				$ary = array_remove($array , $v , $strict);
			}else{
				$ary = array_intersect($ary , array_remove($array , $v , $strict));
			}
		}
	}else{

    	$ary = array_diff_key($array, array_flip(array_keys($array, $value, $strict)));
	}
	return $ary;
}

/**
 * 多次元配列の合計を、条件を動的に指定して参照する
 * @author Akabane 
 * @date 2009/06/17 14:02:02 
 * 例> array_total($ary , "{n}.User.id");
 */
function array_total( $ary , $str="" , $first=true ){
	static $c = 0;
	static $sum = 0;
	
	if($first){
		$c = 0;
		$sum = 0;
	}

	$pattern = explode("." , $str);
	if($pattern[$c] == "{n}"){
		#v($ary , false);
		foreach($ary as $k=>$v){
			$params_str = "\$v";
			for($i=$c+1;$i<count($pattern) ;$i++){
				$params_str .= "[\"{$pattern[$i]}\"]";
			}//for
			$eval = ("\$param = ({$params_str}) ? {$params_str} : 0;");
			eval($eval);
			$sum += $param;
		}//foreach
	}
	else{
		$c++;
		array_total($ary[$pattern[$c-1]] , $str , false);
	}
	return $sum;
}

/**
 * 多次元配列の平均値を、条件を動的に指定して参照する
 * @author Akabane 
 * @date 2009/06/17 14:02:02 
 * 例> array_total($ary , "{n}.User.id");
 */
function array_avg( $ary , $str="" , $first=true , $isNotCountZero=false){
	static $key_num = 0;
	static $c = 0;
	static $sum = 0;
	
	if($first){
		$c = 0;
		$sum = 0;
		$key_num = 0;
	}

	$pattern = explode("." , $str);
	if($pattern[$c] == "{n}"){
		#v($ary , false);
		foreach($ary as $k=>$v){
			$params_str = "\$v";
			for($i=$c+1;$i<count($pattern) ;$i++){
				$params_str .= "[\"{$pattern[$i]}\"]";
			}//for
			$eval = ("\$param = ({$params_str}) ? {$params_str} : 0;");
			eval($eval);
			if($param){
				$key_num++;
				$sum += $param;
			}
		}//foreach
	}
	else{
		$c++;
		array_avg($ary[$pattern[$c-1]] , $str , false);
	}
	return @($sum / $key_num);
}

/**
 * 多次元配列の最小値を、条件を動的に指定して参照する
 * @author Akabane 
 * @date 2009/06/17 14:02:02 
 * 例> array_total($ary , "{n}.User.id");
 */
function array_min( $ary , $str="" , $first=true ){
	static $c = 0;
	static $min_key;
	static $min_num = false;
	
	if($first){
		$c = 0;
		$min_key = false;
		$min_num = 0;
	}

	$pattern = explode("." , $str);
	if($pattern[$c] == "{n}"){
		#v($ary , false);
		foreach($ary as $k=>$v){
			$params_str = "\$v";
			for($i=$c+1;$i<count($pattern) ;$i++){
				$params_str .= "[\"{$pattern[$i]}\"]";
			}//for
			$eval = ("\$param = ({$params_str}) ? {$params_str} : 0;");
			eval($eval);
			if(FALSE==$min_num OR $param < $min_num){
				$min_key = $k;
				$min_num = $param;
			}
		}//foreach
	}else{
		$c++;
		array_min($ary[$pattern[$c-1]] , $str , false);
	}
	$return = array("min_num"=>$min_num , "min_key"=> $min_key);
	return $return;
}

/**
 * 多次元配列の最大値を、条件を動的に指定して参照する
 * @author Akabane 
 * @date 2009/06/17 14:02:02 
 * 例> array_total($ary , "{n}.User.id");
 */
function array_max( $ary , $str="" , $first=true ){
	static $c = 0;
	static $max_key;
	static $max_num = 0;
	
	if($first){
		$c = 0;
		$max_key = false;
		$max_num = 0;
	}

	$pattern = explode("." , $str);
	if($pattern[$c] == "{n}"){
		#v($ary , false);
		foreach($ary as $k=>$v){
			$params_str = "\$v";
			for($i=$c+1;$i<count($pattern) ;$i++){
				$params_str .= "[\"{$pattern[$i]}\"]";
			}//for
			$eval = ("\$param = ({$params_str}) ? {$params_str} : 0;");
			eval($eval);
			if($param > $max_num){
				$max_key = $k;
				$max_num = $param;
			}
		}//foreach
	}else{
		$c++;
		array_max($ary[$pattern[$c-1]] , $str , false);
	}
	$return = array("max_num"=>$max_num , "max_key"=> $max_key);
	return $return;
}

?>