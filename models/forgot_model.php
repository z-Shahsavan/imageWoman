<?php
class forgot_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function selectuser($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function selecactivecod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }

    public function insertnewpass($data) {
        return $this->db->insert('tbl_activecod', $data);
    }

    public function updatenewpass($data, $cond, $condata) {
        $this->db->update('tbl_activecod', $data, $cond, $condata);
    }

}
