<?php
define('WEB_AUTH', true);
define('__DOCUMENT_ROOT__', dirname(__FILE__) );
include_once (__DOCUMENT_ROOT__ . "/include/public_inc.php");
Common_ZendDbSession::start();


$_G = array();//公共变量
/**
 * 默认重写规则 /模块($module)/PHP文件($phpFile)/动作($action)/参数1/参数1值/参数2/参数2值/参数3/参数3值/...
 */
 
$route = new Common_Route;
$route->run();

// 不清楚参数请打印









