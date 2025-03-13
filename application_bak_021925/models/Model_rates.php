<?php 

class Model_rates extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getRateData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM rate WHERE id = ? ORDER BY id ASC";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM rate";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getRateRegular($vechile_cat_id = null) 
	{
		if($vechile_cat_id==1) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'mot regular'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		else if($vechile_cat_id==2) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'cars regular'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		elseif($vechile_cat_id==3) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'BUS/truck'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		else{
			
			return Null;
		}
	}
	public function getRateDiscount($vechile_cat_id = null) 
	{
		if($vechile_cat_id==1) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'mot tenants'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		else if($vechile_cat_id==2) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'cars senior_pwd'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		elseif($vechile_cat_id==3) {
			$sql = "SELECT * FROM rate WHERE rate_name = 'BUS/truck'";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		else{
			
			return Null;
		}
	}

	public function create($data = '')
	{
		$create = $this->db->insert('rate', $data);
		return ($create == true) ? true : false;
	}

	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('rate', $data);
		return ($update == true) ? true : false;	
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('rate');
		return ($delete == true) ? true : false;
	}

	public function getCategoryRate($id)
	{
	 	$sql = "SELECT * FROM rate WHERE vechile_cat_id = ? AND active = ?";
	 	$query = $this->db->query($sql, array($id, 1));
	 	return $query->result_array();
	}

	public function countTotalRates() {
		$sql = "SELECT * FROM rate";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}