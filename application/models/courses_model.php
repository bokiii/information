<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_course_by_course_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('courses');
		return $query->result();
	}
	
	function course_exists_in_id($id, $course) {
		$this->db->where('id', $id);
		$this->db->where('course', $course);
		
		$count = $this->db->count_all_results('courses');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
		
	}
	
}





