<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class Touchpoint extends Admin_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("model_users");
        $this->load->model("model_touchpoint");
        $this->load->model('model_company');
        $this->load->model('model_ptu');
        require_once FCPATH . 'vendor/autoload.php';
    }

    public function index(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $kiosk1_id = 2;
                $kiosk2_id = 3;

                $kioskOneStorage = $this->model_touchpoint->terminalDrawer($kiosk1_id);
                $kioskTwoStorage = $this->model_touchpoint->terminalDrawer($kiosk2_id);

                $cashier_opening = isset($cashDrawer['opening_fund']) ? $cashDrawer['opening_fund'] : '0.00';
                $cashier_remaining = isset($cashDrawer['remaining']) ? $cashDrawer['remaining'] : '0.00';

                $kioskone_opening = isset($kioskOneStorage['opening_fund']) ? $kioskOneStorage['opening_fund'] : '0';
                $kioskone_remaining = isset($kioskOneStorage['remaining']) ? $kioskOneStorage['remaining'] : '0';

                $kiosktwo_opening = isset($kioskTwoStorage['opening_fund']) ? $kioskTwoStorage['opening_fund'] : '0';
                $kiosktwo_remaining = isset($kioskTwoStorage['remaining']) ? $kioskTwoStorage['remaining'] : '0';

                $recentTransaction = $this->model_touchpoint->getRecentTransactions($user_id);

                $this->data['cashier_opening'] = $cashier_opening;
                $this->data['cashier_remaining'] = $cashier_remaining;
                $this->data['kioskone_opening'] = $kioskone_opening;
                $this->data['kioskone_remaining'] = $kioskone_remaining;
                $this->data['kiosktwo_opening'] = $kiosktwo_opening;
                $this->data['kiosktwo_remaining'] = $kiosktwo_remaining;
                $this->data['recentTransaction'] = $recentTransaction;

                $this->load->view('templates/header');
                $this->render_template('pos/index', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function setBalance()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {

            $terminalId = 1;

            $amount = $this->input->post('amount');

            if (empty($amount)) {
                $this->session->set_flashdata('error', 'Opening fund required.');
                $this->load->view('balance');
            } else {
                $drawerData = array(
                    'terminal_id' => $terminalId,
                    'cashier_id' => $user_id,
                    'opening_fund' => $amount,
                    'remaining' => $amount,
                    'start_time' => strtotime('now'),
                    'status' => 1
                );
                $setCashDrawer = $this->model_touchpoint->createData($drawerData);

                if ($setCashDrawer) {
                    redirect('touchpoint');
                } else {
                    $this->session->set_flashdata('error', 'Failed to set drawer, Please try again.');
                    $this->load->view('balance');
                }
            }
        } else {
            echo (" you are not cashier");
            $this->load->view('login');
            return;
        }
    }

    public function deviceSetup(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $kiosk1_id = 2;
                $kiosk2_id = 3;

                $kioskOneStorage = $this->model_touchpoint->terminalDrawer($kiosk1_id);
                $kioskTwoStorage = $this->model_touchpoint->terminalDrawer($kiosk2_id);

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
                $this->render_template('pos/index', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    // public function clientEntry()
    // {
    //     $user_id = $this->session->userdata('id');
    //     $position = $this->model_users->getUserGroup($user_id);
    //     if ($position['id'] == 5) {
    //         $terminalId = 1;
    //         $cashDrawer = $this->model_demo->terminalDrawer($terminalId);

    //         if ($cashDrawer) {
    //             $access = $this->input->post("accessEntry");
    //             $code = $this->input->post("code");
    //             $record = $this->model_demo->getRecord($access, $code);

    //             $checkInTime = $record['in_time'];
    //             $checkoutTime = strtotime('now');
    //             $totalMin = ceil((abs($checkoutTime - $checkInTime) / 60));
    //             $totalHour = floor((abs($checkoutTime - $checkInTime) / 60) / 60);
    //             $min = ((abs($checkoutTime - $checkInTime) / 60) % 60);

    //             $vehicleId = $record['vechile_cat_id'];
    //             $rates = $this->model_demo->getRate($vehicleId);

    //             if ($totalMin < 15) {
    //                 $amount = 0;
    //                 $vrate = "Drop off";
    //             } else {
    //                 if ($totalHour < 10) {
    //                     $amount = $rates['amount'];
    //                     $vrate = "Regular";
    //                 } else {
    //                     $amount = $rates['amount'] + (10 * ($totalHour - 9));
    //                     $vrate = "Over";
    //                 }
    //                 $vrate = "Regular";
    //             }

    //             if ($totalHour > 1 && $min) {
    //                 $parkingTime = $totalHour . " Hours    " . $min . " Mins";
    //             } else {
    //                 $parkingTime = $totalHour . " Hour    " . $min . " Min";
    //             }

    //             $consumeParkingHour = $totalHour . " : " . $totalMin;
    //             $details = array(
    //                 'id' => $record['id'],
    //                 'gate' => $record['GateId'],
    //                 'access_type' => $record['AccessType'],
    //                 'parking_code' => $record['parking_code'],
    //                 'entryTime' => $record['in_time'],
    //                 'paymentTime' => $checkoutTime,
    //                 'parkingTime' => $parkingTime,
    //                 'parkingStay' => $consumeParkingHour,
    //                 'vehicleClass' => $record['vechile_cat_id'],
    //                 'parking_status' => $vrate,
    //                 'parking_amount' => $amount,
    //                 'pictureName' => $record['pictureName'],
    //                 'picturePath' => $record['picturePath'],
    //             );

    //             $this->data['details'] = $details;
    //             $this->load->view('templates/header');
    //             $this->render_template('demo/details', $this->data);
    //         } else {
    //             $this->load->view('balance');
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', 'You are not a cashier');
    //         redirect('auth/login');
    //     }
    // }

    public function payments()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {

                $this->load->view('templates/header');
                $this->render_template('pos/payments', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    public function clientEntry(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $access = $this->input->post("accessEntry");
                $code = $this->input->post("code");
                $record = $this->model_touchpoint->getRecord($access, $code);

                $checkInTime = $record['in_time'];
                $checkoutTime = strtotime('now');
                $totalMin = ceil((abs($checkoutTime - $checkInTime) / 60));
                $totalHour = floor((abs($checkoutTime - $checkInTime) / 60) / 60);
                $min = ((abs($checkoutTime - $checkInTime) / 60) % 60);

                $vehicleId = $record['vechile_cat_id'];
                $rates = $this->model_touchpoint->getRate($vehicleId);

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
                $this->render_template('pos/details', $this->data);
            } else {
                $this->load->view('balance');
            }

        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login'); 
        }
    }

    public function applyDiscount(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

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
                    'discountType' => $this->input->post("discount_type")
                );
                $vehicleId = $this->input->post("vehicleClass");
                $originalAmount = $this->input->post("parking_amount");
                $discountType = $this->input->post('discount_type');

                $this->data['details'] = $details;
                $this->render_template('pos/paymode', $this->data);

            } else {
                $this->load->view('balance');
            }

        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login'); // Adjust the URL based on your application structure
        }
    }

    public function transactPayment(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

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
                    'discountType' => $this->input->post("discount_type"),
                    'paymode' => $this->input->post("paymentmode")
                );

                $paymode = $this->input->post("paymentmode");
    
                if ($paymode == "Cash") {
                    $vehicleId = $this->input->post("vehicleClass");
                    $originalAmount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
    
                    $vatExempt = 0;
                    $vatableSale = 0;
                    $nonVatSales = 0;
                    $zeroRatedSales = 0;
                    $totalVat = 0;
                    $amountAfterDiscounted = 0;
                    if ($discountType == "none") {
                            $vatRate = 1.12;
                            $vatPercent = 0.12;
                            $vatableSale = $originalAmount / $vatRate;
                            $totalSales = $vatableSale;
                            $totalVat = ($vatableSale * $vatPercent);
                            $amountDue = $vatableSale + $totalVat;
                            $totalDiscount = ($vatableSale * 0.0);
                            $vatExemption = $originalAmount * $vatExempt;
                            // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                            // echo "Discount: " . $discountType . "</br>";
                            // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                            // echo "Non-vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                            // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                            // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                            // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                            // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                            // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                            // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                    } else {
                        $vatRate = 1.12;
                        $vatPercent = 0.12; 
                        $discountCode = $this->input->post('discount_type');
                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                        $discountPercentage = $discounts['percentage'];

                        $vatableSale = $originalAmount / $vatRate;

                        $totalDiscount = ($vatableSale * $discountPercentage);
                        $nonVatSales = $vatableSale - $totalDiscount;
                        $totalSales = $vatableSale - $totalDiscount;
                        $amountDue = $vatableSale - $totalDiscount;
                        $vatExempt = $vatableSale * $vatPercent;


                        // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                        // echo "Discount: " . $discountType . "</br>";
                        // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                        // echo "Non-Vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                        // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                        // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                        // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                        // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                        // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                        // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                    }
                    $remaining = $cashDrawer['remaining'];

                    $details['amountDue'] = $amountDue;
                    $this->data['details'] = $details;
                    $this->render_template("pos/cash_payment", $this->data);
                }else if($paymode== "GCash" || $paymode == "Paymaya"){
                    $vehicleId = $this->input->post("vehicleClass");
                    $originalAmount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
    
                    $vatExempt = 0;
                        $vatableSale = 0;
                        $nonVatSales = 0;
                        $zeroRatedSales = 0;
                        $totalVat = 0;
                        $amountAfterDiscounted = 0;
                        if ($discountType == "none") {
                                $vatRate = 1.12;
                                $vatPercent = 0.12;
                                $vatableSale = $originalAmount / $vatRate;
                                $totalSales = $vatableSale;
                                $totalVat = ($vatableSale * $vatPercent);
                                $amountDue = $vatableSale + $totalVat;
                                $totalDiscount = ($vatableSale * 0.0);
                                $vatExemption = $originalAmount * $vatExempt;
                        } else {
                            $vatRate = 1.12;
                            $vatPercent = 0.12; 
                            $discountCode = $this->input->post('discount_type');
                            $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                            $discountPercentage = $discounts['percentage'];

                            $vatableSale = $originalAmount / $vatRate;

                            $totalDiscount = ($vatableSale * $discountPercentage);
                            $nonVatSales = $vatableSale - $totalDiscount;
                            $totalSales = $vatableSale - $totalDiscount;
                            $amountDue = $vatableSale - $totalDiscount;
                            $vatExempt = $vatableSale * $vatPercent;

                        }
                    $bill = $this->input->post('amount');

                    $url = 'https://api02.apigateway.bdo.com.ph/v1/mpqr/generates';
            
                    $billNumber = rand(100000, 999999);
                    $data = array(
                        // 'Amount' => $bill . '00',
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
                        $decodedResponse = json_decode($response, true);
                        if (isset($decodedResponse['Status'])) {
                            if ($decodedResponse['Status'] === "Successful") {
                                
                                $codeUrl = $decodedResponse['CodeUrl'];

                                // echo $response;
                                
                            } else {
                               
                                echo "Transaction failed.";
                                echo "Error Code: " . $decodedResponse['Error']['Code'] . "<br>";
                                echo "Error Description: " . $decodedResponse['Error']['Description'] . "<br>";
                            }
                        } else {
                            echo "Invalid response format.";
                        }
                    }
                    curl_close($ch);
                    $details['codeUrl'] = $codeUrl;
                    $details['refnumber'] = $billNumber;
                    $details['amountDue'] = $amountDue;
                    $this->data['details'] = $details;
                    $this->render_template("pos/ewallet_payment", $this->data);
                }else{
                    $details['totalSales'] = 0;
                    $this->data['details'] = $details;
                    $this->render_template("pos/voucher_payment", $this->data);
                }

            } else {
                $this->load->view('balance');
            }

        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function processTransaction(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
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
                    'discountType' => $this->input->post("discount_type"),
                    'paymode' => $this->input->post("paymentmode"),
                    'totalSales' => $this->input->post("total_sales")
                );
                $paymode = $this->input->post("paymentmode");
    
                if ($paymode == "Cash") {
                    $cashReceived = $this->input->post("cash_received");
                    $changeAmount = $this->input->post("change_due");
                    $remaining = $cashDrawer['remaining'];
                    // echo $changeAmount;
                    if ($changeAmount > $remaining) {
                        $this->session->set_flashdata('failed', 'Sorry, remaining balance is not enough.');
                        $this->data['details'] = $details;
                        $this->render_template("demo/cash_payment", $this->data);
                    } else if ($changeAmount == 0) {
                        $companyId = 1;
                        $ptuId = 3;
                        $companyData = $this->model_touchpoint->getOrganization($companyId);
                        $ptuData = $this->model_touchpoint->getPtu($ptuId);
    
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
                            'issuedDate' => $ptuData['issued_date']
                        );
                        $OR = sprintf('%06d', $companyData['OR'] + 1);
                        
                        
                            // Discount and VAT calculations
                        $vehicleId = $this->input->post("vehicleClass");
                        $originalAmount = $this->input->post("parking_amount");
                        $discountType = $this->input->post('discount_type');
    
                        $vatExempt = 0;
                        $vatableSale = 0;
                        $nonVatSales = 0;
                        $zeroRatedSales = 0;
                        $totalVat = 0;
                        $amountAfterDiscounted = 0;
                        if ($discountType == "none") {
                                $vatRate = 1.12;
                                $vatPercent = 0.12;
                                $vatableSale = $originalAmount / $vatRate;
                                $totalSales = $vatableSale;
                                $totalVat = ($vatableSale * $vatPercent);
                                $amountDue = $vatableSale + $totalVat;
                                $totalDiscount = ($vatableSale * 0.0);
                                $vatExemption = $originalAmount * $vatExempt;
                                // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                                // echo "Discount: " . $discountType . "</br>";
                                // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                                // echo "Non-vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                                // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                                // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                                // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                                // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                                // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                                // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                        } else {
                            $vatRate = 1.12;
                            $vatPercent = 0.12; 
                            $discountCode = $this->input->post('discount_type');
                            $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                            $discountPercentage = $discounts['percentage'];
  
                            $vatableSales = $originalAmount / $vatRate;
                            $totalDiscount = ($vatableSale * $discountPercentage);
                            $nonVatSales = $vatableSale - $totalDiscount;
                            $totalSales = $vatableSale - $totalDiscount;
                            $amountDue = $vatableSale - $totalDiscount;
                            $vatExempt = $vatableSale * $vatPercent;
			    

                            // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                            // echo "Discount: " . $discountType . "</br>";
                            // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                            // echo "Non-Vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                            // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                            // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                            // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                            // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                            // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                            // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                        }

                        // Prepare transaction data
                        $transactionsData = array(
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
                            'earned_amount' => $totalSales,
                            'cash_received' => $cashReceived,
                            'change' => $changeAmount,
                            'discount_type' => $this->input->post("discount_type"),
                            'discount' => $totalDiscount,
                            'vat_exempt' => $vatExempt,
                            'vat' => $totalVat,
                            'vatable_sales' => $vatableSale,  // Ensure this is not NULL
                            'zero_rated' => 0,
                            'transact_status' => 1,
                            'non_vat' => $nonVatSales,
                            'paymode' => $paymode,
                            'status' => 1
                        );



                        $parkingData = array(
                            'id' => $this->input->post("parking_id"),
                            'paid_time' => $this->input->post("paymentTime"),
                            'total_time' => $this->input->post("parkingStay"),
                            'earned_amount' => $totalSales,
                            'paid_status' => 1
                        );

                        $this->model_touchpoint->updateParkingData($parkingData);
                        $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);
                        $updateComp = array(
                            'id' => $companyData['id'],
                            'OR' => $OR
                        );

                        $this->model_touchpoint->updateCompany($updateComp);
                        if($postTransaction){
                            $discType = "";
                            if($discountType == 'senior'){
                                $discType = "SC";
                            }else if($discountType == "pwd"){
                                $discType = "PWD";
                            }else if($discountType == "naac"){
                                $discType = "NAAC";
                            }else if($discountType == "sp"){
                                $discType = "Solo Parent";
                            }else if($discountType == "tenant"){
                                $discType == "Tenant";
                            }else{
                                $discType = "None";
                            }
                            $receipt = array(
                                'transactionId' => $postTransaction,
                                'entryTime' => $this->input->post("entryTime"),
                                'paymentTime' => $this->input->post("paymentTime"),
                                'parkingStay' => $this->input->post("parkingStay"),
                                'totalSales' => $totalSales,
                                'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                'terminalName' => "TRM001",
                                'nonVat' => $nonVatSales,
                                'vatableSales' => $vatableSale,
                                'totalAmountDue' => $totalSales + $totalVat,
                                'salesInvoice' => $OR,
                                'parkingStatus'=> $this->input->post("parking_status"),
                                'vatAmount' => $totalVat,
                                'vatExempt' => $vatExempt,
                                'zeroRated' => 0,
                                'cashReceived' => $cashReceived,
                                'changeDue' => $changeAmount,
                                'discount' => $totalDiscount,
                                
                                'discountType' => $this->input->post("discount_type"),
                                'discountDisplay' => $discType,
                                'paymentMode' => $paymode,
                                'accessType' => $this->input->post("access_type"),
                                'parkingCode' => $this->input->post("parking_code"),
                                'vehicleClass' => $this->input->post("vehicleClass"),
                                
                            );

                            // print_r($receipt);
                            $this->data['receipt'] = $receipt;
                            $this->data['receiptData'] = json_encode($receipt);
                            if($discountType == "none"){
                                $this->render_template("pos/success_status", $this->data);
                            }else{
                                $this->render_template("pos/customer_details", $this->data);
                            }
                        }else{
                            echo "Failed";
                        }

                        // print_r($transactionsData);
                    } else {
                        $remainingBalance = $remaining - $changeAmount;
                        $remainingData = array(
                            'terminal_id' => $terminalId,
                            'id' => $cashDrawer['id'],
                            'remaining' => $remainingBalance
                        );
                        $drawerUpdate = $this->model_touchpoint->updateDrawer($remainingData);
    
                        if ($drawerUpdate == true) {
                            // Company and PTU data
                            $companyId = 1;
                            $ptuId = 3;
                            $companyData = $this->model_touchpoint->getOrganization($companyId);
                            $ptuData = $this->model_touchpoint->getPtu($ptuId);
    
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
                                'issuedDate' => $ptuData['issued_date']
                            );
                            $OR = sprintf('%06d', $companyData['OR'] + 1);
    
                            $vehicleId = $this->input->post("vehicleClass");
                            $originalAmount = $this->input->post("parking_amount");
                            $discountType = $this->input->post('discount_type');
    
                            $vatExempt = 0;
                            $vatableSale = 0;
                            $nonVatSales = 0;
                            $zeroRatedSales = 0;
                            $totalVat = 0;
                            $amountAfterDiscounted = 0;
                            if ($discountType == "none") {
                                    $vatRate = 1.12;
                                    $vatPercent = 0.12;
                                    $vatableSale = $originalAmount / $vatRate;
                                    $totalSales = $vatableSale;
                                    $totalVat = ($vatableSale * $vatPercent);
                                    $amountDue = $vatableSale + $totalVat;
                                    $totalDiscount = ($vatableSale * 0.0);
                                    $vatExemption = $originalAmount * $vatExempt;
                                    // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                                    // echo "Discount: " . $discountType . "</br>";
                                    // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                                    // echo "Non-vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                                    // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                                    // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                                    // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                                    // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                                    // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                                    // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                            } else {
                                $vatRate = 1.12;
                                $vatPercent = 0.12; 
                                $discountCode = $this->input->post('discount_type');
                                $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                                $discountPercentage = $discounts['percentage'];


                                $totalDiscount = ($vatableSale * $discountPercentage);
                                $nonVatSales = $vatableSale - $totalDiscount;
                                $totalSales = $vatableSale - $totalDiscount;
                                $amountDue = $vatableSale - $totalDiscount;
                                $vatExempt = $vatableSale * $vatPercent;


                                // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                                // echo "Discount: " . $discountType . "</br>";
                                // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                                // echo "Non-Vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                                // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                                // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                                // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                                // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                                // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                                // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                            }

                            $updateComp = array(
                                'id' => $companyData['id'],
                                'OR' => $OR
                            );
    
                            $this->model_touchpoint->updateCompany($updateComp);
                            $parkingData = array(
                                'id' => $this->input->post("parking_id"),
                                'paid_time' => $this->input->post("paymentTime"),
                                'total_time' => $this->input->post("parkingStay"),
                                'earned_amount' => $totalSales,
                                'paid_status' => 1
                            );
    
                            $this->model_touchpoint->updateParkingData($parkingData);

                            $transactionsData = array(
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
                                'earned_amount' => $totalSales,
                                'cash_received' => $cashReceived,
                                'change' => $changeAmount,
                                'discount_type' => $discountType,
                                'discount' => $totalDiscount,
                                'vat_exempt' => $vatExempt,
                                'vatable_sales' => $vatableSale,
                                'zero_rated' => 0,
                                'vat' => $totalVat,
                                'transact_status' => 1,
                                'non_vat' => $nonVatSales,
                                'paymode' => $paymode,
                                'status' => 1
                            );
                            $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);

                            if($postTransaction){
                                $discType = "";
                                if($discountType == 'senior'){
                                    $discType = "SC";
                                }else if($discountType == "pwd"){
                                    $discType = "PWD";
                                }else if($discountType == "naac"){
                                    $discType = "NAAC";
                                }else if($discountType == "sp"){
                                    $discType = "Solo Parent";
                                }else if($discountType == "tenant"){
                                    $discType == "Tenant";
                                }else{
                                    $discType = "None";
                                }
                                $receipt = array(
                                    'transactionId' => $postTransaction,
                                    'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                    'terminalName' => "TRM001",
                                    'entryTime' => $this->input->post("entryTime"),
                                    'paymentTime' => $this->input->post("paymentTime"),
                                    'parkingStay' => $this->input->post("parkingStay"),
                                    'totalSales' => $totalSales,
                                    'nonVat' => $nonVatSales,
                                    'vatableSales' => $vatableSale,
                                    'totalAmountDue' => $totalSales + $totalVat,
                                    'salesInvoice' => $OR,
                                    'parkingStatus'=> $this->input->post("parking_status"),
                                    'vatAmount' => $totalVat,
                                    'vatExempt' => $vatExempt,
                                    'zeroRated' => 0,
                                    'cashReceived' => $cashReceived,
                                    'changeDue' => $changeAmount,
                                    'discount' => $totalDiscount,
                                    'discountType' => $discountType,
                                    'discountDisplay' => $discType,
                                    'paymentMode' => $paymode,
                                    'accessType' => $this->input->post("access_type"),
                                    'parkingCode' => $this->input->post("parking_code"),
                                    'vehicleClass' => $this->input->post("vehicleClass"),
                                    
                                );

                                
                                $this->data['receipt'] = $receipt;
                                $this->data['receiptData'] = json_encode($receipt);

                                if($discountType == "none"){
                                    $this->render_template("pos/success_status", $this->data);
                                }else{
                                    $this->render_template("pos/customer_details", $this->data);
                                }
                            }else{
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
                                    'discountType' => $this->input->post("discount_type"),
                                    'paymode' => $this->input->post("paymentmode"),
                                    'totalSales' => $this->input->post("total_sales")
                                );

                            }
                        } else {
                            $this->render_template('pos/server_failed', $this->data);
                        }
                    }
                } else if ($paymode == "GCash" || $paymode == "Paymaya") {
                    $refnumber = $this->input->post("qrphref");
                    $amount = $this->input->post('amount');
                    // echo $refnumber;
                    $url = "https://103.95.213.254:49416/switch-card-utility/v1/transactions/" . urlencode($refnumber);
                

                    $transactDate = date('Y-m-d');
                    // echo $transactDate;
                    $data = array(
                        'ref' => $refnumber,
                        // 'amount' => $amount,
                        'amount' => "100",
                        'transact-date' => $transactDate
                    );

                    $params = array(
                        'trace-number' => $refnumber,
                        'terminal-id' => '70021415',
                        // 'amount' => number_format($amount, 2, '.', ''), 
                        'amount' => 1, 
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
                    }else{
                        $decodedResponse = json_decode($response, true);
                        if ($decodedResponse) {
                            // Access specific fields in the response
                            // echo "Invoice Number: " . $decodedResponse['InvoiceNumber'] . "<br>";
                            // echo "Reference Number: " . $decodedResponse['ReferenceNumber'] . "<br>";
                            // echo "Amount: " . $decodedResponse['Amount'] . "<br>";
                            // echo "Date: " . $decodedResponse['Date'] . "<br>";
                            // echo "Time: " . $decodedResponse['Time'] . "<br>";
                            // echo "Card Number: " . $decodedResponse['CardNumber'] . "<br>";
                            // echo "Trace Number: " . $decodedResponse['TraceNumber'] . "<br>";
                            // echo "Approval Code: " . $decodedResponse['ApprovalCode'] . "<br>";
                            // echo "Status: " . $decodedResponse['Status'] . "<br>";
                            // echo "Reason: " . $decodedResponse['Reason'] . "<br>";

                            $status = $decodedResponse['Status'];

                            if($status == "Approved"){
                                $companyId = 1;
                                $ptuId = 3;
                                $companyData = $this->model_touchpoint->getOrganization($companyId);
                                $ptuData = $this->model_touchpoint->getPtu($ptuId);
            
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
                                    'issuedDate' => $ptuData['issued_date']
                                );
                                $OR = sprintf('%06d', $companyData['OR'] + 1);
            
                                    // Discount and VAT calculations
                                $vehicleId = $this->input->post("vehicleClass");
                                $originalAmount = $this->input->post("parking_amount");
                                $discountType = $this->input->post('discount_type');
            
                                $vatExempt = 0;
                                $vatableSale = 0;
                                $nonVatSales = 0;
                                $zeroRatedSales = 0;
                                $totalVat = 0;
                                $amountAfterDiscounted = 0;
                                if ($discountType == "none") {
                                        $vatRate = 1.12;
                                        $vatPercent = 0.12;
                                        $vatableSale = $originalAmount / $vatRate;
                                        $totalSales = $vatableSale;
                                        $totalVat = ($vatableSale * $vatPercent);
                                        $amountDue = $vatableSale + $totalVat;
                                        $totalDiscount = ($vatableSale * 0.0);
                                        $vatExemption = $originalAmount * $vatExempt;
                                        //echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                                        //echo "Discount: " . $discountType . "</br>";
                                        //echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                                        //echo "Non-vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                                        //echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                                        //echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                                        //echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                                        //echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                                        //echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                                        //echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                                } else {
                                    $vatRate = 1.12;
                                    $vatPercent = 0.12; 
                                    $discountCode = $this->input->post('discount_type');
                                    $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                                    $discountPercentage = $discounts['percentage'];
    
                                    $vatableSale = $originalAmount / $vatRate;
    
                                    $totalDiscount = ($vatableSale * $discountPercentage);
                                    $nonVatSales = $vatableSale - $totalDiscount;
                                    $totalSales = $vatableSale - $totalDiscount;
                                    $amountDue = $vatableSale - $totalDiscount;
                                    $vatExempt = $vatableSale * $vatPercent;
    
    
                                    // echo "Original Amount: " . number_format($originalAmount, 2) . "</br>";
                                    // echo "Discount: " . $discountType . "</br>";
                                    // echo "Vatable Sales: " . number_format($vatableSale, 2) . "</br>";
                                    // echo "Non-Vat Sales: " . number_format($nonVatSales, 2) . "</br>";
                                    // echo "Zero-Rated Sales: " . number_format($zeroRatedSales, 2) . "</br>";
                                    // echo "Total Sales: " . number_format($totalSales, 2) . "</br>";
                                    // echo "Total Vat: " . number_format($totalVat, 2) . "</br>";
                                    // echo "Total Amount Due: " . number_format($amountDue, 2) . "</br>";
                                    // echo "Amount Discount: " . number_format($totalDiscount, 2) . "</br>";
                                    // echo "Vat Exemption:  " . number_format($vatExempt, 2) . "</br>";
                                }
            
                                $transactionsData = array(
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
                                    'earned_amount' => $totalSales,
                                    'cash_received' => 0,
                                    'discount_type' => $this->input->post("discount_type"),
                                    'change' => 0,
                                    'discount' => $totalDiscount,
                                    'vat' => $totalVat,
                                    'vat_exempt' => $vatExempt,
                                    'vatable_sales' => $vatableSale,
                                    'zero_rated' => $zeroRatedSales,
                                    'transact_status' => 1,
                                    'non_vat' => $nonVatSales,
                                    'paymode' => $paymode,
                                    'status' => 1
                                );
                                $parkingData = array(
                                    'id' => $this->input->post("parking_id"),
                                    'paid_time' => $this->input->post("paymentTime"),
                                    'total_time' => $this->input->post("parkingStay"),
                                    'earned_amount' => $totalSales,
                                    'paid_status' => 1
                                );
        
                                $this->model_touchpoint->updateParkingData($parkingData);
    
                                $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);
                                $updateComp = array(
                                    'id' => $companyData['id'],
                                    'OR' => $OR
                                );
        
                                $this->model_touchpoint->updateCompany($updateComp);
                                if($postTransaction){
                                    $discType = "";
                                    if($discountType == 'senior'){
                                        $discType = "SC";
                                    }else if($discountType == "pwd"){
                                        $discType = "PWD";
                                    }else if($discountType == "naac"){
                                        $discType = "NAAC";
                                    }else if($discountType == "sp"){
                                        $discType = "Solo Parent";
                                    }else if($discountType == "tenant"){
                                        $discType == "Tenant";
                                    }else{
                                        $discType = "None";
                                    }
                                    $receipt = array(
                                        'entryTime' => $this->input->post("entryTime"),
                                        'paymentTime' => $this->input->post("paymentTime"),
                                        'parkingStay' => $this->input->post("parkingStay"),
                                        'totalSales' => $amountDue,
                                        'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                        'terminalName' => "TRM001",
                                        'nonVat' => $nonVatSales,
                                        'vatableSales' => $vatableSale,
                                        'totalAmountDue' => $totalSales + $totalVat,
                                        'salesInvoice' => $OR,
                                        'parkingStatus'=> $this->input->post("parking_status"),
                                        'vatAmount' => $totalVat,
                                        'vatExempt' => $vatExempt,
                                        'zeroRated' => 0,
                                        'cashReceived' => 0,
                                        'changeDue' => 0,
                                        'discount' => $totalDiscount,
                                        'discountType' => $discountType,
                                        'discountDisplay' => $discType,
                                        'paymentMode' => $paymode,
                                        'accessType' => $this->input->post("access_type"),
                                        'parkingCode' => $this->input->post("parking_code"),
                                        'vehicleClass' => $this->input->post("vehicleClass"),
                                        
                                    );
        
                                    // print_r($receipt);
                                    $this->data['receipt'] = $receipt;
                                    $this->data['receiptData'] = json_encode($receipt);
                                    $this->render_template("pos/success_status", $this->data);
                                }else{
                                    echo "Failed";
                                }
                            }else{

                            }
                        } else {
                            echo "Failed to decode the JSON response.";
                        }
                    }

                    curl_close($ch);

                    // echo $response;
                } else if ($paymode == "Complimentary") {
                    
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
                        'discountType' => $this->input->post("discount_type"),
                        'paymode' => $this->input->post("paymentmode"),
                        'totalSales' => $this->input->post("total_sales")
                    );

                    $code = $this->input->post("compcode");
                    $OR = sprintf('%06d', 000000 + 1);
                    $verifyCode = $this->model_touchpoint->getComplimentary($code);
                    $currentDate = date('Y-m-d');

                    $status = '';

                    if ($verifyCode['is_used'] == 1) {

                        $status = 'This code is already used.';

                        $receipt = array(
                            'entryTime' => $this->input->post("entryTime"),
                            'paymentTime' => $this->input->post("paymentTime"),
                            'parkingStay' => $this->input->post("parkingStay"),
                            'totalSales' => 0,
                            'nonVat' => 0,
                            'vatableSales' => 0,
                            'totalAmountDue' => $this->input->post("parking_amount"),
                            'salesInvoice' => $OR,
                            'vatAmount' => 0,
                            'vatExempt' => 0,
                            'zeroRated' => 0,
                            'cashReceived' => 0,
                            'changeDue' => 0,
                            'discount' => 0,
                            'paymentMode' => $this->input->post("paymentmode"),
                            'accessType' => $this->input->post("access_type"),
                            'parkingCode' => $this->input->post("parking_code"),
                            'vehicleClass' => $this->input->post("vehicleClass"),
                            
                        );

                        // print_r($receipt);
                        $this->data['receipt'] = $receipt;
                        $this->data['voucherStatus'] = $status;
                        $this->data['receiptData'] = json_encode($receipt);
                        $this->render_template("pos/failed_payment", $this->data);
                    } 
                    else if ($currentDate > $verifyCode['end_date']) {
                        $status = 'This code is already expired.';
                        $receipt = array(
                            'entryTime' => $this->input->post("entryTime"),
                            'paymentTime' => $this->input->post("paymentTime"),
                            'parkingStay' => $this->input->post("parkingStay"),
                            'totalSales' => 0,
                            'nonVat' => 0,
                            'vatableSales' => 0,
                            'totalAmountDue' => $this->input->post("parking_amount"),
                            'salesInvoice' => $OR,
                            'vatAmount' => 0,
                            'vatExempt' => 0,
                            'zeroRated' => 0,
                            'cashReceived' => 0,
                            'changeDue' => 0,
                            'discount' => 0,
                            'paymentMode' => $this->input->post("paymentmode"),
                            'accessType' => $this->input->post("access_type"),
                            'parkingCode' => $this->input->post("parking_code"),
                            'vehicleClass' => $this->input->post("vehicleClass"),
                            
                        );

                        // print_r($receipt);
                        $this->data['voucherStatus'] = $status;
                        $this->data['receipt'] = $receipt;
                        $this->render_template("pos/failed_payment", $this->data);
                    }
                    else if ($currentDate < $verifyCode['start_date']) {
                        $status = 'This code is not yet available.';
                        $receipt = array(
                            'entryTime' => $this->input->post("entryTime"),
                            'paymentTime' => $this->input->post("paymentTime"),
                            'parkingStay' => $this->input->post("parkingStay"),
                            'totalSales' => 0,
                            'nonVat' => 0,
                            'vatableSales' => 0,
                            'totalAmountDue' => $this->input->post("parking_amount"),
                            'salesInvoice' => $OR,
                            'vatAmount' => 0,
                            'vatExempt' => 0,
                            'zeroRated' => 0,
                            'cashReceived' => 0,
                            'changeDue' => 0,
                            'discount' => 0,
                            'paymentMode' => $this->input->post("paymentmode"),
                            'accessType' => $this->input->post("access_type"),
                            'parkingCode' => $this->input->post("parking_code"),
                            'vehicleClass' => $this->input->post("vehicleClass"),
                            
                        );

                        // print_r($receipt);
                        $this->data['voucherStatus'] = $status;
                        $this->data['receipt'] = $receipt;
                        $this->render_template("pos/failed_payment", $this->data);
                    }
                    else {
                        $parkingData = array(
                            'id' => $this->input->post("parking_id"),
                            'paid_time' => $this->input->post("paymentTime"),
                            'total_time' => $this->input->post("parkingStay"),
                            'earned_amount' => 0,
                            'paid_status' => 1
                        );

                        $complimentaryData = array(
                            'id' => $verifyCode['id'],
                            'is_used' => 1
                        );
                        $this->model_touchpoint->updateComplimentary($complimentaryData);
                        $this->model_touchpoint->updateParkingData($parkingData);
                        $transactionsData = array(
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
                            'earned_amount' => 0,
                            'cash_received' => 0,
                            'change' => 0,
                            'discount_type' => $this->input->post("discount_type"),
                            'discount' => 0,
                            'vat_exempt' => 0,
                            'vatable_sales' => 0,
                            'zero_rated' => 0,
                            'transact_status' => 1,
                            'non_vat' => 0,
                            'paymode' => $this->input->post("paymentmode"),
                            'status' => 1
                        );

                        $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);
                        if($postTransaction){
                            $receipt = array(
                                'entryTime' => $this->input->post("entryTime"),
                                'paymentTime' => $this->input->post("paymentTime"),
                                'parkingStay' => $this->input->post("parkingStay"),
                                'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                'terminalName' => "TRM001",
                                'totalSales' => 0,
                                'nonVat' => 0,
                                'vatableSales' => 0,
                                'totalAmountDue' => $this->input->post("parking_amount"),
                                'salesInvoice' => $OR,
                                'vatAmount' => 0,
                                'vatExempt' => 0,
                                'zeroRated' => 0,
                                'cashReceived' => 0,
                                'changeDue' => 0,
                                'discount' => 0,
                                'paymentMode' => $this->input->post("paymentmode"),
                                'accessType' => $this->input->post("access_type"),
                                'parkingCode' => $this->input->post("parking_code"),
                                'vehicleClass' => $this->input->post("vehicleClass"),
                                
                            );

                            // print_r($receipt);
                            $this->data['receipt'] = $receipt;
                            $this->data['receiptData'] = json_encode($receipt);
                            $this->render_template("pos/success_payment", $this->data);
                        }else{
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
                                'discountType' => $this->input->post("discount_type"),
                                'paymode' => $this->input->post("paymentmode"),
                                'totalSales' => $this->input->post("total_sales")
                            );
                        }
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

    public function addCustomerDetail(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {

                $customerInformation = array(
                    'transact_id' => $this->input->post('transact_id'),
                    'discount_type' => $this->input->post('discount_type'),
                    'name' => $this->input->post('name'),
                    'address' => $this->input->post('address'),
                    'tin_id' => $this->input->post('tin_id'),
                    'id_number' => $this->input->post('id_number'),
                    'child_name' => $this->input->post('child_name'),
                    'child_dob' => $this->input->post('child_dob'),
                );

                $createDiscountRecord = $this->model_touchpoint->createRecDiscount($customerInformation);
                
                if($createDiscountRecord == true){
                    $this->load->view('templates/header');
                    $this->render_template('pos/success_page', $this->data);
                }else{
                    $this->load->view('templates/header');
                    $this->render_template('pos/failed_page', $this->data);
                }
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function transactions() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $transactions = $this->model_touchpoint->getTransactions($user_id);
    
                // Pass transactions to the view
                $this->data['transactions'] = $transactions;
    
                $this->load->view('templates/header');
                $this->render_template('pos/transactions', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function transactionHistory(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $transactions = $this->model_touchpoint->getAllTransactions($user_id);
    
                $this->data['transactions'] = $transactions;
    
                $this->load->view('templates/header');
                $this->render_template('pos/transaction_history', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function reports(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $transactions = $this->model_touchpoint->getTransactions($user_id);
    
                $this->data['transactions'] = $transactions;
    
                $this->load->view('templates/header');
                $this->render_template('pos/reports', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function xreport(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
    
                $this->load->view('templates/header');
                $this->render_template('pos/xreport', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function xreadingGenerate(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        date_default_timezone_set("Asia/Manila");
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $terminalId = $this->input->post('terminal');
                $cashierId = $this->input->post('cashier');
                $selectedDate = $this->input->post('date');

                $data = $this->model_touchpoint->getXreadingData($selectedDate, $cashierId, $terminalId);

                $data['reportDate'] = date('F d, Y');
                $data['reportTime'] = date('H:i A');
                $data['cashierName'] =  $this->session->userdata("fname") . " " . $this->session->userdata("lname");
                $data['terminalName'] =  "TRM001";
                $data['startDateandTime'] = date('m/d/y h:i A', strtotime('08:00 AM'));
                $data['endDateandTime'] = date('m/d/y H:i A');
                // print_r($data);
                $this->data['xreading'] = $data;
                $this->data['xreadingData'] = json_encode($data);
                // print_r($xreading);
                $this->load->view('templates/header');
                $this->render_template('pos/xreport_data', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function zreport(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
    
                $this->load->view('templates/header');
                $this->render_template('pos/zreport', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function zreadingGenerate(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $terminalId = $this->input->post('terminal');
                $cashierId = $this->input->post('cashier');
                $selectedDate = $this->input->post('date');

                $data = $this->model_touchpoint->getZreadingData($selectedDate, $cashierId, $terminalId);

                // print_r($data);
                
                $data['reportDate'] = date('F d, Y');
                $data['reportTime'] = date('H:i A');
                $data['cashierName'] =  $this->session->userdata("fname") . " " . $this->session->userdata("lname");
                $data['terminalName'] =  "TRM001";
                $data['startDateandTime'] = date('m/d/y h:i A', strtotime('08:00 AM'));
                $data['endDateandTime'] = date('m/d/y H:i A');
                $this->data['xreading'] = $data;
                $this->data['xreadingData'] = json_encode($data);
                $this->load->view('templates/header');
                $this->render_template('pos/zreport_data', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }


    public function ejournal(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
    
                $this->load->view('templates/header');
                $this->render_template('pos/ejournal', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function ejournalGenerate(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $startDate = $this->input->post('start_date');
                $endDate = $this->input->post('end_date');
                $cashierId = $this->input->post('cashier');
                $terminalId = $this->input->post('terminal');

                $companyId = 1;
                $terminalId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $ptuData = $this->model_touchpoint->getPtu($terminalId);

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
                    'issuedDate' => $ptuData['issued_date']
                );


                $data = $this->model_touchpoint->geteJournalData($startDate, $endDate, $cashierId, $terminalId);
                
                $fileName = "eJournalReport_" . date('Ymd_His') . ".txt";
                $content = "e-Journal Report\n";
                $content .= "Date Range: $startDate to $endDate\n";
                $content .= "Cashier ID: $cashierId\n";
                $content .= "Terminal ID: $terminalId\n";
                $content .= "Date Range: $startDate to $endDate\n";
                $content .= "-------------------------------------------------------\n";

                foreach ($data as $row) {
                    $vehicleId = $row['vehicle_cat_id'];
                    if ($vehicleId == "1") {
                        $vehicle = "Motorcycle";
                    } elseif ($vehicleId == "2") {
                        $vehicle = "Car";
                    } elseif ($vehicleId == "3") {
                        $vehicle = "BUS/Truck";
                    } else {
                        $vehicle = "Unknown";
                    }

                    $userid = $row['cashier_id'];
                    $pid = $row['pid'];

                    $profile = $this->model_touchpoint->getUserData($userid);
                    $terminal = $this->model_touchpoint->getTerminalData($pid);

                    $totalAmountd = floatval($row['earned_amount']) + floatval($row['vat']);

                    
                    $content .= "                           PICC\n";
                    $content .= "        ". $companyData['name'] ."\n";
                    $content .= $companyData['address'] ."\n";
                    $content .= "             VAT REG TIN: ". $companyData['TIN'] ."\n";
                    $content .= "                   MIN: ". $companyData['MIN'] ."\n";
                    $content .= "                   SN: M8N0CV16T94434H\n";
                    $content .= "                     ". $companyData['telephone'] ."\n\n";
                    $content .= "                     TRAINING MODE\n\n";
                    $content .= "        Date and Time: " . date('Y-m-d H:i:s A',$row['paid_time']) . "\n";
                    $content .= "                    S/I: 00-" . $row['ornumber'] . "\n";
                    $content .= "                    ". $row['access_type'] .":" . $row['parking_code'] . "\n";
                    $content .= "                    Vehicle: " . $vehicle . "\n\n";
                    $content .= "                     Sales Invoice\n\n";
                    $content .= "Cashier:                                   " . $profile['firstname'] ." " . $profile['lastname'] . "\n";
                    $content .= "Terminal:                                   " . $terminal['name'] . "\n";
                    $content .= "-------------------------------------------------------\n";
                    $content .= "Gate In:                            " . date('Y-m-d H:i:s A', $row['in_time']) . "\n";
                    $content .= "Billing Time:                       " . date('Y-m-d H:i:s A', $row['paid_time']) . "\n";
                    $content .= "Parking Time:                                     " . $row['total_time'] . "\n";
                    $content .= "Total Sales:                                           " . $row['earned_amount'] . "\n";
                    $content .= "vat(12%):                                             " . $row['vat'] . "\n";
                    $content .= "Total Amount Due:                                   " . $totalAmountd . "\n";
                    $content .= "-------------------------------------------------------\n";
                    $content .= "Cash Received:                                   " . $row['cash_received'] . "\n";
                    $content .= "Cash Change:                                   " . $row['change'] . "\n";
                    $content .= "-------------------------------------------------------\n";
                    $content .= "Vatable Sales:                                   " . number_format($row['vatable_sales'], 2) . "\n";
                    $content .= "Non-Vat Sales:                                   " . $row['non_vat'] . "\n";
                    $content .= "Vat-Exempt:                                   " . $row['vat_exempt'] . "\n";
                    $content .= "Zero-Rated Sales:                                   " . $row['zero_rated'] . "\n";
                    $content .= "Discount:                                   " . $row['discount'] . "\n";
                    $content .= "Payment Mode:                                   " . $row['paymode'] . "\n\n";
                    $content .= "             BIR PTU NO: ". $ptuData['BIR_SN'] ."\n";
                    $content .= "           PTU ISSUED DATE: ". $ptuData['issued_date'] ."\n";
                    $content .= "          THIS SERVES AS YOUR SALES INVOICE\n\n";
                    $content .= "=======================================================\n\n";
                }

                // Force download headers
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Content-Length: ' . strlen($content));

                // Output content
                echo $content;
                exit;
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function ejournalPreview() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $startDate = $this->input->post('start_date');
                $endDate = $this->input->post('end_date');
                $cashierId = $this->input->post('cashier');
                $terminalId = $this->input->post('terminal');
    
                $companyId = 1;
                $terminalId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $ptuData = $this->model_touchpoint->getPtu($terminalId);
    
                $data = $this->model_touchpoint->geteJournalData($startDate, $endDate, $cashierId, $terminalId);
    
                // Prepare data for the modal
                $previewData = [];
                foreach ($data as $row) {
                    $vehicleId = $row['vehicle_cat_id'];
                    $vehicle = $vehicleId == "1" ? "Motorcycle" : ($vehicleId == "2" ? "Car" : ($vehicleId == "3" ? "BUS/Truck" : "Unknown"));
    
                    $userid = $row['cashier_id'];
                    $pid = $row['pid'];
    
                    $profile = $this->model_touchpoint->getUserData($userid);
                    $terminal = $this->model_touchpoint->getTerminalData($pid);
    
                    $totalAmountd = floatval($row['earned_amount']) + floatval($row['vat']);
    
                    $previewData[] = [
                        'company_name' => $companyData['name'],
                        'company_address' => $companyData['address'],
                        'MIN' => $companyData['MIN'],
                        'tin' => $companyData['TIN'],
                        'date_time' => date('Y-m-d h:i:s A', strtotime($row['paid_time'])),
                        'ornumber' => $row['ornumber'],
                        'access_type' => $row['access_type'],
                        'parking_code' => $row['parking_code'],
                        'vehicle' => $vehicle,
                        'cashier_name' => $profile['firstname'] . " " . $profile['lastname'],
                        'terminal_name' => $terminal['name'],
                        'in_time' => date('Y-m-d h:i:s A', strtotime($row['in_time'])),
                        'billing_time' => date('Y-m-d h:i:s A', strtotime($row['paid_time'])),
                        'total_time' => $row['total_time'],
                        'earned_amount' => $row['earned_amount'],
                        'vat' => $row['vat'],
                        'total_amount_due' => $totalAmountd,
                        'cash_received' => $row['cash_received'],
                        'change' => $row['change'],
                        'vatable_sales' => number_format($row['vatable_sales'], 2),
                        'non_vat' => $row['non_vat'],
                        'vat_exempt' => $row['vat_exempt'],
                        'zero_rated' => $row['zero_rated'],
                        'discount' => $row['discount'],
                        'paymode' => $row['paymode'],
                        'BIR_SN' => $ptuData['BIR_SN'],
                        'issued_date' => $ptuData['issued_date'],
                    ];
                }
    
                // Return data to modal view
                echo json_encode([
                    'status' => 'success',
                    'previewData' => $previewData
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No cash drawer found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'You are not a cashier.'
            ]);
        }
    }


    public function xreading(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
                $this->load->view('templates/header');
                $this->render_template('pos/xreading', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function xresult(){
        $user_id = $this->session->userdata('id');
        
        $position = $this->model_users->getUserGroup($user_id);
        
        if ($position['id'] == 5) {
            $terminalId = 1;  // Assuming the terminal ID is fixed to 1
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
            
            if ($cashDrawer) {
                $report_date = $this->input->post('report_date');
                $cashier_id = $this->input->post('cashier_id');
                
                $xreading = $this->model_touchpoint->getXReadingData($report_date, $cashier_id);
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $report_date);
                $formatted_report_date = $date->format('m-d-Y H:i:s A');

                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();
               
                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
                $this->data['xreading'] = $xreading; 
                $this->load->view('templates/header');
                $this->data['xreadingData'] = json_encode($xreading);
                print_r($xreading);
                $this->render_template('pos/xresult', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function zreading(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
                $this->load->view('templates/header');
                $this->render_template('pos/zreading', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function zresult(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();
                $report_date = $this->input->post('report_date');
                $zreading = $this->model_touchpoint->getZReadingData($report_date); // pass report_date if needed
                
                print_r($zreading);
                // Pass the data to the view
                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
                $this->data['zreading'] = $zreading;
                $this->load->view('templates/header');
                $this->render_template('pos/zresult', $this->data); // Adjusted to include $this->data
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    
    
    public function searchPlate(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $plate_number = $this->input->post('plate_number'); 
    
                $similarRecords = $this->model_touchpoint->getSimilarRecord($plate_number);
    
                if ($similarRecords) {
                    $this->data['similarRecords'] = $similarRecords;
                } else {
                    $this->data['message'] = "No data filtered, please input details.";
                }
    
                $this->load->view('templates/header');
                $this->render_template('pos/search_plate', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    

    public function generateSummary(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                

                $cashiers = $this->model_touchpoint->getCashierList();
                $terminals = $this->model_touchpoint->getTerminalList();
               

                $this->data['cashiers'] = $cashiers;
                $this->data['terminals'] = $terminals;
                $this->load->view('templates/header');
                $this->render_template('pos/summary_generate', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function previewSummaryReport(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        // added by jake
        $taxPayer = $this->model_company->getCompanyInfo(1);
        date_default_timezone_set('Asia/Manila'); // Set the timezone
        $currentDateTime = date('Y-m-d H:i:s');
        $software = "Touchpoint v1.0";

        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $cashier_id = $this->input->post('cashier');
                $trmId = $this->input->post('terminal');
                $startDate = $this->input->post('start_date');
                $endDate = $this->input->post('end_date');

                // pass to export button
                $this->data['cashier_id'] = $cashier_id;
                $this->data['trmId'] = $trmId;
                $this->data['startDate'] = $startDate;
                $this->data['endDate'] = $endDate;

                // Added
                $ptuData = $this->model_ptu->getPtuData($trmId);

                $summaryData = $this->model_touchpoint->getDiscountsSummary($cashier_id, $trmId, $startDate, $endDate);
                $seniorsReport = $this->model_touchpoint->getSeniorCitizenReport();
                $pwdReport = $this->model_touchpoint->getPwdReport();
                $naacReport = $this->model_touchpoint->getNaacReport();
                $soloparentReport = $this->model_touchpoint->getSoloParentReport();
                $joinedResult = $summaryData['joinedResult'];


                // Check if 'joinedResult' exists in $summaryData to avoid potential errors.
                $this->data['summaryData'] = $summaryData;
                $this->data['seniorsReport'] = $seniorsReport;
                $this->data['pwdReport'] = $pwdReport;
                $this->data['naacReport'] = $naacReport;
                $this->data['soloparentReport'] = $soloparentReport;

                // print_r($summaryData);
                // var_dump($seniorsReport);
                $this->render_template('pos/preview_excel', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    public function discountSummaryReport()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        // added by jake
        $taxPayer = $this->model_company->getCompanyInfo(1);
        date_default_timezone_set('Asia/Manila'); // Set the timezone
        $currentDateTime = date('Y-m-d H:i:s');
        $software = "Touchpoint v1.0";

        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $cashier_id = $this->input->post('cashier');
                $trmId = $this->input->post('terminal');
                $startDate = $this->input->post('start_date');
                $endDate = $this->input->post('end_date');

                // Added
                $ptuData = $this->model_ptu->getPtuData($trmId);

                $summaryData = $this->model_touchpoint->getDiscountsSummary($cashier_id, $trmId, $startDate, $endDate);
                $seniorsReport = $this->model_touchpoint->getSeniorCitizenReport();
                $pwdReport = $this->model_touchpoint->getPwdReport();
                $naacReport = $this->model_touchpoint->getNaacReport();
                $soloparentReport = $this->model_touchpoint->getSoloParentReport();
                $joinedResult = $summaryData['joinedResult'];

                try {
                    // Create a new Spreadsheet object
                    $spreadsheet = new Spreadsheet();

                    // Add data to E-1
                    $sheet1 = $spreadsheet->getActiveSheet();
                    $sheet1->setTitle('E-1');
                    $sheet1->mergeCells('A1:AF1')->setCellValue('A1', $taxPayer['name']);
                    $sheet1->mergeCells('A2:AF2')->setCellValue('A2', $taxPayer['address']);
                    $sheet1->mergeCells('A3:AF3')->setCellValue('A3', $taxPayer['TIN']);
                    $sheet1->getStyle('A1:AF3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $sheet1->setCellValue('A5', $software);
                    $sheet1->setCellValue('A6', $ptuData['serial']);
                    $sheet1->setCellValue('A7', $taxPayer['MIN']);
                    $sheet1->setCellValue('A8', 'TRM00' . $trmId);
                    $sheet1->setCellValue('A9', $currentDateTime);
                    $sheet1->setCellValue('A10', $user_id);
                    $sheet1->getRowDimension(12)->setRowHeight(21.60);

                    // Merge each row individually and set text alignment to left
                    for ($row = 5; $row <= 10; $row++) {
                        $sheet1->mergeCells("A{$row}:B{$row}");
                        $sheet1->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    // Add text for BIR SALES SUMMARY REPORT (Bold, Centered, Font size 16)
                    $sheet1->mergeCells('A12:AF12')->setCellValue('A12', 'BIR SALES SUMMARY REPORT');
                    $sheet1->getStyle('A12')->getFont()->setBold(true)->setSize(16);
                    $sheet1->getStyle('A12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

                    $sheet1->getRowDimension(15)->setRowHeight(29.40);
                    // Merge and set headers in row 13 to 15 for 'Date'
                    $sheet1->mergeCells('A13:A15')->setCellValue('A13', 'Date');
                    $sheet1->getColumnDimension('A')->setWidth(8.11);
                    $sheet1->getStyle('A13:A15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);

                    // Merge and set headers in row 13 to 15 for 'Beginning SI/OR No.' and 'Ending SI/OR No.' in the E-1 sheet
                    $sheet1->getColumnDimension('B')->setWidth(10.11);
                    $sheet1->mergeCells('B13:B15')->setCellValue('B13', 'Beginning SI/OR No.');
                    $sheet1->getColumnDimension('C')->setWidth(10.11);
                    $sheet1->mergeCells('C13:C15')->setCellValue('C13', 'Ending SI/OR No.');

                    $sheet1->getColumnDimension('D')->setWidth(12.67);
                    $sheet1->mergeCells('D13:D15')->setCellValue('D13', 'Grand Accum. Sales Ending Balance');
                    $sheet1->getColumnDimension('E')->setWidth(12.67);
                    $sheet1->mergeCells('E13:E15')->setCellValue('E13', 'Grand Accum. Beg.Balance');

                    $sheet1->getColumnDimension('F')->setWidth(12.67);
                    $sheet1->getStyle('F13')->getFont()->setSize(9);
                    $sheet1->mergeCells('F13:F15')->setCellValue('F13', 'Sales Issued w/ Manual SI/OR (per RR 16-2018)');
                    $sheet1->getColumnDimension('G')->setWidth(12.67);
                    $sheet1->mergeCells('G13:G15')->setCellValue('G13', 'Gross Sales for the Day');

                    $sheet1->getColumnDimension('H')->setWidth(12.67);
                    $sheet1->mergeCells('H13:H15')->setCellValue('H13', 'VATable Sales');
                    $sheet1->getColumnDimension('I')->setWidth(12.67);
                    $sheet1->mergeCells('I13:I15')->setCellValue('I13', 'VAT Amount');
                    $sheet1->getColumnDimension('J')->setWidth(12.67);
                    $sheet1->mergeCells('J13:J15')->setCellValue('J13', 'VAT-Exempt Sales');
                    $sheet1->getColumnDimension('K')->setWidth(12.67);
                    $sheet1->mergeCells('K13:K15')->setCellValue('K13', 'Zero-Rated Sales');

                    $sheet1->mergeCells('L13:S13')->setCellValue('L13', 'Deductions');
                    $sheet1->mergeCells('L14:P14')->setCellValue('L14', 'Discount');
                    $sheet1->setCellValue('L15', 'SC');
                    $sheet1->setCellValue('M15', 'PWD');
                    $sheet1->setCellValue('N15', 'NAAC');
                    $sheet1->setCellValue('O15', 'Solo Parent');
                    $sheet1->setCellValue('P15', 'Others');

                    $sheet1->getColumnDimension('Q')->setWidth(9.22);
                    $sheet1->mergeCells('Q14:Q15')->setCellValue('Q14', 'Returns');

                    $sheet1->getColumnDimension('R')->setWidth(9.22);
                    $sheet1->mergeCells('R14:R15')->setCellValue('R14', 'Voids');

                    $sheet1->getColumnDimension('S')->setWidth(10.89);
                    $sheet1->mergeCells('S14:S15')->setCellValue('S14', 'Total Deductions');


                    $sheet1->mergeCells('T13:Y13')->setCellValue('T13', 'Adjustment on VAT');
                    $sheet1->mergeCells('T14:V14')->setCellValue('T14', 'Discount');
                    $sheet1->setCellValue('T15', 'SC');
                    $sheet1->setCellValue('U15', 'PWD');
                    $sheet1->setCellValue('V15', 'Others');

                    $sheet1->getColumnDimension('W')->setWidth(8.11);
                    $sheet1->mergeCells('W14:W15')->setCellValue('W14', 'VAT on Returns');

                    $sheet1->getColumnDimension('X')->setWidth(8.11);
                    $sheet1->mergeCells('X14:X15')->setCellValue('X14', 'Others');

                    $sheet1->getColumnDimension('Y')->setWidth(16.56);
                    $sheet1->mergeCells('Y14:Y15')->setCellValue('Y14', 'Total VAT Adjustment');

                    $sheet1->getColumnDimension('Z')->setWidth(10.67);
                    $sheet1->mergeCells('Z13:Z15')->setCellValue('Z13', 'VAT Payable');
                    $sheet1->getColumnDimension('AA')->setWidth(10.67);
                    $sheet1->mergeCells('AA13:AA15')->setCellValue('AA13', 'Net Sales');
                    $sheet1->getColumnDimension('AB')->setWidth(12.56);
                    $sheet1->mergeCells('AB13:AB15')->setCellValue('AB13', 'Sales Overrun /Overflow');
                    $sheet1->getColumnDimension('AC')->setWidth(10.67);
                    $sheet1->mergeCells('AC13:AC15')->setCellValue('AC13', 'Total Income');
                    $sheet1->getColumnDimension('AD')->setWidth(10.67);
                    $sheet1->mergeCells('AD13:AD15')->setCellValue('AD13', 'Reset Counter');
                    $sheet1->getColumnDimension('AE')->setWidth(10.67);
                    $sheet1->mergeCells('AE13:AE15')->setCellValue('AE13', 'Z-Counter');
                    $sheet1->getColumnDimension('AF')->setWidth(10.67);
                    $sheet1->mergeCells('AF13:AF15')->setCellValue('AF13', 'Remarks');

                    // Define colors for specific ranges
                    $colors = [
                        'A13:B15' => 'A6A6A6', // Ending SI/OR No. (gray)
                        'C13:C15' => 'A6A6A6', // Same color as A13:B13 (gray)
                        'D13:G15' => '00B0F0', // Grand Accum. Sales Ending Balance to Gross Sales (light blue)
                        'H13:K15' => 'FFFF00', // VATable Sales to Zero-Rated Sales (yellow)
                        'L13:S15' => 'FFA500', // Deductions (orange)
                        'T13:Y15' => '90EE90', // Adjustment on VAT (light green)
                        'Z13:AF15' => 'A6A6A6'  // VAT Payable to Remarks (gray)
                    ];

                    // Apply colors
                    foreach ($colors as $range => $color) {
                        $sheet1->getStyle($range)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($color);
                    }

                    // Apply border styles
                    $borderStyle = [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => '000000'], // Black border
                            ],
                        ],
                    ];

                    // Apply borders and other styles for header range
                    $sheet1->getStyle('A13:AF15')->applyFromArray($borderStyle);





                    $row = 16; // Start from row 16

                    // Set the values in the respective cells
                    $sheet1->setCellValue("A{$row}", date('m/d/Y')); // Date
                    $sheet1->setCellValue("B{$row}", $summaryData['beginOrNumber']); // Beginning SI/OR No.
                    $sheet1->setCellValue("C{$row}", $summaryData['endOrNumber']); // Ending SI/OR No.
                    $sheet1->setCellValue("D{$row}", $summaryData['grandBeginningBalance']); // Grand Accum. Sales Ending Balance
                    $sheet1->setCellValue("E{$row}", $summaryData['grandEndingBalance']); // Grand Accum. Beg. Balance
                    $sheet1->setCellValue("F{$row}", $summaryData['manualSalesInvoice']); // Manual Sales Invoice
                    $sheet1->setCellValue("G{$row}", $summaryData['grossSales']); // Gross Sales for the Day
                    $sheet1->setCellValue("H{$row}", $summaryData['vatableSales']); // VATable Sales
                    $sheet1->setCellValue("I{$row}", $summaryData['vatAmount']); // VAT Amount
                    $sheet1->setCellValue("J{$row}", $summaryData['zeroRated']); // Zero-Rated Sales
                    $sheet1->setCellValue("K{$row}", $summaryData['zeroRated']); // VAT-Exempt Sales

                    // Discounts and Deductions
                    $sheet1->setCellValue("L{$row}", $summaryData['seniorDiscount']); // Senior Discount
                    $sheet1->setCellValue("M{$row}", $summaryData['pwdDiscount']); // PWD Discount
                    $sheet1->setCellValue("N{$row}", $summaryData['naacDiscount']); // NAAC Discount
                    $sheet1->setCellValue("O{$row}", $summaryData['soloParentDiscount']); // Solo Parent Discount
                    $sheet1->setCellValue("P{$row}", $summaryData['otherDiscount']); // Other Discounts
                    $sheet1->setCellValue("Q{$row}", $summaryData['returnAmount']); // Returns
                    $sheet1->setCellValue("R{$row}", $summaryData['voidAmount']); // Voids
                    $sheet1->setCellValue("S{$row}", $summaryData['totalDeductions']); // Total Deductions

                    // VAT Adjustments
                    $sheet1->setCellValue("T{$row}", $summaryData['vatSenior']); // VAT Senior
                    $sheet1->setCellValue("U{$row}", $summaryData['vatPwd']); // VAT PWD
                    $sheet1->setCellValue("V{$row}", $summaryData['vatOthers']); // VAT Others
                    $sheet1->setCellValue("W{$row}", $summaryData['vatReturns']); // VAT on Returns
                    $sheet1->setCellValue("X{$row}", $summaryData['vatOthers']); // VAT on Others
                    $sheet1->setCellValue("Y{$row}", $summaryData['totalVatAdjustment']); // Total VAT Adjustment

                    // Additional Summary
                    $sheet1->setCellValue("Z{$row}", $summaryData['vatPayable']); // VAT Payable
                    $sheet1->setCellValue("AA{$row}", $summaryData['netSales']); // Net Sales
                    $sheet1->setCellValue("AB{$row}", $summaryData['salesOverflow']); // Sales Overflow
                    $sheet1->setCellValue("AC{$row}", $summaryData['totalIncome']); // Total Income
                    $sheet1->setCellValue("AD{$row}", $summaryData['zCounter']); // Reset Counter
                    $sheet1->setCellValue("AE{$row}", $summaryData['zCounter']); // Z-Counter
                    $sheet1->setCellValue("AF{$row}", $summaryData['remarks']); // Remarks


                    // Adjust formatting as needed
                    $sheet1->getStyle("A{$row}:AF{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet1->getStyle("A{$row}:AF{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


                    $sheet1->getStyle('B13:AF16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);

                    // ==================================================== E2 ====================================================

                    $spreadsheet->createSheet()->setTitle("E-2");
                    $spreadsheet->setActiveSheetIndexByName('E-2');
                    $sheetE2 = $spreadsheet->getActiveSheet();
                    $sheetE2->getColumnDimension('A')->setWidth(9.10);
                    $sheetE2->getColumnDimension('B')->setWidth(22.10);

                    $sheetE2->mergeCells('A1:K1');
                    $sheetE2->setCellValue('A1', $taxPayer['name']);
                    $sheetE2->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE2->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE2->mergeCells('A2:K2');
                    $sheetE2->setCellValue('A2', $taxPayer['address']);
                    $sheetE2->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE2->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE2->mergeCells('A3:K3');
                    $sheetE2->setCellValue('A3', $taxPayer['TIN']);
                    $sheetE2->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE2->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE2->setCellValue('A5', $software);
                    $sheetE2->setCellValue('A6', $ptuData['serial']);
                    $sheetE2->setCellValue('A7', $taxPayer['MIN']);
                    $sheetE2->setCellValue('A8', 'TRM00' . $trmId);
                    $sheetE2->setCellValue('A9', $currentDateTime);
                    $sheetE2->setCellValue('A10', $user_id);

                    // Merge each row individually and set text alignment to left
                    for ($row = 5; $row <= 10; $row++) {
                        $sheetE2->mergeCells("A{$row}:B{$row}");
                        $sheetE2->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    $sheetE2->mergeCells('A12:K12');
                    $sheetE2->getStyle('A12:K12')->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM);
                    $sheetE2->getStyle('A13:K12')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
                    $sheetE2->setCellValue('A12', 'Senior Citizen Sales Book/Report');
                    $sheetE2->getStyle('A12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE2->getStyle('A12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheetE2->getRowDimension(12)->setRowHeight(21);
                    $sheetE2->getStyle('A12')->getFont()->setBold(true);
                    $sheetE2->getStyle('A12')->getFont()->setSize(16);
                    $sheetE2->getRowDimension(14)->setRowHeight(22.80);

                    $sheetE2->mergeCells('A13:A14');
                    $sheetE2->setCellValue('A13', 'Date');
                    $sheetE2->getStyle('A13')->getAlignment()->setWrapText(true);

                    $sheetE2->mergeCells('B13:B14');
                    $sheetE2->setCellValue('B13', 'Name of Senior Citizen (SC)');

                    $sheetE2->mergeCells('C13:C14');
                    $sheetE2->setCellValue('C13', 'OSCA ID No./ SC ID No.');

                    $sheetE2->mergeCells('D13:D14');
                    $sheetE2->setCellValue('D13', 'SC TIN');

                    $sheetE2->mergeCells('E13:E14');
                    $sheetE2->setCellValue('E13', 'SI/OR Number');

                    $sheetE2->mergeCells('F13:F14');
                    $sheetE2->setCellValue('F13', 'Sales (inclusive of VAT)');

                    $sheetE2->mergeCells('G13:G14');
                    $sheetE2->setCellValue('G13', 'VAT Amount');

                    $sheetE2->mergeCells('H13:H14');
                    $sheetE2->setCellValue('H13', 'VAT Exempt Sales');

                    $sheetE2->mergeCells('I13:J13');
                    $sheetE2->setCellValue('I13', 'Discount');
                    $sheetE2->setCellValue('I14', '5%');
                    $sheetE2->setCellValue('J14', '20%');

                    $sheetE2->mergeCells('K13:K14');
                    $sheetE2->setCellValue('K13', 'Net Sales');

                    // Set column widths
                    $sheetE2->getColumnDimension('C')->setWidth(15);
                    $sheetE2->getColumnDimension('D')->setWidth(15);
                    $sheetE2->getColumnDimension('E')->setWidth(15);
                    $sheetE2->getColumnDimension('F')->setWidth(15);
                    $sheetE2->getColumnDimension('G')->setWidth(15);
                    $sheetE2->getColumnDimension('H')->setWidth(10);
                    $sheetE2->getColumnDimension('K')->setWidth(10);

                    // Merge each row individually and set text alignment to left for A5:A10, center for others
                    for ($row = 5; $row <= 10; $row++) {
                        $sheetE2->mergeCells("A{$row}:B{$row}");

                        // Left-align text in column A (A5:A10)
                        if ($row >= 5 && $row <= 10) {
                            $sheetE2->getStyle("A{$row}:B{$row}")
                                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                                ->setVertical(Alignment::VERTICAL_CENTER)
                                ->setWrapText(true);
                        }
                    }

                    // Header rows for table in sheetE2 with specified colors
                    $header = [
                        ['column' => 'A', 'value' => 'Date', 'bgColor' => 'CCCCCC'],
                        ['column' => 'B', 'value' => 'Name of Senior Citizen (SC)', 'bgColor' => '00B0F0'],
                        ['column' => 'C', 'value' => 'OSCA ID No./ SC ID No.', 'bgColor' => 'FFFF00'],
                        ['column' => 'D', 'value' => 'SC TIN', 'bgColor' => '9999FF'],
                        ['column' => 'E', 'value' => 'SI/OR Number', 'bgColor' => 'FFA500'],
                        ['column' => 'F', 'value' => 'Sales (inclusive of VAT)', 'bgColor' => '92D050'],
                        ['column' => 'G', 'value' => 'VAT Amount', 'bgColor' => 'ED7D31'],
                        ['column' => 'H', 'value' => 'VAT Exempt Sales', 'bgColor' => 'D9D9D9'],
                        ['column' => 'I', 'value' => 'Discount', 'bgColor' => 'FFD966', 'merge' => 'I13:J13'],
                        ['column' => 'K', 'value' => 'Net Sales', 'bgColor' => 'A6A6A6'],
                    ];

                    foreach ($header as $head) {
                        $col = $head['column'];
                        $merge = $head['merge'] ?? null;

                        if ($merge) {
                            $sheetE2->mergeCells($merge);
                            $sheetE2->setCellValue($col . '13', $head['value']);
                        } else {
                            $sheetE2->mergeCells("{$col}13:{$col}14");
                            $sheetE2->setCellValue("{$col}13", $head['value']);
                        }

                        // Apply styles
                        $sheetE2->getStyle("{$col}13:{$col}14")->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::VERTICAL_CENTER)
                            ->setWrapText(true);
                        $sheetE2->getStyle("{$col}13:{$col}14")->getFont()->setBold(true);
                        $sheetE2->getStyle("{$col}13:{$col}14")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB($head['bgColor']);

                        // Add borders for columns with background color
                        $sheetE2->getStyle("{$col}13:{$col}14")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    }

                    // Additional settings for merged Discount columns
                    $sheetE2->mergeCells('I14:I14');
                    $sheetE2->setCellValue('I14', '5%');
                    $sheetE2->getStyle('I14')->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);
                    $sheetE2->getStyle('I14')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFD966');

                    $sheetE2->mergeCells('J14:J14');
                    $sheetE2->setCellValue('J14', '20%');
                    $sheetE2->getStyle('J14')->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);
                    $sheetE2->getStyle('J14')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFD966');

                    $sheetE2->getRowDimension(14)->setRowHeight(45);

                    // Add borders for merged Discount columns
                    $sheetE2->getStyle('I14:J14')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    // Add title row border
                    $sheetE2->getStyle('A12:K12')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $rowNumber = 15;


                    foreach($seniorsReport as $d){
                        $sheetE2->setCellValue('A' . $rowNumber, date('m/d/Y')); // Date
                        $sheetE2->setCellValue('B' . $rowNumber, $d['name']);
                        $sheetE2->setCellValue('C' . $rowNumber, $d['id_number']);
                        $sheetE2->setCellValue('D' . $rowNumber, $d['tin_id']);
                        $sheetE2->setCellValue('E' . $rowNumber, $d['ornumber']);
                        $sheetE2->setCellValue('F' . $rowNumber, $d['vat_exempt']);
                        $sheetE2->setCellValue('G' . $rowNumber, $d['vat']);
                        $sheetE2->setCellValue('H' . $rowNumber, $d['vat_exempt']);
                        $sheetE2->setCellValue('J' . $rowNumber, $d['discount']);
                        $sheetE2->setCellValue('K' . $rowNumber, $d['earned_amount']);
                        $rowNumber++;
                    }
                    
                    
                    // foreach ($joinedResult as $data) {
                    //     $sheetE2->setCellValue('A' . $rowNumber, date('m/d/Y')); // Date
                    //     $sheetE2->setCellValue('B' . $rowNumber, $data['customer_name']);  // Customer Name
                    //     $sheetE2->setCellValue('C' . $rowNumber, $data['id_number']);  // Customer Name
                    //     $sheetE2->setCellValue('D' . $rowNumber, $data['tin_id']);  // Customer Name
                    //     $sheetE2->setCellValue('E' . $rowNumber, $data['ornumber']);  // Customer Name

                    //     $sheetE2->setCellValue('F' . $rowNumber, $data['earned_amount']);  // Customer Name
                    //     $sheetE2->setCellValue('G' . $rowNumber, $data['vat']);  // Customer Name
                    //     $sheetE2->setCellValue('H' . $rowNumber, $data['vat_exempt']);  // Customer Name
                    //     $sheetE2->setCellValue('K' . $rowNumber, $data['new_sales']);  // Customer Name
                    //     $rowNumber++;
                    // }




                    // ==================================================== E3 ====================================================

                    // E3 Beginning
                    $spreadsheet->createSheet()->setTitle("E-3");
                    $spreadsheet->setActiveSheetIndexByName('E-3');
                    $sheetE3 = $spreadsheet->getActiveSheet();

                    // Header content
                    $sheetE3->mergeCells('A1:K1');
                    $sheetE3->setCellValue('A1', $taxPayer['name']);
                    $sheetE3->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE3->mergeCells('A2:K2');
                    $sheetE3->setCellValue('A2', $taxPayer['address']);
                    $sheetE3->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE3->mergeCells('A3:K3');
                    $sheetE3->setCellValue('A3', $taxPayer['TIN']);
                    $sheetE3->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    // Additional rows
                    $sheetE3->setCellValue('A5', $software);
                    $sheetE3->setCellValue('A6', $ptuData['serial']);
                    $sheetE3->setCellValue('A7', $taxPayer['MIN']);
                    $sheetE3->setCellValue('A8', 'TRM00' . $trmId);
                    $sheetE3->setCellValue('A9', $currentDateTime);
                    $sheetE3->setCellValue('A10', $user_id);

                    // Merge each row individually and set text alignment to left
                    for ($row = 5; $row <= 10; $row++) {
                        $sheetE3->mergeCells("A{$row}:B{$row}");
                        $sheetE3->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    // Ensure alignment and wrapping for all cells in the header
                    $rows = ['A1', 'A2', 'A3'];
                    foreach ($rows as $row) {
                        $sheetE3->getStyle($row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheetE3->getStyle($row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $sheetE3->getStyle($row)->getAlignment()->setWrapText(true);
                    }

                    // Add space between UserID and the title (insert empty row 12)
                    $sheetE3->setCellValue('A12', '');  // Empty row for space

                    // Add title for the report (adjusted to row 13)
                    $sheetE3->mergeCells('A13:K13');
                    $sheetE3->setCellValue('A13', 'Persons with Disability Sales Book/Report');
                    $sheetE3->getStyle('A13')->getFont()->setBold(true)->setSize(16);  // Font size 16
                    $sheetE3->getStyle('A13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('A13')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    // Set column widths
                    $sheetE3->getColumnDimension('B')->setWidth(20); // B13:14 width 20
                    $sheetE3->getColumnDimension('C')->setWidth(14); // C to H width 14
                    $sheetE3->getColumnDimension('D')->setWidth(14);
                    $sheetE3->getColumnDimension('E')->setWidth(14);
                    $sheetE3->getColumnDimension('F')->setWidth(14);
                    $sheetE3->getColumnDimension('G')->setWidth(14);
                    $sheetE3->getColumnDimension('H')->setWidth(14);
                    $sheetE3->getColumnDimension('K')->setWidth(14); // K width 14

                    // Create header rows with specified formatting (adjusted to start from row 14)
                    $header = [
                        ['column' => 'A', 'value' => 'Date', 'bgColor' => 'CCCCCC'], // Grey
                        ['column' => 'B', 'value' => 'Name of Person with Disability', 'bgColor' => '00B0F0'], // Light blue
                        ['column' => 'C', 'value' => 'PWD ID No.', 'bgColor' => 'FFFF00'], // Yellow
                        ['column' => 'D', 'value' => 'PWD TIN', 'bgColor' => '9999FF'], // Purple
                        ['column' => 'E', 'value' => 'SI/OR Number', 'bgColor' => 'FFA500'], // Orange
                        ['column' => 'F', 'value' => 'Sales (Inclusive of VAT)', 'bgColor' => '92D050'], // Light green
                        ['column' => 'G', 'value' => 'VAT Amount', 'bgColor' => 'ED7D31'], // Orange Accent 2
                        ['column' => 'H', 'value' => 'VAT Exempt Sales', 'bgColor' => 'D9D9D9'], // Gray 25%
                        ['column' => 'I', 'value' => 'Discount', 'bgColor' => 'FFD966', 'merge' => 'I14:J14'], // Gold Accent 4 lighter 40%
                        ['column' => 'K', 'value' => 'Net Sales', 'bgColor' => 'A6A6A6'], // White bg 1 darker 35%
                    ];

                    foreach ($header as $head) {
                        $col = $head['column'];
                        $merge = $head['merge'] ?? null;

                        if ($merge) {
                            $sheetE3->mergeCells($merge);
                            $sheetE3->setCellValue($col . '14', $head['value']);  // Adjusted to row 14
                        } else {
                            $sheetE3->mergeCells("{$col}14:{$col}17");  // Adjusted to rows 14-17
                            $sheetE3->setCellValue("{$col}14", $head['value']);
                        }

                        // Apply styles
                        $sheetE3->getStyle("{$col}14:{$col}17")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheetE3->getStyle("{$col}14:{$col}17")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $sheetE3->getStyle("{$col}14:{$col}17")->getAlignment()->setWrapText(true);
                        $sheetE3->getStyle("{$col}14:{$col}17")->getFont()->setBold(true);
                        $sheetE3->getStyle("{$col}14:{$col}17")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB($head['bgColor']);

                        // Add borders for columns with background color
                        $sheetE3->getStyle("{$col}14:{$col}17")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    }

                    // Additional settings for merged Discount columns (adjusted to rows 15-17)
                    $sheetE3->mergeCells('I15:I17');
                    $sheetE3->setCellValue('I15', '5%');
                    $sheetE3->getStyle('I15:I17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('I15:I17')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheetE3->getStyle('I15:I17')->getAlignment()->setWrapText(true);
                    $sheetE3->getStyle('I15:I17')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFD966');

                    $sheetE3->mergeCells('J15:J17');
                    $sheetE3->setCellValue('J15', '20%');
                    $sheetE3->getStyle('J15:J17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE3->getStyle('J15:J17')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheetE3->getStyle('J15:J17')->getAlignment()->setWrapText(true);
                    $sheetE3->getStyle('J15:J17')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFD966');

                    // Add borders for the merged discount columns
                    // Add borders for the title row (A13:K13)
                    $sheetE3->getStyle('I15:J17')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $sheetE3->getStyle('A13:K13')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $rowNumber = 18;


                    foreach($pwdReport as $d){
                        $sheetE3->setCellValue('A' . $rowNumber, date('m/d/Y')); // Date
                        $sheetE3->setCellValue('B' . $rowNumber, $d['name']);
                        $sheetE3->setCellValue('C' . $rowNumber, $d['id_number']);
                        $sheetE3->setCellValue('D' . $rowNumber, $d['tin_id']);
                        $sheetE3->setCellValue('E' . $rowNumber, $d['ornumber']);
                        $sheetE3->setCellValue('F' . $rowNumber, $d['vat_exempt']);
                        $sheetE3->setCellValue('G' . $rowNumber, $d['vat']);
                        $sheetE3->setCellValue('H' . $rowNumber, $d['vat_exempt']);
                        $sheetE3->setCellValue('J' . $rowNumber, $d['discount']);
                        $sheetE3->setCellValue('K' . $rowNumber, $d['earned_amount']);
                        $rowNumber++;
                    }
                    // ==================================================== E4 ====================================================

                    $spreadsheet->createSheet()->setTitle("E-4");
                    $spreadsheet->setActiveSheetIndexByName('E-4');
                    $sheetE4 = $spreadsheet->getActiveSheet();

                    // Header content
                    $sheetE4->mergeCells('A1:G1');
                    $sheetE4->setCellValue('A1', $taxPayer['name']);
                    $sheetE4->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE4->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE4->mergeCells('A2:G2');
                    $sheetE4->setCellValue('A2', $taxPayer['address']);
                    $sheetE4->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE4->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE4->mergeCells('A3:G3');
                    $sheetE4->setCellValue('A3', $taxPayer['TIN']);
                    $sheetE4->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE4->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    // Additional rows (same as in E-3)
                    $sheetE4->setCellValue('A5', $software);
                    $sheetE4->setCellValue('A6', $ptuData['serial']);
                    $sheetE4->setCellValue('A7', $taxPayer['MIN']);
                    $sheetE4->setCellValue('A8', 'TRM00' . $trmId);
                    $sheetE4->setCellValue('A9', $currentDateTime);
                    $sheetE4->setCellValue('A10', $user_id);

                    // Merge each row individually (A5 to A10) but don't apply centering alignment
                    for ($row = 5; $row <= 10; $row++) {
                        $sheetE4->mergeCells("A{$row}:B{$row}");

                        // Apply left alignment for A5 to A10
                        $sheetE4->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                        $sheetE4->getStyle("A{$row}:B{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    }


                    // Add space between UserID and title (Row 11 will be shifted to Row 12)
                    $sheetE4->setCellValue('A11', '');  // Empty row for space

                    // Title for the report (with adjusted style, now on Row 12)
                    $sheetE4->mergeCells('A12:G12');
                    $sheetE4->setCellValue('A12', 'National Athletes and Coaches Sales Book/Report');
                    $sheetE4->getStyle('A12')->getFont()->setBold(true)->setSize(16);  // Font size 16
                    $sheetE4->getStyle('A12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE4->getStyle('A12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    // Apply border to the title cell (A12:G12)
                    $sheetE4->getStyle('A12:G12')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    // Create header rows with specified formatting for columns A to G (now starting from row 13)
                    $header = [
                        ['column' => 'A', 'value' => 'Date', 'bgColor' => 'CCCCCC'], // White
                        ['column' => 'B', 'value' => 'National Athletes and Coaches Sales Book/Report', 'bgColor' => '00B0F0'], // Light Blue
                        ['column' => 'C', 'value' => 'PNSTM ID No.', 'bgColor' => 'FFFF00'], // Yellow
                        ['column' => 'D', 'value' => 'SI/OR Number', 'bgColor' => 'FFA500'], // Orange
                        ['column' => 'E', 'value' => 'Gross Sales/Receipts', 'bgColor' => '92D050'], // Light Green
                        ['column' => 'F', 'value' => 'Sales Discount', 'bgColor' => 'ED7D31'], // Gold Accent 4 Lighter 40%
                        ['column' => 'G', 'value' => 'Net Sales', 'bgColor' => 'A6A6A6'], // White (background 1, darker 35%)
                    ];

                    // Apply header cells starting from row 13
                    foreach ($header as $head) {
                        $col = $head['column'];
                        $sheetE4->mergeCells("{$col}13:{$col}15");
                        $sheetE4->setCellValue("{$col}13", $head['value']);

                        // Apply styles for centering the text horizontally and vertically
                        $sheetE4->getStyle("{$col}13:{$col}15")->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)  // Center horizontally
                            ->setVertical(Alignment::VERTICAL_CENTER);     // Center vertically

                        $sheetE4->getStyle("{$col}13:{$col}15")->getAlignment()->setWrapText(true);
                        $sheetE4->getStyle("{$col}13:{$col}15")->getFont()->setBold(true);
                        $sheetE4->getStyle("{$col}13:{$col}15")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB($head['bgColor']);

                        // Add borders for columns with background color
                        $sheetE4->getStyle("{$col}13:{$col}15")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    }

                    // Set column widths for columns A to G
                    $sheetE4->getColumnDimension('A')->setWidth(25);
                    $sheetE4->getColumnDimension('B')->setWidth(25);
                    $sheetE4->getColumnDimension('C')->setWidth(25);
                    $sheetE4->getColumnDimension('D')->setWidth(25);
                    $sheetE4->getColumnDimension('E')->setWidth(25);
                    $sheetE4->getColumnDimension('F')->setWidth(25);
                    $sheetE4->getColumnDimension('G')->setWidth(25);

                    $rowNumber = 16;

                    foreach($naacReport as $d){
                        $sheetE4->setCellValue('A' . $rowNumber, date('m/d/Y')); // Date
                        $sheetE4->setCellValue('B' . $rowNumber, $d['name']);
                        $sheetE4->setCellValue('C' . $rowNumber, $d['id_number']);
                        $sheetE4->setCellValue('D' . $rowNumber, $d['ornumber']);
                        $sheetE4->setCellValue('E' . $rowNumber, $d['amount']);
                        $sheetE4->setCellValue('F' . $rowNumber, $d['discount']);
                        $sheetE4->setCellValue('G' . $rowNumber, $d['earned_amount']);
                        $rowNumber++;
                    }

                    // ==================================================== E5 ====================================================
                    // E5 Beginning
                    $spreadsheet->createSheet()->setTitle("E-5");
                    $spreadsheet->setActiveSheetIndexByName('E-5');
                    $sheetE5 = $spreadsheet->getActiveSheet();

                    // Header content
                    $sheetE5->mergeCells('A1:K1');
                    $sheetE5->setCellValue('A1', $taxPayer['name']);
                    $sheetE5->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE5->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE5->mergeCells('A2:K2');
                    $sheetE5->setCellValue('A2', $taxPayer['address']);
                    $sheetE5->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE5->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE5->mergeCells('A3:K3');
                    $sheetE5->setCellValue('A3', $taxPayer['TIN']);
                    $sheetE5->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE5->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    // Additional rows (same as in E-4)
                    $sheetE5->setCellValue('A5', $software);
                    $sheetE5->setCellValue('A6', $ptuData['serial']);
                    $sheetE5->setCellValue('A7', $taxPayer['MIN']);
                    $sheetE5->setCellValue('A8', 'TRM00' . $trmId);
                    $sheetE5->setCellValue('A9', $currentDateTime);
                    $sheetE5->setCellValue('A10', $user_id);

                    // Merge each row individually and set text alignment to left
                    for ($row = 5; $row <= 10; $row++) {
                        $sheetE5->mergeCells("A{$row}:B{$row}");
                        $sheetE5->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
                    }

                    // Add space between UserID and title
                    $sheetE5->setCellValue('A11', '');  // Empty row for space

                    // Title for the report (adjusted to row 12)
                    $sheetE5->mergeCells('A12:K12');
                    $sheetE5->setCellValue('A12', 'Solo Parent Sales Book/Report');
                    $sheetE5->getStyle('A12')->getFont()->setBold(true)->setSize(16);  // Font size 16
                    $sheetE5->getStyle('A12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheetE5->getStyle('A12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $sheetE5->getStyle('A12:K12')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    // Set column widths for A through K to 15
                    foreach (range('A', 'K') as $col) {
                        $sheetE5->getColumnDimension($col)->setWidth(15);
                    }

                    // Merging cells for the header columns (A13 to K16)
                    $header = [
                        ['column' => 'A', 'value' => 'Date', 'bgColor' => '808080'], // Grey
                        ['column' => 'B', 'value' => 'Name of Solo Parent', 'bgColor' => 'ED7D31'], // RGB(237, 125, 49) => Hex: ED7D31
                        ['column' => 'C', 'value' => 'SPIC No.', 'bgColor' => 'FFA500'], // Orange
                        ['column' => 'D', 'value' => 'Name of Child', 'bgColor' => 'FFFF00'], // Yellow
                        ['column' => 'E', 'value' => 'Birth Date of Child', 'bgColor' => 'FFFF00'], // Yellow
                        ['column' => 'F', 'value' => 'Age of Child', 'bgColor' => 'FFFF00'], // Yellow
                        ['column' => 'G', 'value' => 'SI/OR Number', 'bgColor' => '90EE90'], // Green
                        ['column' => 'H', 'value' => 'Gross Sales', 'bgColor' => 'ADD8E6'], // Light Blue
                        ['column' => 'I', 'value' => 'Discount', 'bgColor' => '9999FF'], // RGB(153, 153, 255) => Hex: 9999FF
                        ['column' => 'K', 'value' => 'Net Sales', 'bgColor' => 'FF66FF'], // RGB(255, 102, 255) => Hex: FF66FF
                    ];

                    // Apply header cells starting from row 13
                    foreach ($header as $head) {
                        $col = $head['column'];
                        // Special merge for Discount (Columns I and J)
                        if ($col == 'I') {
                            $sheetE5->mergeCells('I13:J16');
                            $sheetE5->setCellValue('I13', $head['value']);
                        } elseif ($col == 'K') {
                            $sheetE5->mergeCells('K13:K16');
                            $sheetE5->setCellValue('K13', $head['value']);
                        } else {
                            $sheetE5->mergeCells("{$col}13:{$col}16");
                            $sheetE5->setCellValue("{$col}13", $head['value']);
                        }

                        // Apply styles
                        $sheetE5->getStyle("{$col}13:{$col}16")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheetE5->getStyle("{$col}13:{$col}16")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $sheetE5->getStyle("{$col}13:{$col}16")->getAlignment()->setWrapText(true);
                        $sheetE5->getStyle("{$col}13:{$col}16")->getFont()->setBold(true);
                        $sheetE5->getStyle("{$col}13:{$col}16")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB($head['bgColor']);

                        // Add borders for columns with background color
                        $sheetE5->getStyle("{$col}13:{$col}16")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    }

                    // Empty Rows D16, E16, F16 with Purple Background
                    $sheetE5->getStyle('D16:F16')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('800080'); // Purple

                    // Optional: Reset previous formatting for the "Discount" and check for merge consistency
                    $sheetE5->getStyle('I13:J16')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $rowNumber = 17;

                    foreach($soloparentReport as $d){
                        $sheetE5->setCellValue('A' . $rowNumber, date('m/d/Y')); // Date
                        $sheetE5->setCellValue('B' . $rowNumber, $d['name']);
                        $sheetE5->setCellValue('C' . $rowNumber, $d['id_number']);
                        $sheetE5->setCellValue('D' . $rowNumber, $d['child_name']);
                        $sheetE5->setCellValue('E' . $rowNumber, $d['child_dob']);
                        $sheetE5->setCellValue('F' . $rowNumber, $d['child_age']);
                        $sheetE5->setCellValue('G' . $rowNumber, $d['ornumber']);
                        $sheetE5->setCellValue('H' . $rowNumber, $d['amount']);
                        $sheetE5->setCellValue('J' . $rowNumber, $d['discount']);
                        $sheetE5->setCellValue('K' . $rowNumber, $d['earned_amount']);
                        $rowNumber++;
                    }


                    $spreadsheet->setActiveSheetIndex(0);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="multisheet_example.xlsx"');
                    header('Cache-Control: max-age=0');

                    $writer = new Xlsx($spreadsheet);
                    $writer->save('php://output'); // Send the file to the browser
                    exit;
                } catch (Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                }

                print_r($summaryData);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
    
    
    public function testStatus(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {

                $type = $this->input->get('status');
                IF($type == "S"){
                    echo "Success";
                }else if($type == "SF"){
                    $this->render_template('pos/server_failed');
                }else{
                    echo "No status";
                }
                $this->load->view('templates/header');
                // $this->render_template('pos/server_failed', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }


    public function testDiscountMethod(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {

                $seniorsReport = $this->model_touchpoint->getSeniorCitizenReport();
                $pwdReport = $this->model_touchpoint->getPwdReport();
                $naacReport = $this->model_touchpoint->getNaacReport();
                $soloparentReport = $this->model_touchpoint->getSoloParentReport();
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($soloparentReport));
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }
}
