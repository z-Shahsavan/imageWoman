<?php
class reactiv_model extends Model {

    public function selectuid($cond, $condata) {
        return $this->db->select('tbl_users', '*', $cond, $condata);
    }

    public function selectuser($cond, $condata) {
        return $this->db->select('tbl_active', '*', $cond, $condata);
    }

    public function updatenewpass($data, $cond, $condata) {
        $this->db->update('tbl_active', $data, $cond, $condata);
    }
    
     public function insertnewactive($data) {
        $this->db->insert('tbl_active', $data);
    }

}
