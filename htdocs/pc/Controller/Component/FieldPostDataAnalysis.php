<?php

class FieldPostDataAnalysisComponent extends Component{
	
	public $sendData=array();
	private $fieldID;
	private $errorStacks=array();
	
	public $form;
	public $useFields;
	public $usePresetFields;
	
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
	
	# ■稼働中のフォーム
	# @author Kiyosawa 
	# @date 
	function getUseFormData($hash){
		
		if(!$this->form=ClassRegistry::init("MuzForm")->findByHash($hash) OR empty($this->form['MuzForm']["{$this->controller->site}_flg"])){
			return false;
		}
		return $this->form;
	}
	
	# ■対象のフィールド(SORT)
	# @author Kiyosawa 
	# @date 
	function getUseFields(){
		
		ClassRegistry::init("MuzFormFieldSetting")->order='MuzFormFieldSetting.sort_number ASC';
		if(!$this->useFields=ClassRegistry::init("MuzFormFieldSetting")->getUseFields($this->form['MuzForm']['id'])){
			return false;
		}
		return $this->useFields;
	}
	
	# ■プリセット一覧
	# @author Kiyosawa 
	# @date 
	function getPresets(){
		
		if(empty($this->usePresetFields)){
			$preset_ids=$this->getPresetIds();
			$this->usePresetFields=ClassRegistry::init("MuzFormPreset")->findAllById($preset_ids);
		}
		
		$all_presets=$preset_detail_ids=array();
		foreach($this->usePresetFields as $k=>$v){
			
			$key_id=array();
			foreach($v['MuzFormPresetDetail'] as $_k=>$_v){
				$key_id[$_k]=$_v['sort_num'];
			}
			array_multisort($key_id,SORT_ASC,SORT_NUMERIC,$v['MuzFormPresetDetail']);
			$this->usePresetFields[$k]['MuzFormPresetDetail']=$v['MuzFormPresetDetail'];
			
			# 選択肢
			$preset_detail_ids=array_merge(Set::extract($v['MuzFormPresetDetail'],"{}.id"),$preset_detail_ids);
		}
		return $this->usePresetFields;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getPresetFieldMergePresetValues(){
		
		$useFields=$this->getPresets();
		
		$preset_detail_ids=$this->_getPresetDetailIds();
		$_preset_values=ClassRegistry::init("MuzFormPresetValue")->findAllByPresetDetailId($preset_detail_ids);
		foreach($_preset_values as $k=>$v){
			$preset_values[$v['MuzFormPresetValue']['preset_detail_id']][$v['MuzFormPresetValue']['data']]=$v['MuzFormPresetValue']['value'];
		}
		
		foreach($useFields as $k=>$v){
			
			# 基本
			$useFields[$v['MuzFormPreset']['id']]['MuzFormPreset']=$v['MuzFormPreset'];
			
			# 選択肢
			foreach($v['MuzFormPresetDetail'] as $_k=>$_v){
				if(!isset($preset_values[$_v['id']])) continue;
				$v['MuzFormPresetDetail'][$_k]['values']=$preset_values[$_v['id']];
			}
			
			# 詳細
			$useFields[$v['MuzFormPreset']['id']]['MuzFormPresetDetail']=$v['MuzFormPresetDetail'];
		}
		
		return $useFields;
	}
	
	
	# ■グループ一覧
	# @author Kiyosawa 
	# @date 
	function getGroupList(){
		
		ClassRegistry::init("MuzFormGroupSetting")->order='MuzFormGroupSetting.sort_number ASC';
		$groups=ClassRegistry::init("MuzFormGroupSetting")->findAllByFormId($this->form['MuzForm']['id']);
		return $groups;
	}
	
	# ■フィールドに基づく出力フォーマット
	# @author Kiyosawa 
	# @date 
	function getFieldFormats(){
		
		$types=array_unique(Set::extract($this->useFields,"{}.MuzFormFieldSetting.type"));
		$type_formats=ClassRegistry::init("MuzFormTypeFormat")->findAllByTypeAndSite($types,$this->controller->site);
		$types=Set::combine($type_formats,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.format");
		return $types;
	}
	
	# ■[Group][Field]へ変換
	# @author Kiyosawa 
	# @date 
	function fieldsInGroups(){
		
		foreach($this->useFields as $k=>$v){
			
			$fields[$v['MuzFormFieldSetting']['group_id']][$v['MuzFormFieldSetting']['id']]=array_merge($v['MuzFormFieldSetting'],$v['MuzFormFieldSettingDetail']);
			
			# 選択肢
			if(!empty($v['MuzFormValueSetting'])){
				
				foreach($v['MuzFormValueSetting'] as $_k=>$_v){
					$fields[$v['MuzFormFieldSetting']['group_id']][$v['MuzFormFieldSetting']['id']]['values'][$_v['value']]=$_v['value'];
				}
			}
		}
		return $fields;
	}
	
	# ■
	# @author Kiyosawa 
	# @date 
	private function _getPresetDetailIds(){
		
		$preset_detail_ids=array();
		foreach($this->usePresetFields as $k=>$v){
			$preset_detail_ids=array_merge(Set::extract($v['MuzFormPresetDetail'],"{}.id"),$preset_detail_ids);
		}
		return $preset_detail_ids;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getPresetIds(){
	
		if(empty($this->useFields)) return;
		$preset_ids=array_unique(Set::extract($this->useFields,"{}.MuzFormFieldSettingDetail.preset_id"));
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
	private function _requiredText($value=''){
		
		if($this->errorStacks[$this->fieldID]['valid_required'])$this->errorStacks[$this->fieldID]['valid_required']=true;
		if(empty($value) AND !empty($this->errorStacks[$this->fieldID]['valid_required'])){
			$this->errorStacks[$this->fieldID]['valid_required']=false;
		}
	}
	
	# ■1つでもNGがあればNG
	# @author Kiyosawa 
	# @date 
	private function _requiredTextArea($value=''){
		$this->_requiredText($value);
	}
	
	# ■1つでもNGがあればNG
	# @author Kiyosawa 
	# @date 
	private function _requiredSelect($value=''){
		$value=trim($value,'-');
		$this->_requiredText($value);
	}
	
	# ■1でもtrueがあればtrue
	# @author Kiyosawa 
	# @date 
	private function _requiredCheckbox($value){
		
		if($this->errorStacks[$this->fieldID]['valid_required'])$this->errorStacks[$this->fieldID]['valid_required']=false;
		if(!empty($value) AND empty($this->errorStacks[$this->fieldID]['valid_required'])){
			$this->errorStacks[$this->fieldID]['valid_required']=true;
		}
	}
	
	# ■1でもtrueがあればtrue
	# @author Kiyosawa 
	# @date 
	private function _requiredRadio($value){
		$this->_requiredCheckbox($value);
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
