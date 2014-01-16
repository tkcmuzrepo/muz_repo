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

class AjaxsController extends AppController{
	
	public $name = 'Ajaxs';
	public $uses = array("MuzFormFieldSetting","MuzFormFieldSettingDetail","MuzFormGroupSetting","MuzFormColorSetting");
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
	}
	
	function index(){
	}
	
	# ■グループの順番を変更した時
	# @author Kiyosawa 
	# @date 
	function group_sort(){
	}
	
	# ■フィールドの順番を変更した時
	# @author Kiyosawa 
	# @date 
	function field_sort(){
		
	}
	
	# ■フィールドの内容を編集した時
	# @author Kiyosawa 
	# @date 
	function field_edit(){
	}
	
	# ■使用可能から未使用の所にドラッグが完了した時
	# @author Kiyosawa 
	# @date 
	function drag_end(){
	}
	
	# ■フィールドを新規作成した時
	# @author Kiyosawa 
	# @date 
	function new_field(){
		
	}
	
	# ■色の編集
	# @author Kiyosawa
	# @date 
	function color_edit(){
		
		$colors=array("form_title_color",
		               "auxiliary_color",
					   "note_color",
					   "all_bg_color",
					   "group_title_color"
					   "group_bg_color",
					   "form_title_color",
					   "form_bg_color",
					   "form_color",
					   "submit_btn_color"
					   );
					   
	}
	
}