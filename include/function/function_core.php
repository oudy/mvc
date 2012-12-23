<?php
function checkint($str, $def)
{
    //检测输入的是否是整数
    //str 输入的字符串，def如果str非法则返回的整数
    $result = "";
    $str = strval(trim($str));
    if (strlen($str) == 0 || is_null($str))
    {
        $result = $def;
        return $result;
    }
    if (is_numeric($str))
        $result = intval($str);
    else
        $result = $def;
    return $result;
}

function checknumber($str, $def)
{
    $result = "";
    if (strlen($str) == 0 || is_null($str))
    {
        $result = $def;
        return $result;
    }
    if (is_numeric($str))
    {
        $result = $str;
    } else
    {
        $result = $def;
    }
    return $result;
}

function checksqlstr($getstr)
{
    //检测输入的参数是否含有sql敏感字符，如果有返回过滤后的符串
    if(is_array($getstr)){
        return $getstr;
    }else{
        $getstr = trim($getstr);
    }
    if (strlen($getstr) == 0 || is_null($getstr))
    {
        $result = '';
        return $result;
    }
    $pattern = array('/\biframe\b/i', '/\bjavascript\b/i', '/\bvbscript\b/i', '/\bscript\b/i',
        '/\bselect\b/i', '/\binsert\b/i', '/\bdrop\b/i',
        '/\bcreate\b/i', '/\bexec\b/i', '/\btruncate\b/i', '/\bcha?r\b/i', '/\bdeclare\b/i');
    $rep = array_fill(0, count($pattern), '');
    $getstr = preg_replace($pattern, $rep, $getstr);

    $s = array("'",'"',chr(0), '0x' , '   ', "\r\n", "\n");
    $r = array("&acute;",'&quot;','', '', ' ', '<br>', '<br>');
    
    $getstr = str_replace($s, $r, $getstr);
    return $getstr;
}

function jstop($strmsg)
{
    //'显示信息并回退一步
    $html = "<script>alert('" . $strmsg . "');if(history.length==0){window.opener='';window.close();}else{history.go(-1);}</script>";
    echo $html;
    exit();
}
function showmsgbox($strmsg, $strurl)
{
    //显示信息
    $html = "<script>alert('" . $strmsg . "');window.location.href='" . $strurl .
        "'</script>";
    //$html = "<script>alert('" . $strmsg . "');</script>";
    echo $html;
    exit();
}


function jsRedirect($strurl)
{
    //显示信息
    $html = "<script>window.location.href='" . $strurl . "';</script>";
    echo $html;
    exit();
}
/**
 * 以下得到随机密码
 */
function getRndCode($iCount)
{
    $strCode = "";
    $arrChar = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $k = strlen($arrChar);
    for ($i = 1; $i < $iCount; $i++)
    {
        $j = intval(rand(1, $k)) + 1;
        $strCode .= substr($arrChar, $j, 1);
    }
    return $strCode;
}


/**
 * 返回$_GET 值
 * @param $validateType 检查类型
 * @param $val 默认值
 * @return 当检查格式不正确时 返回''
 */
function GET($key, $validateType = '',$val = '')
{
    $temp = isset($_GET[$key]) ? checksqlstr($_GET[$key]) : $val;
    if ($temp === '0')
    {
        return '0';
    }
    $str = empty($_GET[$key]) ? $val : checksqlstr($_GET[$key]);
    if($validateType){
        return checkInputValidate($str,$validateType);
    }
    return $str;
}
/**
 * 返回$_POST 值
 * @param $validateType 检查类型
 * @param $val 默认值
 * @return 当检查格式不正确时 返回''
 */
function POST($key, $validateType = '',$val = '')
{
    $temp = isset($_POST[$key]) ? checksqlstr($_POST[$key]) : $val; 
    if ($temp === '0')
    {
        return '0';
    }
    $str = empty($_POST[$key]) ? $val : checksqlstr($_POST[$key]);
    if($validateType){
        return checkInputValidate($str,$validateType);
    }
    return $str;
}

/**
 * 返回isset() 值
 */
function IS_SET($key)
{
    return isset($key) ? $key : '';
}


/**
 * 返回$_POST 值
 * @param $validateType 检查类型
 * @param $val 默认值
 * @return 当检查格式不正确时 返回''
 */
function REQUEST($key, $validateType = '',$val = '')
{
    $temp = isset($_REQUEST[$key]) ? checksqlstr($_REQUEST[$key]) : $val;
    if ($temp === '0')
    {
        return '0';
    }
    $str = empty($_REQUEST[$key]) ? $val : checksqlstr($_REQUEST[$key]);
    if($validateType){
        return checkInputValidate($str,$validateType);
    }
    return $str;
}
/**
 * 页面重定向
 */
function headerLocation($page)
{
	header('location: ' . $page);
    exit();
}

function checkInputValidate($value,$validateType){
    $checkArray = array(
    'Alnum',//字母和数字
    'Alpha',//字母
    'Date',//格式为YYYY-MM-DD的有效日期
    'Digits',//数字
    'EmailAddress',//邮箱
    'Float',//浮点数
    'Ip',//IP
    'NotEmpty',//非空
    'Zipcode',//邮政编码
    'Int',//整数
    'Mobile',//手机
    'Qq',//QQ
    'Telephone',//电话
    'Chn',//全是汉字
    'Url',// http 网址
    'Bodycard',//身份证
    );
    if(in_array($validateType,$checkArray)){
        return Zend_Validate::is($value, $validateType)?$value:'';// 这里会作进一步处理
    }else{
        return $value;
    }
        
}


