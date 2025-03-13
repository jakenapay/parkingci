<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Handheld extends CI_Controller
{
    public function __construct(){
        parent::__construct();
		ob_start();
        $this->load->model('model_parking');
		$this->load->model('model_rates');
		$this->load->model('model_ptu');
		$this->load->model('model_company');
		$this->load->model("model_handheldapi");
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
				$bill = 0;
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

	public function ewalletHandheldQr(){
		$bill = $this->input->get('amount');

		$url = 'https://api02.apigateway.bdo.com.ph/v1/mpqr/generates';

		$billNumber = rand(100000, 999999);
		$data = array(
            'Amount' => $bill . '00',
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

	public function ewalletconfirmation(){
		date_default_timezone_set("Asia/Manila");
		$refnumber = $this->input->get('refno');
		$amount = $this->input->get('amount');
		// $amount ="1";

		$url = "https://103.95.213.254:49416/switch-card-utility/v1/transactions/" . urlencode($refnumber);
	

		$transactDate = date('Y-m-d');
	
		// echo $transactDate;
		$data = array(
			'ref' => $refnumber,
			'amount' => $amount,
			'transact-date' => $transactDate
		);

		// echo json_encode($data);
		$params = array(
			'trace-number' => $refnumber,
			'terminal-id' => '70021415',
			'amount' => number_format($amount, 2, '.', ''), 
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

	public function payment()
    {
        // $user_id = $this->session->userdata('id');
        // $position = $this->model_users->getUserGroup($user_id);

        // if ($position['id'] == "ptu") {

        //     $code = $this->input->get('code');
        //     $access = $this->input->get('access');

        //     $clientData = $this->model_device->getData($access, $code);

        //     if (empty($clientData)) {
        //         $response = array(
        //             'status' => 'error',
        //             'message' => 'No record found!',
        //             'data' => null
        //         );
        //     } else {
        //         date_default_timezone_set("Asia/Manila");
        //         $checkInTime = $clientData['in_time'];
        //         $checkOutTime = strtotime('now');

        //         $totalMin = ceil((abs($checkOutTime - $checkInTime) / 60));
        //         $totalHour = floor((abs($checkOutTime - $checkInTime) / 60) / 60);
        //         $minute = ((abs($checkOutTime - $checkInTime) / 60) % 60);

        //         $vehicleId = $clientData['vechile_cat_id'];
        //         $regRate = $this->model_rates->getRateRegular($vehicleId);
        //         $discRate = $this->model_rates->getRateDiscount($vehicleId);

        //         if ($totalMin < 15) {
        //             $amount = 0;
        //             $vehicleRate = "Drop off";
        //         } else {
        //             if ($totalHour < 10) {
        //                 $amount = $regRate['total'];
        //                 $vehicleRate = "Regular";
        //             } else {
        //                 $amount = $regRate['total'] + (10 * ($totalHour - 9));
        //                 $vehicleRate = "Over";
        //             }
        //         }

        //         $currentTime = strtotime('now');
        //         $parkingData = array(
        //             'id' => $clientData['id'],
        //             'accessType' => $clientData['AccessType'],
        //             'parkingCode' => $clientData['parking_code'],
        //             'gateEntry' => $clientData['GateId'],
        //             'vehicleClass' => $clientData['vechile_cat_id'],
        //             'entryTime' => $clientData['in_time'],
        //             'paytime' => strtotime('now'),
        //             'parkingTime' => $totalHour . ":" . $totalMin,
        //             'totalParkTime' => $totalHour . " Hour " . $minute . " Min",
        //             'picturePath' => $clientData['picturePath'],
        //             'pictureName' => $clientData['pictureName'],
        //             'amount' => $amount,
        //             'vehicleRate' => $vehicleRate,
        //             'paymentStatus' => $clientData['paid_status']
        //         );


        //         $response = array(
        //             'status' => 'success',
        //             'message' => 'Record found!',
        //             'id' => $clientData['id'],
        //             'accessType' => $clientData['AccessType'],
        //             'parkingCode' => $clientData['parking_code'],
        //             'gateEntry' => $clientData['GateId'],
        //             'vehicleClass' => $clientData['vechile_cat_id'],
        //             'unixEntryTime' => $clientData['in_time'],
        //             'decodeEntryTime'  =>  date('Y-m-d H:i:s A', $clientData['in_time']),
        //             'paytime' =>$currentTime,
        //             'parkingTime' => $totalHour . ":" . $totalMin,
        //             'totalParkTime' => $totalHour . " Hour " . $minute . " Min",
        //             'picturePath' => $clientData['picturePath'],
        //             'pictureName' => $clientData['pictureName'],
        //             'amount' => $amount,
        //             'vehicleRate' => $vehicleRate,
        //             'paymentStatus' => $clientData['paid_status']
        //         );
        //     }

        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode($response));

        // } else {
        //     $response = array(
        //         'status' => 'failed',
        //         'message' => 'You are not authorized to access this resource.',
        //         'data' => null
        //     );

        //     $this->output
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode($response));
        // }
        $code = $this->input->get('code');
        $access = $this->input->get('access');

        $clientData = $this->model_handheldapi->getData($access, $code);

        if (empty($clientData)) {
            $response = array(
            	'status' => 'error',
                'message' => 'No record found!',
                'data' => null
            );
        } else {
            date_default_timezone_set("Asia/Manila");
            $checkInTime = $clientData['in_time'];
            $checkOutTime = strtotime('now');

            $totalMin = ceil((abs($checkOutTime - $checkInTime) / 60));
            $totalHour = floor((abs($checkOutTime - $checkInTime) / 60) / 60);
			$minute = ((abs($checkOutTime - $checkInTime) / 60) % 60);

            $vehicleId = $clientData['vechile_cat_id'];
            $regRate = $this->model_rates->getRateRegular($vehicleId);
			$discRate = $this->model_rates->getRateDiscount($vehicleId);

            if ($totalMin < 15) {
                $amount = 0;
                $vehicleRate = "Drop off";
            } else {
                if ($totalHour < 10) {
                    $amount = $regRate['total'];
                    $vehicleRate = "Regular";
                } else {
                    $amount = $regRate['total'] + (10 * ($totalHour - 9));
                    $vehicleRate = "Over";
                }
            }

            $currentTime = strtotime('now');
            $parkingData = array(
                'id' => $clientData['id'],
                'accessType' => $clientData['AccessType'],
                'parkingCode' => $clientData['parking_code'],
                'gateEntry' => $clientData['GateId'],
                'vehicleClass' => $clientData['vechile_cat_id'],
                'entryTime' => $clientData['in_time'],
                'paytime' => strtotime('now'),
                'parkingTime' => $totalHour . ":" . $totalMin,
                'totalParkTime' => $totalHour . " Hour " . $minute . " Min",
                'picturePath' => $clientData['picturePath'],
                'pictureName' => $clientData['pictureName'],
				'amount' => $amount,
                'vehicleRate' => $vehicleRate,
                'paymentStatus' => $clientData['paid_status']
            );

                // $response = array(
                //     'status'  => 'success',
                //     'message' => 'Record found!',
                //     'data'    => $parkingData
                // );
            $response = array(
                'status' => 'success',
                'message' => 'Record found!',
                'id' => $clientData['id'],
                'accessType' => $clientData['AccessType'],
                'parkingCode' => $clientData['parking_code'],
                'gateEntry' => $clientData['GateId'],
                'vehicleClass' => $clientData['vechile_cat_id'],
                'unixEntryTime' => $clientData['in_time'],
                'decodeEntryTime'  =>  date('Y-m-d H:i:s', $clientData['in_time']),
                'paytime' =>$currentTime,
                'parkingTime' => $totalHour . ":" . $totalMin,
                'totalParkTime' => $totalHour . " Hour " . $minute . " Min",
                'picturePath' => $clientData['picturePath'],
                'pictureName' => $clientData['pictureName'],
                'amount' => $amount,
                'vehicleRate' => $vehicleRate,
                'paymentStatus' => $clientData['paid_status']
            );
        }

    	$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
		}
}