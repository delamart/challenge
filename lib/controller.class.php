<?php

abstract class ControllerLib {

    const RETURN_VIEW = null;
    const RETURN_NONE = false;
    
    private $vars;
    
    public function __get($name)
    {
        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }
    
    public function __set($name, $value)
    {
        $this->vars[$name] = $value;
    }
    
    public function getVars() { return $this->vars; }        
    
    public function redirect($url) {
        RoutingLib::setHeader("Location: $url");
        return self::RETURN_NONE;
    }
    
    public function proxy_call($name, $arguments)
    {
       return call_user_func_array(array($this,$name), $arguments);
    }    
    
}