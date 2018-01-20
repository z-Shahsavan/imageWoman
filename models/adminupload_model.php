<?php

class adminupload_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function saveconfigupload($data) {
        return $this->db->update('tbl_siteinfo', $data, 'id=1');
    }
    public function loadsiteinfo() {
        return $this->db->select('tbl_siteinfo','*'); 
    }

}
