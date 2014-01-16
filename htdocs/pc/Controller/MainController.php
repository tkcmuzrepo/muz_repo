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
	
	var $site='pc';
	
	
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