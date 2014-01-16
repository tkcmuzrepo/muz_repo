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

class MuzPreviewsController extends AppController{
	
	public $name = 'MuzPreviews';
	public $components=array('AjaxData');
	var $uses = array("MuzMasterAccount");
	
	
	# ■色の変更処理を行う
	# @author Kiyosawa 
	# @date 
	function colorEdit(){
	}
	
	
	# ■フィールドの何控えを行う
	# @author Kiyosawa 
	# @date 
	function fieldSort(){
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		# 送信データ処理
		if(property_exists($this->params,'data')){
			$this->data=&$this->params->data;
		}
		
	}
	
	# ■id が同じテーブル同士での場合
	# @author Kiyosawa 
	# @date 
	function _dataCopyById($id,$fromModel,$toModel,$primary='id'){
		
		# camel
		$ucSpace = ucWords(str_replace('_',' ',$primary));
		$camel_primary_key=str_replace(' ','',$ucSpace);
		
		# 転送元データ
		$fromModel->unbindFully();
		$from=$fromModel->{"findBy{$camel_primary_key}"}($id);
		if(empty($from)) return;
		
		/*
		$primary_key='';
		$toModel->unbindFully();
		if($to=$toModel->{"findBy{$camel_primary_key}"}($id)){
			$primary_key_value=$to[$toModel->name]['id'];
		}
		*/
		
		if(!empty($primary)){
			$toModel->primaryKey=$primary;
		}
		
		//v($toModel->primaryKey);
		
		foreach($from[$fromModel->name] as $k=>$v){
			
			if($k=='id' AND $toModel->primaryKey!='id') continue;
			
			/*
			if(!empty($primary_key_value) AND $k=='id'){
				$insert[$toModel->name][$k]=$primary_key_value;
				continue;
			}
			*/
			$insert[$toModel->name][$k]=$v;
		}
		
		$toModel->unbindFully();
		$res=$toModel->save($insert);
		return $res;
	}
	
	# ■プレビューを実行するか
	# ■date_key : date('YmdHis') で生成している値
	# ■同じ値があればそのページでは保存している事になる
	# ■リロードすればその都度変更される
	# @author Kiyosawa 
	# @date 
	function _isPreviewExec($form_id='',$date_key=''){
		
		$form_id=(!empty($form_id))?$form_id:Configure::read('form_id');
		$date_key=(!empty($date_key))?$date_key:Configure::read('date_key');
		if($res=ClassRegistry::init("MuzPreviewForm")->findByIdAndDateKey($form_id,$date_key)){
			return false;
		}
		return true;
	}
	
	# ■muz_forms
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormCopy($form_id,$status='copy'){
		
		$models[0]=ClassRegistry::init("MuzForm");
		$models[1]=ClassRegistry::init("MuzPreviewForm");
		if($status=='restore'){
			$models=array_reverse($models);
		}
		$this->_dataCopyById($form_id,$models[0],$models[1]);
	}
	
	# ■muz_form_color_settings
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormColorSettingCopy($form_id,$status='copy'){
		
		$models[0]=ClassRegistry::init("MuzFormColorSetting");
		$models[1]=ClassRegistry::init("MuzPreviewFormColorSetting");
		if($status=='restore'){
			$models=array_reverse($models);
		}
		$this->_dataCopyById($form_id,$models[0],$models[1],'form_id');
		return;
	}
	
	# ■muz_form_html_settings
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormHtmlSettingCopy($form_id,$status='copy'){
		
		$models[0]=ClassRegistry::init("MuzFormHtmlSetting");
		$models[1]=ClassRegistry::init("MuzPreviewFormHtmlSetting");
		if($status=='restore'){
			$models=array_reverse($models);
		}
		$this->_dataCopyById($form_id,$models[0],$models[1],'form_id');
		return;
	}
	
	# ■muz_form_image_setting
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormImageSettingCopy($form_id,$status='copy'){
		
		$models[0]=ClassRegistry::init("MuzFormImage");
		$models[1]=ClassRegistry::init("MuzPreviewFormImage");
		if($status=='restore'){
			$models=array_reverse($models);
		}
		$this->_dataCopyById($form_id,$models[0],$models[1],'form_id');
		return;
	}
	
