<?php

class policy_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadrules() {
        return $this->db->select('tbl_policy','*');
    }
}
