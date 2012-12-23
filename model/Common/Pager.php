<?php
/**
 * 分页类
 */
class Common_Pager
{
    protected $db;
    
    protected $sql;
    
    protected $window_width;
    
    protected $total_records;
    
    protected $page_records;
    
    protected $current_page;
    
    protected $total_pages;
    
    /**
     * 获取导航HTML
     *
     * @param int $total_records 总记录数
     * @param int $current_page 当前页码
     * @param string $query 其它参数
     * @param int $page_records 每页记录数
     * @param int $window_width 导航宽度
     * @param string $base_url 基带网址
     * @return string 
     */
    static public function renderNavigator ($total_records, $current_page, $query = '', $page_records = 35, $window_width = 3, $base_url = '',$showlastpage=true)
    {
        if(!empty($query)){
        	$query='&'.$query;
        }
    	$total_pages = ceil($total_records / $page_records);
        if ($total_pages<2)
            return '';
        
        if (1 >= $current_page)
        {
            $current_page = 1;
        }
        else if ($current_page >= $total_pages)
        {
            $current_page = $total_pages;
        }
        
        $start = $current_page - $window_width;
        $start_sp = '<span> ... </span>';
        if (2 > $start)
        {
            $start_sp = '';
            $start = 2;
        }
        
        $end = $current_page + $window_width;
        $end_sp = '<span> ... </span>';
        if ($end >= $total_pages)
        {
            $end_sp = '';
            $end = $total_pages - 1;
        }
        
        $navigator = '';
        for (; $start <= $end; $start++)
        {
            if ($current_page == $start)
                $navigator .= " <strong>{$start}</strong> ";
            else
                $navigator .= " <a href=\"{$base_url}?page={$start}{$query}\">{$start}</a> ";
        }
        
        if (1 >= $current_page)
        {
            $navigator = "<strong>1</strong>" . $navigator;
        }
        else
        {
            $prev = $current_page - 1;
            $navigator = "<a href=\"{$base_url}?page=1{$query}\">1</a>" . $start_sp . $navigator;
            $navigator = "<a href=\"{$base_url}?page={$prev}{$query}\" class=\"pageBtn\">&lt;&lt; 上一页</a>" . $navigator;
        }
        
        if (1 < $total_pages)
        {
            if ($current_page >= $total_pages)
            {
                $navigator = $navigator . "<strong>{$total_pages}</strong>";
            }
            else
            {
                $next = $current_page + 1;
                $navigator = $navigator . $end_sp;
                if($showlastpage){
                	$navigator.="<a href=\"{$base_url}?page={$total_pages}{$query}\">{$total_pages}</a>";
                }
                $navigator = $navigator . "<a href=\"{$base_url}?page={$next}{$query}\" class=\"pageBtn\">下一页 &gt;&gt;</a>";
            }
        }
        
        return $navigator;
    }
    
	static public function renderPlaceNavi ($total_records, $current_page, $query = '', $page_records = 30, $window_width = 3, $base_url = '')
    {
    	if(!empty($query)){
    		$query='&'.$query;
    	}
    	$total_pages = ceil($total_records / $page_records);
        if ($total_pages<2)
        	//2页一下都不显示
            return '';
        
        if (1 >= $current_page)
        {
            $current_page = 1;
        }
        else if ($current_page >= $total_pages)
        {
            $current_page = $total_pages;
        }
        
        $start = $current_page - $window_width;
        $start_sp = '<span> ... </span>';
        if (2 > $start)
        {
            $start_sp = '';
            $start = 2;
        }
        
        $end = $current_page + $window_width;
        $end_sp = '<span> ... </span>';
        if ($end >= $total_pages)
        {
            $end_sp = '';
            $end = $total_pages - 1;
        }
        
        $navigator = '';
        for (; $start <= $end; $start++)
        {
            if ($current_page == $start)
                $navigator .= " <strong>{$start}</strong> ";
            else
                $navigator .= " <a href=\"{$base_url}?page={$start}{$query}\">{$start}</a> ";
        }
        
        if (1 >= $current_page)
        {
            $navigator = "<strong>1</strong>" . $navigator;
        }
        else
        {
            $prev = $current_page - 1;
            $navigator = "<a href=\"{$base_url}?page=1{$query}\">1</a>" . $start_sp . $navigator;
            $navigator = "<a href=\"{$base_url}?page={$prev}{$query}\" class=\"pageBtn\">&lt;&lt; 上一页</a>" . $navigator;
        }
        
        if (1 < $total_pages)
        {
            if ($current_page >= $total_pages)
            {
                $navigator = $navigator . "<strong>{$total_pages}</strong>";
            }
            else
            {
                $next = $current_page + 1;
                $navigator = $navigator . $end_sp . "<a href=\"{$base_url}?page={$total_pages}{$query}\">{$total_pages}</a>";
                $navigator = $navigator . "<a href=\"{$base_url}?page={$next}{$query}\" class=\"pageBtn\">下一页 &gt;&gt;</a>";
            }
        }
        
        return $navigator;
    }
    
