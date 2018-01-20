<?php

class adminprize_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function comps($cond) {
        return $this->db->select('tbl_comp','*',$cond);
    }
    public function insertprize($cond) {
        return $this->db->insert('tbl_prize',$cond);
    }
    public function insertimg($cond) {
        return $this->db->insert('tbl_prizefiles',$cond);
    }
    public function isrepeat($cond,$codata) {
        return $this->db->select('tbl_prize','*',$cond,$codata);
    }
    public function updateprize($upda,$cond,$codata) {
        return $this->db->update('tbl_prize',$upda,$cond,$codata);
    }
    public function deletelastprze( $cond, $condata) {
        $this->db->delete('tbl_prize', $cond, $condata);
    }
    public function deleteallfile( $cond, $condata) {
        $this->db->delete('tbl_prizefiles', $cond, $condata);
    }
    public function selectallfiles($cond,$codata) {
        return $this->db->select('tbl_prizefiles','*',$cond,$codata);
    }
}
