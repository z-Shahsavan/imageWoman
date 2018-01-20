<?php

class adminblog_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loads() {
        return $this->db->select('tbl_files', '*');
    }
    public function saveups($data) {
        return $this->db->insert('tbl_files', $data);
    }
    public function del($id) {
        $data= array('id'=>$id);
        $cond='id=:id';
        $this->db->delete('tbl_files',$cond,$data);
    }
     public function editups($updata,$id) {
        $condata = array('id' => $id);
        $cond = 'id=:id';
        return $this->db->update('tbl_files', $updata, $cond, $condata);
    }
}
