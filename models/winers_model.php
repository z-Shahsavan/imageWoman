<?php

class winers_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function comps($cond) {
        return $this->db->select('tbl_comp', '*', $cond);
    }
    public function ispeopel($cond,$condata) {
        return $this->db->select('tbl_comp', '*', $cond,$condata);
    }

    public function montakhaban($cond, $condata) {
        return $this->db->select('viw_comp', '*', $cond, $condata);
    }

    public function loadjayeze($cond, $condata) {
        return $this->db->select('tbl_wins', '*', $cond, $condata);
    }

}
