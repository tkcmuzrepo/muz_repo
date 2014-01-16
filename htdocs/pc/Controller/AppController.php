<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller {
		
		var $components = array("Session","Cookie","PostAnalysis");
		var $helpers=array('Form');
		var $isPreview=false;
		
		public $data;
		
		function beforeFilter(){
			parent::beforeFilter();
			
			Configure::write('Security.level','low');
			
			# 送信データ処理
			if(property_exists($this->params,'data')){
				$this->data=&$this->params->data;
			}
			
			$base_url=PC_DOMAIN;
			$this->set(compact('base_url'));
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
			
			$_COOKIE=array();
			$this->Session->destroy();
			$this->Session->write('user_id','');
		}
		
		
	# ■プレビューであるか
	# @author Kiyosawa 
	# @date 
	function isPreview($hash,$date_key=''){
		
		$error_tsv=tsv("preview_error.tsv");
		
		# 形式が違う
		if(strpos($date_key,date('Ymd'))!==0 OR strlen($date_key)!==14){
			throw new Exception($error_tsv[3]);
		}
		
		# 誰かが別で更新している
		if(!$form_preview=ClassRegistry::init("MuzPreviewForm")->findByHash($hash) OR $form_preview['MuzPreviewForm']['date_key']>$date_key){
			throw new Exception($error_tsv[1]);
		}
		return true;
	}
	
	# ■プレビューの制限
	# @author Kiyosawa 
	# @date 
	function previewAction($hash,$date_key=''){
		
		if(empty($date_key)){
			$this->isPreview=false;
			$this->set('isPreview',false);
			return false;
		}
		
		try{
			$this->isPreview($hash,$date_key);
			$this->isPreview=true;
			$this->set('isPreview',$this->isPreview);
		}catch(Exception $e){
			$this->isPreview=false;
			$this->set('isPreview',$this->isPreview);
			return $e->getMessage();
		}
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function setPreview($hash,$dateKey){
		
		# プレビュー確認
		if($res=$this->previewAction($hash,$dateKey)){
			
			if(getType($res)!='boolean'){
				header("Content-type:text/plain;charset=utf-8");
				echo $res;
				exit;
			}
			
			if($this->site!='sp' AND isSp()){
				$redirectURL=sprintf("%s%s/%s/%s/%s",SMP_DOMAIN,$this->params['controller'],$this->params['action'],$hash,$dateKey);
				$this->redirect($redirectURL);
			}
			
			if($this->site!='mb' AND isMb()){
				$redirectURL=sprintf("%s%s/%s/%s/%s",MB_DOMAIN,$this->params['controller'],$this->params['action'],$hash,$dateKey);
				$this->redirect($redirectURL);
			}
			
			$this->FieldData->setPreview(true);
			$this->set(compact('dateKey'));
		}
	}
	
	
	# ■最終更新日でのETAG
	# @author Kiyosawa 
	# @date 
	function setEtag($hash){
		
		if(!$form=$this->FieldData->getFormDataByStorage($hash)) return;
		if(empty($form[$this->FieldData->getModelName('MuzForm')]['date_key'])) return;
		$date=$form[$this->FieldData->getModelName('MuzForm')]['date_key'];
		header("ETAG:{$date}");
		header("Last-Modified:".gmdate("D, d M Y H:i:s",strtotime($date))." GMT");
	}
}
