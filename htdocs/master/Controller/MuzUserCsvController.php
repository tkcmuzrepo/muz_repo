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

require_once(CLASS_DIR."form_base".DS."checkbox.php");

class MuzUserCsvController extends AppController{
	
	public $name = 'MuzUserCsv';
	var $uses = array("MuzUser");
	
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
		
		$regist_data=ClassRegistry::init("MuzUserRegistData")->find('all');
		$user_ids=array_unique(Set::extract($regist_data,"{}.MuzUserRegistData.user_id"));
		$this->get_csv($user_ids);
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function _getUserIdByWinStorage($file_name){
		
		require_once("win_blob_strage.php");
		$instance=new WinBlobStorage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
		$user_ids=$instance->blob_get_contents(CSV_TMP,$file_name);
		return unserialize($user_ids);
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function get_csv_by_filename($file_name){
		
		# Azureに保存してある(仮で)
		$user_ids=$this->_getUserIdByWinStorage($file_name);
		$this->get_csv($user_ids);
	}
	
	# ■縦長～～
	# @author Kiyosawa 
	# @date 
	function get_csv($user_ids){
		
		if(empty($user_ids)) return;
		
		# フォームID別に整列
		$users=ClassRegistry::init("MuzUser")->findAllById($user_ids);
		$users=Set::sort($users,"{}.MuzUser.form_id",'asc');
		$user_referers=Set::combine($users,"{n}.MuzUser.id","{n}.MuzUser.referer");
		$user_createds=Set::combine($users,"{n}.MuzUser.id","{n}.MuzUser.created");
		$user_promotions=Set::combine($users,"{n}.MuzUser.id","{n}.MuzUser.promotion_id");
		$user_regist_form_ids=array_unique(Set::extract($users,"{}.MuzUser.form_id"));
		
		# フォーム
		$form_names=$this->_getFormNames($user_regist_form_ids);
		
		# 登録データ
		$regist_data_ary=array();
		$regist_datas=ClassRegistry::init("MuzUserRegistData")->findAllByUserId($user_ids);
		foreach($regist_datas as $k=>$v){
			$model=$v['MuzUserRegistData'];
			$regist_data_ary[$model['form_id']][$model['user_id']][$model['field_id']]=$model['value'];
			$field_ids[]=$model['field_id'];
		}
		
		# プロモーション
		$promotion_codes=$this->_getPromotionCodes($user_promotions);
		
		# フィールド
		$fields=$this->_getFields($field_ids);
		$field_types=Set::combine($fields,"{n}.MuzFormFieldSetting.id","{n}.MuzFormFieldSetting.type");
		$field_titles=Set::combine($fields,"{n}.MuzFormFieldSetting.id","{n}.MuzFormFieldSetting.title");
		$field_formats=$this->_getFieldFormats($field_types);
		
		# タイトル、登録データの取り出し
		$csv_title=$csv_data=array();
		$pref_tsv=tsv("pref.tsv");
		foreach($users as $k=>$v){
			
			$user_id=$v['MuzUser']['id'];
			if(!isset($regist_data_ary[$v['MuzUser']['form_id']][$user_id])) continue;
			$regist_data=$regist_data_ary[$v['MuzUser']['form_id']][$user_id];
			
			$csv_ary=array();
			$csv_top_field_titles=array();
			foreach($regist_data as $field_id=>$_v){
				
				# checkbox(選択肢が複数)
				$field_format=$field_formats[$field_types[$field_id]];
				if($this->_getFieldType($field_types[$field_id])==Checkbox::NAME){
					$box_num=count(explode(SEPARATOR,$_v));
					$field_format=implode(' ',array_pad(array(),$box_num,$field_format));
				}
				
				# 県
				if($field_types[$field_id]==PRESET_SELECT_PREF) $_v=$pref_tsv[$_v];
				
				$value=$this->_sprintf($field_format,explode(SEPARATOR,str_replace(",","",$_v)));
				$csv_data[$v['MuzUser']['form_id']][$v['MuzUser']['id']][$field_id]=$value;
				
				if(!isset($csv_title[$v['MuzUser']['form_id']][$field_id])){
					$csv_title[$v['MuzUser']['form_id']][$field_id]=$field_titles[$field_id];
				}
			}
			
			# 必要か？？
			ksort($csv_title[$v['MuzUser']['form_id']]);
			ksort($csv_data[$v['MuzUser']['form_id']][$v['MuzUser']['id']]);
		}
		
		# 登録データの整形
		# タイトルを主として動かさないと空白時、ずれる
		$user_regist_data=array();
		foreach($csv_title as $form_id=>$values){
			foreach($values as $field_id=>$title_value){
				if(!isset($csv_data[$form_id])) continue;
				foreach($csv_data[$form_id] as $user_id=>$data){
					$user_regist_data[$form_id][$user_id][]=(isset($data[$field_id]))?$data[$field_id]:'';
				}
			}
		}
		
		# CSVデータ整形
		$csv_title_tsv=tsv('csv_title.tsv');
		foreach($user_regist_data as $form_id=>$values){
			
            $csv_str=implode(',',array_merge($csv_title[$form_id],$csv_title_tsv))."\n";
			foreach($values as $user_id=>$value){
				
				# 規定値付与
				array_push($value,$user_id);
				
				array_push($value,$form_names[$form_id]);
				$created=isset($user_createds[$user_id])?$user_createds[$user_id]:'';
				array_push($value,$created);
				$referer=isset($user_referers[$user_id])?$user_referers[$user_id]:'';
				array_push($value,$referer);
				$promotion_code=isset($promotion_codes[$user_promotions[$user_id]])?$promotion_codes[$user_promotions[$user_id]]:'';
				array_push($value,$promotion_code);
				$csv_str.=sprintf("%s\n",implode(',',$value));
			}
			$csv_ary[]=$csv_str;
		}
		$this->_csvDownload(implode("\n\n",$csv_ary));
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function _csvDownload($csv_str){
		
		$fileName=sprintf("muz_%s.csv",date('Y_m_d'));
		$csv_str=mb_convert_encoding($csv_str,"SJIS",mb_detect_encoding($csv_str));
		header('Content-Type:application/octet-stream;charset=shift_jis');
		header('Content-Disposition:attachment;filename='.$fileName);
		header('Content-Transfer-Encoding:binary');
		header('Content-Length:'.strlen($csv_str));
		echo $csv_str;
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _getFormNames($form_ids=array()){
		
		if(!$form=ClassRegistry::init("MuzForm")->findAllById($form_ids)){
			return array();
		}
		return Set::combine($form,"{n}.MuzForm.id","{n}.MuzForm.title");
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _getPromotionCodes($promotion_ids=array()){
		
		if(!$promotions=ClassRegistry::init("MuzPromotionSetting")->findAllById($promotion_ids)){
			return array();
		}
		return Set::combine($promotions,"{n}.MuzPromotionSetting.id","{n}.MuzPromotionSetting.promotion_code");
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _getFieldFormats($field_types=array()){
		
		# view format
		$type_formats=ClassRegistry::init("MuzFormTypeFormat")->findAllByType(array_unique($field_types));
		$field_formats=Set::combine($type_formats,"{n}.MuzFormTypeFormat.type","{n}.MuzFormTypeFormat.confirm");
		return $field_formats;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _getFields($field_ids=array()){
		
		# field
		$field_ids=array_unique($field_ids);
		ClassRegistry::init("MuzFormFieldSetting")->unbindModel(array('hasMany'=>array('MuzFormValueSetting')));
		$fields=ClassRegistry::init("MuzFormFieldSetting")->findById($field_ids);
		return $fields;
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
	
}