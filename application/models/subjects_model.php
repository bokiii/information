<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	
	function get_subjects() {
		$this->db->select('*');
		$this->db->from('subjects');
		$this->db->join('terms', 'terms.id = subjects.term_id');
		$this->db->order_by('terms.order');
		$query = $this->db->get();
		return $query->result();
	
	}
	
	function get_subject_by_subject_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('subjects');
		return $query->result();
	} 
	
	function get_subject_by_subject_id_and_term_id($id, $term_id) {
		$this->db->where('id', $id);
		$this->db->where('term_id', $term_id);
		$query = $this->db->get('subjects');
		return $query->result();
	}
	
	function course_no_and_descriptive_title_exist_in_id($id, $course_no, $descriptive_title) {
		$this->db->where('id', $id);
		$this->db->where('course_no', $course_no);
		$this->db->where('descriptive_title', $descriptive_title);
		
		$count = $this->db->count_all_results('subjects');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function course_no_or_descriptive_title_exist_in_id($id, $course_no, $descriptive_title) {
		$this->db->where('id', $id);
		$this->db->where('course_no', $course_no);
		$this->db->or_where('descriptive_title', $descriptive_title);
		
		$count = $this->db->count_all_results('subjects');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function course_no_exist_in_id($id, $course_no) {
		$this->db->where('id', $id);
		$this->db->where('course_no', $course_no);
		
		$count = $this->db->count_all_results('subjects');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function descriptive_title_exist_in_id($id, $descriptive_title) {
		$this->db->where('id', $id);
		$this->db->where('descriptive_title', $descriptive_title);
		
		$count = $this->db->count_all_results('subjects');
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function update_via_course_no($id, $course_no, $credit) {
		
		$data = array(
			'course_no' => $course_no,
			'credit' => $credit
		);
		
		$this->db->where('id', $id);
		$query = $this->db->update('subjects', $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function update_via_descriptive_title($id, $descriptive_title, $credit) {
		
		$data = array(
			'descriptive_title' => $descriptive_title,
			'credit' => $credit
		);
		
		$this->db->where('id', $id);
		$query = $this->db->update('subjects', $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function get_subject_by_descriptive_title($descriptive_title) {
		$this->db->where('descriptive_title', $descriptive_title);
		$query = $this->db->get('subjects');
		return $query->result();
	}
	
	function get_subject_term_id_by_subject_id($subject_id) {
		$this->db->select('term_id');
		$this->db->where('id', $subject_id);
		$query = $this->db->get('subjects');
		
		return $query->result();
	}
	
	
} // end main class









