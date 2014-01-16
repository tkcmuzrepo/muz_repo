<?php

class WinBlobStorage{
	
	private $instance;
	private $debug=false;
	private $protocol="azure";
	
	private $errorMes=array(
		
		0=>'コンテナが存在しません【%s】',
		1=>"blobが存在しません【%s】",
		2=>"メソッドが無い【%s】",
		3=>"必要なClassがロードされていません:class=>【%s】"
	);
	
	private $setArgs=array();
	
	function __construct($url,$account,$key,$debug=false){
		
		$microsoft_windowsazure_storage_blob='Microsoft_WindowsAzure_Storage_Blob';
		if(!class_exists($microsoft_windowsazure_storage_blob)){
			$this->__echo(sprintf($this->errorMes[3],$microsoft_windowsazure_storage_blob));
		}
		
		$microsoft_windowsazure_retrypolicyabstract='Microsoft_WindowsAzure_RetryPolicy_RetryPolicyAbstract';
		if(!class_exists($microsoft_windowsazure_retrypolicyabstract)){
			$this->__echo(sprintf($this->errorMes[3],$microsoft_windowsazure_retrypolicyabstract));
		}
		
		if(!empty($this->instance)) return;
		
		$this->debug=$debug;
		
		# ストリームラッパー
		$this->instance=new $microsoft_windowsazure_storage_blob($url,
		                                               $account,
													   $key,
													   false,
													   $microsoft_windowsazure_retrypolicyabstract::retryN(10, 250));
		$this->instance->registerStreamWrapper();
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function containerExists($container_name){
		return $this->instance->containerExists($container_name);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function blobExists($container_name,$file_name){
		return $this->instance->blobExists($container_name,$file_name);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function makeContainer($container_name,$mode='private'){
		
		$res=$this->instance->createContainerIfNotExists($container_name);
		
		# ネットに公開するか(画像くらいか)
		if($mode!=BLOB_PUBLIC) return;
		$this->setPublic($container_name);
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function listBlobs($container_name){
		
		if(!$this->containerExists($container_name)) return array();
		$res=$this->instance->listBlobs($container_name);
		return $res;
	}
	
	
	# ファイルシステムから
	# 画像の場合はこれ、httpで直接保存出来ないので一旦サーバへ保存しそこのパスを渡す
	# @author Kiyosawa 
	# @date 
	public function putContents($container_name,$file_name,$data_path){
		
		$this->makeContainer($container_name);
		$result=$this->instance->putBlob($container_name,$file_name,$data_path);
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	private function __getAzureBlobURI($container_name,$file_name){
		$uri=sprintf("{$this->protocol}://%s/%s",$container_name,$file_name);
		return $uri;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __echo($data){
		
		header("Content-type:text/plain;charset=utf8");
		echo $data;
	}

	# 読み取り権限をパブリックへ(公開)
	# @author Kiyosawa 
	# @date 
	function setPublic($container_name){
		return $this->__method_exec('__'.__FUNCTION__,func_get_args());
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __setPublic($args=array()){
		
		$container_name=$args[0];
		if(!$this->containerExists($container_name)){
			throw new Exception(sprintf($this->errorMes[0],$container_name));
		}
		$this->instance->setContainerAcl($container_name,Microsoft_WindowsAzure_Storage_Blob::ACL_PUBLIC_CONTAINER);
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function blob_remove($container_name,$file_name){
		return $this->__method_exec('__'.__FUNCTION__,func_get_args());
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function blob_container_remove($container_name){
		return $this->__method_exec('__'.__FUNCTION__,func_get_args());
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function listContainers(){
		return $this->instance->listContainers();
	}
	
	# 文字はこれ
	# FILE_APPENDで追加
	# @author Kiyosawa 
	# @date 
	public function blob_put_contents($container_name,$file_name,$data,$mode=true){
		
		$this->makeContainer($container_name);
		$uri=$this->__getAzureBlobURI($container_name,$file_name);
		if(empty($mode)){
			file_put_contents($uri,$data);
			return;
		}
		file_put_contents($uri,$data,FILE_APPEND);
		return;
	}
	
	# データの取得はこれ
	# @author Kiyosawa 
	# @date 
	public function blob_get_contents($container_name,$file_name){
		return $this->__method_exec('__'.__FUNCTION__,func_get_args());
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __blob_get_contents($args=array()){
		
		$container_name=$args[0];
		$file_name=$args[1];
		if(!$this->containerExists($args[0])){
			throw new Exception(sprintf($this->errorMes[0],$container_name));
		}
		
		if(!$this->blobExists($args[0],$args[1])){
			throw new Exception(sprintf($this->errorMes[1],$file_name));
		}
		$uri=$this->__getAzureBlobURI($container_name,$file_name);
		return file_get_contents($uri);
	}

	# パスにコピーします
	# @author Kiyosawa 
	# @date 
	public function getBlob($container_name,$file_name,$save_path){
		return $this->__method_exec('__'.__FUNCTION__,func_get_args());
	}
	
	# 
	# @author Kiyosawa 
	# @date 
	private function __getBlob($args=array()){
		
		$container_name=$args[0];
		$file_name=$args[1];
		$save_path=$args[2];
		if(!$this->containerExists($container_name)){
			throw new Exception(sprintf($this->errorMes[0],$container_name));
		}
		
		if(!$this->blobExists($args[0],$args[1])){
			throw new Exception(sprintf($this->errorMes[1],$file_name));
		}
		
		try{ $result=$this->instance->getBlob($container_name,$file_name,$save_path);
		}catch(Microsoft_WindowsAzure_Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __blob_remove($args=array()){
		
		$container_name=$args[0];
		$file_name=$args[1];
		if(!$this->instance->blobExists($container_name,$file_name)){
			throw new Exception(sprintf($this->errorMes[1],$file_name));
		}
		try{ $result=$this->instance->deleteBlob($container_name,$file_name);
		}catch(Microsoft_WindowsAzure_Exception $e){
			throw new Exception($e->getMessage());
		}
		
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __blob_container_remove($args=array()){
		
		$container_name=$args[0];
		if(!$this->instance->containerExists($container_name)){
			throw new Exception(sprintf($this->errorMes[0],$container_name));
		}
		try{ $result=$this->instance->deleteContainer($container_name);
		}catch(Microsoft_WindowsAzure_Exception $e){
			throw new Exception($e->getMessage());
		}
		return true;
	}

	#
	# @author Kiyosawa 
	# @date 
	private function __method_exec($methodName,$args=array()){
		
		try{
			if(!method_exists($this,$methodName)) throw new Exception(sprintf($this->errorMes[2],$methodName));
			$res=$this->{$methodName}($args);
		}catch(Exception $e){
			
			if($this->debug) $this->__echo(sprintf("catchError:%s\n<br />",$e->getMessage()));
			return false;
		}
		return $res;
	}
	
}


?>