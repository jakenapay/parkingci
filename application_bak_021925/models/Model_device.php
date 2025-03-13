<?php
defined('BASEPATH') or exit('No direct scripts allowed');

class Model_device extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkTerminalDrawer($terminalId)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $this->db->from('cash_drawer');
        $query = $this->db->get();

        if($query->num_rows() >  0)
        {
            return true;
        }else{
            return false;
        }
    }

    public function updateCompanyOr($data)
    {
        $recordId = $data['id'];
        $this->db->where('id', $recordId);
        $this->db->update('company', $data);
    }

    public function createData($data)
    {
        $query = $this->db->insert('cash_drawer', $data);

        if($query)
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function getData($access, $code)
    {
        $this->db->select('*');
        $this->db->from('parking');
        $this->db->where('AccessType', $access);
        $this->db->where('parking_code', $code);
        $this->db->where('out_time', '');
        $this->db->where('paid_status', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getStorage($terminalId)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $this->db->from('cash_drawer');
        $query = $this->db->get();

        if($query->num_rows() >  0)
        {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function updateStorage($data)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;

        $terminalId = $data['terminal_id'];


        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $this->db->from('cash_drawer');
        $query = $this->db->update('cash_drawer', $data);


        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getCompany($companyId)
    {
        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('id', $companyId);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getPtu($ptuid)
    {
        $this->db->select('*');
        $this->db->from('ptu');
        $this->db->where('id', $ptuid);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function postTransaction($data)
    {
        $query = $this->db->insert('transactions', $data);

        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function updateParking($data)
    {

        $recordId = $data['id'];
        $parkingData = array(
            'id'    =>  $data['id'],
            'paid_time' =>  $data['paid_time'],
            'total_time'    =>  $data['total_time'],
            'earned_amount' =>  $data['amount'],
            'paid_status'   =>  $data['paid_status']
        );

        $this->db->where('id', $recordId);
        $this->db->update('parking', $parkingData);
    }

    public function summarizedData($date) {
        $cashierId = 12;
        $terminalId = 2;
    
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
    
        // Drop-off count
        $this->db->reset_query();
        $this->db->select('COUNT(*) as drop_off_count');
        $this->db->from('parking');
        $this->db->where('out_time IS NOT NULL');
        $this->db->where('paid_status', 1);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $dropOffQuery = $this->db->get();
        $dropOffCount = $dropOffQuery->num_rows() > 0 ? $dropOffQuery->row()->drop_off_count : 0;
    
        // Calculate expected total and short/over
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
                'shortOver' => $shortOver, // Added Short/Over calculation
            ],
            $payments
        );
    }
}