<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Telephone extends Zend_Validate_Abstract
{
    
    const INVALID    = 'telephoneInvalid';
    const NOT_TELEPHONE = 'notTelephone';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_TELEPHONE => "'%value%' does not appear to be a valid Telephone"
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('#^[1-9][0-9]{4,}$#is',$value)){
            $this->_error(self::NOT_TELEPHONE);
            return false;
        }
        return true;  
    }
}