<!--  
   Summary report 
   Total Income report
    1. this year total amount and monthly income 
   Total statistical report (daily ,weekly,monthly)
   Transaction Report 
   Parking Load report 
   Lenth of Stay report 
-->
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Parking Report';
		$this->load->model('model_report');
	}

	// public function index()
	// {
	// 	$annual_parking = $this->model_report->getAnnualParking();
	// 	echo json_encode($annual_parking);
	// 	$this->data['annual_park'] = $annual_parking;
	// 	$this->render_template('reports/nincome', $this->data);
	// }
	
	
	public function index()
	{

		
		$today_year = date('Y');
		if ($this->input->post('select_year')) {
			if($this->input->post('select_month')){
				$today_month = $this->input->post('select_month');				
				$parking_data = $this->model_report->getEarningMonth($today_year,$today_month +1);		
				$this->data['report_years'] = $this->model_report->getParkingYear();		
				$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');		
				$this->data['selected_year'] = $today_year;		
				$this->data['selected_month'] = $today_month;		
				$this->data['company_currency'] = $this->company_currency();
				$this->data['parking_data'] = $parking_data;			
				$this->render_template('reports/income_daily', $this->data);
	
			}
			else{				
				$parking_data = $this->model_report->getEarningData($today_year);
				$today_month = 0;
			}
		}
		else{
			$parking_data = $this->model_report->getEarningData($today_year);
			$today_month = 0;
			$this->data['report_years'] = $this->model_report->getParkingYear();		
			$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');		
			$this->data['selected_year'] = $today_year;		
			$this->data['selected_month'] = $today_month;		
			$this->data['company_currency'] = $this->company_currency();
			$this->data['parking_data'] = $parking_data;		
			$this->render_template('reports/income', $this->data);
		}
		// echo ($today_month.'-'.$today_year); 
		
	}
	public function statistical()
	{
		$today_year = date('Y');
		if ($this->input->post('select_year')){
			 $today_year =$this->input->post('select_year');			 
		}
		$this->data['report_years'] = $this->model_report->getParkingYear();		
		$parking_data = $this->model_report->getParkingData($today_year);
		$parking_entry=	$this->model_report->getEntrygData($today_year);
		
		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			if (count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if ($v2) {
						$total_amount_earned[] = $v2['earned_amount'];
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);
			} else {
				$final_parking_data[$k] = 0;
			}
		}
		$this->data['selected_year'] = $today_year;
		$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');	
		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $final_parking_data;
		$this->render_template('reports/statistical', $this->data);		
	}
	public function Transaction()
	{

		$today_year = date('Y');
		if ($this->input->post('select_year')) {
			if($this->input->post('select_month')){
				$today_month = $this->input->post('select_month');				
				$parking_data = $this->model_report->getEntrygMonth($today_year,$today_month +1);	
				$this->data['report_years'] = $this->model_report->getParkingYear();
				$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');	
				$this->data['selected_year'] = $today_year;		
				$this->data['parking_data'] = $parking_data;
				$this->render_template('reports/Transaction_daily', $this->data);			
			}
			else{				
				$parking_data = $this->model_report->getEntrygData($today_year);
				$today_month = 0;
			}
		}
		else{
			$parking_data = $this->model_report->getEntrygData($today_year);
			$today_month = 0;
			// $parking_data = $this->model_report->getEntrygData($today_year);				
			$this->data['report_years'] = $this->model_report->getParkingYear();
			$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');	
			$this->data['selected_year'] = $today_year;		
			$this->data['parking_data'] = $parking_data;
			$this->render_template('reports/Transaction', $this->data);
		}
				
		
	}
	public function ParkingLoad()
	{
		$today_year = date('Y');

		if ($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_report->getParkingData($today_year);
		$this->data['report_years'] = $this->model_report->getParkingYear();

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			if (count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if ($v2) {
						$total_amount_earned[] = $v2['earned_amount'];
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);
			} else {
				$final_parking_data[$k] = 0;
			}
		}

		$this->data['selected_year'] = $today_year;
		$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');    
		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $final_parking_data;

		$this->render_template('reports/ParkingLoad', $this->data);
	}

	public function LenthofStay ()
	{
		$today_year = date('Y');
		if ($this->input->post('select_year')) {
			if($this->input->post('select_month')){
				$today_month = $this->input->post('select_month');				
				$parking_data = $this->model_report->getEntrygMonth($today_year,$today_month +1);				
			}
			else{				
				$parking_data = $this->model_report->getStayData($today_year);
				$today_month = 0;
			}
		}
		else{
			$parking_data = $this->model_report->getStayData($today_year);
			$today_month = 0;
		}
				
		// $parking_data = $this->model_report->getEntrygData($today_year);				
		$this->data['report_years'] = $this->model_report->getParkingYear();
		$this->data['report_months'] = array('January','February','March','April','May','June','July','August','September','October','November','December');	
		$this->data['selected_year'] = $today_year;		
		$this->data['parking_data'] = $parking_data;
		$this->render_template('reports/LenthofStay', $this->data);

	}
}
