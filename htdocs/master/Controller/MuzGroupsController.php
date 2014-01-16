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

class MuzGroupsController extends AppController{
	
	public $components=array('Session');
	public $name = 'MuzGroups';
	public $uses = array();
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		ini_set("memory_limit", -1);
		set_time_limit(0);
		
		if(empty($this->login_user)){
			$this->redirect("/muz_logins");
		}
	}
	
	# ■作成、管理
	# ■C-5
	# ■保存はAjax通信
	# @author Kiyosawa 
	# @date 
	function index(){
		exit;
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function lists($hash=''){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHash($hash)){
			exit;
		}
		
		# グループ
		ClassRegistry::init("MuzFormGroupSetting")->order="MuzFormGroupSetting.sort_number ASC";
		$_groups=ClassRegistry::init("MuzFormGroupSetting")->findAllByFormId($form['MuzForm']['id']);
		
		# 表示、非表示分け
		foreach($_groups as $k=>$v){
			$groups[$v['MuzFormGroupSetting']['view_flg']][]=$v['MuzFormGroupSetting'];
		}
		
		$this->set(compact('hash','groups','form'));
	}
	

}