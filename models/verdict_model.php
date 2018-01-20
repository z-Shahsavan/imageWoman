<?php

class verdict_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function imageofcomp($compid, $lmt = 0) {
        $cond = 'confirm=1 AND compid=:compid LIMIT ' . $lmt . ',24';
        $condata = array('compid' => $compid);
        return $this->db->select('viw_davaranimg', '*', $cond, $condata);
    }
    public function imageofcomps($cond, $condata) {
        return $this->db->select('viw_davaranimg', '*', $cond, $condata);
    }

    public function allimageofcomp($compid) {
        $cond = 'compid=:compid';
        $condata = array('compid' => $compid);
        return $this->db->select('viw_davaranimg', '*', $cond, $condata);
    }

    public function loadusername($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function loadrate($vrdid, $imgid) {
        $cond = 'vrdid=:vrdid AND imgid=:imgid';
        $condata = array('vrdid' => $vrdid, 'imgid' => $imgid);
        return $this->db->select('tbl_vrdrate', '*', $cond, $condata);
    }
    public function select($vrdid, $imgid) {
        $cond = 'vrdid=:vrdid AND imgid=:imgid';
        $condata = array('vrdid' => $vrdid, 'imgid' => $imgid);
        return $this->db->select('tbl_vrdrate', '*', $cond, $condata);
    }

    public function saverate($userid, $imgid, $rate) {
        $data = array('vrdid' => $userid, 'imgid' => $imgid, 'rate' => $rate, 'issize' => 0);
        return $this->db->insert('tbl_vrdrate', $data);
    }
    public function savesrart($userid, $imgid) {
        $data = array('vrdid' => $userid, 'imgid' => $imgid, 'rate' => 0, 'issize' => 1);
        return $this->db->insert('tbl_vrdrate', $data);
    }

    public function updaterate($userid, $imgid,$rate) {
        $update = array('rate' => $rate,'issize' => 0);
        $cond = 'vrdid=:vrdid AND imgid=:imgid';
        $condata = array('vrdid' => $userid, 'imgid' => $imgid);
        return $this->db->update('tbl_vrdrate', $update, $cond, $condata);
    }

    public function uprate($userid, $imgid) {
        $cond = 'vrdid=:vrdid AND imgid=:imgid';
        $condata = array('vrdid' => $userid, 'imgid' => $imgid);
        $update = array('rate' => 0, 'issize' => 1);
        return $this->db->update('tbl_vrdrate', $update, $cond, $condata );
    }
//    public function upnewrate($userid, $imgid,$rate) {
//        $cond = 'vrdid=:vrdid AND imgid=:imgid';
//        $condata = array('vrdid' => $userid, 'imgid' => $imgid);
//        $update = array('rate' => $rate, 'issize' => 0);
//        return $this->db->update('tbl_vrdrate', $update, $cond, $condata );
//    }

//    public function notissize($did, $imgid) {
//        $update = array('rate' => 0, 'issize' => 1);
//        $cond = 'vrdid=:vrdid AND imgid=:imgid';
//        $condata = array('vrdid' => $did, 'imgid' => $imgid);
//        return $this->db->update('tbl_vrdrate', $update, $cond, $condata);
//    }


//    public function checkcomp($id) {
//        $cond = 'id=:id';
//        $condata = array('id' => $id);
//        return $this->db->select('tbl_comp', '*', $cond, $condata);
//    }
    public function checkcomps($cond, $condata) {
    
        return $this->db->select('tbl_comp', '*', $cond, $condata);
    }

//    public function imgrate($id, $compid) {
//        $data = array('compid' => $compid);
//        $res = $this->db->select('tbl_davarcomp', 'did', 'compid=:compid', $data);
//        $cnt = $res->rowCount();
//        $data = array('imgid' => $id);
//        $res = $this->db->select('tbl_vrdrate', 'rate', 'imgid=:imgid', $data);
//        $rate = 0;
//        while ($row = $res->fetch()) {
//            $rate+=$row['rate'];
//        }
//        if ($rate > 0) {
//            $rate = $rate / $cnt;
//        }
//        $rate = round($rate, 2);
//        $cond = 'id=:id';
//        $condata = array('id' => $id);
//        $updata = array('refrate' => $rate);
//        $this->db->update('tbl_photos', $updata, $cond, $condata);
//    }
    public function seluser($id) {
        $cond = 'imgid=:imgid AND rate>0';
        $condata = array('imgid' => $id);
        return $this->db->select('tbl_vrdrate', '*', $cond, $condata);
    }

    public function uprefate($id, $rate) {
        $updata = array('refrate' => $rate);
        $condata = array('id' => $id);
        $cond = 'id=:id';
        return $this->db->update('tbl_photos', $updata, $cond, $condata);
    }

    public function loadsubjectcomp($userid) {
        $data = array('did' => $userid);
        $cond = 'isopen=2 AND did=:did AND cenddate<' . (time() - 24 * 3600) . ' AND ' . (time() - 48 * 3600) . '<cenddate';
        return $this->db->select('compname', '*', $cond, $data);
    }

}
