<?php

class index_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function loadslide($cond) {
        return $this->db->select('tbl_comp', '*', $cond);
    }

    public function loadpic($cond, $condata) {
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

    public function loadpics($cond, $condata) {
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }

    public function loaduser($cond, $condata) {
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }

    public function forselectedpic($cond,$condata=NULL) {
        return $this->db->select('viw_comp', '*', $cond,$condata);
    }

    public function saveviolation($data) {
        return $this->db->insert('tbl_violation', $data);
    }

}
