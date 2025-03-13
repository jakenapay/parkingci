<?php

class Model_terminal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function checkDrawer($data){
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

		$this->db->select('*');
		$this->db->from('cash_drawer');
		$this->db->where('terminal_id', $data);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
		$queryCheck = $this->db->get();


		if($queryCheck->num_rows() > 0){
			return $queryCheck->row_array();
		}else{
			return false;
		}
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
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function deductChangeAmount($data)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;

        $terminalId = $data['terminal_id'];


        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('start_time <=', $endTime);
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

    public function create($data)
    {
        $transaction = array(
            'pid' => 1,
            'cashier_id' => $data['cashier_id'],
            'ornumber' => $data['ornumber'],
            'gate_en' => $data['gateEntry'],
            'access_type' => $data['accessType'],
            'parking_code' => $data['parkingCode'],
            'vehicle_cat_id' => $data['vehicleClass'],
            'rate_id' => $data['vehicleRate'],
            'in_time' => $data['entryTime'],
            'paid_time' => $data['paymentTime'],
            'total_time' => $data['parkingTime'],
            'amount' => $data['amount'],
            'discount' => $data['discount'],
            'vat' => $data['vat'],
            'vatable_sales' => $data['bill'],
            'paymode' => $data['mode'],
            'status' => 1
        );

        $parking = array(
            'paid_time' => $data['paymentTime'],
            'earned_amount' => $data['amount'],
            'total_time' => $data['parkingTime'],
            'paid_status' => 1
        );

        $this->db->trans_begin();

        $this->db->where('ornumber', $data['ornumber']);
        $existingTransaction = $this->db->get('transactions')->row_array();

        if ($existingTransaction) {
            $this->db->trans_rollback();
            return array('status' => 'error', 'message' => 'Transaction already exists.');
        }

        $createTransaction = $this->db->insert('transactions', $transaction);

        $company = array(
            'OR' => $data['ornumber']
        );
        $this->db->where('id', 1);
        $this->db->update('company', $company);

        if ($createTransaction) {
            $this->db->where('id', $data['parkingId']);
            $updateRecord = $this->db->update('parking', $parking);

            if ($updateRecord) {
                $this->db->trans_commit();
                return array('status' => 'success', 'message' => 'Transaction and parking record updated successfully.');
            } else {
                $this->db->trans_rollback();
                return array('status' => 'error', 'message' => 'Failed to update parking record.');
            }
        } else {
            $this->db->trans_rollback();
            return array('status' => 'error', 'message' => 'Failed to create transaction.');
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

    public function updateCompanyOr($data)
    {
        // $this->db->reset_query();
        $recordId = $data['id'];
        $this->db->where('id', $recordId);
        $this->db->update('company', $data);
    }

    public function getTicket($code)
    {
        $this->db->select('*');
        $this->db->where('qrcode', $code);
        $this->db->from('complimentary');
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        else
        {
            return false;
        }
    }


    public function getTransactions($cid){
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cid);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $query = $this->db->get();

        if($query->num_rows() > 0 ){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function getXReadingReport($terminal_id, $cashier_id)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
    
        // Fetch cash drawer data
        $this->db->select('opening_fund, remaining, start_time, end_time');
        $this->db->from('cash_drawer');
        $this->db->where('terminal_id', $terminal_id);
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $cash_drawer = $this->db->get()->row_array();
    
        // Ensure cash_drawer has data
        if (empty($cash_drawer)) {
            $cash_drawer = [
                'opening_fund' => 0,
                'remaining' => 0,
                'start_time' => null,
                'end_time' => null
            ];
        }
    
        $this->db->select('paymode, SUM(amount) as total');
        $this->db->from('transactions');
        $this->db->where('pid', $terminal_id);
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('paid_time >=', $startTime);
        $this->db->where('paid_time <=', $endTime);
        $this->db->group_by('paymode');
        $transactions = $this->db->get()->result_array();
    
        $transactionTotals = [];
        foreach ($transactions as $transaction) {
            $transactionTotals[$transaction['paymode']] = $transaction['total'];
        }
    
        $paymentModes = ['GCash', 'Paymaya', 'Cash', 'Credit Card', 'Others'];
        foreach ($paymentModes as $mode) {
            if (!isset($transactionTotals[$mode])) {
                $transactionTotals[$mode] = 0; // Initialize missing payment types
            }
        }
    
        $this->db->select('MIN(ornumber) as beg_invoice, MAX(ornumber) as end_invoice');
        $this->db->from('transactions');
        $this->db->where('pid', $terminal_id);
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('paid_time >=', $startTime);
        $this->db->where('paid_time <=', $endTime);
        $invoice_numbers = $this->db->get()->row_array();
    
        // Prepare the data for the report
        $data = [
            'opening_fund' => $cash_drawer['opening_fund'],
            'remaining' => $cash_drawer['remaining'],
            'start_time' => $cash_drawer['start_time'],
            'end_time' => $cash_drawer['end_time'],
            'transactions' => $transactionTotals, // Updated to use the new totals
            'beg_invoice' => $invoice_numbers['beg_invoice'] ?? null,
            'end_invoice' => $invoice_numbers['end_invoice'] ?? null,
        ];
    
        return $data;
    }

    
    public function getTransactionsByTerminalId($terminalId)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startTime);
        $this->db->where('paid_time <=', $endTime);
        $this->db->where('pid', $terminalId);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    
        return false; // No transactions found
    }
    


