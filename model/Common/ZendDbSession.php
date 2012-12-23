<?php
/**
 * Session 跨站设计 保存于数据库
 * @author oudy
 * 用法:
 * Common_ZendDbSession::start();
 * $sess = new Zend_Session_Namespace('count');  
 * if(isset($sess->count)) {  
        $sess->count += 1;  
 * }else {  
        $sess->count = 1;  
 * }  
 */
class Common_ZendDbSession
{    
    // TODO ADD MEMCACHE
    public function start(){
        if(__SESSION_SAVE_METHOD__==2){
            $db=DB_DBtbase::getDb();
            $dbColumn = array(
                'db' => $db 
                ,'name' => 'sg_session'
                ,'primary' => 'id'
                ,'modifiedColumn' => 'modified'
                ,'lifetimeColumn' => 'lifetime'
                ,'dataColumn' => 'data'
            );
            Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($dbColumn));         
        }
        Zend_Session::start();
    }

    
}