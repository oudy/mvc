<?php
class User_Virtual
{
    /**
     *   用户列表
     * @author oudy
     * @return array
     */  
    public static function getUserList($startpos=0,$eachpage=100){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select()->from('sg_user', '*')
               //->where('uid = ?', '1')
               ->order('uid','desc')
               ->limit($eachpage,$startpos);
    	$rs=$db->fetchAll($sql);
    	return $rs;
    }
    
    /**
     * 获得用户总数
     */ 
    public static function getUserCount(){
        $db=DB_DBtbase::getDb();
    	$sql="SELECT count(1) AS total FROM sg_user ";
    	$total=$db->fetchOne($sql);
    	return $total;
    }
    
    /**
     * 添加 用户
     */    
    public static function addUser($row)
    {
    	$db=DB_DBtbase::getDb();
    	$rows_affected = $db->insert('sg_user', $row);
    	$last_insert_id = $db->lastInsertId();
    	return $last_insert_id;
        //MYSQL 触发器 addUserCount 自动添加 sg_user_count 记录
    }  
	/**
	 * 修改用户信息
	*/
	public  static  function edituser($set,$uid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_user';
		$where = $db->quoteInto('uid = ? ', $uid);
		$rows_affected = $db->update($table, $set, $where);
		return $rows_affected;
	}  
    
	/**
	* 删除用户
	*/
	public  static  function deleteUser($uid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_user';
		$where = $db->quoteInto('uid = ?', intval($uid));
		$rows_affected = $db->delete($table, $where);
		return $rows_affected;
	}

}
