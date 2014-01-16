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
class MainMuzUserRegistData extends AppModel {

		var $name='MuzUserRegistData';
		var $useTable='muz_user_regist_datas';
		var $primaryKey='id';
		
		
	#
	# @author Kiyosawa 
	# @date 
	function findAllByFormIdAndFieldID($form_ids=array(),$field_ids=array()){
		
		$w=null;
		$w['and']["{$this->name}.form_id"]=$form_ids;
		$w['and']["{$this->name}.field_id"]=$field_ids;
		$user_regist_data=ClassRegistry::init($this->name)->findAll($w);
		return $user_regist_data;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function findAllByUserId($user_ids=array()){
		
		$w=null;
		$w['and']["{$this->name}.user_id"]=$user_ids;
		$regist_data=ClassRegistry::init($this->name)->findAll($w);
		return $regist_data;
	}
}