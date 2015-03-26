<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function debug($debug) {
		echo "<pre>";
			print_r($debug);
		echo "</pre>";
	}
	
	function __construct() {
		parent::__construct();
		
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
		
			$this->session->set_flashdata("error", "Invalid username or password");
			redirect("login");
		}
	}
	
	
}












