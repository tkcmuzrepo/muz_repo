<?php
	
	$redirectURL=sprintf("http://%s/pc",$_SERVER['SERVER_NAME']);
	header("location:{$redirectURL}");
	exit;
	
?>