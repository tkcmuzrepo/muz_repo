<?php
/**
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
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
	
	$baseURL=sprintf("%s://%s/",$_SERVER['REQUEST_SCHEME'],$_SERVER['SERVER_NAME']);
	
	switch(true){
		case(isSp()):
		$baseURL.="smp/main/index/";
	break;
		case(isMb()):
		$baseURL.="mobile/main/index/";
	break;
		default:
		$baseURL.="pc/main/index/";
	break;
	}
	
	$baseURL.="{$this->params['controller']}/";
	v($baseURL);
	if($_REQUEST['code']){
		$p=(is_numeric(strpos($baseURL,'?')))?"&":"?";
		$baseURL.="{$p}code={$_REQUEST['code']}";
	}
	
?>