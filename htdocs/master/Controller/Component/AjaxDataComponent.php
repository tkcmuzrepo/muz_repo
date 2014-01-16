<?php

class AjaxDataComponent extends Component{

	public $res_error_param='err_mes';
	public $res_status_param='status';
	private $status=array(
		0=>'NO',
		1=>'YES'
	);
	public $error=array();
	private $res=array();
	
	#
	# @author Kiyosawa 
	# @date 
	function __construct(){
	}
	
 	public function initialize(Controller $controller) {
   		
		$this->controller=$controller;
		if(!empty($controller->params->data)){
			$this->sendData=$controller->params->data;
		}
		
		$this->error=tsv('error.tsv');
  	}
	
	#
	# @author Kiyosawa 
	# @date 
	static function trim($datas=array()){
		return array_map('trim',$datas);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	static function isEmpty($datas=array()){
		
		self::trim($datas);
		if(!in_array('',$datas)) return false;
		return true;
	}
	
	# ■配列の要素が一致しているか
	# @author Kiyosawa 
	# @date 
	static function isEqualArray($datas=array()){
		
		self::trim($datas);
		$first=array_shift($datas);
		$count_values=array_count_values($datas);
		if(!isset($count_values[$first]) OR $count_values[$first]!=count($datas)){
			return false;
		}
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function setError($error_num,$string=''){
		
		$this->res[$this->res_error_param]=sprintf($this->error[$error_num],$string);
		$this->res[$this->res_status_param]=$this->status[0];
	}
	
	# ■本番=>プレビューへ
	# @author Kiyosawa 
	# @date 
	function previewDataCopyExec($form_id,$date_key){
		
		if(empty($form_id) OR empty($date_key)) return false;
		
		# 本番=> プレビュー
		$flg=$this->controller->requestAction("/muz_previews/preview_exec/{$form_id}/{$date_key}");
		return $flg;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function restoreDateCopyExec($form_id,$date_key){
		
		if(empty($form_id)) return false;
		
		# 本番=> プレビュー
		return $this->controller->requestAction("/muz_previews/restore_exec/{$form_id}/{$date_key}");
	}
	
	# ■レス
	# @author Kiyosawa 
	# @date 
	function response($res=array()){
		
		$res=array_merge($this->res,$res);
		header("Content-Type:application/json;charset=utf-8");
		echo json_encode($res);
		exit;
	}

	# ■正常の場合
	# @author Kiyosawa 
	# @date 
	function successResponse($res=array()){
		
		$res[$this->res_status_param]=$this->status[1];
		$this->response($res);
	}

	# ■DB保存失敗
	# @author Kiyosawa 
	# @date 
	function notDbSave(){
		
		$res[$this->res_error_param]=$this->error[4];
		$res[$this->res_status_param]=$this->status[0];
		$this->response($res);
	}
	
	# ■入力値が空の要素があるか
	# @author Kiyosawa 
	# @date 
	function isEmptyAfterResponseExec($datas=array(),$res=array(),$error_num=''){
		
		if(!self::isEmpty($datas)) return true;
		
		$error_num=(!empty($error_num))?$error_num:0;
		
		# 空
		$res[$this->res_error_param]=$this->error[$error_num];
		$res[$this->res_status_param]=$this->status[0];
		$this->response($res);
	}
	
	# ■一致の確認
	# @author Kiyosawa 
	# @date 
	function isEqualAfterResponseExec($datas=array(),$error_num,$res=array()){
		
		if(self::isEqualArray($datas)) return false;
		
		# 空
		$res[$this->res_error_param]=$this->error[$error_num];
		$res[$this->res_status_param]=$this->status[0];
		$this->response($res);
	}
	
}
?>
