<?php

class admincopyright_model extends Model {
    function __construct() {
        parent::__construct();
    }
    
    public function load() {
        return $this->db->select('tbl_copyright', '*');
    }
    public function savecopyright($data) {
        return $this->db->insert('tbl_copyright', $data);
    }
     public function deletcmnt($dlt){
        $data= array('id'=>$dlt);
        $cond='id=:id';
        $this->db->delete('tbl_copyright',$cond,$data);
    }
    public function editcop($updata,$condata){
        $cond='id=:id';
        $this->db->update('tbl_copyright',$updata,$cond,$condata);
    }
} 
    

