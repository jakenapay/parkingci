<?php
class Model_demo extends CI_Model {
    public function getBeginningSI() {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select("ornumber");
        $this->db->from("transactions");
        $this->db->where("paid_time >=", $startOfDay);
        $this->db->where("paid_time <=", $endOfDay);
        $this->db->order_by('paid_time', 'ASC');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }

    public function getEndingSI() {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

        $this->db->select("ornumber");
        $this->db->from("transactions");
        $this->db->where("paid_time >=", $startOfDay);
        $this->db->where("paid_time <=", $endOfDay);
        $this->db->order_by('paid_time', 'DESC');
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }

    public function getOpeningFund($terminalId){
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;

		$this->db->select('*');
		$this->db->from('cash_drawer');
		$this->db->where('terminal_id', $terminalId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
		$queryCheck = $this->db->get();


		if($queryCheck->num_rows() > 0){
			return $queryCheck->row_array();
		}else{
			return false;
		}
    }

    public function getDailySales() {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        $this->db->select_sum('amount', 'total_sales');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1);
        $query = $this->db->get();
    
        return ($query->num_rows() > 0) ? $query->row()->total_sales : 0.00;
    }

    public function getVoidCounts() {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 2);
        $query = $this->db->get();
    
        return $query->num_rows();
    }

    public function getVoidSales() {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        $totalVoidSales = 0;
    
        $this->db->select('vehicle_cat_id, COUNT(*) as void_count');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 2);
        $this->db->group_by('vehicle_cat_id');
        $voidTransactionsQuery = $this->db->get();
    
        if ($voidTransactionsQuery->num_rows() > 0) {
            foreach ($voidTransactionsQuery->result() as $voidTransaction) {
                $vehicleCatId = $voidTransaction->vehicle_cat_id;
                $voidCount = $voidTransaction->void_count;
    
                $this->db->select('total');
                $this->db->from('rate');
                $this->db->where('vechile_cat_id', $vehicleCatId);
                $rateQuery = $this->db->get();
    
                if ($rateQuery->num_rows() > 0) {
                    $rate = $rateQuery->row()->total;
    
                    $totalVoidSales += $voidCount * $rate;
                }
            }
        }
    
        return $totalVoidSales;
    }
    public function getCashierList(){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where('position', 5);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    public function getTerminalList(){
        $this->db->select("*");
        $this->db->from("ptu");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
    

    public function getXreadingData($date, $cashierId, $terminalId){
        $startOfDay = strtotime('today midnight');
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
        $drawerQuery  = $this->db->get();

        $this->db->reset_query();
        $this->db->select("remaining");
        $this->db->from("cash_drawer");
        $this->db->where("terminal_id", $terminalId);
        $this->db->where("cashier_id", $cashierId);
        $this->db->where('start_time >=', $startOfDay);
        $this->db->where('start_time <=', $endOfDay);
        $drawerQueryRemaining  = $this->db->get();
    
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : 0;
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : 0;
        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
        $remainingFund = $drawerQueryRemaining->num_rows() > 0 ? $drawerQueryRemaining->row()->remaining : 0;
        $this->db->reset_query();
        $this->db->select('paymode, SUM(amount) as total');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $this->db->group_by('paymode');
        $paymentQuery = $this->db->get();
    
        $paymentsReceived = [
            'Cash' => 0.00,
            'Gcash' => 0.00,
            'Paymaya' => 0.00,
        ];
    
        foreach ($paymentQuery->result() as $row) {
            $paymentsReceived[$row->paymode] = $row->total;
        }
        $totalPayments = $paymentsReceived['Cash'] + $paymentsReceived['Gcash'] + $paymentsReceived['Paymaya'];


        $totalVoidSales = 0;
        $this->db->reset_query();
        $this->db->select('vehicle_cat_id, COUNT(*) as void_count');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 2); // Only void transactions
        $this->db->group_by('vehicle_cat_id');
        $voidTransactionsQuery = $this->db->get();

        if ($voidTransactionsQuery->num_rows() > 0) {
            foreach ($voidTransactionsQuery->result() as $voidTransaction) {
                $vehicleCatId = $voidTransaction->vehicle_cat_id;
                $voidCount = $voidTransaction->void_count;

                $this->db->reset_query();
                $this->db->select('total');
                $this->db->from('rate');
                $this->db->where('vechile_cat_id', $vehicleCatId);
                $rateQuery = $this->db->get();

                if ($rateQuery->num_rows() > 0) {
                    $rate = $rateQuery->row()->total;
                    $totalVoidSales += $voidCount * $rate;
                }
            }
        }
        return [
            'first_ornumber' => $firstOrnumber,
            'last_ornumber' => $lastOrnumber,
            'opening_fund' => $openingFund,
            'Cash' => $paymentsReceived['Cash'],
            'Gcash' => $paymentsReceived['Gcash'],
            'Paymaya' => $paymentsReceived['Paymaya'],
            'totalPaymentsReceived' =>  $totalPayments,
            'totalVoidSales' => $totalVoidSales,
            'cashInDrawer'  => $remainingFund,
        ];
    }

    public function getZreadingData($dateStart, $dateEnd, $cashierId, $terminalId) {
        $startOfDay = strtotime('today midnight');
        $endOfDay = strtotime('tomorrow midnight') - 1;
    
        // Current day transactions
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
    
        // Current day cash drawer data
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
        $drawerQueryRemaining = $this->db->get();
    
        $firstOrnumber = $firstQuery->num_rows() > 0 ? $firstQuery->row()->ornumber : 0;
        $lastOrnumber = $lastQuery->num_rows() > 0 ? $lastQuery->row()->ornumber : 0;
        $openingFund = $drawerQuery->num_rows() > 0 ? $drawerQuery->row()->opening_fund : 0;
        $remainingFund = $drawerQueryRemaining->num_rows() > 0 ? $drawerQueryRemaining->row()->remaining : 0;
    
        // Current day payments received
        $this->db->reset_query();
        $this->db->select('paymode, SUM(amount) as total');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $this->db->group_by('paymode');
        $paymentQuery = $this->db->get();
    
        $paymentsReceived = [
            'Cash' => 0.00,
            'Gcash' => 0.00,
            'Paymaya' => 0.00,
        ];
    
        foreach ($paymentQuery->result() as $row) {
            $paymentsReceived[$row->paymode] = $row->total;
        }
        $totalPayments = $paymentsReceived['Cash'] + $paymentsReceived['Gcash'] + $paymentsReceived['Paymaya'];
    
        // Calculate Total Void Sales
        $totalVoidSales = 0;
        $this->db->reset_query();
        $this->db->select('vehicle_cat_id, COUNT(*) as void_count');
        $this->db->from('transactions');
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 2); // Only void transactions
        $this->db->group_by('vehicle_cat_id');
        $voidTransactionsQuery = $this->db->get();
    
        if ($voidTransactionsQuery->num_rows() > 0) {
            foreach ($voidTransactionsQuery->result() as $voidTransaction) {
                $vehicleCatId = $voidTransaction->vehicle_cat_id;
                $voidCount = $voidTransaction->void_count;
    
                $this->db->reset_query();
                $this->db->select('total');
                $this->db->from('rate');
                $this->db->where('vechile_cat_id', $vehicleCatId);
                $rateQuery = $this->db->get();
    
                if ($rateQuery->num_rows() > 0) {
                    $rate = $rateQuery->row()->total;
                    $totalVoidSales += $voidCount * $rate;
                }
            }
        }
    
        // Calculate Present Accumulated Sales
        $this->db->reset_query();
        $this->db->select_sum('amount', 'accumulated_sales');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $accumulatedSalesQuery = $this->db->get();
        $accumulatedSales = $accumulatedSalesQuery->row()->accumulated_sales ?? 0.00;
    
        // Calculate Previous Accumulated Sales (1 day before)
        $previousStartOfDay = strtotime('-1 day', $startOfDay);
        $previousEndOfDay = strtotime('-1 second', $startOfDay);
    
        $this->db->reset_query();
        $this->db->select_sum('amount', 'previous_accumulated_sales');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $previousStartOfDay);
        $this->db->where('paid_time <=', $previousEndOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $previousAccumulatedSalesQuery = $this->db->get();
        $previousAccumulatedSales = $previousAccumulatedSalesQuery->row()->previous_accumulated_sales ?? 0.00;
    
        $this->db->reset_query();
        $this->db->select_sum('vatable_sales', 'vatable_sales');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $vatableSalesQuery = $this->db->get();
        $vatableSales = $vatableSalesQuery->row()->vatable_sales ?? 0.00;

        $this->db->reset_query();
        $this->db->select_sum('vat', 'total_vat'); // Assuming the column name is 'vat'
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $vatAmountQuery = $this->db->get();
        $totalVatAmount = number_format($vatAmountQuery->row()->total_vat ?? 0.00, 2, '.', ''); // This will format to 0.00 or the actual VAT amount with two decimal places

        $this->db->reset_query();
        $this->db->select_sum('amount', 'gross_amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $grossAmountQuery = $this->db->get();
        $grossAmount = number_format($grossAmountQuery->row()->gross_amount ?? 0.00, 2, '.', ''); // Format the gross amount

        $this->db->reset_query();
        $this->db->select('vehicle_cat_id, SUM(amount) as total_amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $this->db->group_by('vehicle_cat_id');
        $discountsQuery = $this->db->get();
    
        $totalDiscount = 0.00;
    
        foreach ($discountsQuery->result() as $discountRow) {
            $vehicleCatId = $discountRow->vehicle_cat_id;
            $totalAmount = $discountRow->total_amount;
    
            // Get the total rate based on vehicle category
            $this->db->reset_query();
            $this->db->select('total');
            $this->db->from('rate');
            $this->db->where('vechile_cat_id', $vehicleCatId);
            $rateQuery = $this->db->get();
    
            if ($rateQuery->num_rows() > 0) {
                $rate = $rateQuery->row()->total;
    
                // Determine applicable discount
                if ($vehicleCatId == '1') { // Assuming '1' is the id for Cars
                    // If senior_pwd discount applies
                    $totalDiscount += $totalAmount * 0.20; // Example: 20% discount for senior_pwd
                } elseif ($vehicleCatId == '2') { // Assuming '2' is the id for Motorcycles
                    // If tenants discount applies
                    $totalDiscount += $totalAmount * 0.15; // Example: 15% discount for tenants
                    // If senior_pwd discount applies
                    $totalDiscount += $totalAmount * 0.10; // Example: 10% discount for senior_pwd
                }
            }
        }

        $this->db->reset_query();
        $this->db->select('discount, vehicle_cat_id, SUM(amount) as total_amount');
        $this->db->from('transactions');
        $this->db->where('cashier_id', $cashierId);
        $this->db->where('pid', $terminalId);
        $this->db->where('paid_time >=', $startOfDay);
        $this->db->where('paid_time <=', $endOfDay);
        $this->db->where('status', 1); // Only paid transactions
        $this->db->group_by(['discount', 'vehicle_cat_id']);
        $discountsQuery = $this->db->get();
    
        $totalDiscount = 0.00;
        $discountRates = [
            'car_tenant' => 0,
            'mot_tenant' => 0,
            'car_senior_pwd' => 0,
            'mot_senior_pwd' => 0
        ];

        $this->db->reset_query();
    $this->db->select('discount, vehicle_cat_id, SUM(amount) as total_amount');
    $this->db->from('transactions');
    $this->db->where('cashier_id', $cashierId);
    $this->db->where('pid', $terminalId);
    $this->db->where('paid_time >=', $startOfDay);
    $this->db->where('paid_time <=', $endOfDay);
    $this->db->where('status', 1); // Only paid transactions
    $this->db->group_by(['discount', 'vehicle_cat_id']);
    $discountsQuery = $this->db->get();

    $totalDiscount = 0.00;
    $discountRates = [
        'car_tenant' => 0,
        'mot_tenant' => 0,
        'car_senior_pwd' => 0,
        'mot_senior_pwd' => 0
    ];

    // Retrieve discount rates from rate table and set them
    $this->db->reset_query();
    $this->db->select('total, rate_name');
    $this->db->from('rate');
    $rateQuery = $this->db->get();

    foreach ($rateQuery->result() as $rateRow) {
        if (isset($discountRates[$rateRow->rate_name])) {
            $discountRates[$rateRow->rate_name] = $rateRow->total;
        }
    }

    foreach ($discountsQuery->result() as $discountRow) {
        $vehicleCatId = $discountRow->vehicle_cat_id;
        $totalAmount = $discountRow->total_amount;
        $discountType = strtolower($discountRow->discount); // Normalize case to avoid mismatches

        if ($vehicleCatId == 1) { // Assuming '1' is Car
            if ($discountType == 'tenant') {
                $totalDiscount += $totalAmount * ($discountRates['car_tenant'] / 100);
            } elseif ($discountType == 'spwd') {
                $totalDiscount += $totalAmount * ($discountRates['car_senior_pwd'] / 100);
            }
        } elseif ($vehicleCatId == 2) { // Assuming '2' is Motorcycle
            if ($discountType == 'tenant') {
                $totalDiscount += $totalAmount * ($discountRates['mot_tenant'] / 100);
            } elseif ($discountType == 'spwd') {
                $totalDiscount += $totalAmount * ($discountRates['mot_senior_pwd'] / 100);
            }
        }
    }

        // Calculate Short/Over
        $expectedCash = $openingFund + $paymentsReceived['Cash'];
        $shortOver = $remainingFund - $expectedCash;



        return [
            'first_ornumber' => $firstOrnumber,
            'last_ornumber' => $lastOrnumber,
            'opening_fund' => $openingFund,
            'Cash' => $paymentsReceived['Cash'],
            'Gcash' => $paymentsReceived['Gcash'],
            'Paymaya' => $paymentsReceived['Paymaya'],
            'totalPaymentsReceived' => $totalPayments,
            'totalVoidSales' => $totalVoidSales,
            'cashInDrawer' => $remainingFund,
            'presentAccumulatedSales' => $accumulatedSales,
            'previousAccumulatedSales' => $previousAccumulatedSales,
            'vatable_sales' => $vatableSales,
            'totalVatAmount' => $totalVatAmount,
            'gross_amount' => $grossAmount,
            'lessDiscount' => $totalDiscount,
            'tenantDiscount' => 0,
            'seniorPwd' => 0,
            'shortOver' => number_format($shortOver, 2, '.', '')
        ];
    }
    
    
    
    
}
