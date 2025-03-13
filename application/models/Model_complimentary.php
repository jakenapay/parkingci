<?php

class Model_complimentary extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function getComplimentaryData()
    {
        $query = $this->db->get('complimentary');
        return $query->result();
    }

    public function createComplimentary($data) {
        $this->db->insert('complimentary', $data);
    }

    // public function getEventByTitle($data) {
    //     $this->db->select('qrcode');
    //     $this->db->where('event', $data);
    //     $query = $this->db->get('complimentary');
    
    //     if ($query->num_rows() > 0) {
    //         return $query->result_array();
    //     } else {
    //         return array();
    //     }
    // }

    public function getEventData($data){
        $this->db->select('*');
        $this->db->where('event', $data);
        $this->db->where('is_printed', 0);
        $this->db->from('complimentary');
        $query = $this->db->get();

        if ($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    public function verifyData($data) {
        $this->db->where('qrcode', $data);
        $query = $this->db->get('complimentary');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function markAsPrinted($eventTitle) {
        
        $this->db->where('event', $eventTitle);
        $this->db->update('complimentary', array('is_printed' => 1));
    }
    
    public function getComplimentaryByQRCode($qrcode){
        $this->db->where('qrcode', $qrcode);
        $query = $this->db->get('complimentary');
    
        $result = $query->row_array();
        if ($result) {
            $result['id'] = $result['id'];
        }
    
        return $result;
    }

    public function markComplimentaryUsed($complimentary_id) {
        $this->db->set('is_used', 1);
        $this->db->where('id', $complimentary_id);
        $this->db->update('complimentary');
    }
    public function getComplimentary($code){
        $this->db->select('*');
        $this->db->where('qrcode', $code);
        $this->db->from('complimentary');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }
}