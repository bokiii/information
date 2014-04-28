<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_teachers_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_subject_teachers_by_subject_id($id) {
		$this->db->where('subject_id', $id);
		$query = $this->db->get('subject_teachers');
		return $query->result();
	}
	
	function get_subject_id_by_teacher_id($teacher_id) {
		$this->db->where('teacher_id', $teacher_id);
		$query = $this->db->get('subject_teachers');
		return $query->result();
	}
	
	function count_subject_teacher_by_teacher_id($teacher_id) {
		$this->db->where('teacher_id', $teacher_id);
		$count = $this->db->count_all_results('subject_teachers');
		return $count;
	}
	
	function count_subject_teacher_by_teacher_id_and_subject_id($teacher_id, $subject_id) {
		$this->db->where('teacher_id', $teacher_id);
		$this->db->where('subject_id', $subject_id);
		$count = $this->db->count_all_results('subject_teachers');
		return $count;
	}
	
	
	
}









