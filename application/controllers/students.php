<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$data['main_content'] = "students_view";
		$this->load->view('template/content', $data);
	}
	

	
}