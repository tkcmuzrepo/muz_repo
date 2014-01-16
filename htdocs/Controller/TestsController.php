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
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MainTestsController extends AppController {

	public $name = 'Tests';
	
	public $uses = array();
	
	
	#
	# @author Kiyosawa 
	# @date 
	function beforeFilter(){
		parent::beforeFilter();
	}
	
	function index(){
		
			# modelとfieldの概念って????
			# Form9Field10
			
			# 郵便番号
			
			/*
			$value="sss[Form888][Field999]fasd";
			v($this->PostAnalysis->fieldDecode($value));
			*/
			
			/*
			# hiddenでpost予定
			$form_id=9;
			$this->loadModel('MuzForm');
			v($this->MuzForm->find('all'));
			*/
			
			//v(ClassRegistry::init("MuzFormFieldSettingDetail")->find('all'));
			#$insert['MuzForm']['title']='titlec';
			#$insert['MuzForm']['hash']='jsjsjsjsjsj';
			
			/*
			$update=array();
			foreach(array(1,4,5,6) as $k=>$v){
				
				$counter=count($update);
				$update[$counter]['id']=$v;
				$update[$counter]['title']='update'.$v;
				$update[$counter]['hash']=(int)microtime(time().$v);
				$update[$counter]['pc_flg']=rand(0,1);
				$update[$counter]['mb_flg']=rand(0,1);
				$update[$counter]['sp_flg']=rand(0,1);
			}
			
			v($this->MuzForm->multiUpdateBySqlServerPrimaryKeyUpdate($update));
			*/
			
			/*
			# checkboxを想定
			$this->data['Form9']['Field10'][1]="AAA";
			$this->data['Form9']['Field10'][3]="BBB";
			$this->data['Form9']['Field10'][4]="CCC";
			
			# radioボタンを想定
			$this->data['Form9']['Field11'][1]="ラジオ1";
			$this->data['Form9']['Field12'][1]="ラジオ2";
			$this->data['Form9']['Field13'][1]="ラジオ3";
			
			# textboxを想定
			$this->data['Form9']['Field14'][1]="テキストボックス1";
			
			# 送信内容を整形
			$values=getPostValuesKeyField($this->data["Form{$form_id}"]);
			$field_ids=array_keys($values);
			
			v($values);
			*/
			
			
			# 
			
			/*
			$validate_class="validate_email";
			$colors=array("white","red","blue","gray");
			$form_id=9;
			$field_id=10;
			$textarea=new Textarea($form_id,$field_id);
			$textarea->setValueAttr("ほげほげ");
			$form=$textarea->getForm();
			
		//	v($form);
			v(h($form));
			*/
			
			
			/*
			$validate_class="validate_email";
			$colors=array("white","red","blue","gray");
			$form_id=9;
			$field_id=10;
			$radiobox=new RadioBox($form_id,$field_id);
			
			$values=array("横須賀市","川崎市","札幌市","相模原市");
			$checked_index=2;
			for($i=0;$i<count($values);$i++){
				
				$radiobox->setClass($validate_class);
				$radiobox->setStyleAttr('background-color:'.$colors[$i].";");
				
				$checked=($i==$checked_index)?true:false;
				$radiobox->setValueAttr($values[$i],$checked);
				$form=$radiobox->getForm();
				$box[]=$form;
			}
			
			//v($box);
			v(h($box));
			*/
			
			/*
			# 懸念点
			# box_numが3つの場合のname,idの命名規則
			# フォーマットの設定場所
			$validate_class="validate_email";
			$colors=array("white","red","blue","gray");
			$form_id=9;
			$field_id=10;
			$checkbox=new CheckBox($form_id,$field_id);
			
			$values=array("横須賀市","川崎市","札幌市","相模原市");
			$checked_index=array(1,2);
			for($i=0;$i<4;$i++){
				
				$checkbox->setClass($validate_class);
				$checkbox->setStyleAttr('background-color:'.$colors[$i].";");
				$checkbox->setData("DATA");
				
				$checked=(in_array($i,$checked_index))?true:false;
				$checkbox->setValueAttr($values[$i],$checked);
				$form=$checkbox->getForm();
				$box[]=$form;
			}
			
			//v($box);
			v(h($box));
			*/
			
			/*
			$validate_class="validate_email";
			$colors=array("white","red","blue");
			$form_id=9;
			$field_id=10;
			$select=new SelectBox($form_id,$field_id);
			
			$option_values[]=array("","横須賀","横浜","川崎");
			$option_values[]=array("品川","五反田","代々木");
			$option_values[]=array("八王子","橋本","相模原");
			$selected_indexs=array(3,1,2);
			
			for($i=0;$i<3;$i++){
				
				$select->setClass($validate_class);
				$select->setStyleAttr('background-color:'.$colors[$i].";");
				$select->setOption($option_values[$i],$selected_indexs[$i]);
				$form=$select->getForm();
				
				$box[]=$form;
			}
			
			//v($box);
			v(h($box));
			
			v($select);
			
			exit;
			*/
			/*
			$box=array();
			$form_id=9;
			$field_id=10;
			$text=new TextBox($form_id,$field_id);
			
			for($i=0;$i<3;$i++){
			
				$value=sprintf("value%s",$i);
				$colors=array("white","red","blue");
				$validate_class="validate_email";
				
				$text->setValueAttr($value);
				$text->setClass($validate_class);
				$text->setStyleAttr('background-color:'.$colors[$i].";");
				//$text->replace('value',$value.$i*$i);
				$form=$text->getForm();
				
				$box[]=$form;
			
			}
			
			//format_replace($box,"%s&nbsp;-&nbsp;%s&nbsp;-&nbsp;%s");
			
			//v($box);
			v(h($box));
			*/
			
			/*
			# フォーム作成
			$model="Form";
			$field="sample1";
			$text=new TextBox($model,$field);
			///$text->setTypeAttr('text');
			
			$text->setBoxNum(3);
			$text->setFieldFormat('%s-%s-%s');
			
			$text->setValueAttr('aiueo');
			$text->replace('value','baka');
			$text->replace('value','bakasssss');
			$text->setStyleAttr('background-color:red;');
			$form=$text->getForm();
			
			//v($form);
			v(h($form));
			
			v('ERROR NOT FOUND');
			
			exit;
			*/
			
			
			
			//$this->loadModel('User');
			
			/*
			header("Content-type:text/html;charset=utf-8");
			$user=$this->User->findAll();
			print_r($user);
			exit;
			*/
			
			
			
			/*
			for($i=110;$i<120;$i++){
			$save['User']['name']=sprintf("kiyosawa%d",$i);
			$save['User']['age']=$i;
			$res[]=ClassRegistry::init("User")->save($save);
			}
			v($res);
			v(ClassRegistry::init("User")->find('all'));
			*/
			
			/* count
			$w=null;
			$w['and']['User.age']=101;
			$count=ClassRegistry::init("User")->find('count',$w);
		//	v($count);
			*/
			
			/*
			$this->loadModel('MuzForm');
			
			$save['MuzForm']['id']=1;
			$save['MuzForm']['title']='タイトルa';
			$save['MuzForm']['hash']='abcde';
			v($this->MuzForm->save($save));
			
			exit;
			v(method_exists($this->MuzForm,'multiInsert'));
			v($this->MuzForm->find('all'));
			
			# group by
			$w=null;
			//$w['and']['User.id']=1;
			$w[]="1=1 group by age";
			$w=null;
			$w['and']['User.age']=101;
			$w[]="1=1 group by age";
			$f=array("COUNT(id) as cnt","age");
			$user=ClassRegistry::init("User")->find('all',array('conditions'=>$w,'fields'=>$f));
			v($user);
			exit;
			*/
			
			/*
			$w=null;
			$w[]="1=1 group by User.age";
			$fields=array("User.id","User.age");
			$order="User.id DESC,User.name ASC";
			$limit=100;
			$user=$this->User->find($w,$fields,$order,$limit);
			
			v($user);
			
			print_r($user);
			exit;
			v($user);
			*/
			
			/*
			//$count=ClassRegistry::init('User')->find('count');

//			$data=ClassRegistry::init('User')->findAllByAge(20);
			
			//$data=ClassRegistry::init('User')->findByAge(20);
			
			$w=null;
			$w['conditions']['or']['User.id']=array(1,2);
			$w['conditions']['or']['User.name']='螻ｱ逕ｰ縺倥ｇ縺偵◆繧阪≧';
			$user=ClassRegistry::init('User')->find('all',$w);

			$w=null;
//			$w['and']['User.id']=array(1,2);
//			$w['and']['User.name']='鬮俶ｩ九⊇縺偵◆繧阪≧';
			$w[]="1=1 group by User.age";
			$fields=array("count('id') as id","User.age");
			$order="User.id DESC,User.name ASC";
			$limit=100;
			$user=ClassRegistry::init('User')->findAll($w,$fields,$order,$limit);
			v($user);


			$w=null;
			$w['conditions']['and']['User.id']=array(1,2);
			$w['conditions']['and']['User.name']='螻ｱ逕ｰ縺倥ｇ縺偵◆繧阪≧';
			$w['fields']=array('User.name');
			$w['order']="User.id DESC,User.name ASC";
//			$user=ClassRegistry::init('User')->find('all',$w);

			//v($user);


//			v(Set::combine($user,"{n}.User.id","{n}.User.name"));
//			v(Set::extract($user,"{}.User.name"));
		
			 */
			
//			v($this->params);
		
	}
	
}