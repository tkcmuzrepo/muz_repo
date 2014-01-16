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
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

/*

*/

/*
$w=new WinBlobStorage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
$body='preset_text_nameさん

ミュゼプラチナム採用事務局です。

この度はミュゼプラチナムにご応募いただきまして、ありがとうございます！

次選考のご案内もメールにてお送りしますのでもうしばらくお待ちください♪';

v($w->blob_get_contents('mailtpl','body.txt'));
$w->blob_put_contents('mailtpl','body.txt',$body,false);
exit;
*/

 
require_once("form_base".DS."text.php");
require_once("form_base".DS."select.php");
require_once("form_base".DS."checkbox.php");
require_once("form_base".DS."radio.php");
require_once("form_base".DS."textarea.php");

class TopMainController extends AppController {

	public $components=array('Session','Cookie','FieldData');
	public $helpers=array('FieldData');
	public $name = 'Main';
	public $uses = array();
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		/*
		v(class_exists('Collator'),1);
		echo phpinfo();
		exit;
		*/
		
		# basic認証(本番外す)
		basic_auth(MASTER_BASIC_ID,MASTER_BASIC_PASS);
		
		if($this->params['action']=='index' AND $this->Session->read('user_id')){
			$this->_clearSession();
		}
		
	}
	
	
	# ■画像のパスを設定
	# @author Kiyosawa 
	# @date 
	function _setImgPath($form_id){
		
		$modelName=$this->FieldData->getModelName('MuzFormImage');
		$header_img=ClassRegistry::init($modelName)->findByFormId($form_id);
		$header_img_url='';
		if(isset($header_img[$modelName])){
			$header_img_url=STORAGE_BLOB_URL.HEADER_IMG_BLOB."/".$header_img[$modelName]['image_path'];
		}
		$this->set(compact('header_img_url'));
	}
	
	# valid_number : 数値のみ
	# valid_alpha  : アルファベットのみ
	# valid_required : 必須
	# $hash='preset'; # プリセット
	# $hash='normal'; # 通常
	function index($hash='preset',$dateKey=''){
		
		# プレビュー確認
		$this->setPreview($hash,$dateKey);
		
		if(!$form=$this->FieldData->getUseFormData($hash)){
			exit;
		}
		
		# 画像設定
		$this->_setImgPath($form[$this->FieldData->getModelName('MuzForm')]['id']);
		
		# ETAG
		$this->setEtag($hash);
		
		# 使用Field
		if(!$fields=$this->FieldData->getUseFields()){
			exit;
		}
		
		# data
		$this->_saveAccessData();
		
		# 文字色
		$this->_setHtmlColor($form[$this->FieldData->getModelName('MuzForm')]['id']);
		
		# 注意書き
		$this->_setNote($form[$this->FieldData->getModelName('MuzForm')]['id']);
		
		if(isset($this->data["Form{$form[$this->FieldData->getModelName('MuzForm')]['id']}"])){
			
			if($this->_isConfirm()){
				
				$this->_setConfirmViewDatas();
				$this->render('confirm');
				return;
			}
		}
		
		# [Group][Field]
		$groups=$this->_viewGroups();
		$this->set(compact('groups','hash','dateKey','form'));
	}
	
	# ■フォームの各色設定
	# @author Kiyosawa 
	# @date 
	function _setHtmlColor($form_id){
		
		$html_color=array();
		$html_color=ClassRegistry::init($this->FieldData->getModelName('MuzFormColorSetting'))->findByFormId($form_id);
		if(isset($html_color[$this->FieldData->getModelName('MuzFormColorSetting')])){
			$html_color=$html_color[$this->FieldData->getModelName('MuzFormColorSetting')];
		}
		$this->set(compact('html_color'));
		return $html_color;
	}
	
	# ■注意書き
	# @author Kiyosawa 
	# @date 
	function _setNote($form_id){
		
		$modelName=$this->FieldData->getModelName('MuzFormMessage');
		
		$view_messages=array();
		if($messages=ClassRegistry::init($modelName)->findAllByFormIdAndViewFlgAndDelFlg($form_id,1,0)){
			$view_messages=Set::combine($messages,"{n}.{$modelName}.id","{n}.{$modelName}.message");
		}
		$this->set(compact('view_messages'));
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _saveRegistPostLog($log){
		
		if(!(Configure::read('BLOB_LOG') instanceof BlobLog)) return;
		
		if($GLOBALS['isLocal']){
			$savepath=USER_DATA.USER_REGIST_BLOB.DS.date("Y_m_d").".txt";
			file_put_contents($savepath,$log);
			return;
		}
		
		try{
			Configure::read('BLOB_LOG')->isRemove=true;
			Configure::read('BLOB_LOG')->rotate=7;
			Configure::read('BLOB_LOG')->saveLog($log,USER_REGIST_BLOB,'',true);
		}catch(Exception $e){
			return;
		}
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function done($hash='',$dateKey=''){
		
		# プレビュー確認
		$this->setPreview($hash,$dateKey);
		
		if(!$form=$this->FieldData->getUseFormData($hash) OR !isset($this->data['Field']) OR $user_id=$this->Session->read('user_id')){
			$this->render('notfound');
			return;
		}
		
		$postData=$this->data['Field'];
		
		# 送信データ記録
		$regist_log=sprintf("【%s】%s\n\n",date('H:i:s'),print_r($postData,1));
		$this->_saveRegistPostLog($regist_log);
		
		# 会員情報保存
		$form=$this->FieldData->getUseFormData($hash);
		if(!$this->_userDataSave($form[$this->FieldData->getModelName('MuzForm')]['id'],$form[$this->FieldData->getModelName('MuzForm')]['client_id'])){
			echo __LINE__;
			exit;
		}
		
		# 入力内容
		$insert_user_data=array();
		$insert_count=0;
		foreach($postData as $field_id=>$value){
			
			$insert_user_data[$insert_count]['form_id']=$form[$this->FieldData->getModelName('MuzForm')]['id'];
			$insert_user_data[$insert_count]['user_id']=Configure::read('last_user_id');
			$insert_user_data[$insert_count]['field_id']=$field_id;
			$insert_user_data[$insert_count]['value']=$value;
			$insert_count++;
		}
		
		ClassRegistry::init($this->FieldData->getModelName('MuzUserRegistData'))->multiInsertForSqlServer($insert_user_data);
		$insert_data=ClassRegistry::init($this->FieldData->getModelName('MuzUserRegistData'))->findAllByUserId(Configure::read('last_user_id'));
		
		if(count($insert_data)!=$insert_count){
			
			# 消す(トランザクション出来ん)
			$w=array('id'=>Configure::read('last_user_id'));
			ClassRegistry::init($this->FieldData->getModelName('MuzUser'))->deleteAll($w,false);
			die(__LINE__);
		}
		
		# メール送信処理
		$change_codes=$this->_getRegistDataByType($insert_data);
		$this->_sendGridMail($change_codes['preset_text_email'],$change_codes);
		
		$this->Session->write('user_id',Configure::read('last_user_id'));
		$this->redirect("/main/regist_done/{$hash}/{$dateKey}");
	}
	
	# ■登録完了
	# @author Kiyosawa 
	# @date 
	function regist_done($hash,$date_key=''){
		
		# プレビュー確認
		$this->setPreview($hash,$date_key);
		
		# ETAG
		$this->setEtag($hash);
		
		$modelName=$this->FieldData->getModelName('MuzForm');
		if(!$form=ClassRegistry::init($modelName)->findByHash($hash)){
			exit;
		}
		
		# 画像設定
		$this->_setImgPath($form[$modelName]['id']);
		
		# 文字色
		$this->_setHtmlColor($form[$modelName]['id']);
		
		# 登録後HTML
		$modelNameHtml=$this->FieldData->getModelName('MuzFormHtmlSetting');
		$html_setting=ClassRegistry::init($modelNameHtml)->findByFormId($form[$modelName]['id']);
		$after_html=trim($html_setting[$modelNameHtml]['after_page_html']);
		$this->set(compact('after_html'));
	}
	
	# ■アクセス出来ないページ用
	# @author Kiyosawa 
	# @date 
	function notfound(){
	}
	
	# ■会員データ保存
	# @author Kiyosawa 
	# @date 
	function _userDataSave($form_id,$client_id){
		
		$user_name=$this->FieldData->getModelName('MuzUser');
		$user_save[$user_name]['form_id']=$form_id;
		$user_save[$user_name]['user_agent']=$_SERVER['HTTP_USER_AGENT'];
		$user_save[$user_name]['client_id']=$client_id;
		if($data_id=$this->Session->read('data_id') AND $access_data=ClassRegistry::init("MuzUserAccessData")->findById($data_id)){
			$user_save[$user_name]['referer']=$access_data['MuzUserAccessData']['referer'];
			$user_save[$user_name]['promotion_id']=$access_data['MuzUserAccessData']['promotion_id'];
		}
		if(!ClassRegistry::init($user_name)->save($user_save)){
			return false;
		}
		$lastUserId=ClassRegistry::init($user_name)->getLastInsertID();
		Configure::write('last_user_id',$lastUserId);
		return true;
	}
	
	# ■アクセス時のデータを保存
	# ■ここの処理に疑問を覚える
	# @author Kiyosawa 
	# @date 
	function _saveAccessData(){
		
		# 保存済み
		if($this->Session->read('data_id')) return;
		
		$access_data_save['MuzUserAccessData']['referer']=$access_data_save['MuzUserAccessData']['promotion_id']='';
		if(isset($_SERVER['HTTP_REFERER'])){
			$access_data_save['MuzUserAccessData']['referer']=$_SERVER['HTTP_REFERER'];
		}
		if(isset($_REQUEST['p']) AND !empty($_REQUEST['p']) AND preg_match("#^[a-zA-Z0-0]+$#",$_REQUEST['p'])){
			
			$promotion_code=$_REQUEST['p'];
			if($promotion_setting=ClassRegistry::init("MuzPromotionSetting")->findByPromotionCodeAndDelFlg($promotion_code,0)){
				$access_data_save['MuzUserAccessData']['promotion_id']=$promotion_setting['MuzPromotionSetting']['id'];
			}
		}
		if(!ClassRegistry::init("MuzUserAccessData")->save($access_data_save)){
			return false;
		}
		$lastID=ClassRegistry::init("MuzUserAccessData")->getLastInsertID();
		$this->Session->write('data_id',$lastID);
	}
	
	# ■■確認画面へのデータ処理
	# @author Kiyosawa 
	# @date 
	function _setConfirmViewDatas(){
		
		$fields=$this->FieldData->getUseFields();
		
		# フォーマット(この情報を元にHTMLを生成する)
		$formats=$this->FieldData->getFieldFormats();
		
		$view_values=array();
		$field_name=$this->FieldData->getModelName("MuzFormFieldSetting");
		$type_formats=Set::combine($fields,"{n}.{$field_name}.id","{n}.{$field_name}.type");
		$field_titles=Set::combine($fields,"{n}.{$field_name}.id","{n}.{$field_name}.title");
		foreach($this->postData as $k=>$v){
			
			if(!is_array($v)) continue;
			
			$field_id=str_replace("Field","",$k);
			
			# 通常のフィールドの場合(checkbox)
			$field_format=$formats['conf'][$type_formats[$field_id]];
			$isCheckbox=(Checkbox::NAME==$this->_getFieldType($type_formats[$field_id]));
			if(!$this->_isPresetByFieldType($type_formats[$field_id]) AND $isCheckbox){
				$field_format=implode(' ',array_pad(array(),count($v),$field_format));
			}
			
			$view_values[$field_id]['view']=$this->_sprintf($field_format,$v);
			$view_values[$field_id]['hidden']=implode(SEPARATOR,$v);
		}
		
		$hash=$this->FieldData->form[$this->FieldData->getModelName('MuzForm')]['hash'];
		$this->set(compact('field_titles','view_values','hash'));
	}
	
	# 入力必須については複数のフィールドすべてを対象とする
	# ■確認画面へ遷移できるか
	# @author Kiyosawa 
	# @date 
	function _isConfirm(){
		
		# 送信データ
		$this->postData=$this->data["Form{$this->FieldData->form[$this->FieldData->getModelName('MuzForm')]['id']}"];
		
		# プリセット情報&整形&SORT
		$all_presets=$this->FieldData->getPresetFieldMergePresetValues(true);
		
		foreach($this->postData as $k=>$v){
			if(!is_array($v)) continue;
			$this->postData[$k]=array_map('trim',$v);
		}
		$post=$this->postData;
		
		# 規約同意
		$error_format_list=tsv('error_mes.tsv');
		if(isset($post['check'])AND empty($post['check'])){
			$error_mes['check']=$error_format_list['validate_check'];
			$this->set(compact('error_mes'));
			return false;
		}
		
		$field_name=$this->FieldData->getModelName('MuzFormFieldSetting');
		$field_detail_name=$this->FieldData->getModelName('MuzFormFieldSettingDetail');
		$preset_ids   =Set::combine($this->FieldData->useFields,"{n}.{$field_detail_name}.field_id","{n}.{$field_detail_name}.preset_id");
		$required_list=Set::combine($this->FieldData->useFields,"{n}.{$field_name}.id","{n}.{$field_name}.required_flg");
		$field_types  =Set::combine($this->FieldData->useFields,"{n}.{$field_name}.id","{n}.{$field_name}.type");
		$field_titles =Set::combine($this->FieldData->useFields,"{n}.{$field_name}.id","{n}.{$field_name}.title");
		
		# 最大文字数(通常)
		# 入力制限(通常)
		$normal_validate_list=$normal_max_num_list=array();
		foreach($this->FieldData->useFields as $k=>$v){
			
			if(!empty($preset_ids[$v[$field_detail_name]['field_id']])) continue;
			$field_id=$v[$field_detail_name]['field_id'];
			$sort_num=$v[$field_detail_name]['sort_num'];
			$normal_max_num_list[$field_id][$sort_num]=$v[$field_detail_name]['max_num'];
			$normal_validate_list[$field_id][$sort_num]=explode(',',$v[$field_detail_name]['validate_type']);
		}
		
		# 最大文字数(Preset)
		# 文字制限(Preset)
		$preset_validate_list=$preset_max_num_list=array();
		
		$modelName=$this->FieldData->presetDetailModelName();
		
		foreach($this->FieldData->usePresetFields as $k=>$v){
			
			$preset_id=$v['MuzFormPreset']['id'];
			foreach($v[$modelName] as $_k=>$_v){
				$preset_max_num_list[$preset_id][$_v['sort_num']]=$_v['max_num'];
				$preset_validate_list[$preset_id][$_v['sort_num']]=explode(',',$_v['validate_type']);
			}
		}	
		
		# 確認処理
		$error_list=array();
		$field_ids=Set::extract($this->FieldData->useFields,"{}.{$field_name}.id");
		
		foreach($post as $k=>$v){
			
			if(!is_array($v)) continue;
			
			$field_id=str_replace("Field","",$k);
			$isPreset=(!empty($preset_ids[$field_id]))?true:false;
			
			# 送信されたフィールドを確認
			$field_ids=array_remove($field_ids,$field_id);
			
			# boxの数
			$field_index=1;
			foreach($v as $_k=>$value){
				
				$field_type=$this->_getFieldType($field_types[$field_id]);
				
				if(!in_array($field_type,array(Text::NAME,Textarea::NAME,Select::NAME))) continue;
				
				# 設定済みバリデーション
				$validate_list=($isPreset)?$preset_validate_list[$preset_ids[$field_id]][$field_index]:$normal_validate_list[$field_id][$field_index];
				
				# 必須判定
				# textbox,textarea,selectの場合は 1でもfalseがあればfalse
				$isRequired=$required_list[$field_id];
				$tmp_value=trim($value,'-');
				if(!isset($error_list[$field_id]['validate_required']))$error_list[$field_id]['validate_required']=true;
				if($isRequired AND empty($tmp_value) AND !empty($error_list[$field_id]['validate_required'])){
					$error_list[$field_id]['validate_required']=false;
				}
				
				# 以下入力フィールドを対象
				if($field_type==Select::NAME) continue;
				
				# 文字数判定
				# 1つでもfalseがあればNG
				# textbox,textareaを対象
				if(!isset($error_list[$field_id]['validate_characterlimit']))$error_list[$field_id]['validate_characterlimit']=true;
				$max_num=($isPreset)?$preset_max_num_list[$preset_ids[$field_id]][$field_index]:$normal_max_num_list[$field_id][$field_index];
				
				$isExec=in_array('validate_characterlimit',$validate_list);
				$isNoError=!empty($error_list[$field_id]['validate_characterlimit']);
				if(!empty($value) AND $isExec AND $isNoError AND !empty($max_num) AND (mb_strlen($value)>$max_num)){
					$error_list[$field_id]['validate_characterlimit']=false;
				}
				
				# 数値判定
				# 1つでもfalseがあればNG
				# textbox,textareaを対象
				if(!isset($error_list[$field_id]['validate_number']))$error_list[$field_id]['validate_number']=true;
				$isExec=in_array('validate_number',$validate_list);
				$isNoError=!empty($error_list[$field_id]['validate_number']);
				if(!empty($value) AND $isExec AND $isNoError AND !is_numeric($value)){
					$error_list[$field_id]['validate_number']=false;
				}
				
				# アルファベット判定
				# 1つでもfalseがあればNG
				# textbox,textareaを対象
				if(!isset($error_list[$field_id]['validate_alpha']))$error_list[$field_id]['validate_alpha']=true;
				$reg_exp="#^[a-zA-Z]+$#";
				$isExec=in_array('validate_alpha',$validate_list);
				$isNoError=!empty($error_list[$field_id]['validate_alpha']);
				if(!empty($value) AND $isExec AND $isNoError AND !preg_match($reg_exp,$value)){
					$error_list[$field_id]['validate_alpha']=false;
				}
				
				# メールアドレス判定
				# 1つでもfalseがあればNG
				# textbox,textareaを対象
				if(!isset($error_list[$field_id]['validate_email']))$error_list[$field_id]['validate_email']=true;
				$validate_list=($isPreset)?$preset_validate_list[$preset_ids[$field_id]][$field_index]:$normal_validate_list[$field_id][$field_index];
				
				$reg_exp="#[A-Za-z0-9]+[\w-]+@[\w\.-]+\.\w{2,}#";
				$isExec=in_array('validate_email',$validate_list);
				$isNoError=!empty($error_list[$field_id]['validate_email']);
				if(!empty($value) AND $isExec AND $isNoError AND !preg_match($reg_exp,$value)){
					$error_list[$field_id]['validate_email']=false;
				}
				
				$field_index++;
				
			}
		}
	
		# 必須判定 
		# checkbox radio の valid_required を確認(チェック無は送信されない)
		# 送信されたか、を確認するだけで良い
		if(!empty($field_ids)){
			foreach($field_ids as $k=>$field_id){
				$field_type=$this->_getFieldType($field_types[$field_id]);
				if($required_list[$field_id] AND in_array($field_type,array(Radio::NAME,Checkbox::NAME))){
					$error_list[$field_id]['validate_required']=false;
				}
			}
		}
		
		# エラー確認
		$error_mes=array();
		foreach($error_list as $field_id=>$v){
			foreach($v as $validate_type=>$status){
				if($status) continue;
				$error_mes[$field_id][]=sprintf("{$error_format_list[$validate_type]}",$field_titles[$field_id]);
			}
		}
		
		if(empty($error_mes)) return true;
		$this->set(compact('error_mes'));
		return false;
	}
	
	# ■フィールドのタイプ
	# @author Kiyosawa 
	# @date 
	function _getFieldFormats($types){
		
		# フォーマット(この情報を元にHTMLを生成する)
		$type_formats=ClassRegistry::init("MuzFormTypeFormat")->findAllByTypeAndSite($types,$this->site);
		$types=Set::combine($type_formats,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.format");
		return $types;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _viewGroups(){
		
		# 初期値
		$init_values=$this->_initValues($this->FieldData->form[$this->FieldData->getModelName('MuzForm')]['id']);
		
		# グループ情報(sort)
		$groups=$this->FieldData->getGroupList();
		
		# [Group][Field]へ変換
		$group_fields=$this->FieldData->fieldsInGroups();
		
		# プリセット情報&整形&SORT
		$all_presets=$this->FieldData->getPresetFieldMergePresetValues(true);
		
		# 表示形式
		$formats=$this->FieldData->getFieldFormats(true);
		
		foreach($groups as $k=>$v){
			
			if(!isset($group_fields[$v[$this->FieldData->getModelName('MuzFormGroupSetting')]['id']])) continue;
			$field_ary=$group_fields[$v[$this->FieldData->getModelName('MuzFormGroupSetting')]['id']];
			
			foreach($field_ary as $field_id=>$_v){
				
				$preset_datas=array();
				if(!empty($all_presets[$_v['preset_id']])){
					$preset_datas=$all_presets[$_v['preset_id']];
				}
				
				# 選択肢
				$values=(isset($_v['values']))?$_v['values']:array();
				
				# 初期値
				$datas=array_merge($v[$this->FieldData->getModelName('MuzFormGroupSetting')],$_v);
				$init_value=(isset($init_values[$field_id]))?$init_values[$field_id]:array();
				$html_fields=$this->_makeField($datas,$preset_datas,$init_value);
				
				$format=$this->_makeFormat($formats['main'][$_v['type']],$_v,$values);
				$field_ary[$field_id]['field']=$this->_sprintf($format,$html_fields);
				$groups[$k][$this->FieldData->getModelName('MuzFormGroupSetting')]['fields']=$field_ary;
			}
		}
		return $groups;
	}
	
	# ■送信後の初期値
	# @author Kiyosawa 
	# @date 
	function _initValues($form_id){
		
		if(!isset($this->data["Form{$form_id}"])) return false;
		
		# 初期値
		$init_values=array();
		foreach($this->data["Form{$form_id}"] as $k=>$v){
			$init_values[str_replace('Field','',$k)]=$v;
		}
		return $init_values;
	}
	
	# ■フィールドのタイプを取得する
	# ■normal_ : 通常のフィールド
	# ■preset_ : プリセット
	# ■上記の文字列以降の文字がフィールドのタイプとなるルール
	# @author Kiyosawa 
	# @date 
	function _getFieldType($type){
		
		$ary=explode('_',$type);
		if(!isset($ary[1])) return false;
		return $ary[1];
	}
	
	
	# ■プリセットか
	# @author Kiyosawa 
	# @date 
	function _isPresetByFieldType($type){
		
		$ary=explode('_',$type);
		if(!isset($ary[0])) return false;
		return $ary[0]=='preset';
	}
	
	# ■フォーマット生成
	# @author Kiyosawa 
	# @date 
	function _makeFormat($format,$datas=array(),$values=array()){
		
		$multi_field=array('checkbox','radio');
		$type=$datas['type'];
		
		$type=$this->_getFieldType($type);
		if(!in_array($type,$multi_field)){
			return $format;
		}
		
		# 変更要求
		# 現状は通常フィールド
		$_format='';
		$box_count=!empty($values)?count($values):1;
		for($i=0;$i<$box_count;$i++){
			$_format.=(str_replace("%v",array_shift($values),$format));
		}
		
		# フォーマット
		$camel=ucfirst($type);
		$methodName="_make{$camel}View";
		if(!method_exists($this,$methodName)) return $_format;
		$_format=$this->{$methodName}($datas,$_format);
		return $_format;
	}
	
	
	# ■チェックボックスの表示内容の生成
	# @author Kiyosawa 
	# @date 
	function _makeCheckboxView($datas,$format){
		
		$instance=new Checkbox($datas['form_id'],$datas['field_id']);
		
		$classes[]='input_checkbox_radio';
		$classes[]=$datas['type'];
		if(!empty($datas['required_flg'])){
			$classes[]=Checkbox::VALID_REQUIRED;
		}
		$instance->setViewClass(implode(',',$classes));
		$instance->setViewDataTitle($datas['title']);
		$instance->setHtml($format);
		$format=$instance->getViewFormat();
		return $format;
	}
	
	
	# ■ラジオボタンの表示内容の生成
	# @author Kiyosawa 
	# @date 
	function _makeRadioView($datas,$format){
		
		$instance=new Radio($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$classes[]=$datas['type'];
		$classes[]='input_checkbox_radio';
		if(!empty($datas['required_flg'])){
			$classes[]=Radio::VALID_REQUIRED;
		}
		$instance->setViewClass(implode(',',$classes));
		$instance->setViewDataTitle($datas['title']);
		$instance->setHtml($format);
		$format=$instance->getViewFormat();
		return $format;
	}
	
	# ■Viewに表示するフィールドを生成
	# @author Kiyosawa 
	# @date 
	function _sprintf($format,$fields,$s="%s",$string=''){
		
		$field=array_shift($fields);
		$end_index=mb_strpos($format,'%s')+mb_strlen($s);
		
		# 置換対象
		$change=mb_substr($format,0,$end_index);
		
		# 置換後
		$format=mb_substr($format,$end_index);
		$string.=str_replace($s,$field,$change);
		
		if(!empty($fields)){
			$string=$this->_sprintf($format,$fields,$s,$string);
		}
		
		if(!is_numeric(strpos($format,$s))){
			$string.=$format;
		}
		return $string;
	}
	
	# ■各フィールドの生成
	# ■value : 初期入力値
	# ■checkbox,textareaに関してはプリセットが存在しないので用意しません
	# @author Kiyosawa 
	# @date 
	function _makeField($datas=array(),$preset_datas=array(),$values=array()){
		
		$field_type=ucfirst($this->_getFieldType($datas['type']));
		
		switch($field_type){
			case("Text"):
			return $this->_makeText($datas,$preset_datas,$values);
		break;	
			case("Select"):
			return $this->_makeSelect($datas,$preset_datas,$values);
		break;
			case("Radio"):
			return $this->_makeRadio($datas,$preset_datas,$values);
		break;
			case("Checkbox"):
			return $this->_makeCheckbox($datas,$values);
		break;
			case("Textarea"):
			return $this->_makeTextarea($datas,$preset_datas,$values);
		break;
			default:
			v(__LINE__);
		break;
		}
	}
	
	# ■TextBox プリセット
	# @author Kiyosawa 
	# @date 
	function _makeTextPreset($datas=array(),$preset_datas=array(),$values=array()){
		
		$instance=new Text($datas['form_id'],$datas['field_id'],'text');
		$instance->setSite($this->site);
		
		$modelName=$this->FieldData->presetDetailModelName();
		
		for($i=0;$i<count($preset_datas[$modelName]);$i++){
			
			# 初期値
			$value=isset($values[$i])?$values[$i]:'';
			
			$preset_detail=$preset_datas[$modelName][$i];
			
			if(method_exists($this,'__type') AND $type=$this->__type(Text::NAME,explode(",",$preset_detail['validate_type']))){
				$instance->setFieldType($type);
			}
			
			# 最大文字数
			# 郵便番号等で 3文字4文字で制限をかけるときに不憫
			# 現状はプリセットには設定しない判断
			$max_num=$preset_detail['max_num'];
			if(!empty($max_num)){
				$instance->setDataNum($max_num);
			}
			
			# インデックス
			$instance->_setFieldIndex($preset_detail['id']);
			
			# 初期値
			if(isset($values[$i])){
				$instance->setValueAttr($values[$i]);
			}
			
			# data_title
			$data_title=$preset_detail['field_title'];
			$instance->setDataTitle($data_title);
			
			# class
			$classes[]=$preset_detail['class_name'];
			$validate_type=$preset_detail['validate_type'];
			if(!empty($validate_type)){
				$classes=array_merge($classes,explode(',',$validate_type));
			}
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Text::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# 郵便番号等の場合ボックスは複数になるが、それぞれのフィールドに値を入れさせる
			if(!empty($datas['required_flg'])){
				$classes[]=Text::VALID_REQUIRED;
			}
			
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	
	# ■プルダウンプリセット
	# @author Kiyosawa 
	# @date 
	function _makeSelectPreset($datas=array(),$preset_datas=array(),$values=array()){
		
		$instance=new Select($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$modelName=$this->FieldData->presetDetailModelName();
		
		for($i=0;$i<count($preset_datas[$modelName]);$i++){
			
			# プリセット情報
			$preset_detail=$preset_datas[$modelName][$i];
			
			# class
			$classes=array();
			if(!empty($datas['required_flg'])){
				$classes[]=Select::VALID_REQUIRED;
			}
			$classes[]=$preset_detail['class_name'];
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Select::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# data_title
			$data_title=$preset_detail['field_title'];
			$instance->setDataTitle($data_title);
			
			# selectedIndex
			$selectedIndex=(isset($values[$i]))?$values[$i]:'';
			$instance->setOption($preset_detail['values'],$selectedIndex);
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	# ■プルダウンプリセット
	# @author Kiyosawa 
	# @date 
	function _makeRadioPreset($datas=array(),$preset_datas=array(),$values=array()){
		
		$instance=new Radio($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$modelName=$this->FieldData->presetDetailModelName();
		
		for($i=0;$i<count($preset_datas[$modelName]);$i++){
			
			# プリセット情報
			$preset_detail=$preset_datas[$modelName][$i];
			
			# class
			$classes=array();
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Checkbox::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# 初期値の設定
			$checked=false;
			$field_value=current($preset_detail['values']);
			if(empty($i) AND empty($values) AND !empty($datas['required_flg'])){
				$checked=true;
			}
			if(!empty($values) AND (in_array($field_value,$values))){
				$checked=true;
			}
			$instance->setValueAttr($field_value,$checked);
			
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	# ■プルダウン
	# @author Kiyosawa 
	# @date 
	function _makeSelect($datas=array(),$preset_datas=array(),$values=array()){
		
		# プリセット
		if(!empty($preset_datas)){
			return $this->_makeSelectPreset($datas,$preset_datas,$values);
		}
		
		$instance=new Select($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$box_count=1;
		for($i=0;$i<$box_count;$i++){
			
			# option
			$option_values=$datas['values'];
			
			# class
			$classes[]=$datas['type'];
			if(!empty($datas['required_flg'])){
				$classes[]=Select::VALID_REQUIRED;
			}
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Select::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# selectedIndex
			$selectedIndex=(isset($values[$i]))?$values[$i]:'';
			
			# 空が必要(必須でない)な場合
			if(!empty($datas['required_flg'])){
				
				$tmp=$option_values;
				unset($option_values);
				$option_values['-']='▽選択して下さい';
				$option_values=array_merge($option_values,$tmp);
			}
			
			$instance->setOption($option_values,$selectedIndex);
			
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	# ■ラジオボタン
	# ■現状プリセットの用意はしない(ないから)
	# @author Kiyosawa 
	# @date 
	function _makeRadio($datas=array(),$preset_datas=array(),$values=array()){
		
		# プリセット
		if(!empty($preset_datas)){
			return $this->_makeRadioPreset($datas,$preset_datas,$values);
		}
		
		$instance=new Radio($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$value=(is_array($values))?current($values):$values;
		$box_num=count($datas['values']);
		for($i=0;$i<$box_num;$i++){
			
			# value
			$current_value=current($datas['values']);
			$current_value_key=array_search($current_value,$datas['values']);
			unset($datas['values'][$current_value_key]);
			
			# class
			$classes=array();
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Radio::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# checked
			$checked=false;
			if((string)$value===(string)$current_value){
				$checked=true;
			}
			$instance->setValueAttr($current_value,$checked);
			
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	# ■チェックボックス
	# @author Kiyosawa 
	# @date 
	function _makeCheckbox($datas=array(),$values=array()){
		
		$instance=new Checkbox($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
    	$box_num=count($datas['values']);
		for($i=0;$i<$box_num;$i++){
			
			# value
			$current_value=current($datas['values']);
			$current_value_key=array_search($current_value,$datas['values']);
			unset($datas['values'][$current_value_key]);
			
			# checked
			$checked=false;
			if(isset($values[$i]) AND (string)$values[$i]===(string)$current_value){
				$checked=true;
			}
			
			
			$instance->setValueAttr($current_value,$checked);
			
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}

	# ■テキストボックス
	# ■スマホで validete_numeric が設定されていたら input=tel で対応する
	# @author Kiyosawa 
	# @date 
	function _makeText($datas=array(),$preset_datas=array(),$values=array()){
		
		# プリセット
		if(!empty($preset_datas)){
			return $this->_makeTextPreset($datas,$preset_datas,$values);
		}
		
		$type='text';
		if(method_exists($this,'__type')){
			$type=$this->__type(Text::NAME,explode(",",$datas['validate_type']));
		}
		
		$instance=new Text($datas['form_id'],$datas['field_id'],$type);
		$instance->setSite($this->site);
		
		# プリセットの場合detailsから
		$box_count=1;
		
		for($i=0;$i<$box_count;$i++){
			
			# 初期値
			$value=isset($values[$i])?$values[$i]:'';
			
			# 最大文字数
			# 郵便番号等で 3文字4文字で制限をかけるときに不憫
			# 現状はプリセットには設定しない判断
			$max_num=$datas['max_num'];
			if(!empty($max_num)){
				$instance->setDataNum($max_num);
			}
			
			# 初期値
			if(isset($values[$i])){
				$instance->setValueAttr($values[$i]);
			}
			
			# data_title
			$data_title=$datas['title'];
			$instance->setDataTitle($data_title);
			
			# class
			$classes[]=$datas['type'];
			$validate_type=$datas['validate_type'];
			if(!empty($validate_type)){
				$classes=array_merge($classes,explode(',',$validate_type));
			}
			if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Text::NAME)){
				$classes[]=$site_class_name;
			}
			if(!empty($classes)) $instance->setClass(implode(' ',$classes));
			
			# 郵便番号等の場合ボックスは複数になるが、それぞれのフィールドに値を入れさせる
			if(!empty($datas['required_flg'])){
				$classes[]=Text::VALID_REQUIRED;
			}
			$forms[]=$instance->getForm();
			unset($classes);
		}
		return $forms;
	}
	
	# ■テキストエリア
	# @author Kiyosawa 
	# @date 
	function _makeTextarea($datas=array(),$preset_datas=array(),$values=array()){
		
		$instance=new Textarea($datas['form_id'],$datas['field_id']);
		$instance->setSite($this->site);
		
		$max_num=$datas['max_num'];
		if(!empty($max_num)){
			$instance->setDataNum($max_num);
		}
		
		# data_title
		$data_title=$datas['title'];
		$instance->setDataTitle($data_title);
		
		# class
		$classes[]=$datas['type'];
		$validate_type=$datas['validate_type'];
		if(!empty($validate_type)){
			$classes=array_merge($classes,explode(',',$validate_type));
		}
		
		# 郵便番号等の場合ボックスは複数になるが、それぞれのフィールドに値を入れさせる
		if(!empty($datas['required_flg'])){
			$classes[]=Textarea::VALID_REQUIRED;
		}
		if(method_exists($this,'__class') AND $site_class_name=$this->__class($instance,Textarea::NAME)){
			$classes[]=$site_class_name;
		}
		if(!empty($classes)) $instance->setClass(implode(' ',$classes));
		
		# 初期値(入力ボックスは１つなので１つの要素のみ前提)
		if($value=array_shift($values)){
			$instance->setValueAttr($value);
		}
		
		# style
		if(!empty($datas['style'])){
			$instance->setStyleAttr($datas['style']);
		}
		
		$forms[]=$instance->getForm();
		return $forms;
	}
	
	# ■メール送信
	# @author Kiyosawa 
	# @date 
	function _sendGridMail($to,$changeCodes=array(),$from=array('saiyo.musee@jin-co.jp'=>'ミュゼプラチナム採用事務局')){
		
		require_once('win_blob_strage.php');
		require_once('SendgridSmtp.php');
		
		if(!class_exists('WinBlobStorage')) return;
		if(!class_exists('SendgridSmtp'))   return;
		
		# タイトル、本文はAzureにある
		$win_blob=new WinBlobStorage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
		
		$mail=new SendgridSmtp();
		$mail_body=$win_blob->blob_get_contents(MAILTPL,'body.txt');
		$mail->setBody($mail_body,$changeCodes);
		$mail_subject=$win_blob->blob_get_contents(MAILTPL,'subject.txt');
		$mail->setSubject($mail_subject);
		$mail->sendMail($to,$from);
	}
	
	# ■名前とアドレスを取得する
	# @author Kiyosawa 
	# @date 
	function _getRegistDataByType($regist_data=array(),$types=array('preset_text_email','preset_text_name')){
		
		$modelName=$this->FieldData->getModelName('MuzUserRegistData');
		$regist_value=Set::combine($regist_data,"{n}.{$modelName}.field_id","{n}.{$modelName}.value");
		$field_ids=Set::extract($regist_data,"{}.{$modelName}.field_id");
		
		$w=null;
		$modelName=$this->FieldData->getModelName('MuzFormFieldSetting');
		$w['and']["{$modelName}.id"]=$field_ids;
		ClassRegistry::init($modelName)->unbindFully();
		$fields=ClassRegistry::init($modelName)->findAll($w);
		
		# field_type
		$field_types=Set::combine($fields,"{n}.{$modelName}.id","{n}.{$modelName}.type");
		$field_type_forms=ClassRegistry::init("MuzFormTypeFormat")->findAllByTypeAndSite($field_types,$this->site);
		$field_type_forms=Set::combine($field_type_forms,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.confirm");
		
		$res=array();
		$modelName=$this->FieldData->getModelName('MuzUserRegistData');
		foreach($regist_data as $k=>$v){
			
			$data=$v[$modelName];
			$type=$field_types[$data['field_id']];
			$format=$field_type_forms[$type];
			
			if(!in_array($type,$types)) continue;
			$res[$field_types[$data['field_id']]]=$this->_sprintf($format,explode(SEPARATOR,$data['value']));
		}
		return $res;
	}
	
}