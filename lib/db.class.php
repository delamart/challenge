<?php

class DbLib extends PDO {
    
    private static $connections;
    
    /**
     *
     * @param string $name
     * @return DbLib
     */
    public static function getInstance($name = 'default') {
        
        if(!isset(self::$connections[$name])) {
            $dsn = ConfigLib::g('database/dsn');
            $username = ConfigLib::g('database/user');
            $passwd = ConfigLib::g('database/passwd');            
            $cxn = new DbLib($dsn, $username, $passwd);
            $cxn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connections[$name] = $cxn;
        }
        
        return self::$connections[$name];
    }
    
}