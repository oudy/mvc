<?php
defined('IN_PHPCMS') or exit('Access Denied');

class db_mysql
{
	var $connid;
	var $querynum = 0;
	var $iscache = 0;
	var $caching = 0;
	var $cachedir = '';
	var $expires = 3600;
	var $isclient = 0;
	var $cursor = 0; 
	var $result = array();
	var $cache_id = ''; 
	var $cache_file = ''; 
	var $dbname = '';

	function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) 
	{
		global $CONFIG;
		if($pconnect)
		{
			if(!$this->connid = @mysql_pconnect($dbhost, $dbuser, $dbpw))
			{
				$this->halt('Can not connect to MySQL server');
			}
		}
		else
		{
			if(!$this->connid = @mysql_connect($dbhost, $dbuser, $dbpw)) 
			{
				$this->halt('Can not connect to MySQL server');
			}
		}
		if($this->version() > '4.1' && $CONFIG['dbcharset'])
        {
			mysql_query("SET NAMES '".$CONFIG['dbcharset']."'" , $this->connid);
		}
		if($this->version() > '5.0') 
		{
			mysql_query("SET sql_mode=''" , $this->connid);
		}
		if($dbname) 
		{
			if(!@mysql_select_db($dbname , $this->connid))
			{
				$this->halt('Cannot use database '.$dbname);
			}
			$this->dbname = $dbname;
		}
		return $this->connid;
	}

	function select_db($dbname) 
	{
		return mysql_select_db($dbname , $this->connid);
	}

	function query($sql , $type = '' , $expires = 3600, $dbname = '') 
	{
		if($this->isclient)
		{
			$dbname = $dbname ? $dbname : $this->dbname;
			$this->select_db($dbname);
		}
		if($this->iscache && $type == 'CACHE' && stristr($sql, 'SELECT'))
		{
			$this->caching = 1;
			$this->expires = $expires;
			return $this->_query_cache($sql);
		}
		$this->caching = 0;
		$func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql , $this->connid)) && $type != 'SILENT')
		{
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		return $query;
	}

	function get_one($sql, $type = '', $expires = 3600, $dbname = '')
	{
		$query = $this->query($sql, $type, $expires, $dbname);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs;
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) 
	{
		return $this->caching ? $this->_fetch_array($query) : mysql_fetch_array($query, $result_type);
	}

	function affected_rows() 
	{
		return mysql_affected_rows($this->connid);
	}

	function num_rows($query) 
	{
		return $this->caching ? $this->_num_rows($query) : mysql_num_rows($query);
	}

	function num_fields($query) 
	{
		return mysql_num_fields($query);
	}

	function result($query, $row) 
	{
		return @mysql_result($query, $row);
	}

    function list_tables($query) 
	{
		return mysql_list_tables($query);
	}

	function free_result($query) 
	{
		if($this->caching==1) $this->result = array();
		else @mysql_free_result($query);
	}

	function insert_id() 
	{
		return mysql_insert_id($this->connid);
	}

	function fetch_row($query) 
	{
		return mysql_fetch_row($query);
	}

	function version() 
	{
		return mysql_get_server_info($this->connid);
	}

	function close() 
	{
		return mysql_close($this->connid);
	}

	function _query_cache($sql)
	{
		$this->cache_id = md5($sql);
		$this->result = array();
		$this->cursor = 0;
		$this->cache_file = $this->_get_file();
		if($this->_is_expire())
		{
			$this->result = $this->_get_array($sql);
			$this->_save_result();
		}
		else
		{
		    $this->result = $this->_get_result();
		}
		return $this->result;
	}

	function _fetch_array($result = array())
	{
		if($result) $this->result = $result;
        return isset($this->result[$this->cursor]) ? $this->result[$this->cursor++] : FALSE; 
	} 

	function _num_rows($result = array())
	{ 
		if($result) $this->result = $result;
	    return count($this->result); 
	} 

	function _save_result()
	{
		if(!is_array($this->result)) return FALSE;
		dir_create(dirname($this->cache_file));
        file_put_contents($this->cache_file, "<?php\n return ".var_export($this->result, TRUE).";\n?>");
		@chmod($this->cache_file, 0777);
	}

	function _get_array($sql)
	{
		$this->cursor = 0; 
		$arr = array(); 
		$result = mysql_unbuffered_query($sql, $this->connid);
		while($row = mysql_fetch_assoc($result))
		{
			$arr[] = $row; 
		} 
		$this->free_result($result);
		$this->querynum++;
		return $arr;
	}

	function _get_result()
	{
         return include $this->cache_file;
	}

	function _is_expire()
	{
		global $PHP_TIME;
		return !file_exists($this->cache_file) || ( $PHP_TIME > @filemtime($this->cache_file) + $this->expires );
	}

	function _get_file()
	{
		global $CONFIG;
		return $CONFIG['dbcachedir'].substr($this->cache_id, 0, 2).'/'.$this->cache_id.'.php';
	}

	function error()
	{
		return @mysql_error($this->connid);
	}

	function errno()
	{
		return intval(@mysql_errno($this->connid)) ;
	}

	function halt($message = '', $sql = '')
	{
		exit('MySQL Query:'.$sql.' <br> MySQL Error:'.$this->error().' <br> MySQL Errno:'.$this->errno().' <br> Message:'.$message);
	}
}


class dbstuff {

	var $version = '';
	var $querynum = 0;
	var $link;

	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE) {

		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$this->link = @$func($dbhost, $dbuser, $dbpw)) {
			$halt && $this->halt('Can not connect to MySQL server');
		} else {
			if($this->version() > '4.1') {
				global $charset, $dbcharset;
				$dbcharset = !$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8')) ? str_replace('-', '', $charset) : $dbcharset;
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $this->link);
			}
			$dbname && @mysql_select_db($dbname, $this->link);
		}

	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}
	function query($sql, $type = '') {
		global $debug, $discuz_starttime, $sqldebug, $sqlspenttimes;

		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->close();
				require './config.inc.php';
				$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
				$this->query($sql, 'RETRY'.$type);
			} elseif($type != 'SILENT' && substr($type, 5) != 'SILENT') {
				$this->halt('MySQL Query Error', $sql);
			}
		}

		$this->querynum++;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->link);
		}
		return $this->version;
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
		echo 'SQL Error:<br />'.$message.'<br />'.$sql;
	}
}



?>