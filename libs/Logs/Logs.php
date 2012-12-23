<?php

//date_default_timezone_set('PRC');
class Logs_Logs
{
    private static $_filepath; //文件路径
    private static $_filename; //日志文件名
    private static $_filehandle; //文件句柄

    /**
     *作用:初始化记录类,写入记录
     *输入:文件的路径,要写入的文件名,要写入的记录
     *输出:无
     */
    public static function addLog($log, $type = null)
    {
        //默认路径为当前路径
        //$_SERVER['DOCUMENT_ROOT']
        if (PATH_SEPARATOR == ':') {
            self::$_filepath = "/var/weblogs/" . date("Ym/d", time());
        } else {
            self::$_filepath = "/logs" . date("Ym/d", time());
        }


        //默认为以时间＋.log的文件文件
        self::$_filename = $type . date('Y-m-d', time()) . '.log';

        //生成路径字串
        $path = self::_createPath(self::$_filepath, self::$_filename);
        //判断是否存在该文件
        if (!self::_isExist($path)) { //不存在
            //没有路径的话，默认为当前目录
            if (!empty(self::$_filepath)) {
                //创建目录
                if (!self::_createDir(self::$_filepath)) { //创建目录不成功的处理
                    die("创建目录失败!");
                }
            }
            //创建文件
            if (!self::_createLogFile($path)) { //创建文件不成功的处理
                die("创建文件失败!");
            }
        }

        //生成路径字串
        $path = self::_createPath(self::$_filepath, self::$_filename);
        //打开文件
        self::$_filehandle = fopen($path, "a+");


        //传入的数组记录
        $str[] = "============================日志开始============================\r\n";
        $str[] = "GET: " . self::_getUrl() . "\r\n";
        $str[] = "Date: " . date("Y-m-d H:i:s") . "\r\n";
        $str[] = "IP: " . self::_getIP() . "\r\n";
        $str[] = "FILES: " . self::_fileData() . "\r\n";
        $str[] = "POST: " . self::_postData() . "\r\n";
        if (is_array($log)) {

            foreach ($log as $k => $v) {
                $str[] = $k . " : " . $v . "\r\n";
            }
        } else {
            $str[] = $log . "\r\n";
        }
        $str[] = "----------------------------日志结束----------------------------\r\n\r\n\r\n";
        $str = implode('', $str);


        //写日志
        if (!fwrite(self::$_filehandle, $str)) { //写日志失败
            die("写入日志失败");
        }
    }

    /**
     *作用:判断文件是否存在
     *输入:文件的路径,要写入的文件名
     *输出:true | false
     */
    private static function _isExist($path)
    {
        return file_exists($path);
    }

    /**
     *作用:创建目录
     *输入:要创建的目录
     *输出:true | false
     */
    private static function _createDir($dir)
    {
        return is_dir($dir) or (self::_createDir(dirname($dir)) and mkdir($dir, 0777));
    }

    /**
     *作用:创建日志文件
     *输入:要创建的目录
     *输出:true | false
     */
    private static function _createLogFile($path)
    {
        $handle = fopen($path, "w"); //创建文件
        fclose($handle);
        return self::_isExist($path);
    }

    /**
     *作用:构建路径
     *输入:文件的路径,要写入的文件名
     *输出:构建好的路径字串
     */
    private static function _createPath($dir, $filename)
    {
        if (empty($dir)) {
            return $filename;
        } else {
            return $dir . "/" . $filename;
        }
    }

    /**
     *作用:获取完整URL路径
     *输入:完整URL路径
     *输出:URL路径字串
     */
    private static function _getUrl()
    {
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ?
            $_SERVER['SERVER_NAME'] : 'localhost');
        return 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' :
            '') . '://' . $host . $_SERVER['REQUEST_URI'];
    }

    /**
     *作用:获取POST数据
     *输入:POST数据
     *输出:POST数组
     */
    private static function _postData()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $i = 0;
            foreach ($_POST as $key => $val) {
                //$str[] = $i == 0 ? $key . '=' . $val : '&' . $key . '=' . $val;
                $str[] = $i == 0 ? "\r\n" . $key . '=' . $val . "\r\n" : $key . '=' . $val . "\r\n";
                $i++;
            }
            $str = implode('', $str);
            return $str;
        } else {
            return 'none';
        }
    }
    
    private static function _fileData()
    {
        $str = array();
        if (isset($_FILES) && count($_FILES) > 0) {
            $i = 0;
            foreach ($_FILES['file'] as $key => $val) {
                //$str[] = $i == 0 ? $key . '=' . $val : '&' . $key . '=' . $val;
                $str[] = $i == 0 ? "\r\n" . $key . '=' . $val . "\r\n" : $key . '=' . $val . "\r\n";
                $i++;
            }
            $str = implode('', $str);
            return $str;
        } else {
            return 'none';
        }
    }

    private static function _getIP()
    {
        static $realip;
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else
                if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $realip = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $realip = $_SERVER["REMOTE_ADDR"];
                }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else
                if (getenv("HTTP_CLIENT_IP")) {
                    $realip = getenv("HTTP_CLIENT_IP");
                } else {
                    $realip = getenv("REMOTE_ADDR");
                }
        }
        return $realip;
    }

    /**
     *功能: 析构函数，释放文件句柄
     *输入: 无
     *输出: 无
     */
    function __destruct()
    {
        //关闭文件
        fclose(self::$_filehandle);
    }
}
?>