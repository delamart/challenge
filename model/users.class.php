<?php

class UsersModel extends CollectionDbLib {
    
     protected function init()
     {
         $this->obj_class = 'UserModel';
         $this->table = 'user';
         $this->pk_column = 'id';
         $this->columns = array('id', 'name', 'additional', 'email', 'site', 'avatar', 'openid');
         parent::init();
     }
     
}