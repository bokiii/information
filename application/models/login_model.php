<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}    
	
	function is_valid_account($username, $password) {
		$this->db->where("username", $username);
		$this->db->where("password", md5($password));
		$query = $this->db->get("students");
		
		if($query->result() != NULL) {
			return true;
		} else {
			return false;
		} 
	}

	
}