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
    
}