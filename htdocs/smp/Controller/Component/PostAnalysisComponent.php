<?php

class PostAnalysisComponent extends Component{
	
	public $sendFieldIds=array();
	private $value_separator='%*%';
	private $formFormat="\[Form([0-9]+)\]";
	private $fieldFormat="\[Field([0-9]+)\]";
	
	#
	# @author Kiyosawa 
	# @date 
	function __construct(){
	}
	
	
	/*
	
	# checkboxを想定
	$this->data['Form9']['Field10'][1]="AAA";
	$this->data['Form9']['Field10'][3]="BBB";
	$this->data['Form9']['Field10'][4]="CCC";
	
	# radioボタンを想定
	$this->data['Form9']['Field11'][1]="ラジオ1";
	$this->data['Form9']['Field12'][1]="ラジオ2";
	$this->data['Form9']['Field13'][1]="ラジオ3";
	
	# textboxを想定
	$this->data['Form9']['Field14'][1]="テキストボックス1";
	$this->getPostValuesKeyField($this->data["Form{$form_id}"]);
	
	*/
	
	# ■ポストした内容を整形
	# @author Kiyosawa 
	# @date 
	function getPostValuesKeyField($post=array()){
		
		if(empty($post)) return;
		
		$values=array();
		foreach($post as $k=>$v){
			$field_id=str_replace("Field","",$k);
			$values[$field_id]=implode($this->value_separator,array_values(array_map('trim',$v)));
		}
		
		$this->sendFieldIds=array_keys($values);
		return $values;
	}
	
	# ■フォーマットに対してフィールドを埋め込む
	# @author Kiyosawa 
	# @date 
	function format_replace($fields=array(),$field_format){
		
		foreach($fields as $k=>$v){
			$field_format=preg_replace("#%s#",$v,$field_format,1);
		}
		return $field_format;
	}
	
	# ■解析
	# ■form_id , field_id のデコード
	# ■Form9Field10_0,Form9Field10_1,Form9Field10_2 複数ボックスの場合はこんな感じになる
	# @author Kiyosawa 
	# @date 
	function fieldDecode($value){
		
		$reg_exp=sprintf("#%s#",$this->formFormat.$this->fieldFormat);
		$match_num=preg_match_all($reg_exp,$value,$match);
		if(empty($match_num)) return;
		
		$res['form_id']=$match[1][0];
		$res['field_id']=$match[2][0];
		return $res;
	}
	
	# ■NAME解析
	# @author Kiyosawa
	# @date 
	function formIdDecode($value){
		
		$match=preg_match("#".$this->formFormat."#",$value,$match_ary);
		if(empty($match)) return;
		return $match_ary[1];
	}
	
	# ■ID解析
	# @author Kiyosawa 
	# @date 
	function fieldIdDecode($value){
		
		$match=preg_match("#".$this->fieldFormat."#",$value,$match_ary);
		if(empty($match)) return;
		return $match_ary[1];
	}
	
}
?>
