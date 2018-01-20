<?php

class adminviolation_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function loadviolate($cond){
        return $this->db->select('viw_violat','*',$cond);
    }
    public function delviolate($cond, $condata){
        return $this->db->delete('tbl_violation',$cond,$condata);
    }
    public function loadviolateco(){
        return $this->db->select('tbl_violation','*');
    }
  
}

