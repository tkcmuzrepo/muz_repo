<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class MainModel extends Model {

	public $field=array();
	public $order='';
	public $limit='';
	
	# find の状態を保持
	protected $findByStack=array();
	
	function __construct(){
		parent::__construct();
	}
	
	# ■初期化します
	# @author Kiyosawa 
	# @date 
	protected function __clear(){
		
		$this->field=array();
		$this->order=$this->limit='';
	}
	
	# ■事前の状態に戻す
	# @author Kiyosawa 
	# @date 
	public function init_data(&$data=array()){
		$data[$this->name]=$this->findByStack[$this->name];
	}
	
	# ■存在しない主キーに関してはエラーは起こらない
	# @author Kiyosawa 
	# @date 
	function multiUpdateBySqlServerPrimaryKeyUpdate($data=array(),$primary="id"){
		
		if(empty($data)) return;
		
		static $sql_count=0;
		static $sql='BEGIN TRAN ';
		static $now='';
		static $columnTypes=array();
		
		if(empty($columnTypes)) $columnTypes=$this->getColumnTypes();
		
		$tmp_data=array_shift($data);
		
		# primary key
		$primary_key='';
		if(!isset($tmp_data[$primary]) OR !$columnTypes[$primary]){
			return false;
		}
		$primary_key=$tmp_data[$primary];
		if($columnTypes[$primary]=='integer'){
			$primary_key=(int)$primary_key;
		}
		unset($tmp_data[$primary]);
		# value
		$update_sentence='';
		foreach($tmp_data as $k=>$v){
			
			$v=($columnTypes[$k]=='integer')?$v:"N'{$v}'";
			$update_sentence.="{$k}={$v},";
		}
		
		# modified
		if(!isset($tmp_data['modified']) AND isset($columnTypes['modified'])){
			
			if(empty($now)){
				switch($columnTypes['modified']){
					case('date'):
					$now=date("Y/m/d");
				break;
					default:
					$now=date("Y/m/d H:i:s");
				break;
				}
			}
			$update_sentence.="modified='{$now}'"; # GETTIME()がサーバの時間に左右される
		}
		
		# sentence
		$update_sentence=trim($update_sentence,',');
		$sql.="UPDATE {$this->useTable} SET {$update_sentence}";
		$sql.=" ";
		$sql.="WHERE {$primary}={$primary_key};";
		
		if(!empty($data)){
			$sql_count++;
			$this->multiUpdateBySqlServerPrimaryKeyUpdate($data,$primary);
		}
		
		if(empty($data)){
			
			$sql.="COMMIT";
			
			//echo $sql;
			//exit;
			
			# クエリ実行処理
			$res=$this->query($sql);
			
			# 初期化
			$now=$sql='';
			$sql_count=0;
			$columnTypes=array();
			
			return $res;
		}
	}
	
	# @author Kiyosawa 
	# @date 
	function multiInsertForSqlServer($data=array(),$identity_insert=false){
		
		static $sql_count=0;
		static $sql='BEGIN TRAN ';
		static $now='';
		static $columnTypes=array();
		
		if(empty($data)) return;
		
		# 主キーを直接指定する場合
		if(empty($sql_count) AND !empty($identity_insert)) $sql.="SET IDENTITY_INSERT {$this->useTable} ON;";
		if(empty($columnTypes)) $columnTypes=$this->getColumnTypes();
		
		$tmp_data=array_shift($data);
		
		# value
		$keys=$values=array();
		foreach($tmp_data as $k=>$v){
			
			if(!isset($columnTypes[$k])) continue;
			$keys[]=$k;
			
			# Nプレフィックスの対応
			$value=($columnTypes[$k]=='integer')?$v:"N'{$v}'";
			$values[]=mb_convert_encoding($value,'utf-8',mb_detect_encoding($value));
		}
		
		if(!function_exists('__add_date')){
			function __add_date(&$keys,&$values,$column,$column_type,$time){
				
				if(empty($column_type)){
					return;
				}
				if(empty($time)){
					switch($column_type){
						case('date'):
						$time=date("Y/m/d");
					break;
						default:
						$time=date("Y/m/d H:i:s");
					break;
					}
				}
				$keys[]=$column;
				$values[]="'{$time}'";
			}
		}
		
		if(!isset($tmp_data['created']) AND isset($columnTypes['created'])) __add_date($keys,$values,'created',$columnTypes['created'],$now);
		if(!isset($tmp_data['modified']) AND isset($columnTypes['modified'])) __add_date($keys,$values,'modified',$columnTypes['modified'],$now);
		
		# sentence
		
		$sql.="INSERT INTO {$this->useTable}";
		$sql.=" ";
		$sql.="(".implode(',',$keys).")";
		$sql.=" ";
		$sql.="values";
		$sql.=" ";
		$sql.="(".implode(',',$values).");";
		
		if(!empty($data)){
			$sql_count++;
			$this->multiInsertForSqlServer($data,$identity_insert);
		}
		
		if(empty($data)){
			
			if($identity_insert) $sql.="SET IDENTITY_INSERT {$this->useTable} OFF;";
			$sql.="COMMIT";
			
			# クエリ実行処理
			$res=$this->query($sql);
			
			# 初期化
			$now=$sql='';
			$sql_count=0;
			$columnTypes=array();
			
			return $res;
		}
	}
	
	# ■IDの最大値
	# @author Kiyosawa 
	# @date 
	function _getMaxID(){
		
		$fields=array('MAX(id) as id');
		ClassRegistry::init($this->name)->unbindFully();
		if(!$max_id=ClassRegistry::init($this->name)->find('first',array('fields'=>$fields))){
			return 0;
		}
		return $max_id[0]['id'];
	}
	
	
	# ■deleteAll
	# @author Kiyosawa 
	# @date 
	function deleteAll($w,$cascade=true,$callbacks=false){
		$this->unbindFully();
		parent::deleteAll($w,$cascade,$callbacks);
	}
	
	
	function multiInsert($data = array() , $primary = "id" , $limit = 1000 , $update = array() , $clm = array()){
		
		$sql = "INSERT INTO {$this->useTable} (";
		# カラム取得
		if(!$clm){
			$map_data = current($data);
			ksort($map_data); # 2010/12/19 21:15:05 位置ぞろえ
			foreach($map_data as $k=>$v)	$clm[$k] = "`{$k}`";
			if($this->hasField(array("created")))	$clm["created"]		= "`created`";
			if($this->hasField(array("modified")))	$clm["modified"]	= "`modified`";
		}
		$sql.= implode(",",$clm).") VALUES ";
		# 実データをインサート用文字列に変換
		$i = 1;
		foreach($data as $k=>$v){
			# 2010/12/19 21:15:18 位置ぞろえ
			ksort($v);
			foreach($v as $_v)	$in[] = "'$_v'";
			$str = "(".implode(",",$in);
			$str.= $this->hasField(array("created")) ? ",NOW()" : "";
			$str.= $this->hasField(array("modified")) ? ",NOW()" : "";
			$str.= ")";
			$insert[] = $str;
			array_shift($data);
			unset($in);
			if($i == $limit)	break;
			$i++;
		}
		$sql.= implode(",",$insert)."\n";
		# アップデート用文字列生成
		if(!$update){
			foreach($clm as $k=>$v){
				//プライマリーキーやユニークキーはアップデート対象にしない。文字列でも、配列でも指定可
				if(is_string($primary)){
					if($primary == $k)	continue;
				} elseif (is_array($primary)){
					if(in_array($k,$primary)) continue;
				}
				//追加日は飛ばす。
				if ($k == "created" or $k == "modified")	continue;
				$update[] = "{$k} = VALUES({$k})";
			}
		}
		if($update){
			$sql.= " ON DUPLICATE KEY UPDATE ";
			$sql.= implode(" , ",$update);
			$sql.= $this->hasField(array("modified")) ? ",modified = NOW()" : "";
		}
		
		# インサート＆アップデート
		#v($sql);
		$this->query($sql);
		unset($insert,$sql);
		# 再帰的に
		if($data){
			$this->multiInsert($data , $primary , $limit , $update , $clm);
		}
	}
	
	function findAll($conditions=array(),$field=array(),$order='',$limit=''){
		
		$params=null;
		if(!empty($conditions)){
			$params['conditions']=$conditions;
		}
		if(!empty($field) OR !empty($this->field)){
			$params['fields']=!empty($field)?$field:$this->field;
		}
		if(!empty($order) OR !empty($this->order)){
			$params['order']=!empty($order)?$order:$this->order;
		}
		if(!empty($limit) OR !empty($this->limit)){
			$params['limit']=max($limit,$this->limit);
		}
		$this->order=$this->limit=$this->field='';
		return $this->find('all',$params);
	}
	
	/**
	 * 全てのリレーションを解除
	 *
	 */
	function unbindFully() {
		
		$unbind = array();
		foreach ($this->belongsTo as $model=>$info) {
			$unbind['belongsTo'][] = $model;
		}
		foreach ($this->hasOne as $model=>$info) {
			$unbind['hasOne'][] = $model;
		}
		foreach ($this->hasMany as $model=>$info) {
			$unbind['hasMany'][] = $model;
		}
		foreach ($this->hasAndBelongsToMany as $model=>$info) {
			$unbind['hasAndBelongsToMany'][] = $model;
		}
		$this->unbindModel($unbind);
	}
	
	/**
	* 絵文字も考慮しています。
	*/
	function mob_length($data , $num){
		foreach($data as $k=>$v){
			$length = mb_strlen($v , "UTF-8");
			#v($length);
			if($length > $num){
				#v($v);
				return false;
			}
		}
		return true;
	}
	
	
	#
	# @author Kiyosawa 
	# @date 
	function save($data=NULL,$validate=true,$fieldList=array()){
		
		$data=(isset($data[$this->name]))?$data[$this->name]:$data;
		$data=array_remove($data,NULL);
		$save[$this->name]=$data;
		return parent::save($save);
	}
	
}