<?php

class search_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function searchphot($cond, $condata = array()) {
        return $this->db->select('photosearch', '*', $cond, $condata);
    }

    public function selectcomp() {
        $cond = 'isopen!=:isopen';
        $condata = array('isopen' => 0);
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

    public function selectstates() {
        return $this->db->select('tbl_states', '*');
    }

    public function saveviolation($data) {
        return $this->db->insert('tbl_violation', $data);
    }

    public function loadrate($pid, $uid) {
        $cond = 'uid=:uid AND pid=:pid';
        $condata = array('uid' => $uid, 'pid' => $pid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }

}
