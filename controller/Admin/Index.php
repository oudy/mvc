<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Admin_Index
{
    public function index(){
        $page = REQUEST('page', '',0);
        $query = array();
        $eachpage = 2;
        $startpos = empty($_GET['page']) ? 0 : 
        (intval($_GET['page']) - 1) * $eachpage;
        $pageTotal = 0;
        $rsAdmin = Admin_Admin::getAdminList($startpos,$eachpage);
        $pageTotal = Admin_Admin::getAdminCount();
        $pager = Common_Pager::renderNavigator($pageTotal, $page, 
        http_build_query($query), $eachpage);
        include_once(__VIEWFILE__ . "/admin/admin.html");
    }
    
    public function add(){
        $rsAdminRole = Admin_Admin::getAdminRoleList();
        include_once(__VIEWFILE__ . "/admin/add.html");
        
    }
       
}