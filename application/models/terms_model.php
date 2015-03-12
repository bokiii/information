<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_model extends CI_Model {

	private $table = "terms";
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function term_exists($term) {
		$this->db->where('term', $term);
		$count = $this->db->count_all_results($this->table);
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function semester_exists($semester) {	
		$this->db->where('semester', $semester);
		$count = $this->db->count_all_results($this->table);
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function term_and_semester_exists($term, $semester) {
		$this->db->where('term', $term);
		$this->db->where('semester', $semester);
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	function school_year_exists($school_year) {
		$this->db->where('school_year', $school_year);
		$count = $this->db->count_all_results($this->table);
		
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_term_by_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	function delete_subjects_by_term_id($term_id) {
		$this->db->where_in('term_id', $term_id);
		$query = $this->db->delete("subjects");
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_terms_with_order() {
		$this->db->order_by("order"); 
		$query = $this->db->get($this->table); 
		return $query->result();
	}
	
	
}
