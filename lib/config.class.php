<?php

require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php' );

class ConfigLib {
    
    private static $config;

    public static function parse($cfg_file) {
        self::$config = new ConfigLib($cfg_file);
        return self::$config;
    }
    
    public static function getInstance() {
        return self::$config;
    }

    public static function g($path, $default = null) {
        $g = self::getInstance()->get($path);
        if($g === null) { return $default; }
        return $g;
    }

    
    private $config_file;
    private $vars;
    
    private function __construct($cfg_file) {
        $this->parse_file($cfg_file);
        
        //Little hack to let php set timezone on it's own if not set in php.ini (no more missing timezone errors)
        if(!ini_get('date.timezone')) {
            $tz = @date_default_timezone_get(); //php guesses server timezone
            date_default_timezone_set($tz);
        }
    }

    private function parse_file($cfg_file) {
        if(!file_exists($cfg_file)) { throw new Exception("Could not find config file: $cfg_file."); }        
        $this->vars = parse_ini_file($cfg_file, true);
        $this->config_file = realpath($cfg_file);
        return $this->vars;
    }
    
    public function get($path) {        
        $p = explode('/', $path);
        $v = $this->vars;
        foreach ($p as $pp)
        {
            if(!isset($v[$pp])) { return null; }
            $v = $v[$pp];
        }

        if($p[0] == 'directory' && $v[0] !== '/' && $v[0] !== '\\' )
        {
            $v = realpath( dirname($this->config_file) . DIRECTORY_SEPARATOR . $v );
        }
        
        return $v;
    }
    
}