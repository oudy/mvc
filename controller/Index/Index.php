<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Index_Index extends Common_Controller
{
    public function index(){
        require(__VIEWFILE__ . "/main.php");
    }
}





