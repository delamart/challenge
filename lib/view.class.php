<?php

class ViewLib {       
    
    const NO_LAYOUT = false;
    
    public static function _getHeader($layout) {
        if(!$layout) return false;
        $tmpl = ConfigLib::g('directory/layout') . DIRECTORY_SEPARATOR . $layout . '.header.tmpl.php';
        if(!file_exists($tmpl)) { throw new Exception("Could not find header: $tmpl."); }
        return $tmpl;
    }
    
    public static function _getFooter($layout) {
        if(!$layout) return false;
        $tmpl =  ConfigLib::g('directory/layout') . DIRECTORY_SEPARATOR . $layout . '.footer.tmpl.php';
        if(!file_exists($tmpl)) { throw new Exception("Could not find footer: $tmpl."); }
        return $tmpl;
    }
    

    private $_controller;
    private $_template;
    private $_vars;
    private $_layout;
    
    public function __construct($controller = null, $template = null, $layout = null) {                
        $this->_controller = $controller === null ? ConfigLib::g('default/controller') : $controller;
        $this->_template = $template === null ? ConfigLib::g('default/view') : $template;
        
        if($this->_controller[0] === '_')
        {
        	$this->_layout = '_';
        }
        elseif($layout === null)
        {
        	$this->_layout = ConfigLib::g('default/layout');
        }
        else 
        {
        	$this->layout = $layout;
        }
    }
    
    public function __get($name) {
        return isset($this->_vars[$name]) ? EscapeLib::escape($this->_vars[$name]) : '';
    }
    
    public function _render($vars = array()) {
        $tmpl = ConfigLib::g('directory/view') . DIRECTORY_SEPARATOR . $this->_controller . DIRECTORY_SEPARATOR . $this->_template . '.tmpl.php';
        if(!file_exists($tmpl)) { throw new Exception("Could not find template: $tmpl."); }
        $this->_vars = $vars;
        
        if(($header = self::_getHeader($this->_layout)) && ($this->_layout !== self::NO_LAYOUT)) { include($header); }
        
        include($tmpl);
        
        if(($footer = self::_getFooter($this->_layout)) && ($this->_layout !== self::NO_LAYOUT)) { include($footer); }
    }
    
}