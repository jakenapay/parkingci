<?php

class Model_report extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getParkingYear()
	{
		$sql = "SELECT * FROM parking WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();		
		$return_data = array();

		foreach ($result as $k => $v) {
			$date = date('Y', $v['in_time']);
			$return_data[] = $date;
		}
		$return_data = array_unique($return_data);
		return $return_data;
	}
	public function getParkingMonth($month)
	{
		if ($month) {
			$days = $this->days();
		}
	}
	public function getStayData($year)
	{
		if ($year) {	
			$final_data = array();
			for($index = 1; $index < 13; $index++){
				$get_mon_year = $year . '-' . $index;				
				$start_tamp = mktime(0, 0, 0, $index, 1, $year);				
				$end_tamp = mktime(0, 0, 0, $index, 31, $year);	
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum  FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G1' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate1'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G2' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate2'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G3' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate3'][] = $result->sum;				
				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G4' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate4'][] = $result->sum;			
			}
			return $final_data;
		}

	}
	public function getStayMonth($year,$month)
	{
		if ($year && $month	) {		
			$final_data = array();
			for($index = 1; $index < 32; $index++){
				$get_mon_year = $month . '/' . $index;				
				$start_tamp = mktime(0, 0, 0, $month, $index, $year);
				$end_tamp = mktime(23, 59, 59, $month, $index, $year);	
				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum  FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G1' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate1'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G2' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate2'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G3' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate3'][] = $result->sum;								
				$query = $this->db->query("SELECT SUM(`total_time`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G4' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate4'][] = $result->sum;			
			}
			return $final_data;
		}

	}
	public function getEntrygData($year)
	{
		if ($year) {	
			$final_data = array();
			for($index = 1; $index < 13; $index++){
				$get_mon_year = $year . '-' . $index;				
				$start_tamp = mktime(0, 0, 0, $index, 1, $year);				
				$end_tamp = mktime(0, 0, 0, $index, 31, $year);	
				$query = $this->db->query("SELECT * FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G1' ");					
				$final_data[$get_mon_year]['gate1'][] = $query->num_rows();				
				$query = $this->db->query("SELECT * FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G2' ");					
				$final_data[$get_mon_year]['gate2'][] = $query->num_rows();				
				$query = $this->db->query("SELECT * FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G3' ");					
				$final_data[$get_mon_year]['gate3'][] = $query->num_rows();				
				$query = $this->db->query("SELECT * FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G4' ");					
				$final_data[$get_mon_year]['gate4'][] = $query->num_rows();				
			}
			return $final_data;
		}

	}
	public function getEntrygMonth($year,$month)
	{
		if ($year && $month	) {				
			$final_data = array();
			for($index = 1; $index < 32; $index++){
				$get_mon_year = $month . '/' . $index;				
				$start_tamp = mktime(0, 0, 0, $month, $index, $year);
				$end_tamp = mktime(23, 59, 59, $month, $index, $year);	
				// echo(" month : ".$month_int." index : ".$index." start : ".$start_tamp." end : ".$end_tamp);
								
				$query = $this->db->query("SELECT *  FROM parking WHERE in_time BETWEEN '".$start_tamp ."' AND '".$end_tamp ."' AND `GateId`='G1'");									
				$final_data[$get_mon_year]['gate1'][] = $query->num_rows();				
				$query = $this->db->query("SELECT *  FROM parking WHERE in_time BETWEEN '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G2'");									
				$final_data[$get_mon_year]['gate2'][] = $query->num_rows();				
				$query = $this->db->query("SELECT *  FROM parking WHERE  in_time BETWEEN  '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G3'");								
				$final_data[$get_mon_year]['gate3'][] = $query->num_rows();				
				$query = $this->db->query("SELECT * FROM parking WHERE  in_time BETWEEN  '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G4'");								
				$final_data[$get_mon_year]['gate4'][] = $query->num_rows();				
			}
			return $final_data;
		}

	}
	public function getEarningData($year)
	{
		if ($year) {	
			$final_data = array();
			for($index = 1; $index < 13; $index++){
				$get_mon_year = $year . '-' . $index;				
				$start_tamp = mktime(0, 0, 0, $index, 1, $year);				
				$end_tamp = mktime(0, 0, 0, $index, 31, $year);	
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum  FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G1' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate1'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G2' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate2'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G3' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate3'][] = $result->sum;				
				
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE in_time >= '".$start_tamp ."' AND in_time <= '".$end_tamp ."' AND`GateId`='G4' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate4'][] = $result->sum;
			}
			return $final_data;
		}
	}
	public function getEarningMonth($year,$month)
	{
		if ($year && $month	) {				
			$final_data = array();
			for($index = 1; $index < 32; $index++){
				$get_mon_year = $month . '/' . $index;				
				$start_tamp = mktime(0, 0, 0, $month, $index, $year);
				$end_tamp = mktime(23, 59, 59, $month, $index, $year);	
				//echo(" month : ".$month_int." index : ".$index." start : ".$start_tamp." end : ".$end_tamp);
								
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum  FROM parking WHERE in_time BETWEEN '".$start_tamp ."' AND '".$end_tamp ."' AND `GateId`='G1' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate1'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE in_time BETWEEN '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G2' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate2'][] = $result->sum;				
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE  in_time BETWEEN  '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G3' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate3'][] = $result->sum;
				$query = $this->db->query("SELECT SUM(`earned_amount`) AS sum FROM parking WHERE  in_time BETWEEN  '".$start_tamp ."' AND  '".$end_tamp ."' AND `GateId`='G4' AND paid_status =1");					
				$result = $query->row();
				$final_data[$get_mon_year]['gate4'][] = $result->sum;				
			}
			return $final_data;
		}
	}
	public function getParkingData($year)
	{
		if ($year) {
			$months = $this->months();	
			// $startdate = strtotime("1 July ".$year);		
			// $enddate = strtotime("31 July ".$year);
			// $sql = "SELECT SUM(`earned_amount`) FROM parking WHERE in_time >= '".$startdate ."' AND in_time <= '".$enddate ."'AND paid_status =1";
			
			$sql = "SELECT * FROM parking WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();
			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;
				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['in_time']);
					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}
			return $final_data;
		}

	}
	

	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}
	private function days()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13', '14', '15', '16', '17', '18', '19', '20', '21', '22','23', '24', '25','26', '27', '28','29', '30', '31');
	}
}
