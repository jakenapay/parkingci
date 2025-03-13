<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require_once(dirname(__FILE__) . '/data/rate.php');

class Cashier extends Admin_Controller
{
/**
 * Get All Data from this method.
 *
 * @return Response
*/
	public function __construct()
	{
                ob_start();
		parent::__construct();

		$this->not_logged_in();
		$this->data['page_title'] = 'Cashier';		
		$this->load->model('model_parking');
		$this->load->model('model_groups');
		$this->load->model('model_users');
		$this->load->model('model_rates');
		$this->load->model('model_ptu');
		$this->load->model('model_company');
		$this->load->model('model_complimentary');
		ob_end_clean();
	}


	public function index()
	{
		
		$user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){  
			// $this->data['payment'] =$this->model_parking->getPaymentData();		
			$this->data['transaction']= $this->model_parking->getTransaction($user_id);

			$this->data['no_transaction'] = empty($this->data['transaction']);

			$rates_data = $this->model_rates->getRateData();
			$this->load->view('templates/header');
			$this->render_template('cashier/index', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
		}		
	}
	
	public function transaction()
	{
		
		$user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);	
		// $data=$this->model_parking-> getCashierToday($user_id);	
		if($position['id'] ==5){   // this is cashier 
			$this->data['transaction']= $this->model_parking->getTransactionAll($user_id);
			$this->data['no_transaction'] = empty($this->data['transaction']);

			$rates_data = $this->model_rates->getRateData();
			$this->load->view('templates/header');
			$this->render_template('cashier/transaction', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
		}		
	}

