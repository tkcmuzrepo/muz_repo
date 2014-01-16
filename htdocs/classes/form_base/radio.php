<?php

require_once(CLASS_DIR."form.php");

# 通常TEXT 郵便番号 電話番号 をカバーできる
class Radio extends Form{
	
	const NAME='radio';
	
	# ■入力制限
	const VALID_REQUIRED ='validate_radio validate_required';
	const VALID_NUMBER   ='validate_number';
	const VALID_ALPHA    ='validate_alpha';
	const VALID_EMAIL    ='validate_email';
	
	function __construct($form_id,$field_id){
		
		$this->formType='input_radio';
		parent::__construct($form_id,$field_id,'radio');
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
	
	# ■初期値の設定
	# ■設定した値を保持しておいて置換できる様にする
	# ■box_numの値によって状況は変わる
	public function setValueAttr($value='',$checked=false){
		
		$type='value';
		$value_format=$this->attrFormatValue;
		
		$form=$this->_getForm();
		$this->valueCache[$this->form_id][$this->field_id][$type][]=$value;
		$form=str_replace($this->attrValue,sprintf($value_format,$value),$form);
		
		if(!$checked){
			
			$this->form=str_replace($this->attrChecked,'',$form);
			return;
		}
		$this->form=str_replace($this->attrChecked,'checked',$form);
	}

	# ■表示用のクラス
	# @author Kiyosawa 
	# @date 
	public function setViewClass($className=''){
		
		if(empty($className)) return;
		$className=str_replace(","," ",$className);
		$class_format=$this->attrFormatClass;
		
		$viewFormat=$this->_getViewFormat();
		$viewFormat=str_replace($this->attrClass,sprintf($class_format,$className),$viewFormat);
		
		$this->viewFormat=$viewFormat;
	}
	
	
	# ■表示用のdata-title
	# @author Kiyosawa 
	# @date 
	function setViewDataTitle($title=''){
		
		if(empty($title)) return;
		$data_title_format=$this->attrDataTitle;
		
		$viewFormat=$this->_getViewFormat();
		$viewFormat=str_replace($this->attrDataTitle,sprintf($this->attrFormatDataTitle,$title),$viewFormat);
		$this->viewFormat=$viewFormat;
	}

	# ■HTML埋め込み
	# @author Kiyosawa 
	# @date 
	public function setHtml($html){
		
		$viewFormat=$this->_getViewFormat();
		$viewFormat=str_replace($this->attrHtml,$html,$viewFormat);
		$this->viewFormat=$viewFormat;
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
	
	#@Override
	protected function _makeName($form_id,$field_id){
		
		$name_format=$this->attrFormatName;
		$name=sprintf($name_format,$form_id,$field_id,1);
		return $name;
	}
	
	# ■表示内容の取得
	# @author Kiyosawa 
	# @date 
	public function getViewFormat(){
		
		$viewFormat=$this->_getViewFormat();
		$viewFormat=$this->stripCodes($viewFormat);
		return $viewFormat;
	}
	
}

?>