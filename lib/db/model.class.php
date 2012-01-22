<?php

abstract class ModelDbLib extends ModelLib {    

    private $collection;
    private $data;
    
    public function __construct(CollectionDbLib $collection, array $data = array())
    {
        $this->collection = $collection;
        foreach ($data as $k=>$v)
        {
            $this->data[strtolower($k)] = $v;
        }
    }
    
    public function update($values) 
    {
        if(!$this->collection) { return false; }
        $used = $this->collection->getColumnsFromArray($values);        
        $this->data = array_merge($this->data, $used);
        return true;
    }    
    
    public function save()    
    {
        $this->collection->save($this);
    }

    public function delete()
    {
        $this->collection->delete($this);
    }    
    
    public function pk_col()
    {
        return $this->collection->pk();
    }
    
    public function pk() 
    {
        return $this->__get($this->pk_col());
    }
    
    public function __toString()    
    {
        return implode('-',$this->data);
    }
    
    public function __get($name)
    {
        return isset($this->data[strtolower($name)]) ? $this->data[strtolower($name)] : null;
    }
    
    public function __set($name, $value)
    {
        $this->data[strtolower($name)] = $value;
    }
        
}
