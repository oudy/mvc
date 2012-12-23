<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Notice_Index
{
    public function index(){
        $page = REQUEST('page', '',0);
        $query = array();
        $eachpage = 12;
        $startpos = empty($_GET['page']) ? 0 : 
        (intval($_GET['page']) - 1) * $eachpage;
        $pageTotal = 0;
        $rsNotice = Notice_Notice::getNoticeList($startpos,$eachpage);
        $pageTotal = Notice_Notice::getNoticeCount();
        $pager = Common_Pager::renderNavigator($pageTotal, $page, 
        http_build_query($query), $eachpage);
        include_once(__VIEWFILE__ . "/notice/index.html");
    }
      
    public function add(){
        include_once(__VIEWFILE__ . "/notice/add.html");
    }
    
    public function edit(){
        $nid = GET('nid');
        $rsNotice = Notice_Notice::getNoticeById($nid);
        if(!$rsNotice){
           exit('公告不存在'); 
        }
        include_once(__VIEWFILE__ . "/notice/edit.html");
    }    
       
       
}