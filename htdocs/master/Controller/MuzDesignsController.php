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

class MuzDesignsController extends AppController{
	
	public $name = 'MuzDesigns';
	var $uses = array("MuzFormColorSetting");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(empty($this->login_user)){
			$this->redirect("/muz_logins");
		}
	}
	
	
	# ■色の初期値
	# @author Kiyosawa 
	# @date 
	function _getColor($form_id){
		
		if($color_settings=ClassRegistry::init("MuzFormColorSetting")->findByFormId($form_id)){
			return $color_settings;
		}
		
		# createでデフォルトが設定される
		$save['MuzFormColorSetting']['form_id']=$form_id;
		ClassRegistry::init("MuzFormColorSetting")->create();
		return ClassRegistry::init("MuzFormColorSetting")->save($save);
	}
	
	# ■ログイン
	# ■ログイン後履歴を記録する
	function index($hash){
		exit;
	}
	
	# ■ログイン
	# ■ログイン後履歴を記録する
	function lists($hash,$date_key=''){
		
		# リダイレクトしてくるので再設定
		$date_key=(!empty($date_key))?$date_key:$this->date_key;
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHash($hash)){
			exit;
		}
		
		# 無ければ初期値を設定
		$color_settings=$this->_getColor($form['MuzForm']['id']);
		
		# image
		$image=ClassRegistry::init("MuzFormImage")->findByFormId($form['MuzForm']['id']);
		
		# upload (ここではプレビューとして保存)
		$is_upload_exec=(isset($this->data['UPLOAD']));
		if($is_upload_exec AND !$save_preview_image_file_name=$this->requestAction("/muz_images/images/{$form['MuzForm']['id']}/{$date_key}")){
			# upload_error
		}
		if($is_upload_exec) $image['MuzFormImage']['image_path']=$save_preview_image_file_name;
		
		# 初期値設定
		foreach($color_settings as $k=>$v){
			unset($color_settings[$k]);
			$color_settings[$k]['color']=$v;
		}
		$this->data=$color_settings;
		$this->set(compact('hash','form','date_key','image'));
	}
	
}