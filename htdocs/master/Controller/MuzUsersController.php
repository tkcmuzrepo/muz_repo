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

require_once("form_base".DS."checkbox.php");

class MuzUsersController extends AppController{
	
	public $name = 'MuzUsers';
	var $uses = array("MuzUser");
	var $components=array('Bj');
	var $helpers=array('Paginator');
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(!$this->login_user){
			$this->redirect("/muz_logins/");
		}
	}
	
	# E-1 ユーザ管理
	function index(){
		exit;
	}
	
	#
	# @author Kiyosawa
	# @date 
	function search(){
		
		# ページングの為初期アクセス判定
		Configure::write('isFirstAccess',(!isset($this->passedArgs['page']) AND !$this->data));
		
		# フォームID
		$form_titles=ClassRegistry::init("MuzForm")->findFormTitles($this->login_user['MuzClient']['id']);
		
		# 検索結果ユーザ
		# 並び替え後
		$search_users=$this->_findBySearchUsers();
		
		# CSVで使える
		$search_user_ids=array_keys($search_users);
		
		if(isset($this->data['CSV'])) $this->_csvDownLoad($search_user_ids);
		
		# 再検索...(paging)
		$sort_regist_users=$this->_paginateByUserId($search_user_ids,50);
		
		# ユーザ登録データ
		$sort_regist_user_ids=Set::extract($sort_regist_users,'{}.MuzUser.id');
		$regist_data=$this->_getUserRegistData($sort_regist_user_ids);
		
		$this->set(compact('regist_data','sort_regist_users','form_titles'));
	}
	
	
	# ■仮のファイルをAzureに保存します
	# @author Kiyosawa 
	# @date 
	function _csvDownLoad($search_user_ids=array()){
		
		require_once("win_blob_strage.php");
		
		$file_name=sprintf("%s_%s_%s.txt",$this->login_user['MuzClient']['id'],$this->login_user['MuzMasterAccount']['id'],date('YmdHis'));
		$instance=new WinBlobStorage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
		$instance->blob_put_contents(CSV_TMP,$file_name,serialize($search_user_ids),false);
		$this->requestAction("/muz_user_csv/get_csv_by_filename/{$file_name}");
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _paginateByUserId($search_sort_user_ids=array(),$limit=50){
		
		if(empty($search_sort_user_ids)) return array();
		
		$str='case id';
		foreach($search_sort_user_ids as $k=>$v){
			$str.=" when {$v} then {$k}";
		}
		$str.=" end";
		
		$w=null;
		$w['and']['MuzUser.id']=$search_sort_user_ids;
		$w['and']['MuzUser.del_flg']=0;
		$this->paginate=array('conditions'=>$w,
		                      'order'=>$str,'limit'=>2);
		$regist_users=$this->paginate('MuzUser');
		return $regist_users;
	}
	
	# ■登録データ取得
	# @author Kiyosawa 
	# @date
	function _getUserRegistData($user_ids=array()){
		
		if(empty($user_ids)) return array();
		
		$regist_data=ClassRegistry::init("MuzUserRegistData")->findAllByUserId($user_ids);
		
		$field_ids=array_unique(Set::extract($regist_data,"{}.MuzUserRegistData.field_id"));
		
		$field_settings=ClassRegistry::init("MuzFormFieldSetting")->findAllById($field_ids);
		
		# format
		$field_types=Set::combine($field_settings,"{n}.MuzFormFieldSetting.id","{n}.MuzFormFieldSetting.type");
		$field_titles=Set::combine($field_settings,"{n}.MuzFormFieldSetting.id","{n}.MuzFormFieldSetting.title");
		$type_formats=$this->_getTypeFormat();
		
		$res_array=array();
		$pref_tsv=tsv("pref.tsv");
		foreach($regist_data as $k=>$v){
			
			$value   =$v['MuzUserRegistData']['value'];
			$field_id=$v['MuzUserRegistData']['field_id'];
			$user_id =$v['MuzUserRegistData']['user_id'];
			
			# checkboxは複数
			if(!isset($field_types[$field_id])) continue;
			$type_format=$type_formats[$field_types[$field_id]];
			if($this->_getFieldType($field_types[$field_id])==Checkbox::NAME){
				$type_format=implode(' ',array_pad(array(),count(explode(SEPARATOR,$value)),$type_format));
			}
			
			# 姓名
			$value=$this->_sprintf($type_format,explode(SEPARATOR,$value));
			if($field_types[$field_id]==PRESET_TEXT_NAME){
				$res_array[$user_id][PRESET_TEXT_NAME]=$value;
				continue;
			}
			
			# 県名
			if($field_types[$field_id]==PRESET_SELECT_PREF){
				$res_array[$user_id][$field_titles[$field_id]]=$pref_tsv[$value];
				continue;
			}
			$res_array[$user_id][$field_titles[$field_id]]=$value;
		}
		return $res_array;
	}
	
	# ■formatの取得
	# @author Kiyosawa 
	# @date 
	function _getTypeFormat($site='pc',$colm='confirm'){
		
		$types=ClassRegistry::init("MuzFormTypeFormat")->findAllBySite($site);
		return Set::combine($types,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.{$colm}");
	}
	
	# ■検索対象取得
	# @author Kiyosawa 
	# @date 
	function _findBySearchUsers($convert_type='yyyy/mm/dd',$date_sort=false,$name_sort=false){
		
		# 変換形式
		$convert['yyyymmdd']=112;
		$convert['yyyy/mm/dd']=111;
		
		$w=null;
		$w['and']["MuzUser.del_flg"]=0;
		$w['and']["MuzUser.client_id"]=$this->login_user['MuzClient']['id'];
		
		# form_id
		$search_form=$this->_getForm();
		if($search_form) $w["and"]['MuzUser.form_id']=$search_form;
		
		# created 
		if($date_by=$search_date=$this->_dateBy()){
			
			if(!empty($date_by['first'])){
				$date_ary[]="CONVERT(varchar,created,{$convert[$convert_type]}) >= '{$date_by['first']}'";
			}
			if(!empty($date_by['last'])){
				$date_ary[]="CONVERT(varchar,created,{$convert[$convert_type]}) <= '{$date_by['last']}'";
			}
			if(!empty($date_ary)){
				$w[]=sprintf("%s",implode(" AND ",$date_ary));
			}
		}
		
		# 日付のソート
		if($is_date_sort=$this->_dateSort()) ClassRegistry::init("MuzUser")->order="MuzUser.created ASC";
		if(!$_users=ClassRegistry::init("MuzUser")->findAll($w)) return array();
		
		# 整形
		foreach($_users as $k=>$v){
			$users[$v['MuzUser']['id']]=$v['MuzUser'];
		}
		
		$search_name=$this->_getName();
		
		# 名前のフィールドを調査
		$regist_form_ids=array_unique(Set::extract($users,"{}.form_id"));
		$search_name_user_ids=$this->_getSearchByNameUserIds($search_name,$regist_form_ids,$this->_nameSort());
		
		# この順で並び替える
		$res_users=array();
		foreach($search_name_user_ids as $k=>$user_id){
			if(!isset($users[$user_id])) continue;
			$res_users[$user_id]=$users[$user_id];
		}
		return $res_users;
	}
	
	# ■日本語ソートモジュール(intl)
	# @author Kiyosawa
	# @date 
	function __collatorSortByPECL($ary=array(),$locale='ja_JP'){
		
		# しゃーない
		if(!class_exists('Collator')){
			asort($ary);
			return $ary;
		}
		
		$collator=Collator::create($locale);
		$collator->asort($ary,Collator::SORT_STRING);
		return $ary;
	}
	
	# @author Kiyosawa 
	# @date 
	function _getSearchByNameUserIds($search_name='',$regist_form_ids,$sort_by=true){
		
		$field_name_ids=$this->_getFieldIdByName($regist_form_ids);
		
		# 登録データ取得
		$user_regist_data=ClassRegistry::init("MuzUserRegistData")->findAllByFormIdAndFieldID($regist_form_ids,$field_name_ids);
		
		if($sort_by){
			
			# 並び替え
			$user_names=Set::combine($user_regist_data,'{n}.MuzUserRegistData.user_id','{n}.MuzUserRegistData.value');
			$user_names=$this->__collatorSortByPECL($user_names);
			//v($user_names);
			foreach($user_names as $user_id=>$value){
				
				$name=str_replace(SEPARATOR,'',$value);
				if(!empty($search_name) AND !is_numeric(mb_strpos($name,$search_name))) continue;
				$res_user_ids[]=$user_id;
			}
			return $res_user_ids;
		}
		
		$res_user_ids=array();
		foreach($user_regist_data as $k=>$v){
			
			$name=str_replace(SEPARATOR,'',$v['MuzUserRegistData']['value']);
			if(!empty($search_name) AND !is_numeric(mb_strpos($name,$search_name))) continue;
			$res_user_ids[]=$v['MuzUserRegistData']['user_id'];
		}
		return $res_user_ids;
	}
	
	# ■姓名を消した場合もあり、複数の場合がある
	# @author Kiyosawa 
	# @date 
	function _getFieldIdByName($regist_form_ids=array()){
		
		$w=null;
		$w['and']["MuzFormFieldSetting.form_id"]=$regist_form_ids;
		$w['and']["MuzFormFieldSetting.type"]=PRESET_TEXT_NAME;
		ClassRegistry::init("MuzFormFieldSetting")->unbindFully();
		$field_settings=ClassRegistry::init("MuzFormFieldSetting")->findAll($w);
		
		return Set::extract($field_settings,"{}.MuzFormFieldSetting.id");
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _getForm(){
		
		if(Configure::read('isFirstAccess')){
			$this->Session->delete('search_form');
			return;
		# post
		}elseif(isset($this->data['MuzForm']['id'])){
			$form_id=$this->data['MuzForm']['id'];
			if(empty($form_id)){
				$this->Session->delete('search_form');
				return;
			}
		# paging
		}elseif($this->Session->read('search_form')){
			return $this->Session->read('search_form');
		}else{
			return;
		}
		$this->Session->write('form_id',$form_id);
		return $form_id;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _dateBy($SEPARATOR="/"){
		
		if(Configure::read('isFirstAccess')){
			$this->Session->delete('search_date');
			return;
		
		# post
		}elseif($this->data){
			
			$first_year=$first_month=$first_day='';
			if(!empty($this->data['MuzUser']['created_start'])){
			
				$start_ary=explode("/",$this->data['MuzUser']['created_start']);
				$first_year=$start_ary[0];
				$first_month=$start_ary[1];
				$first_day=$start_ary[2];
			}
			
			$last_year=$last_month=$last_day='';
			if(!empty($this->data['MuzUser']['created_end'])){
			
				$end_ary=explode("/",$this->data['MuzUser']['created_end']);
				$last_year=$end_ary[0];
				$last_month=$end_ary[1];
				$last_day=$end_ary[2];
			}
			
		# paging
		}elseif($this->Session->read('search_date')){
			$date_ary=unserialize($this->Session->read('search_date'));
			$this->data['MuzUser']['created_start']=$date_ary['first'];
			$this->data['MuzUser']['created_end']=$date_ary['last'];
			return;
		}else{
			return;
		}
		
		# 以上検索
		$res['first']=$res['last']=array();
		if(strlen($first_year.$first_month.$first_day)=='8'){
			$res['first']=sprintf("%s{$SEPARATOR}%s{$SEPARATOR}%s",$first_year,$first_month,$first_day); 
		}
		# 以下検索
		if(strlen($last_year.$last_month.$last_day)=='8'){
			$res['last']=sprintf("%s{$SEPARATOR}%s{$SEPARATOR}%s",$last_year,$last_month,$last_day);
		}
		
		$this->Session->write('search_date',serialize($res));
		return $res;
	}
	
	# ■名前の検索
	# @author Kiyosawa 
	# @date 
	function _getName(){
		
		# 初期アクセス
		if(Configure::read('isFirstAccess')){
			$this->Session->delete('search_name');
				return;
		# post
		}elseif(isset($this->data['MuzUser']['name'])){
			$name=trim($this->data['MuzUser']['name']);
			if(empty($name)){
				$this->Session->delete('search_name');
				return;
			}
		# paging
		}elseif($this->Session->read('search_name')){
			$name=$this->Session->read('search_name');
		}else{
			return;
		}
		
		$this->data['MuzUser']['name']=$name;
		$this->Session->write('search_name',$name);
		return $name;
	}
	
	# ■名前のソート
	# @author Kiyosawa 
	# @date 
	function _nameSort($status='name'){
		
		# 最初
		if(Configure::read('isFirstAccess')){
			$this->Session->delete('search_name_sort');
			$name_sort_flg=false;
		# post
		}elseif(isset($this->data['MuzUser']['sort'])){
			$name_sort_flg=($this->data['MuzUser']['sort']==$status);
			$this->Session->write('search_name_sort',$name_sort_flg);
		# paging
		}elseif($this->Session->read('search_name_sort')){
			$name_sort_flg=$this->Session->read('search_name_sort');
		}else{
			$name_sort_flg=false;
		}
		$this->set(compact('name_sort_flg'));
		return $name_sort_flg;
	}
	
	# ■日付のソート
	# @author Kiyosawa 
	# @date 
	function _dateSort($status='created'){
		
		# 最初
		if(Configure::read('isFirstAccess')){
			$this->Session->delete('search_date_sort');
			$date_sort_flg=false;
		# post
		}elseif(isset($this->data['MuzUser']['sort'])){
			$date_sort_flg=($this->data['MuzUser']['sort']==$status);
			$this->Session->write('search_date_sort',$date_sort_flg);
		# paging
		}elseif($this->Session->read('search_date_sort')){
			$date_sort_flg=$this->Session->read('search_date_sort');
		}else{
			$date_sort_flg=false;
		}
		$this->set(compact('date_sort_flg'));
		return $date_sort_flg;
	}
}