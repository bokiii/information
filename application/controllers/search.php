<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	private $student;
	
	function __construct() {
		parent::__construct();
		$this->load->model('search_model');
		
		include_once (dirname(__FILE__) . "/students.php");
		$this->student = new Students();
		
	}
	
	function index() {
	
		if($this->input->get("search")) {
			
			$table = $this->input->get("search");
			$fields = $this->db->list_fields($table);
			$keyword = $this->input->get("keyword");
			
			$this->load->model('search_model');
			
			$search = $this->search_model->search($table, $fields, $keyword);
			
			$this->student->search_status = true;
			$this->student->search = $search;
			$this->student->keyword = $keyword;
			$this->student->index();
			
		} else {
			show_404();
		}
	}

}