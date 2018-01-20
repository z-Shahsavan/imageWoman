<?php

class comp_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function loadimagesforgall($cond, $condata) {
        return $this->db->select('viw_comp', '*', $cond, $condata);
    }

    public function loadjayeze($cond, $condata) {
        return $this->db->select('tbl_wins', '*', $cond, $condata);
    }

    public function loadimagesfordavs($cond, $condata) {
        return $this->db->select('viw_davarcomnew', '*', $cond, $condata);
    }

    public function loadusername($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function countofimage($cond, $condata) {
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }
    public function selisopen($cond, $condata) {
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

    public function subjectinfo($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

    public function selrate($id, $userid) {
        $cond = 'pid=:pid and uid=:uid';
        $condata = array('pid' => $id, 'uid' => $userid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }

    public function seluser($id) {
        $cond = 'pid=:pid';
        $condata = array('pid' => $id);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }

    public function loadcompname($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

    public function loaddate($id) {
        $cond = 'cid=:cid';
        $condata = array('cid' => $id);
        return $this->db->select('compname', '*', $cond, $condata);
    }

    public function loadisok($id) {
        $cond = 'imgid=:imgid';
        $condata = array('imgid' => $id);
        return $this->db->select('tbl_bazbinrate', '*', $cond, $condata);
    }

    public function loadcompid($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }

    public function selu($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }

    public function loadrate($pid) {
        $cond = 'pid=:pid';
        $condata = array('pid' => $pid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }

    public function saveviolation($data) {
        return $this->db->insert('tbl_violation', $data);
    }

    public function uprate($uid, $id, $rate) {
        $updata = array('rate' => $rate);
        $condata = array('pid' => $id, 'uid' => $uid);
        $cond = 'pid=:pid AND uid=:uid';
        return $this->db->update('tbl_ratemardomi', $updata, $cond, $condata);
    }

    public function uprefate($id, $rate) {
        $updata = array('imglike' => $rate);
        $condata = array('id' => $id);
        $cond = 'id=:id';
        return $this->db->update('tbl_photos', $updata, $cond, $condata);
    }

    public function saverate($data) {
        return $this->db->insert('tbl_ratemardomi', $data);
    }

    public function loadwinimage($id) {
        $cond = 'cmpid=:cmpid';
        $condata = array('cmpid' => $id);
        return $this->db->select('tbl_wins', '*', $cond, $condata);
    }

    public function loadsubjectcomp($userid) {
        $data = array('did' => $userid);
        $cond = 'isopen=2 AND did=:did AND cenddate<' . (time() - 24 * 3600) . ' AND ' . (time() - 48 * 3600) . '<cenddate';
        return $this->db->select('compname', '*', $cond, $data);
    }

    public function prizes($cond, $conddata) {
        return $this->db->select('viw_prizeandfiles', '*', $cond, $conddata);
    }

    public function deluser($cond, $condata) {
        return $this->db->delete('tbl_ratemardomi', $cond, $condata);
    }

}
