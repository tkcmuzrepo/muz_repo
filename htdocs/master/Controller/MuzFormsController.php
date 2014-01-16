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

App::uses('AppController', 'Controller');

class MuzFormsController extends AppController{
	
	public $components=array('Session');
	public $name = 'MuzForms';
	public $uses = array();
	public $helpers=array('Muzform');
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(empty($this->login_user)){
			$this->redirect("/muz_logins");
		}
	}
	
	# ■フォーム管理(C-1)
	function index(){
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function lists(){
		
		# フォーム一覧
		$forms=ClassRegistry::init("MuzForm")->findAllByClientID($this->login_user['MuzMasterAccount']['client_id']);
		
		# 使用済み、未使用振り分け
		$form_list=array();
		foreach($forms as $k=>$v){
			$form_list[$v['MuzForm']['view_flg']][]=$v['MuzForm'];
		}
		$this->set(compact('form_list'));
	}
	
	# ■フォーム作成(C-2)
	# ■フォーム作成と同時にプリセットをコピーする様にする
	# ■フォーム作成後C-1へ
	# @author Kiyosawa 
	# @date 
	function action(){
		
		# client
		$client=ClassRegistry::init("MuzClient")->findById($this->login_user['MuzMasterAccount']['client_id']);
		$this->set(compact('client'));
		
		if(!$this->data){
			return;
		}
		
		$form_setting=array_map('trim',$this->data['MuzFormSetting']);
		$group_title=trim($this->data['MuzFormGroupSetting']['group_title']);
		if(empty($form_setting['title']) OR empty($form_setting['hash']) OR empty($group_title)){
			return;
		}
		
		# 保存処理
		$datasource=ClassRegistry::init("MuzFormFieldSetting")->getDataSource();
		$datasource->begin();
			
		# フォームの保存
		if(!$form_res=$this->_formInsert($form_setting['title'],$form_setting['hash'])){
			$datasource->rollback();
			return;
		}
		
		# グループの保存
		if(!$group_res=$this->_groupInsert($form_res['MuzForm']['id'],$group_title)){
			$datasource->rollback();
			return;
		}
		
		# プリセットのコピー処理
		$all_presets=ClassRegistry::init("MuzFormPreset")->find('all');
		
		# ループ処理で対応するしかない
		$field_save=array();
		$sql_res_flg=false;
		foreach($all_presets as $k=>$v){
			
			# フィールド情報
			ClassRegistry::init("MuzFormFieldSetting")->create();
			$field_insert['MuzFormFieldSetting']['form_id']=$form_res['MuzForm']['id'];
			$field_insert['MuzFormFieldSetting']['group_id']=$group_res['MuzFormGroupSetting']['id'];
			$field_insert['MuzFormFieldSetting']['title']=$v['MuzFormPreset']['name'];
			$field_insert['MuzFormFieldSetting']['type']=$v['MuzFormPreset']['type'];
			$field_insert['MuzFormFieldSetting']['sort_num']=($k+1);
			if(!$field_res=ClassRegistry::init("MuzFormFieldSetting")->save($field_insert)){
				$sql_res_flg=true;
				break;
			}
			
			# 詳細データ
			# validate_typeはプリセットなので設定する必要はない
			ClassRegistry::init("MuzFormFieldSettingDetail")->create();
			$field_detail_insert['MuzFormFieldSettingDetail']['form_id']=$form_res['MuzForm']['id'];
			$field_detail_insert['MuzFormFieldSettingDetail']['field_id']=$field_res['MuzFormFieldSetting']['id'];
			$field_detail_insert['MuzFormFieldSettingDetail']['box_num']=0;
			$field_detail_insert['MuzFormFieldSettingDetail']['preset_id']=$v['MuzFormPreset']['id'];
			if(!$res=ClassRegistry::init("MuzFormFieldSettingDetail")->save($field_detail_insert)){
				$sql_res_flg=true;
				break;
			}
		}
		
		# 保存エラー有り(後始末)
		if(!empty($sql_res_flg)){
			$datasource->rollback();
			return;
		}
		
		$datasource->commit();
		
		# 保存完了処理
		$this->redirect("./index");
	}

	# ■C-3 フォーム編集
	# ■プリセットはフォーム作成時に自動的にコピーされる様にする
	# ■初期入力文字とバリデーションの仕様が固まっていない
	# @author Kiyosawa 
	# @date 
	function setting($hash=''){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHashAndDelFlg($hash,0)){
			$this->redirect("/muz_homes/");
		}
		
		$form_id=$form['MuzForm']['id'];
		$this->set(compact('form_id'));
		
		# フィールド
		if(!$fields=$this->_getFields($form_id)){
			return;
		}
		
		foreach($fields as $k=>$v){
			
			$field_setting=$v['MuzFormFieldSetting'];
			$field_details=$v['MuzFormFieldSettingDetail'];
			$enable_fields[$field_setting['group_id']][$field_details['id']]=array_merge($field_setting,$field_details);
			$enable_fields[$field_setting['group_id']][$field_details['id']]['values']=$v['MuzFormValueSetting'];
		}
		
		# グループ情報
		$group_ids=array_unique(Set::extract($fields,"{}.MuzFormFieldSetting.group_id"));
		$group_list=$this->_getGroups($group_ids);
		
		# グループに属していないフィールドは「使用可能なフォームへ」
		$enable_use_fields=$enable_no_use_fields=array();
		foreach($group_list as $k=>$v){
			
			$group_id=$v['MuzFormGroupSetting']['id'];
			if(!isset($enable_fields[$group_id])) continue;
			
			$fields=$enable_fields[$group_id];
			unset($enable_fields[$group_id]);
			
			# フィールド処理
			foreach($fields as $_k=>$_v){
				
				# 未使用
				if(empty($_v['use_flg'])){
					$enable_no_use_fields[]=$_v;
					continue;
				}
				
				$enable_use_fields[$group_id][$_v['id']]=$_v;
			}
		}
		
		# グループ未設定のフィールドがある場合
		if(isset($enable_fields[0])){
			$enable_no_use_fields=array_merge($enable_fields[0],$enable_no_use_fields);
		}
		
		$this->set(compact('enable_no_use_fields','enable_use_fields','group_list','hash'));
	}
	
	
	# ■基本設定
	# @author Kiyosawa 
	# @date 
	function basic($hash){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHashAndDelFlg($hash,0)){
			exit;
		}
		
		# html
		$html_settings=ClassRegistry::init("MuzFormHtmlSetting")->findByFormId($form['MuzForm']['id']);
		$this->data['MuzFormHtmlSetting']=$html_settings['MuzFormHtmlSetting'];
		
		# message
		$messages=ClassRegistry::init("MuzFormMessage")->findAllByFormId($form['MuzForm']['id']);
		$this->set(compact('hash','messages','image','form'));
	}
	
	# ■HTMLの情報設定
	# @author Kiyosawa 
	# @date 
	function html($hash){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHash($hash)){
			$this->redirect("/muz_homes/");
		}
		
		# 初期化
		if(!$this->data){
			
			ClassRegistry::init("MuzFormHtmlSetting")->findByFormId($form['MuzForm']['id']);
			ClassRegistry::init("MuzForm")->init_data($this->data);
			ClassRegistry::init("MuzFormHtmlSetting")->init_data($this->data);
			return;
		}
		
		$html_setting=array_map('trim',$this->data['MuzFormHtmlSetting']);
		$view_flgs=$this->data['MuzForm'];
		
		# 保存処理
		$datasource=ClassRegistry::init("MuzForm")->getDataSource();
		$datasource->begin();
		
		$form_edit['MuzForm']=$view_flgs;
		$form_edit['MuzForm']['id']=$form['MuzForm']['id'];
		if(!ClassRegistry::init("MuzForm")->save($form_edit)){
			ClassRegistry::init("MuzForm")->init_data($this->data);
			return;
		}
		
		$html_save['MuzFormHtmlSetting']['form_id']=$form['MuzForm']['id'];
		$html_save['MuzFormHtmlSetting']['before_page_html']=$html_setting['before_page_html'];
		$html_save['MuzFormHtmlSetting']['after_page_html']=$html_setting['after_page_html'];
		if(!ClassRegistry::init("MuzFormHtmlSetting")->save($html_save)){
			$datasource->rollback();
			ClassRegistry::init("MuzForm")->init_data($this->data);
			ClassRegistry::init("MuzFormHtmlSetting")->init_data($this->data);
			return;
		}
		$datasource->commit();
	}
	
	# ■フォーム新規作成
	# ■同名でも一旦許可します
	# @author Kiyosawa 
	# @date 
	function _formInsert($form_title='',$form_hash=''){
		
		$save['MuzForm']['title']=$form_title;
		$save['MuzForm']['hash']=$form_hash;
		$save['MuzForm']['client_id']=$this->login_user['MuzMasterAccount']['client_id'];
		$res=ClassRegistry::init("MuzForm")->save($save);
		return $res;
	}
	
	
	# ■グループの新規作成
	# @author Kiyosawa 
	# @date 
	function _groupInsert($form_id,$group_title=''){
		
		$save['MuzFormGroupSetting']['group_title']=$group_title;
		$save['MuzFormGroupSetting']['form_id']=$form_id;
		$res=ClassRegistry::init("MuzFormGroupSetting")->save($save);
		return $res;
	}
	
	# ■フォームの設定と関連フィールドを削除する
	# @author Kiyosawa 
	# @date 
	function _formRemove($form_id){
		
		$w=array('form_id'=>$form_id);
		ClassRegistry::init("MuzFormFieldSetting")->deleteAll($w);
		ClassRegistry::init("MuzFormFieldSettingDetail")->deleteAll($w);
		
		$w=array('id'=>$form_id);
		ClassRegistry::init("MuzFormSetting")->deleteAll($w);
	}
	
	# ■フィールド取得
	# @author Kiyosawa 
	# @date 
	function _getFields($form_id){
	
		ClassRegistry::init("MuzFormFieldSetting")->order='MuzFormFieldSetting.sort_number ASC';
		$fields=ClassRegistry::init("MuzFormFieldSetting")->getEnableField($form_id);
		return $fields;
	}
	
	# ■プリセット取得
	# @author Kiyosawa 
	# @date 
	function _getPresets($preset_ids=array()){
		
		function not_empty($val){
			
			if(empty($val)) return false;
			return true;
		}
		$preset_ids=array_filter($preset_ids,'not_empty');
		if(empty($preset_ids)) return array();
		$preset_list=ClassRegistry::init("MuzFormPreset")->getEnablePresetListByIds($preset_ids);
		return $preset_list;
	}
	
	# ■グループ一覧
	# @author Kiyosawa 
	# @date 
	function _getGroups($group_ids=array()){
		
		if(empty($group_ids)) return;
		
		ClassRegistry::init("MuzFormGroupSetting")->order='MuzFormGroupSetting.sort_number ASC';
		$group_list=ClassRegistry::init("MuzFormGroupSetting")->getEnableGroupListByIds($group_ids);
		return $group_list;
	}
	
	# ■使用中と、未使用に分ける
	# ■使用中 : user_flg==1
	# ■view_flg は無関係
	# @author Kiyosawa 
	# @date 
	function _separateField($enable_fields=array()){
		
		$res=array();
		foreach($enable_fields as $k=>$v){
			$res[$v['MuzFormFieldSetting']['use_flg']][$v['MuzFormFieldSetting']['id']]=$v;
		}
		return $res;
	}
	
}