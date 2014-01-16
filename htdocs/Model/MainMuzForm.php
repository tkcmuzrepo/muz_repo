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
class MainMuzForm extends AppModel {

		var $name='MuzForm';
		var $userTable='muz_forms';
		var $primaryKey='id';
		
		# ■クライアントでの
		# @author Kiyosawa 
		# @date 
		function findAllByClientID($client_id){
			
			$w=null;
			$w['and']["{$this->name}.client_id"]=$client_id;
			$w['and']["{$this->name}.del_flg"]=0;
			$res=$this->find('all',array('conditions'=>$w,'limit'=>$this->limit,'order'=>$this->order,'fields'=>$this->field));
			$this->__clear();
			return $res;
		}
		
		
		#
		# @author Kiyosawa 
		# @date 
		function findFormTitles($client_id){
			
			$data=$this->findAllByClientID($client_id);
			return Set::combine($data,"{n}.{$this->name}.id","{n}.{$this->name}.title");
		}
		
		
		# ■Hashから
		# @author Kiyosawa 
		# @date 
		function findByHash($hash){
			
			$w['and']["{$this->name}.hash"]=$hash;
			$w['and']["{$this->name}.del_flg"]=0;
			if(!$res=$this->find('first',array('conditions'=>$w))){
				$this->findByStack[$this->name]=array();
				return false;
			}
			$this->findByStack[$this->name]=$res[$this->name];
			return $res;
		}
		
}