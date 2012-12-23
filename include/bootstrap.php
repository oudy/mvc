<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
set_include_path(__DOCUMENT_ROOT__ . '/libs' . PATH_SEPARATOR .
                 __DOCUMENT_ROOT__ . '/model' . PATH_SEPARATOR .
                 get_include_path() );

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(false);

function autoload($className)
{
    if (is_file(__DOCUMENT_ROOT__ . '/libs/' . implode('/', explode('_', $className)) . '.php'))
        include_once __DOCUMENT_ROOT__ . '/libs/' . implode('/', explode('_', $className)) . '.php';
    elseif (is_file(__DOCUMENT_ROOT__ . '/model/' . implode('/', explode('_', $className)) . '.php'))
        include_once __DOCUMENT_ROOT__ . '/model/' . implode('/', explode('_', $className)) . '.php';
}

spl_autoload_register('autoload');