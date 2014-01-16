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
	private $res=array();
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
	}
	
	# ■新規追加
	# @author Kiyosawa 
	# @date 
	function promotionSave(){
		
		try{
			$promotion_datas['promotion_code']=$this->data['MuzPromotionSetting']['promotion_code'];
			$promotion_datas['name']=$this->data['MuzPromotionSetting']['name'];
			$promotion_datas['owner_id']=$this->login_user['MuzMasterAccount']['id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($promotion_datas);
		
		# IDの存在
		if(ClassRegistry::init("MuzPromotionSetting")->isSameCode($promotion_datas['promotion_code'])){
			
			$this->AjaxData->setError(5,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$save['MuzPromotionSetting']=$promotion_datas;
		if(!ClassRegistry::init("MuzPromotionSetting")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		# 成功
		$res['id']=ClassRegistry::init("MuzPromotionSetting")->getLastInsertID();
		$res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($res);
	}
	
	# ■編集
	# @author Kiyosawa 
	# @date 
	function promotionEdit(){
		
		try{
			$promotion_datas['promotion_code']=$this->data['MuzPromotionSetting']['promotion_code'];
			$promotion_datas['name']=$this->data['MuzPromotionSetting']['name'];
			$promotion_datas['owner_id']=$this->login_user['MuzMasterAccount']['id'];
			$promotion_datas['id']=$this->data['MuzPromotionSetting']['promotionid'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($promotion_datas);
		
		# IDの存在
		if(ClassRegistry::init("MuzPromotionSetting")->isSameCode($promotion_datas['promotion_code'])){
			
			$this->AjaxData->setError(5,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$save['MuzPromotionSetting']=$promotion_datas;
		if(!ClassRegistry::init("MuzPromotionSetting")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		# 成功
		$res['id']=$promotion_datas['id'];
		$res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($res);
	}
	
	
	# ■広告削除
	# @author Kiyosawa 
	# @date 
	function promotionRemove(){
		
		try{
			$promotion_datas['id']=$this->data['MuzPromotionSetting']['promotion_id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($promotion_datas);
		
		# 保存処理
		$save['MuzPromotionSetting']=$promotion_datas;
		$save['MuzPromotionSetting']['del_flg']=1;
		if(!ClassRegistry::init("MuzPromotionSetting")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		# 成功
		$res['promotion_id']=$promotion_datas['id'];
		$res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($res);
	}
	
}