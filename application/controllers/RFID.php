<?php

defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH.'libraries/fpdf/fpdf.php');

class RFID extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'RFID';
		$this->load->model('model_rfid');
	}


	public function index()
	{
		
		$this->data['rfid_active'] =$this->model_rfid->getrfidactive();
		$this->data['rfid_inactive'] =$this->model_rfid->getrfiddisable();
		$this->render_template('rfid/index', $this->data);
	}

	public function create()
	{
		$this->data['rfid_inactive'] =$this->model_rfid->getrfiddisable();
		
		$this->form_validation->set_rules('rfid', 'rfid name', 'required');
		$this->form_validation->set_rules('plate', 'plate', 'required');

		if ($this->form_validation->run() == TRUE) {
			$data = array(
				'RFindex' => $this->input->post('RFindex'),
				'RFID' => $this->input->post('rfid'),
				'platenumber' => $this->input->post('plate'),
				'owner' => $this->input->post('owner'),
				'model' => $this->input->post('model'),
				//'payment' => $this->input->post('payment'),
				'status' =>1
			);
			$create = $this->model_rfid->create($data);
			if ($create == true) {
				$this->session->set_flashdata('success', 'Successfully created');
				redirect('RFID/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('RFID/create', 'refresh');
			}
		} else {			
			$this->render_template('rfid/create', $this->data);
		}
	}

	public function edit($id = null)
	{
		if ($id) {
			$this->form_validation->set_rules('rfid', 'rfid name', 'required');
			$this->form_validation->set_rules('plate', 'plate', 'required');

			if ($this->form_validation->run() == TRUE) {				
				$data = array(
					'RFindex' => $this->input->post('slot_name'),
					'RFID' => $this->input->post('rfid'),
					'platenumber' => $this->input->post('plate'),
					'owner' => $this->input->post('owner'),
					'model' => $this->input->post('model'),
					//'payment' => $this->input->post('payment'),
					'status' =>1
				);
				
				$update = $this->model_rfid->edit($data, $id);
				if ($update == true) {
					$this->session->set_flashdata('success', 'Successfully updated');
					redirect('RFID/', 'refresh');
				} else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('RFID/edit/' . $id, 'refresh');
				}
			} else {
				// false case
				$rfid_data = $this->model_rfid->getrfidactive($id);
				$this->data['rfid_data'] = $rfid_data;
				$this->render_template('rfid/edit', $this->data);
			}
		}
	}

	public function delete($id = null)
	{
		
		if ($id) {
			if ($this->input->post('confirm')) {

				$delete = $this->model_rfid->delete($id);
				if ($delete == true) {
					$this->session->set_flashdata('success', 'Successfully removed');
					redirect('RFID/', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('RFID/delete/' . $id, 'refresh');
				}
				// }	
			} else {
				$this->data['id'] = $id;
				$this->render_template('rfid/delete', $this->data);
			}
		}
	}

	public function getRfidRecords(){
		$data = $this->model_rfid->getallregistered();
		print_r($data);
		$date = date('Y-m-d');
		$pdf = new FPDF('P', 'mm', 'A4');
		$pdf->AddPage();
	
		$pdf->SetFont('Arial', '', 10);
	
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, 'RFID Records', 0, 1, 'C');
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(0, 10, 'Date Generated:' . ' ' . $date , 0, 1, 'C');
		$pdf->Ln();
	
		$pdf->Cell(10);
	
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(20, 10, 'Index', 1);
		$pdf->Cell(30, 10, 'RFID', 1);
		$pdf->Cell(40, 10, 'Plate Number', 1);
		$pdf->Cell(40, 10, 'Owner', 1);
		$pdf->Cell(40, 10, 'Model', 1);
		$pdf->SetFont('Arial', '', 10);
		$pdf->Ln();
	
		foreach ($data as $row) {
			$pdf->Cell(10);
			$pdf->Cell(20, 10, $row['RFindex'], 1);
			$pdf->Cell(30, 10, $row['RFID'], 1);
			$pdf->Cell(40, 10, $row['platenumber'], 1);
			$pdf->Cell(40, 10, $row['owner'], 1);
			$pdf->Cell(40, 10, $row['model'], 1);
			$pdf->Ln();
		}
	
		$pdf->Output('D', 'RFID_Records.pdf');
	}
	
}
