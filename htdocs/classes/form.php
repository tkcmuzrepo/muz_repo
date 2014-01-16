<?php

# 初期構造のみを着手する
class FormFactory{
	
	# 属性リスト
	static $attrCodes=array(
		
		'attrType'       =>'#type#',
		'attrStyle'      =>'#style#',
		'attrValue'      =>'#value#',
		'attrId'         =>'#id#',
		'attrName'       =>'#name#',
		'attrOption'     =>'#option#',
		'attrClass'      =>'#class#',
		'attrPlaceholder'=>'#placeholder#',
		'attrChecked'    =>'#checked#',
		'attrSelected'   =>'#selected#',
		'attrData'       =>'#data#',
		'attrDataNum'    =>'#data_num#',
		'attrDataTitle'  =>'#data_title#',
		'attrHtml'       =>'#html#'
	);
	
	# 表示タグ
	private $viewFormat=array(
		
		'input_checkbox_view'=>array('pc'=>"<ul %s %s>%s</ul>",
		                             'sp'=>"<ul %s %s>%s</div>",
								     'mb'=>"<ul %s %s>%s</ul>"
		),
		'input_radio_view'=>array('pc'=>"<ul %s %s>%s</ul>",
		                          'sp'=>"<ul %s %s>%s</ul>",
							      'mb'=>"<ul %s %s>%s</ul>"
		)
	);
	
	static $attrFormat=array(
		
		'attrFormatValue' =>"value=\"%s\"",
		'attrFormatType'  =>"type=\"%s\"",
		'attrFormatStyle' =>"style=\"%s\"",
		'attrFormatName'  =>"name=\"data[Form%s][Field%s][%s]\"",
		'attrFormatId'    =>"id=\"%s\"",
		'attrFormatData'  =>"data=\"%s\"",
		'attrFormatDataNum'  =>"data_num=\"%s\"",
		'attrFormatDataTitle'  =>"data_title=\"%s\"",
		'attrFormatClass' =>"class=\"%s\"",
		
	);
	
	# ■format
	private $formFormat=array(
		
		'input_text'    =>"<input %s %s %s %s %s %s %s %s %s %s/>",
		'input_checkbox'=>"<input %s %s %s %s %s %s %s#checked#/>",
		'input_radio'   =>"<input %s %s %s %s %s %s %s #checked#/>",
		'select'        =>"<select %s %s %s %s %s %s>#option#</select>",
		'textarea'      =>"<textarea %s %s %s %s %s %s %s>#value#</textarea>",
	);
	
	#
	# @author Kiyosawa 
	# @date 
	function input_checkbox_view(){
		
		if(!isset($this->viewFormat['input_checkbox_view'])) return;
		
		$view_format=$this->viewFormat['input_checkbox_view'];
		
		foreach($view_format as $k=>$v){
			
			$v=sprintf($v,self::$attrCodes['attrClass'],
			              self::$attrCodes['attrDataTitle'],
					      self::$attrCodes['attrHtml']);
			$view_format[$k]=$v;
		}
		return $view_format;
	}
	
	# 
	# @author Kiyosawa 
	# @date 
	function input_radio_view(){
		
		if(!isset($this->viewFormat['input_radio_view'])) return;
		
		$view_format=$this->viewFormat['input_radio_view'];
		
		foreach($view_format as $k=>$v){
			
			$v=sprintf($v,self::$attrCodes['attrClass'],
			              self::$attrCodes['attrDataTitle'],
						  self::$attrCodes['attrHtml']);
			
			$view_format[$k]=$v;
		}
		return $view_format;
	}

