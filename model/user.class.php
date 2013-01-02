<?php

class UserModel extends ModelDbLib {       
    
    const COL_PREFIX = 'user_';
    
    public function getAdditionals() {
        $add = $this->additional;
        if(!$add) { return ''; }
        $add = explode("\n", $add);
        $add = array_map('trim', $add);
        return implode(', ', $add);
    }
    
    public function getNameWithAdditionals($max = false) {
        $name = $this->name;
        $add = $this->getAdditionals();
        
        $out = $add ? $name . ' & ' . $add : $name;
        if($max && strlen_pixels($out) > $max) {
            $out = $name . ' & Co.';
        } 
        
        return $out;
    }
    
}
