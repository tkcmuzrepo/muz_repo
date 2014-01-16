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

define("DEVELOPER","developer");
define("MASTER","master");
define("ADMIN","admin");


/*
require_once("Swift".DS."swift_required.php");

$text = "Hi!\nHow are you?\n";
$html="<center>ほげほげ</center>";
$html='';

$from = array('ksaiyo.musee@jin-co.jp'=>'ミュゼプラチナム採用事務局');

$to = array(
'zrx02@i.softbank.jp'=>'Destination 1 Name'
);
$subject = 'ほげほげ';

// Login credentials
$username = 'sgohcrfa@kke.com';
$password = 'hayahide4561';
 // Setup Swift mailer parameters
 $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net',587);
 $transport->setUsername($username);
 $transport->setPassword($password);
 $swift = Swift_Mailer::newInstance($transport);

 // Create a message (subject)
 $message = new Swift_Message($subject);

 // attach the body of the email
 $message->setFrom($from);
 $message->setBody($html,'text/html');
 $message->setTo($to);
 $message->addPart($text, 'text/plain');
 
 
 // send message 
 if ($recipients = $swift->send($message, $failures))
 {
     // This will let us know how many users received this message
     echo 'Message sent out to '.$recipients.' users';
 }
 // something went wrong =(
 else
 {
     echo "Something went wrong - ";
     print_r($failures);
 }
exit;
*/

/*
require_once("SendGrid.php");
require_once("Unirest.php");
SendGrid::register_autoloader();
require_once("SendGrid".DS."Email.php");
require_once("SendGrid".DS."SmtpapiHeaders.php");
require_once("SendGrid".DS."Api.php");
require_once("SendGrid".DS."EmailInterface.php");
require_once("SendGrid".DS."Smtp.php");


$sendgrid=new SendGrid('hayahide','hayahide4561');

$email    = new SendGrid\Email();
$email->addTo('zrx02@i.softbank.jp');
$email->setFrom('kiyosawa@ai-pacific.jp');
$email->setSubject('Subject goes here');
$email->setText('Hello World!');
//$sendgrid->web->send($email);

$sendgrid->smtp->send($email);
v($email);
*/

class AppController extends Controller {
		
		var $components = array("Session","Cookie","PostAnalysis");
		var $helpers=array('Form');
		
		public $data;
		
		function beforeFilter(){
			parent::beforeFilter();
			
			Configure::write('Security.level','low');
			
			/*
			v(class_exists('Collator'),1);
			echo phpinfo();
			exit;
			*/
			
			# basic認証
			basic_auth(MASTER_BASIC_ID,MASTER_BASIC_PASS);
			
			# 送信データ処理
			if(property_exists($this->params,'data')){
				$this->data=&$this->params->data;
			}
			
			# ログインアカウント
			$this->login_user=array();
			if($master_id=$this->Session->read('login_id')){
				$this->login_user=$login_user=ClassRegistry::init("MuzMasterAccount")->_getLoignAccount($master_id);
				if(!empty($this->login_user['MuzClient']['del_flg'])) exit;
			}
			
			# 権限を設定
			$this->_setAdminLevel();
			
			$base_url=MASTER_DOMAIN;
			
			# プレビュー用のKey
			$this->date_key=$date_key=date('YmdHis');
			$this->set(compact('base_url','login_user','date_key'));
		}
		
		#
		# @author Kiyosawa 
		# @date 
		function _testReturn(){
			
			header("Content-Type:application/json;charset=utf-8");
			echo json_encode($_POST);
			exit;
		}
		
		# ■権限を設定
		# @author Kiyosawa 
		# @date 
		function _setAdminLevel(){
			
			$this->admin_level='';
			switch(true){
				case($this->_isDeveloper()):
				$this->admin_level=DEVELOPER;
			break;
				case($this->_isMaster()):
				$this->admin_level=MASTER;
			break;
				case($this->_isAdmin()):
				$this->admin_level=ADMIN;
			}
			
			$this->set('admin_level',$this->admin_level);
		}
		
		# ■セッションの破棄
		# @author Kiyosawa 
		# @date 
		function _clearSession(){
			
			$_SESSION = array();
			
			$request_directory=trim($_SERVER['REQUEST_URI'],'/');
			$explode=explode("/",$request_directory);
			
			if(isset($_COOKIE[session_name()])){
			    setcookie(session_name(),'',time()-42000,"/{$explode[0]}");
			}
			session_destroy();
			
			$this->Session->destroy();
			$this->Session->write('login_id','');
		}
		
		# ■開発者か
		# @author Kiyosawa 
		# @date 	
		function _isDeveloper(){
			
			if(empty($this->login_user)) return false;
			if($this->login_user['MuzMasterAccount']['admin_level']!=0) return false;
			return true;
		}
		
		# ■管理者か
		# @author Kiyosawa 
		# @date 
		function _isMaster(){
			
			if(empty($this->login_user)) return false;
			if($this->login_user['MuzMasterAccount']['admin_level']!=1) return false;
			return true;
		}
		
		# ■店舗の方か
		# @author Kiyosawa 
		# @date 
		function _isAdmin(){
			
			if(empty($this->login_user)) return false;
			if($this->login_user['MuzMasterAccount']['admin_level']!=2) return false;
			return true;
		}
		
		# ■フィールドのタイプを取得する
		# ■normal_ : 通常のフィールド
		# ■preset_ : プリセット
		# ■上記の文字列以降の文字がフィールドのタイプとなるルール
		# @author Kiyosawa 
		# @date 
		function _getFieldType($type){
		
			$ary=explode('_',$type);
			if(!isset($ary[1])) return false;
			return $ary[1];
		}
		
		# ■プリセットか
		# @author Kiyosawa 
		# @date 
		function _isPresetByFieldType($type){
		
			$ary=explode('_',$type);
			if(!isset($ary[0])) return false;
			return $ary[0]=='preset';
		}
		
		# ■Viewに表示するフィールドを生成
		# @author Kiyosawa 
		# @date 
		function _sprintf($format,$fields,$s="%s",$string=''){
		
			$field=array_shift($fields);
			$end_index=mb_strpos($format,'%s')+mb_strlen($s);
		
			# 置換対象
			$change=mb_substr($format,0,$end_index);
		
			# 置換後
			$format=mb_substr($format,$end_index);
			$string.=str_replace($s,$field,$change);
		
			if(!empty($fields)){
				$string=$this->_sprintf($format,$fields,$s,$string);
			}
		
			if(!is_numeric(strpos($format,$s))){
				$string.=$format;
			}
			return $string;
		}
		
}
