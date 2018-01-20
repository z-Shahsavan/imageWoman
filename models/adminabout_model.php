<?php

class adminabout_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function load() {
        return $this->db->select('tbl_about', '*');
    }

    public function editaboutus($data) {
        return $this->db->update('tbl_about', $data, 'id=1');
    }

}
