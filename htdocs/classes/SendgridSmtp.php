<?php
	
require_once("Swift".DS."swift_required.php");
class SendgridSmtp{
	
	private $mailData=array();
	private $user='sgohcrfa@kke.com';
	private $pass='hayahide4561';
	private $smtp='smtp.sendgrid.net';
	
	function __construct($user='',$pass=''){
		
		if(!empty($user))$this->user=$user;
		if(!empty($pass))$this->pass=$pass;
		
		$default=array('body',
		               'html_body',
					   'from',
					   'from_title',
					   'to',
					   'subject');
					   
		foreach($default as $k=>$v){
			$this->mailData[$v]='';
		}
		
		try{$this->__checkPass();
		}catch(Exception $e){
			echo $e->getMessage();
			exit;
		}
	}
	
	# ■ユーザはアドレス形式
	# @author Kiyosawa 
	# @date 
	private function __checkPass(){
		if(empty($this->user)) throw new Exception('user empty');
		if(empty($this->pass)) throw new Exception('pass empty');
		if(empty($this->smtp)) throw new Exception('smtp empty');
		return true;
	}
	
	# ■HTML
	# @author Kiyosawa 
	# @date 
	public function setHtmlBody($body){
		$this->mailData['html_body']=$body;
	}
	
	# ■
	# @author Kiyosawa 
	# @date 
	public function setBody($body,$changeCodes=array()){
		
		if(empty($changeCodes)){
			$this->mailData['body']=$body;
			return;
		}
		$this->mailData['body']=str_replace(array_keys($changeCodes),array_values($changeCodes),$body);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function setSubject($subject){
		$this->mailData['subject']=$subject;
	}
	
	# ■メール送信
	# @author Kiyosawa 
	# @date 
	function sendMail($to,$from=array()){
		
		$transport=Swift_SmtpTransport::newInstance($this->smtp,587);
		$transport->setUsername($this->user);
		$transport->setPassword($this->pass);
		$swift=Swift_Mailer::newInstance($transport);
		
		$message=new Swift_Message($this->mailData['subject']);
		$message->setFrom($from);
		$message->setTo($to);
		
		$message->addPart($this->mailData['body'],'text/plain');
		if(!empty($this->mailData['html_body'])){
			$message->setBody($this->mailData['html_body'],'text/html');
		}
		
		# 送信処理
		if($recipients=$swift->send($message,$failures)){
			return true;
		}
		throw new Exception($failures);
	}
}

?>