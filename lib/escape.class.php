<?php

class EscapeLib {
    
    public static function escape($var) {
        $var_copy = $var;         
        if(is_array($var_copy))
        {
            foreach($var_copy as &$v) { $v = self::escape($v); }
        }
        elseif(is_object($var_copy))
        {
            $var_copy = new EscapeLib($var_copy);
        }   
        else
        {
            $var_copy = htmlentities((string) $var, ENT_COMPAT, 'UTF-8');
        }
        return $var_copy;
    }    
    
    private $object;
    
    public function __construct($object)
    {
        $this->object = $object;
    }
    
    public function __get($name)
    {
        return self::escape($this->object->$name);
    }
    
    public function __call($name, $arguments)
    {
        return self::escape(call_user_func_array(array($this->object,$name), $arguments));
    }
    
    public function __toString()
    {
        return (string) $this->object;
    }
        
}