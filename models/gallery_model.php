<?php
class gallery_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadimagesforgall($cond,$condata=NULL) {
        return $this->db->select('tbl_photos','*',$cond,$condata);
    }
    public function loadusername($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_users','*',$cond,$condata);
    }
    public function loadcompname($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    public function countofimage(){
        $cond='confirm=1';
        return $this->db->select('tbl_photos','*',$cond);
    }
      public function saveviolation($data) {
        return $this->db->insert('tbl_violation', $data);
    }
        public function loadrate($pid) {
        $cond = ' pid=:pid';
        $condata = array('pid' => $pid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }
}
