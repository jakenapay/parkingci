<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_demo extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function terminalDrawer($terminalId){
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $this->db->from('cash_drawer');
        $query = $this->db->get();

        if($query->num_rows() >  0)
        {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getRecord($access, $code){
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
            return "no data";
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

    // Trasactions
    public function updateDrawer($data){
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;

        $terminalId = $data['terminal_id'];


        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('start_time <=', $endTime);
        $query = $this->db->update('cash_drawer', $data);


        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getDiscounts($discount, $vehicleId){
        $this->db->select("*");
        $this->db->from("discounts");
        $this->db->where("discount_code", $discount);
        $this->db->where("vehicle_id", $vehicleId);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getDiscountsRates(){
        $this->db->select("*");
        $this->db->from("discounts");
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function getRates($vehicleId){
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

    public function getComplimentary($code){
        $this->db->select("*");
        $this->db->where("qrcode", $code);
        $this->db->from("complimentary");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function updateComplimentary($data){
        $this->db->select("id");
        $this->db->where("id", $data['id']);
        $query = $this->db->update("complimentary", $data);

        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function getTransactions($user_id){
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("cashier_id", $user_id);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
}