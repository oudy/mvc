<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Url extends Zend_Validate_Abstract
{
    
    const INVALID    = 'urlInvalid';
    const NOT_URL = 'notUrl';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_URL => "'%value%' does not appear to be a valid Url",
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('~(?:https?\:\/\/)(?:[A-Za-z0-9_\-]+\.)+[A-Za-z0-9]{1,4}\:?\d{0,5}(?:\/[\w\d\/=\?%\-\&_\~`@\:\+\#\.]*(?:[^<>\'\"\n\r\t\s\[\]\£¬\¡£][^\x{4e00}-\x{9fa5}])*)?~iu',$value)){
            $this->_error(self::NOT_URL);
            return false;
        }
        return true;  
    }
}