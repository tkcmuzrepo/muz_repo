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

class MuzLoginsController extends AppController{
	
	public $name = 'MuzLogins';
	var $uses = array("MuzMasterAccount");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if($this->login_user){
			$this->redirect("/muz_homes");
		}
	}
	
	# ■ログイン
	# ■ログイン後履歴を記録する
	function index(){
		
		if(!$this->data){
			return;
		}
		
		$modelName=ClassRegistry::init("MuzMasterAccount")->name;
		$post=array_map('trim',$this->data[$modelName]);
		
		$w=null;
		$w['and']["{$modelName}.login_id"]  =$post['login_id'];
		$w['and']["{$modelName}.login_pass"]=$post['login_pass'];
		if(!$master=ClassRegistry::init("{$modelName}")->find('first',array('conditions'=>$w))){
			return;
		}
		
		# ログイン履歴
		ClassRegistry::init("MuzLoginLog")->saveLog($master[$modelName]['id']);
		
		$this->Session->write('login_id',$master[$modelName]['id']);
		$this->redirect("/muz_homes");
	}
}