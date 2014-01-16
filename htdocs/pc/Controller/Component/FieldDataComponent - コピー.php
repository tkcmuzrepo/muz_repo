<?php

class Model{
	
	private $isPreview;
	private $modelStacks=array();
	private $modelNames=array('MuzForm',
		                      'MuzFormFieldSetting',
						      'MuzFormFieldSettingDetail',
						      'MuzFormColorSetting',
						      'MuzFormHtmlSetting',
						      'MuzFormGroupSetting',
						      'MuzFormImageSetting',
						      'MuzFormValueSetting');
	
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
	function getModel($modelName){
		
		if($this->isPreview AND isset($this->modelStacks[$modelName])){
			return ClassRegistry::init($this->modelStacks[$modelName]);
		}
		return ClassRegistry::init($modelName);
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

class FieldDataComponent extends Component{
	
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
		$this->isPreview=$isPreview;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function getModel($modelName){
		
		static $instance;
		if(!$instance){
			$instance=new Model();
		}
		return $instance->getModel($modelName);
	}
	
	# ■稼働中のフォーム
	# @author Kiyosawa 
	# @date 
	function getUseFormData($hash=''){
		
		if(!empty($this->form)){
			return $this->form;
		}
		
		v($this->getModel('MuzForm'));
		
		if(!$this->form=ClassRegistry::init("MuzForm")->findByHash($hash) OR empty($this->form['MuzForm']["view_flg"])){
			return false;
		}
		return $this->form;
	}
	
	# ■対象のフィールド(SORT)
	# @author Kiyosawa 
	# @date 
	function getUseFields($flg=false){
		
		if(!empty($flg) AND !empty($this->useFields)){
			return $this->useFields;
		}
		
		ClassRegistry::init("MuzFormFieldSetting")->order='MuzFormFieldSetting.sort_number ASC';
		if(!$this->useFields=ClassRegistry::init("MuzFormFieldSetting")->getUseFields($this->form['MuzForm']['id'])){
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
		
		$all_presets=$preset_detail_ids=array();
		foreach($this->usePresetFields as $k=>$v){
			
			$v['MuzFormPresetDetail']=Set::sort($v['MuzFormPresetDetail'],"{}.MuzFormPresetDetail.sort_num",'asc');
			$this->usePresetFields[$k]['MuzFormPresetDetail']=$v['MuzFormPresetDetail'];
			
			# 選択肢
			$preset_detail_ids=array_merge(Set::extract($v['MuzFormPresetDetail'],"{}.id"),$preset_detail_ids);
		}
		return $this->usePresetFields;
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
	function getFieldFormats($flg=false){
		
		if(!empty($flg) AND !empty($this->fieldFormats)){
			return $this->fieldFormats;
		}
		
		$types=array_unique(Set::extract($this->useFields,"{}.MuzFormFieldSetting.type"));
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
