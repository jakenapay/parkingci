<?php
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
class Terminal extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_users');
        $this->load->model('model_terminal');
        $this->load->model('model_company');
        $this->load->model('model_rates');
    }

    public function index()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_terminal->checkTerminalDrawer($terminalId);

            if ($cashDrawer) {
                $kiosk1_id = 2;
                $kiosk2_id = 3;

                // Check for kiosk 1 and kiosk 2 data
                $kioskOneStorage = $this->model_terminal->checkTerminalDrawer($kiosk1_id);
                $kioskTwoStorage = $this->model_terminal->checkTerminalDrawer($kiosk2_id);

                // Cashier data
                $cashier_opening = isset($cashDrawer['opening_fund']) ? $cashDrawer['opening_fund'] : '0.00';
                $cashier_remaining = isset($cashDrawer['remaining']) ? $cashDrawer['remaining'] : '0.00';

                // Kiosk 1 data
                $kioskone_opening = isset($kioskOneStorage['opening_fund']) ? $kioskOneStorage['opening_fund'] : '0';
                $kioskone_remaining = isset($kioskOneStorage['remaining']) ? $kioskOneStorage['remaining'] : '0';

                // Kiosk 2 data
                $kiosktwo_opening = isset($kioskTwoStorage['opening_fund']) ? $kioskTwoStorage['opening_fund'] : '0';
                $kiosktwo_remaining = isset($kioskTwoStorage['remaining']) ? $kioskTwoStorage['remaining'] : '0';

                $this->data['cashier_opening'] = $cashier_opening;
                $this->data['cashier_remaining'] = $cashier_remaining;
                $this->data['kioskone_opening'] = $kioskone_opening;
                $this->data['kioskone_remaining'] = $kioskone_remaining;
                $this->data['kiosktwo_opening'] = $kiosktwo_opening;
                $this->data['kiosktwo_remaining'] = $kiosktwo_remaining;

                $this->load->view('templates/header');
                $this->render_template('terminal/index', $this->data);
            } else {
                // When there's no cashier data, load the balance view
                $this->load->view('balance');
            }
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
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
                $setCashDrawer = $this->model_terminal->createData($drawerData);

                if ($setCashDrawer) {
                    redirect('terminal');
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

    public function payment()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $code = $this->input->get('code');
            $access = $this->input->get('accessEntry');
            $clientData = $this->model_terminal->getData($access, $code);
            $status = $clientData['paid_status'];

            $companyId = 1;
            $vehicleId = $clientData['vechile_cat_id'];
            $company = $this->model_company->getCompanyInfo($companyId);
            $regRate = $this->model_rates->getRateRegular($vehicleId);
            $discRate = $this->model_rates->getRateDiscount($vehicleId);


            if (empty($clientData)) {
                $this->session->set_flashdata('error', 'No data found for the given input.');
                redirect('terminal/index');
            } else if ($status == 1) {
                $this->session->set_flashdata('error', 'Client is already paid.');
                redirect('terminal/index');
            } else {
                date_default_timezone_set("Asia/Manila");
                $checkInTime = $clientData['in_time'];
                $checkOutTime = strtotime('now');

                $totalMin = ceil((abs($checkOutTime - $checkInTime) / 60));
                $totalHour = floor((abs($checkOutTime - $checkInTime) / 60) / 60);
                $minute = ((abs($checkOutTime - $checkInTime) / 60) % 60);

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


                $parkingData = array(
                    'id' => $clientData['id'],
                    'accessType' => $clientData['AccessType'],
                    'parkingCode' => $clientData['parking_code'],
                    'gateEntry' => $clientData['GateId'],
                    'vehicleClass' => $clientData['vechile_cat_id'],
                    'unixEntryTime' => $clientData['in_time'],
                    'decodeEntryTime' => date('Y-m-d H:i:s', $clientData['in_time']),
                    'paytime' => strtotime('now'),
                    'parkingTime' => $totalHour . ":" . $minute,
                    'totalParkTime' => $totalHour . " Hour    " . $minute . " Min",
                    'picturePath' => $clientData['picturePath'],
                    'pictureName' => $clientData['pictureName'],
                    'amount' => $amount,
                    'vehicleRate' => $vehicleRate,
                    'status' => $clientData['paid_status']
                );
                $this->data['discount_rates'] = $discRate;
                $this->data['billdata'] = $parkingData;
                $this->render_template('terminal/billing', $this->data);
            }
        } else {
            echo (" you are not cashier");
            $this->load->view('login');
            return;
        }
    }

    public function paymentmode()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $billingData = array(
                'parkingId' => $this->input->get('id'),
                'gateEntry' => $this->input->get('gate_id'),
                'accessType' => $this->input->get('access_type'),
                'parkingCode' => $this->input->get('parking_code'),
                'entryTime' => $this->input->get('unix_entry_time'),
                'paymentTime' => $this->input->get('paytime'),
                'vehicleClass' => $this->input->get('vehicle_class'),
                'parkingTime' => $this->input->get('parking_time'),
                'amount' => $this->input->get('amount_due'),
                'discount' => $this->input->get('discount_opt'),
                'vehicleRate' => $this->input->get('vehicle_rate'),
                'status' => $this->input->get('status')
            );

            // print_r($billingData);
            $this->data['billdata'] = $billingData;
            $this->render_template('terminal/payment_mode', $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }
    public function loadpaymentforms()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $mode = $this->input->get('paymentmode');


            if ($mode == "Cash") {
                $billingData = array(
                    'parkingId' => $this->input->get('id'),
                    'gateEntry' => $this->input->get('gate_id'),
                    'accessType' => $this->input->get('access_type'),
                    'parkingCode' => $this->input->get('parking_code'),
                    'entryTime' => $this->input->get('unix_entry_time'),
                    'paymentTime' => $this->input->get('paytime'),
                    'vehicleClass' => $this->input->get('vehicle_class'),
                    'parkingTime' => $this->input->get('parking_time'),
                    'amount' => $this->input->get('amount_due'),
                    'discount' => $this->input->get('discount_opt'),
                    'vehicleRate' => $this->input->get('vehicle_rate'),
                    'status' => $this->input->get('status'),
                    'mode' => $this->input->get('paymentmode')
                );
                $this->data['billdata'] = $billingData;
                $this->render_template('terminal/cash_payment', $this->data);
            } else if ($mode == "GCash" || $mode == "Paymaya") {

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
                    $responseData = json_decode($response, true);
                    $codeUrl = isset($responseData['CodeUrl']) ? $responseData['CodeUrl'] : '';
                    $refNumber = isset($responseData['ReferenceNumber']) ? $responseData['ReferenceNumber'] : '';
                    $billingData = array(
                        'parkingId' => $this->input->get('id'),
                        'gateEntry' => $this->input->get('gate_id'),
                        'accessType' => $this->input->get('access_type'),
                        'parkingCode' => $this->input->get('parking_code'),
                        'entryTime' => $this->input->get('unix_entry_time'),
                        'paymentTime' => $this->input->get('paytime'),
                        'vehicleClass' => $this->input->get('vehicle_class'),
                        'parkingTime' => $this->input->get('parking_time'),
                        'amount' => $this->input->get('amount_due'),
                        'discount' => $this->input->get('discount_opt'),
                        'vehicleRate' => $this->input->get('vehicle_rate'),
                        'status' => $this->input->get('status'),
                        'mode' => $this->input->get('paymentmode'),
                        'refNumber' => $billNumber,
                        'codeUrl' => $codeUrl
                    );

                    // print_r($billingData);
                }
                curl_close($ch);
                $this->data['billdata'] = $billingData;
                $this->render_template('terminal/ewallet_payment', $this->data);
            } else if ($mode == "Complimentary") {
                $billingData = array(
                    'parkingId' => $this->input->get('id'),
                    'gateEntry' => $this->input->get('gate_id'),
                    'accessType' => $this->input->get('access_type'),
                    'parkingCode' => $this->input->get('parking_code'),
                    'entryTime' => $this->input->get('unix_entry_time'),
                    'paymentTime' => $this->input->get('paytime'),
                    'vehicleClass' => $this->input->get('vehicle_class'),
                    'parkingTime' => $this->input->get('parking_time'),
                    'amount' => $this->input->get('amount_due'),
                    'discount' => $this->input->get('discount_opt'),
                    'vehicleRate' => $this->input->get('vehicle_rate'),
                    'status' => $this->input->get('status'),
                    'mode' => $this->input->get('paymentmode')
                );
                $this->data['billdata'] = $billingData;
                $this->render_template('terminal/complimentary_payment', $this->data);
            }
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function reports()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $transactions = $this->model_terminal->getTransactions($user_id);
            $this->data['transactions'] = $transactions;
            $this->render_template('terminal/report', $this->data);
        } else {
            $this->session->set_flashdata('error', 'Sorry Please login!.');
            $this->load->view('login');
            return;
        }
    }

    public function analysis()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        // Check if the user is authorized
        if ($position['id'] == 5) {
            $type = $this->input->get('type');
            $terminalId = $this->input->get('terminal_id') ?? 1; // Parameterized terminalId

            if ($type == "xreading") {
                $report_data = $this->model_terminal->getXReadingReport($terminalId, $user_id);
                if ($report_data) {
                    $this->data['report_data'] = $report_data;
                    $this->render_template('terminal/xreading', $this->data);
                } else {
                    // Handle the case when no report data is found
                    $this->session->set_flashdata('error', 'No X-Reading report found for the selected terminal.');
                    redirect('terminal/reports'); // Adjust redirection as needed
                }
            } elseif ($type == "zreading") {
                // Implement Z-Reading logic here if needed
                $this->render_template('terminal/zreading', $this->data);
            } elseif ($type == "ejournal") {
                $this->generateEJournalReport($terminalId);
            } else {
                $this->session->set_flashdata('error', 'Invalid report type selected.');
                redirect('terminal/reports');
            }
        } else {
            // Redirect unauthorized users
            $this->session->set_flashdata('error', 'You are not authorized to view this report.');
            redirect('dashboard'); // Adjust redirection as needed
        }
    }

    private function generateEJournalReport($terminalId)
    {
        $companyId = 1;
        $ptuId = 3;

        $companyData = $this->model_terminal->getOrganization($companyId);
        $ptuData = $this->model_terminal->getPtu($ptuId);
        $getTransactions = $this->model_terminal->getTransactionsByTerminalId($terminalId);

        if ($getTransactions) {
            // Create a temporary file to store the receipt content
            $fileName = 'receipts.txt';
            $tempFilePath = sys_get_temp_dir() . '/' . $fileName;
            $fileHandle = fopen($tempFilePath, 'w');

            if ($fileHandle) {
                foreach ($getTransactions as $getTransaction) {
                    // Prepare the receipt content (similar to the original logic)
                    $receiptContent = $this->formatReceipt($companyData, $ptuData, $getTransaction);
                    fwrite($fileHandle, $receiptContent);
                }
                fclose($fileHandle);

                // Prompt the user to download the file
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($tempFilePath));
                readfile($tempFilePath);
                unlink($tempFilePath); // Delete temporary file

                exit;
            } else {
                $this->session->set_flashdata('error', 'Unable to create the receipt file.');
                redirect('terminal/reports');
            }
        } else {
            $this->session->set_flashdata('error', 'No transactions found for the selected terminal.');
            redirect('terminal/reports');
        }
    }

    private function formatReceipt($companyData, $ptuData, $transaction)
    {
        $totalAmountDue = $transaction['amount'] + $transaction['vat'];

        // Determine vehicle class
        $vehicleClass = $this->getVehicleClass($transaction['vehicle_cat_id']);

        // Format the receipt content as a string
        $receiptContent = "===========================================\n";
        $receiptContent .= "              RECEIPT                     \n";
        $receiptContent .= "===========================================\n";
        $receiptContent .= "Organization:  {$companyData['name']}\n";
        $receiptContent .= "Address:       {$companyData['address']}\n";
        $receiptContent .= "Contact:       {$companyData['telephone']}\n";
        $receiptContent .= "VAT Reg TIN:   {$companyData['TIN']}\n";
        $receiptContent .= "MIN:           {$companyData['MIN']}\n";
        $receiptContent .= "Invoice #:     {$transaction['ornumber']}\n";
        $receiptContent .= "Code:          {$transaction['parking_code']}\n";
        $receiptContent .= "Vehicle Class: {$vehicleClass}\n";
        $receiptContent .= "-------------------------------------------\n";
        $receiptContent .= "Cashier:       John Doe\n"; // Replace with actual cashier
        $receiptContent .= "Gate In:       " . date('Y-m-d H:i:s', $transaction['in_time']) . "\n";
        $receiptContent .= "Payment Time:  " . date('Y-m-d H:i:s', $transaction['paid_time']) . "\n";
        $receiptContent .= "Parking Time:  {$transaction['total_time']}\n";
        $receiptContent .= "Amount Due:    PHP {$transaction['amount']}\n";
        $receiptContent .= "VAT (12%):     PHP {$transaction['vat']}\n";
        $receiptContent .= "Total:         PHP {$totalAmountDue}\n";
        $receiptContent .= "-------------------------------------------\n";
        $receiptContent .= "Vatable Sales: PHP {$transaction['vatable_sales']}\n";
        $receiptContent .= "Discount:      PHP {$transaction['discount']}\n";
        $receiptContent .= "Paymode:       {$transaction['paymode']}\n";
        $receiptContent .= "===========================================\n";
        $receiptContent .= "\n";

        return $receiptContent;
    }

    private function getVehicleClass($vehicleCatId)
    {
        switch ($vehicleCatId) {
            case 1:
                return 'Motorcycle';
            case 2:
                return 'Car';
            case 3:
                return 'Bus/Truck';
            default:
                return 'Unknown';
        }
    }

    
    
    


    public function paymentend()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $mode = $this->input->get('paymentmode');
            $change = $this->input->get('change');
            $terminalId = 1;
            if ($mode == "Cash") {
                $checkDrawer = $this->model_terminal->checkDrawer($terminalId);
                $cashBalance = $checkDrawer['remaining'];

                if ($change > $cashBalance) {
                    $billingData = array(
                        'parkingId' => $this->input->get('id'),
                        'gateEntry' => $this->input->get('gate_id'),
                        'accessType' => $this->input->get('access_type'),
                        'parkingCode' => $this->input->get('parking_code'),
                        'entryTime' => $this->input->get('unix_entry_time'),
                        'paymentTime' => $this->input->get('paytime'),
                        'vehicleClass' => $this->input->get('vehicle_class'),
                        'parkingTime' => $this->input->get('parking_time'),
                        'amount' => $this->input->get('amount_due'),
                        'discount' => $this->input->get('discount_opt'),
                        'vehicleRate' => $this->input->get('vehicle_rate'),
                        'status' => $this->input->get('status'),
                        'mode' => $this->input->get('paymentmode')
                    );
                    $this->data['billdata'] = $billingData;
                    $this->session->set_flashdata('error', 'Drawer balance is not enough!.');
                    $this->render_template('terminal/cash_payment', $this->data);
                } else {

                    $remBalance = $cashBalance - $change;
                    // print_r($checkDrawer);
                    // echo $remBalance;
                    $dataBalance = array(
                        'terminal_id' => $terminalId,
                        'id' => $checkDrawer['id'],
                        'remaining' => $remBalance
                    );
                    $updateDrawer = $this->model_terminal->deductChangeAmount($dataBalance);

                    if ($updateDrawer) {
                        $companyId = 1;
                        $ptuId = 3;
                        $companyData = $this->model_terminal->getOrganization($companyId);
                        $ptuData = $this->model_terminal->getPtu($ptuId);

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

                        $amount = $this->input->get('amount_due');

                        if ($amount > 0) {
                            $vatAmount = number_format($amount - ($amount / 1.12), 2);
                            $vatableSales = number_format(($amount / 1.12), 2);
                        } else {
                            $vatAmount = 0;
                            $vatableSales = 0;
                        }
                        $billingData = array(
                            'parkingId' => $this->input->get('id'),
                            'gateEntry' => $this->input->get('gate_id'),
                            'accessType' => $this->input->get('access_type'),
                            'parkingCode' => $this->input->get('parking_code'),
                            'entryTime' => $this->input->get('unix_entry_time'),
                            'paymentTime' => $this->input->get('paytime'),
                            'vehicleClass' => $this->input->get('vehicle_class'),
                            'parkingTime' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'vehicleRate' => $this->input->get('vehicle_rate'),
                            'status' => $this->input->get('status'),
                            'mode' => $this->input->get('paymentmode')
                        );

                        $transaction = array(
                            'pid' => $terminalId,
                            'cashier_id' => $user_id,
                            'ornumber' => $companyData['OR'] + 1,
                            'gate_en' => $this->input->get('gate_id'),
                            'access_type' => $this->input->get('access_type'),
                            'parking_code' => $this->input->get('parking_code'),
                            'vehicle_cat_id' => $this->input->get('vehicle_class'),
                            'rate_id' => $this->input->get('vehicle_rate'),
                            'in_time' => $this->input->get('unix_entry_time'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'paymode' => $this->input->get('paymentmode'),
                            'vat' => $vatAmount,
                            'vatable_sales' => $vatableSales,
                            'status' => 1
                        );

                        $OR = $companyData['OR'] + 1;

                        $parking = array(
                            'id' => $this->input->get('id'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'total_time' => $this->input->get('parking_time'),
                            'paid_status' => 1,
                        );
                        $createTransaction = $this->model_terminal->postTransaction($transaction);

                        if ($createTransaction === true) {

                            $companyOr = array(
                                'id' => $companyData['id'],
                                'OR' => $OR
                            );
                            $this->model_terminal->updateCompanyOr($companyOr);
                            $this->model_terminal->updateParking($parking);
                            // try {
                            //     $connector = new WindowsPrintConnector("POS-80-Series");

                            //     $printer = new Printer($connector);

                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                            //     $printer->text("PICC\n");

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_A);
                            //     $printer->text("\n{$companyData['organization']}\n");
                            //     $printer->text(date('Y-m-d H:i:s A', $companyData['TIN']) . "\n");

                            //     $printer->text("{$companyData['address']}\n");
                            //     $printer->text("{$companyData['telephone']}\n");

                            //     $printer->text("VAT REG TIN: {$companyData['tin']}\n");
                            //     $printer->text("MIN: {$companyData['min']}\n");
                            //     $printer->text("Invoice #: {$OR}\n");
                            //     $printer->text("Access Type: {$this->input->get('access_type')}\n");
                            //     $printer->text("Code: {$this->input->get('parking_code')}\n");
                            //     $printer->text("Vehicle Class: " . getVehicleClass($this->input->get('vehicle_class')) . "\n");

                            //     $printer->selectPrintMode();
                            //     $printer->feed();
                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);
                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                            //     $printer->text("Receipt\n");
                            //     $printer->selectPrintMode();
                            //     $printer->feed();

                            //     $printer->setJustification(Printer::JUSTIFY_LEFT);
                            //     $printer->text(formatLine("Cashier:", $this->session->userdata('username')));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Gate In:", date('Y-m-d H:i:s', $this->input->get('unix_entry_time'))));
                            //     $printer->text(formatLine("Payment Time:", date('Y-m-d H:i:s', $this->input->get('paytime'))));
                            //     $printer->text(formatLine("Parking Time:",$this->input->get('parking_time')));
                            //     $printer->text(formatLine("Amount Due:", "PHP {$vatableSales}"));
                            //     $printer->text(formatLine("Vat (12%):", "PHP {$vatAmount}"));
                            //     $printer->text(formatLine("Total Amount Due:", "PHP {$vatableSales}"));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Vatable Sales:", $vatableSales));
                            //     $printer->text(formatLine("Vat-Exempt:", 'PHP 0.00'));

                            //     $printer->text(formatLine("Discount:", $this->input->get('discount_opt')));
                            //     $printer->text(formatLine("Paymode:", $this->input->get('paymentmode')));

                            //     $printer->text("===========================================\n");
                            //     $printer->text("{$ptuData['name']}\n");
                            //     $printer->text("ACCREDITATION: {$ptuData['name']}\n");
                            //     $printer->text("Date Issued: {$ptuData['accredit_date']}\n");
                            //     $printer->text("Valid Until: {$ptuData['valid_date']}\n");
                            //     $printer->text("BIR PTU NO: {$ptuData['BIR_SN']}\n");
                            //     $printer->text("PTU DATE ISSUED: {$ptuData['issued_date']}\n");
                            //     $printer->text("THIS SERVES AS AN OFFICIAL INVOICE\n");
                            //     $printer->cut();
                            //     $printer->close();

                            // } catch (Exception $e) {
                            //     echo "Could not connect to printer: " . $e->getMessage() . "\n";
                            // }

                            // function formatLine($left, $right) {
                            //     $maxLength = 48;
                            //     $leftLength = strlen($left);
                            //     $rightLength = strlen($right);
                            //     $spaces = $maxLength - $leftLength - $rightLength;
                            //     return $left . str_repeat(' ', $spaces) . $right . "\n";
                            // }

                            // function getVehicleClass($vehicleId) {
                            //     switch ($vehicleId) {
                            //         case 1: return "Motorcycle";
                            //         case 2: return "Car";
                            //         case 3: return "Bus/Truck";
                            //         default: return "Unknown";
                            //     }
                            // }

                            $receipt = array(
                                'organization' => $companyData['name'],
                                'address' => $companyData['address'],
                                'telephone' => $companyData['telephone'],
                                'tin' => $companyData['TIN'],
                                'min' => $companyData['MIN'],

                                'name' => $ptuData['name'],
                                'vendor' => $ptuData['vendor'],
                                'accreditation' => $ptuData['accredition'],
                                'accreditDate' => $ptuData['accredit_date'],
                                'validDate' => $ptuData['valid_date'],
                                'serialNo' => $ptuData['BIR_SN'],
                                'issuedDate' => $ptuData['issued_date'],

                                'vehicleClass' => $this->input->get('vehicle_class'),

                                'in_time' => $this->input->get('unix_entry_time'),
                                'ornumber' => $companyData['OR'] + 1,
                                'parking_code' => $this->input->get('parking_code'),
                                'paytime' => $this->input->get('paytime'),
                                'parking_time' => $this->input->get('parking_time'),
                                'amount_due' => $vatableSales,
                                'vat' => $vatAmount,
                                'total_amount' => $this->input->get('amount_due'),

                                'vatable_sale' => $vatableSales,
                                'vat_exampt' => 0,
                                'discount' => $this->input->get('discount_opt'),
                                'paymode' => $this->input->get('paymentmode')
                            );

                            $this->data['receipt'] = $receipt;

                            $this->render_template('terminal/invoice', $this->data);
                        } else {

                        }
                        $this->data['billdata'] = $billingData;
                    }
                }




            } else if ($mode == "GCash" || $mode == "Paymaya") {

                $refnumber = $this->input->get('refno');
                $amount = $this->input->get('amount');

                $url = "https://103.95.213.254:49416/switch-card-utility/v1/transactions/" . urlencode($refnumber);


                $transactDate = date('Y-m-d');

                $data = array(
                    'ref' => $refnumber,
                    'amount' => '1',
                    'transact-date' => $transactDate
                );

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
                } else {
                    $decodedResponse = json_decode($response, true);
                    if (isset($decodedResponse['Fault'])) {
                        echo "Error: " . $decodedResponse['Fault']['Message'] . "<br>";
                        echo "Description: " . $decodedResponse['Fault']['Description'];
                    } else if (isset($decodedResponse['Status']) && $decodedResponse['Status'] == 'Approved') {

                        $companyId = 1;
                        $ptuId = 3;
                        $companyData = $this->model_terminal->getOrganization($companyId);
                        $ptuData = $this->model_terminal->getPtu($ptuId);

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

                        $amount = $this->input->get('amount_due');

                        if ($amount > 0) {
                            $vatAmount = number_format($amount - ($amount / 1.12), 2);
                            $vatableSales = number_format(($amount / 1.12), 2);
                        } else {
                            $vatAmount = 0;
                            $vatableSales = 0;
                        }
                        $billingData = array(
                            'parkingId' => $this->input->get('id'),
                            'gateEntry' => $this->input->get('gate_id'),
                            'accessType' => $this->input->get('access_type'),
                            'parkingCode' => $this->input->get('parking_code'),
                            'entryTime' => $this->input->get('unix_entry_time'),
                            'paymentTime' => $this->input->get('paytime'),
                            'vehicleClass' => $this->input->get('vehicle_class'),
                            'parkingTime' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'vehicleRate' => $this->input->get('vehicle_rate'),
                            'status' => $this->input->get('status'),
                            'mode' => $this->input->get('paymentmode')
                        );

                        $transaction = array(
                            'pid' => $terminalId,
                            'cashier_id' => $user_id,
                            'ornumber' => $companyData['OR'] + 1,
                            'gate_en' => $this->input->get('gate_id'),
                            'access_type' => $this->input->get('access_type'),
                            'parking_code' => $this->input->get('parking_code'),
                            'vehicle_cat_id' => $this->input->get('vehicle_class'),
                            'rate_id' => $this->input->get('vehicle_rate'),
                            'in_time' => $this->input->get('unix_entry_time'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'paymode' => $this->input->get('paymentmode'),
                            'vat' => $vatAmount,
                            'vatable_sales' => $vatableSales,
                            'status' => 1
                        );

                        $OR = $companyData['OR'] + 1;

                        $parking = array(
                            'id' => $this->input->get('id'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'total_time' => $this->input->get('parking_time'),
                            'paid_status' => 1,
                        );
                        $createTransaction = $this->model_terminal->postTransaction($transaction);

                        if ($createTransaction === true) {

                            $companyOr = array(
                                'id' => $companyData['id'],
                                'OR' => $OR
                            );
                            $this->model_terminal->updateCompanyOr($companyOr);
                            $this->model_terminal->updateParking($parking);
                            // try {
                            //     $connector = new WindowsPrintConnector("POS-80-Series");

                            //     $printer = new Printer($connector);

                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                            //     $printer->text("PICC\n");

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_A);
                            //     $printer->text("\n{$companyData['organization']}\n");
                            //     $printer->text(date('Y-m-d H:i:s A', $companyData['TIN']) . "\n");

                            //     $printer->text("{$companyData['address']}\n");
                            //     $printer->text("{$companyData['telephone']}\n");

                            //     $printer->text("VAT REG TIN: {$companyData['tin']}\n");
                            //     $printer->text("MIN: {$companyData['min']}\n");
                            //     $printer->text("Invoice #: {$OR}\n");
                            //     $printer->text("Access Type: {$this->input->get('access_type')}\n");
                            //     $printer->text("Code: {$this->input->get('parking_code')}\n");
                            //     $printer->text("Vehicle Class: " . getVehicleClass($this->input->get('vehicle_class')) . "\n");

                            //     $printer->selectPrintMode();
                            //     $printer->feed();
                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);
                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                            //     $printer->text("Receipt\n");
                            //     $printer->selectPrintMode();
                            //     $printer->feed();

                            //     $printer->setJustification(Printer::JUSTIFY_LEFT);
                            //     $printer->text(formatLine("Cashier:", $this->session->userdata('username')));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Gate In:", date('Y-m-d H:i:s', $this->input->get('unix_entry_time'))));
                            //     $printer->text(formatLine("Payment Time:", date('Y-m-d H:i:s', $this->input->get('paytime'))));
                            //     $printer->text(formatLine("Parking Time:",$this->input->get('parking_time')));
                            //     $printer->text(formatLine("Amount Due:", "PHP {$vatableSales}"));
                            //     $printer->text(formatLine("Vat (12%):", "PHP {$vatAmount}"));
                            //     $printer->text(formatLine("Total Amount Due:", "PHP {$vatableSales}"));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Vatable Sales:", $vatableSales));
                            //     $printer->text(formatLine("Vat-Exempt:", 'PHP 0.00'));

                            //     $printer->text(formatLine("Discount:", $this->input->get('discount_opt')));
                            //     $printer->text(formatLine("Paymode:", $this->input->get('paymentmode')));

                            //     $printer->text("===========================================\n");
                            //     $printer->text("{$ptuData['name']}\n");
                            //     $printer->text("ACCREDITATION: {$ptuData['name']}\n");
                            //     $printer->text("Date Issued: {$ptuData['accredit_date']}\n");
                            //     $printer->text("Valid Until: {$ptuData['valid_date']}\n");
                            //     $printer->text("BIR PTU NO: {$ptuData['BIR_SN']}\n");
                            //     $printer->text("PTU DATE ISSUED: {$ptuData['issued_date']}\n");
                            //     $printer->text("THIS SERVES AS AN OFFICIAL INVOICE\n");
                            //     $printer->cut();
                            //     $printer->close();

                            // } catch (Exception $e) {
                            //     echo "Could not connect to printer: " . $e->getMessage() . "\n";
                            // }

                            // function formatLine($left, $right) {
                            //     $maxLength = 48;
                            //     $leftLength = strlen($left);
                            //     $rightLength = strlen($right);
                            //     $spaces = $maxLength - $leftLength - $rightLength;
                            //     return $left . str_repeat(' ', $spaces) . $right . "\n";
                            // }

                            // function getVehicleClass($vehicleId) {
                            //     switch ($vehicleId) {
                            //         case 1: return "Motorcycle";
                            //         case 2: return "Car";
                            //         case 3: return "Bus/Truck";
                            //         default: return "Unknown";
                            //     }
                            // }

                            $receipt = array(
                                'organization' => $companyData['name'],
                                'address' => $companyData['address'],
                                'telephone' => $companyData['telephone'],
                                'tin' => $companyData['TIN'],
                                'min' => $companyData['MIN'],

                                'name' => $ptuData['name'],
                                'vendor' => $ptuData['vendor'],
                                'accreditation' => $ptuData['accredition'],
                                'accreditDate' => $ptuData['accredit_date'],
                                'validDate' => $ptuData['valid_date'],
                                'serialNo' => $ptuData['BIR_SN'],
                                'issuedDate' => $ptuData['issued_date'],

                                'vehicleClass' => $this->input->get('vehicle_class'),

                                'in_time' => $this->input->get('unix_entry_time'),
                                'ornumber' => $companyData['OR'] + 1,
                                'parking_code' => $this->input->get('parking_code'),
                                'paytime' => $this->input->get('paytime'),
                                'parking_time' => $this->input->get('parking_time'),
                                'amount_due' => $vatableSales,
                                'vat' => $vatAmount,
                                'total_amount' => $this->input->get('amount_due'),

                                'vatable_sale' => $vatableSales,
                                'vat_exampt' => 0,
                                'discount' => $this->input->get('discount_opt'),
                                'paymode' => $this->input->get('paymentmode')
                            );

                            $this->data['receipt'] = $receipt;

                            $this->render_template('terminal/invoice', $this->data);
                            // echo "SUCCESS PAYMENT<br>";
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
                        } else {
                            echo "Unknown response format.";
                        }
                    }

                    curl_close($ch);

                    echo $response;

                }

            } else if ($mode == "Complimentary") {
                $code = $this->input->get('voucher_code');
                $companyId = 1;
                $companyData = $this->model_terminal->getOrganization($companyId);
                $ptuId = 3;
                $ptuData = $this->model_terminal->getPtu($ptuId);

                $amount = $this->input->get('amount_due');

                if ($amount > 0) {
                    $vatAmount = number_format($amount - ($amount / 1.12), 2);
                    $amountBill = number_format(($amount / 1.12), 2);
                } else {
                    $vatAmount = 0;
                    $amountBill = number_format(($amount / 1.12), 2);
                }

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

                $terminalId = 1;
                $billingData = array(
                    'terminal' => $terminalId,
                    'cashier_id' => $user_id,
                    'ornumber' => $companyData['OR'] + 1,
                    'parkingId' => $this->input->get('id'),
                    'gateEntry' => $this->input->get('gate_id'),
                    'accessType' => $this->input->get('access_type'),
                    'parkingCode' => $this->input->get('parking_code'),
                    'entryTime' => $this->input->get('unix_entry_time'),
                    'paymentTime' => $this->input->get('paytime'),
                    'vehicleClass' => $this->input->get('vehicle_class'),
                    'parkingTime' => $this->input->get('parking_time'),
                    'amount' => $this->input->get('amount_due'),
                    'vehicleRate' => $this->input->get('vehicle_rate'),
                    'discount' => $this->input->get('discount_opt'),
                    'status' => $this->input->get('status'),
                    'mode' => $this->input->get('paymentmode'),
                    'cash' => $this->input->get('cash'),
                    'change' => $this->input->get('change'),
                    'vat' => $vatAmount,
                    'bill' => $amountBill
                );

                $this->data['company'] = $company;
                $this->data['payment'] = $billingData;
                $this->data['ptu'] = $ptu;
                $voucherData = $this->model_terminal->getTicket($code);

                if ($voucherData && is_array($voucherData)) {
                    $startDate = $voucherData['start_date'];
                    $endDate = $voucherData['end_date'];
                    $currentDate = date('Y-m-d');

                    if ($currentDate < $startDate) {
                        $this->session->set_flashdata('failed', 'Complimentary ticket is not yet available.');
                        $this->data['billdata'] = $billingData;
                        $this->render_template('terminal/complimentary_payment', $this->data);
                    } else if ($currentDate > $endDate) {
                        $this->session->set_flashdata('failed', 'Complimentary ticket is already expired.');
                        $this->data['billdata'] = $billingData;
                        $this->render_template('terminal/complimentary_payment', $this->data);
                    } else {
                        $companyId = 1;
                        $ptuId = 3;
                        $companyData = $this->model_terminal->getOrganization($companyId);
                        $ptuData = $this->model_terminal->getPtu($ptuId);

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

                        $amount = $this->input->get('amount_due');

                        if ($amount > 0) {
                            $vatAmount = number_format($amount - ($amount / 1.12), 2);
                            $vatableSales = number_format(($amount / 1.12), 2);
                        } else {
                            $vatAmount = 0;
                            $vatableSales = 0;
                        }
                        $billingData = array(
                            'parkingId' => $this->input->get('id'),
                            'gateEntry' => $this->input->get('gate_id'),
                            'accessType' => $this->input->get('access_type'),
                            'parkingCode' => $this->input->get('parking_code'),
                            'entryTime' => $this->input->get('unix_entry_time'),
                            'paymentTime' => $this->input->get('paytime'),
                            'vehicleClass' => $this->input->get('vehicle_class'),
                            'parkingTime' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'vehicleRate' => $this->input->get('vehicle_rate'),
                            'status' => $this->input->get('status'),
                            'mode' => $this->input->get('paymentmode')
                        );

                        $transaction = array(
                            'pid' => $terminalId,
                            'cashier_id' => $user_id,
                            'ornumber' => $companyData['OR'] + 1,
                            'gate_en' => $this->input->get('gate_id'),
                            'access_type' => $this->input->get('access_type'),
                            'parking_code' => $this->input->get('parking_code'),
                            'vehicle_cat_id' => $this->input->get('vehicle_class'),
                            'rate_id' => $this->input->get('vehicle_rate'),
                            'in_time' => $this->input->get('unix_entry_time'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'discount' => $this->input->get('discount_opt'),
                            'paymode' => $this->input->get('paymentmode'),
                            'vat' => $vatAmount,
                            'vatable_sales' => $vatableSales,
                            'status' => 1
                        );

                        $OR = $companyData['OR'] + 1;

                        $parking = array(
                            'id' => $this->input->get('id'),
                            'paid_time' => $this->input->get('paytime'),
                            'total_time' => $this->input->get('parking_time'),
                            'amount' => $this->input->get('amount_due'),
                            'total_time' => $this->input->get('parking_time'),
                            'paid_status' => 1,
                        );
                        $createTransaction = $this->model_terminal->postTransaction($transaction);

                        if ($createTransaction === true) {

                            $companyOr = array(
                                'id' => $companyData['id'],
                                'OR' => $OR
                            );
                            $this->model_terminal->updateCompanyOr($companyOr);
                            $this->model_terminal->updateParking($parking);
                            // try {
                            //     $connector = new WindowsPrintConnector("POS-80-Series");

                            //     $printer = new Printer($connector);

                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                            //     $printer->text("PICC\n");

                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_A);
                            //     $printer->text("\n{$companyData['organization']}\n");
                            //     $printer->text(date('Y-m-d H:i:s A', $companyData['TIN']) . "\n");

                            //     $printer->text("{$companyData['address']}\n");
                            //     $printer->text("{$companyData['telephone']}\n");

                            //     $printer->text("VAT REG TIN: {$companyData['tin']}\n");
                            //     $printer->text("MIN: {$companyData['min']}\n");
                            //     $printer->text("Invoice #: {$OR}\n");
                            //     $printer->text("Access Type: {$this->input->get('access_type')}\n");
                            //     $printer->text("Code: {$this->input->get('parking_code')}\n");
                            //     $printer->text("Vehicle Class: " . getVehicleClass($this->input->get('vehicle_class')) . "\n");

                            //     $printer->selectPrintMode();
                            //     $printer->feed();
                            //     $printer->setJustification(Printer::JUSTIFY_CENTER);
                            //     $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                            //     $printer->text("Receipt\n");
                            //     $printer->selectPrintMode();
                            //     $printer->feed();

                            //     $printer->setJustification(Printer::JUSTIFY_LEFT);
                            //     $printer->text(formatLine("Cashier:", $this->session->userdata('username')));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Gate In:", date('Y-m-d H:i:s', $this->input->get('unix_entry_time'))));
                            //     $printer->text(formatLine("Payment Time:", date('Y-m-d H:i:s', $this->input->get('paytime'))));
                            //     $printer->text(formatLine("Parking Time:",$this->input->get('parking_time')));
                            //     $printer->text(formatLine("Amount Due:", "PHP {$vatableSales}"));
                            //     $printer->text(formatLine("Vat (12%):", "PHP {$vatAmount}"));
                            //     $printer->text(formatLine("Total Amount Due:", "PHP {$vatableSales}"));

                            //     $printer->text("===========================================\n");

                            //     $printer->text(formatLine("Vatable Sales:", $vatableSales));
                            //     $printer->text(formatLine("Vat-Exempt:", 'PHP 0.00'));

                            //     $printer->text(formatLine("Discount:", $this->input->get('discount_opt')));
                            //     $printer->text(formatLine("Paymode:", $this->input->get('paymentmode')));

                            //     $printer->text("===========================================\n");
                            //     $printer->text("{$ptuData['name']}\n");
                            //     $printer->text("ACCREDITATION: {$ptuData['name']}\n");
                            //     $printer->text("Date Issued: {$ptuData['accredit_date']}\n");
                            //     $printer->text("Valid Until: {$ptuData['valid_date']}\n");
                            //     $printer->text("BIR PTU NO: {$ptuData['BIR_SN']}\n");
                            //     $printer->text("PTU DATE ISSUED: {$ptuData['issued_date']}\n");
                            //     $printer->text("THIS SERVES AS AN OFFICIAL INVOICE\n");
                            //     $printer->cut();
                            //     $printer->close();

                            // } catch (Exception $e) {
                            //     echo "Could not connect to printer: " . $e->getMessage() . "\n";
                            // }

                            // function formatLine($left, $right) {
                            //     $maxLength = 48;
                            //     $leftLength = strlen($left);
                            //     $rightLength = strlen($right);
                            //     $spaces = $maxLength - $leftLength - $rightLength;
                            //     return $left . str_repeat(' ', $spaces) . $right . "\n";
                            // }

                            // function getVehicleClass($vehicleId) {
                            //     switch ($vehicleId) {
                            //         case 1: return "Motorcycle";
                            //         case 2: return "Car";
                            //         case 3: return "Bus/Truck";
                            //         default: return "Unknown";
                            //     }
                            // }

                            $receipt = array(
                                'organization' => $companyData['name'],
                                'address' => $companyData['address'],
                                'telephone' => $companyData['telephone'],
                                'tin' => $companyData['TIN'],
                                'min' => $companyData['MIN'],

                                'name' => $ptuData['name'],
                                'vendor' => $ptuData['vendor'],
                                'accreditation' => $ptuData['accredition'],
                                'accreditDate' => $ptuData['accredit_date'],
                                'validDate' => $ptuData['valid_date'],
                                'serialNo' => $ptuData['BIR_SN'],
                                'issuedDate' => $ptuData['issued_date'],

                                'vehicleClass' => $this->input->get('vehicle_class'),

                                'in_time' => $this->input->get('unix_entry_time'),
                                'ornumber' => $companyData['OR'] + 1,
                                'parking_code' => $this->input->get('parking_code'),
                                'paytime' => $this->input->get('paytime'),
                                'parking_time' => $this->input->get('parking_time'),
                                'amount_due' => $vatableSales,
                                'vat' => $vatAmount,
                                'total_amount' => $this->input->get('amount_due'),

                                'vatable_sale' => $vatableSales,
                                'vat_exampt' => 0,
                                'discount' => $this->input->get('discount_opt'),
                                'paymode' => $this->input->get('paymentmode')
                            );

                            $this->data['receipt'] = $receipt;

                            $this->render_template('terminal/invoice', $this->data);
                            $voucherUpdate = array(
                                'id' => $voucherData['id'],
                                'qrcode' => $voucherData['qrcode'],
                                'start_date' => $voucherData['start_date'],
                                'end_date' => $voucherData['end_date'],
                                'is_used' => 1,
                            );
                            $this->model_terminal->updateTicket($voucherUpdate);
                            // $this->render_template('terminal/receipt_preview', $this->data);
                        }
                    }
                } else {
                    $this->session->set_flashdata('failed', 'Complimentary ticket does not exist.');
                    $this->data['billdata'] = $billingData;
                    $this->render_template('terminal/complimentary_payment', $this->data);
                }
            }
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function verifyTransaction()
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


    public function summary(){
        $user_id = $this->session->userdata('id');
        $date = date('Y-m-d');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] === "5") {

            $reports = $this->model_terminal->getTransactionRecords($user_id, $date);
            $this->data['reports']  =   $reports;
            // print_r($reports);
            $this->render_template('terminal/summary', $this->data);
        }else{
            echo "You are not an authized person!";
        }

    }


    public function report() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] === "5") { // Assuming "5" is the cashier position ID
            $report_type = $this->input->get('report_type');
            $cashier_id = $user_id;
            $date = $this->input->get('date');
    
            $data = $this->model_terminal->getReadingReport($cashier_id, $date);
    
            if ($data) {
                $data['report_type'] = $report_type;
                $data['date'] = $date;
                $data['cashier_id'] = $cashier_id;
    
                if ($report_type == 'z_reading') {
                    $this->render_template('terminal/z_reading',$data );
                } elseif ($report_type == 'x_reading') {
                    $this->render_template('terminal/x_reading',$data );
                }
            } else {
                $this->session->set_flashdata('error', 'No transactions found for the selected date.');
                redirect('terminal/reports');
            }

            $this->render_template('terminal/reports',$data );
        } else {
            show_error("You are not authorized to access this report!", 403, "Forbidden");
        }
    }

    public function generate_report()
    {
        date_default_timezone_set("Asia/Manila");
        $user_id = $this->session->userdata('id');
        $cashier_id = $this->input->get('cashier_id');
        $date = $this->input->get('date');
        $report_type = $this->input->get('report_type');
    
        $data = $this->model_terminal->getReading($user_id, $date);
    
        if ($data) {
            // Log report type for debugging
    
            // Load the appropriate view based on report type
            if ($report_type == 'z_reading') {
                $report_data = $this->model_terminal->getReadingReport($cashier_id, $date);

                $data['report_data'] = $report_data;
                $this->load->view('terminal/z_reading_report', $data);
            } elseif ($report_type == 'x_reading') {
                $report_data = $this->model_terminal->getReadingReport($cashier_id, $date);

                $data['report_data'] = $report_data;
                $this->render_template('terminal/x_reading_report', $data);
            } else {
                $this->session->set_flashdata('error', 'Invalid report type selected.');
                redirect('terminal/reports');
            }
        } else {
            $this->session->set_flashdata('error', 'No transactions found for the selected date.');
            redirect('terminal/reports');
        }
    }
    
    
}