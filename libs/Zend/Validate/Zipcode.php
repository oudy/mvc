<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Zipcode extends Zend_Validate_Abstract
{
    
    const INVALID    = 'zipcodeInvalid';
    const NOT_ZIPCODE = 'notZipcode';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_ZIPCODE => "'%value%' does not appear to be a valid Zipcode",
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('/^[1-9]\d{5}$/',$value)){
            $this->_error(self::NOT_ZIPCODE);
            return false;
        }
        return true;  
    }
}