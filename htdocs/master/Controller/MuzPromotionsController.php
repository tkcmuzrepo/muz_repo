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

class MuzPromotionsController extends AppController{
	
	public $name = 'MuzPromotions';
	var $uses = array("MuzPromotionSetting");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
		
		if(!$this->login_user){
			$this->redirect("/muz_logins/");
		}
		
	}
	
	# F-1 広告コード管理
	# @author Kiyosawa 
	# @date 
	function lists(){
		
		if($this->data){
			$postData=array_map('trim',$this->data['MuzPromotionSetting']);
			if($this->_promotionSave($postData['promotion_code'],$postData['name'])){
				$this->redirect("lists");
			}
		}
		
			
		# クライアント
		$clients=ClassRegistry::init("MuzMasterAccount")->findAllByIdAndDelFlg($this->login_user['MuzMasterAccount']['id'],0);
		$client_ids=Set::extract($clients,"{}.MuzMasterAccount.id");
		
		# paging
		$w=null;
		$w['and']['MuzPromotionSetting.owner_id']=$client_ids;
		$w['and']['MuzPromotionSetting.del_flg']=0;
		$this->paginate=array('conditions'=>$w,'limit'=>100,'order'=>'MuzPromotionSetting.created DESC');
		$promotions=$this->paginate('MuzPromotionSetting');
		$this->set(compact('promotions'));
	}
	
	function index(){
		exit;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function _promotionSave($code,$title){
		
		$save['promotion_code']=$code;
		$save['name']=$title;
		$save['owner_id']=$this->login_user['MuzMasterAccount']['id'];
		return ClassRegistry::init("MuzPromotionSetting")->save($save);
	}
	
}