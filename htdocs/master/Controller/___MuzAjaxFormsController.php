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

class MuzAjaxFormsController extends AppController{

	public $name = 'MuzAjaxFormsController';
	public $components=array('AjaxData');
	public $uses = array("MuzFormg");
	private $admin_level=array(
		
		0=>2, # admin
		1=>1  # master
	);
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		
		#Configure::write('debug',0);

		# 送信データ処理
		if(property_exists($this->params,'data')){
			$this->data=&$this->params->data;
		}
		
		if(!$login_id=$this->Session->read('login_id')){
			$this->AjaxData->setError(2,__LINE__);
			$this->AjaxData->response();
		}
		$this->login_user=ClassRegistry::init("MuzMasterAccount")->_getLoignAccount($login_id);
	}
	
	function index(){
		exit;
	}
	
	
	# ■フォームの新規作成
	# @author Kiyosawa 
	# @date 
	function saveForm(){
		
		$form_datas['name']=$this->data['MuzForm']['title'];
		$form_datas['hash']=$this->data['MuzForm']['hash'];
		$grouup_datas['group_title']=$this->data['MuzFormGroupSetting']['group_title'];
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($form_datas);
		$this->AjaxData->isEmptyAfterResponseExec($grouup_datas);
		
		# begin
		$datasource=ClassRegistry::init("MuzForm")->getDataSource();
		$datasource->begin();
		
		# 重複確認(hash)
		if(ClassRegistry::init("MuzForm")->findByClientIdAndHashAndDelFlg($this->login_user['MuzMasterAccount']['client_id'],$form_datas['hash'],1)){
			$this->AjaxData->setError(11,__LINE__);
			$this->AjaxData->response();
		}
		
		$form_datas['client_id']=$this->login_user['MuzMasterAccount']['client_id'];
		$form_save['MuzForm']=$form_datas;
		if(!$form=ClassRegistry::init("MuzForm")->save($form_save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		# 重複許可(title)
		$grouup_datas['form_id']=ClassRegistry::init("MuzForm")->getLastInsertID();
		if(!$group=ClassRegistry::init("MuzFormGroupSetting")->save($grouup_datas)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		$datasource->commit();
		$res['form_id']=$grouup_datas['form_id'];
		$res['group_id']=ClassRegistry::init("MuzFormGroupSetting")->getLastInsertID();
		$this->AjaxData->successResponse();
	}
	
}