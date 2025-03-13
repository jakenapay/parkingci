<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/fpdf/fpdf.php');

class Parking extends Admin_Controller 
{
	

	public function __construct()
	{
		parent::__construct();

		// $this->not_logged_in();
		ob_start();
		$this->data['page_title'] = 'Parking';
		$this->load->model('model_parking');
		$this->load->model('model_category');
		$this->load->model('model_slots');
		$this->load->model('model_rates');
		$this->load->model('model_company');
		ob_end_clean();
	}

	public function index()
	{

		if(!in_array('viewParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		

		$start = $this->input->get('start');    
    	$end = $this->input->get('end');    
		$gate = $this->input->get('gate');
		$action = $this->input->get('submit');
		if ($action === "Export") {
			date_default_timezone_set('Asia/Manila');

			$parking_data = $this->model_parking->getParkingDate($start, $end, $gate);
			
			$selected_start_date = date("Y-m-d", strtotime($start));
			$selected_end_date = date("Y-m-d", strtotime($end));
			$current_date = date("Y-m-d");
			$filename = "parking_data_report_" . $selected_start_date . "_to_" . $selected_end_date . "_generated_on_" . $current_date . ".csv";

			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Pragma: no-cache');
			header('Expires: 0');
		
			$output = fopen('php://output', 'w');
		
			fputcsv($output, array('DATE', 'Gate In', 'Gate Out', 'Type', 'Code', 'Vehicle Type', 'Check In', 'Check Out', 'Total Time', 'Total Amount'));
			date_default_timezone_set('Asia/Manila');

			foreach ($parking_data as $row) {
				$date = ($row['in_time'] != '') ? date('Y-m-d', $row['in_time']) : '-';
				$gate_in = $row['GateId'];
				$gate_out = $row['GateEx'] ?: '-';
				$type = $row['AccessType'];
				$code = $row['parking_code'];
				$vehicle_types = array(1 => 'Motorcycle', 2 => 'Car', 3 => 'Bus/Truck', 4 => 'Unknown');
				$vehicle_type = isset($vehicle_types[$row['vechile_cat_id']]) ? $vehicle_types[$row['vechile_cat_id']] : 'Unknown';
				$check_in = ($row['in_time'] != '') ? date('m/d h:i:sA', $row['in_time']) : '-';
				$check_out = ($row['out_time'] != '') ? date('m/d h:i:sA', $row['out_time']) : '-';
				$total_time = ($row['in_time'] != '') ? round((time() - $row['in_time']) / 60) . 'm' : '';
				$total_amount = ($row['earned_amount'] != '') ? $row['earned_amount'] : '';
		
				$formatted_row = array($date, $gate_in, $gate_out, $type, $code, $vehicle_type, $check_in, $check_out, $total_time, $total_amount);
				
				fputcsv($output, $formatted_row);
			}
		
			fclose($output);
			exit;
		}else if($action === "Print"){
			date_default_timezone_set('Asia/Manila');
			if($start && $end){
				$parking_data = $this->model_parking->getParkingDate($start, $end, $gate);
				$date = date('Y-m-d');

				$pdf = new FPDF('L', 'mm', 'Legal');
				$pdf->AddPage();
		
				$pdf->SetFont('Arial', '', 10);
		
				$pdf->SetFont('Arial', 'B', 16);
				$pdf->Cell(0, 8, 'PHILIPPINE INTERNATIONAL CONVENTION CENTER', 0, 1, 'C');
				$pdf->Cell(0, 8, 'Smart Parking System', 0, 1, 'C');
				$pdf->Cell(0, 8, 'Parking Report', 0, 1, 'C');
				$pdf->SetFont('Arial', '', 10);
				$pdf->SetFont('Arial', '', 14);
				$pdf->Cell(0, 8, 'Date Generated:' . ' ' . $date, 0, 1, 'C');
				$pdf->SetFont('Arial', '', 10);
		
				$pdf->Cell(30, 10, 'Date', 1);
				$pdf->Cell(20, 10, 'Gate In', 1);
				$pdf->Cell(20, 10, 'Gate Out', 1);
				$pdf->Cell(30, 10, 'Type', 1);
				$pdf->Cell(35, 10, 'Code', 1);
				$pdf->Cell(30, 10, 'Vehicle Type', 1);
				$pdf->Cell(40, 10, 'Check-In', 1);
				$pdf->Cell(40, 10, 'Check-Out', 1);
				$pdf->Cell(30, 10, 'Total Time', 1);
				$pdf->Cell(30, 10, 'Total Amount', 1);
				$pdf->Cell(30, 10, 'Paid Status', 1);
				$pdf->Ln();
				date_default_timezone_set('Asia/Manila');
				foreach ($parking_data as $row) {
					$pdf->Cell(30, 10, date('Y-m-d', $row['in_time']), 1);
					$pdf->Cell(20, 10, $row['GateId'], 1);
					$pdf->Cell(20, 10, $row['GateEx'], 1);
					$pdf->Cell(30, 10, $row['AccessType'], 1);
					$pdf->Cell(35, 10, $row['parking_code'], 1);
					$pdf->Cell(30, 10, $row['vechile_cat_id'] == 1 ? 'Motorcycle' : ($row['vechile_cat_id'] == 2 ? 'Car' : ($row['vechile_cat_id'] == 3 ? 'Bus/Truck' : 'Unknown')), 1);
					$pdf->Cell(40, 10, date('Y-m-d H:i:s', $row['in_time']), 1);
					$pdf->Cell(40, 10, $row['out_time'] ? date('Y-m-d H:i:s', $row['out_time']) : '-', 1);
					$pdf->Cell(30, 10, $row['total_time'] . ($row['total_time'] > 1 ? 'm' : ''), 1);
					$pdf->Cell(30, 10, $row['earned_amount'] ?: '-', 1);
					$pdf->Cell(30, 10, $row['paid_status'] == 1 ? 'Paid' : 'Not Paid', 1);
					$pdf->Ln();
				}
		
				$pdf->Output('D', 'Parking_Report.pdf');

			}
			
		}
		
		
		
		
		date_default_timezone_set('Asia/Manila');
		$this->data['date'] = date("Y-m-d", strtotime('now'));
		$this->data['company_currency'] = $this->company_currency();		
		if($start && $end){
			$this->data['start'] =$start;
			$this->data['end'] =$end;
			$this->data['parking_data'] = $this->model_parking->getParkingDate($start, $end, $gate);
			//$this->data['parking_data'] = $this->model_parking->getParkingData();
		}
		else{
			$this->data['start'] ='';
			$this->data['end'] ='';			  
			$this->data['parking_data'] = $this->model_parking->getParkingDate();
		}				
		$this->render_template('parking/index', $this->data);
		
	}


	
	public function anpr()
	{
				
		$data = array(
			'parkingNo' => $this->input->post('parkingNo'),
			'IPCam' => $this->input->post('IPCam'),
			'vehicleNo' => $this->input->post('vehicleNo'),
			'confidence' => $this->input->post('confidence'),
			'passDataTime' => $this->input->post('passDataTime'),
			'pictureName' => $this->input->post('pictureName'),
			'picturePath' => $this->input->post('picturePath'),			
			'remark' => $this->input->post('remark')
		);		
		echo  json_encode($data);			
		echo ('accepted');
		
	}

	
	public function QRChecker($code)
	{
		$pattern = "/[-\s]/" ;
		$components = preg_split($pattern, $code);		
		print_r($components);		
		return($components[1]);
	}
	
	
	public function entry()  // Parking Barrier 
	{
		// check plate number and checked in time and payment status
		// need check 3 mode RF tag, plate number, manual button 
		// check mode flag  1 RF tag, 2 plate number, 3 manual button
		// in case RF tag , verify RF tag 
		// in case plate number , save plate number and checked in time and payment status 0
		// in case manual button , save checked in time and payment status 0
		// if plate number is exist then send message already exist
		// manual button , check vehicle category and rate and slot
		// parking_slot = gate 
		//ob_end_clean();
		$codetype = $this->input->post('AccessType'); 
		$code =  $this->input->post('parkingcode');
		$gate =  $this->input->post('Gate');
		
		if($codetype == 'RFtag'){   // if access type is RF tag, need to check database and return result
			$parkingvalid=$this->model_parking->CheckRFTag($code);
			if($parkingvalid){  				
				echo ('accepted');
				$num_slot=$this->model_parking->DiscountSlot($gate);
				
			}
			else {
				echo ('rejected RFtag');
				return;
			}
		}
		else if($codetype == 'Plate'){
			$parkingvalid= 1;         // need to check plate number validation 
			if($parkingvalid){  
				echo ('accepted');
				$num_slot=$this->model_parking->DiscountSlot($gate);
				
			}
			else {
				echo ('rejected Plate');
				return;
			}
		}
		else if($codetype == 'QR'){			
			// $pattern = "/[-\s]/" ;
			// $components = preg_split($pattern, $code);		
			// print_r($components);	
			$parkingvalid=1;
			if($parkingvalid){  				
				echo ('accepted');
				$num_slot=$this->model_parking->DiscountSlot($gate);				
			}
			else {
				echo ('rejected QR');
				return;
			}
		}
		else{
//			ob_end_clean();
			echo ('rejected unknown code');
			return;
		}
		$data = array(
			'GateId' => $this->input->post('Gate'),
			'AccessType' => $this->input->post('AccessType'),   // Plate , QR,  RFtag , plate number , QR code , manual button
			'parking_code' => $this->input->post('parkingcode'),
			'vechile_cat_id' => $this->input->post('vehicle_cat'),
			'rate_id' => $this->input->post('rate_id'),
			'slot_id' => $this->input->post('Gate'),
			'pictureName' => '',
			'picturePath' => '',
			'in_time' => strtotime('now'),
			'out_time' => '',
			'paid_time' => '',
			'total_time' => '',
			'earned_amount' => '',
			'paid_status' => 0			
		);	
		
		if($codetype == 'Plate'){
			$data['pictureName']= $this->input->post('pictureName');
			$data['picturePath'] = $this->input->post('picturePath');
		}
		$create = $this->model_parking->create($data);
		//$num_slot=$this->model_parking->DiscountSlot($gate);
		/*
		if($codetype == 'Plate'){		
			$imagedata = $this->input->post('image');
		//	echo $imagedata;
			$bin= imagecreatefromstring ($imagedata);
		//	$bin = base64_decode($imagedata);	
			$filename = $this->input->post('pictureName');
			$filepath = '/assets/images/';
			$fullpath = $filepath.$filename;
			echo $fullpath;			
			// file_put_contents($fullpath, $bin);
		}	
		*/
		/*
		$im = imageCreateFromString($bin);
		if (!$im) {
			echo ('Base64 value is not a valid image');
		}
		else{
			$filename = $this->input->post('pictureName');
			$filepath = $this->input->post('picturePath');
			$fullpath = $filepath.$filename;
			echo $fullpath;			
			imagepng($im, $fullpath, 0);
			imagepng($im, $fullpath);
			imagedestroy($im);
		}
		*/
		// echo  json_encode($data);
		
		/*
		if($create == true) {			
			echo ('accepted');			
		}
		else {			
			echo ('rejected');
			return;
		}
		*/
	}
	public function exit()
	{
//		ob_end_clean();
		$codetype = $this->input->post('AccessType'); 		
		$code =  $this->input->post('parkingcode');		
		$parkingvalid=$this->model_parking->checkexit($codetype,$code);
		$gate= $this->input->post('Gate');
		if($parkingvalid==0){
			echo ('rejected');			
		}
		else{
			date_default_timezone_set("Asia/Manila");	
			if($codetype =='RFtag'){
				$data = array(
					'GateEx' => $this->input->post('Gate'),
					'paid_status' => 1,
					'out_time' => strtotime('now')
					
				);			
				$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
				echo ('accepted');	
				$num_slot=$this->model_parking->AddSlot($gate);					 		
			}
			else{
				if($parkingvalid['paid_status'] ==1) {
					$paid_time = $parkingvalid['paid_time'];
					$out_time 	= strtotime('now');
					$diff_time = $out_time - $paid_time;
					$data = array(
						'GateEx' => $this->input->post('Gate'),
						'out_time' => strtotime('now')
					);			
					$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
					echo ('accepted');	
					$num_slot=$this->model_parking->AddSlot($gate);								 		
				}
				else{    // not paid
					$check_in_time = $parkingvalid['in_time'];			
					$checkout_time = strtotime('now');	
					$total_min = ceil((abs($checkout_time - $check_in_time) / 60) );	
					
					if($total_min < 15){   // 15 minutes free
						$data = array(
							'GateEx' => $this->input->post('Gate'),
							'paid_status' => 1,
							'total_time' => $total_min, 
							'out_time' => $checkout_time
						);			
						$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
						echo ('accepted');	
						$num_slot=$this->model_parking->AddSlot($gate);																	
					}
					else{
						/* only test */
						$data = array(
							'GateEx' => $this->input->post('Gate'),
							'paid_status' => 1,
							'total_time' => $total_min, 
							'out_time' => $checkout_time
						);			
						$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
						echo ('accepted');	
						$num_slot=$this->model_parking->AddSlot($gate);																	

					}
				}				
				
			}				
		}		
	}
	/////////////////   new add code end  	 

	public function create()
	{
		if(!in_array('createParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('parking_gate', 'parking_gate', 'required');
		$this->form_validation->set_rules('accesstype', 'accesstype', 'required');
		$this->form_validation->set_rules('Code', 'Code', 'required');
		$this->form_validation->set_rules('vehicle_cat', 'Category', 'required');
		$this->form_validation->set_rules('vehicle_rate', 'Rate', 'required');

        if ($this->form_validation->run() == TRUE) {
			$accesstype = $this->input->post('accesstype');
			$code = $this->input->post('Code');
			echo ($code);
			/*
			if($accesstype == 'QR'){
				$pattern = "/[-\s]/" ;
				$components = preg_split($pattern, $code);		
				print_r($components);
				$code = $components[1];	
			}
			*/	
			
			$data = array(
				'GateId' => $this->input->post('parking_gate'),
				'AccessType' => $accesstype,   // Plate , QR,  RFtag , plate number , QR code , manual button
				'parking_code' => $code,
				'vechile_cat_id' => $this->input->post('vehicle_cat'),
				'rate_id' => $this->input->post('vehicle_rate'),
				'slot_id' => $this->input->post('parking_gate'),
				'pictureName' => '',
				'picturePath' => '',				
				'in_time' => strtotime('now'),
				'out_time' => '',
				'paid_time' => '',
				'total_time' => '',
				'earned_amount' => '',
				'paid_status' => 0			
			);
        	$create = $this->model_parking->create($data);
        	if($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
		    	redirect('parking/', 'refresh');	
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        	redirect('parking/create', 'refresh');
        	}        	
        }
        else {
        	$vehicle_cat = $this->model_category->getActiveCategoryData();        	
        	$this->data['vehicle_cat'] = $vehicle_cat;
        	$slots = $this->model_slots->getAvailableSlotData();
			$gate = $this->model_slots->getAvailableGateData();
        	$this->data['slot_data'] = $slots;
			$this->data['gate_data'] = $gate;
			$this->render_template('parking/create', $this->data);
		}
	}

	public function View($id = null)
	{
		if($id) {	        	
				$vehicle_cat = $this->model_category->getCategoryData();
	        	$this->data['vehicle_cat'] = $vehicle_cat; 
	        	$parking_data = $this->model_parking->getParkingData($id);
	        	$this->data['parking_data'] = $parking_data;
				$this->render_template('parking/view', $this->data);
	    }
		else {		
			redirect('parking/', 'refresh');
		}				
	}

	public function edit($id = null)
	{
		if(!in_array('updateParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			/*
			$this->form_validation->set_rules('parking_gate', 'parking_gate', 'required');
			$this->form_validation->set_rules('accesstype', 'accesstype', 'required');
			$this->form_validation->set_rules('Code', 'Code', 'required');
			$this->form_validation->set_rules('vehicle_cat', 'Category', 'required');
			$this->form_validation->set_rules('vehicle_rate', 'Rate', 'required');
			*/
			if ($this->form_validation->run() == TRUE) {
            // true case
	        	$save_parking_data = $this->model_parking->getParkingData($id);
	        	$before_slot_id = $save_parking_data['slot_id'];

	        	// update the slot data
	        	$update_slot = array(
	        		'availability_status' => 1
	        	);
	        	$this->model_slots->updateSlotAvailability($update_slot, $before_slot_id);

	        	$data = array(
	        		'vechile_cat_id' => $this->input->post('vehicle_cat'),
	        		'rate_id' => $this->input->post('vehicle_rate'),
	        		'slot_id' => $this->input->post('parking_slot'),
	        	);

	        	$update_parking_data = $this->model_parking->edit($data, $id);
	        	if($update_parking_data == true) {

	        		// now unavailable the slot
	        		$slot_data = array(
	        			'availability_status' => 2
	        		);

	        		$update_slot = $this->model_slots->updateSlotAvailability($slot_data, $this->input->post('parking_slot'));

	        		if($update_parking_data == true && $update_slot == true) {
	        			$this->session->set_flashdata('success', 'Successfully created');
			    		redirect('parking/', 'refresh');	
	        		}
	        		else {
	        			$this->session->set_flashdata('errors', 'Error occurred!!');
		        		redirect('parking/create', 'refresh');
	        		}
	        		
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('parking/create', 'refresh');
	        	}
	        }
			else {
				$vehicle_cat = $this->model_category->getCategoryData();
	        	$this->data['vehicle_cat'] = $vehicle_cat;

	        	$slots = $this->model_slots->getAvailableSlotData();
	        	$this->data['slot_data'] = $slots;

	        	$save_parking_data = $this->model_parking->getParkingData($id);
	        	$this->data['save_parking_data'] = $save_parking_data;

	        	// used parking slot info
	        	$get_used_slot = $this->model_slots->getSlotData($save_parking_data['slot_id']);

	        	$get_used_rate = $this->model_rates->getCategoryRate($save_parking_data['vechile_cat_id']);

	        	$this->data['slot_data'][] = $get_used_slot;
	        	$this->data['get_used_rate_data'] = $get_used_rate;

	        	// echo "<pre>";
	        	// print_r($save_parking_data);
	        	// die;
	        	

				$this->render_template('parking/edit', $this->data);	
			}				
		}
		
	}

	public function delete($id = null)
	{
		if(!in_array('deleteParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			if($this->input->post('confirm')) {

				$delete = $this->model_parking->delete($id);
				if($delete == true) {
	        		$this->session->set_flashdata('success', 'Successfully removed');
	        		redirect('parking/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('error', 'Error occurred!!');
	        		redirect('parking/delete/'.$id, 'refresh');
	        	}	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('parking/delete', $this->data);	
			}	
			
			
		}	
	}

	public function printInvoice($id)
	{
		if(!in_array('viewParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if($id) {
			$parking_data = $this->model_parking->getParkingData($id);
			$company_info = $this->model_company->getCompanyData(1);

			
			$gateid = $parking_data['GateId'];
			$accesstype = $parking_data['AccessType'];
			$parking_code = $parking_data['parking_code'];
			$vechile_cat_id = $parking_data['vechile_cat_id'];
			$paid_status = $parking_data['paid_status'];
			$paid_time = $parking_data['paid_time'];

			if($paid_status == 0){
				$paid_time = "not yet paid";
				$earned_amount = 0;
			}
			else{
				$paid_time = date("h:i a", $parking_data['paid_time']);
				$earned_amount = $parking_data['earned_amount'];
			}
			if($parking_data['total_time'])
			{
				$total_time = $parking_data['total_time'];
				$hour = floor($total_time / 3600);
				$min = floor(($total_time % 3600) / 60);
				$total_time = $hour.' Hour '.$min.' Min';
			}
			else{
				$total_time = "not yet out";
			}
			
			$earned_amount = $parking_data['earned_amount'];
			$picturePath = $parking_data['picturePath'];
			$pictureName = $parking_data['pictureName'];		
			

			$vehicle_category = $this->model_category->getCategoryData($parking_data['vechile_cat_id']);
			$check_in_date = date("Y-m-d", $parking_data['in_time']);
			$check_in = date("h:i a", $parking_data['in_time']);
			if($parking_data['out_time'] == 0){
				$check_out_date = "not yet out";
				$check_out = "not yet out";
			}			
			else{
				$check_out_date = date("Y-m-d", $parking_data['out_time']);
				$check_out = date("h:i a", $parking_data['out_time']);
			}
			$html = '<html>
				<head>
				 	<title>Print</title>
				 	<style>
				 	.main-content {
					    text-align: center;
					    width: 100%;
					}

					table.table {
					    width: 50%;
					    margin: 0 auto;
					    text-align: left;
					}
				 	</style>
				</head>
				<body>
					<div class="main-content">
						<div class="company-info">
							<div class="company-name"><p>'.$company_info['name'].'</p></div>
							<div class="company-address"><p>'.$company_info['address'].'</p></div>
							<div class="parking-slip"><h2>Parking Slip</h2></div>
						</div>
						<div class="parking-info">
							<table class="table">
								<tr>
									<td>Date: '.$check_in_date.'</td>
									<td>Time: '.$check_in.'</td>									
								</tr>
								<tr>
									<td>Date: '.$check_out_date.'</td>
									<td>Time: '.$check_out.'</td>
								</tr>
								<tr>
									<td>Vehicle type: '.ucwords($vehicle_category['name']).' </td>
								</tr>
								<tr>
									<td>Access Type: '.$parking_data['AccessType'].' </td>
									<td>Parking no: '.$parking_data['parking_code'].' </td>
								</tr>
								<tr>
									<td>Parking Time: '.$total_time.' </td>
								</tr>
								<tr>
									<td>Bill Amount: Php  '.$parking_data['earned_amount'].' </td>
								</tr>
							</table>							
							<p> For you own convenience, please do not loose the slip. </p>
						</div>
						<div >
							<img src="'.$picturePath.$pictureName.'" style="width: 400px; height:400px" class="img-rounded"  id="myImage">
						</div>
					</div>					
				</body>
			</html>
			';

			echo $html;
		}
	}

	public function updatepayment() 
	{
		if(!in_array('updateParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$id = $this->input->post('parking_id');
		if($id) {
			// getting the parking data 
			$updatePayment = $this->model_parking->updatePayment($id, $this->input->post('payment_status'));
			if($updatePayment == true) {
    			$this->session->set_flashdata('success', 'Successfully updated');
	    		redirect('parking/', 'refresh');	
    		}
    		else {
    			$this->session->set_flashdata('payment_error', 'Error occurred!!');
        		redirect('parking/edit/'.$id, 'refresh');
    		}
		}
	}

	public function getCategoryRate($id) 
	{
		if($id) {
			$rate_data = $this->model_rates->getCategoryRate($id);
			$html = '';
			foreach ($rate_data as $k => $v) {
				$html .= '<option value="'.$v['id'].'">'.$v['rate_name'].'</option>';
			}
			
			echo json_encode($html);
		}
	}
	public function live() 
	{
		if(!in_array('viewParking', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$parking_data = $this->model_parking->getParkingLive();
	
		$result = array();
		foreach ($parking_data as $k => $v) {
			$result[$k]['parking'] = $v;
			$category_data = $this->model_category->getCategoryData($v['vechile_cat_id']);
			$slot_data = $this->model_slots->getSlotData($v['slot_id']);
			$rate_data = $this->model_rates->getRateData($v['rate_id']);

			$result[$k]['category'] = $category_data;
			$result[$k]['slot'] = $slot_data;
			$result[$k]['rate'] = $rate_data;
		}

		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $result;
		$this->render_template('parking/live', $this->data);
	}

	public function anpr_entry()  // Parking Barrier 
	{
		ob_end_clean();
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);

		$codetype = $data['AccessType'];
		$code = $data['parkingcode'];

		if($codetype != 'Plate'){
			echo ('rejected unknown code');
			return;
		}
		
		$cdate=date("Y-m-d", strtotime('now'));
		$image_name = $data['pictureName'];	
		$image_data = base64_decode($data['picture']);
		$image_path ="asset/images/".$cdate."/".$data['Gate']."/";
		$anprdata = array(
			'GateId' => $data['Gate'],
			'AccessType' => $data['AccessType'],  
			'parking_code' => $data['parkingcode'],
			'vechile_cat_id' => $data['vehicle_cat'],
			'rate_id' => $data['rate_id'],
			'slot_id' => $data['Gate'],
			'pictureName' => $data['pictureName'],
			'picturePath' => $image_path,
			'in_time' => strtotime('now'),
			'out_time' => '',
			'paid_time' => '',
			'total_time' => '',
			'earned_amount' => '',
			'paid_status' => 0			
		);	
		$create = $this->model_parking->create($anprdata);
		$num_slot=$this->model_parking->DiscountSlot($data['Gate']);
		// echo ($image_path.$image_name);
		
		if (!is_dir($image_path)){
			mkdir($image_path, 0777, true);
			file_put_contents(($image_path.$image_name), $image_data);
			// echo '(1)Image saved as ' . $image_name;
		}
		else {
			file_put_contents(($image_path.$image_name), $image_data);
		// 	echo '(2)Image saved as ' . $image_name;
		}		
		if($create == true) {			
			echo ('accepted');			
		}
		else {		
			echo ('rejected');
			return;
		}
		
	}
	public function entrytest() 
	{

		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);
		$image_name = $data['pictureName'];
		echo ($image_name);
		$image_data = base64_decode($data['picture']);		
		$image_path ="asset/images/";
		echo ($image_path.$image_name);
		
		if (!is_dir($image_path)){
        		mkdir($image_path, 0777, true);
    			file_put_contents(($image_path.$image_name), $image_data);
				echo '(1)Image saved as ' . $image_name;
		}
		else {
			file_put_contents(($image_path.$image_name), $image_data);
			echo '(2)Image saved as ' . $image_name;
		}
		
		
	}

	public function anpr_In()   
	{
		ob_end_clean();
		$a=array("G1"=>"138","G2"=>"141","G2"=>"143","G3"=>"150","G4"=>"155");
		
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);
		
		$IPCam = $data['iPCam'];
		list($w, $x, $y, $z) = explode('.', $IPCam);
		$parkingNo= array_search($z,$a);
		$gate = array_search($z, $a);
		if($parkingNo == "G4")
			$slot_id=5;
		else 
			$slot_id=1;


		$vehicleNo = $data['vehicleNo'];
		//$pictureName= $data['pictureName'];
		//$picture = $data['picture'];
			
		$cdate=date("Y-m-d", strtotime('now'));
		$image_name = $data['pictureName'];	
		$image_data = base64_decode($data['picture']);
		$image_path ="asset/images/".$cdate."/".$data['parkingNo']."/";

		$anprdata = array(
			'GateId' => $parkingNo,
			'AccessType' => 'Plate',  
			'parking_code' => $vehicleNo,
			'vechile_cat_id' => '2',
			'rate_id' => 1,
			'slot_id' => $data['parkingNo'],
			'pictureName' => $data['pictureName'],
			'picturePath' => $image_path,    
			'in_time' => strtotime('now'),
			'out_time' => '',
			'paid_time' => '',
			'total_time' => '',
			'earned_amount' => '',
			'paid_status' => 0			
		);	
		
		$create = $this->model_parking->create($anprdata);
		$num_slot=$this->model_parking->DiscountSlot($parkingNo);
		// echo ($image_path.$image_name);
		
		if (!is_dir($image_path)){
			mkdir($image_path, 0777, true);
			file_put_contents(($image_path.$image_name), $image_data);
			// echo '(1)Image saved as ' . $image_name;
		}
		else {
			file_put_contents(($image_path.$image_name), $image_data);
		// 	echo '(2)Image saved as ' . $image_name;
		}		
		/*
		if($create == true) {			
			echo ('accepted');			
		}
		else {			
			echo ('rejected');
			return;
		}
		*/		
	}
	public function testDiscount(){
		$gate = $this->input->get('gate');
		echo $gate; 
		$result = $this->model_parking->DiscountSlot($gate);
		return $result;
	}
	public function anpr_Out()
	{

		$a=array("G2"=>"145","G2"=>"147","G3"=>"152","G4"=>"157");
		
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);		
		$code = $data['vehicleNo'];
		$codetype = 'Plate'; 	
		$IPCam = $data['iPCam'];
		list($w, $x, $y, $z) = explode('.', $IPCam);
		$gate= array_search($z,$a);

		$parkingvalid=$this->model_parking->checkexit($codetype,$code);
		
		if($parkingvalid==0){
			echo ('rejected');			
			/* we will record data */
		}
		else{
			date_default_timezone_set("Asia/Manila");	
			if($parkingvalid['paid_status'] ==1) {
				$paid_time = $parkingvalid['paid_time'];
				$out_time 	= strtotime('now');
				$diff_time = $out_time - $paid_time;
				$data = array(
					'GateEx' => $gate,
					'out_time' => strtotime('now')
				);			
				$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
				echo ('accepted');	
				$num_slot=$this->model_parking->AddSlot($gate);								 		
			}
			else{    // not paid
				$check_in_time = $parkingvalid['in_time'];						
				$checkout_time = strtotime('now');				
				$total_min = ceil((abs($checkout_time - $check_in_time) / 60) );	
				if($total_min < 1500){   // 15 minutes free
					$data = array(
						'GateEx' => $gate,
						'paid_status' => 1,
						'total_time' => $total_min, 
						'out_time' => $checkout_time
					);			
					$update_parking_data = $this->model_parking->edit($data, $parkingvalid['id']);
					echo ('accepted');	
					$num_slot=$this->model_parking->AddSlot($gate);																	
				}
				else{
					echo ('rejected');										
				}
			}	
		}				
				
	}
	public function Api_test()
	{
		$ip = "10.0.0.144";
		list($w, $x, $y, $z) = explode('.', $ip);
		echo($z);
	}
}
