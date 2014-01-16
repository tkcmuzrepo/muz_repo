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

class MuzAjaxFormHtmlSettingsController extends AppController{

	public $name = 'MuzAjaxFormHtmlSettings';
	public $components=array('AjaxData');
	public $uses = array("MuzForm","MuzFormHtmlSetting");
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
		
		$this->res['form_id']=$this->data['MuzFormHtmlSetting']['form_id'];
		$this->res['date_key']=$this->data['MuzFormHtmlSetting']['date_key'];
		$this->res['preview']='YES';
		if(!$this->AjaxData->previewDataCopyExec($this->res['form_id'],$this->res['date_key'])){
			$this->res['preview']='NO';
		}
		
	}
	
	function index(){
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _sitePrefix($site){
		$prefix=($site=='pc')?'':"{$site}_";
		return $prefix;
	}
	
	# ■応募後ページ内容
	# @author Kiyosawa 
	# @date 
	function html_after_edit(){
			
		$this->res['site']=$this->data['MuzFormHtmlSetting']['site'];
		
		$prefix=$this->_sitePrefix($this->res['site']);
		$key_name="{$prefix}after_page_html";
		$this->res[$key_name]=$datas[$key_name]=$this->data['MuzFormHtmlSetting'][$key_name];
		
		$datas['form_id']=$this->res['form_id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		if(!$html_setting=ClassRegistry::init("MuzFormHtmlSetting")->findByFormId($this->res['form_id'])){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$datas['id']=$html_setting['MuzFormHtmlSetting']['id'];
		$save['MuzPreviewFormHtmlSetting']=$datas;
		
		if(!ClassRegistry::init("MuzPreviewFormHtmlSetting")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function html_header_edit(){
		
		$this->res['site']=$this->data['MuzFormHtmlSetting']['site'];
		
		$prefix=$this->_sitePrefix($this->res['site']);
		$key_name="{$prefix}header_html";
		$this->res[$key_name]=$datas[$key_name]=$this->data['MuzFormHtmlSetting'][$key_name];
		
		$datas['form_id']=$this->res['form_id'];
		
		# 空
		$datas=$this->AjaxData->trim($datas);
		$this->AjaxData->isEmptyAfterResponseExec($datas);
		
		if(!$html_setting=ClassRegistry::init("MuzFormHtmlSetting")->findByFormId($form_id)){
			$this->AjaxData->setError(7,__LINE__);
			$this->AjaxData->response();
		}
		
		# 保存処理
		$datas['id']=$html_setting['MuzFormHtmlSetting']['id'];
		$save['MuzPreviewFormHtmlSetting']=$datas;
		if(!ClassRegistry::init("MuzPreviewFormHtmlSetting")->save($save)){
			$this->AjaxData->setError(4,__LINE__);
			$this->AjaxData->response();
		}
		
		$this->res['modified']=date("Y/m/d H:i:s");
		$this->AjaxData->successResponse($this->res);
	}
	
}