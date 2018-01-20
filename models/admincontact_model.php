<?php

class admincontact_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function load() {
        return $this->db->select('tbl_contact', '*');
    }

    public function editcontact($data) {
        return $this->db->update('tbl_contact', $data, 'id=1');
    }

    public function loadunreadmessage() {
        return $this->db->select('tbl_formcontact', '*', 'status=0');
    }

    public function loadreadmessage() {
        return $this->db->select('tbl_formcontact', '*', 'status=1');
    }

    public function updcmnt($data) {
        $cond = 'id=:id';
        $condata = array('id' => $data);
        $updata=array('status' => 1);
        return $this->db->update('tbl_formcontact', $updata,$cond,$condata);
    }

}