    public function getReading($cashierId, $date)
    {
        date_default_timezone_set("Asia/Manila");
        $todayStart = strtotime($date . ' 00:00:00'); // Start of the selected date
        $todayEnd = strtotime($date . ' 23:59:59'); // End of the selected date
    
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('paid_time >=', $todayStart);
        $this->db->where('paid_time <=', $todayEnd);
        $queryData = $this->db->get();
    
        if ($queryData->num_rows() > 0) {
            $transactions = $queryData->result_array();
    
            // Initialize totals
            $total_sales = 0;
            $total_vat = 0;
            $total_vatable_sales = 0;
            $cash_payments = 0;
            $ewallet_payments = 0;
            $complimentary_tickets = 0;
            $total_transactions = 0;
            $total_time_parked = 0;
            $total_vehicles = 0;
    
            foreach ($transactions as $transaction) {
                // Convert total_time to minutes
                list($hours, $minutes) = explode(':', $transaction['total_time']);
                $total_time_in_minutes = $hours * 60 + $minutes;
    
                $total_sales += $transaction['amount'];
                $total_vat += $transaction['vat'];
                $total_vatable_sales += str_replace(',', '', $transaction['vatable_sales']); // Remove commas
                $total_time_parked += $total_time_in_minutes;
                $total_vehicles++;
    
                switch ($transaction['paymode']) {
                    case 'Cash':
                        $cash_payments += $transaction['amount'];
                        break;
                    case 'E-Wallet':
                        $ewallet_payments += $transaction['amount'];
                        break;
                    case 'Complimentary':
                        $complimentary_tickets += $transaction['amount'];
                        break;
                }
    
                $total_transactions++;
            }
    
            // Prepare results
            return [
                'total_sales' => $total_sales,
                'total_vat' => $total_vat,
                'total_vatable_sales' => $total_vatable_sales,
                'cash_payments' => $cash_payments,
                'ewallet_payments' => $ewallet_payments,
                'complimentary_tickets' => $complimentary_tickets,
                'total_transactions' => $total_transactions,
                'total_time_parked' => $total_time_parked,
                'total_vehicles' => $total_vehicles,
                'transactions' => $transactions, // In case you need individual transactions
            ];
        } else {
            return false;
        }
    }
    

    public function getTransactionRecords($cashierId, $date){
        date_default_timezone_set("Asia/Manila");
        $todayStart = strtotime($date . ' 00:00:00'); // Start of the selected date
        $todayEnd = strtotime($date . ' 23:59:59'); // End of the selected date
    
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('paid_time >=', $todayStart);
        $this->db->where('paid_time <=', $todayEnd);
        $queryData = $this->db->get();

        if($queryData->num_rows() > 0){
            return $queryData->result_array();
        }else{
            return false;
        }
    }

