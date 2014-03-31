<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function add($table, $data) {
	
		$query = $this->db->insert($table, $data);
	
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function get($table) {
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function delete($table, $id) {
		$this->db->where_in("id", $id);
		$query = $this->db->delete($table);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
}