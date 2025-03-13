<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mobile extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

	#	$this->not_logged_in();

		$this->data['page_title'] = 'Mobile Cashier';
		$this->load->model('model_parking');
		$this->load->model('model_groups');
		$this->load->model('model_users');
		$this->load->model('model_rates');
		$this->load->model('model_ptu');
		$this->load->model('model_company');
	}


	public function index()
	{
		
		$this->data['payment'] =$this->model_parking->getPaymentData();			
		$or = $this->model_ptu->getOR();			
		$rates_data = $this->model_rates->getRateData();
		$this->load->view('templates/header');
		$this->load->view('cashier/indexmobile', $this->data);		
	}

	public function payment()
	{		
					
		
		if (isset($_POST['anpr']) and $_POST['anpr'] != null){
			$parking_code = $this->input->post('anpr');	
			$data = $this->model_parking->check("Plate", $parking_code);			
			if($data == null){
				$this->session->set_flashdata('errors', 'No data for this number!');				
				redirect('Cashier', 'refresh');				
				return;
			}
		}
		elseif (isset($_POST['QR']) and $_POST['QR'] != null){
			$parking_code = $this->input->post('QR');
			//$arr = preg_split("/[-]/",$parking_code); 			
			$data = $this->model_parking->check("QR", $parking_code);			
			if($data == null){				
				$this->session->set_flashdata('error', 'No QR data for this number!');
				redirect('Cashier', 'refresh');
				return;
			}
			
		}		
		else{			
			$this->session->set_flashdata('error', 'Error occurred!!');
			echo "no data";
			redirect('Cashier', 'refresh');
			return;
		}
		date_default_timezone_set("Asia/Manila");
		$check_in_time = $data['in_time'];			
		$checkout_time = strtotime('now');		
		$total_min = ceil((abs($checkout_time - $check_in_time) / 60) );	
		$totalhour = floor((abs($checkout_time - $check_in_time) / 60) / 60);									
		$min = ((abs($checkout_time - $check_in_time) / 60) % 60);	
	
		$billrate = $this->model_rates->getRateRegular($data['vechile_cat_id']);
		$discount_rate = $this->model_rates->getRateDiscount($data['vechile_cat_id']);

		if ($total_min < 15){
			$bill = 0;
			$vrate ="drop off";			
		}		
		else{
			if($totalhour <10){
				$bill = $billrate['total'];
				$vrate = "regular";
			}
			else{
				$bill = $billrate['total'] + (10 *($totalhour-9)) ;		
				$vrate = "over";
			}
			// echo "bill : ".$bill;
			$vrate = "regular";			
		}
		date_default_timezone_set("Asia/Manila");
		$parking_data = array(
			'id' => $data['id'],
			'accesstype'=> $data['AccessType'],
			'plate' => $data['parking_code'],
			'gate' => $data['GateId'],
			'vclass' =>$data['vechile_cat_id'],
			'entry_time' => date('Y-m-d h:i:s', $data['in_time']),
			'pay_time' => date('Y-m-d h:i:s'),			
			'Ptime' => 	$totalhour." hour    ".$min." min", 	
			'parkingtime' => $totalhour.":".$min, 	
			'bill' => $bill,
			'vrate' => $vrate,
			'payment' => $data['paid_status']			
		);             		
		$this->data['parking_data'] = $parking_data;
		$this->data['parking_time'] = $total_min;
		$this->data['billrate'] = $billrate;
		$this->data['discount_rate'] = $discount_rate;
		$this->load->view('templates/header');
		# echo "</br>".$this->data['parking_time'];
		// print_r($billrate);
		// print_r ($this->data['discount_rate']) ;
		
		$this->load->view('cashier/edit_mobile', $this->data);
	
	}
	public function pmethods()
    {
		$bill=$this->input->post('bill');
		$parking_data = array(
			'id' => $this->input->post('id'),
			'access' => $this->input->post('accesstype'), 
			'plate' => $this->input->post('plate'),
			'gate' => $this->input->post('gate'),
			'entry_time' => $this->input->post('entry_time'),
			'bill' => $bill,
			'vehicle' => $this->input->post('vehicle'),
			'discount' => $this->input->post('d_option'),
			'Ptime' => $this->input->post('Ptime'),
			'pay_time' => $this->input->post('pay_time'),
			'payment' => 1
		);				
		// print_r($parking_data);
		$this->data['parking_data']=$parking_data;
		if($bill >0){
			$this->data['vat'] = number_format($bill-($bill/1.12),2);	
			$this->data['amount'] = number_format(($bill/1.12),2);				
		}		
		else{	
			$this->data['vat'] = 0;
			$this->data['amount'] = number_format(($bill/1.12),2);	
		}
        $this->load->view('templates/header');
		$this->load->view("cashier/paymentmobile", $this->data); 
		/*	
		$PaidStatus='Paid';
		$company_id=1;
		$ptu_id =1;
		if($bill ==0)	{
       		   $this->model_parking->updatePaid($this->data,1);	
			   redirect('Cashier', 'refresh');
		}
		else{			
			$this->model_parking->updatePaid($this->data,1);	
			$this->data['company_info'] = $this->model_company->getCompanyData($company_id);
			$this->data['put_info'] = $this->model_ptu->getPtuData($ptu_id);		
			$this->data['OR'] =  $this->model_ptu->getOR();	
			$this->data['TN'] = "169869";	
			$this->data['Cashier'] = $this->session->userdata('fname')." ".$this->session->userdata('lname');
			$this->load->view('cashier/print_receipt', $this->data);
		}
		*/
    }


}
