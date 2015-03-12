<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_subjects extends CI_Controller {
	
	// variables for search height
	public $height1 = "30px";
	public $height2 = "20px";
	
	// variables for school courses
	public $table = "course_subjects";
	public $add = "add_course_subject";
	public $delete = "delete_course_subject";
	
	// variable for subject teachers
	public $subject_teachers = "subject_teachers";
	
	// variables for search 
	public $search;
	public $search_status;
	public $keyword;
	
	// variables for includes
	public $course;
	public $subject;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;
	
	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
		
		// load necessary models
		$this->load->model('subjects_model');
		$this->load->model('courses_model');
		$this->load->model('course_subjects_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/courses.php");
		include_once (dirname(__FILE__) . "/subjects.php");
		
		// assign includes to a variable
		$this->course = new Courses();
		$this->subject = new Subjects();
		
	}
	
	function debug($data) {
		echo "<pre>";
			print_r($data);
		echo "</pre>";
	}
	
	function index($id=null) {
		
		if($this->input->get('id')) {
			$course_id = $this->input->get('id'); 
		}
		
		if(!$this->input->get('id')) {
			$course_id = $id; 
		}
	
		if(!isset($course_id)) {
			show_404();
		}
		
		// call prompt below 
		$this->prompt();
		
		$data['search_table'] = $this->table;
		
		// set search manage variables if it is a manage
		$data['search_manage_table'] = $this->subject->table;
		$data['search_manage_id'] = $course_id;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// get course data 
		
		$get_course = $this->global_model->get_by_id($this->course->table, $course_id);
		

		foreach($get_course as $row_course) { 
			$course = $row_course->course;
		}
		
		// get data for subjects
		
		$get_subjects = $this->global_model->get($this->subject->table);
		
		$subject_data = array();
		
		foreach($get_subjects as $row_subject) {
			$subject_data[] = array(
				"id" => $row_subject->id,
				"course_no" => $row_subject->course_no,
				"subject" => $row_subject->descriptive_title
			);
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $course ."</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					
					<tr>
						<td><label for='subject_id'>Subject:</label></td>
						<td>
							<select name='subject_id' id='subject_id'>
		";
							$data['popup'] .= "
								<option value>&nbsp;</option>
							";
							for($i = 0; $i < count($subject_data); $i++) {
								
								$data['popup'] .= "
									<option value='{$subject_data[$i]['id']}'>". $subject_data[$i]['course_no'] . " " . $subject_data[$i]['subject'] ."</option>
								";
							
							}
		
		$data['popup'] .= "
							</select>
						</td>
						<input type='hidden' name='course_id' value='{$course_id}' />
					</tr>
					
					
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		
		// content below 
		
		$content_action = base_url() . "index.php/". $this->table ."/". $this->delete . " ";
		$module_url = base_url() . "index.php/". $this->table ."?id=". $course_id ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $course ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Subject</th>
						<th>Teachers</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$subject_id = $row->subject_id;
					$course_id = $row->course_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";*/
					$manage_link = base_url() . "index.php/". $this->subject_teachers ."?id={$subject_id}";
					
					$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($subject_id);
					
					foreach($get_subject_by_subject_id as $row_course_subject) {
						$course_no = $row_course_subject->course_no;
						$descriptive_title = $row_course_subject->descriptive_title;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$course_no} {$descriptive_title}</td>
							<td><a href='{$manage_link}'>Manage</a></td>
							<input type='hidden' name='course_id' value='{$course_id}' />
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td style='text-align: center;' colspan='5'>No results found.</td>
					</tr>
				";
			}
		} else {
			$get_content_data = $this->course_subjects_model->get_course_subjects_by_course_id($course_id);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$subject_id = $row->subject_id;
					$course_id = $row->course_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";*/
					$manage_link = base_url() . "index.php/". $this->subject_teachers ."?id={$subject_id}";
				
					$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($subject_id);
					
					foreach($get_subject_by_subject_id as $row_course_subject) {
						$course_no = $row_course_subject->course_no;
						$descriptive_title = $row_course_subject->descriptive_title;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$course_no} {$descriptive_title}</td>
							<td><a href='{$manage_link}'>Manage</a></td>
							<input type='hidden' name='course_id' value='{$course_id}' />
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td style='text-align: center;' colspan='5'>No ". $this->table ." added in the database</td>
					</tr>
				";
			}
		}
		
		
		
		// global json_path below
		$path['current_url'] = base_url() . "index.php/" . $this->table;
		$path['id'] = $course_id;
		$global_json_path = $this->load->view('tools/global_json_path', $path);
		
		$data['content'] .= "
				</table>
				<div id='actions'>
					{$global_json_path}
					<button id='add_button' value='". $this->table . "?id=".  $course_id ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
		
	} 
	
	
	function add_course_subject() {
	
		$subject_id = $this->input->post('subject_id');
		$course_id = $this->input->post('course_id');
		
		if($subject_id == "") {
			
			$this->prompt_status = false;
			$this->validation_errors = "<p>Subject is required</p>";
			
		} else {
			
			// get subject term_id
			
			$get_term_id = $this->subjects_model->get_subject_term_id_by_subject_id($subject_id);
			
			foreach($get_term_id as $row) {
				$term_id = $row->term_id;
			}
			
			$count_course_subject_by_subject_id = $this->course_subjects_model->count_course_subject_by_subject_id($subject_id);
			$count_course_subject_by_subject_id_and_course_id = $this->course_subjects_model->count_course_subject_by_subject_id_and_course_id($subject_id, $course_id);
			
			if($count_course_subject_by_subject_id != 0 && $count_course_subject_by_subject_id_and_course_id != 0) {
				$this->prompt_status = false;
				$this->validation_errors = "<p>Subject already exists.</p>";
			} else {
				
				$data = array(
					"subject_id" => $this->input->post('subject_id'),
					"course_id" => $this->input->post('course_id'),
					"term_id" => $term_id
				);
				
				$add_course_subject = $this->global_model->add($this->table, $data);
			
				$this->prompt_status = true;
			}
			
		}
	
		$this->index($course_id);
		
	}
	
	function delete_course_subject() {
		
		$course_id = $this->input->post('course_id');
		
		$id = $this->input->post('id');
		
		$delete_course_subject = $this->global_model->delete($this->table, $id);
		
		$this->index($course_id);
		
	}
	
	private function prompt() {
		if($this->prompt_status === true) {
			$promp_data['message'] = "<p>Sucess</p>";
			$promp_data['class'] = "success";
			$this->load->view('tools/prompt', $promp_data);
		} else if($this->prompt_status === false) {
			$promp_data['message'] = $this->validation_errors;
			$promp_data['class'] = "error";
			$this->load->view('tools/prompt', $promp_data);
		}
	}
	
}






