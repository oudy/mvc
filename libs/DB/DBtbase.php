<?php
//include_once ("../Zend/Db.php");
// ---------------------------------------------------
// 类 名:	Db_DBbase
// 功 能:	封装数据库操作
// 作 者: oudy
// ---------------------------------------------------
class DB_DBtbase
{
    private static $instance;
    static function getDb($dbname=__DBNAME__)
    {
        if (!(self::$instance instanceof Zend_Db_Adapter_Abstract)) {
            $params = array('host' => __HOST__, 'username' => __USERNAME__, 'password' =>
            __PASSWORD__, 'dbname' => $dbname);       
            self::$instance = Zend_Db::factory('PDO_MYSQL', $params);
            self::$instance->query('SET NAMES '.__CHARSET__);
            return self::$instance;
        } else {
            return self::$instance;
        }
    }
	public static function reset(){
		self::$instance=null;
	}
    
}