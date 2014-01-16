<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel','Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class MainMuzFormFieldSetting extends AppModel {

		var $name='MuzFormFieldSetting';
		var $userTable='muz_form_field_settings';
		var $primaryKey='id';
		
		# 選択中のフォームID
		public $form_id='';
		
		var $hasOne = array(
			'MuzFormFieldSettingDetail' =>array(
				'className' => 'MuzFormFieldSettingDetail',
				'foreignKey' => 'field_id',
				'conditions' => '',
				'order' => '',
				'dependent' => true,
			),
		);
		
		var $hasMany = array(
			'MuzFormValueSetting' =>array(
				'className' => 'MuzFormValueSetting',
				'foreignKey' => 'field_id',
				'conditions' => '',
				'order' => '',
				'dependent' => true,
			),
		);
		
		
		# ■使用中のフィールド
		# @author Kiyosawa 
		# @date 
		function getEnableField($form_id='',$bind=true){
			
			$form_id=!empty($form_id)?$form_id:$this->form_id;
			if(empty($form_id)) return;
			
			$w=null;
			$w['and']["{$this->name}.del_flg"]=0;
			$w['and']["{$this->name}.form_id"]=$form_id;
			if(!$bind) $this->unbindFully();
			$fields=$this->find('all',array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order));
			$this->__clear();
			return $fields;
		}
		
		
	#
	# @author Kiyosawa 
	# @date 
	function findById($field_id){
		
		$w=null;
		$w['and']["{$this->name}.id"]=$field_id;
		$w['and']["{$this->name}.del_flg"]=0;
		$type=(is_array($field_id))?'all':'first';
		if(!$res=$this->find($type,array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order))){
			return array();
		}
		return $res;
	}
		
		
		# ■「使う」フィールド取得
		# @author Kiyosawa 
		# @date 
		function getUseFields($form_id){
			
			$w=null;
			$w['and']["{$this->name}.form_id"]=$form_id;
			$w['and']["{$this->name}.del_flg"]=0;
			$w['and']["{$this->name}.use_flg"]=1;
			
			# 使うフィールドでも非表示の場合があるので
			$w['and']["{$this->name}.view_flg"]=1;
			$w[]="{$this->name}.group_id != 0";
			if(!$res=$this->find('all',array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order))){
				return array();
			}
			return $res;
		}
		
		
		#
		# @author Kiyosawa 
		# @date 
		function getUseFieldsByGroup($group_id){
			
			$w=null;
			$w['and']["{$this->name}.group_id"]=$group_id;
			$w['and']["{$this->name}.del_flg"]=0;
			$w['and']["{$this->name}.use_flg"]=1;
			if(!$res=$this->find('all',array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order))){
				return array();
			}
			return $res;
		}
		
}