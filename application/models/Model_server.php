<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_server extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function search_parking($query) {
        $current_day_start = strtotime('today midnight');
        $current_day_end = strtotime('tomorrow midnight') - 1;

        $this->db->select('*');
        $this->db->from('parking');
        $this->db->like('parking_code', $query);
        $this->db->where('in_time >=', $current_day_start);
        $this->db->where('in_time <=', $current_day_end);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getGateCounts(){
        $current_day_start = strtotime('today midnight');
        $current_day_end = strtotime('tomorrow midnight') - 1;
        $this->db->select('GateId, COUNT(*) as count');
        $this->db->from('parking');
        $this->db->where('in_time >=', $current_day_start);
        $this->db->where('in_time <=', $current_day_end);
        $this->db->where_in('GateId', ['G1', 'G2', 'G3', 'G4']);
        $this->db->group_by('GateId');
    
        $query = $this->db->get();
        
        
        return $query->result_array();
    }
    

    public function getGateCountsEntry(){
        $current_day_start = strtotime('today midnight');
        $current_day_end = strtotime('tomorrow midnight') - 1;
        $this->db->select('GateId, COUNT(*) as count');
        $this->db->from('parking');
        $this->db->where('in_time >=', $current_day_start);
        $this->db->where('in_time <=', $current_day_end);
        $this->db->where_in('GateId', ['G1', 'G2', 'G3', 'G4']);
        $this->db->group_by('GateId');
    
        $query = $this->db->get();
        
        
        return $query->result_array();
    }

    public function getGateCountsExit(){
        $current_day_start = strtotime('today midnight');
        $current_day_end = strtotime('tomorrow midnight') - 1;
        $this->db->select('GateEx, COUNT(*) as count');
        $this->db->from('parking');
        $this->db->where('in_time >=', $current_day_start);
        $this->db->where('in_time <=', $current_day_end);
        $this->db->where_in('GateEx', ['G1', 'G2', 'G3', 'G4']);
        $this->db->group_by('GateEx');
    
        $query = $this->db->get();
        
        
        return $query->result_array();
    }

    public function getDatabyDate() {
        $this->db->select([
            'DATE(FROM_UNIXTIME(in_time)) as date',
            'COUNT(CASE WHEN AccessType = "Plate" THEN 1 END) AS plate_number_count',
            'COUNT(CASE WHEN AccessType = "QR" THEN 1 END) AS qr_count',
            'COUNT(CASE WHEN AccessType = "Rftag" THEN 1 END) AS rftag_count',
            'SUM(CASE WHEN vechile_cat_id = 1 THEN 1 ELSE 0 END) AS motorcycle_count',
            'SUM(CASE WHEN vechile_cat_id = 2 THEN 1 ELSE 0 END) AS car_count',
            'SUM(CASE WHEN vechile_cat_id = 3 THEN 1 ELSE 0 END) AS bus_truck_count',
            'SUM(CASE WHEN GateId = "G1" THEN 1 ELSE 0 END) AS G1_count',
            'SUM(CASE WHEN GateId = "G2" THEN 1 ELSE 0 END) AS G2_count',
            'SUM(CASE WHEN GateId = "G3" THEN 1 ELSE 0 END) AS G3_count',
            'SUM(CASE WHEN GateId = "G4" THEN 1 ELSE 0 END) AS G4_count',
            'SUM(CASE WHEN GateEx = "G1" THEN 1 ELSE 0 END) AS G1Ex_count',
            'SUM(CASE WHEN GateEx = "G2" THEN 1 ELSE 0 END) AS G2Ex_count',
            'SUM(CASE WHEN GateEx = "G3" THEN 1 ELSE 0 END) AS G3Ex_count',
            'SUM(CASE WHEN GateEx = "G4" THEN 1 ELSE 0 END) AS G4Ex_count',
            'COUNT(*) AS total_count'
        ]);
        $this->db->from('parking');
        $this->db->where('in_time >=', strtotime('2024-08-07 00:00:00'));
        $this->db->group_by('DATE(FROM_UNIXTIME(in_time))');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDatabyAccessType($accessType) {
        $this->db->select([
            'DATE(FROM_UNIXTIME(in_time)) as date',
            'COUNT(*) AS access_type_count', // Count occurrences of the specified AccessType
            'SUM(CASE WHEN vechile_cat_id = 1 THEN 1 ELSE 0 END) AS motorcycle_count',
            'SUM(CASE WHEN vechile_cat_id = 2 THEN 1 ELSE 0 END) AS car_count',
            'SUM(CASE WHEN vechile_cat_id = 3 THEN 1 ELSE 0 END) AS bus_truck_count',
            'SUM(CASE WHEN GateId = "G1" THEN 1 ELSE 0 END) AS G1_count',
            'SUM(CASE WHEN GateId = "G2" THEN 1 ELSE 0 END) AS G2_count',
            'SUM(CASE WHEN GateId = "G3" THEN 1 ELSE 0 END) AS G3_count',
            'SUM(CASE WHEN GateId = "G4" THEN 1 ELSE 0 END) AS G4_count',
            'SUM(CASE WHEN GateEx = "G1" THEN 1 ELSE 0 END) AS G1Ex_count',
            'SUM(CASE WHEN GateEx = "G2" THEN 1 ELSE 0 END) AS G2Ex_count',
            'SUM(CASE WHEN GateEx = "G3" THEN 1 ELSE 0 END) AS G3Ex_count',
            'SUM(CASE WHEN GateEx = "G4" THEN 1 ELSE 0 END) AS G4Ex_count',
            'COUNT(*) AS total_count'
        ]);
        $this->db->from('parking');
        $this->db->where('AccessType', $accessType); // Use the parameter for AccessType
        $this->db->where('in_time >=', strtotime('2024-08-07 00:00:00'));
        $this->db->group_by('DATE(FROM_UNIXTIME(in_time))');
    
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getRecord() {
        $this->db->select([
            'DATE(FROM_UNIXTIME(in_time)) as date',
            'in_time',  // Example of additional columns
            'out_time',  // Example of additional columns
            'AccessType',
            'parking_code',
            'GateId',
            'GateEx',
            'vechile_cat_id'
        ]);
        $this->db->from('parking');
        $this->db->where('in_time >=', strtotime('2024-08-07 00:00:00'));
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    public function getRecordByAccessTypeAndDateRange($access, $startTimestamp, $endTimestamp) {
        $this->db->select([
            'DATE(FROM_UNIXTIME(in_time)) as date',
            'in_time',
            'out_time',
            'AccessType',
            'parking_code',
            'GateId',
            'GateEx',
            'vechile_cat_id'
        ]);
        $this->db->from('parking');
        $this->db->where('AccessType', $access);
        $this->db->where('in_time >=', $startTimestamp);
        $this->db->where('in_time <=', $endTimestamp);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    
    
    

    
    
    
    
}
?>
