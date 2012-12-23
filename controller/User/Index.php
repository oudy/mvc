<?php
defined('WEB_AUTH') or die('NO_AUTH');
class User_Index
{
    public function index(){
        $page = REQUEST('page', '',0);
        $query = array();
        $eachpage = 35;
        $startpos = empty($_GET['page']) ? 0 : 
        (intval($_GET['page']) - 1) * $eachpage;
        $pageTotal = 0;
        $rsUser = User_Virtual::getUserList($startpos,$eachpage);
        $pageTotal = User_Virtual::getUserCount();
        $pager = Common_Pager::renderNavigator($pageTotal, $page, 
        http_build_query($query), $eachpage);
        include_once(__VIEWFILE__ . "/user/virtual.html");
    }
       
}