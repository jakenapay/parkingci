<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo extends Admin_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('model_users');
        $this->load->model('model_demo');
    }

    public function index(){
        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){  
			
			$this->load->view('templates/header');
			$this->render_template('demo/index', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
    }

    public function analysis(){
        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){  
			
			$this->load->view('templates/header');
			$this->render_template('cashier/index', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
    }

    public function reports(){
        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){  
            $terminalId = 1;
			$begSalesInvoice = $this->model_demo->getBeginningSI();
            $endSalesInvoice = $this->model_demo->getEndingSI();
            $openingFund = $this->model_demo->getOpeningFund($terminalId);
            $salesOftheDay = $this->model_demo->getDailySales();
            $voidCounts = $this->model_demo->getVoidCounts();
            $voidSales = $this->model_demo->getVoidSales();
            print_r($voidSales);
            $reportSummary = array(
                'begsales_invoice' => $begSalesInvoice['ornumber'],
                'endsales_invoice' => $endSalesInvoice['ornumber'],
                'opening_fund'      => $openingFund['opening_fund'],
                'daily_sales'       => $salesOftheDay,
                'void_counts'       => $voidCounts,
                'void_sales'        => $voidSales
            );
            // print_r($reportSummary);

            $this->data['report_summary'] = $reportSummary;
			$this->load->view('templates/header');
			$this->render_template('demo/reports', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
    }

    public function xsalesAnalysis(){
        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){
            $cashiers = $this->model_demo->getCashierList();
            $terminals = $this->model_demo->getTerminalList();
            $this->data['cashiers'] = $cashiers;
            $this->data['terminals'] = $terminals;
			$this->load->view('templates/header');
			$this->render_template('demo/xanalysis_form', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
    }

    public function zsalesAnalysis(){
        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){
            $cashiers = $this->model_demo->getCashierList();
            $terminals = $this->model_demo->getTerminalList();
            $this->data['cashiers'] = $cashiers;
            $this->data['terminals'] = $terminals;
			$this->load->view('templates/header');
			$this->render_template('demo/zanalysis_form', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
    }

    public function generateXreadingReport(){
        // Retrieve data from the form
       


        $user_id = $this->session->userdata('id');
		$position=$this->model_users->getUserGroup($user_id);		
		if($position['id'] == 5){
            $date = $this->input->post('date_start');
            $cashierId = $this->input->post('cashier_id');
            $terminalId = $this->input->post('terminal_id');
        
            // Make sure to parse the date correctly if necessary
            // For example, you might want to convert it to a timestamp
            $dateStart = strtotime($date . ' midnight');
            $dateEnd = strtotime('tomorrow midnight') - 1;
        
            $xreadingData = $this->model_demo->getXreadingData($dateStart, $cashierId, $terminalId);
        
            $xreading = array(
                'begSalesInvoice' => $xreadingData['first_ornumber'],
                'endSalesInvoice' => $xreadingData['last_ornumber'],
                'openingFund' => $xreadingData['opening_fund'],
                'cash' => $xreadingData['Cash'],
                'gcash' => $xreadingData['Gcash'],
                'paymaya' => $xreadingData['Paymaya'],
                'totalPaymentsReceived' => $xreadingData['totalPaymentsReceived'],
                'totalVoidSales' => $xreadingData['totalVoidSales'],
                'cashInDrawer' => $xreadingData['cashInDrawer']
            );
            $this->data['xreading'] = $xreading;
			$this->load->view('templates/header');
			$this->render_template('demo/xanalysis_result', $this->data);
		}
		else{
			echo(" you are not cashier");
			$this->load->view('login');
			return;
        }
        // Return the response in JSON format
        // echo json_encode($xreading);
    }

    public function printXreadingResult(){

    }
    

    public function generateZreadingReport() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            $startDate = $this->input->post('date_start');
            $endDate = $this->input->post('date_end');
            $cashierId = $this->input->post('cashier_id');
            $terminalId = $this->input->post('terminal_id');
    
            // Convert dates to timestamps
            $dateStart = strtotime($startDate . ' midnight');
            $dateEnd = strtotime($endDate . ' 23:59:59');
    
            // Fetch data including accumulated sales
            $zreadingData = $this->model_demo->getZreadingData($dateStart, $dateEnd, $cashierId, $terminalId);
    
            // Prepare data for the view
            $this->data['zreading'] = [
                'begSalesInvoice' => $zreadingData['first_ornumber'],
                'endSalesInvoice' => $zreadingData['last_ornumber'],
                'openingFund' => $zreadingData['opening_fund'],
                'cash' => $zreadingData['Cash'],
                'gcash' => $zreadingData['Gcash'],
                'paymaya' => $zreadingData['Paymaya'],
                'totalPaymentsReceived' => $zreadingData['totalPaymentsReceived'],
                'totalVoidSales' => $zreadingData['totalVoidSales'],
                'cashInDrawer' => $zreadingData['cashInDrawer'],
                'presentAccumulatedSales' => $zreadingData['presentAccumulatedSales'],
                'previousAccumulatedSales' => $zreadingData['previousAccumulatedSales'],
                'salesForTheDay' => $zreadingData['presentAccumulatedSales'],
                'vatableSales' => $zreadingData['vatable_sales'],
                'totalVatAmount' => $zreadingData['totalVatAmount'],
                'grossAmount' => $zreadingData['gross_amount'],
                'lessDiscount' => $zreadingData['lessDiscount'],
                'shortOver' => $zreadingData['shortOver']
            ];
    


            $this->load->view('templates/header');
            $this->render_template('demo/zanalysis_result', $this->data);
        } else {
            echo("You are not authorized to access this.");
            $this->load->view('login');
        }
    }

    public function printZreadingResult() {
        $user_id = $this->session->userdata('id');
        $position = $this->model_users->getUserGroup($user_id);
    
        if ($position['id'] == 5) {
            // Retrieve the Z-reading data, assuming you have already defined how to get it
            $zreadingData = $this->input->post(); // Assuming you're sending the same data for printing
    
            // Example: You may need to fetch this from the model based on the input
            // Adjust the model call accordingly
            $zreadingData = $this->model_demo->getZreadingData($zreadingData['date_start'], $zreadingData['date_end'], $zreadingData['cashier_id'], $zreadingData['terminal_id']);
    
            $zreading = [
                'begSalesInvoice' => $zreadingData['first_ornumber'],
                'endSalesInvoice' => $zreadingData['last_ornumber'],
                'openingFund' => $zreadingData['opening_fund'],
                'cash' => $zreadingData['Cash'],
                'gcash' => $zreadingData['Gcash'],
                'paymaya' => $zreadingData['Paymaya'],
                'totalPaymentsReceived' => $zreadingData['totalPaymentsReceived'],
                'totalVoidSales' => $zreadingData['totalVoidSales'],
                'cashInDrawer' => $zreadingData['cashInDrawer'],
                'presentAccumulatedSales' => $zreadingData['presentAccumulatedSales'],
                'previousAccumulatedSales' => $zreadingData['previousAccumulatedSales'],
                'salesForTheDay' => $zreadingData['presentAccumulatedSales'],
                'vatableSales' => $zreadingData['vatable_sales'],
                'totalVatAmount' => $zreadingData['totalVatAmount'],
                'grossAmount' => $zreadingData['gross_amount'],
                'lessDiscount' => $zreadingData['lessDiscount'],
                'shortOver' => $zreadingData['shortOver']
            ];
    
            // Load the view and pass the data
            // $this->load->view('demo/zreading_pri0p;9nt', ['zreading' => $zreading]);
        } else {
            echo("You are not authorized to access this.");
            $this->load->view('login');
        }
    }

    public function createEjournal(){
        
    }
    
    
    
}