	#
	# @author Kiyosawa
	# @date 
	function input_text_view(){
		return;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function select_view(){
		return;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function textarea_view(){
		return;
	}
	
	# ■ <input type=''>
	# @author Kiyosawa 
	# @date 
	function input_text(){
		
		$input_format=$this->formFormat['input_text'];
		$input=sprintf($input_format,self::$attrCodes['attrType'],
		                             self::$attrCodes['attrStyle'],
									 self::$attrCodes['attrValue'],
									 self::$attrCodes['attrId'],
									 self::$attrCodes['attrName'],
									 self::$attrCodes['attrClass'],
									 self::$attrCodes['attrData'],
									 self::$attrCodes['attrDataNum'],
									 self::$attrCodes['attrDataTitle'],
									 self::$attrCodes['attrPlaceholder']);
		return $input;
	}
	
	# ■ <select>
	# @author Kiyosawa 
	# @date 
	function select(){
		
		$select_format=$this->formFormat['select'];
		$select=sprintf($select_format,self::$attrCodes['attrStyle'],
		                               self::$attrCodes['attrId'],
									   self::$attrCodes['attrName'],
									   self::$attrCodes['attrClass'],
									   self::$attrCodes['attrDataTitle'],
									   self::$attrCodes['attrData']);
		return $select;
	}
	
	
	# ■ <input type="checkbox">
	# @author Kiyosawa 
	# @date 
	function input_checkbox(){
		
		$input_format=$this->formFormat['input_checkbox'];
		$input=sprintf($input_format,self::$attrCodes['attrType'],
		                             self::$attrCodes['attrStyle'],
									 self::$attrCodes['attrValue'],
									 self::$attrCodes['attrId'],
									 self::$attrCodes['attrName'],
									 self::$attrCodes['attrClass'],
									 self::$attrCodes['attrData']
									 );
		return $input;
	}
	
	# ■ <input type="radio">
	# @author Kiyosawa 
	# @date 
	function input_radio(){
		
		$input_format=$this->formFormat['input_radio'];
		$input=sprintf($input_format,self::$attrCodes['attrType'],
		                             self::$attrCodes['attrStyle'],
									 self::$attrCodes['attrValue'],
									 self::$attrCodes['attrId'],
									 self::$attrCodes['attrName'],
									 self::$attrCodes['attrData'],
									 self::$attrCodes['attrClass']
									 );
		return $input;
	}

	# ■ <textarea>
	# @author Kiyosawa 
	# @date 
	function textarea(){
		
		$input_format=$this->formFormat['textarea'];
		$input=sprintf($input_format,self::$attrCodes['attrStyle'],
									 self::$attrCodes['attrId'],
									 self::$attrCodes['attrName'],
									 self::$attrCodes['attrClass'],
									 self::$attrCodes['attrData'],
									 self::$attrCodes['attrDataNum'],
									 self::$attrCodes['attrDataTitle']									 									 
									 );
		return $input;
	}
	
	# ■typeが合っているかの確認
	# @author Kiyosawa 
	# @date 
	static function attrExists($attr){
		
		if(array_key_exists($attr,self::$attrCodes)){
			return true;
		}
		return false;
	}
}

class Form{
	
	# ■フォーム識別の為 name[FormID][FieldID] とする
	# 継承先からであれば変更可能
	protected $form_id;
	protected $field_id;
	
	# ■作成中のフォーム
	# メソッドを介して編集させる
	protected $form;
	
	# ■作成中の表示内容
	protected $viewFormat;
	
	# ■pc,sp,mb
	protected $site='pc';
	
	# ■input とか 
	protected $formType;
	protected $formTypeValue;
	private $input_ary=array();
	
	# ■保持した値をキャッシュする
	protected $valueCache=array();
	
	# ■フォーム数
	protected $formCountStacks=array();
	
	# 
	# @author Kiyosawa 
	# @date 
	function __construct($form_id,$field_id,$attr_type=''){
		
		$form=new FormFactory();
		
		if(!method_exists($form,$this->formType)){
			return;
		}
		
		# 属性コード
		$this->__setAttrCodes();
		
		# 属性フォーマット
		$this->__setAttrFormat();
		
		$this->form_id=$form_id;
		$this->field_id=$field_id;
		$this->formTypeValue=$attr_type;
		
		# フィールド表示
		if(method_exists($form,$this->formType)){
			$this->input_ary[$this->formType]=$form->{$this->formType}();
		}
		
		# 出力表示
		$view_name="{$this->formType}_view";
		if(method_exists($form,$view_name)){
			$this->view_ary[$this->formType]=$form->{$view_name}();
		}
		
	}
	
	# ■サイトの設定
	# @author Kiyosawa 
	# @date 
	public function setSite($site='pc'){
		
		if(empty($site)) return;
		$site_lis=array('pc','sp','mb');
		
		if(!in_array($site,$site_lis)) return;
		$this->site=$site;
	}
	
	# ■属性コード設定
	# @author Kiyosawa 
	# @date 
	private function __setAttrCodes(){
		
		foreach(FormFactory::$attrCodes as $k=>$v){
			$this->{$k}=$v;
		}
	}
	
	# ■属性フォーマット
	# @author Kiyosawa 
	# @date 
	private function __setAttrFormat(){
		
		foreach(FormFactory::$attrFormat as $k=>$v){
			$this->{$k}=$v;
		}
	}
	
	# ■IDの作成
	# @author Kiyosawa
	# @date 
	protected function _makeID($form_id,$field_id){
		
		$format="Form%sField%s_%s";
		$id=sprintf($format,$form_id,$field_id,$this->formCountStacks[$form_id][$field_id]);
		return $id;
	}
	
	# ■NAMEの作成
	# ■radioボタンは1グループで同じ名前になる
	# @author Kiyosawa 
	# @date 
	protected function _makeName($form_id,$field_id){
		
		$name_format=$this->attrFormatName;
		$name=sprintf($name_format,$form_id,$field_id,$this->formCountStacks[$form_id][$field_id]);
		return $name;
	}
	
	# ■IDの作成
	# ■命名規則 => Form9Field10_1
	# @author Kiyosawa
	# @date 
	protected function _setID($id){
		
		$form=$this->_getForm();
		$id_format=$this->attrFormatId;
		$form=str_replace($this->attrId,sprintf($id_format,$id),$form);
		$this->form=$form;
		
	}
	
	# ■NAMEの作成
	# ■命名規則 => data[Form10Field12][1],data[Form10Field12][2]
	# @author Kiyosawa 
	# @date 
	protected function _setName($name){
		
		$form=$this->_getForm();
		$form=str_replace($this->attrName,$name,$form);
		$this->form=$form;
	}
	
	# ■type=text
	# @author Kiyosawa 
	# @date 
	protected function _setTypeAttr($attr_type='text'){
		
		$type='type';
		$value_format=$this->attrFormatType;
		
		$form=$this->_getForm();
		$this->valueCache[$this->form_id][$this->field_id][$type][]=$this->formTypeValue;
		$form=str_replace($this->attrType,sprintf($value_format,$this->formTypeValue),$form);
		$this->form=$form;
	}
	
	# ■フォームの取得
	# @author Kiyosawa 
	# @date 
	protected function _getForm(){
		
		$form=$this->input_ary[$this->formType];
		if(!empty($this->form)){
			$form=$this->form;
		}
		return $form;
	}
	
	# ■クラスの設定
	# @author Kiyosawa 
	# @date 
	public function setClass($className=''){
		
		if(empty($className)) return;
		
		$className=str_replace(","," ",$className);
		
		$class_format=$this->attrFormatClass;
		
		$form=$this->_getForm();
		$form=str_replace($this->attrClass,sprintf($class_format,$className),$form);
		$this->form=$form;
	}
	
	# ■フィールドの表示方法
	# @author Kiyosawa 
	# @date 
	protected function _getViewFormat(){
		
		if(!isset($this->view_ary[$this->formType][$this->site])) return;
		
		$viewFormat=$this->view_ary[$this->formType][$this->site];
		if(!empty($this->viewFormat)){
			$viewFormat=$this->viewFormat;
		}
		return $viewFormat;
	}
	
	public function _setFieldIndex($field_detail_id=0){
		$this->field_detail_id=$field_detail_id;
	}
	
	# ■置換タグを抹消
	static function stripCodes($form){
		
		$attr_codes=array_values(FormFactory::$attrCodes);
		return str_replace($attr_codes,'',$form);
	}
	
	# ■値変換
	public function replace($type,$value){
		
		$format="attrFormat%s";
		$attr=sprintf($format,ucfirst($type));
		
		# 対象外
		if(!array_key_exists($attr,FormFactory::$attrFormat)){
			die(__FUNCTION__);
		}
		
		# キャッシュなし
		if(!array_key_exists($type,$this->valueCache)){
			return $this->form;
		}
		
		# 置換処理
		$beforeValue=sprintf($this->{$attr},$this->valueCache[$type]);
		$afterValue =sprintf($this->{$attr},$value);
		$this->form=str_replace($beforeValue,$afterValue,$this->form);
		
		# キャッシュ
		$this->valueCache[$type]=$value;
		
		return $this->form;
	}
	
	# ■クリア
	# @author Kiyosawa 
	# @date 
	protected function _clean(){
		
		$this->form=null;
	}
	
}

?>