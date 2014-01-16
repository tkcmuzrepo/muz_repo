<?php
	
	# ■配信時過去ユーザが残っていると配信時重いので過去の配信ログを消します
	
	//■CRONで実行するファイル
	$_GET['url'] = "update_pref_regist_users/delete_pref_users/";
	$fpath = dirname( dirname(__FILE__) ) . "/mb/webroot/index.php";
	require_once( $fpath );
?>