<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_subjects_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_course_subjects_by_course_id($id) {
		$this->db->where('course_id', $id);
		$query = $this->db->get('course_subjects');
		return $query->result();
	}
	
	function get_course_id_id_by_subject_id($subject_id) {
		$this->db->where('subject_id', $subject_id);
		$query = $this->db->get('course_subjects');
		return $query->result();
	}
	
	function count_course_subject_by_subject_id($subject_id) {
		$this->db->where('subject_id', $subject_id);
		$count = $this->db->count_all_results('course_subjects');
		return $count;
	}
	
	function count_course_subject_by_subject_id_and_course_id($subject_id, $course_id) {
		$this->db->where('subject_id', $subject_id);
		$this->db->where('course_id', $course_id);
		$count = $this->db->count_all_results('course_subjects');
		return $count;
	}

}




