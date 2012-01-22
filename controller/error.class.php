<?php

class ErrorController extends ControllerLib {
    
    function index(Exception $exception) {
        
        $this->title = 'Exception';
        $this->message = $exception->getMessage();
        $this->trace = $exception->getTraceAsString();
        
    }
    
}