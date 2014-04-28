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
	
	function get_school_id_by_course_id($course_id) {
		$this->db->where('course_id', $course_id);
		$query = $this->db->get('school_courses');
		return $query->result();
	}
	
	function count_school_course_by_course_id($course_id) {
		$this->db->where('course_id', $course_id);
		$count = $this->db->count_all_results('school_courses');
		return $count;
	}
	
	function count_school_course_by_course_id_and_school_id($course_id, $school_id) {
		$this->db->where('course_id', $course_id);
		$this->db->where('school_id', $school_id);
		$count = $this->db->count_all_results('school_courses');
		return $count;
	}
	

}


