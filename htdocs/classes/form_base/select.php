<?php

require_once(CLASS_DIR."form.php");

# 通常TEXT 郵便番号 電話番号 をカバーできる
class Select extends Form{

	const NAME='select';

	# ■入力制限
	const VALID_REQUIRED ='validate_required';
	const VALID_NUMBER   ='validate_number';
	const VALID_ALPHA    ='validate_alpha';
	const VALID_EMAIL    ='validate_email';
	
	function __construct($form_id,$field_id){
		
		$this->formType='select';
		parent::__construct($form_id,$field_id);
	}
	
	# ■Styleを設定
	# @author Kiyosawa
	# @date
	public function setStyleAttr($style=''){
		
		$style_format=$this->attrFormatStyle;
		
		$form=$this->_getForm();
		$form=str_replace($this->attrStyle,sprintf($style_format,$style),$form);
		$this->form=$form;
	}
	
	# ■data_title属性
	# @author Kiyosawa 
	# @date 
	public function setDataTitle($data=''){
		
		$data_format=$this->attrFormatDataTitle;
		
		$form=$this->_getForm();
		$form=str_replace($this->attrDataTitle,sprintf($data_format,$data),$form);
		$this->form=$form;
	}
	
	# ■data属性
	# @author Kiyosawa 
	# @date 
	public function setData($data=''){
		
		$data_format=$this->attrFormatData;
		
		$form=$this->_getForm();
		$form=str_replace($this->attrData,sprintf($data_format,$data),$form);
		$this->form=$form;
	}
	
	# ■初期値の設定
	# ■設定した値を保持しておいて置換できる様にする
	# ■box_numの値によって状況は変わる
	public function setOption($values=array(),$selected_index=''){
		
		$value_change_code_value='#value#';
		$value_change_code_key='#key#';
		$selected_change_code="#selected#";
		$option_string='';
		$option_format="<option value=\"{$value_change_code_key}\" {$selected_change_code}>{$value_change_code_value}</option>";
		
		foreach($values as $k=>$v){
			
			$_option=str_replace($value_change_code_value,$v,$option_format);
			$_option=str_replace($value_change_code_key,$k,$_option);
			
			if((string)$k===(string)$selected_index){
				$_option=str_replace("#selected#",'selected',$_option);
				$option_string.=$_option;
				continue;
			}
			$_option=str_replace($selected_change_code,'',$_option);
			$option_string.=$_option;
		}
 		$this->form=str_replace($this->attrOption,$option_string,$this->form);
	}
	
	# ■フォームの取得
	public function getForm($formType=''){
		
		if(!empty($type)){
			$this->formType=$formType;
		}
		
		# フィールドindex
		if(!isset($this->formCountStacks[$this->form_id][$this->field_id])){
			$this->formCountStacks[$this->form_id][$this->field_id]=0;
		}else{
			$this->formCountStacks[$this->form_id][$this->field_id]++;
		}
		
		# name
		$attr_name_value=$this->_makeName($this->form_id,$this->field_id);
		$this->_setName($attr_name_value);
		
		# id
		$attr_id_value=$this->_makeID($this->form_id,$this->field_id);
		$this->_setID($attr_id_value);
		
		# type
		$this->_setTypeAttr();
		
		$form=$this->_getForm();
		$form=$this->stripCodes($form);
		$this->_clean();
		return $form;
	}
	
}

?>