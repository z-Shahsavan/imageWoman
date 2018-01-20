<?php

class active_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function checkactcode($id) {
        $cond = 'activecode=:activecode';
        $condata = array('activecode' => $id);
        return $this->db->select('tbl_active', '*', $cond, $condata);
    }

    public function deletecode($id) {
        $cond = 'activecode=:activecode';
        $condata = array('activecode' => $id);
        $this->db->delete('tbl_active', $cond, $condata);
    }

    public function makeuseractive($id) {
        $updata = array('confirm' => 1);
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->update('tbl_users', $updata, $cond, $condata);
    }

    public function delactivcod($cond) {
        return $this->db->delete('tbl_active', $cond);
    }

    public function deletusernotactiv($cond, $condata) {
        $this->db->delete('tbl_users', $cond, $condata);
    }

    public function selctusers($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function selnotact($cond) {
        return $this->db->select('tbl_active', '*', $cond);
    }

}
