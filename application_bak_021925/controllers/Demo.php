<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
class Demo extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_users');
        $this->load->model('model_demo');
        require_once FCPATH . 'vendor/autoload.php';
    }

    public function index()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $kiosk1_id = 2;
                $kiosk2_id = 3;

                $kioskOneStorage = $this->model_demo->terminalDrawer($kiosk1_id);
                $kioskTwoStorage = $this->model_demo->terminalDrawer($kiosk2_id);

                $cashier_opening = isset($cashDrawer['opening_fund']) ? $cashDrawer['opening_fund'] : '0.00';
                $cashier_remaining = isset($cashDrawer['remaining']) ? $cashDrawer['remaining'] : '0.00';

                $kioskone_opening = isset($kioskOneStorage['opening_fund']) ? $kioskOneStorage['opening_fund'] : '0';
                $kioskone_remaining = isset($kioskOneStorage['remaining']) ? $kioskOneStorage['remaining'] : '0';

                $kiosktwo_opening = isset($kioskTwoStorage['opening_fund']) ? $kioskTwoStorage['opening_fund'] : '0';
                $kiosktwo_remaining = isset($kioskTwoStorage['remaining']) ? $kioskTwoStorage['remaining'] : '0';

                $this->data['cashier_opening'] = $cashier_opening;
                $this->data['cashier_remaining'] = $cashier_remaining;
                $this->data['kioskone_opening'] = $kioskone_opening;
                $this->data['kioskone_remaining'] = $kioskone_remaining;
                $this->data['kiosktwo_opening'] = $kiosktwo_opening;
                $this->data['kiosktwo_remaining'] = $kiosktwo_remaining;

                $this->load->view('templates/header');
                $this->render_template('demo/index', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login'); // Adjust the URL based on your application structure
        }
    }

    public function payments()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {

                $this->load->view('templates/header');
                $this->render_template('demo/payments', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function transactions()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $transactionData = $this->model_demo->getTransactions($user_id);
                $this->data['transactions'] =  $transactionData;
                $this->load->view('templates/header');
                $this->render_template('demo/transactions', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }


    // PAYMENT PROCESSING

    public function clientEntry()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $access = $this->input->post("accessEntry");
                $code = $this->input->post("code");
                $record = $this->model_demo->getRecord($access, $code);

                $checkInTime = $record['in_time'];
                $checkoutTime = strtotime('now');
                $totalMin = ceil((abs($checkoutTime - $checkInTime) / 60));
                $totalHour = floor((abs($checkoutTime - $checkInTime) / 60) / 60);
                $min = ((abs($checkoutTime - $checkInTime) / 60) % 60);

                // $discounts = $this->model_demo->getDiscounts();
                $vehicleId = $record['vechile_cat_id'];
                $rates = $this->model_demo->getRate($vehicleId);

                if ($totalMin < 15) {
                    $amount = 0;
                    $vrate = "Drop off";
                } else {
                    if ($totalHour < 10) {
                        $amount = $rates['amount'];
                        $vrate = "Regular";
                    } else {
                        $amount = $rates['amount'] + (10 * ($totalHour - 9));
                        $vrate = "Over";
                    }
                    $vrate = "Regular";
                }

                if ($totalHour > 1 && $min) {
                    $parkingTime = $totalHour . " Hours    " . $min . " Mins";
                } else {
                    $parkingTime = $totalHour . " Hour    " . $min . " Min";
                }

                $consumeParkingHour = $totalHour . " : " . $totalMin;
                $details = array(
                    'id' => $record['id'],
                    'gate' => $record['GateId'],
                    'access_type' => $record['AccessType'],
                    'parking_code' => $record['parking_code'],
                    'entryTime' => $record['in_time'],
                    'paymentTime' => $checkoutTime,
                    'parkingTime' => $parkingTime,
                    'parkingStay' => $consumeParkingHour,
                    'vehicleClass' => $record['vechile_cat_id'],
                    'parking_status' => $vrate,
                    'parking_amount' => $amount,
                    'pictureName' => $record['pictureName'],
                    'picturePath' => $record['picturePath'],
                );

                // print_r($details);
                $this->data['details'] = $details;
                $this->load->view('templates/header');
                $this->render_template('demo/details', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function modeofpayment()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {

                $details = array(
                    'id' => $this->input->post("parking_id"),
                    'gate' => $this->input->post("gate"),
                    'access_type' => $this->input->post("access_type"),
                    'parking_code' => $this->input->post("parking_code"),
                    'entryTime' => $this->input->post("entryTime"),
                    'paymentTime' => $this->input->post("paymentTime"),
                    'parkingStay' => $this->input->post("parkingStay"),
                    'parkingTime' => $this->input->post("parkingTime"),
                    'vehicleClass' => $this->input->post("vehicleClass"),
                    'parking_status' => $this->input->post("parking_status"),
                    'parking_amount' => $this->input->post("parking_amount"),
                    'pictureName' => $this->input->post("pictureName"),
                    'picturePath' => $this->input->post("picturePath"),
                );

                $discount = $this->input->post("discount");

                if ($discount == "none") {
                    $details['discount'] = $discount;
                    $this->data['details'] = $details;
                    $this->load->view('templates/header');
                    $this->render_template('demo/paymode', $this->data);
                } else {
                    $this->form_validation->set_rules('custname', 'Name', 'required');
                    $this->form_validation->set_rules('custaddress', 'Address', 'required');
                    $this->form_validation->set_rules('custtin', 'TIN', 'required');
                    $this->form_validation->set_rules('custidnumber', 'ID', 'required');
                    if ($this->form_validation->run() == FALSE) {
                        $this->data['details'] = $details;
                        $this->data['validation_errors'] = validation_errors();
                        $this->load->view('templates/header');
                        $this->render_template('demo/details', $this->data);
                    } else {
                        $details['discount'] = $discount;
                        $details['name'] = $this->input->post("custname");
                        $details['address'] = $this->input->post("custaddress");
                        $details['tin'] = $this->input->post("custtin");
                        $details['idnumber'] = $this->input->post("custidnumber");
                        // print_r($details);
                        $this->data['details'] = $details;
                        $this->load->view('templates/header');
                        $this->render_template('demo/paymode', $this->data);
                    }
                }
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function paymodeProcess()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $details = array(
                    'id' => $this->input->post("parking_id"),
                    'gate' => $this->input->post("gate"),
                    'access_type' => $this->input->post("access_type"),
                    'parking_code' => $this->input->post("parking_code"),
                    'parkingStay' => $this->input->post("parkingStay"),
                    'entryTime' => $this->input->post("entryTime"),
                    'paymentTime' => $this->input->post("paymentTime"),
                    'parkingTime' => $this->input->post("parkingTime"),
                    'vehicleClass' => $this->input->post("vehicleClass"),
                    'parking_status' => $this->input->post("parking_status"),
                    'parking_amount' => $this->input->post("parking_amount"),
                    'pictureName' => $this->input->post("pictureName"),
                    'picturePath' => $this->input->post("picturePath"),
                    'discountopt' => $this->input->post("discount"),
                    'name' => $this->input->post("custname"),
                    'address' => $this->input->post("custaddress"),
                    'tin' => $this->input->post("custtin"),
                    'idnumber' => $this->input->post("custidnumber"),
                    'paymode' => $this->input->post("paymentmode"),
                );

                $paymode = $this->input->post("paymentmode");

                
                if ($paymode == "Cash") {
                    $discountType = $this->input->post("discount");
                    $amount = $this->input->post("parking_amount");

                    if($discountType == "none"){
                        $this->data['details'] = $details;
                        $this->render_template("demo/cash_payment", $this->data);
                    }else{
                        $vehicleId = $this->input->post("vehicleClass");
                        $discountCode = $this->input->post('discount');
                        $discounts = $this->model_demo->getDiscounts($discountCode, $vehicleId);

                        $discountPercentage = $discounts['percentage'];

                        $vatRate = 1.12;

                        $nonVatSales = $amount / $vatRate;

                        $discount = $nonVatSales * ($discountPercentage / 100);

                        $roundOffDiscount = $discount;

                        $totalBill = $nonVatSales - $discount;


                        // echo $vatRate;
                        // echo "</br>";
                        // echo number_format((float)($nonVatSales ?? 0), 2);
                        // echo "</br>";
                        // echo number_format((float)($discount ?? 0), 2);
                        // echo "</br>";
                        // echo number_format((float)($totalBill ?? 0), 2);
                        $details['non_vat'] = number_format((float)($nonVatSales ?? 0), 2);
                        $details['discount'] = number_format((float)($totalBill ?? 0), 2);
                        $details['amount_due'] = number_format((float)($totalBill ?? 0), 2);
                        $this->data['details'] = $details;
                        $this->render_template("demo/cash_payment", $this->data);
                    }
                } else if ($paymode == "GCash" || $paymode == "Paymaya") {
                    $amount = $this->input->post("parking_amount");
                    $vehicleId = $this->input->post("vehicleClass");
                    $discountCode = $this->input->post('discount');
                    $discounts = $this->model_demo->getDiscounts($discountCode, $vehicleId);

                    $discountPercentage = $discounts['percentage'];

                    $vatRate = 1.12;

                    $nonVatSales = $amount / $vatRate;

                    $discount = $nonVatSales * ($discountPercentage / 100);

                    $roundOffDiscount = $discount;

                    $totalBill = $nonVatSales - $discount;
                    $details = array(
                        'id' => $this->input->post("parking_id"),
                        'gate' => $this->input->post("gate"),
                        'access_type' => $this->input->post("access_type"),
                        'parking_code' => $this->input->post("parking_code"),
                        'parkingStay' => $this->input->post("parkingStay"),
                        'entryTime' => $this->input->post("entryTime"),
                        'paymentTime' => $this->input->post("paymentTime"),
                        'parkingTime' => $this->input->post("parkingTime"),
                        'vehicleClass' => $this->input->post("vehicleClass"),
                        'parking_status' => $this->input->post("parking_status"),
                        'parking_amount' => $this->input->post("parking_amount"),
                        'pictureName' => $this->input->post("pictureName"),
                        'picturePath' => $this->input->post("picturePath"),
                        'discountopt' => $this->input->post("discount"),
                        'name' => $this->input->post("custname"),
                        'address' => $this->input->post("custaddress"),
                        'tin' => $this->input->post("custtin"),
                        'idnumber' => $this->input->post("custidnumber"),
                        'paymode' => $this->input->post("paymentmode"),
                    );
                    $url = 'https://api02.apigateway.bdo.com.ph/v1/mpqr/generates';
                    $amount = $this->input->get('amount_due');
                    $billNumber = rand(100000, 999999);
                    $data = array(
                        // 'Amount' => $amount . '00',
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
                        // echo $response;
                        $responseData = json_decode($response, true);
                        $codeUrl = isset($responseData['CodeUrl']) ? $responseData['CodeUrl'] : '';
                        $refNumber = isset($responseData['ReferenceNumber']) ? $responseData['ReferenceNumber'] : '';
                        $details['refNumber'] = $billNumber;
                        $details['codeUrl'] = $codeUrl;
                        $details['qrphamount'] = "100";
                        print_r($details);
                    }
                    curl_close($ch);
                    $details['non_vat'] = number_format((float)($nonVatSales ?? 0), 2);
                    $details['discount'] = number_format((float)($totalBill ?? 0), 2);
                    $details['amount_due'] = number_format((float)($totalBill ?? 0), 2);
                    $this->data['details'] = $details;
                    $this->render_template("demo/ewallet_payment", $this->data);
                } else if ($paymode == "Complimentary") {
                    
                    $details = array(
                        'id' => $this->input->post("parking_id"),
                        'gate' => $this->input->post("gate"),
                        'access_type' => $this->input->post("access_type"),
                        'parking_code' => $this->input->post("parking_code"),
                        'parkingStay' => $this->input->post("parkingStay"),
                        'entryTime' => $this->input->post("entryTime"),
                        'paymentTime' => $this->input->post("paymentTime"),
                        'parkingTime' => $this->input->post("parkingTime"),
                        'vehicleClass' => $this->input->post("vehicleClass"),
                        'parking_status' => $this->input->post("parking_status"),
                        'parking_amount' => $this->input->post("parking_amount"),
                        'pictureName' => $this->input->post("pictureName"),
                        'picturePath' => $this->input->post("picturePath"),
                        'discountopt' => $this->input->post("discount"),
                        'name' => $this->input->post("custname"),
                        'address' => $this->input->post("custaddress"),
                        'tin' => $this->input->post("custtin"),
                        'idnumber' => $this->input->post("custidnumber"),
                        'paymode' => $this->input->post("paymentmode"),
                    );

                    $amount = $this->input->post("parking_amount");
                    $vehicleId = $this->input->post("vehicleClass");
                    $discountCode = $this->input->post('discount');
                    $discounts = $this->model_demo->getDiscounts($discountCode, $vehicleId);

                    $discountPercentage = $discounts['percentage'];

                    $vatRate = 1.12;

                    $nonVatSales = $amount / $vatRate;

                    $discount = $nonVatSales * ($discountPercentage / 100);

                    $roundOffDiscount = $discount;

                    $totalBill = $nonVatSales - $discount;
                    $details['non_vat'] = number_format((float)($nonVatSales ?? 0), 2);
                    $details['discount'] = number_format((float)($totalBill ?? 0), 2);
                    $details['amount_due'] = number_format((float)($totalBill ?? 0), 2);
                    $this->data['details'] = $details;
                    $this->render_template("demo/voucher_payment", $this->data);
                } else {
                    echo "Please select mode transaction";
                    // $this->session->set_flashdata('error', 'Please select payment mode transaction.');
                }

            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function transactPayment()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $details = array(
                    'id' => $this->input->post("parking_id"),
                    'gate' => $this->input->post("gate"),
                    'access_type' => $this->input->post("access_type"),
                    'parking_code' => $this->input->post("parking_code"),
                    'entryTime' => $this->input->post("entryTime"),
                    'paymentTime' => $this->input->post("paymentTime"),
                    'parkingTime' => $this->input->post("parkingTime"),
                    'vehicleClass' => $this->input->post("vehicleClass"),
                    'parking_status' => $this->input->post("parking_status"),
                    'parking_amount' => $this->input->post("parking_amount"),
                    'pictureName' => $this->input->post("pictureName"),
                    'picturePath' => $this->input->post("picturePath"),
                    'discountopt' => $this->input->post("discountopt"),
                    'name' => $this->input->post("custname"),
                    'address' => $this->input->post("custaddress"),
                    'tin' => $this->input->post("custtin"),
                    'idnumber' => $this->input->post("custidnumber"),
                    'paymode' => $this->input->post("paymode"),
                    'discounted' => $this->input->post("discounted"),
                    'discounted_amount' => $this->input->post("discounted_amount"),
                );


                $paymode = $this->input->post("paymode");

                if($paymode == "Cash"){
                    $cashReceived = $this->input->post("cash_received");
                    $changeAmount = $this->input->post("change_amount");
    
                    $remaining = $cashDrawer['remaining'];
    
                    if ($changeAmount > $remaining) {
                        $this->session->set_flashdata('failed', 'Sorry, remaining balance is not enough.');
                        $this->data['details'] = $details;
                        $this->render_template("demo/cash_payment", $this->data);
                    } else if($changeAmount == 0){
                        echo "Exact Amount!";
                    } else {
    
                        $remainingBalance = $remaining - $changeAmount;
    
                        $remainingData = array (
                            'terminal_id' => $terminalId,
                            'id' => $cashDrawer['id'],
                            'remaining' => $remainingBalance
                        );

    
                        // $this->data['receipt'] = $receipt;
                        // $this->render_template('demo/receipt', $this->data);
                        $drawerUpdate = $this->model_demo->updateDrawer($remainingData);
                        if($drawerUpdate === true){
                            
                            $companyId = 1;
                            $ptuId = 3;
                            $companyData = $this->model_demo->getOrganization($companyId);
                            $ptuData = $this->model_demo->getPtu($ptuId);
    
                            
                            $company = array(
                                'company' => $companyData['name'],
                                'address' => $companyData['address'],
                                'telephone' => $companyData['telephone'],
                                'tin' => $companyData['TIN'],
                                'min' => $companyData['MIN']
                            );
                            $ptu = array(
                                'name' => $ptuData['name'],
                                'vendor' => $ptuData['vendor'],
                                'accreditation' => $ptuData['accredition'],
                                'accreditDate' => $ptuData['accredit_date'],
                                'validDate' => $ptuData['valid_date'],
                                'serialNo' => $ptuData['BIR_SN'],
                                'issuedDate' => $ptuData['issued_date'],
                            );
                            $OR = sprintf('%06d', $companyData['OR'] + 1);

                            $parking = array(
                                'id' => $this->input->post('parking_id'),
                                'paid_time' => $this->input->post('paymentTime'),
                                'total_time' => $this->input->post('parkingStay'),
                                'earned_amount' => $this->input->post('amount_due'),
                                'paid_status' => 1,
                            );

                            $transactions = array(
                                'pid' => $terminalId,
                                'cashier_id' => $user_id,
                                'ornumber' => $OR,
                                'gate_en' => $this->input->post("gate"),
                                'access_type' => $this->input->post("access_type"),
                                'parking_code' => $this->input->post("parking_code"),
                                'vehicle_cat_id' => $this->input->post("vehicleClass"),
                                'rate_id' => $this->input->post("parking_status"),
                                'in_time' => $this->input->post("entryTime"),
                                'paid_time' => $this->input->post("paymentTime"),
                                'total_time' => $this->input->post("parkingStay"),
                                'amount' => $this->input->post("parking_amount"),
                                'cash_received' => $this->input->post("cash_received"),
                                'earned_amount' => $this->input->post("amount_due"),
                                'change' => $this->input->post("change_amount"),
                                'discount' => $this->input->post("discounted"),
                                'discount_type' => $this->input->post("discountopt"),
                                'vat' => 0,
                                'vat_exempt' => $this->input->post("nonvat"),
                                'vatable_sales' => 0,
                                'paymode' => $this->input->post("paymode"),
                                'status' => 1
                            );

                            $postTransaction = $this->model_demo->createTransaction($transactions);

                            $receipt = array(
                                'salesInvoice' => $OR,
                                'accessType' => $this->input->post("access_type"),
                                'parkingCode' => $this->input->post("parking_code"),
                                'vehicleClass' => $this->input->post("vehicleClass"),
                                'entryTime' => $this->input->post("entryTime"),
                                'billingTime' => $this->input->post("paymentTime"),
                                'parkingStay' => $this->input->post("parkingStay"),
                                'totalSales' => $this->input->post("earned_amount"),
                                'vatAmount' => $transactions['vat'],
                                'totalAmountDue' => $this->input->post("amount_due"),
                                'vatableSales' => $transactions['vatable_sales'],
                                'nonvatSales' => $this->input->post("amount_due"),
                                'vatExempt' => $this->input->post("nonvat"),
                                'discount' => $this->input->post("discounted"),
                                'paymode' => $this->input->post("paymode")
                            );

                            $parkingUpdate = $this->model_demo->updateParking($parking);
                            // print_r($parking);
                            $this->data['receipt'] = $receipt;
                            $this->render_template("demo/invoice", $this->data);
                        }else{
                            $this->session->set_flashdata('failed', 'Failed to update drawer');
                            $this->data['details'] = $details;
                            $this->render_template("demo/cash_payment", $this->data);
                        }
                    }

                    
                }else if($paymode == "GCash" || $paymode == "Paymaya"){
                    $refnumber = $this->input->get('qrphref');
                    $amount = $this->input->get('qrphamount');

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
                }else{
                    $compCode = $this->input->post("compcode");

                    $verifyCode = $this->model_demo->getComplimentary($compCode);

                    $startDate = $verifyCode['start_date'];
                    $endDate = $verifyCode['end_date'];
                    $isUsed = $verifyCode['is_used'];
                    
                    $currentDate = date('Y-m-d');

                    // Check conditions
                    if ($isUsed == 1) {
                        echo "This code has already been used.";
                    } elseif ($currentDate < $startDate || $currentDate > $endDate) {
                        echo "This code is not valid yet.";
                    } elseif ($currentDate >= $startDate && $currentDate <= $endDate && $isUsed == 0) {
                        $compData = array(
                            'id' => $verifyCode['id'],
                            'is_used' => 1
                        );

                        $complimentaryUp = $this->model_demo->updateComplimentary($compData);

                        if($complimentaryUp === true){
                            $parking = array(
                                'id' => $this->input->post('parking_id'),
                                'paid_time' => $this->input->post('paymentTime'),
                                'total_time' => $this->input->post('parkingStay'),
                                'earned_amount' => $this->input->post('amount_due'),
                                'paid_status' => 1,
                            );

                            $transactions = array(
                                'pid' => $terminalId,
                                'cashier_id' => $user_id,
                                'ornumber' => 000000,
                                'gate_en' => $this->input->post("gate"),
                                'access_type' => $this->input->post("access_type"),
                                'parking_code' => $this->input->post("parking_code"),
                                'vehicle_cat_id' => $this->input->post("vehicleClass"),
                                'rate_id' => $this->input->post("parking_status"),
                                'in_time' => $this->input->post("entryTime"),
                                'paid_time' => $this->input->post("paymentTime"),
                                'total_time' => $this->input->post("parkingStay"),
                                'amount' => $this->input->post("parking_amount"),
                                'cash_received' => 0,
                                'earned_amount' => 0,
                                'change' => 0,
                                'discount' => 0,
                                'discount_type' => 'Free',
                                'vat' => 0,
                                'vat_exempt' => 0,
                                'vatable_sales' => 0,
                                'paymode' => $this->input->post("paymode"),
                                'status' => 1
                            );

                            $postTransaction = $this->model_demo->createTransaction($transactions);
                            $parkingUpdate = $this->model_demo->updateParking($parking);
                            // print_r($parking);
                            $receipt = array(
                                'accessType' => $this->input->post("access_type"),
                                'parkingCode' => $this->input->post("parking_code"),
                                'vehicleClass' => $this->input->post("vehicleClass"),
                                'entryTime' => $this->input->post("entryTime"),
                                'billingTime' => $this->input->post("paymentTime"),
                                'parkingStay' => $this->input->post("parkingStay"),
                                'totalSales' => $this->input->post("earned_amount"),
                                'vatAmount' => $transactions['vat'],
                                'totalAmountDue' => $this->input->post("amount_due"),
                                'vatableSales' => $transactions['vatable_sales'],
                                'nonvatSales' => $this->input->post("amount_due"),
                                'vatExempt' => $this->input->post("nonvat"),
                                'discount' => $this->input->post("discounted"),
                                'paymode' => $this->input->post("paymode")
                            );
                            $this->data['receipt'] = $receipt;
                        }
                        
                        $this->data['receipt'] = $receipt;
                        $this->render_template("demo/comppass", $this->data);

                    } else {
                        echo "This code is invalid.";
                    }
                    // try {
                    //     $connector = new WindowsPrintConnector("POS-80-Series");
                    //     $printer = new Printer($connector);

                    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
                    //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                    //     $printer->text("PICC\n");
                    //     $printer->selectPrintMode();

                    //     function formatLine($left, $right)
                    //     {
                    //         $maxLength = 48;
                    //         $leftLength = strlen($left);
                    //         $rightLength = strlen($right);
                    //         $spaces = $maxLength - $leftLength - $rightLength;
                    //         return $left . str_repeat(' ', $spaces) . $right . "\n";
                    //     }

                    //     $printer->text("Philippine International Convention Center\n");
                    //     $printer->text("PICC, Complex 1307 Pasay City, Metro Manila, Philippines\n");
                    //     $printer->text("VAT REG TIN: 000-000-000-00000\n");
                    //     $printer->text("MIN: 1234567891\n");
                    //     $printer->text("(+63)936994578\n");
                    //     $printer->feed();
                    //     $printer->text(str_repeat("-", 48) . "\n");
                    //     $printer->text("Date and Time: 07-22-2024 08:54:53 AM\n");
                    //     $printer->text("Plate Number: ABC123\nVehicle: Car\n");
                    //     $printer->feed();
                    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
                    //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    //     $printer->text("Complimentary Gate Pass\n");
                    //     $printer->text("BIR PTU NO: AB1234567-12345678\n");
                    //     $printer->text("PTU DATE ISSUED: 11/24/2020\n");
                    //     $printer->text("THIS SERVES AS AN OFFICIAL RECEIPT\n");
                    //     $printer->feed(2);
                    //     $printer->cut();

                    //     $printer->close();

                    //     echo "Printed successfully.";
                    // } catch (Exception $e) {
                    //     echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
                    // } 
                }
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    // END OF PAYMENT PROCESSING

    // public function transactions()
    // {
    //     $user_id = $this->session->userdata('id');
    //     $position = $this->model_users->getUserGroup($user_id);

    //     if ($position['id'] == 5) {
    //         $transactionData = $this->model_touchpoint->getTransactions($user_id);
    //         $this->data['transactions'] =  $transactionData;
    //         $this->load->view('templates/header');
    //         $this->render_template('demo/transactions', $this->data);
    //     }else{
    //         echo ("You are not a cashier");
    //         $this->load->view('login');
    //         return;
    //     }
    // }
    // EWALLET

    // END OF EWALLET

    // GENERATING REPORTS
    // END OF GENERATING REPORTS
}