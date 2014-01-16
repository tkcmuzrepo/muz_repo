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

require_once(CLASS_DIR."form_base".DS."textbox.php");
require_once(CLASS_DIR."form_base".DS."selectbox.php");
require_once(CLASS_DIR."form_base".DS."checkbox.php");
require_once(CLASS_DIR."form_base".DS."radiobox.php");
require_once(CLASS_DIR."form_base".DS."textarea.php");

define("DEVELOPER","developer");
define("MASTER","master");
define("ADMIN","admin");

class AppController extends Controller {
		
		var $components = array("Session","Cookie","PostAnalysis");
		var $helpers=array('Form');
		
		public $data;
		
		function beforeFilter(){
			parent::beforeFilter();
			
			Configure::write('Security.level','low');
			
			# 送信データ処理
			if(property_exists($this->params,'data')){
				$this->data=&$this->params->data;
			}
			
			$base_url=MB_DOMAIN;
			$this->set(compact('base_url'));
		}
		
}
