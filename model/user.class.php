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
    
}
