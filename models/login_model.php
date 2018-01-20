<?php
class login_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function login($data) {
        $cond='username=:username AND password=:password';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function numberphoto($id) {
        $cond='userid=:userid';
        $condata = array('userid' => $id);
        return $this->db->select('tbl_photos','count(id) as nphoto',$cond,$condata);
    }
    public function score($id) {
        $cond='userid=:userid';
        $condata = array('userid' => $id);
        return $this->db->select('tbl_score','*',$cond,$condata);
    }
    public function setlogininfo($data,$cond,$condata) {
        return $this->db->update('tbl_users',$data,$cond,$condata);
    }
}
