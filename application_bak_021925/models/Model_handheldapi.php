<?php
defined('BASEPATH') or exit('No direct scripts allowed');

class Model_handheldapi extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    public function getData($access, $code)
    {
        $this->db->select('*');
        $this->db->from('parking');
        $this->db->where('AccessType', $access);
        $this->db->where('parking_code', $code);
        $this->db->where('out_time', '');
        $this->db->where('paid_status', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
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

    public function createTransaction($data){
        $query = $this->db->insert('transactions', $data);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function updateParking($data){
        $this->db->select("id");
        $id = $data['id'];
        $this->db->where("id", $id);
        $query = $this->db->update("parking", $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function updateCompany($data){
        $this->db->select("id");
        $id = $data['id'];
        $this->db->where("id", $id);
        $query = $this->db->update("company", $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}