<?php

class KernelLib {
	
	private static $instance = null;
	
    public static function start() { self::getInstance()->run(); }

    public static function getInstance() {
		if(self::$instance == null) { self::$instance = new KernelLib(); }
		return self::$instance;
	}
		
    
    private $config;
    private $routing;
    
	private function __construct() {
        session_start();
        $this->config = ConfigLib::getInstance();        
        $this->routing = new RoutingLib();
        
        date_default_timezone_set($this->config->g('default/timezone','UTC'));
    }		
	
	public function run() {
		
        try {
            $r = $this->routing;

            $controller = $r->getController();
            $controller_class = ucfirst(strtolower($controller)) . 'Controller';
            if(!class_exists($controller_class)) {
                throw new Exception("Could not find controller: $controller_class");
            }

            $view = $r->getView();
            if(!method_exists($controller_class, $view)) {
                throw new Exception("Could not find view method: $view in $controller_class");            
            }

            $controller_obj = new $controller_class();
            if(!$controller_obj instanceof ControllerLib) {
                throw new Exception("Object $controller_class is not instanceof ControllerLib");
            }

            $params = $r->getParameters();        
            $result = $controller_obj->proxy_call($view, $params);
            
            if($result !== ControllerLib::RETURN_NONE) { 
                
                $view = new ViewLib($controller, $view);   
                $view->_render($controller_obj->getVars());
                
            }
                        
        }
        catch (Exception $e) {
            
            $error_class = ucfirst(strtolower( ConfigLib::g('error/controller') )) . 'Controller';                   
            $error_obj = new $error_class();
            $result = call_user_func_array(array($error_obj, ConfigLib::g('error/view')), array($e));
            
            $error_view = new ViewLib(ConfigLib::g('error/controller'), ConfigLib::g('error/view'), ConfigLib::g('error/layout'));
            $error_view->_render($error_obj->getVars());            
            
        }
                
	}
	
}