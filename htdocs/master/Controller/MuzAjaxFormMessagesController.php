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

class MuzAjaxFormMessagesController extends AppController{

	public $name = 'MuzAjaxFormMessagesController';
	public $components=array('AjaxData');
	public $uses = array("MuzFormMessage");
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
		
		try{
			$date_key=$this->data['MuzFormMessage']["date_key"];
			$form_id =$this->data['MuzFormMessage']["form_id"];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['form_id']=$form_id;
		$this->res['date_key']=$date_key;
		$this->res['preview']='YES';
		if(!$this->AjaxData->previewDataCopyExec($form_id,$date_key)){
			$this->res['preview']='NO';
		}
	}
	
	function index(){
		exit;
	}
	
	# ■注意文の新規保存
	# @author Kiyosawa 
	# @date 
	function saveMessage(){
		
		$datas['form_id']=$this->res['form_id'];
		$datas['message']=$this->data['MuzFormMessage']['name'];
		$datas['owner_id']=$this->login_user['MuzMasterAccount']['id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		$save['MuzPreviewFormMessage']=$datas;
		if(!$save_data=ClassRegistry::init("MuzPreviewFormMessage")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		# 成功
		$this->res['message_id']=ClassRegistry::init("MuzPreviewFormMessage")->getLastInsertID();
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■注意文の
	# @author Kiyosawa 
	# @date 
	function editMessage(){
		
		$datas['form_id']=$this->res['form_id'];
		$this->res['message']=$datas['message']=$this->data['MuzFormMessage']['name'];
		$this->res['owner_id']=$datas['owner_id']=$this->login_user['MuzMasterAccount']['id'];
		$this->res['message_id']=$datas['id']=$this->data['MuzFormMessage']['message_id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		$save['MuzPreviewFormMessage']=$datas;
		if(!$save_data=ClassRegistry::init("MuzPreviewFormMessage")->save($save)){
			
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■表示、非表示の切り替え
	# @author Kiyosawa 
	# @date 
	function viewEdit(){
		
		$this->res['message_id']=$datas['id']=$this->data['MuzFormMessage']['message_id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		if(!$message=ClassRegistry::init("MuzPreviewFormMessage")->findByIdAndDelFlg($datas['id'],0)){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		$datas['view_flg']=(empty($message['MuzPreviewFormMessage']['view_flg']))?1:0;
		$datas['owner_id']=$this->login_user['MuzMasterAccount']['id'];
		$save['MuzPreviewFormMessage']=$datas;
		ClassRegistry::init("MuzPreviewFormMessage")->create();
		if(!$res=ClassRegistry::init("MuzPreviewFormMessage")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['view_flg']=$datas['view_flg'];
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■注意文の削除
	# @author Kiyosawa 
	# @date 
	function deleteMessage(){
		
		$this->res['message_id']=$datas['id']=$this->data['MuzFormMessage']['message_id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		$datas['del_flg']=1;
		$save['MuzPreviewFormMessage']=$datas;
		if(!$save_data=ClassRegistry::init("MuzPreviewFormMessage")->save($save)){
			
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		$this->AjaxData->successResponse($this->res);
	}
	
}