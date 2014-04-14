<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_courses_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_school_courses_by_school_id($id) {
		$this->db->where('school_id', $id);
		$query = $this->db->get('school_courses');
		return $query->result();
	}
	
}