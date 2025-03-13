<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();
		date_default_timezone_set("Asia/Manila");
		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));
           		if($login) {
					/* 
						echo("admin");
						redirect('Auth/login');						       
					} 
					*/      
					if($login['position']== 'cashier'){
						if(!empty($_POST["start_balance"])) {
							$balance =$this->input->post('start_balance');
						}
						else {
							$this->data['errors'] = 'Please input start balance';
           					$this->load->view('login', $this->data);
							return;
						}
					}				
					
           			$logged_in_sess = array(
           				'id' => $login['id'],
				        'username'  => $login['username'],
						'position'  => $login['position'],
				        'email'     => $login['email'],
						'fname'     => $login['firstname'],
						'lname'     => $login['lastname'],
						'start_balance' =>NULL, 
						'at_time'   => strtotime('now'),
				        'logged_in' => TRUE
					);
					 
					$data = array( 
						'userid' => $login['id'],
				        'username'  => $login['username'],
				        'email'     => $login['email'],
						'start_balance' =>NULL, 
						'log_status'     => 'login',
						'at_time'     => strtotime('now')
					);				
					
					if($login['position']== 'cashier'){
						$logged_in_sess['start_balance'] = $balance;
						$this->session->set_userdata($logged_in_sess);
						$data['start_balance'] = $balance;
						$this->db->insert('user_log', $data);
						redirect('cashier', 'refresh');
					}						
					else if($login['position']== 'ptu'){
						$this->session->set_userdata($logged_in_sess);
						$this->db->insert('user_log', $data);
						redirect('ptu', 'refresh');
					}						
					else{
						$this->session->set_userdata($logged_in_sess);
						$this->db->insert('user_log', $data);
						redirect('dashboard', 'refresh');
					} 	
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Email does not exists';
           		$this->load->view('login', $this->data);
           	}	
        }
        else {
			$this->load->view('login');
        }	
	}
	public function Devicelogin()
	{
	   	$login = $this->model_auth->login($this->input->get('email'), $this->input->get('password'));
        if($login) {
			$logged_in_sess = array(
				'id' => $login['id'],
				'username'  => $login['username'],
				'email'     => $login['email'],
				'logged_in' => TRUE
			) ;
			$this->session->set_userdata($logged_in_sess);
			echo("validation");
			$data = array( 
				'userid' => $login['id'],
				'username'  => $login['username'],
				'email'     => $login['email'],
				'log_status'     => 'login',
				'at_time'     => strtotime('now')
			);				
			$this->db->insert('user_log', $data);	
		}
		else {
			echo("error");
		}	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		date_default_timezone_set("Asia/Manila");
		if($this->session->userdata('username') != NULL){		
			$data = array( 
				'userid' => $this->session->userdata('id'),
				'username'  => $this->session->userdata('username'),
				'email'     => $this->session->userdata('email'),
				'log_status'     => 'logout',					
				'at_time'     => strtotime('now')
			);								
			$this->db->insert('user_log', $data);			
		}
		$this->session->unset_userdata(array("username"=>"","logged_in"=>False,"password"=>"","email"=>""));
		$this->session->sess_destroy();			
		redirect('auth/login', 'refresh');		
	}
	public function Devicelogout()
	{
		date_default_timezone_set("Asia/Manila");		
		$data = array( 
				'userid' => $this->session->userdata('id'),
				'username'  => $this->session->userdata('username'),
				'email'     => $this->session->userdata('email'),
				'log_status'  => 'logout',
				'at_time'     => strtotime('now')
		);				
		$this->db->insert('user_log', $data);			
		$this->session->unset_userdata(array("username"=>"","logged_in"=>False,"password"=>"","email"=>""));
		$this->session->sess_destroy();			
		echo("success");	
	}

	public function DeviceKeep()
	{			
		echo("alive");			
	}


}
