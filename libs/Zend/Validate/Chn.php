<?php
require_once 'Zend/Validate/Abstract.php';
/**
 * @author oudy
 */
class Zend_Validate_Chn extends Zend_Validate_Abstract
{
    
    const INVALID    = 'chnInvalid';
    const NOT_CHN = 'notChn';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID    => "Invalid type given. String expected",
        self::NOT_CHN => "'%value%' does not appear to be a valid Chn",
    );

    public function isValid($value)
    {        
        
        if (!is_string($value)) {
            $this->_error(self::INVALID);
            return false;
        }

        $this->_setValue($value);
        if (!preg_match('/^[\x{4e00}-\x{9fa5}]+$/iu',$value)){
            $this->_error(self::NOT_CHN);
            return false;
        }
        return true;  
    }
}