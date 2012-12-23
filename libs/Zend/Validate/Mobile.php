<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Mobile extends Zend_Validate_Abstract
{
    
    const INVALID    = 'mobileInvalid';
    const NOT_MOBILE = 'notMobile';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_MOBILE => "'%value%' does not appear to be a valid Mobile",
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('#^1[358]\d{9}$#is',$value)){
            $this->_error(self::NOT_MOBILE);
            return false;
        }
        return true;  
    }
}
