<?php

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';

		$this->load->model('model_slots');
		$this->load->model('model_users');
		$this->load->model('model_parking');
		$this->load->model('model_rates');
		$this->load->model('model_category');
		$this->load->model('model_slots');
		$this->load->model('model_company');
		$this->load->model('model_gate');
	}

	public function index()
	{
		$parking_data = $this->model_parking->getParkingData();
		$result = array();
		foreach ($parking_data as $k => $v) {
			$result[$k]['parking'] = $v;
			$category_data = $this->model_category->getCategoryData($v['vechile_cat_id']);
			$slot_data = $this->model_slots->getSlotData($v['slot_id']);
			$rate_data = $this->model_rates->getRateData($v['rate_id']);

			$result[$k]['category'] = $category_data;
			$result[$k]['slot'] = $slot_data;
			$result[$k]['rate'] = $rate_data;
		}	
		$this->data['company_currency'] = $this->company_currency();
		$this->data['parking_data'] = $result;		
		$this->data['total_slots'] = $this->model_slots->countTotalSlots();	
		$this->data['total_availableslots'] = $this->model_slots->countTotalAvailableSlots();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_parking'] = $this->model_slots->getSlotData();	
		/* $this->data['total_parking'] = $this->model_parking->countTotalParking();*/
		$this->data['total_earning'] = $this->model_parking->countTotalEarning();
		$this->data['total_rates'] = $this->model_rates->countTotalRates();
		$this->data['total_unpaid'] = $this->model_parking->countTotalUnpaid();
		// $this->data['parking_data'] = $this->model_parking->getParkingData();

		$this->data['user_id'] = $this->session->userdata('id');
		// print_r($this->data['user_id']);
		$this->data['gate'][0]['name'] = 'Gate 1';
		$this->data['gate'][1]['name'] = 'Gate 2';
		$this->data['gate'][2]['name'] = 'Gate 3';
		$this->data['gate'][3]['name'] = 'Gate 4';
		$gate_data = $this->model_gate->getGateData();
		$this->data['gate'][0]['status'] = 'Entry  '.$gate_data[0]['direction'];
		$this->data['gate'][1]['status'] = 'Entry  '.$gate_data[1]['direction'].' / '.'Exit '.$gate_data[3]['direction'];
		$this->data['gate'][2]['status'] = 'Entry  '.$gate_data[5]['direction'].' / '.'Exit '.$gate_data[6]['direction'];
		$this->data['gate'][3]['status'] = 'Entry  '.$gate_data[7]['direction'].' / '.'Exit '.$gate_data[8]['direction'];
		
		

		$this->render_template('dashboard', $this->data);
	}
}