/**
 * 获得真实IP值
 */
function getIP()
{
    $realip="";
    if (isset($_SERVER))
    {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])){
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else if(isset($_SERVER["REMOTE_ADDR"])){
                $realip = $_SERVER["REMOTE_ADDR"];
            }
    } else
    {
        if (getenv("HTTP_X_FORWARDED_FOR"))
        {
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else
            if (getenv("HTTP_CLIENT_IP"))
            {
                $realip = getenv("HTTP_CLIENT_IP");
            } else
            {
                $realip = getenv("REMOTE_ADDR");
            }
    }
    return $realip;
}


/**
 *二维数组和 *
 *
 * @param array $array
 * @param string $col
 * @return int 
 */
function arrcol_sum($array, $col)
{
    $sum = 0;
    foreach ($array as $key => $val)
        $sum += $val[$col];
    return $sum;
}


/**
 * 判断是几维数组 by ouyd
 */
function getmaxdim($vDim)
{
    if (!is_array($vDim))
        return 0;
    else
    {
        $max1 = 0;
        foreach ($vDim as $item1)
        {
            $t1 = getmaxdim($item1);
            if ($t1 > $max1)
                $max1 = $t1;
        }
        return $max1 + 1;
    }
}

/**
 * 截取中文标题不会出现乱码 两个英文只抵一个中文
 * @author oudy
 */
function mbSubstrNew($str, $start, $len,$dot=true)
{
    $sumlen = mb_strlen($str,'utf-8');
    if($len>$sumlen){$len = $sumlen;}
    $newlen = $len;
    for($i = 0;$i<$len;$i++){
        $onezi = mb_substr($str, $i, 1,'utf-8');
        if(preg_match('#\w|\-|_{1}#is',$onezi)){
            $newlen += 0.3;
            $len += 0.3;
        }
    }
    $newlen = round($newlen);   
    if ($sumlen > $newlen)
    {
        $str = mb_substr($str, $start, $newlen,'utf-8');
        if($dot){$str.='..';}
    }   
    return $str;
}
/**
 * 二维数组排序
 * @author oudy
 */
function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC)
{
	$key_array=array();
    if (is_array($multi_array))
    {
        foreach ($multi_array as $row_array)
        {
            if (is_array($row_array))
            {
                $key_array[] = $row_array[$sort_key];
            } else
            {
                return - 1;
            }
        }
    } else
    {
        return - 1;
    }

    array_multisort($key_array, $sort, $multi_array);
    return $multi_array;
}


function format_date($time)
{
    $hour = 1 * 60 * 60;
    $now = time();
    if ($now - $time < 60)
    {
        //1分钟内
        $temp = $now - $time;
        if ($temp == 0)
        {
            $temp = 1;
        }
        return ($temp) . '秒前';
    }
    if ($now - $time < $hour)
    {
        //1小时内
        return ((int)(($now - $time) / 60)) . '分钟前';
    }
    if (date("m.d.y", $time) == date("m.d.y", $now))
    {
        //今天
        return date('今天 H:i', $time);
    }
    //直接格式化成时间
    return date('m月d日 H:i', $time);

}


function getCreateFilePath($absolutePath = null)
{
    $absolutePath = $absolutePath ? $absolutePath : __ATTACHMENTFILE__;
    $path = $absolutePath . '/' . date('Ym');
    if (PATH_SEPARATOR != ':') // 兼容linux WINDOW

    {
        $path = str_replace('/', '\\', $path);
    }
    return $path;
}

/**
 * 获得附件地址
 */
function getAttachmentUrl($avatar)
{
    return empty($avatar) ? '' : __ATTACHMENT_URL__ .
        '/' . $avatar;
}

function includeTemplate($fileName) {
    include_once __DOCUMENT_ROOT__ . "/view/templates/{$fileName}";
}

/**
 * URL 正则
 * @author oudy
 */
 
 function getHttpUrlMatch($content){
 preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9_\-]+\.)+[A-Za-z0-9]{1,4}\:?\d{0,5}(?:\/[\w\d\/=\?%\-\&_\~`@\:\+\#\.]*(?:[^<>\'\"\n\r\t\s\[\]\，\。][^\x{4e00}-\x{9fa5}])*)?~iu',
            $content, $match);
 return $match;
 }
 
/**
 * 文件是否真的可读 
 * is_readable() 有BUG
 * @author oudy
 */
function isReadable($filename)
{
    if (!$fh = @fopen($filename, 'r', true)) {
        return false;
    }
    @fclose($fh);
    return true;
}

/**
 * 格式化输出信息 
 */
function prf($data) {
	echo '<br/><pre>';
	print_r($data);
	echo '</pre>';
	echo '<hr color="';
	if (function_exists('rndcolor')) {
		echo rndcolor();
	} else {
		echo '#ccc';
	}
	echo '"/><br />';
}
/**
 * 颜色随机器 
 */
function rndcolor() {
	$str = '#';
	$arr = array (
		'0',
		'1',
		'2',
		'3',
		'4',
		'5',
		'6',
		'7',
		'8',
		'9',
		'A',
		'B',
		'C',
		'D',
		'E',
		'F'
	);
	for ($i = 0; $i < 6; $i++) {
		$str .= $arr[array_rand($arr)];
	}
	return $str;
}

 
