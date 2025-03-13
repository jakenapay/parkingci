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
                $details = array(
                    'id' => $record['id'],
                    'gate' => $record['GateId'],
                    'access_type' => $record['AccessType'],
                    'parking_code' => $record['parking_code'],
                    'entryTime' => $record['in_time'],
                    'paymentTime' => $checkoutTime,
                    'parkingTime' => $parkingTime,
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
                        print_r($details);
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
                    'entryTime' => $this->input->post("entryTime"),
                    'paymentTime' => $this->input->post("paymentTime"),
                    'parkingTime' => $this->input->post("parkingTime"),
                    'vehicleClass' => $this->input->post("vehicleClass"),
                    'parking_status' => $this->input->post("parking_status"),
                    'parking_amount' => $this->input->post("parking_amount"),
                    'pictureName' => $this->input->post("pictureName"),
                    'picturePath' => $this->input->post("picturePath"),
                    'discount' => $this->input->post("discount"),
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

                        $ratewithVat = $amount / $vatRate;

                        $discount = $ratewithVat * ($discountPercentage / 100);
                        // echo $discountAmount;
                        $totalBill = $ratewithVat - $discount;

                        $details['vat_amount'] = round($ratewithVat, 2);
                        $details['amount_due'] = round($totalBill, 2);
                        $details['discount_amount'] = round($discount, 2);
                        $this->data['details'] = $details;
                        $this->render_template("demo/cash_payment", $this->data);
                    }
                } else if ($paymode == "GCash" || $paymode == "Paymaya") {
                    $this->render_template("demo/ewallet_payment", $this->data);
                } else if ($paymode == "Complimentary") {
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
                    'discount' => $this->input->post("custname"),
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

                        $OR = $company['OR'] + 1;
                        $transactions = array (
                            'pid' => $terminalId,
                            'cashier_id' => $user_id,
                            'ornumber' => $OR,
                            'gate_en' => $this->input->post("gate"),
                            'access_type' => $this->input->post("access_type"),
                            'parking_code' => $this->input->post("parking_code"),
                            'vehicle_cat_id' => $this->input->post("vehicleClass"),
                            'rate_id' => 'Regular',
                            'in_time' => $this->input->post("entryTime"),
                            'paid_time' => $this->input->post("paymentTime"),
                            'total_time' => $this->input->post("parkingTime"),
                            'amount' => $this->input->post("parking_amount"),
                            'cash_received' => 60,
                            'change' => 0,
                            'discount' => 0,
                            'vat' => 0,
                            'vat_exempt' => 0,
                            'vatable_sales' => 0,
                            'paymode' => $this->input->post("paymode"),
                            'status' => 1
                        );
                        try {
                            $connector = new WindowsPrintConnector("POS-80-Series");
                            $printer = new Printer($connector);
                    
                            $printer->setJustification(Printer::JUSTIFY_CENTER);
                            $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                            $printer->text("PICC\n");
                            $printer->selectPrintMode();
                    
                            function formatLine($left, $right)
                            {
                                $maxLength = 48;
                                $leftLength = strlen($left);
                                $rightLength = strlen($right);
                                $spaces = $maxLength - $leftLength - $rightLength;
                                return $left . str_repeat(' ', $spaces) . $right . "\n";
                            }
                    
                            $printer->text("Philippine International Convention Center\n");
                            $printer->text("PICC, Complex 1307 Pasay City,\nMetro Manila, Philippines\n");
                            $printer->text("VAT REG TIN: 000-000-000-00000\n");
                            $printer->text("MIN: 1234567891\n");
                            $printer->text("(+63)936994578\n");
                            $printer->feed();
                            $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                            $printer->text("TRAINING MODE\n\n");
                            $printer->selectPrintMode();
                            $printer->text("Date and Time: " . $receipt['dateAndTime'] . "\n");
                            $printer->text("S/I: " . "0000046\n");
                            $printer->text("Plate Number: " . $receipt['parkingCode'] . "\n");
                            $printer->text("Vehicle: " . $receipt['vehicleCategory'] . "\n");
                            $printer->feed();
                            $printer->setJustification(Printer::JUSTIFY_CENTER);
                            $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                            $printer->text("Sales Invoice\n");
                            $printer->selectPrintMode();
                            $printer->feed();
                            $printer->setJustification(Printer::JUSTIFY_LEFT);
                    
                            // Dummy data for the case without discount
                            $originalRate = 60.00; // original rate
                            $vatExempt = "No"; // VAT exemption status
                            $vatableSale = number_format($originalRate / 1.12, 2); // VATable sale (Original Rate / 1.12)
                            $nonVatSales = 0.00; // Non-VAT Sales
                            $zeroRatedSales = 0.00; // Zero Rated Sales
                            $totalSales = number_format($vatableSale, 2); // Total Sales (Vatable Sales)
                            $totalVAT = number_format($vatableSale * 0.12, 2); // Total VAT (Vatable Sales * 12%)
                            $totalAmountDue = number_format($originalRate, 2); // Total Amount Due (Original Rate)
                            $totalDiscount = 0.00; // No discount
                            $vatExemption = 0.00; // No VAT exemption amount
                    
                            // Output the formatted data on the receipt
                            $printer->text(formatLine("Cashier:", $receipt['cashierName']));
                            $printer->text(formatLine("Terminal:", $receipt['terminal']));
                            $printer->text(str_repeat("-", 48) . "\n");
                    
                            $printer->text(formatLine("Gate In:", $receipt['entryTime']));
                            $printer->text(formatLine("Bill Time:", $receipt['paymentTime']));
                            $printer->text(formatLine("Parking Time:", $receipt['parkingStay']));
                            $printer->text(formatLine("Total Sales:", $totalSales));
                            $printer->text(formatLine("Vat(12%):", $totalVAT));
                            $printer->text(formatLine("Total Amount Due:", $totalAmountDue));
                    
                            $printer->text(str_repeat("-", 48) . "\n");
                    
                            // Breakdown of sales and VAT information
                            $printer->text(formatLine("Vatable Sales:", $vatableSale));
                            $printer->text(formatLine("Non-Vat Sales:", $nonVatSales));
                            $printer->text(formatLine("Vat-Exempt:", $vatExemption));
                            $printer->text(formatLine("Zero-Rated Sales:", $zeroRatedSales));
                            $printer->text(formatLine("Discount:", $totalDiscount));
                            $printer->text(formatLine("Payment Mode:", $receipt['paymentmode']));
                    
                            $printer->text(formatLine("Name:", "_____________________________"));
                            $printer->text(formatLine("Address:", "_____________________________"));
                            $printer->text(formatLine("TIN:", "_____________________________"));
                            $printer->text(formatLine("ID Number:", "_____________________________"));
                    
                            $printer->setJustification(Printer::JUSTIFY_CENTER);
                            $printer->text("\n\nBIR PTU NO: AB1234567-12345678\n");
                            $printer->text("PTU DATE ISSUED: 11/24/2020\n");
                            $printer->text("THIS SALES INVOICE BE VALID FOR FIVE(5) YEARS\nFROM THE DATE OF PERMIT TO USE\n");
                            $printer->feed(2);
                    
                            $printer->cut();
                            $printer->close();
                    
                            echo "Printed successfully.";
                        } catch (Exception $e) {
                            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
                        }
                    } else {
    
                        $remainingBalance = $remaining - $changeAmount;
    
                        $remainingData = array (
                            'terminal_id' => $terminalId,
                            'id' => $cashDrawer['id'],
                            'remaining' => $remainingBalance
                        );
    
                        $vehicleId = $this->input->post("vehicleClass");
                        $discountCode = $this->input->post('discount');
    
                        $rates = $this->model_demo->getRates($vehicleId);
    
                        $vehicleRate = $this->input->post("discounted");
    
                        $discounts = $this->model_demo->getDiscounts($discountCode, $vehicleId);
    
                        $vatRate = 1.12;
    
                        $discountPercentage = $discounts['percentage'];
                        $vatExempt = $discounts['vat_exempt'];
    
    
                        $discountedAmount = $this->input->post("discounted");
    
                        $totalAmountSale = $discountedAmount / $vatRate;
    
                        $roundedOff = round($totalAmountSale, 2);
                        $vatExempt = 0;
                        $totalVat = 0;
                        $zeroRated = 0;
                        echo $roundedOff;
                        $eTime = $this->input->post("entryTime");
                        $payTime = $this->input->post("paymentTime");
    
                        $receipt = array(
                            'cashierName' => $this->session->userdata('fname'),
                            'terminal' => 'terminal1',
                            'dateAndTime' => date("m-d-Y H:i:s A"),
                            'S/I' => 000001,
                            'accessType' => 'Plate',
                            'parkingCode' => 'ABC1234',
                            'vehicleCategory' => 'Car',
                            'entryTime' => date('Y-m-d H:i:s A', $eTime),
                            'paymentTime' => date('Y-m-d H:i:s A', $payTime),
                            'parkingStay' => $this->input->post("parkingTime"),
                            'discountType' => $this->input->post("discount"),
                            'discountAmount' => $roundedOff,
                            'vatableSale' => $vatExempt,
                            'nonVatSale' => $roundedOff,
                            'zeroRatedSale' => $zeroRated,
                            'totalSales' => $totalAmountSale,
                            'totalVAT' => $totalVat,
                            'totalAmountDue' => $roundedOff,
                            'paymentmode' => $this->input->post("paymode"),
                            'discounted' => $this->input->post("discounted"),
                            'discounted_amount' => $this->input->post("discounted_amount"),
                        );
    
                        $this->data['receipt'] = $receipt;
                        $this->render_template('demo/receipt', $this->data);
                        $drawerUpdate = $this->model_demo->updateDrawer($remainingData);
                        if($drawerUpdate === true){
                            
                            try {
                                $connector = new WindowsPrintConnector("POS-80-Series");
                                $printer = new Printer($connector);
                            
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                                $printer->text("PICC\n");
                                $printer->selectPrintMode();
                            
                                function formatLine($left, $right)
                                {
                                    $maxLength = 48;
                                    $leftLength = strlen($left);
                                    $rightLength = strlen($right);
                                    $spaces = $maxLength - $leftLength - $rightLength;
                                    return $left . str_repeat(' ', $spaces) . $right . "\n";
                                }
                            
                                $printer->text("Philippine International Convention Center\n");
                                $printer->text("PICC, Complex 1307 Pasay City,\nMetro Manila, Philippines\n");
                                $printer->text("VAT REG TIN: 000-000-000-00000\n");
                                $printer->text("MIN: 1234567891\n");
                                $printer->text("(+63)936994578\n");
                                $printer->feed();
                                $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                                $printer->text("TRAINING MODE\n\n");
                                $printer->selectPrintMode();
                                $printer->text("Date and Time: " . $receipt['dateAndTime'] . "\n");
                                $printer->text("S/I: " . "0000046\n");
                                $printer->text("Plate Number: " . $receipt['parkingCode'] . "\n");
                                $printer->text("Vehicle: " . $receipt['vehicleCategory'] . "\n");
                                $printer->feed();
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                                $printer->text("Sales Invoice\n");
                                $printer->selectPrintMode();
                                $printer->feed();
                                $printer->setJustification(Printer::JUSTIFY_LEFT);
                            
                                $printer->text(formatLine("Cashier:", $receipt['cashierName']));
                                $printer->text(formatLine("Terminal:", $receipt['terminal']));
                                $printer->text(str_repeat("-", 48) . "\n");
                            
                                $printer->text(formatLine("Gate In:", $receipt['entryTime']));
                                $printer->text(formatLine("Bill Time:", $receipt['paymentTime']));
                                $printer->text(formatLine("Parking Time:", $receipt['parkingStay']));
                                $printer->text(formatLine("Total Sales:", number_format($receipt['discountAmount'], 2)));
                                $printer->text(formatLine("Vat(12%):", number_format($receipt['totalVAT'], 2)));
    
                                $printer->text(formatLine("Total Amount Due:", number_format($receipt['discountAmount'], 2)));
                            
                                $printer->text(str_repeat("-", 48) . "\n");
                            
                                $printer->text(formatLine("Vatable Sales:", number_format($receipt['vatableSale'], 2)));
                                $printer->text(formatLine("Non-Vat Sales:", number_format($receipt['discountAmount'], 2)));
                                $printer->text(formatLine("Vat-Exempt:", number_format($receipt['zeroRatedSale'], 2)));
                                $printer->text(formatLine("Zero-Rated Sales:", number_format($receipt['zeroRatedSale'], 2)));
                                $printer->text(formatLine("Discount:", number_format($receipt['discounted_amount'], 2)));
                                $printer->text(formatLine("Payment Mode:", $receipt['paymentmode']));
    
                                $printer->text(formatLine("Name:", "_____________________________"));
                                $printer->text(formatLine("Address:", "_____________________________"));
                                $printer->text(formatLine("TIN:", "_____________________________"));
                                $printer->text(formatLine("ID Number:", "_____________________________"));
                            
                                $printer->setJustification(Printer::JUSTIFY_CENTER);
                                $printer->text("\n\nBIR PTU NO: AB1234567-12345678\n");
                                $printer->text("PTU DATE ISSUED: 11/24/2020\n");
                                $printer->text("THIS SALES INVOICE BE VALID FOR FIVE(5) YEARS\nFROM THE DATE OF PERMIT TO USE\n");
                                $printer->feed(2);
                            
                                $printer->cut();
                                $printer->close();
                            
                                echo "Printed successfully.";
                            } catch (Exception $e) {
                                echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
                            }
                        }else{
                            $this->session->set_flashdata('failed', 'Failed to update drawer');
                            $this->data['details'] = $details;
                            $this->render_template("demo/cash_payment", $this->data);
                        }
                    }

                    
                }else if($paymode == "GCash" || $paymode == "Paymaya"){
                    $this->render_template("demo/ewallet_payment", $this->data);
                }else{
                    try {
                        $connector = new WindowsPrintConnector("POS-80-Series");
                        $printer = new Printer($connector);

                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                        $printer->text("PICC\n");
                        $printer->selectPrintMode();

                        function formatLine($left, $right)
                        {
                            $maxLength = 48;
                            $leftLength = strlen($left);
                            $rightLength = strlen($right);
                            $spaces = $maxLength - $leftLength - $rightLength;
                            return $left . str_repeat(' ', $spaces) . $right . "\n";
                        }

                        $printer->text("Philippine International Convention Center\n");
                        $printer->text("PICC, Complex 1307 Pasay City, Metro Manila, Philippines\n");
                        $printer->text("VAT REG TIN: 000-000-000-00000\n");
                        $printer->text("MIN: 1234567891\n");
                        $printer->text("(+63)936994578\n");
                        $printer->feed();
                        $printer->text(str_repeat("-", 48) . "\n");
                        $printer->text("Date and Time: 07-22-2024 08:54:53 AM\n");
                        $printer->text("Plate Number: ABC123\nVehicle: Car\n");
                        $printer->feed();
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                        $printer->text("Complimentary Gate Pass\n");
                        $printer->text("BIR PTU NO: AB1234567-12345678\n");
                        $printer->text("PTU DATE ISSUED: 11/24/2020\n");
                        $printer->text("THIS SERVES AS AN OFFICIAL RECEIPT\n");
                        $printer->feed(2);
                        $printer->cut();

                        $printer->close();

                        echo "Printed successfully.";
                    } catch (Exception $e) {
                        echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
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
    // END OF PAYMENT PROCESSING

    // EWALLET

    // END OF EWALLET

    // GENERATING REPORTS
    // END OF GENERATING REPORTS
}