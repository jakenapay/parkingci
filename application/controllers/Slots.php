<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slots extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Slots';
		$this->load->model('model_slots');
	}


	public function index()
	{

		if (!in_array('viewSlots', $this->permission)) {
			redirect('dashboard', 'refresh');
		}


		$slot_data = $this->model_slots->getSlotData();
		$this->data['slot_data'] = $slot_data;


		$this->render_template('slots/index', $this->data);
	}

	public function create()
	{

		if (!in_array('createSlots', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('slot_name', 'Slot name', 'required');
		$this->form_validation->set_rules('slot_no', 'Number of slots', 'required');
		$this->form_validation->set_rules('slot_occ', 'Occupied slots', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == TRUE) {

			$num_slots = $this->input->post('slot_no');
			$occupied_slots = $this->input->post('slot_occ');

			// Subtract occupied slots from the total slots
			$available_slots = $occupied_slots - $num_slots;
			// true case
			$data = array(
				'slot_name' => $this->input->post('slot_name'),
				'num_slot' => $num_slots,
				'occupied' => $occupied_slots,
				'vacant' => $available_slots,
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
			$this->render_template('slots/create', $this->data);
		}
	}

	public function edit($id = null)
	{
		if (!in_array('updateSlots', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		if ($id) {
			$this->form_validation->set_rules('slot_name', 'Slot name', 'required');
			$this->form_validation->set_rules('slot_no', 'slot_no', 'required');
			$this->form_validation->set_rules('slot_occ', 'slot_occ', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() == TRUE) {
				$num_slots = $this->input->post('slot_no');
				$occupied_slots = $this->input->post('slot_occ');

				$available_slots = $num_slots - $occupied_slots;

				// true case
				$data = array(
					'slot_name' => $this->input->post('slot_name'),
					'num_slot' => $num_slots,
					'occupied' => $occupied_slots,
					'vacant' => $available_slots,
					'active' => $this->input->post('status'),
					'availability_status' => 1
				);

				$update = $this->model_slots->edit($data, $id);
				if ($update == true) {
					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('slots/', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('slots/edit/' . $id, 'refresh');
				}
			} else {
				// false case
				$slot_data = $this->model_slots->getSlotData($id);
				$this->data['slot_data'] = $slot_data;
				$this->render_template('slots/edit', $this->data);
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
