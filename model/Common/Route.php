<?php
/**
 * URL 路由
 * 默认重写规则 /模块($module)/PHP文件($phpFile)/动作($action)/参数1/参数1值/参数2/参数2值/参数3/参数3值/...
 * @author oudy
 */
class Common_Route
{
    public $module;//模块
    public $phpFile;//类PHP文件
    private $action;//动作
    private $pathInfo;//长串参数信息
    
    public function __construct(){
        $this->module = GET('__REWRITE_MODULE__','','Index');
        $this->phpFile = GET('__REWRITE_PHPFILE__','','Index');
        $this->action = GET('__REWRITE_ACTION__','','index');
        $this->pathInfo = GET('__REWRITE_PATHINFO__','','');
        self::parseRoutePathInfoForGET();
        self::resetRewriteByGET();
    }
    /**
     * 解析无限参数及参数对应的值
     * @author oudy
     */
    public function parseRoutePathInfoForGET(){
        if(preg_match('#\.(js|html|png|jpg|jpeg|gif|css|html|htm)$#is',$this->pathInfo)){exit;}
        if($this->module=='view'){exit;}
        if(!empty($this->pathInfo) && substr_count($this->pathInfo,'/')>0){
            $pathInfoStrArray = explode('/',$this->pathInfo);
            foreach($pathInfoStrArray as $key=>$val){
                if( $key % 2 ==0){
                    if(is_numeric($val)){continue;}
                    $_GET[$val] = isset($pathInfoStrArray[$key+1])?$pathInfoStrArray[$key+1]:'';
                }
            }
        }    
    }
    
    /**
     * 直接传参抵销重写$_GET : m p a
     * @author oudy
     */
    public function resetRewriteByGET(){
        $this->module = GET('m','',$this->module);
        $this->phpFile = GET('p','',$this->phpFile);
        $this->action = GET('a','',$this->action);
    }
    
    /**
     * 根据路由参数 实例化类对应的方法 
     * @author oudy
     */
    public function run(){     
        $module = ucfirst(strtolower($this->module));
        $action = $this->action;
        $phpFile = ucfirst(strtolower($this->phpFile));
        
        $file = 'controller/' . $module.'/'.$phpFile.'.php';
        // Ajax 请求 引导到 api 文件夹
        if(isset($_POST['method'])){$file = 'api/web/' . $module.'/'.$phpFile.'.php';}

        if(file_exists($file)){
            include ($file);            
            $tempClass = $module.'_'.$phpFile;
            if(!class_exists("$tempClass")){
                throw new Exception("$tempClass 类不存在");
            }
            eval("$$tempClass = new $tempClass ;");  
            if(!method_exists($$tempClass,$action)){
                header('HTTP/1.1 404 Not Found');
                //throw new Exception("类 $tempClass 的 $action 方法名不存在");
            }else{
                $$tempClass->$action();
            }
        }else{
            header('HTTP/1.1 404 Not Found');
            //throw new Exception('不存在的 '.$file);
        }
    }    
    
}