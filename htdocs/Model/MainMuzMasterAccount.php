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
class MainMuzMasterAccount extends AppModel {

		var $name='MuzMasterAccount';
		var $userTable='muz_master_accounts';
		var $primaryKey='id';
		
		var $belongsTo = array(
			'MuzClient' =>array(
				'className' => 'MuzClient',
				'foreignKey' => 'client_id',
				'conditions' => '',
				'order' => '',
				'dependent' => true,
			),
		);
		
		
		# ■ログインアカウント
		# @author Kiyosawa 
		# @date 
		function _getLoignAccount($login_id){
			
			$w=null;
			$w['and']["{$this->name}.id"]=$login_id;
			$w['and']["{$this->name}.del_flg"]=0;
			$login=$this->find('first',array('conditions'=>$w));
			return $login;
		}
		
		
		# ■ユーザ一覧
		# @author Kiyosawa 
		# @date 
		function findAllByClientId($client_id){
			
			$w=null;
			$w['and']['MuzMasterAccount.client_id']=$client_id;
			$accounts=$this->findAll($w);
			return $accounts;
		}
		
		
		#
		# @author Kiyosawa 
		# @date 
		function findByLoginId($login_id,$client_id){
			
			if(empty($client_id) OR empty($login_id)) return array();
			
			$w=null;
			$w['and']["{$this->name}.login_id"]=$login_id;
			$w['and']["{$this->name}.client_id"]=$client_id;
			return $this->find('first',array('conditions'=>$w));
		}
		
		# ■同じアカウントがあるか
		# @author Kiyosawa 
		# @date 
		function isSameAccount($login_id,$client_id){
			
			if(!$account=$this->findByLoginId($login_id,$client_id)){
				return false;
			}
			
			# 同じであれば正とする
			if($account[$this->name]['login_id']=$login_id){
				return false;
			}
			
			return true;
		}
		
		#
		# @author Kiyosawa 
		# @date 
		function accountSave($datas=array()){
		
		}
		
}