<?php
class setting_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function loadokimage($cond,$condata){
        return $this->db->select('tbl_photos','*',$cond,$condata);
    }
    public function idkarbar($cond,$condata){
        return $this->db->select('tbl_users','*',$cond,$condata);
    }
    public function editimage($updata,$cond,$condata){
        return $this->db->update('tbl_photos',$updata,$cond,$condata);
    }
    public function edituser($updata,$cond,$condata){
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    public function selectuser($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_users','*',$cond,$condata);
    }
    public function checkmobile($mobile,$userid) {
        $data=array('mobile'=>$mobile,'id'=>$userid);
        $cond='mobile=:mobile AND id!=:id';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function checkmelicode($melicode,$userid) {
        $data=array('melicode'=>$melicode,'id'=>$userid);
        $cond='melicode=:melicode AND id!=:id';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function loadcomps(){
        $cond='isopen=1';
        return $this->db->select('tbl_comp','*',$cond);
    }
    public function loadlocation($name=NULL){
        if($name!=NULL){
            $cond='state=:state';
            $condata=array('state'=>$name);
            return $this->db->select('tbl_states','*',$cond,$condata);
        }  else {
            return $this->db->select('tbl_states','*');
        }
    }
    public function loadlocationbyid($id){
            $cond='id=:id';
            $condata=array('id'=>$id);
            return $this->db->select('tbl_states','*',$cond,$condata);
    }
    
    public function delimage($cond,$condata){
        return $this->db->delete('tbl_photos',$cond,$condata);
    }
    
    public function savedeactivecode($data){
        return $this->db->insert('tbl_deactivecode',$data);
    }
    
    public function updatedeactivecode($data,$cond,$condata){
        return $this->db->update('tbl_deactivecode',$data,$cond,$condata);
    }
    public function checkdeactivecode($cond,$condata){
        return $this->db->select('tbl_deactivecode','*',$cond,$condata);
    }
    public function deldeactivecode($cond,$condata=  array()){
        return $this->db->delete('tbl_deactivecode',$cond,$condata);
    }
    
    public function checkmobilejad($mobile) {
        $data=array('mobile'=>$mobile);
        $cond='mobile=:mobile';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    public function delav($updata,$cond,$condata) {
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    public function getusermobile($flds,$cond,$condata) {
        return $this->db->select('tbl_users',$flds,$cond,$condata);
    }
    
}