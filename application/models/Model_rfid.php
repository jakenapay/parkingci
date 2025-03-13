<?php 

class Model_RFID extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getrfidactive($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM rfid_vehicle WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM rfid_vehicle where status = 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getrfiddisable() 
	{
		$sql = "SELECT RFindex ,RFID FROM rfid_vehicle where status = 0";		
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('rfid_vehicle', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('rfid_vehicle', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('rfid_vehicle');
		return ($delete == true) ? true : false;
	}

	public function getallregistered(){
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->from('rfid_vehicle');
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}
