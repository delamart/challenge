<?php

class ResultController extends ControllerLib
{
    
    public function delete($id) {
        $coll = new ResultsModel();
        $this->result = $coll->get($id);
        $id = $this->result->idchallenge;
        $this->result->delete();        
        $this->redirect(url('challenge','show',$id));
    }
    
}
