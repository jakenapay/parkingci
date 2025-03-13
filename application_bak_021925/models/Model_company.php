<?php 

class Model_company extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCompanyData($id)
	{
		if($id) {
			$sql = "SELECT * FROM company WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();	
		}
	}

	public function getCompanyInfo($companyId){
		$this->db->select('*');
		$this->db->where('id', $companyId);
		$this->db->from('company');
		$queryCompany = $this->db->get();

		if($queryCompany->num_rows() > 0){
			return $queryCompany->row_array();
		}else{
			return false;
		}
	}


	public function edit($data, $id)
	{
		$this->db->where('id', $id);
		$update = $this->db->update('company', $data);
		return ($update == true) ? true: false;
	}
}