<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper','View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class MuzformHelper extends Helper{
	
	
	public function getFiledType($type){
		$ary=explode('_',$type);
		if(!isset($ary[1])) return false;
		return $ary[1];
	}
	
	public function isText($type){
		$type=$this->getFiledType($type);
		return $this->__isEqualType($type,'text');
	}
	
	public function isSelect($type){
		$type=$this->getFiledType($type);
		return $this->__isEqualType($type,'select');
	}
	
	public function isCheckbox($type){
		$type=$this->getFiledType($type);
		return $this->__isEqualType($type,'checkbox');
	}
	
	public function isRadio($type){
		$type=$this->getFiledType($type);
		return $this->__isEqualType($type,'radio');
	}
	
	private function __isEqualType($type,$input){
		$type=$this->getFiledType($type);
		return ($type==$input);
	}
	
	# ■Azureストレージから取得
	# @author Kiyosawa 
	# @date 
	function img_path($img=''){
		return STORAGE_BLOB_URL.HEADER_IMG_BLOB."/".$img;
	}
	
}