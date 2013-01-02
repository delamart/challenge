<?php

abstract class ControllerSecureLib extends ControllerLib {

    const SESSION_KEY = 'sec:user';
    
    private static $user = null;

    private $public_views = array();
    
    public function __construct($public_views = array())
    {
        if(isset($_SESSION[self::SESSION_KEY]) && $_SESSION[self::SESSION_KEY]) { $this->setUser($_SESSION[self::SESSION_KEY]); }
        $this->public_views = $public_views;
    }
    
    public function getUser() { return self::$user; }
    public function setUser($user) { self::$user = $user; $this->__set('user', $user); }
    public function isAuthenticated() { return $this->getUser() !== null; }


 	public function proxy_call($name, $arguments)
    {
       if(!in_array($name, $this->public_views) && !$this->isAuthenticated()) {
           $login_url = url(ConfigLib::g('security/login_controller','user'),
                            ConfigLib::g('security/login_view','login'),
                            array(),
                            array('redirect' => urlencode($_SERVER['REQUEST_URI'])));
           return $this->redirect($login_url);
       }
       return parent::proxy_call($name, $arguments);
    }
    
    public function __destruct()
    {
        $_SESSION[self::SESSION_KEY] = $this->getUser();
    }
    
}