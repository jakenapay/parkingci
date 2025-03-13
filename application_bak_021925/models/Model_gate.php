<?php 

class Model_Gate extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getGateData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM Gate WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM Gate";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getGateLog() 
	{
		$sql = "SELECT * FROM device_log WHERE 1  ORDER BY `device_log`.`id` DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = '')
	{
		$create = $this->db->insert('Gate', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('Gate', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('Gate');
		return ($delete == true) ? true : false;
	}

}
