<?php

class adminconfig_model extends Model {

    function __construct() {
        parent::__construct();
    }
    public function savesite($data){
        return $this->db->update('tbl_siteinfo',$data,'id=1');
    }
    
    public function getsiteinf(){
        return $this->db->select('tbl_siteinfo','*');
    }
}
