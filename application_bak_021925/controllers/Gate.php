<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gate extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Gate';
		$this->load->model('model_gate');
	}


	public function index()
	{
		
		$gate_data = $this->model_gate->getGateData();
		$this->data['gate_data'] = $gate_data;
		$this->render_template('gates/index', $this->data);
	}

	public function devicelog()
	{
		
		$gate_data = $this->model_gate->getGateLog();
		$this->data['device_log'] = $gate_data;
		$this->render_template('gates/logview', $this->data);
	}


	public function create()
	{

		$this->form_validation->set_rules('slot_name', 'Slot name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$data = array(
				'slot_name' => $this->input->post('slot_name'),
				'active' => $this->input->post('status'),
				'availability_status' => 1
			);

			$create = $this->model_slots->create($data);
			if ($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
				redirect('slots/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('slots/create', 'refresh');
			}
		} else {
			$this->render_template('gates/create', $this->data);
		}
	}

	public function edit($id = null)
	{
		if ($id) {
			$this->form_validation->set_rules('gate_name', 'Gate name', 'required');
			$this->form_validation->set_rules('address', 'address', 'required');

			if ($this->form_validation->run() == TRUE) {				
				$data = array(
					'GateName' => $this->input->post('gate_name'),
					'address' => $this->input->post('address'),
					'direction' => $this->input->post('direction')					
				);
				
				$update = $this->model_gate->edit($data, $id);
				if ($update == true) {
					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('Gate/', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('Gate/edit/' . $id, 'refresh');
				}
			} else {
				// false case
				$gate_data = $this->model_gate->getGateData($id);
				$this->data['gate_data'] = $gate_data;
				$this->render_template('gates/edit', $this->data);
			}
		}
	}

	public function delete($id = null)
	{
		if (!in_array('deleteSlots', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			if ($this->input->post('confirm')) {

				// $check = $this->model_groups->existInUserGroup($id);
				// if($check == true) {
				// 	$this->session->set_flashdata('error', 'Group exists in the users');
				//      		redirect('category/', 'refresh');
				// }
				// else {
				$delete = $this->model_slots->delete($id);
				if ($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('slots/', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('slots/delete/' . $id, 'refresh');
				}
				// }	
			} else {
				$this->data['id'] = $id;
				$this->render_template('slots/delete', $this->data);
			}
		}
	}
}
