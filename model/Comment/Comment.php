<?php
class Comment_Comment
{
    /**
     * 评论列表
     * @author oudy
     * @return array
     */  
    public static function getCommentList($startpos=0,$eachpage=100){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_comment', '*')
               ->order('cid','desc')
               ->limit($eachpage,$startpos);
    	$rs=$db->fetchAll($sql);
    	return $rs;
    }
    
    
    /**
     * 获得评论总数
     */ 
    public static function getCommentCount(){
        $db=DB_DBtbase::getDb();
    	$sql="SELECT count(*) AS total FROM sg_comment ";
    	$total=$db->fetchOne($sql);
    	return $total;
    }
    
    /**
     * 某条评论信息
     * @author oudy
     * @return array
     */  
    public static function getCommentById($cid){        
        $db=DB_DBtbase::getDb();
        $sql = $db->select();
        $sql->from('sg_comment', '*')
              ->where('cid = ?', $cid);
    	$rs=$db->fetchRow($sql);
    	return $rs;
    }
    
    /**
     * 添加评论
     */    
    public static function addComment($row)
    {
    	$db=DB_DBtbase::getDb();
    	$rows_affected = $db->insert('sg_comment', $row);
    	$last_insert_id = $db->lastInsertId();
    	return $last_insert_id;
    }  
	/**
	 * 修改评论信息
	*/
	public  static  function editComment($set,$cid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_comment';
		$where = $db->quoteInto('cid = ? ', $cid);
		$rows_affected = $db->update($table, $set, $where);
		return $rows_affected;
	}  
    
	/**
	* 删除评论
	*/
	public  static  function deleteComment($cid)
	{
		$db=DB_DBtbase::getDb();
		$table = 'sg_comment';
		$where = $db->quoteInto('cid = ?', intval($cid));
		$rows_affected = $db->delete($table, $where);
		return $rows_affected;
	}

}
