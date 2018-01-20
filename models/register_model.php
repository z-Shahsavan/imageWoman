<?php
class register_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function checkuser($username) {
        $data=array('username'=>$username);
        $cond='username=:username';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function checkmobile($mobile) {
        $data=array('mobile'=>$mobile);
        $cond='mobile=:mobile';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function checkmelicode($melicode) {
        $data=array('melicode'=>$melicode);
        $cond='melicode=:melicode';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function register($data) {
        return $this->db->insert('tbl_users',$data);
    }
    public function saveactivecode($data) {
        return $this->db->insert('tbl_active',$data);
    }
    public function saveuser($data) {
        return $this->db->insert('tbl_score',$data);
    }
}
