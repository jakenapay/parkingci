<?php 

class Model_parking extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_rates');
		$this->load->model('model_slots');
		$this->load->model('model_ptu');
	}
	
	public function getParkingPending()
	{
		$sql = "SELECT AccessType, parking_code FROM parking WHERE paid_status= 0  ORDER BY id DESC";
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getParkingDate($start = null,$end =null,$gate=null)
	{
		if($start && $end && $gate) {
			$sql = "SELECT * FROM parking WHERE  (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end') AND GateId = '$gate' ";			
			$query = $this->db->query($sql , array($start,$end));
			return $query->result_array();
		}elseif($start && $end) {
			$sql = "SELECT * FROM parking WHERE  (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end') ";			
			$query = $this->db->query($sql , array($start,$end));
			return $query->result_array();		
		}else{			
			// $sql = "SELECT * FROM parking  ORDER BY id DESC LIMIT 150";				
			$sql = "SELECT * FROM parking  ORDER BY id DESC LIMIT 1500";				
			$query = $this->db->query($sql);		
			return $query->result_array();
		}	
	}

	public function getTransaction($id){
		$this->db->select('*');
		$this->db->from('cashier_log');
		$this->db->where('cashierID', $id);
		$this->db->where('paid_status', 1);
		$this->db->limit(10);
		$queryTransaction = $this->db->get();

		if($queryTransaction->num_rows() > 0){
			return $queryTransaction->result_array();
		}else{
			return false;
		}
	}

	public function getTransactionAll($id){
		$this->db->select('*');
		$this->db->from('cashier_log');
		$this->db->where('cashierID', $id);
		$this->db->where('paid_status', 1);
		$queryTransaction = $this->db->get();

		if($queryTransaction->num_rows() > 0){
			return $queryTransaction->result_array();
		}else{
			return false;
		}
	}

	public function getParkingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM parking WHERE id = ?  ";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM parking  ORDER BY id DESC LIMIT 10";
		// $sql = "SELECT * FROM parking  ORDER BY id DESC   ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getParkingLive()
	{
		$sql = "SELECT * FROM parking  ORDER BY id DESC LIMIT 15";		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPaymentData()
	{
		$sql = "SELECT * FROM cashier_log   ORDER BY id DESC LIMIT 10";		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getPaymentAll()
	{
		$sql = "SELECT * FROM cashier_log   ORDER BY id DESC";		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getCashierToday($userid ,$date)
	{
		$sql = "SELECT * FROM cashier_log  WHERE cashierID =  '".$userid."' AND  `paid_time` LIKE  '".$date."%' ";	
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function create($data = '')
	{		
		$create = $this->db->insert('parking', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('parking', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('parking');
		return ($delete == true) ? true : false;
	}	
	
	public function check($accesstype,$code)
	{
		$sql = "SELECT * FROM parking  WHERE AccessType = '".$accesstype."'  AND parking_code ='".$code."' AND out_time ='' AND paid_status = '0'";														
		//  there is problem .. if the user need addtional payment , can't find the data
		// if we don't check paid status , we can fetch old data		
		$query = $this->db->query($sql);		
		if($query->num_rows() > 0) 
			return $query->row_array();		
		else 
			return false;					
	}
	public function checkexit($accesstype,$code)
	{
		if($accesstype == "RFtag")
			$sql = "SELECT * FROM parking  WHERE AccessType = '".$accesstype."'  AND parking_code ='".$code."'  AND out_time ='' ";														
		else
			$sql = "SELECT * FROM parking  WHERE AccessType = '".$accesstype."'  AND parking_code ='".$code."' AND out_time ='' ";
		//  $sql = "SELECT * FROM parking  WHERE AccessType = '".$accesstype."'  AND parking_code ='".$code."' AND out_time ='' AND paid_status = '1'";
		//  there is problem .. if the user need addtional payment , can't find the data
		// if we don't check paid status , we can fetch old data		
		$query = $this->db->query($sql);		
		if($query->num_rows() > 0) 
			return $query->row_array();		
		else 
			return 0;					
	}
	public function Kioskcheck($accesstype,$code)
	{
		$sql = "SELECT * FROM parking  WHERE AccessType = '".$accesstype."'  AND parking_code ='".$code."' AND out_time ='' AND paid_status = '0'";														
		//  there is problem .. if the user need addtional payment , can't find the data
		// if we don't check paid status , we can fetch old data		
		$query = $this->db->query($sql);		
		if($query->num_rows() > 0) 
			return $query->row_array();		
		else 
			return false;					
	}
	
        
        public function TerminaCheck($access, $code) 
    	{
        	$this->db->select('*');
        	$this->db->from('parking');
        	$this->db->where('AccessType', $access);
        	$this->db->where('parking_code', $code);
        	$this->db->where('paid_status', 0);
        
 	       $query = $this->db->get();
    
        // Use num_rows() instead of num_rows
        	if ($query->num_rows() > 0) {
            		return $query->row_array();
        	} else {
            		return false;
        	}
    	}


// FOR MOBILE

	public function updatePaidTerminal($data,$payment_status) 
	{
		if($payment_status == 1) {				
				$id = $data['parking_data']['id'];							
				$update_data = array(
					//'out_time' => strtotime($data['parking_data']['pay_time']),
					'paid_time'=> strtotime('now'),
					'paid_status' => 1,
					'total_time' => $data['parking_data']['Ptime'],
					'earned_amount' => $data['parking_data']['bill']
				);
				$this->db->where('id', $id);
				$update_ops = $this->db->update('parking', $update_data);
				date_default_timezone_set("Asia/Manila");
				$or =$this->model_ptu->getOR();	
				$data2 = array(
					'pid' => 1, 		
					'ORNO'=> $or+1,
					'GateId' => $data['parking_data']['gate'],								
					'AccessType'=>$data['parking_data']['access'], 
					'parking_code'=>$data['parking_data']['plate'], 
					'vechile_cat_id'=>$data['parking_data']['vehicle'], 
					'rate_id' => $data['parking_data']['vrate'],
					// 'rate_id'=>$data['parking_data']['discount'], 
					'in_time'=>$data['parking_data']['entry_time'],  
					'paid_time'=>date('m-d-y h:i:s'), 
					'total_time'=>$data['parking_data']['Ptime'], 
					'earned_amount'=>$data['parking_data']['bill'], 
					'pay_mode' => $data['parking_data']['paymode'], 
					'paid_status'=>1					
				);
				//print_r($data2);
			    $this->db->insert('cashier_log', $data2);		
				return ($update_data == true) ? true: false; 
		}
    }
	/*
	 update the payment information for the parking
	 gets the parking data from the id and 
	 caculate the difference time 
	 checks if the rate is based on the hourly or fixed rate
	*/
	public function updatePaid($data,$payment_status) 
	{
		if($payment_status == 1) {				
				$id = $data['parking_data']['id'];							
				$update_data = array(
					//'out_time' => strtotime($data['parking_data']['pay_time']),
					'paid_time'=> strtotime('now'),
					'paid_status' => 1,
					'total_time' => $data['parking_data']['Ptime'],
					'earned_amount' => $data['parking_data']['bill']
				);
				$this->db->where('id', $id);
				$update_ops = $this->db->update('parking', $update_data);
				date_default_timezone_set("Asia/Manila");
				$or =$this->model_ptu->getOR();	
				$data2 = array(
					'pid' => 1, 		
					'ORNO'=> $or+1,
					'GateId' => $data['parking_data']['gate'],								
					'AccessType'=>$data['parking_data']['access'], 
					'parking_code'=>$data['parking_data']['plate'], 
					'vechile_cat_id'=>$data['parking_data']['vehicle'], 
					'rate_id'=>$data['parking_data']['discount'], 
					'in_time'=>$data['parking_data']['entry_time'],  
					'paid_time'=>date("Y-m-d H:i:s"), 
					'total_time'=>$data['parking_data']['Ptime'], 
					'earned_amount'=>$data['parking_data']['bill'], 
					'pay_mode' => $data['parking_data']['pay_mode'],
					'paid_status'=>1					
				);
				//print_r($data2);
			    $this->db->insert('cashier_log', $data2);		
				return ($update_data == true) ? true: false; 
		}
		else 
			return false;
	}

	public function updateParking($data){

		$parkingId = $data['parking_data']['id'];
		$or = $data['parking_data']['ORNO'];
		$companyId = $data['parking_data']['companyid'];

		// echo $or;
		$clientData = array (
			'paid_time'		=>		$data['parking_data']['paymenttime'],
			'paid_status'	=>		1,
			'total_time'	=>		$data['parking_data']['parktime'],
			'earned_amount'	=>		$data['parking_data']['bill']
		);
		// print_r($clientData);
		$this->db->select('*');
		$this->db->where('id', $parkingId);
		$updateStatus = $this->db->update('parking', $clientData);

		if($updateStatus){
			$transactionData = array (
				'pid'				=>		1,
				'cashierID'			=>		$data['parking_data']['userid'],
				'ORNO'				=>		$data['parking_data']['ORNO'],
				'GateId'			=>		$data['parking_data']['gate'],
				'AccessType'		=>		$data['parking_data']['access'],
				'parking_code'		=>		$data['parking_data']['code'],
				'vechile_cat_id'	=>		$data['parking_data']['vehicle'],
				'rate_id'			=>		$data['parking_data']['discount'],
				'in_time'			=>		$data['parking_data']['etime'],
				'paid_time'			=>		$data['parking_data']['paymenttime'],
				'total_time'		=>		$data['parking_data']['parktime'],
				'earned_amount'		=>		$data['parking_data']['bill'],
				'pay_mode'			=>		$data['parking_data']['paymode'],
				'paid_status'		=>		1
			);
	
			$this->db->insert('cashier_log', $transactionData);

			// For company update
			$companyData = array (
				'OR'	=>$data['parking_data']['ORNO']
			);
			$this->db->where('id', $companyId);
			$this->db->update('company', $companyData);

			// For complimentary
			$pmethod = $data['parking_data']['paymode'];

			if($pmethod == "Complimentary"){
				$ticketId = $data['parking_data']['ticketid'];
				$comStatus = array (
					'is_used' => 1
				);

				$this->db->where('id', $ticketId);
				$this->db->update('complimentary', $comStatus);
			}
			return true;
		}else{
			return false;
		}
		// for cashier log
		
	}

	public function updateParkingforComplimentary($data){

		$parkingId = $data['parking_data']['id'];
		$or = $data['parking_data']['ORNO'];
		$companyId = $data['parking_data']['companyid'];

		// echo $or;
		$clientData = array (
			'paid_time'		=>		$data['parking_data']['paymenttime'],
			'paid_status'	=>		1,
			'total_time'	=>		$data['parking_data']['parktime'],
			'earned_amount'	=>		$data['parking_data']['bill']
		);
		// print_r($clientData);
		$this->db->select('*');
		$this->db->where('id', $parkingId);
		$updateStatus = $this->db->update('parking', $clientData);

		if($updateStatus){
			$transactionData = array (
				'pid'				=>		1,
				'cashierID'			=>		$data['parking_data']['userid'],
				'ORNO'				=>		$data['parking_data']['ORNO'],
				'GateId'			=>		$data['parking_data']['gate'],
				'AccessType'		=>		$data['parking_data']['access'],
				'parking_code'		=>		$data['parking_data']['code'],
				'vechile_cat_id'	=>		$data['parking_data']['vehicle'],
				'rate_id'			=>		$data['parking_data']['discount'],
				'in_time'			=>		$data['parking_data']['etime'],
				'paid_time'			=>		$data['parking_data']['paymenttime'],
				'total_time'		=>		$data['parking_data']['parktime'],
				'earned_amount'		=>		$data['parking_data']['bill'],
				'pay_mode'			=>		$data['parking_data']['paymode'],
				'paid_status'		=>		1
			);
	
			$this->db->insert('cashier_log', $transactionData);

			// For company update
			$companyData = array (
				'OR'	=>$data['parking_data']['ORNO']
			);
			$this->db->where('id', $companyId);
			$this->db->update('company', $companyData);

			// For complimentary
			$ticketId = $data['parking_data']['ticketid'];
			$comStatus = array (
				'is_used' => 1
			);
			$this->db->where('id', $ticketId);
			$this->db->update('complimentary', $comStatus);
			return true;
		}else{
			return false;
		}
		// for cashier log
		
	}

	public function updatePaidPayStation($data,$payment_status) 
	{
		if($payment_status == 1) {				
				$id = $data['parking_data']['id'];							
				$update_data = array(
					//'out_time' => strtotime($data['parking_data']['pay_time']),
					'paid_time'=> strtotime('now'),
					'paid_status' => 1,
					'total_time' => $data['parking_data']['Ptime'],
					'earned_amount' => $data['parking_data']['bill']
				);
				$this->db->where('id', $id);
				$update_ops = $this->db->update('parking', $update_data);
				date_default_timezone_set("Asia/Manila");
				$or =$this->model_ptu->getOR();	
				$data2 = array(
					'pid' => 1, 		
					'ORNO'=> $or+1,
					'GateId' => $data['parking_data']['gate'],								
					'AccessType'=>$data['parking_data']['access'], 
					'parking_code'=>$data['parking_data']['plate'], 
					'vechile_cat_id'=>$data['parking_data']['vehicle'], 
					'rate_id' => $data['parking_data']['vrate'],
					// 'rate_id'=>$data['parking_data']['discount'], 
					'in_time'=>$data['parking_data']['entry_time'],  
					'paid_time'=>date('m-d-y h:i:s'), 
					'total_time'=>$data['parking_data']['Ptime'], 
					'earned_amount'=>$data['parking_data']['bill'], 
					'pay_mode' => "cash", 
					'paid_status'=>1					
				);
				//print_r($data2);
			    $this->db->insert('cashier_log', $data2);		
				return ($update_data == true) ? true: false; 
		}
		else 
			return false;
	}

	
	public function updatePayment($id, $payment_status) 
	{
		if($id && $payment_status) {
			if($payment_status == 1) {
				// get the data of parking data
				$data = $this->getParkingData($id);				
				$check_in_time = $data['in_time'];
				$rate_id = $data['rate_id'];
				$slot_id = $data['slot_id'];
				$checkout_time = strtotime('now');
				// calculates the time by hourly
				$total_time = ceil((abs($checkout_time - $check_in_time) / 60) / 60);
				$rate_data = $this->model_rates->getRateData($rate_id);
				$earned_amount = 0;
				if($rate_data['type'] == 2) {
					// means hourly
					$earned_amount = ((int) $rate_data['rate'] * (int) $total_time);					
				}
				else {
					$earned_amount = $rate_data['rate'];
				}
				$update_data = array(
					'paid_time' => $checkout_time,
					'paid_status' => 1,
					'total_time' => $total_time,
					'earned_amount' => $earned_amount
				);

				$this->db->where('id', $id);
				$update_ops = $this->db->update('parking', $update_data);

				if($update_ops == true) {

					$slot_update_data = array(
						'availability_status' => 1
					); 
					$update_slot_ops = $this->model_slots->updateSlotAvailability($slot_update_data, $slot_id);
				}
				else {
					return false;
				}

				return ($update_ops == true && $update_slot_ops == true) ? true : false;

			} // /elseif
			else {
				$update_data = array(
					'paid_time' => '',
					'paid_status' => 0,
					'earned_amount' => 0				
				);

				$this->db->where('id', $id);
				$update_data = $this->db->update('parking', $update_data);
				return ($update_data == true) ? true: false; 
				
			}
		} // /if
		return false;
	}

	public function countTotalParking()
	{
		$sql = "SELECT * FROM parking";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	
	public function countTotalEarning() {
		$this->db->select_sum('earned_amount');
		$result = $this->db->get('parking')->row();  
		return $result->earned_amount;
	}

	public function countTotalUnpaid() {
		$sql = "SELECT * FROM parking WHERE paid_status = 0";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	public function CheckRFTag($code = null)
	{
		if($code) {
			$sql = "SELECT * FROM rfid_vehicle WHERE RFID = ?  ";
			$query = $this->db->query($sql, array($code));
			if($query->num_rows() > 0) {
				return $query->row_array();
			}
			else {
				return false;
			}			
		}
		else
		{
			return false;
		}
	}
	public function SerachPlate($plate = null)
	{
		if($plate) {
			$sql = "SELECT * FROM `parking` WHERE  `AccessType` ='Plate' AND `out_time` = '' AND `parking_code` LIKE '%$plate%' ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else
		{
			return false;
		}

	}

	public function getAnprParkingRecords(){
		$this->db->select('*');
		$this->db->where('AccessType', 'Plate');
		$this->db->where('out_time', '');
		$this->db->where('paid_status', 0);
		$this->db->from('parking');
		$this->db->limit(20);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function getSimilarRecord($plate){
		$this->db->select('*');
		$this->db->where('AccessType', 'Plate');
		$this->db->where('out_time', '');
		$this->db->like('parking_code', $plate);
		$this->db->from('parking');
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function DiscountSlot($gate = null)
	{
		if($gate == 'G4') {			
			$query = $this->db->query("SELECT * FROM `slots` WHERE  `id` =5 ");
			$num_slot = $query->row_array();
			if($num_slot['vacant'] > 0 AND $num_slot['occupied'] < $num_slot['num_slot'])
			{
				$vacant = $num_slot['vacant'] -1;
				$occupied = $num_slot['occupied'] + 1;
				$sql = "UPDATE `slots` SET `vacant` = '".$vacant."', `occupied` = '".$occupied."' WHERE `slots`.`id` = 5";
				$query = $this->db->query($sql);
				return $vacant;
			}
			else
			{				
				return 0;
			}
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `slots` WHERE  `id` =1 ");
			$num_slot = $query->row_array();
			if($num_slot['vacant'] > 0 AND $num_slot['occupied'] < $num_slot['num_slot'])
			{
				$vacant = $num_slot['vacant'] -1;
				$occupied = $num_slot['occupied'] + 1;
				$sql = "UPDATE `slots` SET `vacant` = '".$vacant."', `occupied` = '".$occupied."' WHERE `slots`.`id` = 1";
				$query = $this->db->query($sql);
				return $vacant;
			}
			else
			{				
				$vacant =0;
				return 0;
			}
		}

	}
	public function AddSlot($gate = null)
	{
		if($gate == 'G4') {			
			$query = $this->db->query("SELECT * FROM `slots` WHERE  `id` =5 ");
			$num_slot = $query->row_array();
			$vacant = $num_slot['vacant'] ;
			if($num_slot['vacant'] < $num_slot['num_slot'] AND $num_slot['occupied'] >0 )
			{
				$vacant = $num_slot['vacant'] +1;
				$occupied = $num_slot['occupied'] - 1;
				$sql = "UPDATE `slots` SET `vacant` = '".$vacant."', `occupied` = '".$occupied."' WHERE `slots`.`id` = 5";
				$query = $this->db->query($sql);
				return $vacant;
			}
			else
			{				
				return $vacant;
			}
		}
		else
		{
			$query = $this->db->query("SELECT * FROM `slots` WHERE  `id` =1 ");
			$num_slot = $query->row_array();
			$vacant = $num_slot['vacant'] ;
			if($num_slot['vacant'] < $num_slot['num_slot'] AND $num_slot['occupied'] >0 )
			{
				$vacant = $num_slot['vacant'] +1;
				$occupied = $num_slot['occupied'] +-1;
				$sql = "UPDATE `slots` SET `vacant` = '".$vacant."', `occupied` = '".$occupied."' WHERE `slots`.`id` = 1";
				$query = $this->db->query($sql);
				return $vacant;
			}
			else
			{				
				return $vacant;
			}
		}

	}
}
