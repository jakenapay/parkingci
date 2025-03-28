<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class Touchpoint extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->model("model_users");
        $this->load->model("model_touchpoint");
        $this->load->model('model_company');
        $this->load->model('model_ptu');
        $this->resetZstatus();
        require_once FCPATH . 'vendor/autoload.php';
        require_once FCPATH . 'fpdf186/fpdf.php';
    }

    public function index()
    {
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

    public function resetZstatus()
    {
        $allPtuData = $this->model_ptu->getAllPtuData();
        $today = date('Y-m-d', strtotime('now'));
        // print_r($allPtuData);

        foreach ($allPtuData as $ptu) {
            $zDate = date('Y-m-d', strtotime($ptu['z_date']));
            if ($zDate != $today) {
                $newStatus = ($ptu['z_status'] == 1) ? 0 : $ptu['z_status'];
                $resetZstatus = $this->model_ptu->edit(['z_status' => $newStatus], $ptu['id']);
                $this->session->set_flashdata('status', $resetZstatus ? 'success' : 'failed');
            }
        }
    }

    public function setBalance()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {

            $terminalId = 1;
            // Testing purposes
            // $terminalId = $this->input->post('terminalid');
            $amount = $this->input->post('amount');

            if (empty($amount)) {

                if ($terminalId == 2) {
                    $this->session->set_flashdata('error', 'Opening fund required.');
                    redirect('touchpoint');
                }

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

    public function deviceSetup()
    {
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

    public function payments()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
            if ($cashDrawer) {
                // print_r($cashDrawer);
                $ptuData = $this->model_touchpoint->getPtu($cashDrawer['terminal_id']);

                // z status checker
                $this->session->set_flashdata('status', $ptuData['z_status'] == 0 ? 'success' : 'failed');

                $this->data['z_status'] = $ptuData['z_status'];
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
    public function clientEntry()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);
            // cashDrawer's balance are empty and no data , should return 
            if ($cashDrawer["remaining"]) {
                $access = trim($this->input->post("accessEntry")); // Trim spaces from access
                $code = trim($this->input->post("code")); // Trim spaces from code
                $record = $this->model_touchpoint->getRecord($access, $code);
                // echo json_encode($record);           
                if ($record == "no data") {
                    $this->session->set_flashdata('error', 'no data');
                    redirect('touchpoint/payments');
                } else {
                    $checkInTime = $record['in_time'];
                    date_default_timezone_set('Asia/Manila');
                    //$checkoutTime = strtotime('now');
                    $checkoutTime = strtotime(date('Y-m-d H:i:s'));
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
                    // echo ($totalHour);
                    // echo (":");
                    // echo ($min);
                    if ($totalHour > 1 && $min) {
                        $parkingTime = $totalHour . " Hours    " . $min . " Mins";
                    } else {
                        $parkingTime = $totalHour . " Hour    " . $min . " Min";
                    }

                    $consumeParkingHour = $totalHour . " : " . $min;
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
                }
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function applyDiscount()
    {
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

                // print_r($details);
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
    /************************************************************************************** */
    public function transactPayment()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
        if ($position['id'] != 5) {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login'); // Adjust the URL based on your application structure
        } else {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);  /* session data */
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
                    $totalDiscount = 0;
                    $amountAfterDiscounted = 0;
                    $discountPercentage = 0;
                    $totalDiscount = 0;

                    if ($discountType == "none") {
                        $vatableSale = round($originalAmount / VATRATE, 2);
                        $totalVat = ($vatableSale * VATPERCENT);
                        $amountDue = $vatableSale + $totalVat;

                        $OriginalvatableSale = $vatableSale;
                        $OriginalVat = $totalVat;
                        $netOfDiscount = $OriginalvatableSale;

                    } else {
                        // refactored the code 022825
                        $OriginalvatableSale = round($originalAmount / VATRATE, 2);   // 60 / 1.12 = 53.57
                        $OriginalVat = round($OriginalvatableSale * VATPERCENT, 2);   // 53.57 * 0.12 = 6.43

                        $discountCode = $this->input->post('discount_type');
                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId); // array
                        $discountPercentage = (int) $discounts['percentage'] / 100;  // Example: 20/100 = 0.2

                        $totalDiscount = round($OriginalvatableSale * $discountPercentage, 2); // 53.57 * 0.2 = 10.71
                        $discountAmount = $OriginalvatableSale - $totalDiscount;  // 53.57 - 10.71 = 42.86

                        $zeroRatedSales = 0;

                        if ($discounts['vat_exempt'] == 1) {
                            // VAT-Exempt Customers
                            $totalVat = 0;
                            $vatExempt = round($OriginalvatableSale, 2); // Full vatable sale moves to VAT-Exempt Sales
                            $amountDue = round($discountAmount, 2); // 42.86 (No VAT added back)
                            $vatableSale = 0;
                            $netOfDiscount = round($OriginalvatableSale - $totalDiscount, 2); // 53.57 - 10.71 = 42.86
                        } else {
                            // Regular (Non-VAT-Exempt) Customers
                            $vatExempt = 0;
                            $totalVat = round($OriginalVat, 2);                                          // 6.43
                            $netOfDiscount = round($OriginalvatableSale - $totalDiscount, 2);            // 53.57 - 10.71 = 42.86
                            $amountDue = round($netOfDiscount + $totalVat, 2); // 42.86 + 6.43 = 49.29
                            $vatableSale = round($OriginalvatableSale, 2);     // 53.57                        
                        }

                        // Display Results
                        // echo "<table border='1'>";
                        // echo "<tr><th>Description</th><th>Amount</th></tr>";
                        // echo "<tr><td>Total Sales (with VAT)</td><td>₱" . number_format($originalAmount, 2) . "</td></tr>";
                        // echo "<tr><td>Less VAT (12%)</td><td>₱" . number_format($OriginalVat, 2) . "</td></tr>";
                        // echo "<tr><td>Net of VAT</td><td>₱" . number_format($OriginalvatableSale, 2) . "</td></tr>";
                        // echo "<tr><td>Less Discount (" . ($discountPercentage * 100) . "%)</td><td>₱" . number_format($totalDiscount, 2) . "</td></tr>";
                        // echo "<tr><td>Net of Discount</td><td>₱" . number_format($netOfDiscount, 2) . "</td></tr>";
                        // echo "<tr><td>Add 12% VAT</td><td>₱" . number_format($totalVat, 2) . "</td></tr>";
                        // echo "<tr><td>Total Amount Due</td><td>₱" . number_format($amountDue, 2) . "</td></tr>";
                        // echo "<tr><td>Cash Received</td><td>₱50.00</td></tr>";
                        // echo "<tr><td>Cash Change</td><td>₱" . number_format(50 - $amountDue, 2) . "</td></tr>";
                        // echo "<tr><td>Vatable Sales</td><td>₱" . number_format($vatableSale, 2) . "</td></tr>";
                        // echo "<tr><td>VAT Amount</td><td>₱" . number_format($totalVat, 2) . "</td></tr>";
                        // echo "<tr><td>VAT-Exempt Sales</td><td>₱" . number_format($vatExempt, 2) . "</td></tr>";
                        // echo "<tr><td>Zero-Rated Sales</td><td>₱0.00</td></tr>";
                        // echo "<tr><td>Payment Method</td><td>Cash</td></tr>";
                        // echo "</table>";
                    }
                    $details['discountPercentage'] = $discountPercentage;                       // 0.2 or 0.1
                    $details['discountAmount'] = $totalDiscount;                                // 10.71
                    $details['remaining'] = $cashDrawer['remaining'];                           // 500
                    $details['amountDue'] = $originalAmount;                                    // 60
                    $details['DiscountedAmountDue'] = $totalDiscount;                           // 10.71
                    $details['vatableSale'] = $vatableSale;                                     // 53.57
                    $details['vatExempt'] = $vatExempt; //
                    $details['zeroRatedSales'] = $zeroRatedSales;
                    $details['totalVat'] = $totalVat;
                    $details['totalSales'] = $amountDue;
                    $details['netOfDisc'] = $netOfDiscount;                                    // 42.86
                    $details['netOfVat'] = number_format($OriginalvatableSale, 2); // 53.57
                    $details['lessVat'] = number_format($OriginalVat, 2); // 6.43
                    $details['addNVat'] = number_format($totalVat, 2); // 6.43
                    $details['originalAmount'] = number_format($originalAmount, 2);
                    // print_r($details);
                    $this->data['details'] = $details;
                    $this->render_template("pos/cash_payment", $this->data);

                } else if ($paymode == "GCash" || $paymode == "Paymaya") { // GCASH or PAYMAYA
                    $vehicleId = $this->input->post("vehicleClass");
                    $originalAmount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
                    $vatExempt = 0;
                    $vatableSale = 0;
                    $nonVatSales = 0;
                    $zeroRatedSales = 0;
                    $totalVat = 0;
                    $totalDiscount = 0;
                    $amountAfterDiscounted = 0;
                    $discountPercentage = 0;
                    $totalDiscount = 0;

                    if ($discountType == "none") {
                        $vatableSale = round($originalAmount / VATRATE, 2);
                        $totalVat = ($vatableSale * VATPERCENT);
                        $amountDue = $vatableSale + $totalVat;

                        $OriginalvatableSale = $vatableSale;
                        $OriginalVat = $totalVat;
                        $netOfDiscount = $OriginalvatableSale;

                    } else {
                        // refactored the code 022825
                        $OriginalvatableSale = round($originalAmount / VATRATE, 2);   // 60 / 1.12 = 53.57
                        $OriginalVat = round($OriginalvatableSale * VATPERCENT, 2);   // 53.57 * 0.12 = 6.43

                        $discountCode = $this->input->post('discount_type');
                        $discounts = $this->model_touchpoint->getDiscounts($discountCode, $vehicleId); // array
                        $discountPercentage = (int) $discounts['percentage'] / 100;  // Example: 20/100 = 0.2

                        $totalDiscount = round($OriginalvatableSale * $discountPercentage, 2); // 53.57 * 0.2 = 10.71
                        $discountAmount = $OriginalvatableSale - $totalDiscount;  // 53.57 - 10.71 = 42.86

                        $zeroRatedSales = 0;

                        if ($discounts['vat_exempt'] == 1) {
                            // VAT-Exempt Customers
                            $totalVat = 0;
                            $vatExempt = round($OriginalvatableSale, 2); // Full vatable sale moves to VAT-Exempt Sales
                            $amountDue = round($discountAmount, 2); // 42.86 (No VAT added back)
                            $vatableSale = 0;
                            $netOfDiscount = round($OriginalvatableSale - $totalDiscount, 2); // 53.57 - 10.71 = 42.86
                        } else {
                            // Regular (Non-VAT-Exempt) Customers
                            $vatExempt = 0;
                            $totalVat = round($OriginalVat, 2);                                          // 6.43
                            $netOfDiscount = round($OriginalvatableSale - $totalDiscount, 2);            // 53.57 - 10.71 = 42.86
                            $amountDue = round($netOfDiscount + $totalVat, 2); // 42.86 + 6.43 = 49.29
                            $vatableSale = round($OriginalvatableSale, 2);     // 53.57                        
                        }

                        // Display Results
                        // echo "<table border='1'>";
                        // echo "<tr><th>Description</th><th>Amount</th></tr>";
                        // echo "<tr><td>Total Sales (with VAT)</td><td>₱" . number_format($originalAmount, 2) . "</td></tr>";
                        // echo "<tr><td>Less VAT (12%)</td><td>₱" . number_format($OriginalVat, 2) . "</td></tr>";
                        // echo "<tr><td>Net of VAT</td><td>₱" . number_format($OriginalvatableSale, 2) . "</td></tr>";
                        // echo "<tr><td>Less Discount (" . ($discountPercentage * 100) . "%)</td><td>₱" . number_format($totalDiscount, 2) . "</td></tr>";
                        // echo "<tr><td>Net of Discount</td><td>₱" . number_format($netOfDiscount, 2) . "</td></tr>";
                        // echo "<tr><td>Add 12% VAT</td><td>₱" . number_format($totalVat, 2) . "</td></tr>";
                        // echo "<tr><td>Total Amount Due</td><td>₱" . number_format($amountDue, 2) . "</td></tr>";
                        // echo "<tr><td>Cash Received</td><td>₱50.00</td></tr>";
                        // echo "<tr><td>Cash Change</td><td>₱" . number_format(50 - $amountDue, 2) . "</td></tr>";
                        // echo "<tr><td>Vatable Sales</td><td>₱" . number_format($vatableSale, 2) . "</td></tr>";
                        // echo "<tr><td>VAT Amount</td><td>₱" . number_format($totalVat, 2) . "</td></tr>";
                        // echo "<tr><td>VAT-Exempt Sales</td><td>₱" . number_format($vatExempt, 2) . "</td></tr>";
                        // echo "<tr><td>Zero-Rated Sales</td><td>₱0.00</td></tr>";
                        // echo "<tr><td>Payment Method</td><td>Cash</td></tr>";
                        // echo "</table>";
                    }

                    $url = 'https://api02.apigateway.bdo.com.ph/v1/mpqr/generates';
                    $bill = strval(round($amountDue) * 100);
                    echo "Bill Amount: " . $bill . "</br>";
                    $billNumber = rand(100000, 999999);
                    $data = array(
                        'Amount' => 1,
                        // 'Amount' => $bill,
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
                                $codeImgUrl = $decodedResponse['CodeImgUrl'];
                                //echo $response;    
                                // echo "Code URL: " . $codeUrl . "</br>";
                                // echo "Code Img Url: " . $codeImgUrl . "</br>";
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
                    $details['codeImgUrl'] = $codeImgUrl;
                    $details['refnumber'] = $billNumber;

                    $details['discountPercentage'] = $discountPercentage;                       // 0.2 or 0.1
                    $details['discountAmount'] = $totalDiscount;                                // 10.71
                    $details['remaining'] = $cashDrawer['remaining'];                           // 500
                    $details['amountDue'] = $originalAmount;                                    // 60
                    $details['DiscountedAmountDue'] = $totalDiscount;                           // 10.71
                    $details['vatableSale'] = $vatableSale;                                     // 53.57
                    $details['vatExempt'] = $vatExempt; //
                    $details['zeroRatedSales'] = $zeroRatedSales;
                    $details['totalVat'] = $totalVat;
                    $details['totalSales'] = $amountDue;
                    $details['netOfDisc'] = $netOfDiscount;                                    // 42.86
                    $details['netOfVat'] = number_format($OriginalvatableSale, 2); // 53.57
                    $details['lessVat'] = number_format($OriginalVat, 2); // 6.43
                    $details['addNVat'] = number_format($totalVat, 2); // 6.43
                    $details['originalAmount'] = number_format($originalAmount, 2);

                    // TESTING PURPOSES
                    // echo "<pre>";
                    // print_r($details);
                    // echo "</pre>";

                    $this->data['details'] = $details;
                    $this->render_template("pos/ewallet_payment", $this->data);
                } else {
                    $details['totalSales'] = 0;
                    $this->data['details'] = $details;
                    $this->render_template("pos/voucher_payment", $this->data);
                }

            } else {
                $this->load->view('balance');
            }

        }
    }
    /************************************************************************************** */
    public function processTransaction()
    {
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
                    'totalSales' => $this->input->post("total_sales"),
                    'totalSalesVat' => $this->input->post("totalSalesVat"),
                );
                // echo "POST DATAT"; print_r($_POST);
                $paymode = $this->input->post("paymentmode");
                if ($paymode == "Cash") {
                    $cashReceived = $this->input->post("cash_received");
                    $changeAmount = $this->input->post("change_due");
                    $remaining = $cashDrawer['remaining'];

                    if ($changeAmount > $remaining) {
                        $this->session->set_flashdata('failed', 'Sorry, remaining balance is not enough.');
                        $this->data['details'] = $details;
                        // redirect("touchpoint/processTransaction");
                        // $this->load->view('balance');
                        // $this->render_template("demo/cash_payment", $this->data);  // need to fix
                    } else {
                        if ($changeAmount > 0) {
                            $remainingBalance = $remaining - $changeAmount;
                            $remainingData = array('terminal_id' => $terminalId, 'id' => $cashDrawer['id'], 'remaining' => $remainingBalance);
                            $drawerUpdate = $this->model_touchpoint->updateDrawer($remainingData);
                        }

                        $companyId = 1;
                        $ptuId = 1;
                        $companyData = $this->model_touchpoint->getOrganization($companyId);
                        $ptuData = $this->model_touchpoint->getPtu($ptuId);
                        // echo "<script>console.log(" . json_encode($ptuData) . ");</script>";

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
                            'sn' => $ptuData['serial'],
                            'issuedDate' => $ptuData['issued_date']
                        );
                        $OR = sprintf('%06d', $companyData['OR'] + 1);

                        $vehicleId = $this->input->post("vehicleClass");
                        $vatExempt = $this->input->post("vatExempt");

                        $nonVatSales = 0;
                        $zeroRatedSales = 0;

                        $originalAmount = $this->input->post("parking_amount");
                        $discountType = $this->input->post('discount_type');
                        $totalVat = $this->input->post('totalVat');
                        $vatableSale = $this->input->post('vatableSale');
                        //  $totalSales = $this->input->post("total_sales");
                        $totalDiscount = $this->input->post("discountAmount");
                        $amountAfterDiscounted = $this->input->post("total_sales");
                        $totalSales = $this->input->post("salesamount");
                        $netOfDisc = $this->input->post("netOfDisc");
                        $lessVat = $this->input->post("lessVat");
                        $addNvat = $this->input->post("addNVat");

                        // refactored code
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
                            // 'total_time' => $details['parkingStay'],
                            'amount' => $this->input->post("parking_amount"),
                            'earned_amount' => number_format($totalSales, 2),
                            'cash_received' => number_format($cashReceived, 2),
                            'change' => number_format($changeAmount, 2),
                            'discount_type' => $this->input->post("discount_type"),
                            'discount' => number_format($totalDiscount, 2)
                        );

                        $transactionsData['min'] = $company['min'];
                        $transactionsData['sn'] = $ptu['sn'];
                        $transactionsData['ptu_num'] = $ptuData['BIR_SN'];
                        $transactionsData['ptu_date'] = $ptuData['issued_date'];

                        // If there is a discount
                        if ($discountType != "none") {
                            if ($vatExempt == 0) { // Tenant, NAAC (Not VAT-exempt)
                                $transactionsData['vat_exempt'] = number_format(0, 2); // Not exempt
                                $transactionsData['vat'] = number_format($totalVat, 2);
                                $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                                $transactionsData['less_vat'] = number_format($totalVat, 2);
                                $transactionsData['net_of_vat'] = number_format($vatableSale, 2);
                                $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                $transactionsData['add_nvat'] = number_format($addNvat, 2);
                                if ($discountType == "naac") {
                                    $transactionsData['vat_exempt'] = number_format(0, 2);
                                    $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                    $transactionsData['less_vat'] = number_format($totalVat, 2);
                                    $transactionsData['add_nvat'] = number_format($totalVat, 2);
                                    $transactionsData['net_of_vat'] = number_format($vatableSale, 2);
                                    $transactionsData['earned_amount'] = number_format(number_format($this->input->post("netOfDisc"), 2) + number_format($totalVat, 2), 2);
                                    $transactionsData['vat'] = number_format($totalVat, 2);
                                    $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                                }
                            } else { // VAT-exempt (PWD, SC, Solo Parent)
                                $transactionsData['vat_exempt'] = number_format($vatExempt, 2);
                                $transactionsData['vat'] = number_format(0.00, 2);
                                $transactionsData['vatable_sales'] = number_format(0.00, 2);
                                $transactionsData['net_of_vat'] = number_format($vatExempt, 2);
                                $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                $transactionsData['less_vat'] = number_format($lessVat, 2);

                                $transactionsData['add_nvat'] = number_format(0, 2);
                            }
                        } else { // No discount, apply regular VAT rules
                            $transactionsData['vat_exempt'] = number_format(0, 2);
                            $transactionsData['less_vat'] = number_format(0, 2);
                            $transactionsData['vat'] = number_format($totalVat, 2);
                            $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                            $transactionsData['net_of_disc'] = number_format(0, 2);
                            $transactionsData['net_of_vat'] = number_format(0, 2);
                            $transactionsData['add_nvat'] = number_format(0, 2);
                        }

                        $transactionsData['zero_rated'] = 0;
                        $transactionsData['transact_status'] = 1;
                        $transactionsData['non_vat'] = $nonVatSales;
                        $transactionsData['paymode'] = $paymode;
                        $transactionsData['status'] = 1;
                        $transactionsData['min'] = $company['min'];
                        $transactionsData['sn'] = $ptu['sn'];
                        $transactionsData['ptu_num'] = $ptuData['BIR_SN'];
                        $transactionsData['ptu_date'] = $ptuData['issued_date'];

                        // echo json_encode($transactionsData);
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

                        // echo $remainingBalance;
                        // echo "<br>";
                        // echo $transactionsData['earned_amount'];
                        // echo "<br>";
                        $remainingBalance = $remainingBalance + $transactionsData['earned_amount'];
                        // echo $remainingBalance;
                        $remainingData = array('terminal_id' => $terminalId, 'id' => $cashDrawer['id'], 'remaining' => $remainingBalance);
                        $this->model_touchpoint->updateDrawerBalance($remainingData);

                        /******** printing process    */
                        if ($postTransaction) {
                            $discType = "";
                            if ($discountType == 'senior') {
                                $discType = "Senior Citizen";
                                $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                            } else if ($discountType == "pwd") {
                                $discType = "PWD";
                                // $discPercent = "20%";
                                $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                            } else if ($discountType == "naac") {
                                $discType = "NAAC";
                                $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                            } else if ($discountType == "sp") {
                                $discType = "Solo Parent";
                                $discPercent = ($this->input->post("vehicleClass")) == 2 ? "10%" : "10%";
                            } else if ($discountType == "tenant") {
                                $discType = "Tenant";
                                $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                            } else {
                                $discType = "No";
                                $discPercent = "0%";
                            }

                            // refactored code
                            $receipt = array(
                                'transactionId' => $OR,
                                'entryTime' => $this->input->post("entryTime"),
                                'paymentTime' => $this->input->post("paymentTime"),
                                'parkingStay' => $this->input->post("parkingStay"),
                                'totalSales' => $totalSales,
                                'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                'terminalName' => "TRM001",
                                'salesInvoice' => $OR,
                                'parkingStatus' => $this->input->post("parking_status"),
                                'origAmount' => $originalAmount,
                                'totalAmountDue' => $this->input->post("parking_amount"),
                                'totalAmountDueForDC' => $this->input->post("salesamount"),
                                'cashReceived' => $cashReceived,
                                'changeDue' => $changeAmount,
                                'discount' => $totalDiscount,
                                'discountType' => $this->input->post("discount_type"),
                                'discountDisplay' => $discType,
                                'discPercent' => $discPercent,
                                'paymentMode' => $paymode,
                                'accessType' => $this->input->post("access_type"),
                                'parkingCode' => $this->input->post("parking_code"),
                                'vehicleClass' => $this->input->post("vehicleClass"),

                                'ptuName' => $ptu['name'],
                                'ptuVendor' => $ptu['vendor'],
                                'ptuAccreditation' => $ptu['accreditation'],
                                'ptuAccreditDate' => $ptu['accreditDate'],
                                'ptuValidDate' => $ptu['validDate'],
                                'ptuSerialNo' => $ptu['serialNo'],
                                'ptuIssuedDate' => $ptu['issuedDate'],
                                'ptuSN' => $ptu['sn'],

                                'companyName' => $company['company'],
                                'companyAddress' => $company['address'],
                                'companyTelephone' => $company['telephone'],
                                'companyTin' => $company['tin'],
                                'companyMin' => $company['min']
                            );

                            // If there is a discount
                            if ($discountType != "none") {

                                if ($vatExempt == 0) { // Tenant, NAAC
                                    $receipt['vatExempt'] = 0; // Not exempt
                                    $receipt['vatAmount'] = round($totalVat, 2); // Proper VAT calculation 
                                    $receipt['vatableSales'] = round($vatableSale, 2); // Assign computed vatable sales
                                    $receipt['lessVat'] = round($totalVat, 2); // Proper VAT calculation 
                                    $receipt['netofVat'] = round($vatableSale, 2);                            // 53.57
                                    $receipt['netofdisc'] = number_format($netOfDisc, 2); // 42.86
                                    $receipt['addNVat'] = round($addNvat, 2);                                // 6.43
                                    if ($discountType == "naac") {
                                        $receipt['vatExempt'] = 0;
                                        $receipt['netofdisc'] = number_format($netOfDisc, 2); // 53.57
                                        $receipt['lessVat'] = round($totalVat, 2);                                // 6.43   
                                        $receipt['addNVat'] = round($totalVat, 2);                                // 6.43
                                        $receipt['netofVat'] = round($vatableSale, 2);                            // 53.57
                                        $receipt['totalAmountDueForDC'] = round(number_format($this->input->post("netOfDisc"), 2) + round($totalVat, 2), 2); // 60
                                        $receipt['vatAmount'] = round($totalVat, 2);                              // 6.43
                                        $receipt['vatableSales'] = round($vatableSale, 2);                        // 53.57
                                    }
                                } else { // VAT-exempt PWD, SC, Solo Parent
                                    $receipt['vatExempt'] = round($vatExempt, 2);
                                    $receipt['vatAmount'] = 0.00;
                                    $receipt['vatableSales'] = 0.00;
                                    $receipt['netOfVat'] = number_format($vatExempt, 2); // vat exempt value
                                    $receipt['netofdisc'] = number_format($netOfDisc, 2);
                                    $receipt['lessVat'] = number_format($lessVat, 2);
                                }
                            } else { // No discount, apply regular VAT rules
                                $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                                $receipt['lessVat'] = round(0, 2);
                                $receipt['vatAmount'] = round($totalVat, 2);
                                $receipt['vatableSales'] = round($vatableSale, 2);

                                $receipt['netofdisc'] = number_format(0, 2);
                                $receipt['netOfVat'] = number_format(0, 2);
                                $receipt['addNVat'] = round(0, 2);

                                // Change into this if you want to show exact details
                                // $receipt['lessVat'] = round($totalVat, 2); 
                                // $receipt['netofdisc'] = number_format($vatableSale, 2); 
                                // $receipt['netOfVat'] = number_format($vatableSale, 2);
                                // $receipt['addNVat'] = round($totalVat, 2);  
                            }

                            $receipt['zeroRated'] = 0;
                            $receipt['nonVat'] = $nonVatSales;
                            // echo "receipt: ";
                            // print_r($receipt);
                            $this->data['receipt'] = $receipt;
                            $this->data['receiptData'] = json_encode($receipt);

                            if ($discountType == "none") {
                                $this->render_template("pos/success_status", $this->data);
                            } else {
                                $this->render_template("pos/customer_details", $this->data);
                            }
                        } else {
                            echo "Failed";
                        }
                        // print_r($transactionsData);
                    }

                } else if ($paymode == "GCash" || $paymode == "Paymaya") {
                    $refnumber = $this->input->post("qrphref");
                    $cashReceived = $this->input->post("salesamount");
                    $changeAmount = 0.00;

                    $amount = $this->input->post('amount');
                    // echo $refnumber;
                    $url = "https://103.95.213.254:49416/switch-card-utility/v1/transactions/" . urlencode($refnumber);

                    date_default_timezone_set('Asia/Manila');
                    $transactDate = date('Y-m-d');
                    // echo $transactDate;
                    $data = array(
                        'ref' => $refnumber,
                        'amount' => $cashReceived,
                        // 'amount' => 0.01,
                        'transact-date' => $transactDate
                    );

                    $params = array(
                        'trace-number' => $refnumber,
                        'terminal-id' => '70021415',
                        // 'amount' => number_format($amount, 2, '.', ''), 
                        'amount' => number_format(0.01, 2, '.', ''),
                        'transaction-date' => $transactDate,
                        // 'transaction-date' => '2025-02-26',
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
                        print_r($decodedResponse);
                        if ($decodedResponse) {

                            $status = $decodedResponse['Status'];

                            if ($status == "Approved") {
                                $companyId = 1;
                                $ptuId = 1;
                                $companyData = $this->model_touchpoint->getOrganization($companyId);
                                $ptuData = $this->model_touchpoint->getPtu($ptuId);
                                // echo "<script>console.log(" . json_encode($ptuData) . ");</script>";

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
                                    'sn' => $ptuData['serial'],
                                    'issuedDate' => $ptuData['issued_date']
                                );
                                $OR = sprintf('%06d', $companyData['OR'] + 1);

                                $vehicleId = $this->input->post("vehicleClass");
                                $vatExempt = $this->input->post("vatExempt");

                                $nonVatSales = 0;
                                $zeroRatedSales = 0;

                                $originalAmount = $this->input->post("parking_amount");
                                $discountType = $this->input->post('discount_type');
                                $totalVat = $this->input->post('totalVat');
                                $vatableSale = $this->input->post('vatableSale');
                                //  $totalSales = $this->input->post("total_sales");
                                $totalDiscount = $this->input->post("discountAmount");
                                $amountAfterDiscounted = $this->input->post("total_sales");
                                $totalSales = $this->input->post("salesamount");
                                $netOfDisc = $this->input->post("netOfDisc");
                                $lessVat = $this->input->post("lessVat");
                                $addNvat = $this->input->post("addNVat");

                                // refactored code
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
                                    // 'total_time' => $details['parkingStay'],
                                    'amount' => $this->input->post("parking_amount"),
                                    'earned_amount' => number_format($totalSales, 2),
                                    'cash_received' => number_format($cashReceived, 2),
                                    'change' => number_format($changeAmount, 2),
                                    'discount_type' => $this->input->post("discount_type"),
                                    'discount' => number_format($totalDiscount, 2)
                                );

                                $transactionsData['min'] = $company['min'];
                                $transactionsData['sn'] = $ptu['sn'];
                                $transactionsData['ptu_num'] = $ptuData['BIR_SN'];
                                $transactionsData['ptu_date'] = $ptuData['issued_date'];

                                // If there is a discount
                                if ($discountType != "none") {
                                    if ($vatExempt == 0) { // Tenant, NAAC (Not VAT-exempt)
                                        $transactionsData['vat_exempt'] = number_format(0, 2); // Not exempt
                                        $transactionsData['vat'] = number_format($totalVat, 2);
                                        $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                                        $transactionsData['less_vat'] = number_format($totalVat, 2);
                                        $transactionsData['net_of_vat'] = number_format($vatableSale, 2);
                                        $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                        $transactionsData['add_nvat'] = number_format($addNvat, 2);
                                        // echo $transactionsData['add_nvat'];
                                        if ($discountType == "naac") {
                                            $transactionsData['vat_exempt'] = number_format(0, 2);
                                            $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                            $transactionsData['less_vat'] = number_format($totalVat, 2);
                                            $transactionsData['add_nvat'] = number_format($totalVat, 2);
                                            $transactionsData['net_of_vat'] = number_format($vatableSale, 2);
                                            $transactionsData['earned_amount'] = number_format(number_format($this->input->post("netOfDisc"), 2) + number_format($totalVat, 2), 2);
                                            $transactionsData['vat'] = number_format($totalVat, 2);
                                            $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                                        }
                                    } else { // VAT-exempt (PWD, SC, Solo Parent)
                                        $transactionsData['vat_exempt'] = number_format($vatExempt, 2);
                                        $transactionsData['vat'] = number_format(0.00, 2);
                                        $transactionsData['vatable_sales'] = number_format(0.00, 2);
                                        $transactionsData['net_of_vat'] = number_format($vatExempt, 2);
                                        $transactionsData['net_of_disc'] = number_format($netOfDisc, 2);
                                        $transactionsData['less_vat'] = number_format($lessVat, 2);

                                        $transactionsData['add_nvat'] = number_format(0, 2);
                                    }
                                } else { // No discount, apply regular VAT rules
                                    $transactionsData['vat_exempt'] = number_format(0, 2);
                                    $transactionsData['less_vat'] = number_format(0, 2);
                                    $transactionsData['vat'] = number_format($totalVat, 2);
                                    $transactionsData['vatable_sales'] = number_format($vatableSale, 2);
                                    $transactionsData['net_of_disc'] = number_format(0, 2);
                                    $transactionsData['net_of_vat'] = number_format(0, 2);
                                    $transactionsData['add_nvat'] = number_format(0, 2);
                                }

                                $transactionsData['zero_rated'] = 0;
                                $transactionsData['transact_status'] = 1;
                                $transactionsData['non_vat'] = $nonVatSales;
                                $transactionsData['paymode'] = $paymode;
                                $transactionsData['status'] = 1;
                                $transactionsData['min'] = $company['min'];
                                $transactionsData['sn'] = $ptu['sn'];
                                $transactionsData['ptu_num'] = $ptuData['BIR_SN'];
                                $transactionsData['ptu_date'] = $ptuData['issued_date'];

                                // echo json_encode($transactionsData);
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

                                /******** printing process    */
                                if ($postTransaction) {
                                    $discType = "";
                                    if ($discountType == 'senior') {
                                        $discType = "Senior Citizen";
                                        $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                                    } else if ($discountType == "pwd") {
                                        $discType = "PWD";
                                        // $discPercent = "20%";
                                        $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                                    } else if ($discountType == "naac") {
                                        $discType = "NAAC";
                                        $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                                    } else if ($discountType == "sp") {
                                        $discType = "Solo Parent";
                                        $discPercent = ($this->input->post("vehicleClass")) == 2 ? "10%" : "10%";
                                    } else if ($discountType == "tenant") {
                                        $discType = "Tenant";
                                        $discPercent = ($this->input->post("vehicleClass")) == 2 ? "20%" : "20%";
                                    } else {
                                        $discType = "No";
                                        $discPercent = "0%";
                                    }

                                    // refactored code
                                    $receipt = array(
                                        'transactionId' => $OR,
                                        'entryTime' => $this->input->post("entryTime"),
                                        'paymentTime' => $this->input->post("paymentTime"),
                                        'parkingStay' => $this->input->post("parkingStay"),
                                        'totalSales' => $totalSales,
                                        'cashierName' => $this->session->userdata("fname") . " " . $this->session->userdata("lname"),
                                        'terminalName' => "TRM001",
                                        'salesInvoice' => $OR,
                                        'parkingStatus' => $this->input->post("parking_status"),
                                        'origAmount' => $originalAmount,
                                        'totalAmountDue' => $this->input->post("parking_amount"),
                                        'totalAmountDueForDC' => $this->input->post("salesamount"),
                                        'cashReceived' => $cashReceived,
                                        'changeDue' => $changeAmount,
                                        'discount' => $totalDiscount,
                                        'discountType' => $this->input->post("discount_type"),
                                        'discountDisplay' => $discType,
                                        'discPercent' => $discPercent,
                                        'paymentMode' => $paymode,
                                        'accessType' => $this->input->post("access_type"),
                                        'parkingCode' => $this->input->post("parking_code"),
                                        'vehicleClass' => $this->input->post("vehicleClass"),

                                        'ptuName' => $ptu['name'],
                                        'ptuVendor' => $ptu['vendor'],
                                        'ptuAccreditation' => $ptu['accreditation'],
                                        'ptuAccreditDate' => $ptu['accreditDate'],
                                        'ptuValidDate' => $ptu['validDate'],
                                        'ptuSerialNo' => $ptu['serialNo'],
                                        'ptuIssuedDate' => $ptu['issuedDate'],
                                        'ptuSN' => $ptu['sn'],

                                        'companyName' => $company['company'],
                                        'companyAddress' => $company['address'],
                                        'companyTelephone' => $company['telephone'],
                                        'companyTin' => $company['tin'],
                                        'companyMin' => $company['min']
                                    );

                                    // If there is a discount
                                    if ($discountType != "none") {

                                        if ($vatExempt == 0) { // Tenant, NAAC
                                            $receipt['vatExempt'] = 0; // Not exempt
                                            $receipt['vatAmount'] = round($totalVat, 2); // Proper VAT calculation 
                                            $receipt['vatableSales'] = round($vatableSale, 2); // Assign computed vatable sales
                                            $receipt['lessVat'] = round($totalVat, 2); // Proper VAT calculation 
                                            $receipt['netofVat'] = round($vatableSale, 2);                            // 53.57
                                            $receipt['netofdisc'] = number_format($netOfDisc, 2); // 42.86
                                            $receipt['addNVat'] = number_format($addNvat, 2); // 6.43
                                            if ($discountType == "naac") {
                                                $receipt['vatExempt'] = 0;
                                                $receipt['netofdisc'] = number_format($netOfDisc, 2); // 53.57
                                                $receipt['lessVat'] = round($totalVat, 2);                                // 6.43   
                                                $receipt['addNVat'] = round($totalVat, 2);                                // 6.43
                                                $receipt['netofVat'] = round($vatableSale, 2);                            // 53.57
                                                $receipt['totalAmountDueForDC'] = round(number_format($this->input->post("netOfDisc"), 2) + round($totalVat, 2), 2); // 60
                                                $receipt['vatAmount'] = round($totalVat, 2);                              // 6.43
                                                $receipt['vatableSales'] = round($vatableSale, 2);                        // 53.57
                                            }
                                        } else { // VAT-exempt PWD, SC, Solo Parent
                                            $receipt['vatExempt'] = round($vatExempt, 2);
                                            $receipt['vatAmount'] = 0.00;
                                            $receipt['vatableSales'] = 0.00;
                                            $receipt['netOfVat'] = number_format($vatExempt, 2); // vat exempt value
                                            $receipt['netofdisc'] = number_format($netOfDisc, 2);
                                            $receipt['lessVat'] = number_format($lessVat, 2);
                                        }
                                    } else { // No discount, apply regular VAT rules
                                        $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                                        $receipt['lessVat'] = round(0, 2);
                                        $receipt['vatAmount'] = round($totalVat, 2);
                                        $receipt['vatableSales'] = round($vatableSale, 2);

                                        $receipt['netofdisc'] = number_format(0, 2);
                                        $receipt['netOfVat'] = number_format(0, 2);
                                        $receipt['addNVat'] = round(0, 2);

                                        // Change into this if you want to show exact details
                                        // $receipt['lessVat'] = round($totalVat, 2); 
                                        // $receipt['netofdisc'] = number_format($vatableSale, 2); 
                                        // $receipt['netOfVat'] = number_format($vatableSale, 2);
                                        // $receipt['addNVat'] = round($totalVat, 2);  
                                    }

                                    $receipt['zeroRated'] = 0;
                                    $receipt['nonVat'] = $nonVatSales;

                                    // Testing purposes
                                    // echo "receipt: ";
                                    // print_r($receipt);

                                    $this->data['receipt'] = $receipt;
                                    $this->data['receiptData'] = json_encode($receipt);

                                    if ($discountType == "none") {
                                        $this->render_template("pos/success_status", $this->data);
                                    } else {
                                        $this->render_template("pos/customer_details", $this->data);
                                    }
                                } else {
                                    echo "Failed";
                                }
                            } else {
                                echo "Failed";
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

                    $code = trim($this->input->post("compcode"));
                    $OR = sprintf('%06d', 000000 + 1);
                    $verifyCode = $this->model_touchpoint->getComplimentary($code);
                    $currentDate = date('Y-m-d');

                    $status = '';

                    $nonVatSales = 0;
                    $zeroRatedSales = 0;

                    $originalAmount = $this->input->post("parking_amount");
                    $discountType = $this->input->post('discount_type');
                    $totalVat = $this->input->post('totalVat');
                    $vatableSale = $this->input->post('vatableSale');
                    //  $totalSales = $this->input->post("total_sales");
                    $totalDiscount = $this->input->post("discountAmount");
                    $amountAfterDiscounted = $this->input->post("total_sales");
                    $totalSales = $this->input->post("salesamount");
                    $netOfDisc = $this->input->post("netOfDisc");
                    $lessVat = $this->input->post("lessVat");
                    $addNvat = $this->input->post("addNVat");

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

                        $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                        $receipt['lessVat'] = round(0, 2);
                        $receipt['vatAmount'] = round($totalVat, 2);
                        $receipt['vatableSales'] = round($vatableSale, 2);

                        $receipt['netofdisc'] = number_format(0, 2);
                        $receipt['netOfVat'] = number_format(0, 2);
                        $receipt['addNVat'] = round(0, 2);

                        // print_r($receipt);
                        $this->data['receipt'] = $receipt;
                        $this->data['voucherStatus'] = $status;
                        $this->data['receiptData'] = json_encode($receipt);
                        $this->render_template("pos/failed_payment", $this->data);
                    } else if ($currentDate > $verifyCode['end_date']) {
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

                        $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                        $receipt['lessVat'] = round(0, 2);
                        $receipt['vatAmount'] = round($totalVat, 2);
                        $receipt['vatableSales'] = round($vatableSale, 2);

                        $receipt['netofdisc'] = number_format(0, 2);
                        $receipt['netOfVat'] = number_format(0, 2);
                        $receipt['addNVat'] = round(0, 2);

                        print_r($receipt);
                        $this->data['voucherStatus'] = $status;
                        $this->data['receipt'] = $receipt;
                        $this->render_template("pos/failed_payment", $this->data);
                    } else if ($currentDate < $verifyCode['start_date']) {
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

                        $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                        $receipt['lessVat'] = round(0, 2);
                        $receipt['vatAmount'] = round($totalVat, 2);
                        $receipt['vatableSales'] = round($vatableSale, 2);

                        $receipt['netofdisc'] = number_format(0, 2);
                        $receipt['netOfVat'] = number_format(0, 2);
                        $receipt['addNVat'] = round(0, 2);

                        print_r($receipt);
                        $this->data['voucherStatus'] = $status;
                        $this->data['receipt'] = $receipt;
                        $this->render_template("pos/failed_payment", $this->data);
                    } else {
                        // echo "Success";
                        $companyId = 1;
                        $ptuId = 1;
                        $companyData = $this->model_touchpoint->getOrganization($companyId);
                        $ptuData = $this->model_touchpoint->getPtu($ptuId);
                        // echo "<script>console.log(" . json_encode($ptuData) . ");</script>";

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
                            'sn' => $ptuData['serial'],
                            'issuedDate' => $ptuData['issued_date']
                        );

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

                        $transactionsData['vat_exempt'] = number_format(0, 2);
                        $transactionsData['less_vat'] = number_format(0, 2);
                        $transactionsData['vat'] = number_format(0, 2);
                        $transactionsData['vatable_sales'] = number_format(0, 2);
                        $transactionsData['net_of_disc'] = number_format(0, 2);
                        $transactionsData['net_of_vat'] = number_format(0, 2);
                        $transactionsData['add_nvat'] = number_format(0, 2);

                        $transactionsData['zero_rated'] = 0;
                        $transactionsData['transact_status'] = 1;
                        $transactionsData['non_vat'] = $nonVatSales;
                        $transactionsData['paymode'] = $paymode;
                        $transactionsData['status'] = 1;
                        $transactionsData['min'] = $company['min'];
                        $transactionsData['sn'] = $ptu['sn'];
                        $transactionsData['ptu_num'] = $ptuData['BIR_SN'];
                        $transactionsData['ptu_date'] = $ptuData['issued_date'];
                        print_r($transactionsData);
                        $postTransaction = $this->model_touchpoint->createTransaction($transactionsData);
                        if ($postTransaction) {
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

                                'ptuName' => $ptu['name'],
                                'ptuVendor' => $ptu['vendor'],
                                'ptuAccreditation' => $ptu['accreditation'],
                                'ptuAccreditDate' => $ptu['accreditDate'],
                                'ptuValidDate' => $ptu['validDate'],
                                'ptuSerialNo' => $ptu['serialNo'],
                                'ptuIssuedDate' => $ptu['issuedDate'],
                                'ptuSN' => $ptu['sn'],

                                'companyName' => $company['company'],
                                'companyAddress' => $company['address'],
                                'companyTelephone' => $company['telephone'],
                                'companyTin' => $company['tin'],
                                'companyMin' => $company['min']
                            );

                            $receipt['vatExempt'] = 0; // Regular transactions not VAT-exempt
                            $receipt['lessVat'] = round(0, 2);
                            $receipt['vatAmount'] = round(0, 2);
                            $receipt['vatableSales'] = round(0, 2);

                            $receipt['netofdisc'] = number_format(0, 2);
                            $receipt['netOfVat'] = number_format(0, 2);
                            $receipt['addNVat'] = round(0, 2);

                            print_r($receipt);
                            $this->data['receipt'] = $receipt;
                            $this->data['receiptData'] = json_encode($receipt);
                            $this->render_template("pos/success_payment", $this->data);
                        } else {
                            echo "Failed";
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

    public function addCustomerDetail()
    {
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

                if ($createDiscountRecord == true) {
                    $this->load->view('templates/header');
                    $this->render_template('pos/success_page', $this->data);
                } else {
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

    public function transactions()
    {
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

    public function reprint()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $transactions = $this->model_touchpoint->getTransactionsForReprint();
            $this->data['transactions'] = $transactions;
            $this->load->view('templates/header');
            $this->render_template('pos/receipts', $this->data);
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function reprintReceipt()
    {
        $companyId = 1;
        $companyData = $this->model_touchpoint->getOrganization($companyId);

        $company = array(
            'company' => $companyData['name'],
            'address' => $companyData['address'],
            'telephone' => $companyData['telephone'],
            'tin' => $companyData['TIN'],
            'min' => $companyData['MIN']
        );

        $id = $this->input->post('ornumber');
        $transaction = $this->model_touchpoint->getReceipt($id);

        $cashierId = $transaction['cashier_id'];
        $cashier = $this->model_users->getUserData($cashierId);

        // Testing purposes
        // echo "<pre>";
        // print_r($cashier);
        // print_r($transaction);
        // print_r($company);
        // echo "</pre>";

        $this->data['cashier'] = $cashier;
        $this->data['receipt'] = $transaction;
        $this->data['company'] = $company;
        $this->load->view('templates/header');
        $this->render_template('pos/reprint_receipt', $this->data);
    }

    public function transactionHistory()
    {
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

    public function reports()
    {
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
    /******************************************* */
    public function xreport()
    {
        $user_id = $this->session->userdata('id');
        $user_id = 12;
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

    public function xreadingGenerate()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        date_default_timezone_set("Asia/Manila");
        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $terminalId = $this->input->post('terminal');
                $cashierId = $this->input->post('cashier');
                // $cashierId = 12; // Testing purposes
                $selectedDate = $this->input->post('date');
                echo "Selected Date: " . $selectedDate;
                echo "Cashier ID: " . $cashierId;
                echo "Terminal ID: " . $terminalId;

                $data = $this->model_touchpoint->getXreadingData($selectedDate, $cashierId, $terminalId);

                $data['reportDate'] = date('F d, Y');
                $data['reportTime'] = date('H:i A');
                $data['cashierName'] = $this->session->userdata("fname") . " " . $this->session->userdata("lname");
                $data['terminalName'] = "TRM001";
                // $data['startDateandTime'] = date('m/d/y h:i A', strtotime('08:00 AM'));
                // $data['endDateandTime'] = date('m/d/y H:i A');
                $data['startDateandTime'] = date('m/d/y h:i A', strtotime($selectedDate . ' 08:00 AM'));
                $data['endDateandTime'] = date('m/d/y H:i A', strtotime($selectedDate . date('H:i:s')));
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

    public function zreport()
    {
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

    public function zreadingGenerate()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            // $terminalId = 1;
            $terminalId = $this->input->post('terminal');
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {
                $terminalId = $this->input->post('terminal');
                $cashierId = $this->input->post('cashier');
                $selectedDate = $this->input->post('date');

                $data = $this->model_touchpoint->getZreadingData($selectedDate, $cashierId, $terminalId);

                // Change Z-Status to 1
                // $zStatusSet = $this->model_ptu->edit(array('z_status' => 1), $terminalId);
                // if($zStatusSet){
                //     echo "Z-Status set to 1";
                // } else {
                //     echo "Z-Status not set to 1";
                // }
                // print_r($data);


                // Fetch z counter from company table
                $companyId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $data['zCounter'] = $companyData['z_counter'];

                // Fetch PTU data from PTU table
                $ptuData = $this->model_touchpoint->getPtu($terminalId);
                $data['ptuName'] = $ptuData['name'];

                $data['reportDate'] = date('F d, Y');
                date_default_timezone_set('Asia/Manila');
                $data['reportTime'] = date('g:i A');
                $data['cashierName'] = $this->session->userdata("fname") . " " . $this->session->userdata("lname");
                // $data['terminalName'] = "TRM001";
                // $data['startDateandTime'] = date('m/d/y h:i A', strtotime('08:00 AM'));
                // $data['endDateandTime'] = date('m/d/y H:i A');
                $data['startDateandTime'] = date('m/d/y h:i A', strtotime($selectedDate . ' 08:00 AM'));
                $data['endDateandTime'] = date('m/d/y H:i A', strtotime($selectedDate . ' 23:59:59'));
                $data['terminalId'] = $terminalId; // Pass terminalId to data array
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

    public function setZstatus($terminalId)
    {
        if ($terminalId) {

            $num = 1; // This is the Z-Status value

            $zStatusSet = $this->model_ptu->edit(array('z_status' => $num), $terminalId);
            if ($zStatusSet) {

                $companyId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $updateComp = [
                    'id' => $companyData['id'],
                    'z_counter' => $companyData['z_counter'] + 1
                ];
                if (!$this->model_touchpoint->updateCompany($updateComp)) {
                    $response = ['status' => 'error', 'message' => 'Updating Z counter failed'];
                    echo "<script>console.log(" . json_encode($response) . ");</script>";
                    return;
                }
                $response = ['status' => 'success', 'message' => 'Z-Status set to 1'];
            } else {
                $response = array('status' => 'error', 'message' => 'Z-Status not set to 1');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'No number');
        }
        echo json_encode($response);
    }


    public function ejournal()
    {
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



    // public function ejournalGenerate()
    // {
    //     $user_id = $this->session->userdata('id');
    //     $position = $this->model_users->getUserGroup($user_id);

    //     if ($position['id'] == 5) {
    //         $terminalId = 1;
    //         $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

    //         if ($cashDrawer) {
    //             $startDate = $this->input->post('start_date');
    //             $endDate = $this->input->post('end_date');
    //             $cashierId = $this->input->post('cashier');
    //             $terminalId = $this->input->post('terminal');

    //             $companyId = 1;
    //             $terminalId = 1;
    //             $companyData = $this->model_touchpoint->getOrganization($companyId);
    //             $ptuData = $this->model_touchpoint->getPtu($terminalId);

    //             $data = $this->model_touchpoint->geteJournalData($startDate, $endDate, $cashierId, $terminalId);

    //             // Create a new FPDF instance
    //             $pdf = new FPDF('L'); // Landscape orientation
    //             $pdf->AddPage();
    //             $pdf->SetFont('Arial', 'B', 14); // Adjusted font size

    //             // Add the title
    //             $pdf->Cell(0, 8, 'e-Journal Report', 0, 1, 'C'); // Reduced height for title

    //             // Date range and other info
    //             $pdf->SetFont('Arial', '', 11); // Smaller font size
    //             $pdf->Cell(0, 8, 'Date Range: ' . $startDate . ' to ' . $endDate, 0, 1, 'C');
    //             $pdf->Cell(0, 8, 'Cashier ID: ' . $cashierId . ' | Terminal ID: ' . $terminalId, 0, 1, 'C');
    //             $pdf->Ln(5); // Reduced line break

    //             // Company information
    //             $pdf->SetFont('Arial', 'B', 14); // Smaller font size
    //             $pdf->Cell(0, 8, 'Company Information', 0, 1);
    //             $pdf->SetFont('Arial', '', 11); // Smaller font size
    //             $pdf->Cell(40, 8, 'Company: ' . htmlspecialchars($companyData['name']), 0, 1);
    //             $pdf->Cell(40, 8, 'Address: ' . htmlspecialchars($companyData['address']), 0, 1);
    //             $pdf->Cell(40, 8, 'Telephone: ' . htmlspecialchars($companyData['telephone']), 0, 1);
    //             $pdf->Cell(40, 8, 'TIN: ' . htmlspecialchars($companyData['TIN']), 0, 1);
    //             $pdf->Cell(40, 8, 'MIN: ' . htmlspecialchars($companyData['MIN']), 0, 1);
    //             $pdf->Ln(5); // Reduced line break

    //             // PTU information
    //             $pdf->SetFont('Arial', 'B', 14); // Smaller font size
    //             $pdf->Cell(0, 8, 'PTU Information', 0, 1);
    //             $pdf->SetFont('Arial', '', 11); // Smaller font size
    //             $pdf->Cell(40, 8, 'Name: ' . htmlspecialchars($ptuData['name']), 0, 1);
    //             $pdf->Cell(40, 8, 'Vendor: ' . htmlspecialchars($ptuData['vendor']), 0, 1);
    //             $pdf->Cell(40, 8, 'Accreditation: ' . htmlspecialchars($ptuData['accredition']), 0, 1);
    //             $pdf->Cell(40, 8, 'Accredit Date: ' . htmlspecialchars($ptuData['accredit_date']), 0, 1);
    //             $pdf->Cell(40, 8, 'Valid Date: ' . htmlspecialchars($ptuData['valid_date']), 0, 1);
    //             $pdf->Cell(40, 8, 'Serial Number: ' . htmlspecialchars($ptuData['BIR_SN']), 0, 1);
    //             $pdf->Cell(40, 8, 'Issued Date: ' . htmlspecialchars($ptuData['issued_date']), 0, 1);
    //             $pdf->Ln(5); // Reduced line break

    //             // Add new page for table
    //             $pdf->AddPage();

    //             // Start the table for e-Journal Data
    //             $pdf->SetFont('Arial', 'B', 7); // Smaller font size for table headers
    //             $pdf->Cell(30, 8, 'Transaction ID', 1, 0, 'C');
    //             $pdf->Cell(20, 8, 'SI Number', 1, 0, 'C');
    //             // $pdf->Cell(20, 8, 'Access Type', 1, 0,'C');
    //             $pdf->Cell(15, 8, 'Vehicle', 1, 0, 'C');
    //             // $pdf->Cell(20, 8, 'Cashier', 1, 0,'C');
    //             // $pdf->Cell(15, 8, 'Terminal', 1, 0,'C');
    //             // $pdf->Cell(30, 8, 'Gate In', 1, 0,'C');
    //             $pdf->Cell(30, 8, 'Billing Time', 1, 0, 'C');
    //             $pdf->Cell(20, 8, "Vatable Sales", 1, 0, 'C', false, '');
    //             $pdf->Cell(20, 8, "Vat-Exempt", 1, 0, 'C', false, '');
    //             $pdf->Cell(20, 8, 'Total Sales', 1, 0, 'C', false, '');
    //             $pdf->Cell(15, 8, 'VAT', 1, 0, 'C', false, '');
    //             $pdf->Cell(23, 8, 'Total Amount Due', 1, 0, 'C', false, '');
    //             $pdf->Cell(23, 8, 'Cash Received', 1, 0, 'C', false, '');
    //             $pdf->Cell(23, 8, 'Discount', 1, 0, 'C', false, '');
    //             $pdf->Cell(23, 8, 'Payment Mode', 1, 0, 'C', false, '');
    //             $pdf->Ln();

    //             // Insert data into the table
    //             foreach ($data as $row) {
    //                 $vehicleId = $row['vehicle_cat_id'];
    //                 $vehicle = $vehicleId == "1" ? "Motorcycle" : ($vehicleId == "2" ? "Car" : ($vehicleId == "3" ? "BUS/Truck" : "Unknown"));

    //                 $userid = $row['cashier_id'];
    //                 $pid = $row['pid'];

    //                 $profile = $this->model_touchpoint->getUserData($userid);
    //                 $terminal = $this->model_touchpoint->getTerminalData($pid);

    //                 $totalAmountd = floatval($row['earned_amount']);

    //                 // Add row to the table
    //                 $pdf->SetFont('Arial', '', 7); // Smaller font size for table content
    //                 $pdf->Cell(30, 8, htmlspecialchars($row['id']), 1, 0, 'C');
    //                 $pdf->Cell(20, 8, htmlspecialchars($row['ornumber']), 1, 0, 'C'); // Wrap text if needed
    //                 // $pdf->Cell(20, 8, htmlspecialchars($row['access_type']), 1, 0, 'C'); // Wrap text if needed
    //                 $pdf->Cell(15, 8, $vehicle, 1, 0, 'C'); // Wrap text if needed
    //                 // $pdf->Cell(20, 8, htmlspecialchars($profile['firstname'] . ' ' . $profile['lastname']), 1, 0, 'C'); // Wrap text if needed
    //                 // $pdf->Cell(15, 8, htmlspecialchars($terminal['name']), 1, 0, 'C'); // Wrap text if needed
    //                 // $pdf->Cell(30, 8, date('Y-m-d H:i:s A', $row['in_time']), 1);
    //                 date_default_timezone_set("Asia/Manila");
    //                 $pdf->Cell(30, 8, date('Y-m-d H:i:s A', $row['paid_time']), 1, 0, 'C');
    //                 $pdf->Cell(20, 8, htmlspecialchars(number_format($row['vatable_sales'], 2)), 1, 0, 'C');
    //                 $pdf->Cell(20, 8, htmlspecialchars(number_format($row['vat_exempt'], 2)), 1, 0, 'C');
    //                 $pdf->Cell(20, 8, htmlspecialchars(number_format($row['earned_amount']), 2), 1, 0, 'C');
    //                 $pdf->Cell(15, 8, htmlspecialchars(!empty($row['vat']) ? number_format($row['vat'], 2) : '0.00'), 1, 0, 'C');
    //                 $pdf->Cell(23, 8, htmlspecialchars(!empty($totalAmountd) ? number_format($totalAmountd, 2) : '0.00'), 1, 0, 'C');
    //                 $pdf->Cell(23, 8, htmlspecialchars(!empty($row['cash_received']) ? number_format($row['cash_received'], 2) : '0.00'), 1, 0, 'C');
    //                 $pdf->Cell(23, 8, htmlspecialchars(!empty($row['discount']) ? number_format($row['discount'], 2) : '0.00'), 1, 0, 'C');
    //                 $pdf->Cell(23, 8, htmlspecialchars(!empty($row['paymode']) ? $row['paymode'] : '0.00'), 1, 0, 'C');
    //                 $pdf->Ln();
    //             }

    //             // Output the PDF to the browser
    //             $pdf->Output('D', 'eJournalReport_' . date('Ymd_His') . '.pdf');
    //         } else {
    //             $this->load->view('balance');
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', 'You are not a cashier');
    //         redirect('auth/login');
    //     }
    // }

    // back up ejournal generate function

    public function ejournalGenerate()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        $userData = $this->model_users->getUserData($user_id);

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
                    'issuedDate' => $ptuData['issued_date'],
                    'sn' => $ptuData['serial'],
                );


                $data = $this->model_touchpoint->geteJournalData($startDate, $endDate, $cashierId, $terminalId);
                // print_r($data);
                $fileName = "eJournalReport_" . date('Ymd') . ".txt";
                $content = "e-Journal Report\n";
                $content .= "Cashier ID: $cashierId\n";
                $content .= "Cashier Name: " . $userData['firstname'] . " " . $userData['lastname'] . "\n";
                $content .= "Terminal ID: $terminalId\n";
                $content .= "Terminal Name: " . $ptu['name'] . "\n";
                $content .= "Date Range: $startDate to $endDate\n";
                $content .= "-------------------------------------------------------\n";

                function formatLine($label, $value, $totalWidth = 55)
                {
                    $labelWidth = strlen($label);
                    $valueWidth = strlen($value);
                    $spaces = $totalWidth - ($labelWidth + $valueWidth);
                    return $label . str_repeat(" ", $spaces) . $value . "\n";
                }

                function centerText($text, $width = 55)
                {
                    $text = trim($text);
                    $padding = max(0, ($width - strlen($text)) / 2);
                    return str_repeat(" ", floor($padding)) . $text . str_repeat(" ", ceil($padding)) . "\n";
                }

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

                    $discountType = $row['discount_type'];

                    switch ($discountType) {
                        case "pwd":
                            $discountType = "PWD";
                            $percent = "20%";
                            break;
                        case "senior":
                            $discountType = "Senior Citizen";
                            $percent = "20%";
                            break;
                        case "tenant":
                            $discountType = "Tenant";
                            $percent = "20%";
                            break;
                        case "naac":
                            $discountType = "NAAC";
                            $percent = "20%";
                            break;
                        case "sp":
                            $discountType = "Solo Parent";
                            $percent = "10%";
                            break;
                        case "none":
                            $discountType = "No";
                            $percent = "0%";
                            break;
                        default:
                            $discountType = "No";
                            $percent = "0%";
                            break;
                    }

                    $userid = $row['cashier_id'];
                    $pid = $row['pid'];

                    $profile = $this->model_touchpoint->getUserData($userid);
                    $terminal = $this->model_touchpoint->getTerminalData($pid);

                    // $totalAmountd = floatval($row['earned_amount']) + floatval($row['vat']);



                    // Example Usage:
                    // $content = "";
                    $content .= centerText("PICC");
                    $content .= centerText($companyData['name']);
                    $content .= centerText($companyData['address']);
                    $content .= centerText("VAT REG TIN: " . $companyData['TIN']);
                    $content .= centerText("MIN: " . $row['min']);
                    $content .= centerText("SN: " . $row['sn']);
                    $content .= centerText($companyData['telephone']);
                    $content .= "\n";

                    $content .= centerText("Date and Time: " . date('Y-m-d H:i:s A', $row['paid_time']));
                    $content .= centerText("S/I: " . "00-" . $row['ornumber']);
                    $content .= centerText($row['access_type'] . ": " . $row['parking_code']);
                    $content .= centerText("Vehicle: " . $vehicle);
                    $content .= "\n";
                    $content .= "                     Sales Invoice\n\n";
                    $content .= formatLine("Cashier:", $profile['firstname'] . " " . $profile['lastname']);
                    $content .= formatLine("Terminal:", $terminal['name']);
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Gate In:", date('Y-m-d H:i:s A', $row['in_time']));
                    $content .= formatLine("Billing Time:", date('Y-m-d H:i:s A', $row['paid_time']));
                    $totalTime = explode(':', $row['total_time']);
                    $content .= formatLine("Parking Time:", "{$totalTime[0]}hrs{$totalTime[1]}mins");
                    $content .= formatLine("Total Sales:", number_format($row['amount'], 2));
                    $content .= formatLine("Less VAT (12%):", number_format($row['less_vat'], 2));
                    $content .= formatLine("Net of VAT:", number_format($row['net_of_vat'], 2));
                    $content .= formatLine("Less " . $discountType . " Disc (" . $percent . "):", number_format($row['discount'], 2));
                    $content .= formatLine("Net of Disc:", number_format($row['net_of_disc'], 2));
                    $content .= formatLine("Add 12% VAT:", number_format($row['add_nvat'], 2));
                    $content .= formatLine("Total Amount Due:", number_format($row['earned_amount'], 2));
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Cash Received:", number_format($row['cash_received'], 2));
                    $content .= formatLine("Cash Change:", number_format($row['change'], 2));
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Vatable Sales:", number_format($row['vatable_sales'], 2));
                    $content .= formatLine("VAT Amount:", number_format($row['vat'], 2));
                    $content .= formatLine("VAT-Exempt:", number_format($row['vat_exempt'], 2));
                    $content .= formatLine("Zero-Rated Sales:", number_format($row['zero_rated'], 2));
                    $content .= formatLine("Payment Mode:", $row['paymode']);
                    $content .= "\n";
                    $content .= centerText("BIR PTU NO: " . $row['ptu_num']);
                    $content .= centerText("PTU ISSUED DATE: " . $row['ptu_date']);
                    $content .= "          THIS SERVES AS YOUR SALES INVOICE\n\n";
                    $content .= "=========================================================\n\n";
                }

                // Convert the dates to DateTime objects
                $start = new DateTime($startDate);
                $end = new DateTime($endDate);

                // Create an array to store the dates
                $dateRange = [];

                // Loop through the date range and add each date to the array
                while ($start <= $end) {
                    $dateRange[] = $start->format('Y-m-d');
                    $start->modify('+1 day');
                }

                // Test Print the output
                // print_r($dateRange);
                $user_id = $this->session->userdata('id');
                $position = $this->model_users->getUserGroup($user_id);

                if ($position['id'] != 5) {
                    $this->session->set_flashdata('error', 'You are not a cashier');
                    redirect('auth/login');
                    return;
                }

                $terminalId = $this->input->post('terminal');
                $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

                if (!$cashDrawer) {
                    $this->load->view('balance');
                    return;
                }

                foreach($dateRange as $date) {
                    $cashiers = $this->model_touchpoint->getCashierList();
                    $terminals = $this->model_touchpoint->getTerminalList();

                    $xreading = $this->model_touchpoint->getXReadingData($date, $cashierId, $terminalId);
                    $content .= centerText("PICC");
                    $content .= centerText($companyData['name']);
                    $content .= centerText($companyData['address']);
                    $content .= centerText("VAT REG TIN: " . $companyData['TIN']);
                    $content .= centerText("MIN: " . $company['min']);
                    $content .= centerText("SN: " . $ptu['sn']);
                    $content .= centerText("Telephone: ". $companyData['telephone']);
                    $content .= "\n";
                    $content .= centerText("X-READING REPORT");
                    $content .= "\n";
                    $content .= formatLine("Report Date:", $date);
                    $content .= "\n";
                    $content .= formatLine("Start Date & Time:", $date . " 8:00 AM");
                    $content .= formatLine("End Date & Time:", $date . " 11:59 PM");
                    $content .= "\n";
                    $content .= formatLine("Cashier: ", $userData['firstname'] . " " . $userData['lastname']);
                    $content .= formatLine("Terminal: ", $ptu['name']);

                    $content .= formatLine("Beg. SI #:", "00-" . $xreading['beginOrNumber']);
                    $content .= formatLine("End. SI #:", "00-" . $xreading['endOrNumber']);
                    $content .= formatLine("Opening Fund:", number_format($xreading['openingFund'], 2));
                    $content .= "\n";
                    $content .= "-------------------------------------------------------\n";
                    $content .= centerText("Payments Received");
                    $content .= formatLine("Cash:", number_format($xreading['cashPayments'], 2));
                    $content .= formatLine("Gcash:", number_format($xreading['gcashPayments'], 2));
                    $content .= formatLine("Paymaya:", number_format($xreading['paymayaPayments'], 2));
                    $content .= formatLine("Total Payments Received:", number_format($xreading['totalPaymentsReceived'], 2));
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Void:", number_format($xreading['voidAmount'], 2));
                    $content .= formatLine("Refund:", number_format($xreading['refundAmount'], 2));
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Withdrawals:", number_format($xreading['totalWithdrawals'], 2));
                    $content .= "-------------------------------------------------------\n";
                    $content .= formatLine("Cash in Drawer:", number_format($xreading['cashInDrawer'], 2));
                    $content .= formatLine("Gcash:", number_format($xreading['gcashPayments'], 2));
                    $content .= formatLine("Paymaya:", number_format($xreading['paymayaPayments'], 2));
                    $content .= formatLine("Opening Fund:", number_format($xreading['openingFund'], 2));
                    $content .= formatLine("Less Withdrawal:", number_format($xreading['lessWithdrawal'], 2));
                    $content .= formatLine("Payments Received:", number_format($xreading['totalPaymentsReceived'], 2));
                    $content .= formatLine("Short/Over:", number_format($xreading['shortOver'], 2));
                    $content .= "=========================================================\n\n";
                }   

                foreach ($dateRange as $date) {
                    // echo "Date: " . $date . "\n";
                    // $cashiers = $this->model_touchpoint->getCashierList();
                    // $terminals = $this->model_touchpoint->getTerminalList();

                    // Fetch Z-Reading data for the given date, cashier and terminal
                    $zreading = $this->model_touchpoint->getZReadingData($date, $cashierId, $terminalId);

                    // Append the formatted data to $content using the same style as the sample
                    $content .= centerText("PICC");
                    $content .= centerText($companyData['name']);
                    $content .= centerText($companyData['address']);
                    $content .= centerText("VAT REG TIN: " . $companyData['TIN']);
                    // $content .= centerText("MIN: " . $zreading['min']);
                    $content .= centerText("MIN: 234290423");
                    $content .= centerText("SN: " . $ptu['sn']);
                    // $content .= centerText("SN: SN681DEF312963");
                    $content .= centerText("Telephone: " . $companyData['telephone']);
                    $content .= "\n";
                    $content .= centerText("Z-READING REPORT");
                    $content .= "\n";

                    $content .= formatLine("Report Date:", $date);
                    $content .= "\n";

                    $content .= formatLine("Start Date & Time:", $date . " 8:00 AM");
                    $content .= formatLine("End Date & Time:", $date . " 11:59 PM");
                    $content .= "\n";

                    $content .= formatLine("Beg. SI #:", "00-" . $zreading['beginOrNumber']);
                    $content .= formatLine("End. SI #:", "00-" . $zreading['endOrNumber']);
                    $content .= formatLine("Beg. VOID #:", "00-" . str_pad($zreading['beginVoidOr'], 6, '0', STR_PAD_LEFT));
                    $content .= formatLine("End. VOID #:", "00-" . str_pad($zreading['endVoidOr'], 6, '0', STR_PAD_LEFT));
                    $content .= formatLine("Beg. RETURN #:", "00-" . str_pad($zreading['beginReturnOr'], 6, '0', STR_PAD_LEFT));
                    $content .= formatLine("End. RETURN #:", "00-" . str_pad($zreading['endReturnOr'], 6, '0', STR_PAD_LEFT));
                    $content .= formatLine("Reset Counter No:", "00");
                    $content .= formatLine("Z Counter No:", "01");
                    $content .= formatLine("Present Accumulated Sales:", number_format($zreading['presentAccumulatedSales'], 2));
                    $content .= formatLine("Previous Accumulated Sales:", number_format($zreading['previousAccumulatedSales'], 2));
                    $content .= formatLine("Sales for the Day:", number_format($zreading['dailySales'], 2));
                    $content .= "\n";

                    $content .= centerText("BREAKDOWN OF SALES");
                    $content .= formatLine("Vatable Sales:", number_format($zreading['vatableSales'], 2));
                    $content .= formatLine("Vat Amount:", number_format($zreading['vatAmount'], 2));
                    $content .= formatLine("Vat-Exempt Sales:", number_format($zreading['vatExempt'], 2));
                    $content .= formatLine("Zero-Rated Sales:", number_format($zreading['zeroRated'], 2));
                    $content .= formatLine("Gross Amount:", number_format($zreading['grossAmount'], 2));
                    $content .= formatLine("Less Discount:", number_format($zreading['lessDiscount'], 2));
                    $content .= formatLine("Less Return:", number_format($zreading['lessReturn'], 2));
                    $content .= formatLine("Less Void:", number_format($zreading['lessVoid'], 2));
                    $content .= formatLine("Less VAT Adjustment:", number_format($zreading['lessVatAdjustment'], 2));
                    $content .= formatLine("Net Amount:", number_format($zreading['netAmount'], 2));
                    $content .= "\n";

                    $content .= centerText("DISCOUNT SUMMARY");
                    $content .= formatLine("SC Disc.:", number_format($zreading['seniorDiscount'], 2));
                    $content .= formatLine("PWD Disc.:", number_format($zreading['pwdDiscount'], 2));
                    $content .= formatLine("NAAC Disc.:", number_format($zreading['naacDiscount'], 2));
                    $content .= formatLine("Solo Parent Disc.:", number_format($zreading['soloparentDiscount'], 2));
                    $content .= formatLine("Other Disc.:", number_format($zreading['otherDiscount'], 2));
                    $content .= "\n";

                    $content .= centerText("SALES ADJUSTMENT");
                    $content .= formatLine("VOID:", number_format($zreading['voidAmount'], 2));
                    $content .= formatLine("RETURN:", number_format($zreading['refundAmount'], 2));
                    $content .= "\n";

                    $content .= centerText("VAT ADJUSTMENT");
                    $content .= formatLine("SC TRANS.:", number_format($zreading['seniorTransactions'], 2));
                    $content .= formatLine("PWD TRANS.:", number_format($zreading['pwdTransactions'], 2));
                    $content .= formatLine("REG. Disc. TRANS.:", number_format($zreading['regularDiscTransactions'], 2));
                    $content .= formatLine("ZERO-RATED TRANS.:", number_format($zreading['zeroRated'], 2));
                    $content .= formatLine("VAT on Return.:", number_format($zreading['vatOnReturn'], 2));
                    $content .= formatLine("Other VAT Adjustment.:", number_format($zreading['otherVatAdjustment'], 2));
                    $content .= "\n";

                    $content .= centerText("TRANSACTION SUMMARY");
                    $content .= formatLine("Cash In Drawer:", number_format($zreading['cashInDrawer'], 2));
                    $content .= formatLine("GCash:", number_format($zreading['gcashPayments'], 2));
                    $content .= formatLine("Paymaya:", number_format($zreading['paymayaPayments'], 2));
                    $content .= formatLine("Opening Fund:", number_format($zreading['openingFund'], 2));
                    $content .= formatLine("Less Withdrawal:", number_format($zreading['lessWithdrawal'], 2));
                    $content .= formatLine("Payments Received:", number_format($zreading['totalPaymentsReceived'], 2));
                    $content .= formatLine("Short / Over:", number_format($zreading['shortOver'], 2));
                    $content .= "=========================================================\n\n";

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

    public function xreading()
    {
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

    public function xresult()
    {
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
                // print_r($xreading);
                $this->render_template('pos/xresult', $this->data);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }

    public function zreading()
    {
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

    public function zresult()
    {
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

                // print_r($zreading);
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


    public function searchPlate()
    {
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


    public function generateSummary()
    {
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

    public function previewSummaryReport()
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

                // pass to export button
                $this->data['cashier_id'] = $cashier_id;
                $this->data['trmId'] = $trmId;
                $this->data['startDate'] = $startDate;
                $this->data['endDate'] = $endDate;

                // Added
                $ptuData = $this->model_ptu->getPtuData($trmId);

                // Z counter
                $companyId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $this->data['zCounter'] = $companyData['z_counter'];

                $summaryData = $this->model_touchpoint->getDiscountsSummary($cashier_id, $trmId, $startDate, $endDate);
                $seniorsReport = $this->model_touchpoint->getSeniorCitizenReport($startDate, $endDate);
                $pwdReport = $this->model_touchpoint->getPwdReport($startDate, $endDate);
                $naacReport = $this->model_touchpoint->getNaacReport($startDate, $endDate);
                $soloparentReport = $this->model_touchpoint->getSoloParentReport($startDate, $endDate);
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
        // date_default_timezone_set('Asia/Manila'); // Set the timezone
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

                // Z counter
                $companyId = 1;
                $companyData = $this->model_touchpoint->getOrganization($companyId);
                $zCounter = $companyData['z_counter'];


                $summaryData = $this->model_touchpoint->getDiscountsSummary($cashier_id, $trmId, $startDate, $endDate);
                $seniorsReport = $this->model_touchpoint->getSeniorCitizenReport($startDate, $endDate);
                $pwdReport = $this->model_touchpoint->getPwdReport($startDate, $endDate);
                $naacReport = $this->model_touchpoint->getNaacReport($startDate, $endDate);
                $soloparentReport = $this->model_touchpoint->getSoloParentReport($startDate, $endDate);
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
                    $sheet1->setCellValue("A{$row}", $summaryData['startTimeRange']); // Date converted to readable format
                    $sheet1->setCellValue("B{$row}", $summaryData['beginOrNumber']); // Beginning SI/OR No.
                    $sheet1->setCellValue("C{$row}", $summaryData['endOrNumber']); // Ending SI/OR No.
                    $sheet1->setCellValue("D{$row}", number_format($summaryData['grandBeginningBalance'], 2)); // Grand Accum. Sales Ending Balance
                    $sheet1->setCellValue("E{$row}", number_format($summaryData['grandEndingBalance'], 2)); // Grand Accum. Beg. Balance
                    $sheet1->setCellValue("F{$row}", number_format($summaryData['manualSalesInvoice'], 2)); // Manual Sales Invoice
                    $sheet1->setCellValue("G{$row}", number_format($summaryData['grossSales'], 2)); // Gross Sales for the Day
                    $sheet1->setCellValue("H{$row}", number_format($summaryData['vatableSales'], 2)); // VATable Sales
                    $sheet1->setCellValue("I{$row}", number_format($summaryData['vatAmount'], 2)); // VAT Amount
                    $sheet1->setCellValue("J{$row}", number_format($summaryData['vatExempt'], 2)); // Zero-Rated Sales
                    $sheet1->setCellValue("K{$row}", number_format($summaryData['zeroRated'], 2)); // VAT-Exempt Sales

                    // Discounts and Deductions
                    $sheet1->setCellValue("L{$row}", number_format($summaryData['seniorDiscount'], 2)); // Senior Discount
                    $sheet1->setCellValue("M{$row}", number_format($summaryData['pwdDiscount'], 2)); // PWD Discount
                    $sheet1->setCellValue("N{$row}", number_format($summaryData['naacDiscount'], 2)); // NAAC Discount
                    $sheet1->setCellValue("O{$row}", number_format($summaryData['soloParentDiscount'], 2)); // Solo Parent Discount
                    $sheet1->setCellValue("P{$row}", number_format($summaryData['otherDiscount'], 2)); // Other Discounts
                    $sheet1->setCellValue("Q{$row}", number_format($summaryData['returnAmount'], 2)); // Returns
                    $sheet1->setCellValue("R{$row}", number_format($summaryData['voidAmount'], 2)); // Voids
                    $sheet1->setCellValue("S{$row}", number_format($summaryData['totalDeductions'], 2)); // Total Deductions

                    // VAT Adjustments
                    $sheet1->setCellValue("T{$row}", number_format($summaryData['vatSenior'], 2)); // VAT Senior
                    $sheet1->setCellValue("U{$row}", number_format($summaryData['vatPwd'], 2)); // VAT PWD
                    $sheet1->setCellValue("V{$row}", number_format($summaryData['vatOthers'], 2)); // VAT Others
                    $sheet1->setCellValue("W{$row}", number_format($summaryData['vatReturns'], 2)); // VAT on Returns
                    $sheet1->setCellValue("X{$row}", number_format($summaryData['vatOthers'], 2)); // VAT on Others
                    $sheet1->setCellValue("Y{$row}", number_format($summaryData['totalVatAdjustment'], 2)); // Total VAT Adjustment

                    // Additional Summary
                    $sheet1->setCellValue("Z{$row}", number_format($summaryData['vatPayable'], 2)); // VAT Payable
                    $sheet1->setCellValue("AA{$row}", number_format($summaryData['netSales'], 2)); // Net Sales
                    $sheet1->setCellValue("AB{$row}", number_format($summaryData['salesOverflow'], 2)); // Sales Overflow
                    $sheet1->setCellValue("AC{$row}", number_format($summaryData['totalIncome'], 2)); // Total Income
                    $sheet1->setCellValue("AD{$row}", $summaryData['zCounter']); // Reset Counter 
                    $sheet1->setCellValue("AE{$row}", $zCounter); // Z-Counter
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


                    foreach ($seniorsReport as $d) {
                        $sheetE2->setCellValue('A' . $rowNumber, date("Y-m-d", $d['paid_time'])); // Date
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


                    foreach ($pwdReport as $d) {
                        $sheetE3->setCellValue('A' . $rowNumber, date("Y-m-d", $d['paid_time'])); // Date
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

                    foreach ($naacReport as $d) {
                        $sheetE4->setCellValue('A' . $rowNumber, date("Y-m-d", $d['paid_time'])); // Date
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

                    foreach ($soloparentReport as $d) {
                        $sheetE5->setCellValue('A' . $rowNumber, date("Y-m-d", $d['paid_time'])); // Date
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

                // print_r($summaryData);
            } else {
                $this->load->view('balance');
            }
        } else {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
        }
    }


    public function testStatus()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 5) {
            $terminalId = 1;
            $cashDrawer = $this->model_touchpoint->terminalDrawer($terminalId);

            if ($cashDrawer) {

                $type = $this->input->get('status');
                if ($type == "S") {
                    echo "Success";
                } else if ($type == "SF") {
                    $this->render_template('pos/server_failed');
                } else {
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

    public function testDiscountMethod()
    {
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

    public function downloadAllTransaction()
    {
        try {
            $this->load->model('model_touchpoint');
            $allTransaction = $this->model_touchpoint->getAllTransactions(10);

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()
                ->setCreator('Touchpoint')
                ->setTitle('All Transaction Report')
                ->setSubject('All Transaction Report')
                ->setDescription('All Transaction Report');

            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $headers = [
                'ID',
                'Terminal ID',
                'Cashier ID',
                'OR Number',
                'Gate',
                'Access Type',
                'Parking Code',
                'Vehicle Category',
                'Rate',
                'Entry Time',
                'Paid Time',
                'Total Time',
                'Amount',
                'Earned Amount',
                'Cash Received',
                'Change',
                'Discount',
                'Discount Type',
                'VAT',
                'VAT Exempt',
                'Vatable Sales',
                'Zero Rated',
                'Non-VAT',
                'Payment Mode',
                'Transaction Status',
                'Is Manual',
                'Status',
                'Z-Lock'
            ];

            foreach (range('A', 'AB') as $index => $column) {
                $sheet->setCellValue("{$column}1", $headers[$index]);
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Set data
            $row = 2;
            foreach ($allTransaction as $transaction) {
                $sheet->setCellValue("A{$row}", $transaction['id']);
                $sheet->setCellValue("B{$row}", $transaction['pid']);
                $sheet->setCellValue("C{$row}", $transaction['cashier_id']);
                $sheet->setCellValue("D{$row}", $transaction['ornumber']);
                $sheet->setCellValue("E{$row}", $transaction['gate_en']);
                $sheet->setCellValue("F{$row}", $transaction['access_type']);
                $sheet->setCellValue("G{$row}", $transaction['parking_code']);
                $sheet->setCellValue("H{$row}", $transaction['vehicle_cat_id']);
                $sheet->setCellValue("I{$row}", $transaction['rate_id']);
                $sheet->setCellValue("J{$row}", date('Y-m-d H:i:s', $transaction['in_time']));
                $sheet->setCellValue("K{$row}", date('Y-m-d H:i:s', $transaction['paid_time']));
                $sheet->setCellValue("L{$row}", $transaction['total_time']);
                $sheet->setCellValue("M{$row}", $transaction['amount']);
                $sheet->setCellValue("N{$row}", $transaction['earned_amount']);
                $sheet->setCellValue("O{$row}", $transaction['cash_received']);
                $sheet->setCellValue("P{$row}", $transaction['change']);
                $sheet->setCellValue("Q{$row}", $transaction['discount']);
                $sheet->setCellValue("R{$row}", $transaction['discount_type']);
                $sheet->setCellValue("S{$row}", $transaction['vat']);
                $sheet->setCellValue("T{$row}", $transaction['vat_exempt']);
                $sheet->setCellValue("U{$row}", $transaction['vatable_sales']);
                $sheet->setCellValue("V{$row}", $transaction['zero_rated']);
                $sheet->setCellValue("W{$row}", $transaction['non_vat']);
                $sheet->setCellValue("X{$row}", $transaction['paymode']);
                $sheet->setCellValue("Y{$row}", $transaction['transact_status']);
                $sheet->setCellValue("Z{$row}", $transaction['is_manual']);
                $sheet->setCellValue("AA{$row}", $transaction['status']);
                $sheet->setCellValue("AB{$row}", $transaction['zlock']);
                $row++;
            }

            // Style the header row
            $headerStyle = $spreadsheet->getActiveSheet()->getStyle('A1:AB1');
            $headerStyle->getFont()->setBold(true);
            $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $headerStyle->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('CCCCCC');

            // Output file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="all_transactions.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            log_message('error', 'Error in downloadAllTransaction: ' . $e->getMessage());
            show_error('Failed to generate transaction report', 500);
        }
    }

    public function exportTransactionsToExcel($uid)
    {
        // Fetch transactions from the model
        $transactions = $this->model_touchpoint->getAllTransactions($uid);

        if (empty($transactions)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode(['status' => 'error', 'message' => 'No transactions found.']));
            return;
        }

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column names
        $columns = [
            'id',
            'pid',
            'cashier_id',
            'ornumber',
            'gate_en',
            'access_type',
            'parking_code',
            'vehicle_cat_id',
            'rate_id',
            'in_time',
            'paid_time',
            'total_time',
            'amount',
            'earned_amount',
            'cash_received',
            'change',
            'discount',
            'discount_type',
            'vat',
            'vat_exempt',
            'vatable_sales',
            'zero_rated',
            'non_vat',
            'paymode',
            'transact_status',
            'is_manual',
            'status',
            'zlock'
        ];

        // Set header row
        $columnIndex = 'A';
        foreach ($columns as $column) {
            $sheet->setCellValue($columnIndex . '1', strtoupper($column));
            $sheet->getColumnDimension($columnIndex)->setAutoSize(true);
            $columnIndex++;
        }

        // Populate rows with transaction data
        $rowIndex = 2;
        foreach ($transactions as $transaction) {
            $columnIndex = 'A';
            foreach ($columns as $column) {
                $value = $transaction[$column] ?? '';
                // Format timestamps if needed
                if ($column === 'in_time' || $column === 'paid_time') {
                    $value = !empty($value) ? date('Y-m-d H:i:s', $value) : '';
                }
                $sheet->setCellValue($columnIndex . $rowIndex, $value);
                $columnIndex++;
            }
            $rowIndex++;
        }

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="transactions_' . date('Y-m-d_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Create Excel writer and output file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function refund()
    {
        $userId = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($userId);
        $siNumber = trim($this->input->post('code')); // Trim spaces for better validation

        // Check if the user is a cashier (ID 5)
        if ($position['id'] != 5) {
            $this->session->set_flashdata('error', 'You are not a cashier');
            redirect('auth/login');
            return;
        }

        // Validate SI Number input
        if (empty($siNumber)) {
            $this->session->set_flashdata('refund', 'empty_code');
            redirect('touchpoint/payments');
            return;
        }

        if (!preg_match('/^\d{6}$/', $siNumber)) {
            $this->session->set_flashdata('refund', 'invalid_format');
            redirect('touchpoint/payments');
            return;
        }

        // Attempt refund
        $refundSuccess = $this->model_touchpoint->refundTransaction($userId, $siNumber);
        $this->session->set_flashdata('refund', $refundSuccess ? 'refund_success' : 'refund_failed');

        redirect('touchpoint/payments');
    }
}