    static public function getPage ($data_sql, $total_records, $page_no, $page_records)
    {
        $total_pages = ceil($total_records / $page_records);
        
        if (1 >= $page_no)
            $page_no = 1;
        else if ($page_no >= $total_pages)
            $page_no = $total_pages;
        
        $offset = ($page_no-1) * $page_records;
        
        return "{$data_sql} LIMIT $offset, {$page_records}";
    }

    public function __construct (&$db, $sql, $page_records = 30, $window_width = 5)
    {
        $this->db = $db;
        $this->sql = $sql;
        $this->window_width = $window_width;
        $this->total_records = 0;
        $this->page_records = $page_records;
        $this->current_page = 1;
        $this->total_pages = 0;
    }
    
    protected function devidePage ()
    {
        if ($this->total_records)
        {
            return;
        }
        
        $res = $this->db->query($sql);
        $this->total_records = intval($res->rowCount());
        
        $this->total_pages = ceil($this->total_records / $this->page_records);
    }

    public function getPageSql ($page_no)
    {
        if (0 >= $page_no || $page_no > $this->total_pages)
        {
            return null;
        }
        
        $offset = ($page_no-1) * $this->page_records;
        
        return "{$this->sql} LIMIT $offset, {$this->page_records}";
    }
    
    public function getNavigator ($base_url, $query = '')
    {
        $start = $this->current_page - $this->window_width;
        $start_sp = '...';
        if (2 > $start)
        {
            $start_sp = '';
            $start = 2;
        }
        
        $end = $this->current_page + $this->window_width;
        $end_sp = '...';
        if ($end >= $this->total_pages)
        {
            $end_sp = '';
            $end = $this->total_pages - 1;
        }
        
        $navigator = '';
        for (; $start <= $end; $start++)
        {
            if ($current_page == $start)
                $navigator .= " <strong>{$start}</strong> ";
            else
                $navigator .= " <a href=\"{$base_url}?page={$start}&{$query}\">{$start}</a> ";
        }
        
        if ($this->current_page == 1 || 0 >= $this->current_page - 1)
        {
            $navigator = "<a href=\"#\">1</a>" . $navigator;
        }
        else
        {
            $prev = $this->current_page - 1;
            $navigator = "<a href=\"{$base_url}?page=1&{$query}\">1</a>" . $start_sp . $navigator;
            $navigator = "<a href=\"{$base_url}?page={$prev}&{$query}\">上一页</a>" . $navigator;
        }
        
        if ($this->current_page == $this->total_pages || $this->current_page >= $this->total_pages)
        {
            $navigator = $navigator . "<strong>{$this->total_pages}</strong>";
        }
        else
        {
            $next = $this->current_page + 1;
            $navigator = $navigator . $end_sp . "<a href=\"{$base_url}?page={$total_pages}&{$query}\">{$total_pages}</a>";
            $navigator = $navigator . "<a href=\"{$base_url}?page={$next}&{$query}\" class=\"pageBtn\">下一页 &gt;&gt;</a>";
        }
        
        return $navigator;
    }

    //图片导航
    static public function renderPicNavigator ($query = '',$firstpage=false,$lastpage=false,$base_url='')
    {
    	
    	$prev=-1;
    	$next=1;
    	$navigator="";
    	if(!$firstpage){
	    	$navigator = "<a href=\"{$base_url}?page={$prev}&{$query}\" class=\"pageBtn\">&lt;&lt; 上一页</a>" . $navigator;
    	}
    	if(!$lastpage){
	    	$navigator = $navigator . "<a href=\"{$base_url}?page={$next}&{$query}\" class=\"pageBtn\">下一页 &gt;&gt;</a>";
    	}
    	return $navigator;
    }
}