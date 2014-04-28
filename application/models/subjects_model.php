<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_subject_by_subject_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('subjects');
		return $query->result();
	} 
	
	
}