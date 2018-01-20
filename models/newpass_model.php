<?php

class newpass_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function selectusername($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function editregister($updata, $cond, $condata) {
        $this->db->update('tbl_users', $updata, $cond, $condata);
    }

}
