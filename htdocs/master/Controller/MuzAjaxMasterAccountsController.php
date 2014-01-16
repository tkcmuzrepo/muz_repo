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

class MuzAjaxMasterAccountsController extends AppController{

	public $name = 'MuzAjaxMasterAccounts';
	public $components=array('AjaxData');
	public $uses = array("MuzMasterAccount");
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
	}
	
	# ■ユーザアカウント作成
	# @author Kiyosawa 
	# @date 
	function account(){
		
		try{
			$this->res['name']=$user_datas['name']=$this->data['MuzMasterAccount']['name'];
			$this->res['login_id']=$user_datas['login_id']=$this->data['MuzMasterAccount']['login_id'];
			$this->res['login_pass']=$user_datas['login_pass']=$this->data['MuzMasterAccount']['login_pass'];
			$this->res['login_pass_conf']=$user_datas['login_pass_conf']=$this->data['MuzMasterAccount']['login_pass_conf'];
			$this->res['admin_level']=$user_datas['admin_level']=$this->data['MuzMasterAccount']['master_flg'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($user_datas);
		
		# 一致
		$this->AjaxData->isEqualAfterResponseExec(array($user_datas['login_pass'],$user_datas['login_pass_conf']),1);
		
		# IDの存在
		if(ClassRegistry::init("MuzMasterAccount")->isSameAccount($user_datas['login_id'],$this->login_user['MuzMasterAccount']['client_id'])){
			
			$this->AjaxData->setError(3,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$user_datas['client_id']=$this->login_user['MuzMasterAccount']['client_id'];
		$user_datas['admin_level']=$this->admin_level[$user_datas['admin_level']];
		$save['MuzMasterAccount']=$user_datas;
		if(!ClassRegistry::init("MuzMasterAccount")->save($save)){
			$this->AjaxData->notDbSave();			
		}
		
		# 成功
		$this->res['account_id']=ClassRegistry::init("MuzMasterAccount")->getLastInsertID();
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■アカウントの編集
	# @author Kiyosawa 
	# @date 
	function accountEdit(){
		
		try{
			$this->res['name']=$user_datas['name']=$this->data['MuzMasterAccount']['name'];
			$this->res['login_id']=$user_datas['login_id']=$this->data['MuzMasterAccount']['login_id'];
			$this->res['login_pass']=$user_datas['login_pass']=$this->data['MuzMasterAccount']['login_pass'];
			$this->res['account_id']=$user_datas['id']=$this->data['MuzMasterAccount']['account_id'];
			$this->res['status']='YES';
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($user_datas);
		
		# IDの存在
		if(ClassRegistry::init("MuzMasterAccount")->isSameAccount($user_datas['login_id'],$this->login_user['MuzMasterAccount']['client_id'])){
			$this->AjaxData->setError(3,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$save['MuzMasterAccount']=$user_datas;
		if(!ClassRegistry::init("MuzMasterAccount")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	
	# ■アカウントの削除
	# @author Kiyosawa 
	# @date 
	function accountDelete(){
		
		try{
			$this->res['account_id']=$user_datas['id']=$this->data['MuzMasterAccount']['account_id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($user_datas);
		
		# 確認
		if(!$account=ClassRegistry::init("MuzMasterAccount")->findByIdAndClientId($user_datas['id'],$this->login_user['MuzMasterAccount']['client_id'])){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$user_datas['del_flg']=1;
		$save['MuzMasterAccount']=$user_datas;
		if(!ClassRegistry::init("MuzMasterAccount")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
}