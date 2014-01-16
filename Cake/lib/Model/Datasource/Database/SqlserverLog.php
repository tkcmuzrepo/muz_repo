<?php

//v(class_exists('BlobLog'));
App::uses('Sqlserver', 'Model/Datasource/Database');

class SqlserverLog extends Sqlserver{
	
	private $maxSize=10; #M
	private $maxFileNum=20;
	private $logFilePrefixName="sql";
	private $ext='.log';
	
	#
	# @author Kiyosawa 
	# @date 
	private function __rename($ary=array()){
		
		foreach($ary as $k=>$v){
			rename(LOGS.$this->logFilePrefixName.$v++.$this->ext,LOGS.$this->logFilePrefixName.$v.$this->ext);
		}
	}
	
	#
	# @author Kiyosawa 
	# @date 
	private function __unlink($ary=array()){
		
		# 上限確認
		if(count($ary)>$this->maxFileNum){
			$delete_index=array_pop($ary);
			$ary=array_remove($ary,$delete_index);
			unlink(LOGS.$this->logFilePrefixName.$delete_index.$this->ext);
		}
		return $ary;
	}
	
	function logQuery($sql,$params=array()) {
		
		parent::logQuery($sql);
		
		if(!Configure::read('Cake.logQuery')) return;
		
	    $log='';
	    $sql_log=$this->_queriesLog;
	    foreach($sql_log as $k=>$v){
			$log.=sprintf("【%s】query:%s,affected:%s,numRows:%s,took:%s\n\n",date('Y/m/d H:i:s'),$v['query'],$v['affected'],$v['numRows'],$v['took']);
	    }
		
		# Winストレージ
		if(!$GLOBALS['isLocal']){
			$this->_saveWinStorageLog($log);
			return;
		}
		
		$log_type=SELECT_LOG;
		
		$file_name="{$log_type}0";
		$file_size=floor(filesize(LOGS.$file_name.$this->ext)/(1024*1024));
		
		$ary=array();
		$logNameRegExp=addslashes(LOGS.$this->logFilePrefixName);
		if($file_size>=$this->maxSize){
			
			$tmp=glob(LOGS."*");
			foreach($tmp as $k=>$v){
				if(!preg_match("#^{$logNameRegExp}([0-9]*)#",$v,$match)) continue;
				array_push($ary,$match[1]);
			}
			sort($ary);
			
			$ary=$this->__unlink($ary);
			
			# rename
			$ary=array_reverse($ary);
			$this->__rename($ary);
			
			# make
			touch(LOGS.$file_name.$this->ext);
		}
		
	    $this->log($log,$file_name);
	}
	
	# ■Azureストレージへ
	# @author Kiyosawa 
	# @date 
	function _saveWinStorageLog($log){
		
		if(!class_exists('Configure') OR !(Configure::read('BLOB_LOG') instanceof BlobLog)) return;
		
		try{
			Configure::read('BLOB_LOG')->isRemove=true;
			Configure::read('BLOB_LOG')->rotate=7;
			Configure::read('BLOB_LOG')->saveLog($log,SQL_LOG,'',true);
		}catch(Exception $e){
			return;
		}
	}
}