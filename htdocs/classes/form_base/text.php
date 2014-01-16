<?php

require_once(CLASS_DIR."form.php");

# 通常TEXT 郵便番号 電話番号 をカバーできる
class Text extends Form{

	const NAME='text';

	# ■入力制限
	#const VALID_REQUIRED ='validate_checkbox validate_required';
	const VALID_REQUIRED ='validate_required';
	const VALID_NUMBER   ='validate_number';
	const VALID_ALPHA    ='validate_alpha';
	const VALID_EMAIL    ='validate_email';
	
	function __construct($form_id,$field_id,$attr_type=''){
		
		$this->formType='input_text';
		
		if(empty($attr_type)) $attr_type='text';
		
		parent::__construct($form_id,$field_id,$attr_type);
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
	
	
	# ■タイプの切り替え(telになる可能性あり)
	# @author Kiyosawa 
	# @date 
	public function setFieldType($type){
		$this->formTypeValue=$type;
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
	
	# ■data_num属性
	# ■最大文字数で使用
	# @author Kiyosawa 
	# @date 
	public function setDataNum($data=''){
		
		$data_format=$this->attrFormatDataNum;
		
		$form=$this->_getForm();
		$form=str_replace($this->attrDataNum,sprintf($data_format,$data),$form);
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
	
	# ■初期値の設定
	# ■設定した値を保持しておいて置換できる様にする
	# ■box_numの値によって状況は変わる
	public function setValueAttr($value=''){
		
		$type='value';
		$value_format=$this->attrFormatValue;
		
		$form=$this->_getForm();
		$this->valueCache[$type]=$value;
		$form=str_replace($this->attrValue,sprintf($value_format,$value),$form);
		$this->form=$form;
	}
	
	# ■フォームの取得
	public function getForm($formType=''){
		
		if(!empty($formType)){
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