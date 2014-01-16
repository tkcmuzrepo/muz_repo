<?php

require_once(MODELS."MainModel.php");

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends MainModel{
		
		function __construct(){
				parent::__construct();
				if(!DEBUG) return;
		}
}