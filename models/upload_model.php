<?php
class upload_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function comps() {
        $cond='isopen=1';
        return $this->db->select('tbl_comp','*',$cond);
    }
    public function saveimage($data) {
        return $this->db->insert('tbl_photos',$data);
    }
    public function checkcomp($id){
        $cond='id=:id AND isopen=1';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    
    public function isphoto($id){
        $cond='userid=:userid';
        $condata=array('userid'=>$id);
        return $this->db->select('tbl_photos','*',$cond,$condata);
    }
    public function hashtagha ($cond,$condata){

        return $this->db->select('tbl_photos','*',$cond,$condata);
    }
    public function edituser($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        $res=$this->db->select('tbl_users','photonumber',$cond,$condata);
        $row=$res->fetch();
        $newnumber=$row['photonumber']+1;
        $updata=array('photonumber'=>$newnumber);
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    
    public function cityname() {
        return $this->db->select('tbl_states','*');
    }
    public function citynam($cond,$condata) {
        return $this->db->select('tbl_states','*');
    }
}
