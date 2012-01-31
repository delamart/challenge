<?php

abstract class CollectionDbLib
{

    protected $obj_class = null;
    protected $table = null;
    protected $pk_column = null;
    protected $columns = null;

    protected function init()
    {
        if ($this->obj_class === null) { throw new Exception("Object class name has not been set."); }
        if ($this->table === null) { throw new Exception("Table name has not been set."); }
        if ($this->pk_column === null) { throw new Exception("Primary Key column name has not been set."); }
        if ($this->columns === null) { throw new Exception("Column names have not been set."); }
    }

    public function __construct()
    {
        $this->init();
    }
    
    public function pk() { return $this->pk_column; }
    public function tbl() { return $this->table; }
    public function cols($alias = '', $prefix = '') { 
        $cols = $this->columns;
        if($alias || $prefix) { foreach($cols as &$c) { $c = $alias . '.' . $c . ' AS ' . $prefix . $c; } }
        return $cols;
    }
    
    public function build_where_pk($pk,$prefix = '')
    {
        if($prefix) { $prefix .= '.'; }
        $where = sprintf('%s%s="%s"',$prefix, $this->pk_column , $pk);
        return $where;
    }
    
    public function get($pk)
    {
        $where = $this->build_where_pk($pk);
        $coll = $this->getAll($where,'',1);
        if(is_array($coll)) { return reset($coll); }
        return null;
    }
    
    public function getAll($where = '', $order = '', $limit = null)
    {
        $where = $where ? sprintf('WHERE %s',$where) : '';
        $order = $order ? sprintf('ORDER BY %s',$order) : '';
        $limit = $limit ? sprintf('LIMIT %d',$limit) : '';
        
        return $this->getCustom(sprintf('SELECT * FROM %s %s %s %s', $this->table, $where, $order, $limit));
    }
    
    public function getCustom($query)
    {
        $db = DbLib::getInstance();
        $q = $db->query($query);
        if(!$q) { throw new Exception('Something went wrong with DB. Query:'.$query); }
        $all = $q->fetchAll(PDO::FETCH_ASSOC);
        $collection = array();
        foreach ($all as $a)
        {
            $collection[$a[$this->pk_column]] = new $this->obj_class($this, $a);
        }
        return $collection;
    }
    
    /**
     * @param array $values
     * @return ModelDbLib 
     */
    public function create(array $values)
    {
        $used = $this->getColumnsFromArray($values);
        return new $this->obj_class($this, $used);
    }
    
    public function validate(array &$values)
    {        
        return array();
    }
    
    protected function validate_regex($errors, &$values, $field, $regex)
    {
        if(isset($values[$field])) {
            $v = $values[$field];
            if(!preg_match($regex, $v)) {
                $errors[$field] = "Invalid $field: $v";
            }
        }        
        return $errors;
    }

    protected function validate_numeric($errors, &$values, $field)
    {
        if(isset($values[$field])) {
            $v = $values[$field];
            if(!is_numeric($v)) {
                $errors[$field] = "$v is not a number";
            }
        }        
        return $errors;
    }

    protected function validate_integer($errors, &$values, $field, $positive = false)
    {
        if(isset($values[$field])) {
            $v = $values[$field];
            if(!is_numeric($v)) {
                $errors[$field] = "$v is not a number";
            } elseif( (int)$v != $v) {
                $errors[$field] = "$v is not an integer";
            } elseif( $positive && (int)$v < 0) {
                $errors[$field] = "$v is not positive";
            } else {
                $values[$field] = (int) $v;
            }            
        }        
        return $errors;
    }

    protected function validate_date($errors, &$values, $field)
    {
        if(isset($values[$field])) {
            $v = $values[$field];
            if(!preg_match('/^([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})$/', $v, $matches)) {
                $errors[$field] = "Invalid date: $v should be DD-MM-YYYY";
            }
            elseif(!checkdate($matches[2], $matches[1], $matches[3]))
            {
                $errors[$field] = "Wrong date: $v";                
            }
            else
            {
                $values[$field] = date('Y-m-d',  mktime(0,0,0,$matches[2],$matches[1],$matches[3]));
            }
        }        
        return $errors;
    }
    
    protected function validate_email($errors, &$values, $field)
    {
        if(isset($values[$field])) {
            $v = $values[$field];
            if(!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', $v)) {
                $errors[$field] = "Invalid email: $v";
            }
        }        
        return $errors;
    }
    
    public function save(ModelDbLib $model) {
        $id = $model->__get($this->pk_column);
        $db = DbLib::getInstance();
        if($id)
        {
            $set = '';
            $vals = array();
            foreach($this->columns as $col) { 
                if(strcasecmp($col, $this->pk_column) == 0) { continue; }
                $set .= "`$col` = ?, ";
                $vals[] = $model->__get($col);
            }
            $set = rtrim($set, ", \n\r");
            $q = sprintf('UPDATE %s SET %s WHERE `%s` = "%s"',$this->table, $set, $this->pk_column, $id);
            $stmt = $db->prepare($q);
            $ret = $stmt->execute($vals);
            return $ret;
        }
        else
        {
            $cols = '';
            $val = '';
            $vals = array();
            foreach($this->columns as $col) { 
                if(strcasecmp($col, $this->pk_column) == 0) { continue; }
                $cols .= "`$col`,";
                $val .= "?,";
                $vals[] = $model->__get($col);
            }
            $cols = '('.rtrim($cols, ',').')';
            $val = '('.rtrim($val, ',').')';
            $q = sprintf('INSERT INTO %s %s VALUES %s',$this->table, $cols, $val);
            $stmt = $db->prepare($q);
            $ret = $stmt->execute($vals);
            if($ret) { $model->__set($this->pk_column, $db->lastInsertId()); }
            return $ret;
        }
    }

    public function delete(ModelDbLib $model) {
        $id = $model->__get($this->pk_column);
        if($id)
        {
            $where = sprintf('%s = "%s"',$this->pk_column, $id);
            return $this->deleteWhere($where,1);
        }
    }    

    public function deleteWhere($where, $limit = null) {
        $limit = $limit ? sprintf('LIMIT %d',$limit) : '';
        
        $db = DbLib::getInstance();        
        $q = sprintf('DELETE FROM %s WHERE %s %s',$this->table, $where, $limit);
        return $db->query($q);
    }    
 
    public function getColumnsFromArray(array $values) {
        $used = array();
        foreach($this->columns as $name) {
            if(isset($values[$name])) { $used[$name] = $values[$name]; }
        }
        return $used;
    }
    
}