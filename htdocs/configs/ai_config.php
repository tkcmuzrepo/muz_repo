<?php
/*  ----------------------------------------------------------------------------------
AQUA Framework customed cake.1.2
(C)BANEXJAPAN 2006-2009 All Rights Reserved. http://banex.jp
--------------------------------------------------------------------------------------  */

// ----------------------------------------------------------------------------------
// 共通関数をセットする為に、または、汎用的な変数をセットする為に最初に呼び出し
// ----------------------------------------------------------------------------------

$isLocal=(!empty($_SERVER['REMOTE_ADDR']) AND $_SERVER['REMOTE_ADDR']=='127.0.0.1');
$GLOBALS['isLocal']=$isLocal;

/**
* フレームワーク外で呼び出された時、CAKEで提供するdefineを用意する
*/
if(!defined("ROOT")){
	define("ROOT", dirname(__FILE__));
}

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

if(!defined('CONFIG_DIR')){
	define('CONFIG_DIR',ROOT.DS."configs".DS);
}

/**
 * functionディレクトリ
 */
define("FUNCTION_DIR", ROOT. DS . "function" . DS);

// 後で変更します
// functionディレクトリにあるファイルは自動的にロードされます
foreach (glob(FUNCTION_DIR."*.php") as $k=>$v){
	require_once($v);
}

// ----------------------------------------------------------------------------------
// プロジェクト毎の設定
// ----------------------------------------------------------------------------------
/*
v("bj_config.phpを変更して下さい！加えて、「mb/tmp/*」と、「master/tmp/*」の権限を0777にして下さい！
	これを行わないと、ドキュメントルートアクセス時にページが表示されません");
*/


define('DEBUG',1);

$webDomain='muz.hayahide.com:8080/';
if($_SERVER['SERVER_NAME']=='muz.kiyosawa.com'){
	$webDomain=$_SERVER['SERVER_NAME']."/";
//	$webDomain='muz.kiyosawa.com/';
}

if(!$GLOBALS['isLocal']){
	$webDomain='aiweb1.azurewebsites.net/';
}

define('WEB_DOMAIN',$webDomain);
define("ROOT_DOMAIN",sprintf("http://%s",WEB_DOMAIN));
define("SSL_DOMAIN",sprintf("https://%s",WEB_DOMAIN));

/**
 * <title>タイトル
 */
define("SITE_TITLE","テスト管理画面");

$modelDir=dirname(dirname(__FILE__)).DS."Model".DS;
define('MODELS',$modelDir);

$controllerDir=dirname(dirname(__FILE__)).DS."Controller".DS;
define('CONTROLLERS',$controllerDir);

/**
 * 管理画面ベーシック認証ID
 * MASTER_BASIC_IDもしくはMASTER_BASIC_PASSが空の場合は、BASIC認証をかけません
 */
define("MASTER_BASIC_ID","muz");

/**
 * 管理画面ベーシック認証PASS
 * MASTER_BASIC_IDもしくはMASTER_BASIC_PASSが空の場合は、BASIC認証をかけません
 */
define("MASTER_BASIC_PASS","muz");

/**
 * 管理ドメイン
 */
$master_directory='master';
define("MASTER_DOMAIN",ROOT_DOMAIN.$master_directory.'/');

/**
 * 店舗ドメイン
 */
$admin_directory='admin';
define("ADMIN_DOMAIN",ROOT_DOMAIN.$admin_directory.'/');

/**
 * PCドメイン(用途に応じて)
*/

$pc_directory='pc';
define("PC_DOMAIN",ROOT_DOMAIN.$pc_directory.'/');
define("PC_SSL_DOMAIN",ROOT_DOMAIN.$pc_directory.'/');

/**
 * PCドメイン(用途に応じて)
*/

$smp_directory='smp';
define("SMP_DOMAIN", ROOT_DOMAIN .$smp_directory.'/');
define("SMP_SSL_DOMAIN", SSL_DOMAIN .$smp_directory.'/');


/**
 * 携帯ドメイン（WEB）
 */
$mb_directory='mobile';
define("MB_DOMAIN","http://".WEB_DOMAIN.$mb_directory.'/');
define("MB_SSL_DOMAIN", SSL_DOMAIN .$mb_directory.'/');

/**
 * ユーザデータ(空メールで投稿された画像等)の保存ディレクトリ
 */
$S = $_SERVER;
$document_root=substr($S["SCRIPT_FILENAME"],0,-strlen($S["SCRIPT_NAME"]));
define("USER_DATA",dirname(ROOT).DS.'user_data'.DS);

/**
 * MASTER_DATAディレクトリ
 */
define("MASTER_DATA",dirname(ROOT).DS."master_data".DS);

/**
 * CLASSディレクトリ
 */
define("CLASS_DIR",ROOT.DS."classes".DS);

/**
 * TSVディレクトリ
 */
define("TSV",MASTER_DATA."tsv".DS);

/**
 * 自動返信メールのテンプレート保存ディレクトリ
 */
define("MAIL_TPL",MASTER_DATA."mail_tpl".DS );

/**
 * 受信メールのテンプレート保存ディレクトリ
 */
define("MAIL_RECEIVER",ROOT.DS."mail_receiver".DS);

/**
* 絵文字画像ディレクトリ
*/
define("EMOJI_DIR", MASTER_DATA."emoji".DS);

/**
* 自動生成スケルトンディレクトリ
*/
define("GENERATE_DIR",MASTER_DATA."generate_tpl".DS);

if(!function_exists('__config_load')){
	function __config_load($dir_path=''){
		if(empty($dir_path)) $dir_path=__DIR__;
		$config_list=glob($dir_path.DS."*");
		foreach($config_list as $k=>$v){
			if($v==__FILE__)continue;
			require_once($v);
		}
	}
}
__config_load();

?>
