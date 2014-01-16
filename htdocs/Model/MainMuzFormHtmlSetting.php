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
class MainMuzFormHtmlSetting extends AppModel {

		var $name='MuzFormHtmlSetting';
		var $userTable='muz_form_html_settings';
		var $primaryKey='id';
		
		
		# ¡ƒtƒH[ƒ€ID‚©‚ç
		# @author Kiyosawa 
		# @date 
		function findByFormId($form_id){
			
			$w['and']["{$this->name}.form_id"]=$form_id;
			if(!$res=$this->find('first',array('conditions'=>$w))){
				$this->findByStack[$this->name]=array();
				return false;
			}
			$this->findByStack[$this->name]=$res[$this->name];
			return $res;
		}
		
}