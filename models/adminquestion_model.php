<?php

class adminquestion_model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function savequestion($data) {
        return $this->db->insert('tbl_question', $data);
    }

    public function loadquestion() {
        return $this->db->select('tbl_question', '*');
    }

    public function deletcmnt($dlt) {
        $data = array('id' => $dlt);
        $cond = 'id=:id';
        $this->db->delete('tbl_question', $cond, $data);
    }

    public function edequestion($updata, $condata) {
        $cond = 'id=:id';
        $this->db->update('tbl_question', $updata, $cond, $condata);
    }

}
