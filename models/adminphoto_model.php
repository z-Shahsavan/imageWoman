<?php
class adminphoto_model  extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadphoto($condata,$cond){
        return $this->db->select('photconf','*',$cond,$condata);
    }
     public function rejectphoto($updata,$cond,$condata){
        return $this->db->update('tbl_photos',$updata,$cond,$condata);
    }
    public function confirmphoto($updata,$cond,$condtat){
        return $this->db->update('tbl_photos',$updata,$cond,$condtat);
    }
    public function loaddavari($cond,$coda) {
        return $this->db->select('viw_photwin','*',$cond,$coda);
    }
    public function loadcomps($cond) {
        return $this->db->select('tbl_comp', '*', $cond);
    }
    public function savewinner($data,$status) {
        $updata=array('iswin'=>$status);
        $cond='id=:id';
        $condata=array('id'=>$data['imgid']);
        $this->db->update('tbl_photos',$updata,$cond,$condata);
        return $this->db->insert('tbl_wins',$data);
    }
    public function iswinner($id) {
        $cond='imgid=:imgid';
        $condata=array('imgid'=>$id);
        return $this->db->select('tbl_wins','*',$cond,$condata);
    }
    public function delwinner($id,$status,$type) {
        $updata=array('iswin'=>$status);
        $cond='id=:id';
        $condata=array('id'=>$id);
        $this->db->update('tbl_photos',$updata,$cond,$condata);
        
        $cond='imgid=:imgid AND wintype=:wintype';
        $condata=array('imgid'=>$id,'wintype'=>$type);
        return $this->db->delete('tbl_wins',$cond,$condata);
    }
    public function getuid($cond, $conddata) {
        return $this->db->select('tbl_photos', '*', $cond, $conddata);
    }
    public function loadpowins($fld,$cond,$coda) {
        return $this->db->select('tbl_ratemardomi', $fld, $cond,$coda);
    }
    public function loadpowinsinfo($data,$datafld) {
        return $this->db->selectarray('viw_photwin','*',$datafld,$data);
    }
}