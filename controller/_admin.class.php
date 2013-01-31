<?php

class _adminController extends ControllerLib {
    
    function __construct()
    {
    	parent::__construct();
		$this->result = '';
		$this->links = array();
    }
    
    function index() {
        
        // $this->links = array();
        
    }

    function info() {
    
		$this->result = "PHP\t".phpversion()."\n";
		
	}
    
    function db($do = null) {
    
    	$dbadmin = new DbadminPluginLib();
    
    	if($do !== null)
    	{
    		$this->result = $dbadmin->$do();
    	}
    	else 
    	{
    		$this->result = 'Select an action above';	
    	}
    	
    }
    
}