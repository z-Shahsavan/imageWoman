<?php

class blog_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function selectuser($id) {
        $cond = 'id=:id AND confirm=1';
        $condata = array('id' => $id);
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function selectuserinfo($id) {
        $amar = array();
        $cond = 'userid=:userid';
        $condata = array('userid' => $id);
        $res = $this->db->select('viw_phcomp', '*', $cond, $condata);
        if ($res != FALSE) {
            $amar[0] = $res->rowCount();
        } else {
            $amar[0] = 0;
        }
        return $amar;
    }

    public function countofimage($id) {
        $cond = 'userid=:userid';
        $condata = array('userid' => $id);
        return $this->db->select('viw_phcomp', '*', $cond, $condata);
    }

    public function loadimagesforgall($cond, $condata = array()) {
        return $this->db->select('viw_phcomp', '*', $cond, $condata);
    }

    public function wininfo($uid) {
        $cond = 'uid=:uid GROUP BY id';
        $condata = array('uid' => $uid);
        return $this->db->select('winphotos', '*', $cond, $condata);
    }

    public function calcscore($uid) {
        $cond = 'userid=:userid';
        $condata = array('userid' => $uid);
        return $this->db->select('tbl_score', '*', $cond, $condata);
    }

    public function selfing($cond, $condata) {
        return $this->db->select('viw_fing', '*', $cond, $condata);
    }

    public function selfer($cond, $condata) {
        return $this->db->select('viw_fer', '*', $cond, $condata);
    }

    public function checkflw($cond, $condata) {
        return $this->db->select('tbl_follow', '*', $cond, $condata);
    }

    public function makeflw($data) {
        return $this->db->insert('tbl_follow', $data);
    }

    public function makeunflw($cond, $condata) {
        return $this->db->delete('tbl_follow', $cond, $condata);
    }

    public function loadrate($pid) {
        $cond = 'pid=:pid';
        $condata = array( 'pid' => $pid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }

    public function loadcompname($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

}
