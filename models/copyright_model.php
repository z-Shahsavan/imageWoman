<?php
class copyright_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadcpy() {
        return $this->db->select('tbl_copyright','*');
    }
}
