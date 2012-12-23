<?php
defined('WEB_AUTH') or die('NO_AUTH');
class Notice_Index extends Common_Controller
{
    public function add($title,$dateline,$content,$sender){
        $dateline = strtotime($dateline);
        if($title && $dateline && $content && $sender){
            $row = array(
            'title'=>$title,
            'dateline'=>$dateline,
            'content'=>$content,
            'sender'=>$sender
            );   
            $exec = Notice_Notice::addNotice($row); 
            if($exec){
                self::returnJson(true,'添加成功');
            }else{
                self::returnJson(false,'添加失败');
            }                
        }
    }  
    
    public function delete($nid){
        $nid = checkInputValidate($nid,'Int');
        if($nid){
            $exec = Notice_Notice::deleteNotice($nid);
            if($exec){
                self::returnJson(true,'删除成功');
            }else{
                self::returnJson(false,'删除失败');
            }  
        }

    }   
    
    public function edit($nid,$title,$dateline,$content,$sender){
        $nid = checkInputValidate($nid,'Int');
        if($nid && $title && $dateline && $content && $sender){
            $set = array(
            'title'=>$title,
            'dateline'=>$dateline,
            'content'=>$content,
            'sender'=>$sender
            );  
            $exec = Notice_Notice::editNotice($set,$nid);
            if($exec){
                self::returnJson(true,'编辑成功');
            }else{
                self::returnJson(false,'编辑失败');
            }  
        }

    }   
       
}
$server = new Zend_Rest_Server();
header('Content-type: application/json');
$server->setClass('Notice_Index');
$server->handle();
