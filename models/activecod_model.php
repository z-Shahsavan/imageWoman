<?php

class activecod_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function cmppass($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }

    public function selectcod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }

    public function selectedcod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }

    public function selecteduser($cond) {
        return $this->db->select('tbl_users', '*', $cond);
    }

    public function delactivcod($cond) {
        return $this->db->delete('tbl_activecod', $cond);
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
