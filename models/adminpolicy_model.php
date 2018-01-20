<?php

class adminpolicy_model extends Model {
    function __construct() {
        parent::__construct();
    }
    public function regrules($data){
        return $this->db->insert('tbl_policy',$data);
    }
    public function loadrules(){
        return $this->db->select('tbl_policy', '*');
    }
    public function deletcmnt($dlt){
        $data= array('id'=>$dlt);
        $cond='id=:id';
        $this->db->delete('tbl_policy',$cond,$data);
    }
     public function edepolicy($updata,$condata){
        $cond='id=:id';
        $this->db->update('tbl_policy',$updata,$cond,$condata);
    }
} 