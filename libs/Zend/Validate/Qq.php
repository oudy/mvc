<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Qq extends Zend_Validate_Abstract
{
    
    const INVALID    = 'qqInvalid';
    const NOT_QQ = 'notQq';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_QQ => "'%value%' does not appear to be a valid Qq",
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('#^[1-9][0-9]{4,}$#is',$value)){
            $this->_error(self::NOT_QQ);
            return false;
        }
        return true;  
    }
}