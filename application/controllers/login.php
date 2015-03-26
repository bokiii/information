<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function debug($debug) {
		echo "<pre>";
			print_r($debug);
		echo "</pre>";
	}
	
	function __construct() {
		parent::__construct();
		$this->load->model("login_model");
		$this->load->model("students_model");
		
		if($this->session->userdata('allowed') == true) {
			redirect("students");
		}    
		
	}
	
	function index() {
		$this->load->view('login_view');
	}
	
	function process_login() {

		$username = $this->input->post("username");
		$password = $this->input->post("password");
		
		if($username == "admin" && $password == "information@*05") {
			
			$this->session->set_userdata("allowed", true);
			redirect("students");
	
		} else {
		
			$is_valid_account = $this->login_model->is_valid_account($username, $password);
			
			if($is_valid_account) {
				
				$get_student_id = $this->students_model->get_student_id_by_username_and_password($username, $password);                                                                                
				foreach($get_student_id as $row) {
					$student_id = $row->id;
				}
				
				$this->session->set_userdata("student_access_allowed", true);
				$this->session->set_userdata("student_id", $student_id);
				
				redirect("students_access");
			
			} else {
				$this->session->set_flashdata("error", "Invalid username or password");
				redirect("login");
			}
	
		}
	}
	
	
}