	# ■muz_form_field_settings
	# ■一気に消して一気に入れる
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormFieldSettingCopy($form_id,$status='copy'){
		
		$update_flg=false;
		$models[0]=ClassRegistry::init("MuzFormFieldSetting");
		$models[1]=ClassRegistry::init("MuzPreviewFormFieldSetting");
		
		if($status=='restore'){
			$models=array_reverse($models);
			$update_flg=true;
		}
		$this->_dataCopyMultiData($form_id,$models[0],$models[1],$update_flg);
		return;
	}

	# ■muz_form_field_setting_details
	# ■一気に消して一気に入れる
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormFieldSettingDetailCopy($form_id,$status='copy'){
		
		$update_flg=false;
		
		$models[0]=ClassRegistry::init("MuzFormFieldSettingDetail");
		$models[1]=ClassRegistry::init("MuzPreviewFormFieldSettingDetail");
		if($status=='restore'){
			$models=array_reverse($models);
			$update_flg=true;
		}
		$this->_dataCopyMultiData($form_id,$models[0],$models[1],$update_flg);
		return;
	}

	# ■muz_form_value_settings
	# ■一気に消して一気に入れる
	# ■こいつの主キーは誰からも参照されていないので全部消して一気に挿入
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormValueSettingCopy($form_id,$status='copy'){
		
		$update_flg=false;
		$models[0]=ClassRegistry::init("MuzFormValueSetting");
		$models[1]=ClassRegistry::init("MuzPreviewFormValueSetting");
		if($status=='restore'){
			$models=array_reverse($models);
			$update_flg=true;
		}
		$this->_dataCopyMultiData($form_id,$models[0],$models[1],$update_flg);
		return;
		
		# これを使ってた意図を忘れた
		#$this->_dataCopyAllDeleteAfterAllInsert($form_id,'form_id',$models[0],$models[1],$update_flg);
		return;
	}
	
	# ■muz_form_field_settings
	# ■IDが変わらない
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormGroupSettingCopy($form_id,$status='copy'){
		
		$update_flg=false;
		$models[0]=ClassRegistry::init("MuzFormGroupSetting");
		$models[1]=ClassRegistry::init("MuzPreviewFormGroupSetting");
		if($status=='restore'){
			$models=array_reverse($models);
			$update_flg=true;
		}
		$this->_dataCopyMultiData($form_id,$models[0],$models[1],$update_flg);
		return;
	}
	
	# ■注意文
	# @author Kiyosawa 
	# @date 
	function _previewMuzFormMessageCopy($form_id,$status='copy'){
		
		$update_flg=false;
		$models[0]=ClassRegistry::init("MuzFormMessage");
		$models[1]=ClassRegistry::init("MuzPreviewFormMessage");
		if($status=='restore'){
			$models=array_reverse($models);
			$update_flg=true;
		}
//		v($models);
		$this->_dataCopyMultiData($form_id,$models[0],$models[1],$update_flg);
		return;
	}
	
	# ■コピー
	# @author Kiyosawa 
	# @date 
	function _dataCopy($data,$modelObj,$primary_key=''){
		
		foreach($data as $k=>$v){
			
			if(!empty($primary_key) AND $k=='id'){
				$insert[$modelObj->name][$k]=$primary_key;
				continue;
			}
			$insert[$modelObj->name][$k]=$v;
		}
		
		$modelObj->create();
		return $modelObj->save($insert);
	}
	
