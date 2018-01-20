<?php

class admincomp_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function winners($cond, $condata ) {
        return $this->db->select('viw_userwin', '*', $cond, $condata);
    }
    public function checkcomp($cond, $data = array()) {
        return $this->db->select('tbl_comp', '*', $cond, $data);
    }

    public function savecomp($data) {
        return $this->db->insert('tbl_comp', $data);
    }

    public function selectcomps($cond,$condata) {
        return $this->db->select('tbl_comp', '*',$cond,$condata);
    }

    public function updatecomps($updata, $cond, $condata) {
        return $this->db->update('tbl_comp', $updata, $cond, $condata);
    }

    public function selectdavaran($cond, $data = array()) {
        return $this->db->select('tbl_users', '*', $cond, $data);
    }
    public function selectbazbinha($cond, $data = array()) {
        return $this->db->select('tbl_users', '*', $cond, $data);
    }

    public function addds($fields, $data) {

        return $this->db->batchinsert('tbl_davarcomp', $fields, $data);
    }
    public function dltds($cond,$condata){
        $this->db->delete('tbl_davarcomp',$cond,$condata);
    }
    public function dltbz($cond,$condata){
         $this->db->delete('tbl_bazcomp',$cond,$condata);
    }

    public function addbs($fields, $data) {
        return $this->db->batchinsert('tbl_bazcomp', $fields, $data);
    }

    public function editcomp($updata, $cond, $condata) {
        return $this->db->update('tbl_comp', $updata, $cond, $condata);
    }

    public function deldavar($cond, $condata) {
        return $this->db->delete('tbl_davarcomp', $cond, $condata);
    }

    public function selectdavar($cond, $data) {
        return $this->db->select('compname', '*', $cond, $data);
    }

    public function selectcompname($cond, $data) {
        return $this->db->select('tbl_comp', '*', $cond, $data);
    }
    public function selectbazbin($cond, $condata){
        return $this->db->select('viw_compbaz', '*', $cond, $condata);
    }
    public function chosedv($cond,$condata){
     return $this->db->select('tbl_davarcomp','did',$cond,$condata);  
    }
    public function chosebz($cond, $condata){
        return $this->db->select('tbl_bazcomp','bid',$cond,$condata);  
    }
    public function loadfinishcomp($cond){
        return $this->db->select('tbl_comp','*',$cond);  
    }
    public function notifytowinners($cond , $coda) {
        return $this->db->select('viw_winph','*',$cond,$coda);  
    }
    public function insnotify($data) {
        return $this->db->insert('tbl_notify', $data);
    }
    public function binsusernotify($fields, $data) {
        $this->db->batchinsert('tbl_usernotify', $fields, $data);
    }

}