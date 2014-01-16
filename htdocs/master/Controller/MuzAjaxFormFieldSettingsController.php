<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5

 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

App::uses('AppController','Controller');

require_once("form_base".DS."text.php");
require_once("form_base".DS."select.php");
require_once("form_base".DS."checkbox.php");
require_once("form_base".DS."radio.php");
require_once("form_base".DS."textarea.php");

class MuzAjaxFormFieldSettingsController extends AppController{

	public $name = 'MuzAjaxFormFieldSettings';
	public $components=array('AjaxData','FieldSort');
	public $uses = array("MuzFormFieldSetting","MuzPreviewFormFieldSetting");
	private $res=array();
	private $admin_level=array(
		
		0=>2, # admin
		1=>1  # master
	);
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		
		#Configure::write('debug',0);
		
		# 送信データ処理
		if(property_exists($this->params,'data')){
			$this->data=&$this->params->data;
		}
		
		if(!$login_id=$this->Session->read('login_id')){
			$this->AjaxData->setError(2);
			$this->AjaxData->response();
		}
		
		$this->login_user=ClassRegistry::init("MuzMasterAccount")->_getLoignAccount($login_id);
		
		try{
			$this->res['form_id']=$this->data['MuzFormFieldSetting']['form_id'];
			$this->res['date_key']=$this->data['MuzFormFieldSetting']['date_key'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['preview']='YES';
		if(!$this->AjaxData->previewDataCopyExec($this->res['form_id'],$this->res['date_key'])){
		$this->res['preview']='NO';
		}
	}
	
	# プレビューへ保存するよ
	
	function index(){
		
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _classLoad(){
		
		#微妙
		require_once(CLASS_DIR."form_base".DS."text.php");
		require_once(CLASS_DIR."form_base".DS."textarea.php");
	}
	
	# ■muz_form_field_settings
	# @author Kiyosawa 
	# @date 
	function fieldEditSave($datas=array()){
		
		$save['MuzPreviewFormFieldSetting']=$datas;
		if(!$res=ClassRegistry::init("MuzPreviewFormFieldSetting")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		return $res;
	}
	
	# ■muz_form_field_setting_details
	# @author Kiyosawa 
	# @date 
	function fieldSetttingDetailEdit($datas=array()){
		
		if(!$data=ClassRegistry::init("MuzPreviewFormFieldSettingDetail")->findByFieldId($datas['field_id'])){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		$datas=$this->AjaxData->trim($datas);
		$save['MuzPreviewFormFieldSettingDetail']=$datas;
		$save['MuzPreviewFormFieldSettingDetail']['id']=$data['MuzPreviewFormFieldSettingDetail']['id'];
		if(!$res=ClassRegistry::init("MuzPreviewFormFieldSettingDetail")->save($save)){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		return $res;
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function test(){
		
		v('OK');
	}
	
	# ■muz_form_value_settings
	# @author Kiyosawa 
	# @date 
	function fieldEditValuesSave($form_id,$field_id,$values=array()){
		
		# 一度消して再保存
		$w['field_id']=$field_id;
		ClassRegistry::init("MuzPreviewFormValueSetting")->deleteAll($w,false);
		
		$insert=array();
		$counter=0;
		foreach($values as $k=>$v){
			$insert[$counter]['field_id']=$field_id;
			$insert[$counter]['value']=$v;
			$insert[$counter++]['form_id']=$form_id;
		}
		ClassRegistry::init("MuzPreviewFormValueSetting")->multiInsertForSqlServer($insert);
	}
	
	
	# ■新規保存
	# ■フィールドIDを返す
	# @author Kiyosawa 
	# @date 
	function fieldNewSave(){
		
		try{
			$this->res['title']=$datas['title']=$this->data['MuzFormFieldSetting']['title'];
			$this->res['required_flg']=$datas['required_flg']=$this->data['MuzFormFieldSetting']['required_flg'];
			$this->res['view_flg']=$datas['view_flg']=$this->data['MuzFormFieldSetting']['view_flg'];
			$this->res['type']=$datas['type']=$this->data['MuzFormFieldSetting']['type'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$datas['form_id']=$this->res['form_id'];
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		# type 変換
		$datas['type']=$this->_replaceFieldType($datas['type']);
		
		# 必須ではない
		$datas['sub_title']=$this->data['MuzFormFieldSetting']['sub_title'];
		$datas['sub_title']=trim($datas['sub_title']);
		if(empty($datas['sub_title'])) unset($datas['sub_title']);
		
		# text,textarea
		$detail_datas=array();
		if(in_array($this->res['type'],array(Text::NAME,Textarea::NAME))){
			$this->res['validate_type']=$detail_datas['validate_type']=$this->data['MuzFormFieldSettingDetail']['validate_type'];
			$this->res['max_num']=$detail_datas['max_num']=$this->data['MuzFormFieldSettingDetail']['max_num'];
			
			# 未設定は消す
			if(empty($detail_datas['validate_type']) OR $this->_selectIsNone($detail_datas['validate_type'])){
				unset($detail_datas['validate_type']);
			}
			
			if($this->_isSaveMaxNum($this->res['type'],$this->res['max_num'])){
				$detail_datas['max_num']=$this->res['max_num'];
			}
		}
		
		# begin
		$datasource=ClassRegistry::init("MuzPreviewFormFieldSetting")->getDataSource();
		$datasource->begin();
		
		# field_settings
		$field_save['MuzPreviewFormFieldSetting']=$datas;
		ClassRegistry::init("MuzPreviewFormFieldSetting")->create();
		if(!$save_field_settins=ClassRegistry::init("MuzPreviewFormFieldSetting")->save($field_save)){
			$datasource->rollback();
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response($this->res);
		}
		
		$last_field_id=ClassRegistry::init("MuzPreviewFormFieldSetting")->getLastInsertID();
		$this->res['field_id']=$last_field_id;
		
		# 空白はnone
		# field_details
		$detail_datas['form_id']=$this->res['form_id'];
		$detail_datas['field_id']=$last_field_id;
		if(!ClassRegistry::init("MuzPreviewFormFieldSettingDetail")->save($detail_datas)){
			$datasource->rollback();
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response($this->res);
		}
		
		# 選択肢
		if(in_array($this->res['type'],array(Select::NAME,Checkbox::NAME,Radio::NAME))){
			$this->_valuesSave($last_field_id);
		}
		
		$datasource->commit();
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->res['sort_number']=$save_field_settins['MuzPreviewFormFieldSetting']['sort_number'];
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■選択肢
	# @author Kiyosawa 
	# @date 
	function _valuesSave($field_id){
		
		# 選択肢
		try{ $values=$this->data['MuzFormValueSetting']['value'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 必須
		if(empty($values)){
			$datasource->rollback();
			$this->AjaxData->setError(8,__LINE__);
			$this->AjaxData->response($this->res);
			return;
		}
		
		$values=array_map('trim',$values);
		foreach($values as $k=>$value){
			$value_save[$k]['form_id']=$this->res['form_id'];
			$value_save[$k]['field_id']=$field_id;
			$value_save[$k]['value']=$value;
			$this->res["value{$k}"]=$value;
		}
		ClassRegistry::init("MuzPreviewFormValueSetting")->multiInsertForSqlServer($value_save);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function fieldEdit(){
			
		# 普通に保存
		$field_id=130;
		$title='aiueo';
		$view_flg=0;
		$required_flg=1;
		$sub_title='subtitle';
		
		# 入力必須
		$field_edit_datas['id']=$field_id;
		$field_edit_datas['title']=$title;
		$field_edit_datas['view_flg']=$view_flg;
		$field_edit_datas['required_flg']=$required_flg;
		
		# 空
		$field_edit_datas=$this->AjaxData->trim($field_edit_datas);
		$this->AjaxData->isEmptyAfterResponseExec($field_edit_datas);
		
		if(!$field_data=ClassRegistry::init("MuzPreviewFormFieldSetting")->findById($field_id)){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		# 必須ではない
		$sub_title=trim($sub_title);
		if(!empty($sub_title)){
			$field_edit_datas['sub_title']=$sub_title;
		}
		
		# begin
		$datasource=ClassRegistry::init("MuzFormFieldSetting")->getDataSource();
		$datasource->begin();
		
		$this->fieldEditSave($field_edit_datas);
		
		$isPreset=$this->_isPresetByFieldType($field_data['MuzPreviewFormFieldSetting']['type']);
		$field_type=$this->_getFieldType($field_data['MuzPreviewFormFieldSetting']['type']);
		$this->_classLoad();
		
		#入力制限と最大文字数
		#muz_preview_form_field_setting_details
		if(!$isPreset AND in_array($field_type,array(Text::NAME,Textarea::NAME))){
			
			$validate_type='validate_number';
			$max_num=50;
			
			# textarea,textの入力関連のみ(通常フィールド)
			$field_setting_detail_edit['field_id']=$field_id;
			$field_setting_detail_edit['validate_type']=$validate_type;
			$field_setting_detail_edit['max_num']=$max_num;
			$this->fieldSetttingDetailEdit($field_setting_detail_edit);
		}
		
		# 選択肢(増える可能性ある)
		# muz_preview_form_values
		if(!$isPreset AND !in_array($field_type,array(Text::NAME,Textarea::NAME))){
			
			# select,radio,checkboxのみ(通常フィールド)
			$field_values['value0']='sel1';
			$field_values['value1']='sel2';
			$field_values['value2']='sel3';
			
			$field_values=array_remove($field_values,'');
			$field_values=$this->AjaxData->trim($field_values);
			$this->fieldEditValuesSave($field_data['MuzPreviewFormFieldSetting']['form_id'],$field_id,$field_values);
		}
		
		$datasource->commit();
		$this->AjaxData->successResponse();
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function _getSortNum($sort_number_strings,$field_id){
		
		$sort_ary=explode("_",$sort_number_strings);
		if(!in_array($field_id,$sort_ary)) return 1;
		$index=array_search($field_id,$sort_ary);
		$index++;
		return $index;
	}
	
	# ■ドラッグが終了した時
	# @author Kiyosawa 
	# @date 
	function dragSort(){
		
		# 368(46)をgroup_id=45に移動する
		
		#$group_sort_num=3;
		
		# 移動対象のフィールドID
		$field_id=368;
		$form_id=27;
		
		# field_sort_num
		# 1_2_3_4 IDの並び順でPOSTされてくる
		$field_sort_num='365_367_369_371_368_373_375';
		$field_sort_num=$this->_getSortNum($field_sort_num,$field_id);
		
		# 移動先GROUPID
		$group_id=45;
		
		# 未使用にドラッグする場合もある
		$use_flg=1;
		
		#$datas['group_sort_num']=$group_sort_num;
		$datas['field_sort_num']=$field_sort_num;
		$datas['field_id']=$field_id;
		$datas['form_id']=$form_id;
		$datas['group_id']=$group_id;
		$datas['use_flg']=$use_flg;
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		# 保存前のフィールド
		ClassRegistry::init("MuzPreviewFormFieldSetting")->unbindFully();
		$before_save_field=ClassRegistry::init("MuzPreviewFormFieldSetting")->findById($field_id);
		
		# グループを移動したか
		$isGroupMove=($before_save_field['MuzPreviewFormFieldSetting']['group_id']!=$group_id);
		
		# 遷移先のグループのフィールド(同じグループの可能性あり)
		ClassRegistry::init("MuzPreviewFormFieldSetting")->unbindFully();
		$fields=ClassRegistry::init("MuzPreviewFormFieldSetting")->getUseFieldsByGroup($group_id);
		foreach($fields as $k=>$v){
			unset($fields[$k]);
			$fields[$v['MuzPreviewFormFieldSetting']['id']]=$v['MuzPreviewFormFieldSetting'];
		}
		
		# グループを移動しそのグループにフィールドを埋め込んだ
		if($isGroupMove and !isset($fields[$before_save_field['MuzPreviewFormFieldSetting']['id']])){
			$sort_ary=Set::combine($fields,"{}.id","{}.sort_number");
			$this->_fieldSortUpdateMoveGroup($sort_ary,$field_id,$field_sort_num,$group_id);
		}
		
		# グループ移動していないがフィールドを並び替えた
		if(!$isGroupMove and isset($fields[$before_save_field['MuzPreviewFormFieldSetting']['id']])){
			$sort_ary=Set::combine($fields,"{}.id","{}.sort_number");
			$this->_fieldSortUpdateNoMoveGroup($sort_ary,$field_id,$field_sort_num);
		}
		
		$this->AjaxData->successResponse();
	}
	
	
	# ■グループの並び替え実行時
	# ■▼▲を押したとき
	# ■使用、未使用の処理はここではない
	# @author Kiyosawa 
	# @date 
	function groupSort(){
		
		//------------------
		$form_id=27;
		$group_sort_number='45_46';
		$group_id=45;
		//------------------
		
		$group_sort_number=$this->_getSortNum($group_sort_number,$group_id);
		
		$datas['form_id']=$form_id;
		$datas['sort_number']=$group_sort_number;
		$datas['id']=$group_id;
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		# な、訳ない
		if(!$groups=ClassRegistry::init("MuzPreviewFormGroupSetting")->findAllByFormId($form_id)){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		# 更新処理
		$group_sort=Set::combine($groups,"{}.MuzPreviewFormGroupSetting.id","{}.MuzPreviewFormGroupSetting.sort_number");
		$this->_groupSortUpdate($group_sort,$group_id,$group_sort_number);
		
		$this->AjaxData->successResponse();
	}
	
	
	# ■グループの並び替えの移動の保存処理
	# @author Kiyosawa 
	# @date 
	function _groupSortUpdate($group_sort=array(),$group_id,$group_sort_number){
		
		$group_sort=$this->FieldSort->sortExec($group_sort,$group_id,$group_sort_number);
		
		$counter=0;
		$update=array();
		foreach($group_sort as $k=>$v){
			$update_group[$counter]['id']=$k;
			$update_group[$counter++]['sort_number']=$v;
		}
		
		#update
		ClassRegistry::init("MuzPreviewFormGroupSetting")->multiUpdateBySqlServerPrimaryKeyUpdate($update_group);
	}
	
	# ■フィールドの並び替え(グループ移動時)
	# @author Kiyosawa 
	# @date 
	function _fieldSortUpdateMoveGroup($sort_ary=array(),$field_id,$field_sort_num,$group_id){
		
		$sort_ary=$this->FieldSort->sortExec($sort_ary,$field_id,$field_sort_num);
		
		$update_group=array();
		$counter=0;
		foreach($sort_ary as $k=>$v){
			$update_group[$counter]['id']=$k;
			$update_group[$counter]['sort_number']=$v;
			$update_group[$counter++]['group_id']=$group_id;
		}
		
		#update
		ClassRegistry::init("MuzPreviewFormFieldSetting")->multiUpdateBySqlServerPrimaryKeyUpdate($update_group);
	}
	
	# ■フィールドの並び替え(グループ未移動時)
	# @author Kiyosawa 
	# @date 
	function _fieldSortUpdateNoMoveGroup($sort_ary=array(),$field_id,$field_sort_num){
		
		$sort_ary=$this->FieldSort->sortExec($sort_ary,$field_id,$field_sort_num);
		$counter=0;
		foreach($sort_ary as $k=>$v){
			$update_group[$counter]['id']=$k;
			$update_group[$counter++]['sort_number']=$v;
		}
		
		#update
		ClassRegistry::init("MuzPreviewFormFieldSetting")->multiUpdateBySqlServerPrimaryKeyUpdate($update_group);
	}
	
	
	# ■フィールドの削除
	# @author Kiyosawa 
	# @date 
	function fieldRemove(){
		
		$field_id=4;
		
		$datas['id']=$field_id;
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		$datas['del_flg']=1;
		
		$save['MuzPreviewFormFieldSetting']=$datas;
		if(!ClassRegistry::init("MuzPreviewFormGroupSetting")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->AjaxData->successResponse();
	}
	
	# ■validate_type を設定しないのか
	# @author Kiyosawa 
	# @date 
	function _selectIsNone($validate_type){
		
		$validate_type_tsv=tsv('validate_type.tsv');
		if($validate_type==current(array_keys($validate_type_tsv))){
			return true;
		}
		return false;
	}
	
	# ■最大文字数を設定すべきか
	# @author Kiyosawa 
	# @date 
	function _isSaveMaxNum($type,$max_num){
		
		if(!empty($max_num) AND in_array($type,array(Text::NAME,Textarea::NAME))){
			return true;
		}
		return false;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _replaceFieldType($type){
		return sprintf("normal_%s",$type);
	}
	
}