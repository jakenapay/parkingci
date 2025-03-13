<?php
defined('BASEPATH') or exit('No direct scripts allowed');

class HandheldApi extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_handheldapi');
        $this->load->model('model_rates');
    }
    public function billing()
    {
        $access = $this->input->get('access');
        $pcode = $this->input->get('code');

        $parkingData = $this->model_handheldapi->getData($access, $pcode);

        if($parkingData === false){
            $response = array(
                'status' => 'error',
                'message' => 'No parking data found.'
            );
        }else{

            date_default_timezone_set("Asia/Manila");

            $vehicleId = $parkingData['vechile_cat_id'];
            $regRate = $this->model_rates->getRateRegular($vehicleId);
			$check_in_time = $parkingData['in_time'];			
			$checkout_time = strtotime('now');		
			$totalMin = ceil(abs($checkout_time - $check_in_time) / 60);	
			$totalHour = floor((abs($checkout_time - $check_in_time) / 60) / 60);					
			$min = floor((abs($checkout_time - $check_in_time) / 60) % 60);	

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

            $parking_data = array(
				'status' => 'success',
				'id' => $parkingData['id'],
				'accesstype'=> $parkingData['AccessType'],
				'code' => $parkingData['parking_code'],
				'gate' => $parkingData['GateId'],
				'vclass' =>$parkingData['vechile_cat_id'],
				'entry_time' => date('Y-m-d h:i:s', $parkingData['in_time']),
				'pay_time' => date('Y-m-d h:i:s'),			
				'Ptime' => 	$totalHour.":".$min, 	
				'bill' =>$amount							
			);  
            $currentTime = strtotime('now');
            $response = array(
                'status' => 'success',
                'message' => 'Parking data found.',
                'parking_id' => $parkingData['id'],
				'id' => $parkingData['id'],
				'accesstype'=> $parkingData['AccessType'],
				'code' => $parkingData['parking_code'],
				'gate' => $parkingData['GateId'],
				'vclass' =>$parkingData['vechile_cat_id'],
                'unixEntryTime' => $parkingData['in_time'],
				'entry_time' => date('Y-m-d h:i:s', $parkingData['in_time']),
				'paymenttime' => $currentTime,
                'paytime' =>    date('Y-m-d H:i:s A', $currentTime),
				'Ptime' => 	$totalHour.":".$min, 	
                'parkingTime' => $totalHour . ":" . $totalMin,
                'vehicleRate' => $vehicleRate,
				'bill' =>$amount,
                'paid_status' => $parkingData['paid_status']
            );
        }
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function processQrphTransactions(){
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

    public function confirmQrTransactions(){
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
    public function processTransaction(){

    }
}