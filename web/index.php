<?php 
    error_reporting(E_ERROR);
    
    $BASE_DIR = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
    
    require_once( $BASE_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'config.class.php' );    
    ConfigLib::parse( $BASE_DIR . DIRECTORY_SEPARATOR . 'config.ini');
    
	KernelLib::start();