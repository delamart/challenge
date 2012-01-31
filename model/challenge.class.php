<?php

class ChallengeModel extends ModelDbLib {

    const RYTHM_DAY = 'day';
    const RYTHM_WEEK = 'week';
    const RYTHM_MONTH = 'month';
    
    const UNIT_DAY = 'day';
    const UNIT_WEEK = 'week';
    const UNIT_MONTH = 'month';
    const UNIT_YEAR = 'year';
    
    public function getResults()
    {
        $id = $this->pk();
        $where = sprintf('`idchallenge`="%s"', $id);
        $order = 'date DESC';
        
        $coll = new ResultsModel();
        return $coll->getAll($where,$order);
    }
    
    public function calcRythm()
    {
        $total = $this->amount * $this->rythmMult($this->rythm_unit);
        $div = $this->duration * $this->unitMult($this->duration_unit);
        $rythm = ceil( $total / $div );
        $this->rythm = max(array(1,$rythm));
    }
    
    public function rythmMult($rythm)
    {
        switch ($rythm)
        {
            case self::RYTHM_DAY: return 1;
            case self::RYTHM_WEEK: return 7;
            case self::RYTHM_MONTH: return (365/12);
            default: return 1;
        }        
    }

    public function unitMult($unit)
    {
        switch ($unit)
        {
            case self::UNIT_DAY: return 1;
            case self::UNIT_WEEK: return 7;
            case self::UNIT_MONTH: return (365/12);
            case self::UNIT_YEAR: return 365;
            default: return 1;
        }                
    }
    
    public function __construct(CollectionDbLib $collection, array $data = array())
    {
        $user_data = array();
        foreach($data as $n => $d)
        {
            if(substr($n, 0, strlen(UserModel::COL_PREFIX)) == UserModel::COL_PREFIX) { $user_data[substr($n, strlen(UserModel::COL_PREFIX))] = $d; }                    
        }
        parent::__construct($collection, $data);

        if(count($user_data))
        {
            $coll = new UsersModel();
            $user = $coll->create($user_data);
            $this->user = $user;
        }
        
    }
    
    public function start($format = 'Y-m-d H:i:s') {
        if(!$this->start) { return null; }
        return date($format,  strtotime($this->start));
    }    

    public function days() {
        if(!$this->start) { return null; }
        $diff = mktime(0,0,0) - $this->start('U');
        return date('z',$diff) + 1;
    }    
    
    public function amount_left() {
        return max(array(0,$this->amount - $this->total));
    }
    
    public function duration_total() {
        return round($this->duration * $this->unitMult($this->duration_unit) / $this->rythmMult($this->rythm_unit));
    }
    
    public function duration_done() {
        return ceil($this->days() / $this->rythmMult($this->rythm_unit));
    }

    public function duration_left() {
        return max(array(0,$this->duration_total() - $this->duration_done()));
    }
    
    public function rythm_now() {
        return round($this->total / max(array(1,$this->duration_done())), 2);
    }
    
}
