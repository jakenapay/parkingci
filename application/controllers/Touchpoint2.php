<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
class Touchpoint extends Admin_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model("model_users");
        $this->load->model("model_touchpoint");
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
                $amount = $this->input->post("parking_amount");
                $discountType = $this->input->post('discount_type');

                $totalSales = 0;
                $nonVat = 0;

                if ($discountType == "none") {
                    $vatRate = 1.12;
                    $vatableSale = $amount / $vatRate;
                    $vatExempt = 0;
                    $totalSales = $vatableSale;
                    $totalVat = $vatableSale * 0.12;
                    $totalAmountDue = $amount;
                    $discount = 0;
                    $nonVat = 0;
                } else {
                    $discountCode = $this->input->post('discount_type');
                    $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                    $discountPercentage = $discounts['percentage'];

                    $vatRate = 1.12;
                    $vatableSale = $amount / $vatRate;
                    $discount = $vatableSale * ($discountPercentage / 100);

                    $vatExempt = $discount > 0 ? $vatableSale * 0.12 : 0;
                    $nonVatSales = $vatableSale - $discount;

                    $nonVat = $discount > 0 ? $nonVatSales : 0;
                    $totalSales = $nonVat;
                    $totalVat = 0.00;
                    $totalAmountDue = $nonVat;
                }
                $details['totalSales'] = $totalSales;
                $this->data['details'] = $details;
                $this->render_template("pos/paymode", $this->data);


                // Additional output values for debugging
                // echo "Original Rate: " . $amount . " pesos\n";
                // echo "Vatable Sale: " . $vatableSale . "\n";
                // echo "Non-vat Sales: " . $nonVat . "\n";
                // echo "Total Sales: " . $totalSales . "\n";
                // echo "Total VAT: " . $totalVat . "\n";
                // echo "Total amount due: " . $totalAmountDue . "\n";
                // echo "Total Discount: " . $discount . "\n";
                // echo "VAT Exemption: " . $vatExempt . "\n";

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
                    $amount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
    
                    $totalSales = 0;
                    $nonVat = 0;
    
                    if ($discountType == "none") {
                        $vatRate = 1.12;
                        $vatableSale = $amount / $vatRate;
                        $vatExempt = 0;
                        $totalSales = $vatableSale;
                        $totalVat = $vatableSale * 0.12;
                        $totalAmountDue = $amount;
                        $discount = 0;
                        $nonVat = 0;
                    } else {
                        $discountCode = $this->input->post('discount_type');
                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                        $discountPercentage = $discounts['percentage'];
    
                        $vatRate = 1.12;
                        $vatableSale = $amount / $vatRate;
                        $discount = $vatableSale * ($discountPercentage / 100);
    
                        $vatExempt = $discount > 0 ? $vatableSale * 0.12 : 0;
                        $nonVatSales = $vatableSale - $discount;
    
                        $nonVat = $discount > 0 ? $nonVatSales : 0;
                        $totalSales = $nonVat;
                        $totalVat = 0.00;
                        $totalAmountDue = $nonVat;
                    }
                    $remaining = $cashDrawer['remaining'];

                    $details['totalSales'] = $totalSales;
                    $this->data['details'] = $details;
                    $this->render_template("pos/cash_payment", $this->data);
                }else if($paymode== "GCash" || $paymode == "Paymaya"){
                    $vehicleId = $this->input->post("vehicleClass");
                    $amount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
    
                    $totalSales = 0;
                    $nonVat = 0;
    
                    if ($discountType == "none") {
                        $vatRate = 1.12;
                        $vatableSale = $amount / $vatRate;
                        $vatExempt = 0;
                        $totalSales = $vatableSale;
                        $totalVat = $vatableSale * 0.12;
                        $totalAmountDue = $amount;
                        $discount = 0;
                        $nonVat = 0;
                    } else {
                        $discountCode = $this->input->post('discount_type');
                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                        $discountPercentage = $discounts['percentage'];
    
                        $vatRate = 1.12;
                        $vatableSale = $amount / $vatRate;
                        $discount = $vatableSale * ($discountPercentage / 100);
    
                        $vatExempt = $discount > 0 ? $vatableSale * 0.12 : 0;
                        $nonVatSales = $vatableSale - $discount;
    
                        $nonVat = $discount > 0 ? $nonVatSales : 0;
                        $totalSales = $nonVat;
                        $totalVat = 0.00;
                        $totalAmountDue = $nonVat;
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
                                // Handle the success response
                                // echo "Transaction was successful!";
                                // echo "Merchant ID: " . $decodedResponse['MerchantID'] . "<br>";
                                // echo "Amount: " . $decodedResponse['Amount'] . "<br>";
                                // echo "QR Code URL: " . $decodedResponse['CodeImgUrl'] . "<br>";
                                // echo "QR Code Data: " . $decodedResponse['CodeUrl'] . "<br>";

                                $codeUrl = $decodedResponse['CodeUrl'];

                                // echo $codeUrl
                            } else {
                                // Handle the failed response
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
                    $details['totalSales'] = $totalSales;
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
            redirect('auth/login'); // Adjust the URL based on your application structure
        }
    }

    public function processTransaction(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        
        if ($position['id'] == 5) {
            $terminalId = 2;
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
                        $amount = $this->input->post("parking_amount");
                        $discountType = $this->input->post('discount_type');
    
                        $totalSales = 0;
                            $nonVatSales = 0;

                            if ($discountType == "none") {
                                $vatRate = 1.12;
                                $vatableSale = $amount / $vatRate; // Vatable sale amount
                                $vatExempt = 0;                    // No VAT exempt sales in this case
                                $totalSales = $vatableSale;         // Total sales equals vatable sales
                                $totalVat = $amount - $vatableSale; // VAT amount is the difference between total and vatable
                                $totalAmountDue = $amount;          // Total amount due equals original amount
                                $discount = 0;                      // No discount applied
                                $nonVat = 0;                        // Non-VAT sales is zero
                            } else {
                                // For cases where a discount is applied (already adjusted in previous solution)
                                $discountCode = $this->input->post('discount_type');
                                $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                                $discountPercentage = $discounts['percentage'];

                                $vatableSale = 0;                   // No VAT for discounted transactions
                                $vatExempt = 6.43;                  // Assigned VAT-exempt sales
                                $originalSale = $amount / 1.12;     // Calculate original sale excluding VAT
                                $discount = $originalSale * ($discountPercentage / 100);

                                $nonVatSales = $originalSale - $discount;
                                $nonVat = $nonVatSales;

                                $totalSales = $nonVat;
                                $totalAmountDue = $nonVatSales;
                                $totalVat = 0.00;                   // No VAT for discounted sale
                                $totalAmountDue = $nonVat + $vatExempt; // Total due is non-VAT sales plus VAT-exempt
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
                            'cash_received' => $cashReceived,
                            'change' => $changeAmount,
                            'discount_type' => $this->input->post("discount_type"),
                            'discount' => $discount,
                            'vat_exempt' => $vatExempt,
                            'vat' => $totalVat,
                            'vatable_sales' => $vatableSale,
                            'zero_rated' => 0,
                            'transact_status' => 1,
                            'non_vat' => $nonVat,
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
                            $receipt = array(
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
                                'discount' => $discount,
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
                            $amount = $this->input->post("parking_amount");
                            $discountType = $this->input->post('discount_type');
    
                            $totalSales = 0;
                            $nonVatSales = 0;

                            if ($discountType == "none") {
                                $vatRate = 1.12;
                                $vatableSale = $amount / $vatRate; // Vatable sale amount
                                $vatExempt = 0;                    // No VAT exempt sales in this case
                                $totalSales = $vatableSale;         // Total sales equals vatable sales
                                $totalVat = $amount - $vatableSale; // VAT amount is the difference between total and vatable
                                $totalAmountDue = $amount;          // Total amount due equals original amount
                                $discount = 0;                      // No discount applied
                                $nonVat = 0;                        // Non-VAT sales is zero
                            } else {
                                // For cases where a discount is applied (already adjusted in previous solution)
                                $discountCode = $this->input->post('discount_type');
                                $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                                $discountPercentage = $discounts['percentage'];

                                $vatableSale = 0;                   // No VAT for discounted transactions
                                $vatExempt = 6.43;                  // Assigned VAT-exempt sales
                                $originalSale = $amount / 1.12;     // Calculate original sale excluding VAT
                                $discount = $originalSale * ($discountPercentage / 100);

                                $nonVatSales = $originalSale - $discount;
                                $nonVat = $nonVatSales;

                                $totalSales = $nonVat; // Total sales includes VAT-exempt amount
                                $totalAmountDue = $nonVat;
                                $totalVat = 0.00;                   // No VAT for discounted sale
                                $totalAmountDue = $nonVat + $vatExempt; // Total due is non-VAT sales plus VAT-exempt
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
                                'discount_type' => $this->input->post("discount_type"),
                                'discount' => $discount,
                                'vat_exempt' => $vatExempt,
                                'vatable_sales' => $vatableSale,
                                'zero_rated' => 0,
                                'vat' => $totalVat,
                                'transact_status' => 1,
                                'non_vat' => $nonVat,
                                'paymode' => $paymode,
                                'status' => 1
                            );
                            $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);

                            if($postTransaction){
                                $receipt = array(
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
                                    'vatAmount' => $totalVat,
                                    'vatExempt' => $vatExempt,
                                    'zeroRated' => 0,
                                    'cashReceived' => $cashReceived,
                                    'changeDue' => $changeAmount,
                                    'discount' => $discount,
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

                                print_r($details);
                            }
                        } else {
                            // Handle failure
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
                                $amount = $this->input->post("parking_amount");
                                $discountType = $this->input->post('discount_type');
            
                                $totalSales = 0;
                                    $nonVatSales = 0;
        
                                    if ($discountType == "none") {
                                        $vatRate = 1.12;
                                        $vatableSale = $amount / $vatRate; // Vatable sale amount
                                        $vatExempt = 0;                    // No VAT exempt sales in this case
                                        $totalSales = $vatableSale;         // Total sales equals vatable sales
                                        $totalVat = $amount - $vatableSale; // VAT amount is the difference between total and vatable
                                        $totalAmountDue = $amount;          // Total amount due equals original amount
                                        $discount = 0;                      // No discount applied
                                        $nonVat = 0;                        // Non-VAT sales is zero
                                    } else {
                                        // For cases where a discount is applied (already adjusted in previous solution)
                                        $discountCode = $this->input->post('discount_type');
                                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId);
                                        $discountPercentage = $discounts['percentage'];
        
                                        $vatableSale = 0;                   // No VAT for discounted transactions
                                        $vatExempt = 6.43;                  // Assigned VAT-exempt sales
                                        $originalSale = $amount / 1.12;     // Calculate original sale excluding VAT
                                        $discount = $originalSale * ($discountPercentage / 100);
        
                                        $nonVatSales = $originalSale - $discount;
                                        $nonVat = $nonVatSales;
        
                                        $totalSales = $nonVat;
                                        $totalAmountDue = $nonVatSales;
                                        $totalVat = 0.00;                   // No VAT for discounted sale
                                        $totalAmountDue = $nonVat + $vatExempt; // Total due is non-VAT sales plus VAT-exempt
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
                                    'discount' => $discount,
                                    'vat' => $totalVat,
                                    'vat_exempt' => $vatExempt,
                                    'vatable_sales' => $vatableSale,
                                    'zero_rated' => 0,
                                    'transact_status' => 1,
                                    'non_vat' => $nonVat,
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
                                    $receipt = array(
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
                                        'vatAmount' => $totalVat,
                                        'vatExempt' => $vatExempt,
                                        'zeroRated' => 0,
                                        'cashReceived' => 0,
                                        'changeDue' => 0,
                                        'discount' => $discount,
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
                print_r($data);
                $this->data['xreading'] = $data;
                $this->data['xreadingData'] = json_encode($data);
                // sprint_r($xreading);
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

                print_r($data);
                
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

                    $totalAmountd = $row['earned_amount'] + $row['vat'];
                    
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
    public function discountSummaryReport() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
    
            if ($cashDrawer) {
                $cashier_id = $this->input->post('cashier');
                $trmId = $this->input->post('terminal');
                $startDate = $this->input->post('start_date');
                $endDate = $this->input->post('end_date');
    
                $summaryData = $this->model_touchpoint->getDiscountsSummary($cashier_id, $trmId, $startDate, $endDate);
    
                try {
                    // Create a new Spreadsheet object
                    $spreadsheet = new Spreadsheet();
                
                    // Add data to E-1
                    $sheet1 = $spreadsheet->getActiveSheet();
                    $sheet1->setTitle('E-1');
                    $sheet1->mergeCells('A1:AF1')->setCellValue('A1', 'Name of Tax Payer');
                    $sheet1->mergeCells('A2:AF2')->setCellValue('A2', 'Address of Tax Payer');
                    $sheet1->mergeCells('A3:AF3')->setCellValue('A3', 'TIN');
                    $sheet1->getStyle('A1:AF3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                    $sheet1->setCellValue('A5', '<Software Name and Version No. plus Release No./Release Date>');
                    $sheet1->setCellValue('A6', '<Serial No.>');
                    $sheet1->setCellValue('A7', '<Machine Identification Number>');
                    $sheet1->setCellValue('A8', '<POS Terminal No.>');
                    $sheet1->setCellValue('A9', '<Date and Time Generated>');
                    $sheet1->setCellValue('A10', '<UserID>');
                    $sheet1->getRowDimension(12)->setRowHeight(21.60);
                
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
                    // Add data to E-2
                    $spreadsheet->createSheet();
                    $sheet2 = $spreadsheet->setActiveSheetIndex(1);
                    $sheet2->setTitle('E-2');
                    $sheet2->mergeCells('A1:K1')->setCellValue('A1', 'Name of Tax Payer');
                    $sheet2->mergeCells('A2:K2')->setCellValue('A2', 'Address of Tax Payer');
                    $sheet2->mergeCells('A3:K3')->setCellValue('A3', 'TIN');
                    $sheet2->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                    $sheet2->setCellValue('A5', '<Software Name and Version No. plus Release No./Release Date>');
                    $sheet2->setCellValue('A6', '<Serial No.>');
                    $sheet2->setCellValue('A7', '<Machine Identification Number>');
                    $sheet2->setCellValue('A8', '<POS Terminal No.>');
                    $sheet2->setCellValue('A9', '<Date and Time Generated>');
                    $sheet2->setCellValue('A10', '<UserID>');
                
                    // Add data to E-3
                    $spreadsheet->createSheet();
                    $sheet3 = $spreadsheet->setActiveSheetIndex(2);
                    $sheet3->setTitle('E-3');
                    $sheet3->mergeCells('A1:K1')->setCellValue('A1', 'Name of Tax Payer');
                    $sheet3->mergeCells('A2:K2')->setCellValue('A2', 'Address of Tax Payer');
                    $sheet3->mergeCells('A3:K3')->setCellValue('A3', 'TIN');
                    $sheet3->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                    $sheet3->setCellValue('A5', '<Software Name and Version No. plus Release No./Release Date>');
                    $sheet3->setCellValue('A6', '<Serial No.>');
                    $sheet3->setCellValue('A7', '<Machine Identification Number>');
                    $sheet3->setCellValue('A8', '<POS Terminal No.>');
                    $sheet3->setCellValue('A9', '<Date and Time Generated>');
                    $sheet3->setCellValue('A10', '<UserID>');
                
                    // Add data to E-4
                    $spreadsheet->createSheet();
                    $sheet4 = $spreadsheet->setActiveSheetIndex(3);
                    $sheet4->setTitle('E-4');
                    $sheet4->mergeCells('A1:K1')->setCellValue('A1', 'Name of Tax Payer');
                    $sheet4->mergeCells('A2:K2')->setCellValue('A2', 'Address of Tax Payer');
                    $sheet4->mergeCells('A3:K3')->setCellValue('A3', 'TIN');
                    $sheet4->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                    $sheet4->setCellValue('A5', '<Software Name and Version No. plus Release No./Release Date>');
                    $sheet4->setCellValue('A6', '<Serial No.>');
                    $sheet4->setCellValue('A7', '<Machine Identification Number>');
                    $sheet4->setCellValue('A8', '<POS Terminal No.>');
                    $sheet4->setCellValue('A9', '<Date and Time Generated>');
                    $sheet4->setCellValue('A10', '<UserID>');
                
                    // Add data to E-5
                    $spreadsheet->createSheet();
                    $sheet5 = $spreadsheet->setActiveSheetIndex(4);
                    $sheet5->setTitle('E-5');
                    $sheet5->mergeCells('A1:K1')->setCellValue('A1', 'Name of Tax Payer');
                    $sheet5->mergeCells('A2:K2')->setCellValue('A2', 'Address of Tax Payer');
                    $sheet5->mergeCells('A3:K3')->setCellValue('A3', 'TIN');
                    $sheet5->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                    $sheet5->setCellValue('A5', '<Software Name and Version No. plus Release No./Release Date>');
                    $sheet5->setCellValue('A6', '<Serial No.>');
                    $sheet5->setCellValue('A7', '<Machine Identification Number>');
                    $sheet5->setCellValue('A8', '<POS Terminal No.>');
                    $sheet5->setCellValue('A9', '<Date and Time Generated>');
                    $sheet5->setCellValue('A10', '<UserID>');
                
                    // Set Row height and merge cells for A12 to AF12 and add a header
                    $sheet5->getRowDimension(12)->setRowHeight(21.60);
                    $sheet5->mergeCells('A12:AF12')->setCellValue('A12', 'BIR SALES SUMMARY REPORT');
                    $sheet5->getStyle('A12:AF12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet5->getStyle('A12:AF12')->getFont()->setBold(true)->setSize(16);
                
                    // Merge and set headers in row 13 to 15
                    $sheet5->mergeCells('A13:A15')->setCellValue('A13', 'Date');
                    $sheet5->getColumnDimension('A')->setWidth(8.11);
                    $sheet5->getStyle('A13:A15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                    $sheet5->mergeCells('B13:B15')->setCellValue('B13', 'Name of National Athlete/Coach');
                    $sheet5->mergeCells('C13:C15')->setCellValue('C13', 'PNSTM ID No.');
                    $sheet5->mergeCells('D13:D15')->setCellValue('D13', 'SI / OR Number');
                    $sheet5->mergeCells('E13:E15')->setCellValue('E13', 'Gross Sales/Receipts');
                    $sheet5->mergeCells('F13:F15')->setCellValue('F13', 'Sales Discount');
                    $sheet5->mergeCells('G13:G15')->setCellValue('G13', 'Net Sales');
                    $sheet5->getStyle('A13:G15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet5->getStyle('A13:G15')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                    // Set the first sheet as the active one
                    $spreadsheet->setActiveSheetIndex(0);
                
                    // Trigger browser download
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
    
    
    
    
}