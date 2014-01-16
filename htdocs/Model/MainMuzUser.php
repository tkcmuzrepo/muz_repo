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

App::uses('AppModel','Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class MainMuzUser extends AppModel {

		var $name='MuzUser';
		var $userTable='muz_users';
		var $primaryKey='id';
		
		
		# ■対象クライアントの会員
		# @author Kiyosawa 
		# @date 
		function findAllByClientId($client_id){
			
			$w=null;
			$w['and']["MuzUser.client_id"]=$client_id;
			$data=$this->findAll($w);
			return $data;
		}
		
		# ■対象月以上の会員
		# @author Kiyosawa 
		# @date 
		function findAllByClientIdAndMonthOver($client_id,$month=1){
			
		}
		
		# ■月別会員登録数
		# ■111 => yyyy/mm/dd
		# SELECT convert(varchar(7),created,111) as created, count(*) as cnt FROM [muz_users] AS [MuzUser] WHERE [MuzUser].[client_id] = 1 AND created > DATEADD(mm,-6,GETDATE()) AND 1=1 group by convert(varchar(7),created,111)
		# @author Kiyosawa 
		# @date 
		function findAllByClientIdAndMonthOverCount($client_id,$month=-1,$format='yyyy/mm'){
			
			# 変換形式
			$convert['yyyymm']=112;
			$convert['yyyy/mm']=111;
			
			# 取得サイズ
			$size[112]=6;
			$size[111]=7;
			
			$format_num=$convert['yyyymm'];
			if(isset($convert[$format])){
				$format_num=$convert[$format];
			}
			$w=null;
			$w['and']['MuzUser.client_id']=$client_id;
			$w[]="created > DATEADD(mm,{$month},GETDATE())";
			$w[]="1=1 group by convert(varchar({$size[$format_num]}),created,{$format_num})";
			$this->field=array("convert(varchar({$size[$format_num]}),created,{$format_num}) as created","count(*) as cnt");
			if(!$data=$this->findAll($w)){
				return false;
			}
			foreach($data as $k=>$v){
				$res[$v[0]['created']]=$v[0]['cnt'];
			}
			return $res;
		}
		
		# ■日別登録数
		# SELECT convert(varchar,created,112) as created, count(*) as cnt FROM [muz_users] AS [MuzUser] WHERE [MuzUser].[client_id] = 1 AND created > DATEADD(dd,-6,GETDATE()) AND 1=1 group by convert(varchar,created,112)
		# @author Kiyosawa 
		# @date 
		function findAllByClientIdAndDayOverCount($client_id,$day=-1,$format='yyyymmdd'){
			
			# 変換形式
			$convert['yyyymmdd']=112;
			$convert['yyyy/mm/dd']=111;
			
			$w=null;
			$w['and']['MuzUser.client_id']=$client_id;
			$w[]="created > DATEADD(dd,{$day},GETDATE())";
			$w[]="1=1 group by convert(varchar,created,{$convert[$format]})";
			$this->field=array("convert(varchar,created,{$convert[$format]}) as created","count(*) as cnt");
			if(!$data=$this->findAll($w)){
				return false;
			}
			foreach($data as $k=>$v){
				$res[$v[0]['created']]=$v[0]['cnt'];
			}
			return $res;
		}
		
}
