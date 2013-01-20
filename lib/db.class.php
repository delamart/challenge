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
        
        	switch(ConfigLib::g('database/from','config'))
        	{
        		case 'boxfile':
	        		//mysql:dbname=challenge;host=127.0.0.1;port=3306
        			$dsn = 	'mysql:dbname=' . $_SERVER["DB1_NAME"].
        					';host='. $_SERVER["DB1_HOST"].
        					';port='. $_SERVER["DB1_PORT"];
        			$username = $_SERVER["DB1_USER"];        			                      
					$passwd = $_SERVER["DB1_PASS"];
					break;
        		case 'config':
        		default:
            		$dsn = ConfigLib::g('database/dsn');
            		$username = ConfigLib::g('database/user');
            		$passwd = ConfigLib::g('database/passwd');
            		break;
            }
            
            $cxn = new DbLib($dsn, $username, $passwd);
            $cxn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connections[$name] = $cxn;
        }
        
        return self::$connections[$name];
    }
    
}