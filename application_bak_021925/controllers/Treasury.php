<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;

class Treasury extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_users');
        $this->load->model('model_treasury');
        require_once FCPATH . 'vendor/autoload.php';
    }
    public function index(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 16) {
            $this->render_template('treasury/index', $this->data);
        }else{
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function reports()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) { // Check if user is a cashier
    
           $beginningData = $this->model_treasury->getBeginningSi();
           $endingData = $this->model_treasury->getEndingSi();
           $terminalFund = $this->model_treasury->getTerminalFund();
           $summaryData = array(
                'beginningOr' => $beginningData['ornumber'],
                'endingOr' =>   $endingData['ornumber'],
                'cashierTerminalOpFund' => $terminalFund['opening_fund'],
                'cashierTerminalRemFund' => $terminalFund['remaining']
           );
           $this->data['summary_data'] = $summaryData;
           $this->render_template("treasury/reports", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }
    public function reportSummary(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) {
            // // $type = $t
            // $date = $this->input->get('report_date');
            // $cashierId = $this->input->get('cashier_id');
            // $terminal_id = $this->input->get('terminal_id');
    
            // $summary = $this->model_treasury->summaryData($date, $cashierId, $terminal_id);
            
            // $this->data['summary'] = $summary;
            $this->render_template("treasury/xresult", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function analysis()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 16) {
            $cashierList = $this->model_treasury->getCashierList();
            $terminalList = $this->model_treasury->getTerminalList();
            $this->data['cashiers'] = $cashierList;
            $this->data['terminal'] = $terminalList;

            $this->render_template('treasury/analysis', $this->data);
        }else{
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function generateReport()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) {
            $type = $this->input->get('report_type');
            $date = $this->input->get('report_date');
            $cashierId = $this->input->get('cashier_id');
            $terminal_id = $this->input->get('terminal_id');
    
            $summary = $this->model_treasury->summaryData($date, $cashierId, $terminal_id);
            
            $this->data['summary'] = $summary;
            $this->render_template("treasury/xresult", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function analysisResult()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 16) {
            $date = $this->input->get('report_date');
            $cashierId = $this->input->get('cashier_id');
            $terminal_id = $this->input->get('terminal_id');
            $summary = $this->model_treasury->summarizedData($date, $cashierId, $terminal_id);

            $this->data['summary'] = $summary;
            $this->render_template("treasury/xresult", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function printAnalysis()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);

        if ($position['id'] == 16) {
            if ($this->input->post()) {

                $companyId = 1;
                $ptuId = 3;
                $companyData = $this->model_treasury->getOrganization($companyId);
                $ptuData = $this->model_treasury->getPtu($ptuId);

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
                $companyAddress = $companyData['address'];
                $companyRepAddress = str_replace("Metro Manila, Philippines", "\nMetro Manila, Philippines", $companyAddress);

                $companyPhone = $companyData['telephone'];
                $companyTin = $companyData['TIN'];
                $companyMin = $companyData['MIN'];
                
                $formData = $this->input->post();

                $firstOrNumber = $formData['first_ornumber'] ?? null;
                $lastOrNumber = $formData['last_ornumber'] ?? null;
                $openingFund = $formData['openingFund'] ?? null;
                $remainingFund = $formData['remainingFund'] ?? null;
                $presentAccumulatedSales = $formData['presentAccumulatedSales'] ?? null;
                $salesForTheDay = $formData['salesForTheDay'] ?? null;
                $previousAccumulatedSales = $formData['previousAccumulatedSales'] ?? null;
                $totalPaymentsReceived = $formData['totalPaymentsReceived'] ?? null;
                $dropOffCount = $formData['dropOffCount'] ?? null;
                $cash = $formData['Cash'] ?? null;
                $gcash = $formData['Gcash'] ?? null;
                $paymaya = $formData['Paymaya'] ?? null;
                $shortOver = $formData['shortOver'] ?? null;


                try {
                    $connector = new WindowsPrintConnector("POS-80-Series");
                
                    $printer = new Printer($connector);
                
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                    $printer->text("PICC\n");
                
                    function formatLine($left, $right) {
                        $maxLength = 48;
                        $leftLength = strlen($left);
                        $rightLength = strlen($right);
                        $spaces = $maxLength - $leftLength - $rightLength;
                        return $left . str_repeat(' ', $spaces) . $right . "\n";
                    }
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_A);
                    $printer->text("\n". $companyRepAddress ."\n");
                    $printer->text($companyPhone, "\n");
                    $printer->text("\nVAT REG TIN: ". $companyTin."\n");
                    $printer->text("MIN: ". $companyMin ."\n");
                    $printer->selectPrintMode();
                    $printer->feed();
                
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("X-READING REPORT\n");
                    $printer->selectPrintMode();
                    $printer->feed();
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text(formatLine("Report Date:", date('Y-m-d H:i A')));
                    $printer->text(formatLine("Report Time:", date("H:i:s A")));
                    $printer->feed();
                    $printer->text(formatLine("Start Date and Time:", date('m/d/Y H:i A')));
                    $printer->text(formatLine("End Date and Time:", date('m/d/Y H:i A')));
                
                    $printer->text(formatLine("\nCashier:", "cashiername"));
                    $printer->text("================================================\n");
                    $printer->text(formatLine("Beg. SI #:", $firstOrNumber));
                    $printer->text(formatLine("End. SI #:", $lastOrNumber));
                
                    $printer->text(formatLine("Opening Fund:", $openingFund));
                    $printer->text("================================================\n");
                    $printer->text(formatLine("Present Accumulated Sales:", $presentAccumulatedSales));
                    $printer->text(formatLine("Previous Accumulated Sales:", $previousAccumulatedSales));
                    $printer->text(formatLine("Sales for the Day:", $salesForTheDay));
                    $printer->text("================================================\n");
                
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("PAYMENTS RECEIVED\n");
                    $printer->selectPrintMode();
                    $printer->text(formatLine("CASH:", $cash));
                    $printer->text(formatLine("GCASH:", $gcash));
                    $printer->text(formatLine("PAYMAYA:", $paymaya));
                    $printer->text(formatLine("Total Payments:", $totalPaymentsReceived));    
                    $printer->text("================================================\n");
                    $printer->text(formatLine("VOID:", $dropOffCount));
                    $printer->text("================================================\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("TRANSACTION SUMMARY\n");
                    $printer->selectPrintMode();
                    $printer->text(formatLine("Cash In Drawer:", $remainingFund));
                    $printer->text(formatLine("Paymaya:", $paymaya));
                    $printer->text(formatLine("GCash:", $gcash));
                    $printer->text(formatLine("Opening Fund:", $openingFund));
                    $printer->text(formatLine("Payments Received:", $totalPaymentsReceived));
                    $printer->text("================================================\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text(formatLine("SHORT/OVER:", $shortOver));
                    $printer->feed();
                    $printer->cut();
                
                    $printer->close();
                
                } catch (Exception $e) {
                    echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
                }

            } else {
                echo "No form data submitted.";
            }
        } else {
            echo "You are not a cashier.";
            $this->load->view('login');
            return;
        }
    }

    public function generateReadingReport()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) {
            $type = $this->input->get('report_type');
            $date = $this->input->get('report_date');
            $cashierId = $this->input->get('cashier_id');
            $terminal_id = $this->input->get('terminal_id');
    
            $summary = $this->model_treasury->summarizedData($date, $cashierId, $terminal_id);
            
            // print_r($summary);
            $this->data['summary'] = $summary;
            $this->render_template("treasury/xresult", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function zreadingSummary(){
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) {
            $type = $this->input->get('report_type');
            $date = $this->input->get('report_date');
            $cashierId = $this->input->get('cashier_id');
            $terminal_id = $this->input->get('terminal_id');
    
            $summary = $this->model_treasury->summaryReadingTwo($date, $cashierId, $terminal_id);
            
           
            print_r($summary);
            $this->data['summary'] = $summary;
            $this->render_template("treasury/zresult", $this->data);
        } else {
            echo ("You are not a cashier");
            $this->load->view('login');
            return;
        }
    }

    public function printzreadingReport()
    {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 16) {
            if ($this->input->post()) {
    
                // Get form data
                $formData = $this->input->post();
    
                // Retrieve values with type conversion and defaults
                $firstOrNumber = $formData['first_ornumber'] ?? '0';
                $lastOrNumber = $formData['last_ornumber'] ?? '0';
                $beg_void = $formData['beg_void'] ?? '0';
                $end_void = $formData['end_void'] ?? '0';
                $openingFund = floatval($formData['openingFund'] ?? 0);
                $remainingFund = floatval($formData['remainingFund'] ?? 0);
                $presentAccumulatedSales = floatval($formData['presentAccumulatedSales'] ?? 0);
                $salesForTheDay = floatval($formData['salesForTheDay'] ?? 0);
                $previousAccumulatedSales = floatval($formData['previousAccumulatedSales'] ?? 0);
                $totalPaymentsReceived = floatval($formData['totalPaymentsReceived'] ?? 0);
                $dropOffCount = intval($formData['dropOffCount'] ?? 0);
                $cash = floatval($formData['Cash'] ?? 0);
                $gcash = floatval($formData['Gcash'] ?? 0);
                $paymaya = floatval($formData['Paymaya'] ?? 0);
                $shortOver = floatval($formData['shortOver'] ?? 0);
                $totalVatableSales = floatval($formData['totalVatableSales'] ?? 0);
                $totalVAT = floatval($formData['totalVAT'] ?? 0);
                $totalVATExempt = floatval($formData['totalVATExempt'] ?? 0);
                $totalGrossAmount = floatval($formData['totalGrossAmount'] ?? 0);
                $totalDiscount = floatval($formData['totalDiscount'] ?? 0);
                $lessVoid = floatval($formData['lessVoid'] ?? 0);
                $netAmount = floatval($formData['netAmount'] ?? 0);
    
                // Debugging output
                error_log(print_r($formData, true)); // Log the entire form data array
                error_log("Opening Fund: " . $openingFund);
                error_log("Remaining Fund: " . $remainingFund);
                error_log("Present Accumulated Sales: " . $presentAccumulatedSales);
                error_log("Sales for the Day: " . $salesForTheDay);
                error_log("Total Payments Received: " . $totalPaymentsReceived);
                error_log("Short/Over: " . $shortOver);
                error_log("Total VAT: " . $totalVAT);
                error_log("Net Amount: " . $netAmount);
    
                try {
                    $connector = new WindowsPrintConnector("POS-80-Series");
                    $printer = new Printer($connector);
    
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
                    $printer->text("PICC\n");
    
                    // Function to format lines
                    function formatLine($left, $right) {
                        $maxLength = 48;
                        $leftLength = strlen($left);
                        $rightLength = strlen($right);
                        $spaces = $maxLength - $leftLength - $rightLength;
                        return $left . str_repeat(' ', $spaces) . $right . "\n";
                    }
    
                    // Print header information
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED | Printer::MODE_FONT_A);
                    $printer->text("\nPICC, Complex 1307 Pasay City,\n");
                    $printer->text("Metro Manila, Philippines\n");
                    $printer->text("(+63)936994578\n");
                    $printer->text("VAT REG TIN: 000-000-000-00000\n");
                    $printer->text("MIN: 1234567891\n");
                    $printer->selectPrintMode();
                    $printer->feed();
    
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("Z-READING REPORT\n");
                    $printer->selectPrintMode();
                    $printer->feed();
    
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text(formatLine("Report Date:", date('Y-m-d H:i A')));
                    $printer->text(formatLine("Report Time:", date("H:i:s A")));
                    $printer->feed();
                    $printer->text(formatLine("Start Date and Time:", date('m/d/Y H:i A'))); // Replace with actual in_time
                    $printer->text(formatLine("End Date and Time:", date('m/d/Y H:i A'))); // Replace with actual paid_time
                    $printer->text(formatLine("\nCashier:", "cashiername")); // Replace with actual cashier's name
                    $printer->text("================================================\n");
                    $printer->text(formatLine("Beg. VOID #:", $beg_void));
                    $printer->text(formatLine("End. VOID #:", $end_void));
                    $printer->text(formatLine("Opening Fund:", number_format($openingFund, 2)));
                    $printer->text("================================================\n");
                    $printer->text(formatLine("Present Accumulated Sales:", number_format($presentAccumulatedSales, 2)));
                    $printer->text(formatLine("Previous Accumulated Sales:", number_format($previousAccumulatedSales, 2)));
                    $printer->text(formatLine("Sales for the Day:", number_format($salesForTheDay, 2)));
                    $printer->text("================================================\n");
    
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("PAYMENTS RECEIVED\n");
                    $printer->selectPrintMode();
                    $printer->text(formatLine("CASH:", number_format($cash, 2)));
                    $printer->text(formatLine("GCASH:", number_format($gcash, 2)));
                    $printer->text(formatLine("PAYMAYA:", number_format($paymaya, 2)));
                    $printer->text(formatLine("Total Payments:", number_format($totalPaymentsReceived, 2)));
                    $printer->text("================================================\n");
                    $printer->text(formatLine("VOID:", $dropOffCount));
                    $printer->text("================================================\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->text("TRANSACTION SUMMARY\n");
                    $printer->selectPrintMode();
                    $printer->text(formatLine("Cash In Drawer:", number_format($remainingFund, 2)));
                    $printer->text(formatLine("Opening Fund:", number_format($openingFund, 2)));
                    $printer->text(formatLine("Payments Received:", number_format($totalPaymentsReceived, 2)));
                    $printer->text("================================================\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text(formatLine("SHORT/OVER:", number_format($shortOver, 2)));
                    $printer->feed();
                    $printer->cut();
    
                    // Close the printer connection
                    $printer->close();
    
                } catch (Exception $e) {
                    echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
                }
    
            } else {
                echo "No form data submitted.";
            }
        } else {
            echo "You are not a cashier.";
            $this->load->view('login');
            return;
        }
    }
    
    
    
    
    

    public function generateXreading(){
        $startTime = $this->input->get('start_time');
        $endTime = $this->input->get('end_time');
        $cashierIdentification = $this->input->get('cashier_id');
        $terminalIdentifier = $this->input->get('terminal_id');

        $inputArray = array(
            'start_time' => $startTime,
            'end_time' => $endTime,
            'cashier_id' => $ $cashierIdentification,
            'terminal_id' => $terminalIdentifier
        );

        echo json_encode($inputArray);
    }


    
    
    
}