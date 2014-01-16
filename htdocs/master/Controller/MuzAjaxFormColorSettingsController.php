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

class MuzAjaxFormColorSettingsController extends AppController{

	public $name = 'MuzAjaxFormColorSettings';
	public $components=array('AjaxData');
	public $uses = array("MuzFormFieldSetting","MuzFormFieldSettingDetail","MuzFormGroupSetting","MuzFormColorSetting");
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
			$this->res['form_id']=$this->data['MuzFormColorSetting']['form_id'];
			$this->res['date_key']=$this->data['MuzFormColorSetting']['date_key'];
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
		exit;
	}
	
	# ■色を変更したとき
	# ■プレビューへ保存します
	# @author Kiyosawa 
	# @date 
	function color_edit(){
		
		# カラーコード
		try{
			$color_code_ary=$this->data['MuzFormColorSetting']['color'];
			$this->res['color_code']=current(array_keys($color_code_ary));
			$this->res['color_code_value']=$color_code_ary[$this->res['color_code']];
		}catch(Exception $e){
			$this->AjaxData->setError(10,__LINE__);
			$this->AjaxData->response();
		}
		
		$colums=ClassRegistry::init("MuzPreviewFormColorSetting")->getColumnTypes();
		
		# 存在しないステータス
		if(!isset($colums[$this->res['color_code']])){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		# 存在しない
		if(!$color_setting=ClassRegistry::init("MuzPreviewFormColorSetting")->findByFormId($this->res['form_id'])){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$datas[$this->res['color_code']]=$this->res['color_code_value'];
		$datas['id']=$color_setting['MuzPreviewFormColorSetting']['id'];
		ClassRegistry::init("MuzPreviewFormColorSetting")->save($datas);
		$this->AjaxData->successResponse($this->res);
	}
	
}