    public function getReadingReport($cashierId, $date)
    {
        date_default_timezone_set("Asia/Manila");
        $todayStart = strtotime($date . ' 00:00:00'); // Start of the selected date
        $todayEnd = strtotime($date . ' 23:59:59'); // End of the selected date
    
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('paid_time >=', $todayStart);
        $this->db->where('paid_time <=', $todayEnd);
        $queryData = $this->db->get();
    
        if ($queryData->num_rows() > 0) {
            $transactions = $queryData->result_array();
    
            // Initialize totals
            $total_sales = 0;
            $total_vat = 0;
            $total_vatable_sales = 0;
            $cash_payments = 0;
            $ewallet_payments = 0;
            $complimentary_tickets = 0;
            $total_transactions = 0;
            $total_time_parked = 0;
            $total_vehicles = 0;
    
            foreach ($transactions as $transaction) {
                // Convert total_time to minutes
                list($hours, $minutes) = explode(':', $transaction['total_time']);
                $total_time_in_minutes = $hours * 60 + $minutes;
    
                $total_sales += $transaction['amount'];
                $total_vat += $transaction['vat'];
                $total_vatable_sales += str_replace(',', '', $transaction['vatable_sales']); // Remove commas
                $total_time_parked += $total_time_in_minutes;
                $total_vehicles++;
    
                switch ($transaction['paymode']) {
                    case 'Cash':
                        $cash_payments += $transaction['amount'];
                        break;
                    case 'E-Wallet':
                        $ewallet_payments += $transaction['amount'];
                        break;
                    case 'Complimentary':
                        $complimentary_tickets += $transaction['amount'];
                        break;
                }
    
                $total_transactions++;
            }
    
            // Prepare results
            return [
                'total_sales' => $total_sales,
                'total_vat' => $total_vat,
                'total_vatable_sales' => $total_vatable_sales,
                'cash_payments' => $cash_payments,
                'ewallet_payments' => $ewallet_payments,
                'complimentary_tickets' => $complimentary_tickets,
                'total_transactions' => $total_transactions,
                'total_time_parked' => $total_time_parked,
                'total_vehicles' => $total_vehicles,
                'transactions' => $transactions, // In case you need individual transactions
            ];
        } else {
            return false;
        }
    }


    public function get_z_reading($cashier_id, $date)
    {
        $this->db->select('
            MIN(or_number) as first_or,
            MAX(or_number) as last_or,
            SUM(earned_amount) as total_sales,
            SUM(vat) as total_vat,
            SUM(vatable_sales) as total_vatable_sales,
            COUNT(id) as total_transactions,
            SUM(total_time) as total_time_parked,
            SUM(CASE WHEN paymode = "Cash" THEN earned_amount ELSE 0 END) as cash_payments,
            SUM(CASE WHEN paymode = "E-Wallet" THEN earned_amount ELSE 0 END) as ewallet_payments,
            SUM(CASE WHEN paymode = "Complimentary" THEN earned_amount ELSE 0 END) as complimentary_payments,
            COUNT(DISTINCT vehicle_id) as total_vehicles
        ');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('DATE(FROM_UNIXTIME(payment_time))', $date);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_x_reading($cashier_id, $date)
    {
        $this->db->select('
            MIN(or_number) as first_or,
            MAX(or_number) as current_or,
            SUM(earned_amount) as current_sales,
            SUM(vat) as current_vat,
            SUM(vatable_sales) as current_vatable_sales,
            COUNT(id) as current_transactions,
            SUM(total_time) as total_time_parked,
            SUM(CASE WHEN paymode = "Cash" THEN earned_amount ELSE 0 END) as cash_payments,
            SUM(CASE WHEN paymode = "E-Wallet" THEN earned_amount ELSE 0 END) as ewallet_payments,
            SUM(CASE WHEN paymode = "Complimentary" THEN earned_amount ELSE 0 END) as complimentary_payments,
            COUNT(DISTINCT vehicle_id) as current_vehicles
        ');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashier_id);
        $this->db->where('DATE(FROM_UNIXTIME(payment_time))', $date);
        $query = $this->db->get();
        return $query->row_array();
    }
    
}