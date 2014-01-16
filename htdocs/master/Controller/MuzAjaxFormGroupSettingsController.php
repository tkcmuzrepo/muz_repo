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

class MuzAjaxFormGroupSettingsController extends AppController{

	public $name = 'MuzAjaxFormGroupSettings';
	public $components=array('AjaxData');
	public $uses = array("MuzFormGroupSetting");
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
		
		try{
			$this->res['form_id']=$this->data['MuzFormGroupSetting']['form_id'];
			$this->res['date_key']=$this->data['MuzFormGroupSetting']['date_key'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['preview']='YES';
		if(!$this->AjaxData->previewDataCopyExec($this->res['form_id'],$this->res['date_key'])){
			$this->res['preview']='NO';
		}
	}
	
	function index(){
	}
	
	
	# ■グループの使用未使用の設定
	# ■プレビューの設定はあり
	# ■C-5
	# @author Kiyosawa 
	# @date 
	function dragEnd(){
		
		# view_flg : 移動後の状態が送られてくる
		try{
			$this->res['view_flg']=$datas['view_flg']=$this->data['MuzFormGroupSetting']['view_flg'];
			$this->res['group_id']=$datas['group_id']=$this->data['MuzFormGroupSetting']['group_id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		if(!$group=ClassRegistry::init("MuzFormGroupSetting")->findById($this->res['group_id'])){
			
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		# プレビュー側へ保存
		$save['MuzPreviewFormGroupSetting']['id']=$this->res['group_id'];
		$save['MuzPreviewFormGroupSetting']['view_flg']=$this->res['view_flg'];
		if(!ClassRegistry::init("MuzPreviewFormGroupSetting")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		# 成功
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■フィールドの生成
	# @author Kiyosawa 
	# @date 
	function makeGroup(){
		
		try{
			$this->res['group_title']=$datas['group_title']=$this->data['MuzFormGroupSetting']['group_title'];
			$this->res['group_sub_title']=$datas['group_sub_title']=$this->data['MuzFormGroupSetting']['group_sub_title'];
			$datas['form_id']=$this->res['form_id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec(array($datas['group_title']));
		
		# 保存処理
		$save['MuzPreviewFormGroupSetting']=$datas;
		ClassRegistry::init("MuzPreviewFormGroupSetting")->create();
		if(!$save_group=ClassRegistry::init("MuzPreviewFormGroupSetting")->save($save)){
			$this->AjaxData->notDbSave();
		}
		
		# 成功
		$this->res['group_id']=ClassRegistry::init("MuzPreviewFormGroupSetting")->getLastInsertID();
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->res['view_flg']=$save_group['MuzPreviewFormGroupSetting']['view_flg'];
		$this->AjaxData->successResponse($this->res);
	}
	
	# ■グループ削除
	# @author Kiyosawa 
	# @date 
	function groupRemove(){
		
		try{
			$this->res['group_id']=$datas['group_id']=$this->data['MuzFormGroupSetting']['group_id'];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		# 空
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		$datas['del_flg']=1;
		$save['MuzPreviewFormGroupSetting']=$datas;
		
		if(!ClassRegistry::init("MuzPreviewFormGroupSetting")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		# 成功
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
}