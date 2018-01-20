<?php

class Model {

    public $db;

    function __construct() {
        $this->db = new Database();
    }

    public function setinfo() {
        return $this->db->select('tbl_siteinfo', '*');
    }

    public function closecomp() {
        $cond = 'enddate<=:endda AND isopen!=3';
        $condata = array('endda' => time());
        $this->db->update('tbl_comp', array('isopen' => 2), $cond, $condata);
//        $cond = 'startdate<=:endda AND isopen=0';
//        $condata = array('endda' => time());
//        $this->db->update('tbl_comp', array('isopen' => 1), $cond, $condata);
    }

    public function opencomp() {
        $cond = 'startdate<=:endda AND isopen=0';
        $condata = array('endda' => time());
        $res = $this->db->select('tbl_comp', '*', $cond, $condata);
        $this->db->update('tbl_comp', array('isopen' => 1), $cond, $condata);
        return $res;
    }

    public function loadnots() {
        $cond = 'uid=:uid ORDER BY id DESC';
        $condata = array('uid' => Session::get('userid'));
        return $this->db->select('whonots', '*', $cond, $condata);
    }

    public function editnot($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $udata = array('status' => 1);
        $this->db->update('tbl_usernotify', $udata, $cond, $condata);
    }

    public function addnote($text, $href, $ndate) {
        return $this->db->insert('tbl_notify', array('text' => $text, 'href' => $href, 'ndate' => $ndate));
    }

    public function addch($fields, $data) {
        $this->db->batchinsert('tbl_usernotify', $fields, $data);
    }

    public function userfornote() {
        $cond = 'activenotify = 1';
        return $this->db->select('tbl_users', 'id', $cond);
    }

    public function updateview() {
        $time = time() - 3600;
        $cond = 'timeofview<=:timeofview';
        $condata = array('timeofview' => $time);
        $this->db->delete('tbl_view', $cond, $condata);
    }

    public function checkview($id, $ip) {
        $cond = 'imageid=:imageid AND userip=:userip';
        $condata = array('imageid' => $id, 'userip' => $ip);
        return $this->db->select('tbl_view', '*', $cond, $condata);
    }

    public function addview($id, $ip) {
        $data = array('imageid' => $id, 'userip' => $ip, 'timeofview' => time());
        $this->db->insert('tbl_view', $data);
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $res = $this->db->select('tbl_photos', 'view', $cond, $condata);
        if ($res != FALSE) {
            $row = $res->fetch();
            $udata = array('view' => $row['view'] + 1);
        } else {
            return;
        }
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $this->db->update('tbl_photos', $udata, $cond, $condata);
    }

    public function checklike($id, $ip) {
        $cond = 'imageid=:imageid AND userip=:userip';
        $condata = array('imageid' => $id, 'userip' => $ip);
        return $this->db->select('tbl_like', '*', $cond, $condata);
    }

    public function addlike($id, $ip) {
        $data = array('imageid' => $id, 'userip' => $ip);
        $this->db->insert('tbl_like', $data);
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $res = $this->db->select('tbl_photos', 'imglike', $cond, $condata);
        if ($res != FALSE) {
            $row = $res->fetch();
            $udata = array('imglike' => $row['imglike'] + 1);
        } else {
            return;
        }
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $this->db->update('tbl_photos', $udata, $cond, $condata);
    }

    public function removelike($id, $ip) {
        $cond = 'imageid=:imageid AND userip=:userip';
        $data = array('imageid' => $id, 'userip' => $ip);
        $this->db->delete('tbl_like', $cond, $data);
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $res = $this->db->select('tbl_photos', 'imglike', $cond, $condata);
        if ($res != FALSE) {
            $row = $res->fetch();
            if ($row['imglike'] > 0) {
                $udata = array('imglike' => $row['imglike'] - 1);
            } else {
                $udata = array('imglike' => 0);
            }
        } else {
            return;
        }
        $cond = 'id=:id';
        $condata = array('id' => $id);
        $this->db->update('tbl_photos', $udata, $cond, $condata);
    }

    public function selectcur() {
        $cond = 'isopen!=0';
        return $this->db->select('tbl_comp', '*', $cond);
    }

    public function loadcomp($cond) {
        return $this->db->select('tbl_comp', '*', $cond);
    }

    public function selectcomp() {
        return $this->db->select('tbl_comp', '*');
    }

    public function delnoactiveuser($cond) {
        return $this->db->select('tbl_users', '*', $cond);
    }

    public function selectbesusers() {
        $cond = 'isban=0 AND confirm=1 ORDER BY photonumber DESC LIMIT 6';
        return $this->db->select('tbl_users', '*', $cond);
    }

    public function loadusername($id) {
        $cond = 'id=:id';
        $condata = array('id' => $id);
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function loadscore($cond, $condata) {
        return $this->db->select('tbl_score', '*', $cond, $condata);
    }

    public function newscore($updata, $cond, $condata) {

        $this->db->update('tbl_score', $updata, $cond, $condata);
    }

    public function giveuserlik($cond, $condata) {
        return $this->db->select('tbl_photos', '*', $cond, $condata);
    }

    public function loadnotefooter() {
        return $this->db->select('tbl_about', '*');
    }

    public function numofpic($fields, $cond) {
        return $this->db->select('tbl_photos', $fields, $cond);
    }

    public function updatenumofpic($cond, $data) {
        return $this->db->bulkupdate('tbl_comp', $data, $cond);
    }

    public function loadmobileuser($cond = '', $condata = array()) {
        if ($cond == '') {
            $cond = "gcmid!=''";
            return $this->db->select('tbl_users', '*', $cond);
        } else {
            return $this->db->select('tbl_users', '*', $cond, $condata);
        }
    }

    public function selectuid($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function iscode($cond, $condata) {
        return $this->db->select('tbl_active', '*', $cond, $condata);
    }

    public function selectusers($cond, $condata) {
        return $this->db->select('tbl_active', '*', $cond, $condata);
    }

//    public function selectnotactive($cond,$conddata) {
//        return $this->db->select('tbl_active', '*', $cond,$conddata);
//    }

    public function updatenewpas($data, $cond, $condata) {
        $this->db->update('tbl_active', $data, $cond, $condata);
    }

    public function insertnewactive($data) {
        $this->db->insert('tbl_active', $data);
    }

    public function deletenotactiv($condact, $condataact) {
        $this->db->delete('tbl_users', $condact, $condataact);
    }

    public function selctusers($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function selnotact($cond) {
        return $this->db->select('tbl_active', '*', $cond);
    }

    public function deletusernotactiv($cond, $condata) {
        $this->db->delete('tbl_users', $cond, $condata);
    }

    public function delactivcod($condd) {
        return $this->db->delete('tbl_active', $condd);
    }

}
