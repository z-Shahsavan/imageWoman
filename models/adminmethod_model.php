<?php

class adminmethod_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function savemethod($data) {
        return $this->db->insert('tbl_method', $data);
    }

    public function loadmethod() {
        return $this->db->select('tbl_method', '*');
    }

    public function deletcmnt($dlt) {
        $data = array('id' => $dlt);
        $cond = 'id=:id';
        $this->db->delete('tbl_method', $cond, $data);
    }

    public function edemethod($updata, $condata) {
        $cond = 'id=:id';
        $this->db->update('tbl_method', $updata, $cond, $condata);
    }

}
