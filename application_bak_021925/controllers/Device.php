<?php
defined('BASEPATH') or exit('No direct scripts allowed');

class Device extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('model_users');
        $this->load->model('model_device');
        $this->load->model('model_company');
        $this->load->model('model_rates');
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

            $clientData = $this->model_device->getData($access, $code);

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

            // Set the content type to JSON and output the response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
    }

    public function checkDrawer()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        $terminalId = $this->input->get('terminalid');

        $checkDrawer = $this->model_device->getStorage($terminalId);

        $response = array (
            'status'    =>  'success',
            'message'   =>  'Drawer balance.',
            'drawer_id' =>  $checkDrawer['id'],
            'terminal_id'   =>$checkDrawer['terminal_id'],
            'cashier_id'   =>$checkDrawer['cashier_id'],
            'balance'   =>$checkDrawer['opening_fund'],
            'remaining'   =>$checkDrawer['remaining'],
        );
        $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }

    public function drawerUpdate()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        $terminalId = $this->input->get('terminalid');
        $remaining = $this->input->get('remaining');

        $cashDrawer = array (
            'terminal_id'   =>  $terminalId,
            'remaining'     =>  $remaining
        );

        $changeStroage = $this->model_device->updateStorage($cashDrawer);

        if($changeStroage === true)
        {
            $response = array (
                'status'    =>  'approved',
                'message'   =>  'Coin storage updated.'
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            
        }
    }

    public function doTransaction()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        $companyId = 1;
        $companyData = $this->model_device->getCompany($companyId);
        $ptuId = 2;
        $ptuData = $this->model_device->getPtu($ptuId);

        $amount = $this->input->get('amount');

        if ($amount > 0) {
            $vatAmount = number_format($amount - ($amount / 1.12), 2);
            $vatableSales = number_format(($amount / 1.12), 2);
        } else {
            $vatAmount = 0;
            $vatableSales = 0;
        }

        $company = array(
            'company' => $companyData['name'],
            'address' => $companyData['address'],
            'telephone' => $companyData['telephone'],
            'tin' => $companyData['TIN'],
            'min' => $companyData['MIN']
        );
        $ptu = array (
            'name'  =>  $ptuData['name'],
            'vendor'    =>  $ptuData['vendor'],
            'accreditation' =>  $ptuData['accredition'],
            'accreditDate'  =>  $ptuData['accredit_date'],
            'validDate'     =>  $ptuData['valid_date'],
            'serialNo'      =>  $ptuData['BIR_SN'],
            'issuedDate'    =>  $ptuData['issued_date'],   
        );
        $OR = sprintf('%06d', $companyData['OR'] + 1);


        $vatRate = 1.12;
		$vatableSale = $amount / $vatRate;
		$vatExempt = 0;
		$totalVat = $amount - $vatableSale;
		$totalAmountDue = $amount;
		$discount = 0;
		$nonVat = 0;
		$changeAmount = 0;

        $transaction = array(
            'pid'           =>  $this->input->get('terminalid'),
            'cashier_id'    =>  12,
            'ornumber'      =>  $OR,
            'gate_en'       =>   $this->input->get('gate'),
            'access_type'   =>  $this->input->get('access'),
            'parking_code'  =>  $this->input->get('code'),
            'vehicle_cat_id'    =>  $this->input->get('vclass'),
            'rate_id'          =>  $this->input->get('vehicle_rate'),
            'in_time'    =>  $this->input->get('etime'),
            'paid_time'       =>  $this->input->get('paytime'),
            'total_time'    =>  $this->input->get('totaltime'),
            'amount'        =>  $this->input->get('amount'),
            'earned_amount' => $vatableSale,
            'cash_received' => $this->input->get("cashReceived"),
            'change' => $this->input->get("changeAmount"),
            'discount_type'      =>  "none",
            'discount'      =>  $discount,
            'paymode'       =>  $this->input->get('paymode'),
            'vat'           =>  $totalVat,
            'transact_status' => 1,
            'vatable_sales'  =>  $vatableSales,
            'zero_rated' => 0,
            'vat_exempt' => $vatExempt,
            'non_vat' => $nonVat,
            'status'        =>   1
        );

        $parking = array(
            'id'    =>  $this->input->get('id'),
            'paid_time'       =>  $this->input->get('paytime'),
            'total_time'    =>  $this->input->get('totaltime'),
            'amount'        =>  $this->input->get('amount'),
            'total_time'        =>  $this->input->get('totaltime'),
            'paid_status'        => 1,
        );
        $createTransaction = $this->model_device->postTransaction($transaction);

        if($createTransaction === true)
        {
            $companyOr = array(
                'id' => $companyData['id'],
                'OR' => $OR
            );
            $this->model_device->updateCompanyOr($companyOr);
            $this->model_device->updateParking($parking);
            $response = array(
                'status'    =>  'Approved',
                'message'   =>  'Payment success',

                'ornumber'      =>  $OR,
                'company' => $companyData['name'],
                'address' => $companyData['address'],
                'telephone' => $companyData['telephone'],
                'tin' => $companyData['TIN'],
                'min' => $companyData['MIN'],
    
                'name'  =>  $ptuData['name'],
                'vendor'    =>  $ptuData['vendor'],
                'accreditation' =>  $ptuData['accredition'],
                'accreditDate'  =>  $ptuData['accredit_date'],
                'validDate'     =>  $ptuData['valid_date'],
                'serialNo'      =>  $ptuData['BIR_SN'],
                'issuedDate'    =>  $ptuData['issued_date'],   


                'in_time'           =>  $this->input->get('etime'),
                'bill_time'         =>  $this->input->get('paytime'),
                'parking_time'      =>  $this->input->get('totaltime'),
                'amount_due'        =>  $vatableSales,
                'vat'               =>  $vatAmount,
                'amount'            =>  $this->input->get('amount'),
                'vatable_sale'      =>  $vatableSales,
                'vat_exampt'        =>  0,
                'discount'          =>  0,
                'paymode'           =>  $this->input->get('paymode')
    
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));

        }
        else
        {
            $response = array(
                'status'    =>  'failed',
                'message'   =>  'Payment failed',

                
    
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
        }

       

    }

    public function analysisResult()
    {
        $date = date('Y-m-d');
        $cashierId = $this->input->get('cashier_id');
        $terminal_id = $this->input->get('terminal_id');
        $summary = $this->model_device->summarizedData($date, $cashierId, $terminal_id);
    
        echo json_encode($summary, JSON_PRETTY_PRINT);
    }
    
}