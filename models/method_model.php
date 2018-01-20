<?php

class method_model extends Model {
    function __construct() {
        parent::__construct();
    }
     public function loadmethod() {
        return $this->db->select('tbl_method', '*');
    }
}
