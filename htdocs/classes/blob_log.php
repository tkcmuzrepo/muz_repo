<?php

class BlobLog{
	
	private $instance;
	
	# 10日前のは削除
	public $rotate=10;
	public $isRemove=false;
	
	#
	# @author Kiyosawa 
	# @date 
	function __construct(){
		
		$win_blob_storage='WinBlobStorage';
		if(!class_exists($win_blob_storage)) die(__LINE__);
		
		if(!empty($this->instance)) return;
		$this->instance=new $win_blob_storage(STORAGE_URL,STORAGE_ACCOUNT,STORAGE_KEY);
	}
	
	# ■ここら辺はCRONでやるべき
	# @author Kiyosawa 
	# @date 
	public function blobRemove($container_name){
		
		if(!$blobs=$this->instance->listBlobs($container_name)){
			return false;
		}
		
		$before_date=strtotime("- {$this->rotate} day",time());
		foreach($blobs as $k=>$v){
			if(strtotime($v->lastmodified) >= $before_date) continue;
			$this->instance->blob_remove($v->container,$v->name);
		}
		return true;
	}
	
	#
	# @author Kiyosawa 
	# @date 
	public function saveLog($data='',$container_name,$file_name='',$file_mode=true){
		
		if(empty($file_name)){
			$file_name=sprintf("%s.txt",date("Y_m_d"));
		}
		
		if($file_mode AND !$this->instance->blobExists($container_name,$file_name)){
			$file_mode=false;
		}
		
		$this->instance->blob_put_contents($container_name,$file_name,$data,$file_mode);
		
		# 過去のログを削除するか
		if(empty($this->isRemove) OR empty($this->rotate)) return;
		$this->blobRemove($container_name);
	}
	
}

?>