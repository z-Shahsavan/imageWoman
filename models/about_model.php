<?php

class about_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadabout($field) {
        $cond = 'id=1';
        return $this->db->select('tbl_about',$field);
    }
}