<?php

class Model_handheld extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getData($access, $pcode){
        $this->db->select("*");
        $this->db->from("parking");
        $this->db->where("AccessType", $access);
        $this->db->where("parking_code", $pcode);
        $this->db->where("paid_status", 0);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getRate($vehicleId){
        $this->db->select("*");
        $this->db->from("rates");
        $this->db->where("id", $vehicleId);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getOrganization($id)
    {
        $this->db->reset_query();
    
        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('id', $id);
        $query = $this->db->get();
    
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function getPtu($id)
    {
        $this->db->reset_query();
    
        $this->db->select('*');
        $this->db->from('ptu');
        $this->db->where('id', $id);
        $query = $this->db->get();
    
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }
}