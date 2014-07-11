<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schools_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_school_by_school_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('schools');
		return $query->result();
	}
	
	function school_exist_in_id($id, $school) {
		$this->db->where('id', $id);
		$this->db->where('school', $school);
		
		$count = $this->db->count_all_results('schools');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}