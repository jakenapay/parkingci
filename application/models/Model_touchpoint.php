<?php

class Model_touchpoint extends CI_Model
{
    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        parent::__construct();
    }

    public function terminalDrawer($terminalId)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('end_time <=', $endTime);
        $this->db->from('cash_drawer');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function terminalDrawerCheck($terminalId)
    {
        // Format dates as strings matching VARCHAR format
        $startTime = date('Y-m-d 00:00:00');    // Today at midnight
        $endTime = date('Y-m-d 23:59:59');      // Today at end of the day

        $this->db->select('*');                 // SELECT comes before FROM
        $this->db->from('cash_drawer');         // Define the table
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);   // VARCHAR format comparison
        $this->db->where('end_time <=', $endTime);       // VARCHAR format comparison

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }


    public function getRecord($access, $code)
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
            return "no data";
        }
    }

    public function getRate($vehicleId)
    {
        $this->db->select("*");
        $this->db->from("rates");
        $this->db->where("id", $vehicleId);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getDiscountRates()
    {
        $this->db->select("*");
        $this->db->from("discounts");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getSimilarRecord($plate)
    {
        $this->db->like('parking_code', $plate);  // 'plate_number' is the field in your database where plate numbers are stored
        $query = $this->db->get('parking');  // Replace 'vehicles' with your table name

        if ($query->num_rows() > 0) {
            return $query->result_array();  // Return the results as an array
        }
        return [];
    }

    public function getDiscounts($discount, $vehicleId)
    {
        $this->db->select("*");
        $this->db->from("discounts");
        $this->db->where("discount_code", $discount);
        $this->db->where("vehicle_id", $vehicleId);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function updateDrawer($data)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;
        $terminalId = $data['terminal_id'];
        $this->db->select('*');
        $this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startTime);
        $this->db->where('start_time <=', $endTime);
        $query = $this->db->update('cash_drawer', $data);


        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateDrawerBalance($data)
{
    $startTime = strtotime('today midnight');
    $endTime = strtotime('tomorrow midnight') - 1;
    $terminalId = $data['terminal_id'];

    // Use update directly with conditions
    $this->db->where('terminal_id', $terminalId);
    $this->db->where('start_time >=', $startTime);
    $this->db->where('start_time <=', $endTime);
    $query = $this->db->update('cash_drawer', $data);

    return $query ? TRUE : FALSE;
}

    public function getOrganization($id)
    {
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
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

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    public function createTransaction($data)
    {
        $query = $this->db->insert('transactions', $data);

        if ($query) {
            return $this->db->insert_id(); // Returns the last inserted ID
        } else {
            return false;
        }
    }

    public function createRecDiscount($data)
    {
        $query = $this->db->insert('discouned_customers', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function updateParkingData($data)
    {
        $this->db->select("id");
        $id = $data['id'];
        $this->db->where("id", $id);
        $query = $this->db->update("parking", $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCompany($data)
    {
        $this->db->select("id");
        $id = $data['id'];
        $this->db->where("id", $id);
        $query = $this->db->update("company", $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function updateComplimentary($data)
    {
        $this->db->select("id");
        $id = $data['id'];
        $this->db->where("id", $id);
        $query = $this->db->update("complimentary", $data);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function createData($data)
    {
        $query = $this->db->insert('cash_drawer', $data);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getSummary($terminalId, $cashierId)
    {
        $this->db->select("*");
        $this->db->where("pid", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->from("transactions");

    }

    public function getTransactions($uid)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;

        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("cashier_id", $uid);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function refundTransaction($uid, $siNumber)
    {   
        // First, retrieve the transaction record based on cashier id and OR number
        $transaction = $this->db->select('*')
            ->from('transactions')
            ->where(['cashier_id' => $uid, 'ornumber' => $siNumber])
            ->get()
            ->row_array();

        // If no record or no paid time, do not update
        if (!$transaction) {
            return false;
        }
        if (date('Y-m-d', $transaction['paid_time']) !== date('Y-m-d')) {
            // print_r($transaction['paid_time']);
            // print_r(date('Y-m-d'));
            return false;
        }

        // Proceed with updating the transaction status to refunded (status 3)
        $this->db->where(['cashier_id' => $uid, 'ornumber' => $siNumber])
            ->update('transactions', ['transact_status' => 3]);

        return $this->db->affected_rows() > 0;
    }

    public function getTransactionsForReprint()
    {
        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->order_by("ornumber", "DESC"); // Order by OR number descending
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function getReceipt($ornumber)
    {
        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("ornumber", $ornumber);
        $this->db->limit(1); // Limit to only the first result
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return [];
        }
    }

    public function getRecentTransactions($uid)
    {
        $startTime = strtotime('today midnight');
        $endTime = strtotime('tomorrow midnight') - 1;

        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("cashier_id", $uid);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->order_by("paid_time", "DESC"); // Order by most recent
        $this->db->limit(5); // Limit to 5 records

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }


    public function getAllTransactions($uid)
    {
        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("cashier_id", $uid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function getCashierList()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where_in("position", array("cashier", "ptu"));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getTerminalList()
    {
        $this->db->select("*");
        $this->db->from("ptu");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getComplimentary($code)
    {
        $this->db->select("*");
        $this->db->from("complimentary");
        $this->db->where("qrcode", $code);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function geteJournalData($startDate, $endDate, $cashierId, $terminalId)
    {
        $startTime = strtotime($startDate . ' 00:00:00');
        $endTime = strtotime($endDate . ' 23:59:59');
        if ($startDate == date('d-m-Y')) {
            $startTime = strtotime('today 00:00:00');
        }
        if ($endDate == date('d-m-Y')) {
            $endTime = strtotime('today 23:59:59');
        }
        $this->db->select("*");
        $this->db->from("transactions");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);

        return $this->db->get()->result_array();
    }

    public function getUserData($uid)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id", $uid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getTerminalData($tid)
    {
        $this->db->select("*");
        $this->db->from("ptu");
        $this->db->where("id", $tid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }



    public function getXreadingData($date, $cashierId, $terminalId)
    {
        $startTime = strtotime($date . ' 00:00:00');
        $endTime = strtotime($date . ' 23:59:59');

        $this->db->select_min("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $beginOrNumber = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_max("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $endOrNumber = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "Cash");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $cashPayments = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "GCash");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $gcashPayments = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "Paymaya");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $paymayaPayments = $this->db->get("transactions")->row()->earned_amount;

        $totalPaymentsReceived = ($cashPayments ?? 0) + ($gcashPayments ?? 0) + ($paymayaPayments ?? 0);

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 2);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $voidAmount = $this->db->get("transactions")->row()->earned_amount;

        $refundAmount = 0;

        $this->db->select_sum("amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("time_withdraw >=", $startTime);
        $this->db->where("time_withdraw <=", $endTime);
        $totalWithdrawals = $this->db->get("withdrawals")->row()->amount;

        $this->db->select("*");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("status", 1);
        $this->db->where("start_time >=", $startTime);
        $this->db->where("start_time <=", $endTime);
        $cashDrawer = $this->db->get("cash_drawer")->row();

        $this->db->select_sum("change");  
        $this->db->where("cashier_id", $cashierId);  
        $this->db->where("pid", $terminalId);  
        $this->db->where("paid_time >=", $startTime);  
        $this->db->where("paid_time <=", $endTime);  
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $totalChangeGiven = $this->db->get("transactions")->row()->change ?? 0;  

        $openingFund = $cashDrawer ? $cashDrawer->opening_fund : 0;
        $remainingFund = $cashDrawer ? $cashDrawer->remaining : 0;

        $lessWithdrawal = $totalWithdrawals ?? 0;
        $remaining = $openingFund + ($cashPayments ?? 0) - $lessWithdrawal;
        $cashInDrawer = $openingFund + $cashPayments - $lessWithdrawal - $totalChangeGiven;
        $shortOver = $cashInDrawer - ($openingFund + $cashPayments - $lessWithdrawal - $totalChangeGiven);

        return [
            'beginOrNumber' => $beginOrNumber ?? 0,
            'endOrNumber' => $endOrNumber ?? 0,
            'cashPayments' => $cashPayments ?? 0,
            'gcashPayments' => $gcashPayments ?? 0,
            'paymayaPayments' => $paymayaPayments ?? 0,
            'totalPaymentsReceived' => $totalPaymentsReceived,
            'voidAmount' => $voidAmount ?? 0,
            'refundAmount' => $refundAmount,
            'totalWithdrawals' => $totalWithdrawals ?? 0,
            'lessWithdrawal' => $lessWithdrawal,
            'cashInDrawer' => $cashInDrawer ?? 0,
            'openingFund' => $openingFund,
            'remaining' => $remaining,
            'shortOver' => $shortOver ?? 0,
        ];
    }


    public function getZreadingData($date, $cashierId, $terminalId)
    {
        $startTime = strtotime($date . ' 00:00:00');
        $endTime = strtotime($date . ' 23:59:59');

        $this->db->select_min("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $beginOrNumber = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_max("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $endOrNumber = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_min("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 2); // Beg Void
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $beginVoidOr = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_max("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 2); // End Void
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $endVoidOr = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_min("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 3); // Beg Return
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $beginReturnOr = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_max("ornumber");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 3); // End Return
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $endReturnOr = $this->db->get("transactions")->row()->ornumber;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("status", 1);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $dailySales = $this->db->get("transactions")->row()->earned_amount;

        $previousEndTime = $startTime - 1;
        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time <=", $previousEndTime);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $previousAccumulatedSales = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("vatable_sales");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $vatableSales = $this->db->get("transactions")->row()->vatable_sales;

        $this->db->select_sum("vat");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $vatAmount = $this->db->get("transactions")->row()->vat;

        $this->db->select_sum("vat_exempt");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $vatExempt = $this->db->get("transactions")->row()->vat_exempt;


        $this->db->select_sum("zero_rated");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $zeroRatedSales = $this->db->get("transactions")->row()->zero_rated;


        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $discountAmount = $this->db->get("transactions")->row()->discount ?? 0;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 3); // 3 indicates a return/refund
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $returnAmount = $this->db->get("transactions")->row()->earned_amount ?? 0;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 2); // 3 indicates a void
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $voidAmount = $this->db->get("transactions")->row()->earned_amount ?? 0;

        $this->db->select_sum("amount"); // Correct column for total refunded amount
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 3); // Refund transactions
        $this->db->where("paymode <>", "Complimentary"); // Exclude Complimentary paymode
        $refundAmount = $this->db->get("transactions")->row()->amount ?? 0;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $discountAmounts = $this->db->get("transactions")->row()->discount ?? 0;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "Cash");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $cashPayments = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "GCash");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $gcashPayments = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("paymode", "Paymaya");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $paymayaPayments = $this->db->get("transactions")->row()->earned_amount;

        $totalPaymentsReceived = ($cashPayments ?? 0) + ($gcashPayments ?? 0) + ($paymayaPayments ?? 0);

        $this->db->select_sum("earned_amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("transact_status", 2);
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $voidAmount = $this->db->get("transactions")->row()->earned_amount;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "senior");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $seniorDiscounts = $this->db->get("transactions")->row()->discount;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "pwd");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $pwdDiscounts = $this->db->get("transactions")->row()->discount;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "naac");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $naacDiscounts = $this->db->get("transactions")->row()->discount;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "sp");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $spDiscounts = $this->db->get("transactions")->row()->discount;

        $this->db->select_sum("discount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "tenant");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $tenantDiscounts = $this->db->get("transactions")->row()->discount;

        $refundAmount = 0;

        $this->db->select_sum("amount");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("time_withdraw >=", $startTime);
        $this->db->where("time_withdraw <=", $endTime);
        $totalWithdrawals = $this->db->get("withdrawals")->row()->amount;

        $this->db->select("*");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("status", 1);
        $this->db->where("start_time >=", $startTime);
        $this->db->where("start_time <=", $endTime);
        $cashDrawer = $this->db->get("cash_drawer")->row();

        $this->db->select_sum("discount");
        $this->db->select_sum("vat");
        $this->db->where("cashier_id", $cashierId);
        $this->db->where("pid", $terminalId);
        $this->db->where("paid_time >=", $startTime);
        $this->db->where("paid_time <=", $endTime);
        $this->db->where("discount_type", "senior");
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $seniorDiscountData = $this->db->get("transactions")->row();

        $this->db->select_sum("change");  
        $this->db->where("cashier_id", $cashierId);  
        $this->db->where("pid", $terminalId);  
        $this->db->where("paid_time >=", $startTime);  
        $this->db->where("paid_time <=", $endTime);  
        $this->db->where("paymode <>", "Complimentary");  // Exclude Complimentary paymode
        $totalChangeGiven = $this->db->get("transactions")->row()->change ?? 0;  


        $seniorDiscount = $seniorDiscountData->discount ?? 0; // Total SC discount
        $seniorVAT = $seniorDiscountData->vat ?? 0;           // Associated VAT (if any)

        $vatAdjustment = $seniorDiscount * 0.12; // Assuming 12% VAT rate
        if ($vatAdjustment > $seniorVAT) {
            $vatAdjustment = $seniorVAT; // Ensure we don't exceed the VAT collected
        }


        $openingFund = $cashDrawer ? $cashDrawer->opening_fund : 0;
        $remainingFund = $cashDrawer ? $cashDrawer->remaining : 0;

        $lessWithdrawal = $totalWithdrawals ?? 0;

        $remaining = $openingFund + ($cashPayments ?? 0) - $lessWithdrawal;
        $cashInDrawer = $openingFund + $cashPayments - $lessWithdrawal - $totalChangeGiven;

        $shortOver = $cashInDrawer - ($openingFund + $cashPayments - $lessWithdrawal - $totalChangeGiven);
        $presentAccumulatedSales = $dailySales + $previousAccumulatedSales;
        
        $lessVatAdjustment = 0;
        $grossAmount = $vatableSales + $vatExempt + $vatAmount + $zeroRatedSales;
        $voidAmount = $voidAmount ?? 0;
        $refundAmount = $refundAmount ?? 0;
        $dailySales = $dailySales ?? 0;
        $adjustmentAmount = 0;
        $netAmount = $grossAmount - $discountAmount - $lessVatAdjustment - $voidAmount - $refundAmount;

        return [
            'beginOrNumber' => $beginOrNumber ?? 000000,
            'endOrNumber' => $endOrNumber ?? 000000,
            'beginVoidOr' => $beginVoidOr ?? str_pad(000000, 6, '0', STR_PAD_LEFT),
            'endVoidOr' => $endVoidOr ?? str_pad(000000, 6, '0', STR_PAD_LEFT),
            'beginReturnOr' => $beginReturnOr ?? str_pad(000000, 6, '0', STR_PAD_LEFT),
            'endReturnOr' => $endReturnOr ?? str_pad(000000, 6, '0', STR_PAD_LEFT),
            'dailySales' => $dailySales ?? 0,
            'previousAccumulatedSales' => $previousAccumulatedSales ?? 0,
            'presentAccumulatedSales' => $presentAccumulatedSales ?? 0,
            'vatableSales' => $vatableSales ?? 0,
            'vatAmount' => $vatAmount ?? 0,
            'vatExempt' => $vatExempt ?? 0,
            'zeroRated' => $zeroRatedSales ?? 0,
            'grossAmount' => $grossAmount ?? 0,
            'lessDiscount' => $discountAmounts ?? 0,
            'lessReturn' => $returnAmount ?? 0,
            'vatOnReturn' => 0,
            'lessVoid' => $voidAmount ?? 0,
            'lessVatAdjustment' => $lessVatAdjustment ?? 0,
            'netAmount' => $netAmount ?? 0,
            'seniorDiscount' => $seniorDiscounts ?? 0,
            'pwdDiscount' => $pwdDiscounts ?? 0,
            'naacDiscount' => $naacDiscounts ?? 0,
            'soloparentDiscount' => $spDiscounts ?? 0,
            'otherDiscount' => $tenantDiscounts ?? 0,
            'salesAdjustment' => $adjustmentAmount ?? 0,
            'seniorTransactions' => $seniorDiscounts ?? 0,
            'pwdTransactions' => $pwdDiscounts ?? 0,
            'regularDiscTransactions' => $tenantDiscounts ?? 0,
            'otherVatAdjustment' => 0,
            'cashPayments' => $cashPayments ?? 0,
            'gcashPayments' => $gcashPayments ?? 0,
            'paymayaPayments' => $paymayaPayments ?? 0,
            'totalPaymentsReceived' => $totalPaymentsReceived,
            'voidAmount' => $voidAmount ?? 0,
            'refundAmount' => $refundAmount,
            'totalWithdrawals' => $totalWithdrawals ?? 0,
            'lessWithdrawal' => $lessWithdrawal,
            'cashInDrawer' => $cashInDrawer ?? 0,
            'openingFund' => $openingFund,
            'remaining' => $remaining,
            'shortOver' => $shortOver ?? 0,
        ];
    }


    public function getDiscountsSummary($cid, $trmid, $startDate, $endDate)
    {
        // Convert start and end dates to Unix timestamps
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');

        // Get the Beginning OR Number
        // Get the Beginning OR Number (minimum within the date range)
        $this->db->select_min("ornumber");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp); // Add date filter
        $this->db->where("paid_time <=", $endTimestamp);   // Add date filter
        $beginOrNumber = $this->db->get("transactions")->row()->ornumber;

        // Get the Ending OR Number
        // Get the Ending OR Number (maximum within the date range)
        $this->db->select_max("ornumber");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp); // Add date filter
        $this->db->where("paid_time <=", $endTimestamp);   // Add date filter
        $endOrNumber = $this->db->get("transactions")->row()->ornumber;
        // Grand Beginning Balance
        $this->db->select_sum("earned_amount", "grand_beginning_balance");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("ornumber <", $beginOrNumber);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time <", $startTimestamp); // Before the start date
        $grandBeginningBalance = $this->db->get("transactions")->row()->grand_beginning_balance;


        // Grand Ending Balance
        $this->db->select_sum("earned_amount", "grand_ending_balance");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $grandEndingBalance = $this->db->get("transactions")->row()->grand_ending_balance;

        // Manual Sales
        $this->db->select_sum("earned_amount", "manual_sales");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("is_manual", 2);
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $manualSales = $this->db->get("transactions")->row()->manual_sales;

        // Gross Sales
        $this->db->select_sum("earned_amount", "gross_sales");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $grossSales = $this->db->get("transactions")->row()->gross_sales;

        // VATable Sales (Sum of the sales where VAT applies)
        $this->db->select_sum("vatable_sales", "vatable_sales");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $vatableSales = $this->db->get("transactions")->row()->vatable_sales;

        $this->db->select_sum("vat", "vat_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $vatAmount = $this->db->get("transactions")->row()->vat_amount;

        $this->db->select_sum("zero_rated", "zero_sales");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $zeroSales = $this->db->get("transactions")->row()->zero_sales;

        $this->db->select_sum("discount", "sc_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'senior');
        $seniorDiscount = $this->db->get("transactions")->row()->sc_amount;

        $this->db->select_sum("discount", "pwd_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'pwd');
        $pwdDiscount = $this->db->get("transactions")->row()->pwd_amount;

        $this->db->select_sum("discount", "sp_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'sp');
        $spDiscount = $this->db->get("transactions")->row()->sp_amount;

        $this->db->select_sum("discount", "naac_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'naac');
        $naacDiscount = $this->db->get("transactions")->row()->naac_amount;

        $this->db->select_sum("discount", "other_discount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'tenant');
        $otherDiscount = $this->db->get("transactions")->row()->other_discount;

        $this->db->select_sum("earned_amount", "returns_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 3);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $returnAmounts = $this->db->get("transactions")->row()->returns_amount;

        $this->db->select_sum("earned_amount", "void_amount");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 2);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $voidAmounts = $this->db->get("transactions")->row()->void_amount;

        // Adjustment on VAT - Senior Citizen
        $this->db->select_sum("vat", "vat_senior");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'senior');
        $vatSenior = $this->db->get("transactions")->row()->vat_senior;

        // Adjustment on VAT - PWD
        $this->db->select_sum("vat", "vat_pwd");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where("discount_type", 'pwd');
        $vatPwd = $this->db->get("transactions")->row()->vat_pwd;

        // Adjustment on VAT - Others
        $this->db->select_sum("vat", "vat_others");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $this->db->where_not_in("discount_type", ['senior', 'pwd']);
        $vatOthers = $this->db->get("transactions")->row()->vat_others;

        // VAT-Exempt Sales
        $this->db->select_sum("vat_exempt", "vat_exempt");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paymode <>", "Complimentary");
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $vatExemptSales = $this->db->get("transactions")->row()->vat_exempt;

        // Adjustment on VAT - Returns
        $this->db->select_sum("vat", "vat_returns");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 3); // Assuming 3 indicates Returns
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        $vatReturns = $this->db->get("transactions")->row()->vat_returns;

        $this->db->select_sum("vat", "vat_payable");
        $this->db->where("cashier_id", $cid);
        $this->db->where("pid", $trmid);
        $this->db->where("transact_status", 1);
        $this->db->where("paid_time >=", $startTimestamp);
        $this->db->where("paid_time <=", $endTimestamp);
        // $vatPayable = $this->db->get("transactions")->row()->vat_payable;
        // Adjustment on VAT - Total
        $totalVatAdjustment = ($vatSenior ?? 0) +
            ($vatPwd ?? 0) +
            ($vatOthers ?? 0) +
            ($vatReturns ?? 0);
        $vatPayable = ($vatAmount ?? 0) - ($totalVatAdjustment ?? 0);

        $totalDeductions = ($seniorDiscount ?? 0) +
            ($pwdDiscount ?? 0) +
            ($spDiscount ?? 0) +
            ($naacDiscount ?? 0) +
            ($otherDiscount ?? 0) +
            ($returnAmounts ?? 0) +
            ($voidAmounts ?? 0);

        $netSales = ($grossSales ?? 0) - $totalDeductions;

        $totalIncome = ($grossSales ?? 0) - ($returnAmounts ?? 0) - ($totalDeductions ?? 0);

        // $salesOverflow = ($grandEndingBalance ?? 0) - ($grandBeginningBalance ?? 0);
        $salesOverflow = $grossSales ?? 0;
        $remarks = "Generated Summary for cashier id: $cid and terminal id: $trmid";

        $this->db->select('transactions.*, discouned_customers.name AS customer_name, discouned_customers.tin_id, discouned_customers.id_number,  transactions.ornumber, transactions.earned_amount, transactions.vat_exempt, SUM(transactions.earned_amount) AS new_sales');
        $this->db->from('transactions');
        $this->db->join('discouned_customers', 'transactions.id = discouned_customers.transact_id', 'left');
        $this->db->join('discounts', 'transactions.discount_type = discounts.discount_code', 'left');
        $this->db->where("transactions.cashier_id", $cid);
        $this->db->where("transactions.pid", $trmid);
        $this->db->where("transactions.transact_status", 1);
        $this->db->where("transactions.paymode <>", "Complimentary");
        $this->db->where("transactions.paid_time >=", $startTimestamp);
        $this->db->where("transactions.paid_time <=", $endTimestamp);
        $this->db->where("transactions.discount_type", "senior");

        $this->db->group_by('transactions.discount_type');

        $query = $this->db->get();
        $result = $query->result_array();

        return [
            'startTimeRange' => $startDate,
            'beginOrNumber' => $beginOrNumber ?? 0,
            'endOrNumber' => $endOrNumber ?? 0,
            'grandBeginningBalance' => $grandBeginningBalance ?? 0,
            'grandEndingBalance' => $grandEndingBalance ?? 0,
            'manualSalesInvoice' => $manualSales ?? 0,
            'grossSales' => $grossSales ?? 0,
            'vatableSales' => $vatableSales ?? 0,
            'vatAmount' => $vatAmount ?? 0,
            'zeroRated' => $zeroSales ?? 0,
            'seniorDiscount' => $seniorDiscount ?? 0,
            'pwdDiscount' => $pwdDiscount ?? 0,
            'soloParentDiscount' => $spDiscount ?? 0,
            'naacDiscount' => $naacDiscount ?? 0,
            'otherDiscount' => $otherDiscount ?? 0,
            'returnAmount' => $returnAmounts ?? 0,
            'voidAmount' => $voidAmounts ?? 0,
            'totalDeductions' => $totalDeductions ?? 0,
            'vatSenior' => $vatSenior ?? 0,
            'vatPwd' => $vatPwd ?? 0,
            'vatExempt' => $vatExemptSales ?? 0,
            'vatOthers' => $vatOthers ?? 0,
            'vatReturns' => $vatReturns ?? 0,
            'totalVatAdjustment' => $totalVatAdjustment ?? 0,
            'vatPayable' => $vatPayable ?? 0,
            'netSales' => $netSales ?? 0,
            'salesOverflow' => $salesOverflow ?? 0,
            'totalIncome' => $totalIncome ?? 0,
            'zCounter' => $zCounter ?? 0,
            'remarks' => $remarks,
            'joinedResult' => $result  // Add the query result
        ];
    }



    public function getSeniorCitizenReport($startDate = null, $endDate = null)
    {
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');
        $this->db->select('
            discouned_customers.name, 
            discouned_customers.tin_id, 
            discouned_customers.id_number, 
            transactions.ornumber, 
            transactions.vat_exempt,
            transactions.vat,
            transactions.discount,
            transactions.earned_amount,
            transactions.paid_time
        ');
        $this->db->from('discouned_customers');
        $this->db->join('transactions', 'transactions.id = discouned_customers.transact_id');
        $this->db->where('discouned_customers.discount_type', 'senior');
        $this->db->where("transactions.paid_time >=", $startTimestamp);
        $this->db->where("transactions.paid_time <=", $endTimestamp);
        $query = $this->db->get();



        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function getPwdReport($startDate = null, $endDate = null)
    {
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');
        $this->db->select('
            discouned_customers.name, 
            discouned_customers.tin_id, 
            discouned_customers.id_number, 
            transactions.ornumber, 
            transactions.vat_exempt,
            transactions.vat,
            transactions.discount,
            transactions.earned_amount,
            transactions.paid_time
        ');
        $this->db->from('discouned_customers');
        $this->db->join('transactions', 'transactions.id = discouned_customers.transact_id');
        $this->db->where('discouned_customers.discount_type', 'pwd');
        $this->db->where("transactions.paid_time >=", $startTimestamp);
        $this->db->where("transactions.paid_time <=", $endTimestamp);
        $query = $this->db->get();



        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    public function getNaacReport($startDate = null, $endDate = null)
    {
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');
        $this->db->select('
            discouned_customers.name, 
            discouned_customers.id_number, 
            transactions.ornumber, 
            transactions.amount,
            transactions.discount,
            transactions.earned_amount,
            transactions.paid_time,
        ');
        $this->db->from('discouned_customers');
        $this->db->join('transactions', 'transactions.id = discouned_customers.transact_id');
        $this->db->where('discouned_customers.discount_type', 'naac');
        $this->db->where("transactions.paid_time >=", $startTimestamp);
        $this->db->where("transactions.paid_time <=", $endTimestamp);
        $query = $this->db->get();



        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }
    public function getSoloParentReport($startDate = null, $endDate = null)
    {
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $endTimestamp = strtotime($endDate . ' 23:59:59');
        $this->db->select('
            discouned_customers.name, 
            discouned_customers.id_number, 
            discouned_customers.child_name,
            discouned_customers.child_dob,  
            transactions.ornumber,
            transactions.amount, 
            transactions.amount,
            transactions.discount,
            transactions.earned_amount,
            transactions.paid_time
        ');
        $this->db->from('discouned_customers');
        $this->db->join('transactions', 'transactions.id = discouned_customers.transact_id');
        $this->db->where('discouned_customers.discount_type', 'sp');
        $this->db->where("transactions.paid_time >=", $startTimestamp);
        $this->db->where("transactions.paid_time <=", $endTimestamp);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            foreach ($result as &$row) {
                $childDob = $row['child_dob'];

                if (!empty($childDob)) {
                    $dob = new DateTime($childDob);
                    $today = new DateTime();
                    $age = $dob->diff($today)->y;

                    $row['child_age'] = $age;
                } else {
                    $row['child_age'] = null;
                }
            }

            return $result;
        } else {
            return [];
        }
    }


















}