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
class MainMuzLoginLog extends AppModel {

		var $name='MuzLoginLog';
		var $userTable='muz_login_logs';
		var $primaryKey='id';
		
		
		# ■ログイン履歴
		# @author Kiyosawa 
		# @date 
		function saveLog($account_id,$action=1){
			
			$save[$this->name]['account_id']=$account_id;
			$save[$this->name]['action']=$action;
			$this->unbindFully();
			$res=$this->save($save);
			return $res;
		}
		
		
		# ■アカウントIDから
		# @author Kiyosawa 
		# @date 
		function findAllByAccountId($account_ids=array()){
			
			if(empty($account_ids)) return false;
			
			$w=null;
			$w['and']['MuzLoginLog.account_id']=$account_ids;
			$login_logs=$this->find('all',array('conditions'=>$w,'fields'=>$this->field,'limit'=>$this->limit,'order'=>$this->order));
			return $login_logs;
		}
}