<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Login_Index extends Common_Controller
{
    
    public function __construct(){
    }
    
    public function login($username,$password){
        if($username && $password){
            $adminRs = Admin_Admin::getAdminByUsername($username);
            if (!$adminRs) {
                self::returnJson(false,'用户名不存在');
            }else{
                if ($adminRs['password'] != md5(md5($password) . $adminRs['salt'])) {
                   self::returnJson(false,'密码错误');
                }else{
                    $adminSession = new Zend_Session_Namespace('adminSession');
                    $adminSession->roleid = $adminRs['roleid'];
                    $adminSession->username = $username;
                    self::returnJson(true);
                }   
            }        
        }else{
            self::returnJson(false,'登录失败');
        }
    }         
}
$server = new Zend_Rest_Server();
header('Content-type: application/json');
$server->setClass('Login_Index');
$server->handle();
