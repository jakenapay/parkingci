<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PTU extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		//$this->not_logged_in();

		$this->data['page_title'] = 'Ptues';
		$this->load->model('model_ptu');
		$this->load->model('model_slots');
		$this->load->model('model_company');
	}

	public function index()
	{
/*
		if(!in_array('viewPtu', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
*/
		//$ptu_data = $this->model_ptu->getPtuData();
		//$this->data['ptu_data'] = $ptu_data;
		// $this->render_template('ptu/index', $this->data);
		echo (" login sucess");
	}

	public function create()
	{
		/*
		if(!in_array('createRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		*/
		
		$this->form_validation->set_rules('ptu_name', 'PTU Name', 'required');
		$this->form_validation->set_rules('vendor', 'Vendor', 'required');
		$this->form_validation->set_rules('accredition_no', 'accredition_no', 'required');
		$this->form_validation->set_rules('accredition_date', 'accredition_date', 'required');
		$this->form_validation->set_rules('accredition_valid', 'accredition_valid', 'required');
		$this->form_validation->set_rules('BIR_SN', 'BIR Serial No', 'required');
		$this->form_validation->set_rules('ptu_date', 'PTU release date', 'required');


        if ($this->form_validation->run() == TRUE) {
            //  `name`, `vendor`, `accredition`, `accredit_date`, `valid_date`, `BIR_SN`, `issued_date`
        	$data = array(
        		'name' => $this->input->post('ptu_name'),
        		'vendor' => $this->input->post('vendor'),
        		'accredition' => $this->input->post('accredition_no'),
        		'accredit_date' => $this->input->post('accredition_date'),
        		'valid_date' => $this->input->post('accredition_valid'),
				'BIR_SN' => $this->input->post('BIR_SN'),
				'issued_date' => $this->input->post('ptu_date')				
        	);

        	$create = $this->model_ptu->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('ptu/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('ptu/create', 'refresh');
        	}
        }
        else {
			$this->data['title']= 'Create PTU';
        	$this->render_template('ptu/create', $this->data);	
        }
		
	}

	public function edit($id = null)
	{
		/*
		if(!in_array('updateRates', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		*/
		if($id) {
			$this->form_validation->set_rules('ptu_name', 'PTU Name', 'required');
			$this->form_validation->set_rules('vendor', 'Vendor', 'required');
			$this->form_validation->set_rules('accredition_no', 'accredition_no', 'required');
			$this->form_validation->set_rules('accredition_date', 'accredition_date', 'required');
			$this->form_validation->set_rules('accredition_valid', 'accredition_valid', 'required');
			$this->form_validation->set_rules('BIR_SN', 'BIR Serial No', 'required');
			$this->form_validation->set_rules('ptu_date', 'PTU release date', 'required');
			

	        if ($this->form_validation->run() == TRUE) {
	            // true case
	        	$data = array(
					'name' => $this->input->post('ptu_name'),
					'vendor' => $this->input->post('vendor'),
					'accredition' => $this->input->post('accredition_no'),
					'accredit_date' => $this->input->post('accredition_date'),
					'valid_date' => $this->input->post('accredition_valid'),
					'BIR_SN' => $this->input->post('BIR_SN'),
					'issued_date' => $this->input->post('ptu_date')				
				);

	        	$update = $this->model_ptu->edit($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Successfully updated');
	        		redirect('ptu/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('ptu/edit/'.$id, 'refresh');
	        	}
	        }
	        else {	            
				$ptu_data = $this->model_ptu->getPtuData($id);				
				$this->data['ptu_data'] = $ptu_data;
				$this->render_template('ptu/edit', $this->data);	
	        }

			
		}
		
	}

	public function delete($id = null)
	{

		if($id) {
			if($this->input->post('confirm')) {
				$delete = $this->model_ptu->delete($id);
				if($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('ptu/', 'refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('ptu/delete/'.$id, 'refresh');
				}	
			}	
			else {
				$this->data['id'] = $id;
				$this->render_template('ptu/delete', $this->data);	
			}
		}
	}

	public function GetCompamyInfo()
	{	
		$company_id = 1;

		$company_data = $this->model_company->getCompanyData($company_id);
		echo  json_encode($company_data);
	}
	public function GetPtuInfo()
	{	
		if (!isset($_GET['code'])){
			$put_id = 1;
		} else {
			$put_id = $_GET['code'];
		}
		$ptu_data = $this->model_ptu->getPtuData($put_id);	
		echo  json_encode($ptu_data);
	}
	public function DeviceInfo()
	{	
	
		$device_ip = $_GET['ip'];
		$device_data = $this->model_ptu->getDeviceData($device_ip);	
		if ($device_data == null) {
			$device_data = array(
				'GateName' => 'G0',
				'direction' => 'Unknown',
				'address' => $device_ip
				);			
		}
		$json = json_encode($device_data);			
		echo  ($json);
	}
	public function DeviceStatus()
	{	
		$device_ip = $_POST['ip'];
		$device_data = $this->model_ptu->getDeviceData($device_ip);	
		$LED = $_POST['LED'];
		$UHF = $_POST['UHF'];
		$PRINTER = $_POST['PRINTER'];
		$json = json_encode($device_data);			
		echo  ($json);
	}
	public function DeviceEvent()
	{	
	
		$data = array(
			'deviceid' => $this->input->get('ip'),
			'devicename' => $this->input->get('name'),
			'log_status' => $this->input->get('log'),
			'address' => $this->input->get('ip'),
			'at_time' => date("Y-m-d", strtotime('now'))
		);		
		$create = $this->model_ptu->Event($data);
		
	}
	public function GetSlotInfo()
	{	

		$slot_data = $this->model_slots->getSlotData();
		$this->data['slot_data'] = $slot_data;
        echo ('G123 slot  : '.$slot_data[0]['occupied'].'/'.$slot_data[0]['num_slot'].'</br>');
		echo ('G4   slot  : '.$slot_data[1]['occupied'].'/'.$slot_data[1]['num_slot'].'</br>');

		$data[0] = array(
			'area' => "G123",
			'available' => $slot_data[0]['vacant'],
			'Capacity' => $slot_data[0]['num_slot']			
		);		
		$data[1] = array(
			'area' => "G4",
			'available' => $slot_data[1]['vacant'],
			'Capacity' => $slot_data[1]['num_slot']			
		);		
		echo json_encode($data);
		
	}

}