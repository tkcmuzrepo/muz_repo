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

require_once(CONTROLLERS."TopMainController.php");
class MainController extends TopMainController{
	
	var $site='sp';
	
	# ■サイト別クラス
	# @author Kiyosawa 
	# @date 
	function __class($instance,$type){
		
		if($type==Checkbox::NAME){
			$user_class_name='radioinput';
			return $user_class_name;
		}
		
		return false;
	}
	
	# ■サイト別フィールドタイプ
	# @author Kiyosawa 
	# @date 
	function __type($type,$validate_type=array()){
		
		if($type==Text::NAME AND in_array(Text::VALID_NUMBER,$validate_type)){
			return 'tel';
		}
		
		return false;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	function term($hash,$date_key=''){
		
		if(!$form=ClassRegistry::init("MuzForm")->findByHashAndDelFlg($hash,0)){
			exit;
		}
		
		# プレビュー確認
		$this->setPreview($hash,$date_key);
		
		# 画像設定
		$this->_setImgPath($form[$this->FieldData->getModelName('MuzForm')]['id']);
		
		# ETAG
		$this->setEtag($hash);
		
		# 文字色
		$this->_setHtmlColor($form[$this->FieldData->getModelName('MuzForm')]['id']);
	}
	
}