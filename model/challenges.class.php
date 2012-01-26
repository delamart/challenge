<?php

class ChallengesModel extends CollectionDbLib {
    
     protected function init()
     {
         $this->obj_class = 'ChallengeModel';
         $this->table = 'challenge';
         $this->pk_column = 'id';
         $this->columns = array('id', 'iduser', 'amount', 'unit','duration','duration_unit','rythm','rythm_unit');
         parent::init();
     }
     
     public function validate(array &$values)
     {         
         $errors = parent::validate($values);
         
         $errors = $this->validate_integer($errors, $values, 'amount', true);
         $errors = $this->validate_integer($errors, $values, 'duration', true);
         $errors = $this->validate_integer($errors, $values, 'rythm', true);
         
         return $errors;
     }     
     
     public function getWithUser($pk)
     {
        $where = $this->build_where_pk($pk,'c');
        $coll = $this->getAllWithUsers($where,1);
        if(is_array($coll)) { return reset($coll); }
        return null;
     }
     
     public function getAllWithUsers($where = '', $limit = null)
     {
        $coll = new UsersModel();
         
        $where = $where ? sprintf('WHERE %s',$where) : '';
        $limit = $limit ? sprintf('LIMIT %d',$limit) : '';
        
        $cols = $coll->cols('u', UserModel::COL_PREFIX);
        $user_cols = implode(', ', $cols);
        if($user_cols) { $user_cols = ', ' . $user_cols; }
        
        return $this->getCustom(sprintf('SELECT c.* %s FROM %s AS c LEFT JOIN(%s AS u) ON (c.iduser = u.%s) %s %s',$user_cols, $this->table, $coll->tbl(), $coll->pk(), $where, $limit));
     }
    
}