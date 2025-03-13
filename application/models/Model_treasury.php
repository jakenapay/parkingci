<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_treasury extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function getCashierList()
    {
        $this->db->from('users');
        $this->db->where('position', 5);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }
    public function getTerminalList()
    {
        $this->db->from('users');
        $this->db->where('position', 5);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function getBeginningSi()
    {
        date_default_timezone_set("Asia/Manila");
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select("ornumber");
        $this->db->from("transactions");
        $this->db->where("paid_time >=", $startOfDay);
        $this->db->where("paid_time <=", $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }
    public function getEndingSi()
    {
        date_default_timezone_set("Asia/Manila");
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select("ornumber");
        $this->db->from("transactions");
        $this->db->where("paid_time >=", $startOfDay);
        $this->db->where("paid_time <=", $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getTerminalFund(){
        date_default_timezone_set("Asia/Manila");
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select("*");
        $this->db->from("cash_drawer");
        $this->db->where('terminal_id', 1);
        $this->db->where("start_time >=", $startOfDay);
        $this->db->where("start_time <=", $endOfDay);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }
    public function getFirstandLastSI()
    {
        // Set the correct timezone
        date_default_timezone_set("Asia/Manila");
    
        // Define the start and end of the current day
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        // Get the first transaction of the day
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $firstQuery = $this->db->get()->row_array();  // Fetch as an array
    
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $this->db->limit(1);
        $lastQuery = $this->db->get()->row_array();  // Fetch as an array
    
        // Ensure both queries return results
        if ($firstQuery && $lastQuery) {
            return array(
                'first_ornumber' => $firstQuery['ornumber'],  // Return the first ornumber
                'last_ornumber' => $lastQuery['ornumber'],    // Return the last ornumber
            );
        } else {
            return null;  // Return null if no records were found
        }
    }
    
    

    public function summaryData($cashierId, $terminalId, $date)
    {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        // Existing queries for transactions
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', 10);
        $this->db->where('pid', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $firstQuery = $this->db->get();

        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', 10);
        $this->db->where('pid', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $lastQuery = $this->db->get();

        // Cash drawer query
        $this->db->reset_query();
        $this->db->select("opening_fund");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", 1);
        $this->db->where("cashier_id", 10);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerQuery  = $this->db->get();

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', 10);
        $this->db->where('pid', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $salesQuery = $this->db->get();

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', 10);
        $this->db->where('pid', 1);
        $this->db->where('paid_time <', $startOfDay);
        $previousSalesQuery = $this->db->get();

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', 10);
        $this->db->where('pid', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $daySalesQuery = $this->db->get();

        $paymentModes = ['Cash', 'Gcash', 'Paymaya'];
        $payments = [];
        $totalPayments = 0;

        foreach ($paymentModes as $mode) {
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->from('transactions');
            $this->db->where('cashier_id', 10);
            $this->db->where('pid', 1);
            $this->db->where('paymode', $mode);
            $this->db->where('paid_time >=', $startOfDay);
            $this->db->where('paid_time <=', $endOfDay);
            $query = $this->db->get();

            $payments[$mode] = ($query->num_rows() > 0 && $query->row()->amount !== null) ? $query->row()->amount : 0;
            $totalPayments += $payments[$mode];
        }

        $salesForTheDay = $daySalesQuery->num_rows() > 0 ? $daySalesQuery->row()->amount : 0;
        $presentAccumulatedSales = $salesQuery->num_rows() > 0 ? $salesQuery->row()->amount : 0;
        $previousAccumulatedSales = $previousSalesQuery->num_rows() > 0 ? $previousSalesQuery->row()->amount : 0;

        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : null;
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : null;


        $this->db->reset_query();
        $this->db->select('COUNT(*) as drop_off_count');
        $this->db->from('parking');
        $this->db->where('out_time IS NOT NULL');
        $this->db->where('paid_status', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);

        log_message('debug', "Drop-off Query: " . $this->db->last_query()); // Log the query
        $dropOffQuery = $this->db->get();

        $dropOffCount = $dropOffQuery->num_rows() > 0 ? $dropOffQuery->row()->drop_off_count : 0;

        return array_merge(
            [
                'first_ornumber' => $firstOrnumber,
                'last_ornumber' => $lastOrnumber,
                'openingFund' => $openingFund,
                'presentAccumulatedSales' => $presentAccumulatedSales,
                'salesForTheDay' => $salesForTheDay,
                'previousAccumulatedSales' => $previousAccumulatedSales,
                'totalPaymentsReceived' => $totalPayments,
                'dropOffCount' => $dropOffCount,
            ],
            $payments
        );
    }

    public function summarizedData($date) {
        $cashierId = 10; // Hardcoded for now
        $terminalId = 1; // Hardcoded for now
    
        $startOfDay = strtotime($date . ' midnight');
        $endOfDay = strtotime($date . ' tomorrow midnight') - 1;
    
        // First ornumber query
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $firstQuery = $this->db->get();
    
        // Last ornumber query
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $lastQuery = $this->db->get();
    
        // Opening fund query
        $this->db->reset_query();
        $this->db->select("opening_fund");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerQuery  = $this->db->get();
    
        // Remaining fund query
        $this->db->reset_query();
        $this->db->select("remaining");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerRemQuery  = $this->db->get();
    
        // Sales data queries
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $salesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time <', $startOfDay);
        $previousSalesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $daySalesQuery = $this->db->get();
    
        // Payment modes
        $paymentModes = ['Cash', 'Gcash', 'Paymaya'];
        $payments = [];
        $totalPayments = 0;
    
        foreach ($paymentModes as $mode) {
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->from('transactions');
            $this->db->where('cashier_id', $cashierId);
            $this->db->where('pid', $terminalId);
            $this->db->where('paymode', $mode);
            $this->db->where('paid_time >=', $startOfDay);
            $this->db->where('paid_time <=', $endOfDay);
            $query = $this->db->get();
    
            $payments[$mode] = ($query->num_rows() > 0 && $query->row()->amount !== null) ? $query->row()->amount : 0;
            $totalPayments += $payments[$mode];
        }
    
        $salesForTheDay = $daySalesQuery->num_rows() > 0 ? $daySalesQuery->row()->amount : 0;
        $presentAccumulatedSales = $salesQuery->num_rows() > 0 ? $salesQuery->row()->amount : 0;
        $previousAccumulatedSales = $previousSalesQuery->num_rows() > 0 ? $previousSalesQuery->row()->amount : 0;
    
        $remainingFund = $drawerRemQuery->num_rows() > 0 ? $drawerRemQuery->row()->remaining : 0;
        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
    
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : null;
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : null;
    
        $this->db->reset_query();
        $this->db->select('COUNT(*) as drop_off_count');
        $this->db->from('parking');
        $this->db->where('out_time IS NOT NULL');
        $this->db->where('paid_status', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $dropOffQuery = $this->db->get();
        $dropOffCount = $dropOffQuery->num_rows() > 0 ? $dropOffQuery->row()->drop_off_count : 0;
    
        $expectedTotal = $openingFund + $totalPayments;
        $shortOver = $remainingFund - $expectedTotal;
    
        return array_merge(
            [
                'first_ornumber' => $firstOrnumber,
                'last_ornumber' => $lastOrnumber,
                'openingFund' => $openingFund,
                'remainingFund' => $remainingFund,
                'presentAccumulatedSales' => $presentAccumulatedSales,
                'salesForTheDay' => $salesForTheDay,
                'previousAccumulatedSales' => $previousAccumulatedSales,
                'totalPaymentsReceived' => $totalPayments,
                'dropOffCount' => $dropOffCount,
                'shortOver' => $shortOver,
            ],
            $payments
        );
    }

    public function summaryReadingTwo() {
        $cashierId = 10; // Hardcoded for now
        $terminalId = 1; // Hardcoded for now
    
        $startOfDay = strtotime('midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $firstQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $lastQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select("opening_fund");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select("remaining");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerRemQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $salesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time <', $startOfDay);
        $previousSalesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $daySalesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('status', 'void'); 
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $voidQuery = $this->db->get();
        $begVoid = $voidQuery->num_rows() > 0 ? $voidQuery->row()->ornumber : "000000";
    
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('status', 'void');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $endVoidQuery = $this->db->get();
        $endVoid = $endVoidQuery->num_rows() > 0 ? $endVoidQuery->row()->ornumber : "000000";
    
        $this->db->reset_query();
        $this->db->select_sum('vatable_sales');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $vatableSalesQuery = $this->db->get();
        $totalVatableSales = $vatableSalesQuery->num_rows() > 0 ? $vatableSalesQuery->row()->vatable_sales : 0;
    
        $this->db->reset_query();
        $this->db->select_sum('vat');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $vatQuery = $this->db->get();
        $totalVAT = $vatQuery->num_rows() > 0 ? $vatQuery->row()->vat : 0;
    
        $this->db->reset_query();
        $this->db->select_sum('vat_exempt');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $vatExemptQuery = $this->db->get();
        $totalVATExempt = $vatExemptQuery->num_rows() > 0 ? $vatExemptQuery->row()->vat_exempt : 0;
    

         // Calculate total gross amount for the day
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $grossAmountQuery = $this->db->get();

         // Calculate Discounts
        $this->db->reset_query();
        $this->db->select('discount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $discountQuery = $this->db->get();
        
        // Calculate Discounts
        $this->db->reset_query();
        $this->db->select('discount'); // Select discount type
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $discountQuery = $this->db->get();

        $totalDiscount = 0;
        $discountSummary = ['SPWD' => 0, 'Tenant' => 0, 'Resident' => 0]; // Initialize discount summary

        if ($discountQuery->num_rows() > 0) {
            foreach ($discountQuery->result() as $row) {
                if (isset($row->discount) && is_numeric($row->discount)) {
                    $totalDiscount += (float)$row->discount;

                    // Summarize discounts based on type
                    if (isset($row->discount_type)) {
                        switch ($row->discount_type) {
                            case 'SPWD':
                                $discountSummary['SPWD'] += (float)$row->discount;
                                break;
                            case 'Tenant':
                                $discountSummary['Tenant'] += (float)$row->discount;
                                break;
                            case 'Resident':
                                $discountSummary['Resident'] += (float)$row->discount;
                                break;
                        }
                    }
                }
            }
        }

        $totalDiscount = 0;
        if ($discountQuery->num_rows() > 0) {
            foreach ($discountQuery->result() as $row) {
                if (isset($row->discount) && is_numeric($row->discount)) {
                    $totalDiscount += (float)$row->discount;
                }
            }
        }
        
        $totalGrossAmount = $grossAmountQuery->num_rows() > 0 ? $grossAmountQuery->row()->amount : 0;


        $paymentModes = ['Cash', 'Gcash', 'Paymaya'];
        $payments = [];
        $totalPayments = 0;
    
        foreach ($paymentModes as $mode) {
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->from('transactions');
            $this->db->where('cashier_id', $cashierId);
            $this->db->where('pid', $terminalId);
            $this->db->where('paymode', $mode);
            $this->db->where('paid_time >=', $startOfDay);
            $this->db->where('paid_time <=', $endOfDay);
            $query = $this->db->get();
    
            $payments[$mode] = ($query->num_rows() > 0 && $query->row()->amount !== null) ? $query->row()->amount : 0;
            $totalPayments += $payments[$mode];
        }
    
        $salesForTheDay = $daySalesQuery->num_rows() > 0 ? $daySalesQuery->row()->amount : 0;
        $presentAccumulatedSales = $salesQuery->num_rows() > 0 ? $salesQuery->row()->amount : 0;
        $previousAccumulatedSales = $previousSalesQuery->num_rows() > 0 ? $previousSalesQuery->row()->amount : 0;
    
        $remainingFund = $drawerRemQuery->num_rows() > 0 ? $drawerRemQuery->row()->remaining : 0;
        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
    
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : "000000";
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : "000000";

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('status', 'void');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $voidAmountQuery = $this->db->get();
        $totalVoidAmount = $voidAmountQuery->num_rows() > 0 ? $voidAmountQuery->row()->amount : 0;


        // Calculate total gross amount for the day
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $grossAmountQuery = $this->db->get();
        $totalGrossAmount = $grossAmountQuery->num_rows() > 0 ? $grossAmountQuery->row()->amount : 0;

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('status', 'void');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $voidAmountQuery = $this->db->get();
        $totalVoidAmount = $voidAmountQuery->num_rows() > 0 ? $voidAmountQuery->row()->amount : 0;

        $totalVoidAmount = 0;
        $lessVoid = 0;

        $this->db->reset_query();
        $this->db->select('COUNT(*) as drop_off_count');
        $this->db->from('parking');
        $this->db->where('out_time IS NOT NULL');
        $this->db->where('paid_status', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $dropOffQuery = $this->db->get();
        $dropOffCount = $dropOffQuery->num_rows() > 0 ? $dropOffQuery->row()->drop_off_count : 0;
    
        
        $expectedTotal = $openingFund + $totalPayments;
        $shortOver = $remainingFund - $expectedTotal;
    
        $netAmount = $totalGrossAmount - $totalDiscount - $totalVoidAmount - $totalVAT;

        return array_merge(
            [
                'first_ornumber' => $firstOrnumber,
                'last_ornumber' => $lastOrnumber,
                'beg_void' => $begVoid,
                'end_void' => $endVoid,
                'openingFund' => $openingFund,
                'remainingFund' => $remainingFund,
                'presentAccumulatedSales' => $presentAccumulatedSales ?: 0,
                'salesForTheDay' => $salesForTheDay ?: 0,
                'previousAccumulatedSales' => $previousAccumulatedSales,
                'totalPaymentsReceived' => $totalPayments,
                'dropOffCount' => $dropOffCount,
                'shortOver' => $shortOver,
                'totalVatableSales' => $totalVatableSales,
                'totalVAT' => $totalVAT,
                'totalVATExempt' => $totalVATExempt,
                'totalGrossAmount' => $totalGrossAmount,
                'totalDiscount' => $totalDiscount,
                'lessVoid' => $lessVoid,
                'vatAdjustment' => $totalVAT,
                'netAmount' => $netAmount
            ],
            $payments,
            $discountSummary 
        );
    }
    
    

    public function getEndDayReport($date){
        $cashierId = 10; // Hardcoded for now
        $terminalId = 1; // Hardcoded for now
    
        $startOfDay = strtotime($date . ' midnight');
        $endOfDay = strtotime($date . ' tomorrow midnight') - 1;
    
        // First ornumber query
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $firstQuery = $this->db->get();
    
        // Last ornumber query
        $this->db->reset_query();
        $this->db->select('ornumber');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $lastQuery = $this->db->get();
    
        // Opening fund query
        $this->db->reset_query();
        $this->db->select("opening_fund");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerQuery  = $this->db->get();
    
        // Remaining fund query
        $this->db->reset_query();
        $this->db->select("remaining");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerRemQuery  = $this->db->get();
    
        // Sales data queries
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $salesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time <', $startOfDay);
        $previousSalesQuery = $this->db->get();
    
        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $daySalesQuery = $this->db->get();
    
        // Payment modes
        $paymentModes = ['Cash', 'Gcash', 'Paymaya'];
        $payments = [];
        $totalPayments = 0;
    
        foreach ($paymentModes as $mode) {
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->from('transactions');
            $this->db->where('cashier_id', $cashierId);
            $this->db->where('pid', $terminalId);
            $this->db->where('paymode', $mode);
            $this->db->where('paid_time >=', $startOfDay);
            $this->db->where('paid_time <=', $endOfDay);
            $query = $this->db->get();
    
            $payments[$mode] = ($query->num_rows() > 0 && $query->row()->amount !== null) ? $query->row()->amount : 0;
            $totalPayments += $payments[$mode];
        }
    
        $salesForTheDay = $daySalesQuery->num_rows() > 0 ? $daySalesQuery->row()->amount : 0;
        $presentAccumulatedSales = $salesQuery->num_rows() > 0 ? $salesQuery->row()->amount : 0;
        $previousAccumulatedSales = $previousSalesQuery->num_rows() > 0 ? $previousSalesQuery->row()->amount : 0;
    
        $remainingFund = $drawerRemQuery->num_rows() > 0 ? $drawerRemQuery->row()->remaining : 0;
        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
    
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : null;
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : null;
    
    
        $expectedTotal = $openingFund + $totalPayments;
        $shortOver = $remainingFund - $expectedTotal;
    
        return array_merge(
            [
                'first_ornumber' => $firstOrnumber,
                'last_ornumber' => $lastOrnumber,
                'openingFund' => $openingFund,
                'remainingFund' => $remainingFund,
                'presentAccumulatedSales' => $presentAccumulatedSales,
                'salesForTheDay' => $salesForTheDay,
                'previousAccumulatedSales' => $previousAccumulatedSales,
                'totalPaymentsReceived' => $totalPayments,
                'shortOver' => $shortOver,
            ],
            $payments
        );
    }

    public function getOrganization($id)
    {
        $this->db->reset_query();
    
        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('id', $id);
        $query = $this->db->get();
    
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }
    public function getPtu($id)
    {
        $this->db->reset_query();
    
        $this->db->select('*');
        $this->db->from('ptu');
        $this->db->where('id', $id);
        $query = $this->db->get();
    
        if($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }
    
    



}