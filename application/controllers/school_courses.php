<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_courses extends CI_Controller {
	
	public $table = "school_courses";
	public $add = "add_school_course";
	public $delete = "delete_school_course";
	
	function __construct() {
		parent::__construct();
	}
	
	function add_school_course() {
		
		$data = array(
			"course_id" => $this->input->post('course_id'),
			"school_id" => $this->input->post('school_id')
		);
		
		$add_school_course = $this->global_model->add($this->table, $data);
		
		if($add_school_course) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect("manage/". $this->table ."?id=". $data['school_id'] ."");
		
		//echo json_encode($data);
	}
	
	function delete_school_course() {
		
		$data['school_id'] = $this->input->post('school_id');
		
		$id = $this->input->post('id');
		$delete_school_course = $this->global_model->delete($this->table, $id);
		
		if($delete_school_course) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect("manage/". $this->table ."?id=". $data['school_id'] ."");
	}
	
}