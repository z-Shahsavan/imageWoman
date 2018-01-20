<?php

class contact_model extends Model {

    public function loadaddress() {
        return $this->db->select('tbl_contact', '*');
    }
   public function saveform($data){
        return $this->db->insert('tbl_formcontact',$data);
    }

}
