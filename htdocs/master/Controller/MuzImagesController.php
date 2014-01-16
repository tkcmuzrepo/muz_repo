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

class MuzImagesController extends AppController{
	
	public $components=array('FileUpload','AjaxData');
	public $name = 'MuzImages';
	public $uses = array('MuzFormImage');
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(empty($this->login_user)){
			$this->redirect("/muz_logins");
		}
	}
	
	
	# ■保存先ディレクトリ名
	# @author Kiyosawa 
	# @date 
	function _dirname($path){
		
		$path_ary=explode(DS,dirname($path));
		return $path_ary[count($path_ary)-1];
	}
	
	# ■保存ファイル名
	# @author Kiyosawa 
	# @date 
	function _filename($path){
		return basename($path);
	}
	
	# ■ローカルに保存後Azureへ保存を実行します
	# @author Kiyosawa 
	# @date 
	function index(){
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _setDateKey($date_key=''){
		
		# 上書き(非同期ではない)
		if(!empty($date_key)){
			$this->date_key=$date_key;
		}else{
			$date_key=$this->date_key;
		}
		$this->set(compact('date_key'));
		return $date_key;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function images($form_id='27',$date_key=''){
		
		$date_key=$this->_setDateKey($date_key);
		
		# upload 処理
		$this->set(compact('form_id'));
		if(!$this->FileUpload->is_set('data')){
			return false;
		}
		
		if(!$this->FileUpload->validate('data')){
			return false;
		}
		
		$upload_dir=USER_DATA.HEADER_IMG_BLOB.DS;
		if(!$res=$this->FileUpload->upload("data",$upload_dir,false,false ,271,100)){
			return false;
		}
		
		$container_name=$this->_dirname($res);
		$file_name=$this->_filename($res);
		
		# Azureへの画像保存
		$azure_storage=new WinBlobStorage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
		$azure_storage->setPublic($container_name);
		$azure_storage->putContents($container_name,$file_name,$res);
		
		# プレビュー処理(全体コピーしているので暇あれば要カスタマイズ)
		if(!$this->requestAction("/muz_previews/imagePreview/{$form_id}/{$date_key}")){
			return false;
		}
		
		# プレビューへ保存
		# 一時的にCake主キー変更
		$save['MuzPreviewFormImage']['form_id']=$form_id;
		$save['MuzPreviewFormImage']['image_path']=basename($res);
		ClassRegistry::init("MuzPreviewFormImage")->primaryKey='form_id';
		$res=ClassRegistry::init("MuzPreviewFormImage")->save($save);
		return $save['MuzPreviewFormImage']['image_path'];
	}
	
}