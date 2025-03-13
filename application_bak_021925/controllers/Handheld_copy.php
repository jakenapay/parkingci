<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handheld extends CI_Controller
{
    public function __construct(){
        parent::__construct();

        $this->load->model('model_parking');
		$this->load->model('model_rates');
		$this->load->model('model_ptu');
		$this->load->model('model_company');
    }
    public function terminalBillRequest(){
        $access = $this->input->get('access');
        $code = $this->input->get('code');

        $data = $this->model_parking->TerminaCheck($access, $code);

        // echo json_encode($data);

		if($data == null){
			$parking_data = array(
				'status' => 'fail',	
				'message' => 'No data available',
				'bill' =>0										
			);     
			echo json_encode($parking_data);
			return;
		}else {
			date_default_timezone_set("Asia/Manila");
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
				'code' => $data['parking_code'],
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

	public function terminalBillPaid(){
		$bill=$this->input->post('bill');
		$id = $this->input->post('id');    /* parking data id */
		$parking_data = array(
			'id' => $this->input->post('id'),    
			'access' => $this->input->post('access'), 
			'plate' => $this->input->post('code'),
			'gate' => $this->input->post('gate'),
			'entry_time' => $this->input->post('etime'),
			'bill' => $bill,
			'vehicle' => $this->input->post('vehicle'),			
			'Ptime' => $this->input->post('ptime'),
			'pay_time' => $this->input->post('paytime'),
			'paymode' => $this->input->post('paymode'),
			// 'discount' => "regular",
			// 'vrate'=> $this->input->post('vrate'),
			'vrate'=> "regular",
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
		$this->model_parking->updatePaidTerminal($this->data,1);		
		$this->data['OR'] =  $this->model_ptu->getOR();	
		$this->data['Cashier'] = "paystation B";
		$this->data['Status'] = "success";
		echo json_encode($this->data);
		
	}
}