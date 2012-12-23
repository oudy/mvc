<?php
class Notice_Notice
{
    /**
     * 公告列表
     * @author oudy
     * @return array
     */  
    public static function getNoticeList($startpos=0,$eachpage=100){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_notice', '*')
               ->order('nid','desc')
               ->limit($eachpage,$startpos);
    	$rs=$db->fetchAll($sql);
    	return $rs;
    }
    
    
    /**
     * 获得公告总数
     */ 
    public static function getNoticeCount(){
        $db=DB_DBtbase::getDb();
    	$sql="SELECT count(*) AS total FROM sg_notice ";
    	$total=$db->fetchOne($sql);
    	return $total;
    }
    
    /**
     * 某条公告信息
     * @author oudy
     * @return array
     */  
    public static function getNoticeById($nid){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_notice', '*')
              ->where('nid = ?', $nid);
    	$rs=$db->fetchRow($sql);
    	return $rs;
    }
    
    /**
     * 添加公告
     */    
    public static function addNotice($row)
    {
    	$db=DB_DBtbase::getDb();
    	$rows_affected = $db->insert('sg_notice', $row);
    	$last_insert_id = $db->lastInsertId();
    	return $last_insert_id;
    }  
	/**
	 * 修改公告信息
	*/
	public  static  function editNotice($set,$nid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_notice';
		$where = $db->quoteInto('nid = ? ', $nid);
		$rows_affected = $db->update($table, $set, $where);
		return $rows_affected;
	}  
    
	/**
	* 删除公告
	*/
	public  static  function deleteNotice($nid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_notice';
		$where = $db->quoteInto('nid = ?', intval($nid));
		$rows_affected = $db->delete($table, $where);
		return $rows_affected;
	}

}
