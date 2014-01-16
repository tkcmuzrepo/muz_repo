<?php

class ModelName{
	
	private $isPreview;
	private $modelStacks=array();
	private $modelNames=array('MuzForm',
		                      'MuzFormFieldSetting',
						      'MuzFormFieldSettingDetail',
						      'MuzFormColorSetting',
						      'MuzFormHtmlSetting',
						      'MuzFormGroupSetting',
						      'MuzFormImageSetting',
						      'MuzFormValueSetting',
							  'MuzUser',
							  'MuzUserRegistData',
							  'MuzFormMessage');
							  
	function __construct($modelNames=array(),$isPreview=false){
		
		$this->isPreview=$isPreview;
		$this->modelNames=array_merge($this->modelNames,$modelNames);
		$this->setModel($this->modelNames);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function setModel($modelName){
		
		if(is_array($modelName)){
			foreach($modelName as $k=>$v){
				$this->setModel($v);
			}
			return;
		}
		
		$res=$this->__explode($modelName);
		
		$preview_name=$this->__implode($res);
		$this->modelStacks[$modelName]=$preview_name;
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function getModelName($modelName){
		
		if($this->isPreview AND isset($this->modelStacks[$modelName])){
			return $this->modelStacks[$modelName];
		}
		return $modelName;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function setPreview($isPreview){
		$this->isPreview=$isPreview;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __explode($modelName,$prefiex='Muz'){
		
		$_prefix=substr($modelName,'0',strlen($prefiex));
		if($prefiex!=$_prefix) return array();
		
		
		$_sufix=substr($modelName,strlen($prefiex));
		
		$res['prefix']=$_prefix;
		$res['sufix']=$_sufix;
		return $res;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __implode($data=array(),$str='Preview'){
		return "{$data['prefix']}{$str}{$data['sufix']}";
	}
}

class MainFieldDataComponent extends Component{
	
	public $sendData=array();
	private $fieldID;
	private $errorStacks=array();
	private $modelInstance;
	
	public $form;
	public $useFields;
	public $fieldFormats;
	private $isPreview=false;
	
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
  	}
	
	#
	# @author Kiyosawa 
	# @date 
	function setPreview($isPreview){
		
		if(!$this->modelInstance){
			$this->modelInstance=new ModelName();
		}
		$this->modelInstance->setPreview($isPreview);
	}
	
	#
	# @author Kiyosawa 
	# @date 
    function getModelName($modelName){
		
		if(!$this->modelInstance){
			$this->modelInstance=new ModelName();
		}
		return $this->modelInstance->getModelName($modelName);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getFormDataByStorage($hash){
		
		# ある
		if(!empty($this->form) AND $this->form[$this->getModelName('MuzForm')]['hash']==$hash){
			return $this->form;
		}
		
		# ない
		if(!$form=ClassRegistry::init($this->getModelName('MuzForm'))->findByHash($hash)){
			return false;
		}
		return $form;
	}
	
	# ■稼働中のフォーム
	# @author Kiyosawa 
	# @date 
	function getUseFormData($hash=''){
		
		if(!$form=$this->getFormDataByStorage($hash)){
			return false;
		}
		
		if(empty($form[$this->getModelName('MuzForm')]['view_flg'])) return false;
		
		$this->form=$form;
		return $form;
	}
	
	# ■対象のフィールド(SORT)
	# @author Kiyosawa 
	# @date 
	function getUseFields($flg=false){
		
		if(!empty($flg) AND !empty($this->useFields)){
			return $this->useFields;
		}
		
		ClassRegistry::init($this->getModelName('MuzFormFieldSetting'))->order="{$this->getModelName('MuzFormFieldSetting')}.sort_number ASC";
		if(!$this->useFields=ClassRegistry::init($this->getModelName('MuzFormFieldSetting'))->getUseFields($this->form[$this->getModelName('MuzForm')]['id'])){
			return false;
		}
		return $this->useFields;
	}
	
	# ■プリセット一覧
	# @author Kiyosawa 
	# @date 
	function getPresets($flg=false){
		
		if(!empty($flg) AND !empty($this->usePresetFields)){
			return $this->usePresetFields;
		}
		
		$preset_ids=$this->getPresetIds();
		
		$this->usePresetFields=ClassRegistry::init("MuzFormPreset")->findAllById($preset_ids);
		
		# サイト毎に動的に変わる
		$modelName=$this->__presetDetailModelName();
		
		$all_presets=$preset_detail_ids=array();
		foreach($this->usePresetFields as $k=>$v){
			
			$v[$modelName]=Set::sort($v[$modelName],"{}.{$modelName}.sort_num",'asc');
			$this->usePresetFields[$k][$modelName]=$v[$modelName];
			
			# 選択肢
			$preset_detail_ids=array_merge(Set::extract($v[$modelName],"{}.id"),$preset_detail_ids);
		}
		return $this->usePresetFields;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __presetDetailModelName(){
		
		$tmp_ary=array_keys(ClassRegistry::init("MuzFormPreset")->hasMany);
		return $tmp_ary[0];
	}
	
	# ■プリセット詳細のモデル名
	# @author Kiyosawa 
	# @date 
	function presetDetailModelName(){
		
		$siteName=ucfirst($this->controller->site);
		$preset_detail_model_site=($siteName=='Pc')?'':$siteName;
		return "MuzFormPreset{$preset_detail_model_site}Detail";
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getPresetFieldMergePresetValues($flg=false){
		
		$useFields=$this->getPresets($flg);
		
		$preset_detail_ids=$this->__getPresetDetailIds();
		$_preset_values=ClassRegistry::init("MuzFormPresetValue")->findAllByPresetDetailId($preset_detail_ids);
		foreach($_preset_values as $k=>$v){
			$preset_values[$v['MuzFormPresetValue']['preset_detail_id']][$v['MuzFormPresetValue']['data']]=$v['MuzFormPresetValue']['value'];
		}
		
		$modelName=$this->__presetDetailModelName();
		foreach($useFields as $k=>$v){
			
			# 基本
			$useFields[$v['MuzFormPreset']['id']]['MuzFormPreset']=$v['MuzFormPreset'];
			
			# 選択肢
			foreach($v[$modelName] as $_k=>$_v){
				if(!isset($preset_values[$_v['id']])) continue;
				$v[$modelName][$_k]['values']=$preset_values[$_v['id']];
			}
			
			# 詳細
			$useFields[$v['MuzFormPreset']['id']][$modelName]=$v[$modelName];
		}
		return $useFields;
	}
	
	
	# ■グループ一覧
	# @author Kiyosawa 
	# @date 
	function getGroupList(){
		
		$field_group_name=$this->getModelName('MuzFormGroupSetting');
		ClassRegistry::init($field_group_name)->order="{$field_group_name}.sort_number ASC";
		$groups=ClassRegistry::init($field_group_name)->findAllByFormId($this->form[$this->getModelName('MuzForm')]['id']);
		return $groups;
	}
	
	# ■フィールドに基づく出力フォーマット
	# @author Kiyosawa 
	# @date 
	function getFieldFormats($flg=false){
			
		if(!empty($flg) AND !empty($this->fieldFormats)){
			return $this->fieldFormats;
		}
		
		$types=array_unique(Set::extract($this->useFields,"{}.{$this->getModelName('MuzFormFieldSetting')}.type"));
		$type_formats=ClassRegistry::init("MuzFormTypeFormat")->findAllByTypeAndSite($types,$this->controller->site);
		
		$formats['main']=Set::combine($type_formats,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.main");
		$formats['conf']=Set::combine($type_formats,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.confirm");
		$this->fieldFormats=$formats;
		return $formats;
	}
	
	# ■[Group][Field]へ変換
	# @author Kiyosawa 
	# @date 
	function fieldsInGroups(){
		
		$field_name=$this->getModelName('MuzFormFieldSetting');
		$field_detail_name=$this->getModelName('MuzFormFieldSettingDetail');
		$field_value_name=$this->getModelName('MuzFormValueSetting');
		foreach($this->useFields as $k=>$v){
			
			$fields[$v[$field_name]['group_id']][$v[$field_name]['id']]=array_merge($v[$field_name],$v[$field_detail_name]);
			
			# 選択肢
			if(!empty($v[$field_value_name])){
				
				foreach($v[$field_value_name] as $_k=>$_v){
					$fields[$v[$field_name]['group_id']][$v[$field_name]['id']]['values'][$_v['value']]=$_v['value'];
				}
			}
		}
		return $fields;
	}
	
	# ■
	# @author Kiyosawa 
	# @date 
	private function __getPresetDetailIds(){
		
		$preset_detail_ids=array();
		$modelName=$this->__presetDetailModelName();
		foreach($this->usePresetFields as $k=>$v){
			$preset_detail_ids=array_merge(Set::extract($v[$modelName],"{}.id"),$preset_detail_ids);
		}
		return $preset_detail_ids;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getPresetIds(){

		if(empty($this->useFields)) return;
		$preset_ids=array_unique(Set::extract($this->useFields,"{}.{$this->getModelName('MuzFormFieldSettingDetail')}.preset_id"));
		$preset_ids=array_remove($preset_ids,'0');
		return $preset_ids;
	}
	
	#
	# @author Kiyosawa 
	# @date
	function setFieldID($field_id){
		$this->fieldID=$field_id;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function requiredValidate($value){
	}
	
	# ■1つでもNGがあればNG
	# @author Kiyosawa 
	# @date 
	private function __requiredText($value=''){
		
		if($this->errorStacks[$this->fieldID]['valid_required'])$this->errorStacks[$this->fieldID]['valid_required']=true;
		if(empty($value) AND !empty($this->errorStacks[$this->fieldID]['valid_required'])){
			$this->errorStacks[$this->fieldID]['valid_required']=false;
		}
	}
	
	# ■1つでもNGがあればNG
	# @author Kiyosawa 
	# @date 
	private function _requiredTextArea($value=''){
		$this->__requiredText($value);
	}
	
	# ■1つでもNGがあればNG
	# @author Kiyosawa 
	# @date 
	private function _requiredSelect($value=''){
		$value=trim($value,'-');
		$this->__requiredText($value);
	}
	
	# ■1でもtrueがあればtrue
	# @author Kiyosawa 
	# @date 
	private function __requiredCheckbox($value){
		
		if($this->errorStacks[$this->fieldID]['valid_required'])$this->errorStacks[$this->fieldID]['valid_required']=false;
		if(!empty($value) AND empty($this->errorStacks[$this->fieldID]['valid_required'])){
			$this->errorStacks[$this->fieldID]['valid_required']=true;
		}
	}
	
	# ■1でもtrueがあればtrue
	# @author Kiyosawa 
	# @date 
	private function _requiredRadio($value){
		$this->__requiredCheckbox($value);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _maxnumValidate(){
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function _numericValidate(){
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function _alphaValidate(){
		
	}
	
	
}
?>
