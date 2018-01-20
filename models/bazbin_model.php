<?php

class bazbin_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function assignphotos($cond,$data) {
        return $this->db->bulkupdate('tbl_photos', $data,$cond); 
    }
    public function photos($tbl,$field,$cond,$condata=NULL) {
        return $this->db->select($tbl, $field, $cond,$condata);
    }

    public function bazs($cond,$condata,$flds='bid'){
        return $this->db->select('tbl_bazcomp', $flds, $cond,$condata);
    }
    
    public function loadcomps ($tbl,$cond,$coda=NULL) {
        return $this->db->select($tbl, '*', $cond,$coda);
    }

    public function okfunc($id) {
        $data = array('imgid' => $id, 'bazbinid' => Session::get('userid'), 'isok' => 1);
        return $this->db->insert('tbl_bazbinrate', $data);
    }

    public function notinbazrate($compid,$cond) {
        $condata = array('compid' => $compid);
        return $this->db->select('forbaz', '*', $cond, $condata);
    }

    public function notokfunc($id,$cmnt) {
        $data = array('imgid' => $id, 'bazbinid' => Session::get('userid'), 'isok' => 0, 'comment' => $cmnt);
        return $this->db->insert('tbl_bazbinrate', $data);
    }

    public function okphotos($compid,$cond) {
        $condata = array('compid' => $compid);
        return $this->db->select('isok', '*', $cond, $condata);
    }

    public function reject($id,$cmnt) {
        $updata = array('bazbinid' => Session::get('userid'), 'isok' => 0, 'comment' => $cmnt);
        $condata = array('imgid' => $id);
        $cond = 'imgid=:imgid';
        return $this->db->update('tbl_bazbinrate', $updata, $cond, $condata);
    }
    public function addtoall($id) {
        $cond = 'imgid=:imgid';
        $condata = array('imgid' => $id);
        $this->db->delete('tbl_bazbinrate', $cond, $condata);
    }

    public function notokphotos($compid,$cond) {
        $condata = array('compid' => $compid);
        return $this->db->select('isnotok', '*', $cond, $condata);
    }

    public function addtook($id) {
        $updata = array('bazbinid' => Session::get('userid'), 'isok' => 1, 'comment' => '');
        $condata = array('imgid' => $id);
        $cond = 'imgid=:imgid';
        return $this->db->update('tbl_bazbinrate', $updata, $cond, $condata);
    }
    /////publish part
    public function photpub($cond, $condata) {
        return $this->db->select('viw_photus', '*', $cond, $condata);
    }
    public function publish($updata, $cond, $condata){
        return $this->db->update('tbl_photos', $updata, $cond, $condata);
    }
    public function setbaz20($comp){
        $updata = array('bazid' => 0);
        $condata = array('compid' => $comp);
        $cond = 'compid=:compid';
        return $this->db->update('tbl_photos', $updata, $cond, $condata);
    }
    public function setpublishend($comp) {
        $updata = array('publishend' => 1);
        $condata = array('id' => $comp);
        $cond = 'id=:id';
        return $this->db->update('tbl_comp', $updata, $cond, $condata);
    }
    public function getuid($cond,$conddata) {
        return $this->db->select('tbl_photos', '*', $cond, $conddata);
    }
}
