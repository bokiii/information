<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function search($table, $fields, $keyword) {
		
		$this->db->like($fields[1], $keyword);
		
		for($i = 2; $i < count($fields); $i++) {
			$this->db->or_like($fields[$i], $keyword);
		}
		
		$query = $this->db->get($table);
		
		return $query->result();
	}
	
	function search_by_id_and_main_id($table, $fields, $id, $main_id) {
		
		$this->db->where_in($fields[1], $id);
		$this->db->where($fields[2], $main_id);
		$query = $this->db->get($table);
		return $query->result();
		
	}


}





