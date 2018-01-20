<?php


class complist_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function loadlastcomp($cond=null,$condata=array()) {
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    public function loadvs($comp) {
        $cond='compid=:compid';
        $condata=array('compid'=>$comp);
        return $this->db->select('foridx','*',$cond,$condata);
    }
}
