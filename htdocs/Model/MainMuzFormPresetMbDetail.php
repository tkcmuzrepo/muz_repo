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
class MainMuzFormPresetMbDetail extends AppModel {

		var $name='MuzFormPresetMbDetail';
		var $userTable='muz_form_preset_mb_details';
		var $primaryKey='id';
		
		var $hasMany = array(
			"MuzFormPresetValue" => array(
				"className" => "MuzFormPresetValue",
				"foreignKey" => "preset_detail_id",
				"dependent" => false,
				"conditions" => "",
				"fields" => "",
				"order" => "",
				"limit" => "",
				"offset" => "",
				"exclusive" => "",
				"finderQuery" => "",
				"counterQuery" => "",
			),
		);
		
		#
		# @author Kiyosawa 
		# @date 
		function findAllByPresetId($preset_ids=array()){
			
			$w=null;
			$w['and']["{$this->name}.preset_id"]=$preset_ids;
			return $this->find("all",array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order));
		}
		
}