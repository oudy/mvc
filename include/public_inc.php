<?php
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('PRC');
if(isset($_SERVER['HTTP_PROXY_HOST'])&&!empty($_SERVER['HTTP_PROXY_HOST'])){
	//代理中转
	$website='http://'.$_SERVER['HTTP_PROXY_HOST'];
}else{
	$website='http://'.$_SERVER['HTTP_HOST'];	
}
define('__WEBSITE__',$website);
define('__ATTACHMENTFILE__',__DOCUMENT_ROOT__.'/data/attachment');
define('__VIEWFILE__',__DOCUMENT_ROOT__.'/view/templates');
define('__ATTACHMENT_URL__','/data/attachment');
include_once(__DOCUMENT_ROOT__."/include/bootstrap.php");
include_once(__DOCUMENT_ROOT__."/config/config_global.php");
include_once(__DOCUMENT_ROOT__."/include/function/function_core.php");

