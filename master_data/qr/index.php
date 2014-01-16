<?php

if(!$_REQUEST["url"]) exit;

$url = $_REQUEST["url"];

require("./qrcode_img.php");

Header("Content-type: image/png");


$size = (!empty($_REQUEST["size"])) ? $_REQUEST["size"] : 2;

$z=new Qrcode_image;

#$z->set_qrcode_version(1);           # set qrcode version 1
#$z->set_qrcode_error_correct("H");   # set ecc level H
$z->set_module_size($size);              # set module size 3pixel
#$z->set_quietzone(5);                # set quietzone width 5 modules


$z->qrcode_image_out($url,"png");

#$z->image_out($z->cal_qrcode($data),"png");   #old style

?>
