<?php

class DefaultController extends ControllerSecureLib {
    
     public function __construct($public_views = array())
     {
         parent::__construct(array('index'));
     }


     function index() {
                
    }
    
}