<?php
class Admin_Admin
{
    /**
     *   查询管理员BY 用户名
     * @author oudy
     * @return array
     */  
    public static function getAdminByUsername($username){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_admin', array('username','password','salt','roleid'))
               ->where('username = ?', $username);
    	$rs=$db->fetchRow($sql);
    	return $rs;
    }
    
    /**
     *   管理员列表
     * @author oudy
     * @return array
     */  
    public static function getAdminList($startpos=0,$eachpage=100){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_admin', '*')
               ->join('sg_admin_role', 'sg_admin.roleid = sg_admin_role.arid', 'name')        
               ->order('sg_admin.aid','desc')
               ->limit($eachpage,$startpos);
    	$rs=$db->fetchAll($sql);
    	return $rs;
    }
    
    /**
     * 获得管理员总数
     * @author oudy
     */ 
    public static function getAdminCount(){
        $db=DB_DBtbase::getDb();
    	$sql="SELECT count(*) AS total FROM sg_admin ";
    	$total=$db->fetchOne($sql);
    	return $total;
    }
    
    /**
     *   管理员列表
     * @author oudy
     * @return array
     */  
    public static function getAdminRoleList($startpos=0,$eachpage=100){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_admin_role', '*')
               ->order('order','desc');
    	$rs=$db->fetchAll($sql);
    	return $rs;
    }
    
}