	public function create()
	{

		$this->form_validation->set_rules('rfid', 'rfid name', 'required');
		$this->form_validation->set_rules('plate', 'plate', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$data = array(
				'slot_name' => $this->input->post('slot_name'),
				'active' => $this->input->post('status'),
				'availability_status' => 1
			);

			$create = $this->model_rfid->create($data);
			if ($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
				redirect('RFID/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('RFID/create', 'refresh');
			}
		} else {
			$this->render_template('rfid/create', $this->data);
		}
	}
	///////////////////////////////////////////////////////////////////////////////
	public function billrequest()
	{
				
		// $PICC_rate = $this->config->item('rate');

		$AccessType = $this->input->get('AccessType');
		$parking_code = $this->input->get('parkingcode');
						
		$data = $this->model_parking->Kioskcheck($AccessType, $parking_code);
		if($data == null){
			$parking_data = array(
				'status' => 'fail. no data',	
				'bill' =>0										
			);     
			echo json_encode($parking_data);
			return;
		}	
		else{						
			date_default_timezone_set("Asia/Manila");
			// $date = date('Y-m-d', $v['parking']['in_time']);
			$date = date('Y-m-d');
			$check_in_time = $data['in_time'];			
			$checkout_time = strtotime('now');		
			$total_min = ceil(abs($checkout_time - $check_in_time) / 60);	
			$totalhour = floor((abs($checkout_time - $check_in_time) / 60) / 60);					
			$min = floor((abs($checkout_time - $check_in_time) / 60) % 60);	
			
			
			if ($total_min < 15){
				$bill = 0; // drop off
				$vrate ="drop off";
			}		
			else{			
				$billrate = $this->model_rates->getRateRegular($data['vechile_cat_id']);
				// print_r($billrate);
				if($totalhour <10){
					$bill = $billrate['total'];
				}
				else{
					$bill = $billrate['total'] + (10 *($totalhour-9)) ;		
				}
				// echo "bill : ".$bill;
				$vrate = "regular";
				
			}
			date_default_timezone_set("Asia/Manila");
			$parking_data = array(
				'status' => 'success',
				'id' => $data['id'],
				'accesstype'=> $data['AccessType'],
				'plate' => $data['parking_code'],
				'gate' => $data['GateId'],
				'vclass' =>$data['vechile_cat_id'],
				'entry_time' => date('Y-m-d h:i:s', $data['in_time']),
				'pay_time' => date('Y-m-d h:i:s'),			
				'Ptime' => 	$totalhour.":".$min, 	
				'bill' =>$bill							
			);     
			echo json_encode($parking_data);
			
		}
	}

	public function pendingpayment()
	{
		$data = $this->model_parking->getParkingPending();
		echo json_encode($data);		
	}
	public function paystation()
	{
		$AccessType = $this->input->post('AccessType');
		$parking_code = $this->input->post('parkingcode');		

		$data = $this->model_parking->check($AccessType, $parking_code);
		$id = $data['id'];
		$this->model_parking->updatePayment($id, 1);			
		echo json_encode($data);
	}

	public function lost_ticket()
	{
		$this->load->view('templates/header');
		$this->data['titlel'] = "lost";
		$this->load->view('cashier/lost', $this->data);	
	}
	public function payment()
	{		
					
		// $PICC_rate = $this->config->item('rate');
		if (isset($_GET['anpr']) and $_GET['anpr'] != null){
			$parking_code = $this->input->GET('anpr');	
			$data = $this->model_parking->check("Plate", $parking_code);			
			if($data == null){
				$this->session->set_flashdata('errors', 'No data for this number!');				
				redirect('Cashier', 'refresh');				
				return;
			}
		}
		elseif (isset($_POST['QR']) and $_POST['QR'] != null){
			$parking_code = $this->input->post('QR');
			$arr = preg_split("/[-]/",$parking_code); 			
			$data = $this->model_parking->check("QR", $parking_code);			
			if($data == null){				
				$this->session->set_flashdata('error', 'No QR data for this number!');
				redirect('Cashier', 'refresh');
				return;
			}
			
		}
		elseif (isset($_POST['LOST'])){
			$this->load->view('templates/header');
			$this->data['titlel'] = "lost";
			$this->load->view('cashier/lost', $this->data);	
			return;
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
			'picturepath' => $data['picturePath'],
			'picturename' => $data['pictureName'],
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
		
		$this->load->view('cashier/edit', $this->data);
	
	}
	///////////////////////////////////////////////////////////////////////////////

	public function ewalletqr()
	{

		$bill = $this->input->get('amount');

		$url = 'https://api02.apigateway.bdo.com.ph/v1/mpqr/generates';

		$billNumber = rand(100000, 999999);
		$data = array(
            //'Amount' => $bill . '00',
	    'Amount' => '100',
            'CreditMID' => '9183507987',
            'MerchantID' => '116580001612',
            'TerminalID' => '70021415',
            'MerchantKey' => 'cbfbf2a8e33e2f2aadfa4213910e3ac0',
            'BillNumber' => $billNumber,
            'ReferenceNumber' => $billNumber
        );

		$headers = array(
            'Content-Type: application/json',
            'X-QR-Generator-Code: SP',
            'Authorization: Basic M1B1bW5XNGdxQXlaUTlQVURmd1N3NTB1Z24zUzI2anQ6MkY2OFdTOVNHVlVxUmNCRw=='
        );

		$ch = curl_init();


		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, 'http://103.95.213.254:49418');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_VERBOSE, true);

		$response = curl_exec($ch);
		if ($response === FALSE) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            echo $response;
        }
		curl_close($ch);

	}

	public function ewalletconfirmation()
	{
		$refnumber = $this->input->get('refno');
		$amount = $this->input->get('amount');

		$url = "https://103.95.213.254:49416/switch-card-utility/v1/transactions/" . urlencode($refnumber);
	

		$transactDate = date('Y-m-d');
	
		$data = array(
			'ref' => $refnumber,
			'amount' => $amount,
			'transact-date' => $transactDate
		);

		// echo json_encode($data);
		$params = array(
			'trace-number' => $refnumber,
			'terminal-id' => '70021415',
			//'amount' => number_format($amount, 2, '.', ''), 
			'amount' => '100',
			'transaction-date' => $transactDate,
			'merchant-id' => '9183507987'
		);
	
		$url .= '?' . http_build_query($params);
	
		$headers = array(
			"Content-Type: application/json",
			"Authorization: Basic M1B1bW5XNGdxQXlaUTlQVURmd1N3NTB1Z24zUzI2anQ6MkY2OFdTOVNHVlVxUmNCRw=="
		);
	
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Curl error: ' . curl_error($ch);
		}

		curl_close($ch);

		echo $response;
	}
	

	public function billpaid()
	{
		$bill=$this->input->post('bill');
		$id = $this->input->post('id');    /* parking data id */
		$parking_data = array(
			'id' => $this->input->post('id'),    
			'access' => $this->input->post('accesstype'), 
			'plate' => $this->input->post('plate'),
			'gate' => $this->input->post('gate'),
			'entry_time' => $this->input->post('entry_time'),
			'bill' => $bill,
			'vehicle' => $this->input->post('vehicle'),			
			'Ptime' => $this->input->post('Ptime'),
			'pay_time' => $this->input->post('pay_time'),
			'paymode' => $this->input->post('pay_mode'),
			// 'discount' => "regular",
			'vrate'=> $this->input->post('vrate'),
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
		}
		$PaidStatus='Paid';
		$company_id=1;
		$ptu_id =2;	
		$this->model_parking->updatePaidPayStation($this->data,1);		
		$this->data['OR'] =  $this->model_ptu->getOR();	
		$this->data['Cashier'] = "paystation B";
		$this->data['Status'] = "success";
		echo json_encode($this->data);
		
	}


	public function receipt($id = null)
	{			
		$parking_data = array(
			'id' => $this->input->post('id'),
			'access' => $this->input->post('accesstype'), 
			'plate' => $this->input->post('plate'),
			'gate' => $this->input->post('gate'),
			'entry_time' => $this->input->post('entry_time'),
			'bill' =>$this->input->post('paid_amount'),
			'vehicle' => $this->input->post('vehicle'),
			'discount' => $this->input->post('discount'),
			'Ptime' => $this->input->post('Ptime'),
			'pay_time' => $this->input->post('pay_time'),
			'paymode' => 'cash',
			'payment' => 1
		);				
		//  NEED TO UPDATE DISCOUNT FACTOR
		$company_id = 1;
		$ptu_id=1;
		$this->data['parking_data'] = $parking_data;
		$this->data['company_info'] = $this->model_company->getCompanyData($company_id);
		$this->data['put_info'] = $this->model_ptu->getPtuData($put_id);	
		$this->model_parking->updatePaid($this->data,1);

		$this->load->view('templates/header');
		$this->load->view('cashier/print_receipt', $this->data);
	}
	public function lost_receipt()
	{			

		$selectdiscount = $this->input->post('vehicled');
		if ($selectdiscount == '5')
			$vehicletype ="Truck/BUS";
		else if($selectdiscount =='4' || $selectdiscount =='3')
			$vehicletype ="car";
		else if($selectdiscount =='2' || $selectdiscount =='1')
			$vehicletype ="Motocycle";

			$parking_data = array(			
			'access' => 'Lost Ticket', 
			'plate' => 'Lost Ticket',
			'gate' => 'G-',
			'entry_time' => '-',
			'bill' =>$this->input->post('bill'),
			'vehicle' => $vehicletype,
			'discount' => $this->input->post('discount'),
			'Ptime' => '-',
			'pay_time' => $this->input->post('pay_time'),
			'paymode' => 'cash',
			'payment' => 1
		);		
		// print_r($parking_data);		
		$bill=$this->input->post('bill');		
		if($bill >0){
			$this->data['vat'] = number_format($bill-($bill/1.12),2);	
			$this->data['amount'] = number_format(($bill/1.12),2);	
		}
		else{	
			$this->data['vat'] = 0;
			$this->data['amount'] = 0;
		}
		
		$this->data['parking_data'] = $parking_data;
		$this->load->view('templates/header');

		$PaidStatus='Paid';
		$company_id=1;
		$ptu_id =1;
		if($PaidStatus !='Paid')	{
       		$this->load->view("cashier/paymentmethod", $this->data); 
		}
		else{			
			$this->model_parking->updatePaid($this->data,1);	
			$this->data['company_info'] = $this->model_company->getCompanyData($company_id);
			$this->data['put_info'] = $this->model_ptu->getPtuData($ptu_id);		
			$this->data['OR'] = $this->model_ptu->getOR();	
			$this->data['TN'] = "169869";	
			$this->data['Cashier'] = $this->session->userdata('fname')." ".$this->session->userdata('lname');
			$this->load->view('cashier/print_receipt', $this->data);
		}
	}
	public function edit($id = null)
	{
		if ($id) {
			$this->form_validation->set_rules('rfid', 'rfid name', 'required');
			$this->form_validation->set_rules('plate', 'plate', 'required');

			if ($this->form_validation->run() == TRUE) {				
				$data = array(
					'slot_name' => $this->input->post('slot_name'),
					'active' => $this->input->post('status'),
					'availability_status' => 1
				);
				
				$update = $this->model_rfid->edit($data, $id);
				if ($update == true) {
					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('slots/', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('slots/edit/' . $id, 'refresh');
				}
			} else {
				// false case
				$rfid_data = $this->model_rfid->getrfidData($id);
				$this->data['rfid_data'] = $rfid_data;
				$this->render_template('rfid/edit', $this->data);
			}
		}
	}

	public function delete($id = null)
	{
		if (!in_array('deleteSlots', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			if ($this->input->post('confirm')) {

				// $check = $this->model_groups->existInUserGroup($id);
				// if($check == true) {
				// 	$this->session->set_flashdata('error', 'Group exists in the users');
				//      		redirect('category/', 'refresh');
				// }
				// else {
				$delete = $this->model_slots->delete($id);
				if ($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('slots/', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('slots/delete/' . $id, 'refresh');
				}
				// }	
			} else {
				$this->data['id'] = $id;
				$this->render_template('slots/delete', $this->data);
			}
		}
	}

	public function pmethods()
    {
		/*
	    if(isset($_POST['paid_amount'])){
			if($_POST['paid_amount']!=0)
	 	  		$bil =$this->input->post('paid_amount');
			else
				$bill=0;		
			echo "bill : ".$bill;	
		}
		else{ 
			$bill =0;	
			echo "no bill";
		}
		*/
		$bill=$this->input->post('bill');
		$pmode =$this->input->post('paysolution');
		// echo $pmode;

		if($pmode == "cash"){
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
				'pay_mode' => $this->input->post('paysolution'),
				'payment' => 1
			);				
			print_r($parking_data);
			$this->data['parking_data']=$parking_data;
			if($bill >0){
				$this->data['vat'] = number_format($bill-($bill/1.12),2);	
				$this->data['amount'] = number_format(($bill/1.12),2);				
			}		
			else	
				$this->data['vat'] = 0;
			
			$this->load->view('templates/header');
			$PaidStatus='Paid';
			$company_id=1;
			$ptu_id =1;
			if($PaidStatus !='Paid')	{
				$this->load->view("cashier/paymentmethod", $this->data); 
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
		}else{
			echo "Please input complimentary ticket!";

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
				'pay_mode' => $this->input->post('paysolution'),
				'payment' => 1
			);				
			$parking_data['amount'] = 0;


			$p_data = $this->session->set_userdata('parking_data', $parking_data);


			// print_r($p_data);

			$user_id = $this->session->userdata('id');
			$position=$this->model_users->getUserGroup($user_id);		
			if($position['id'] ==5){   // this is cashier 
				$this->data['payment'] =$this->model_parking->getPaymentData();			
				$or = $this->model_ptu->getOR();			
				$rates_data = $this->model_rates->getRateData();
				$this->load->view('templates/header');
				$this->render_template('cashier/apply_comp', $this->data);
			}
			else{
				echo(" you are not cashier");
				$this->load->view('login');
				return;
			}		
		}
		
    }

	public function finishpayment(){
		date_default_timezone_set('Asia/Manila');

		$uid = $this->session->userdata('id');
		$pmode = $this->input->post('paysolution');
		$ptime = date('m-d-Y H:i:s A');

		if($pmode == "Cash"){

			$companyId = 1;
			$companyData = $this->model_company->getCompanyInfo($companyId);
			$vcat = "";
			$vclass = $this->input->post('vehicle');


			if($vclass == "Motorcycle"){
				$vcat = "1";
			}else if($vclass == "Car"){
				$vcat = "2";
			}else if($vclass == "BUS/Truck"){
				$vcat = "3";
			}else{
				$vcat = "4";
			}
			$parkingData = array(
				'id'		=>		$this->input->post('id'),
				'companyid'	=>		$companyData['id'],
				'userid'	=>		$uid,
				'ORNO'		=>		$companyData['OR'] + 1,
				'access'	=>		$this->input->post('accesstype'),
				'code'		=>		$this->input->post('code'),
				'gate'		=>		$this->input->post('gate'),
				'etime'		=>		$this->input->post('entry_time'),
				'bill'		=>		$this->input->post('bill'),
				'vehicle'	=>		$vcat,
				'discount'	=>		$this->input->post('d_option'),
				'paymenttime'	=>		$ptime,
				'parktime'	=>		$this->input->post('Ptime'),
				'paymode'	=>		$this->input->post('paysolution')
			);

			$bill = $this->input->post('bill');
			$companyInformation = array (
				'organization'	=>	$companyData['name'],
				'address'		=>	$companyData['address'],
				'telephone'		=>	$companyData['telephone'],
				'tin'			=>	$companyData['TIN'],
				'min'			=>	$companyData['MIN'],

			);

			$this->data['company_info']	= $companyInformation;
			$this->data['parking_data']	= $parkingData;

			if($bill > 0){
				$this->data['vat'] = number_format($bill-($bill/1.12),2);	
				$this->data['amount'] = number_format(($bill/1.12),2);
			}else{	
				$this->data['vat'] = 0;
				$this->data['amount'] = number_format(($bill/1.12),2);	
			}
			// print_r($this->data);
			$updateData	= $this->model_parking->updateParking($this->data);
			$this->render_template('cashier/receipt', $this->data);
		}else{
			// Get Company Info
			$companyId = 1;
			$companyData = $this->model_company->getCompanyInfo($companyId);

			$vcat = "";
			$vclass = $this->input->post('vehicle');


			if($vclass == "Motorcycle"){
				$vcat = "1";
			}else if($vclass == "Car"){
				$vcat = "2";
			}else if($vclass == "BUS/Truck"){
				$vcat = "3";
			}else{
				$vcat = "4";
			}
			$parkingData = array(
				'id'		=>		$this->input->post('id'),
				'companyid'	=>		$companyData['id'],
				'userid'	=>		$uid,
				'ORNO'		=>		$companyData['OR'],
				'access'	=>		$this->input->post('accesstype'),
				'code'		=>		$this->input->post('code'),
				'gate'		=>		$this->input->post('gate'),
				'etime'		=>		$this->input->post('entry_time'),
				'bill'		=>		$this->input->post('bill'),
				'vehicle'	=>		$vcat,
				'discount'	=>		$this->input->post('d_option'),
				'paymenttime'	=>	$ptime,
				'parktime'	=>		$this->input->post('Ptime'),
				'paymode'	=>		$this->input->post('paysolution')
			);


			$this->session->set_userdata('parking_data', $parkingData);

			
			$this->render_template	('cashier/apply_comp', $this->data);

		}
	}

	public function complimentaryAvailability(){
		date_default_timezone_set('Asia/Manila');
		$complimentaryCode = $this->input->get('complimentary');

		$checkComplimentary = $this->model_complimentary->getComplimentary($complimentaryCode);
		$ptime = date('m-d-Y H:i:s A');

		$ticketId = $checkComplimentary['id'];
		$status = $checkComplimentary['is_used'];
		$expiryDate = $checkComplimentary['end_date'];
		$currentDate = date('Y-m-d');

		if($checkComplimentary){
			if ($status == "1"){
				echo "Complimentary is used!";
			}else if($currentDate > $expiryDate){
				echo "Ticket is already expired!";
			}else{
				$parkingSession = $this->session->userdata('parking_data');

				$parkingData = array(
					'id'		=>		$parkingSession['id'],
					'ticketid'	=>		$ticketId,
					'companyid'	=>		$parkingSession['companyid'],
					'userid'	=>		$parkingSession['userid'],
					'ORNO'		=>		$parkingSession['ORNO'] + 1,
					'access'	=>		$parkingSession['access'],
					'code'		=>		$parkingSession['code'],
					'gate'		=>		$parkingSession['gate'],
					'etime'		=>		$parkingSession['etime'],
					'bill'		=>		$parkingSession['bill'],
					'vehicle'	=>		$parkingSession['vehicle'],
					'discount'	=>		$parkingSession['discount'],
					'paymenttime'	=>	$parkingSession['paymenttime'],
					'parktime'	=>		$parkingSession['parktime'],
					'paymode'	=>		$parkingSession['paymode']
				);

				$this->data['parking_data'] = $parkingData;
				$parkingUpdate = $this->model_parking->updateParking($this->data);

				if($parkingUpdate === TRUE){
					redirect('Cashier');
				}

			}
		}else{
			echo "Ticket does not exist!";
		}

	}


	public function checkTicket(){

		$qrcodeData = $this->input->get('qrcode');
        
		$complimentaryData = $this->Model_complimentary->getComplimentaryByQRCode($qrcodeData);

		if ($complimentaryData) {
			if ($complimentaryData['is_used']) {
				echo "2";
			} else {
				$park_data = $this->session->userdata('parking_data');
				// $parking_data['bill'] = $park_data['bill'];
				$parking_data = array(
					'id' 			=> 			$park_data['id'],
					'access' 		=> 			$park_data['access'],
					'plate' 		=> 			$park_data['plate'],
					'gate' 			=> 			$park_data['gate'],
					'entry_time' 	=> 			$park_data['entry_time'],
					'bill' 			=> 			$park_data['bill'],
					'vehicle' 		=> 			$park_data['vehicle'],
					'discount' 		=> 			$park_data['discount'],
					'Ptime' 		=> 			$park_data['Ptime'],
					'pay_time' 		=> 			$park_data['pay_time'],
					'entry_time' 	=> 			$park_data['entry_time'],
					'pay_mode' 		=> 			$park_data['pay_mode'],
					'payment' 		=> 			$park_data['payment'],
				);

				print_r($parking_data);
				$this->data['parking_data']=$parking_data;

				$PaidStatus='Paid';
				$company_id=1;
				$ptu_id =1;
				if($PaidStatus !='Paid')	{
					$this->load->view("cashier/paymentmethod", $this->data); 
				}
				else{			
					$this->model_parking->updatePaid($this->data,1);	
					$complimentary_data = $this->Model_complimentary->getComplimentaryByQRCode($qrcodeData);

					if ($complimentary_data) {
						$this->Model_complimentary->markComplimentaryUsed($complimentary_data['id']);
					}

					// $this->printReceiptOnPosPrinter($parking_data);

					redirect('Cashier');
				}
			}
		} else {
			echo "0";
			
		}
	}
	public function verifyComplimentary()
	{
		$qrcodeData = $this->input->get('qrcode');

		$complimentaryData = $this->model_complimentary->getComplimentaryByQRCode($qrcodeData);

		if (!$complimentaryData) {
			echo "0";
		} else {
			$eventStartDate = strtotime($complimentaryData['start_date']);
			$eventEndDate = strtotime($complimentaryData['end_date']);

			$eventEndDateMidnight = strtotime(date('Y-m-d', $eventEndDate) . ' +1 day 00:00:00');

			$currentDate = time();
			$currentDateMidnight = strtotime(date('Y-m-d 00:00:00'));

			date_default_timezone_set('Asia/Manila');

			if ($currentDate >= $eventEndDateMidnight || $currentDate < $currentDateMidnight) {
				echo "1";
			} elseif ($complimentaryData['is_used']) {
				echo "2";
			} elseif ($currentDate < $eventStartDate) {
				echo "4";
			} else {
				echo "3";
				$this->model_complimentary->markComplimentaryUsed($complimentaryData['id']);

			}
		}
	}
	public function account()
	{
		$this->data['cashierID'] = $this->session->userdata('id');
		$this->data['cashierName'] = $this->session->userdata('fname').' '. $this->session->userdata('lname');
		$this->data['email'] = $this->session->userdata('email');
		$this->data['Sbalance'] = $this->session->userdata('start_balance');
		$this->data['at_time'] = date('Y/m/d H:i:s a', $this->session->userdata('at_time'));
		$getdate =  date('Y-m-d ', $this->session->userdata('at_time'));
		
		$data=$this->model_parking-> getCashierToday($this->data['cashierID'], $getdate  );
		$index =0; 
		$sum = 0;
		foreach ($data as $row) {
				// echo strval($index).":"; 
				$index++;				
				$sum = $sum+ $row['earned_amount'];  
				// echo ($row['earned_amount']."</br>");
		}
		// echo "</br> total :".strval($index)."earn : ".strval($sum);  
		$this->data['trasaction'] = $index ;
		$this->data['earn'] = $sum;
		$this->data['Cbalance'] = $sum +$this->data['Sbalance'] ;
		
/*
		$position=$this->model_users->getUserGroup($user_id);		
		$this->data['payment'] =$this->model_parking->getPaymentData();			
		$or = $this->model_ptu->getOR();			
		$rates_data = $this->model_rates->getRateData();
*/
		$this->load->view('templates/header');	
		$this->render_template('cashier/account', $this->data);
		
	}
	public function PlateSearch( )
    {
		$anprRecords = $this->model_parking->getAnprParkingRecords();
		$this->data['anpr_records'] = $anprRecords;		
		$this->load->view('templates/header');
		$this->render_template('cashier/anpr', $this->data);
    }

	public function searchAnprResult(){
		$plate = $this->input->get('anpr');
		$this->data['anpr_records'] = $this->model_parking->getSimilarRecord($plate);
		$this->render_template('cashier/search_result', $this->data);
	}

	public function datechange()
	{
		$userid =10;
		$data=$this->model_parking-> getCashierToday($userid);
		$index =0; 
		$sum = 0;
		foreach ($data as $row) {
				echo strval($index).":"; 
				$index++;				
				$sum = $sum+ $row['earned_amount'];  
				echo ($row['earned_amount']."</br>");
		}
		echo "</br> total :".strval($index)."earn : ".strval($sum);  

		/*
		$sql = "SELECT * FROM cashier_log  WHERE 1";
		$query = $this->db->query($sql);
		$data= $query->result_array();		
		date_default_timezone_set("Asia/Manila");
		foreach ($data as $row) {
			//$date = date("m-d-y h:i:s",$row['paid_time']);
			$source=$row['paid_time'];
			$date = DateTime::createFromFormat('m-d-y h:i:s', $source);
    		$newdate= $date->format('Y-m-d H:i:s'); 
			$update = "UPDATE cashier_log SET paid_time = '" . $newdate . "' WHERE id = " . $row["id"];
			
			echo ($update) ;
			
			if ($this->db->query($update) === TRUE) {
				echo $newdate."</br>";
			} 
			else {
				echo "Error updating record: ";
			}
			
			// $newdate = date("Y/m/d H:i:s",$date);
			// echo $date ."=>". $newdate."</br>";
			// echo "</br>"; 
		}
		*/
	}


}
