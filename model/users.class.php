<?php

class UsersModel extends CollectionDbLib {
    
     protected function init()
     {
         $this->obj_class = 'UserModel';
         $this->table = 'user';
         $this->pk_column = 'id';
         $this->columns = array('id', 'name', 'additional', 'email', 'password', 'site', 'avatar', 'openid');
         parent::init();
     }

     public function validate(array &$values)
     {         
         $errors = parent::validate($values);
         
         $errors = $this->validate_email($errors, $values, 'email');
         
         return $errors;
     }     
     
}