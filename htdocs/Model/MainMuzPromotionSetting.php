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
class MainMuzPromotionSetting extends AppModel {
	
		var $name='MuzPromotionSetting';
		var $userTable='muz_promotion_settings';
		var $primaryKey='id';
		
		#
		# @author Kiyosawa 
		# @date 
		function findByPromotionCode($promotion_code){
			
			if(empty($promotion_code)) return array();
			
			$w=null;
			$w['and']["{$this->name}.promotion_code"]=$promotion_code;
			return $this->find('first',array('conditions'=>$w));
		}
		
		# ■同じプロモーションコードがあるか
		# @author Kiyosawa 
		# @date 
		function isSameCode($promotion_code){
			
			if(!$this->findByPromotionCode($promotion_code)){
				return false;
			}
			return true;
		}
		
		
}