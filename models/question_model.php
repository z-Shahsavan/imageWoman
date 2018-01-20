<?php

class question_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function load() {
        return $this->db->select('tbl_question', '*');
    }

}
