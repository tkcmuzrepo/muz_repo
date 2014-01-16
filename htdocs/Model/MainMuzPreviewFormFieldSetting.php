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

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */

require_once(MODELS."MainMuzFormFieldSetting.php");

class MainMuzPreviewFormFieldSetting extends MainMuzFormFieldSetting{

		var $name='MuzPreviewFormFieldSetting';
		var $userTable='muz_preview_form_field_settings';
		var $primaryKey='id';
		
		var $hasOne = array(
			'MuzPreviewFormFieldSettingDetail' =>array(
				'className' => 'MuzPreviewFormFieldSettingDetail',
				'foreignKey' => 'field_id',
				'conditions' => '',
				'order' => '',
				'dependent' => true,
			),
		);
		
		var $hasMany = array(
			'MuzPreviewFormValueSetting' =>array(
				'className' => 'MuzPreviewFormValueSetting',
				'foreignKey' => 'field_id',
				'conditions' => '',
				'order' => '',
				'dependent' => true,
			),
		);
		
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