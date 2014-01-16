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

class MuzAjaxPreviewsController extends AppController{

	public $name = 'MuzAjaxPreviewsController';
	public $components=array('AjaxData');
	public $uses = array("MuzForm");
	private $admin_level=array(
		
		0=>2, # admin
		1=>1  # master
	);
	
	private $res=array();
	
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
	
	# ■リストアします
	# @author Kiyosawa 
	# @date 
	function restore_exec(){
		
		try{
			$this->res['hash']=$hash=$this->data['MuzPreview']['hash'];
			$this->res['date_key']=$date_key=$this->data['MuzPreview']['date_key'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		if(!$flg=$this->requestAction("/muz_previews/restore_exec/{$hash}/{$date_key}")){
			$this->AjaxData->setError(12,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
}