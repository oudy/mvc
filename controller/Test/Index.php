<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Test_Index
{
    public function index(){
        echo 'test';     
    }
    
    public function fckeditor(){
        include_once(__VIEWFILE__ . "/test/fckeditor.html");
    }    
       
}