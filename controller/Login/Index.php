<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Login_Index
{
    public function index(){
        include_once(__VIEWFILE__ . "/login/login.html");
    }
    
    public function reset(){
        Zend_Session::destroy();
        headerLocation('/');
    }
       
}