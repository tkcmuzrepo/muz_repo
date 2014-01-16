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

class MuzHomesController extends AppController{
	
	public $name = 'MuzHomes';
	var $uses = array("MuzMasterAccount");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		$allow_action=array('logout');
		if(!in_array($this->params['action'],$allow_action) AND !$this->login_user){
			$this->redirect("/muz_logins");
		}
	}
	
	
	# ■ログイン
	# @author Kiyosawa 
	# @date 
	function lists(){
		
		# アカウント情報
		$users=ClassRegistry::init("MuzMasterAccount")->findAllByClientId($this->login_user['MuzMasterAccount']['client_id']);
		$user_names=Set::combine($users,"{n}.MuzMasterAccount.id","{n}.MuzMasterAccount.name");
		$account_ids=Set::extract($users,"{}.MuzMasterAccount.id");
		
		# ログイン履歴
		ClassRegistry::init("MuzLoginLog")->order="MuzLoginLog.created DESC";
		ClassRegistry::init("MuzLoginLog")->limit=20;
		$login_logs=ClassRegistry::init("MuzLoginLog")->findAllByAccountId($account_ids);
		
		# 月別
		$month=-6;
		$month_regist_logs=ClassRegistry::init("MuzUser")->findAllByClientIdAndMonthOverCount($this->login_user['MuzMasterAccount']['client_id'],$month);
		
		# 日別
		$day=-6;
		$day_regist_logs=ClassRegistry::init("MuzUser")->findAllByClientIdAndDayOverCount($this->login_user['MuzMasterAccount']['client_id'],$day);
		$this->set(compact('user_names','login_logs','month_regist_logs','day_regist_logs'));
	}
	
	function index(){
		exit;
	}
	
	# ■ログアウト
	# @author Kiyosawa 
	# @date 
	function logout(){
		
		if(!$this->Session->read('login_id')){
			$this->redirect("/muz_login/");
		}
		
		# ログイン履歴
		ClassRegistry::init("MuzLoginLog")->saveLog($this->login_user['MuzMasterAccount']['id'],2);
		
		$this->_clearSession();
		$this->redirect("./index");
	}
	
	# ■セッションの破棄
	# @author Kiyosawa 
	# @date 
	function _clearSession(){
		
		$_SESSION = array();
		
		$request_directory=trim($_SERVER['REQUEST_URI'],'/');
		$explode=explode("/",$request_directory);
		
		if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(),'',time()-42000,"/{$explode[0]}");
		}
		session_destroy();
		
		$this->Session->destroy();
		$this->Session->write('login_id','');
	}
	
}