	# ■
	# @author Kiyosawa 
	# @date 
	function _dataCopyAllDeleteAfterAllInsert($id,$field,$fromModel,$toModel,$update_flg=false){
		
		if(empty($update_flg)){
			$this->_dataCopyMultiData($id,$fromModel,$toModel);
			return;
		}
		
		# 移行データ無し
		$ucSpace = ucWords(str_replace('_',' ',$field));
		$camel=str_replace(' ','',$ucSpace);
		$fromModel->unbindFully();
		if(!$from=$fromModel->{"findAllBy{$camel}"}($id)){
			return;
		}
		
		# 一気消し
		$w=null;
		$w[$field]=$id;
		$toModel->deleteAll($w,false);
		
		$insert=array();
		$counter=0;
		foreach($from as $k=>$v){
			foreach($v[$fromModel->name] as $_k=>$_v){
				if($toModel->primaryKey==$_k) continue;
				$insert[$counter][$_k]=$_v;
			}
			$counter++;
		}
		try{
			$toModel->multiInsertForSqlServer($insert);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	# ■date_keyより新しくcreatedが設定されているデータは新規追加である
	# @author Kiyosawa 
	# @date 
	function _dataCopyMultiDataUpdate($form_id,$fromModel,$toModel){
		
		# 転送元
		$fromModel->unbindFully();
		$fields=$fromModel->findAllByFormId($form_id);
		
		# 挿入先のID確認用
		$to_fields=$toModel->findAllByFormId($form_id,array('id'));
		$to_field_ids=Set::extract($to_fields,"{}.{$toModel->name}.id");
		
		if(empty($fields)) return;
		
		$insert=$update=array();
		$insert_counter=$update_counter=0;
		foreach($fields as $k=>$v){
			
			$insert_flg=$update_flg=false;
			$created=date('YmdHis',strtotime($v[$fromModel->name]['created']));
			$isInsert=($created>=Configure::read('date_key'));
			
			# ID挿入済み(2回連続とか)
			if($isInsert AND !empty($to_field_ids) AND in_array($v[$fromModel->name]['id'],$to_field_ids)) continue;
			
			foreach($v[$fromModel->name] as $_k=>$_v){
				
				# 新規追加した
				if($isInsert){
					$insert[$insert_counter][$_k]=$_v;
					$insert_flg=true;
					continue;
				}
				$update[$update_counter][$_k]=$_v;
				$update_flg=true;
			}
			
			if($update_flg)$update_counter++;
			if($insert_flg)$insert_counter++;
		}
		
		# 新規追加してたら
		# 2連続実行すると同じIDにインサートするのでエラーになる
		if(!empty($insert)){
			
			try{ $toModel->multiInsertForSqlServer($insert,true);
			}catch(Exception $e){
				throw new Exception($e->getMessage());
			}
		}
		
		if(!empty($update)){
			
			try{ $toModel->multiUpdateBySqlServerPrimaryKeyUpdate($update);
			}catch(Exception $e){
				throw new Exception($e->getMessage());
			}
		}
		return true;
	}
	
	# ■
	# @author Kiyosawa 
	# @date 
	function _dataCopyMultiData($form_id,$fromModel,$toModel,$update_flg=false){
		
		if(!empty($update_flg)){
			$this->_dataCopyMultiDataUpdate($form_id,$fromModel,$toModel);
			return;
		}
		
		# delete
		$w['form_id']=$form_id;
		
		$toModel->unbindFully();
		$toModel->deleteAll($w,false);
		
		$fromModel->unbindFully();
		$fields=$fromModel->findAllByFormId($form_id);
		
		if(empty($fields)) return;
		
		# insert
		$insert=array();
		$counter=0;
		foreach($fields as $k=>$v){
			foreach($v[$fromModel->name] as $_k=>$_v){
				$insert[$counter][$_k]=$_v;
			}
			$counter++;
		}
		if(empty($insert)) return;
		
		# IDは同じ値のはず
		try{$toModel->multiInsertForSqlServer($insert,true);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	# ■プレビューへ
	# ■余裕があったら分解して...
	# @author Kiyosawa
	# @date
	function _previewCopy(){
		
		$form_id=Configure::read('form_id');
		
		# muz_forms
		$this->_previewMuzFormCopy($form_id);
		
		# muz_form_field_settings
		$this->_previewMuzFormFieldSettingCopy($form_id);
		
		# muz_form_field_setting_details
		$this->_previewMuzFormFieldSettingDetailCopy($form_id);
		
		# muz_form_group_settings
		$this->_previewMuzFormGroupSettingCopy($form_id);
		
		# muz_form_color_settings
		$this->_previewMuzFormColorSettingCopy($form_id);
		
		# muz_form_html_settings
		$this->_previewMuzFormHtmlSettingCopy($form_id);
		
		# muz_form_image_settings
		$this->_previewMuzFormImageSettingCopy($form_id);
		
		# muz_form_messages
		$this->_previewMuzFormMessageCopy($form_id);
		
		# muz_form_value_settings
		$this->_previewMuzFormValueSettingCopy($form_id);
	}
	
	# ■本番へ	
	# @author Kiyosawa 
	# @date 
	function _restoreData(){
		
		$status='restore';
		
		$form_id=Configure::read('form_id');
		
		$datasource=ClassRegistry::init("MuzForm")->getDataSource();
		$datasource->begin();
		
		# muz_forms
		$this->_previewMuzFormCopy($form_id,'restore');
		
		# muz_form_field_settings
		$this->_previewMuzFormFieldSettingCopy($form_id,$status);
		
		# muz_form_field_settings
		$this->_previewMuzFormFieldSettingDetailCopy($form_id,$status);
		
		# muz_form_group_settings
		$this->_previewMuzFormGroupSettingCopy($form_id,$status);
		
		# muz_form_color_settings
		$this->_previewMuzFormColorSettingCopy($form_id,$status);
		
		# muz_form_html_settings
		$this->_previewMuzFormHtmlSettingCopy($form_id,$status);
		
		# muz_form_image_settings
		$this->_previewMuzFormImageSettingCopy($form_id,$status);
		
		# muz_form_image_settings
		$this->_previewMuzFormMessageCopy($form_id,$status);
		
		# muz_form_value_settings
		$this->_previewMuzFormValueSettingCopy($form_id,$status);
		
		$datasource->commit();
	}
	
	# ■画像プレビュー(同期)
	# @author Kiyosawa 
	# @date 
	function imagePreview($form_id,$date_key){
		
		# 保存済み
		if(!$this->_isPreviewExec($form_id,$date_key)){
			return true;
		}
		
		$this->AjaxData->previewDataCopyExec($form_id,$date_key);
		return true;
	}
	
	# ■本番側への戻し
	# @author Kiyosawa 
	# @date 
	function restore_exec($form_id='',$date_key=''){
		
		$date_key='20140116114818';
		$form_id=27;
		
		if(empty($form_id) OR empty($date_key)) return false;
		
		Configure::write('date_key',$date_key);
		Configure::write('form_id',$form_id);
		
		# 既に対象のkeyで保存処理がされている
		if($this->_isPreviewExec()) return false;
		
		$this->_restoreData();
		return true;
	}
	
	# ■ プレビュー用のDBへ移行
	# @author Kiyosawa 
	# @date 
	function preview_exec($form_id='',$date_key=''){

		Configure::write('date_key',$date_key);
		Configure::write('form_id',$form_id);
		
		if(empty($form_id) OR empty($date_key)) return false;
		
		# 既に対象のkeyで保存処理がされている
		if(!$this->_isPreviewExec()) return false;
		
		$this->_previewCopy();
		$this->_dateKeySave($form_id,$date_key);
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _dateKeySave($form_id,$date_key){
		
		# date_key save
		$date_key_save['MuzPreviewForm']['date_key']=$date_key;
		$date_key_save['MuzPreviewForm']['id']=$form_id;
		return ClassRegistry::init("MuzPreviewForm")->save($date_key_save);
	}
	
	# ■ログイン
	# ■ログイン後履歴を記録する
	function index(){
		
		$this->_previewExec();
	}
	
	# ■リストア
	# @author Kiyosawa 
	# @date 
	function restore($hash,$date_key){
		
		$datas['hash']=$hash;
		$datas['date_key']=$date_key;
		
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHashAndDelFlg($hash,0)){
			$this->AjaxData->setError(2,__LINE__);
			$this->AjaxData->response();
		}
		
		# 実行
		if(!$this->restore_exec($form['MuzForm']['id'],$date_key)){
			$this->AjaxData->setError(1,__LINE__);
			$this->AjaxData->response();
		}
		
		$res['redirect_url']=MASTER_DOMAIN.'muz_forms'.'/'."setting".'/'.$hash;
		$this->AjaxData->successResponse($res);
	}
	
	# ■プレビュー blankで表示する
	# @author Kiyosawa 
	# @date 
	function preview($hash,$dateKey){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHash($hash)){
			die(__LINE__);
		}
		
		# ここどうするか(ログインしないと見れない)
		if($form['MuzForm']['client_id']!=$this->login_user['MuzMasterAccount']['id']){
			die(__LINE__);
		}
		
		# DB同期
		$this->AjaxData->previewDataCopyExec($form['MuzForm']['id'],$dateKey);
		
		# リダイレクト
		$redirectURL=PC_DOMAIN."main"."/"."index"."/".$hash."/".$dateKey;
		$this->redirect($redirectURL);
	}
	
}