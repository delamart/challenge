<?php

class ResultsModel extends CollectionDbLib {
    
     protected function init()
     {
         $this->obj_class = 'ResultModel';
         $this->table = 'result';
         $this->pk_column = 'id';
         $this->columns = array('id', 'idchallenge', 'amount', 'date');
         parent::init();
     }

     public function validate(array &$values)
     {         
         $errors = parent::validate($values);
         
         $errors = $this->validate_numeric($errors, $values, 'amount');
         $errors = $this->validate_date($errors, $values, 'date');
         
         return $errors;
     }
     
}