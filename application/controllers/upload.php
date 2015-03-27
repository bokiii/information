<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {   

	function __construct() {
		parent::__construct();
		$this->load->model("students_model");
	}   
	
	function debug($data) {
		echo "<pre>";
			print_r($data);
		echo "</pre>";
	}
	
	function same_file($file_to_check, $file) {
		if($file_to_check == $file) {
			return true;
		} else {
			return false;
		}
	}
	
	function index() {

		$get_profile_image = $this->students_model->get_student_profile_image_by_student_id($this->session->userdata('student_id'));                                          
		
		if($get_profile_image != NULL) {
		
			foreach($get_profile_image as $row_i) {
				$existing_image_file_name = $row_i->file_name;
			}
			
			$profile_file_names = get_filenames("profiles");
			
			foreach($profile_file_names as $file) {
			
				$same = $this->same_file($existing_image_file_name, $file);
				if($same) {
					$file_path = "profiles/" . $file;
					unlink($file_path);
				}
			}    
			
			$delete_current_profile_image = $this->students_model->delete_student_profile_image_by_student_id($this->session->userdata('student_id'));             
		}
	
		//insert student profile image 
		$get_student = $this->global_model->get_by_id("students", $this->session->userdata('student_id'));
		foreach($get_student as $row) {
			$image_file_name = $row->first_name . "_" . $row->last_name;
		}
		
		$this->load->library('upload');
	
		$this->upload->initialize(array( 
			//"file_name" => $image_file_name,
			"upload_path" => "profiles",
			"allowed_types" => "gif|jpg|png",
			"max_width" => "5000",
			"max_height" => "8000"
		));

		if($this->upload->do_upload('profile_pic')) {
		
			$data = $this->upload->data();
			$data['student_id'] = $this->session->userdata('student_id');
			
			$insert_profile_image = $this->global_model->add("profile_image", $data);
			
			$data['status'] = true;
		
		} else {
			$data['status'] = false;
		}
	
		echo json_encode($data);
	
	}

	
}   
















