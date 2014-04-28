<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teachers_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function get_teacher_by_teachers_id($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('teachers');
		return $query->result();
	}


}