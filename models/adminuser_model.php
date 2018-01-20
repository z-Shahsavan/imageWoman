<?php
class adminuser_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadusers($cond,$data=  array()) {
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function countofuser($cond){
        return $this->db->select('tbl_users','*',$cond);
    }

    public function updateph($cond,$data) {
        $updata=array('bazid'=>0);
        return $this->db->update('tbl_photos',$updata,$cond,$data);
    }
     public function checkcompopen($co,$da) {
        return $this->db->select('compname','*',$co,$da);
    }
     public function deldavarrows($co,$da){
         return $this->db->delete('tbl_davarcomp',$co,$da);
    }
    public function makeban($cond,$data=  array()) {
        $updata=array('isban'=>1);
        return $this->db->update('tbl_users',$updata,$cond,$data);
    }
    
    public function makeunban($cond,$data=  array()) {
        $updata=array('isban'=>0);
        return $this->db->update('tbl_users',$updata,$cond,$data);
    }
    public function updaterole($cond,$role,$data=  array()) {
        $updata=array('isadmin'=>$role);
        return $this->db->update('tbl_users',$updata,$cond,$data);
    }
    
    public function searchusers($cond,$data=  array()) {
        return $this->db->select('viw_searchuser','*',$cond,$data);
    }
}
