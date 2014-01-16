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

class MuzAccountsController extends AppController{
	
	public $name = 'MuzAccounts';
	var $uses = array("MuzMasterAccount");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(!$this->login_user){
			$this->redirect("/muz_logins/");
		}
		
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function index(){
		exit;
	}
	
	# F-2 ログイン情報管理
	function lists(){
		
		$users=ClassRegistry::init("MuzMasterAccount")->findAllByClientIdAndDelFlg($this->login_user['MuzMasterAccount']['client_id'],0);
		$this->set(compact('users'));
	}
	
	
}
