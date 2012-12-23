<?php
/**
 * 控制层父类
 */
abstract class Common_Controller
{
    public function __construct(){
        global $_G;
        $this->_G = $_G;
        $adminSession = new Zend_Session_Namespace('adminSession');
        if (!isset($adminSession->username) || empty($adminSession->username)) {
              headerLocation('/login');
        }

    }
    
    public function returnJson($result=true,$msg=''){
    	$ret=array('success'=>$result,'msg'=>$msg);
    	echo json_encode($ret);
        exit;
    }    
    
}