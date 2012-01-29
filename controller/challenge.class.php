<?php

class ChallengeController extends ControllerSecureLib
{
    public function __construct()
    {
        parent::__construct(array('index'));
    }


    public function index() {
        $this->title = 'Challenges';
        $coll = new ChallengesModel();
        $collu = new UsersModel();
        
        $cols = $collu->cols('u', UserModel::COL_PREFIX);
        $user_cols = implode(', ', $cols);
        if($user_cols) { $user_cols = ', ' . $user_cols; }        
              
        $query = sprintf('SELECT c.*, COUNT(c.id) AS nb_results, SUM(r.amount) AS total %s FROM challenge AS c LEFT JOIN(result AS r) ON (c.id = r.idchallenge) LEFT JOIN(%s AS u) ON (c.iduser = u.%s) GROUP BY c.id', $user_cols,$collu->tbl(),$collu->pk());
        $this->challenges = $coll->getCustom($query);
        
        $this->mine = null;
        foreach($this->challenges as $challenge) { if($challenge->user == $this->user) { $this->mine = $challenge->id; } }
    }

    public function create() {
        $this->title = 'New Challenge';
        $coll = new ChallengesModel();
        if(RoutingLib::isPost())
        {
            $values = $_POST;            
            if(count($errors = $coll->validate($values)) == 0)
            {            
                $this->challenge = $coll->create(RoutingLib::cleanPost($values));
                $this->challenge->__set('iduser', $this->user->pk());
                $this->challenge->calcRythm();
                $this->challenge->save();
                $this->redirect(url('challenge','show',$this->challenge->pk()));
            }
            else
            {
                $this->errors = $errors;
            }            
        }
    }

    public function show($id) {
        $this->id = $id;
        $coll = new ChallengesModel();
        $collr = new ResultsModel();
        $this->challenge = $coll->getWithUser($id);
        
        if(!$this->user || $this->user->id != $this->challenge->iduser) { return $this->redirect(url('challenge','index')); }
        
        $this->errors = array();
        if(RoutingLib::isPost())
        {
            $values = $_POST;
            if(count($errors = $collr->validate($values)) == 0)
            {
                $result = $collr->create(RoutingLib::cleanPost($values));
                $result->idchallenge = $id;
                $result->save();
            }
            else
            {
                $this->errors = $errors;
            }            
        }        
        $this->challenge = $coll->getWithUser($id);
        $this->results = $this->challenge->getResults();
        $this->challenge->total = 0;
        foreach($this->results as $r) { $this->challenge->total += $r->amount; }
        $this->title = 'Challenge';                
    }
    
    public function delete($id) {
        $coll = new ChallengesModel();
        $this->challenge = $coll->get($id);
        $this->challenge->delete();        
        $this->redirect(url('challenge','index'));
    }
    
}
