<?php 

class Model_ptu extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getPtuData($Id = null) 
	{
		if($Id) {
			$sql = "SELECT * FROM ptu WHERE id = ?";
			$query = $this->db->query($sql, array($Id));
			return $query->row_array();
		}
		else {
			$sql = "SELECT * FROM ptu WHERE 1";
			$query = $this->db->query($sql, array(0));
			return $query->row_array();
		}
	}

	public function getAllPtuData() 
	{
		$sql = "SELECT * FROM ptu WHERE 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getOR() 
	{
		$sql = "SELECT ORNO FROM cashier_log WHERE 1 ORDER BY id DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		$row = $query->row_array();		 
		return $row['ORNO'];
	}
	public function getStartBalance() 
	{
		$sql = "SELECT start_balance FROM user_log WHERE 1 ORDER BY id DESC LIMIT 1 ";
		$query = $this->db->query($sql);
		$row = $query->row_array();		 
		return $row['ORNO'];
	}

	public function create($data = '')
	{
		$create = $this->db->insert('PTU', $data);
		return ($create == true) ? true : false;
	}


	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('PTU', $data);
		return ($update == true) ? true: false;
	}


	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('PTU');
		return ($delete == true) ? true : false;
	}
	public function getDeviceData($device_ip) 
	{
		$sql = "SELECT * FROM Gate WHERE address = ?";
		$query = $this->db->query($sql, array($device_ip));
		return $query->row_array();
	}	
	
	public function Event($data = '')
	{
		$create = $this->db->insert('device_log', $data);
		return ($create == true) ? true : false;
	}
	public function putcash($amount ='')
	{
		$create = $this->db->insert('cashbox', $data);
		return ($create == true) ? true : false;
	}
	
}
