<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {


	// variables for search height
	public	$height1 = "30px";
	public	$height2 = "20px";
	
	// variables for courses table 
	public $table = "courses";
	public $add = "add_course";
	public $delete = "delete_course";
	
	// variables for external tables 
	public $course_subjects = "course_subjects";
	public $schools = "schools";
	public $school_courses = "school_courses";
	
	// variables for search
	public $search;
	public $search_status;
	public $keyword;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;
	
	// below is the update id for the update
	
	private $update_id;
	
	function __construct() {
		parent::__construct();
		$this->load->model('school_courses_model');
		$this->load->model('schools_model');
		$this->load->model('courses_model');
	}

	private function get_update_id() {
		return $this->update_id;
	}
	
	private function set_update_id($id) {
		$this->update_id = $id;
	}
	
	private function get_validation_errors() {
		return $this->validation_errors;
	}
	
	private function set_validation_errors($errors) {
		$this->validation_errors = $errors;
	}
	
	function index() {
	
		// call prompt below
		
		$this->prompt();
	
		// search table
		
		$data['search_table'] = $this->table;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $this->table ."</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='course'>Course:</label></td>
						<td><input type='text' name='course' id'course' /></td>
					</tr>
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		// content below 
		
		$content_action = base_url() . "index.php/". $this->table ."/". $this->delete . " ";
		$module_url = base_url() . "index.php/". $this->table ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $this->table ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Course</th>
						<th>School</th>
						<th>Subjects</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course = $row->course;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/". $this->course_subjects ."?id={$id}";
					
					// get data for manage link 
					
					$get_school_id_by_course_id = $this->school_courses_model->get_school_id_by_course_id($id);
					
					if($get_school_id_by_course_id != NULL) {
						
						foreach($get_school_id_by_course_id as $row_a) {
							$school_id = $row_a->school_id;
						}
						
						$get_school_by_school_id = $this->schools_model->get_school_by_school_id($school_id);
						
						foreach($get_school_by_school_id as $row_b) {
							$school = $row_b->school;
						}
						
					} else {
						$school = "<a class='link_add' id='{$id}' href='#'>Update School</a>";
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course}</a></td>
							<td>{$school}</td>
							<td><a class='manage_link' href='{$manage_link}'>Manage</a></td>
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
			$get_content_data = $this->global_model->get($this->table);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course = $row->course;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/". $this->course_subjects ."?id={$id}";
				
					// get data for manage link 
					$get_school_id_by_course_id = $this->school_courses_model->get_school_id_by_course_id($id);
					
					if($get_school_id_by_course_id != NULL) {
						
						foreach($get_school_id_by_course_id as $row_a) {
							$school_id = $row_a->school_id;
						}
						
						$get_school_by_school_id = $this->schools_model->get_school_by_school_id($school_id);
						
						foreach($get_school_by_school_id as $row_b) {
							$school = $row_b->school;
						}
						
					} else {
						$school = "<a class='link_add' id='{$id}' href='#'>Update School</a>";
					}
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course}</a></td>
							<td>{$school}</td>
							<td><a class='manage_link' href='{$manage_link}'>Manage</a></td>
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
		$global_json_path = $this->load->view('tools/global_json_path', $path);
		
		$data['content'] .= "
				</table>
				<div id='actions'>
					{$global_json_path}
					<button id='add_button' value='". $this->table ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		
		// below is for the link add tool
	
		$get_schools = $this->global_model->get($this->schools);
		
		if($get_schools != NULL) {
			
			$link_add_data = array();
			$link_add_id = array();
			foreach($get_schools as $row_l) {
				array_unshift($link_add_data, $row_l->school);
				array_unshift($link_add_id, $row_l->id);
			}
			
			$data['link_add_module'] = $this->schools;
			$data['link_add_id'] = $link_add_id;
			$data['link_add_data'] = $link_add_data;
		}
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	}
	
	function add_course() {
		
		// call validation
		
		$this->validation('add');
		
		if($this->form_validation->run() == TRUE) {
			
			$data = array(
				"course" => $this->input->post('course')
			);
			
			$add_course = $this->global_model->add($this->table, $data);
			
			$this->prompt_status = true;
		} else {
			$this->prompt_status = false;
			//$this->validation_errors = validation_errors();
			$this->set_validation_errors(validation_errors());
			
		} 
		
		$this->index();
		
	}
	
	function delete_course() {
		
		$id = $this->input->post('id');
		$delete_course = $this->global_model->delete($this->table, $id);
		
		$this->index();
	}
	
	function update_course() {
	
		// get id
		
		$id = $this->input->post('id');
		
		$this->set_update_id($id);
		
		// call validation
		
		$this->validation('update');
		
		if($this->form_validation->run() == TRUE) {
		
			// check term_exists_in_id and set variable for course
			
			$course = $this->input->post('course');
			$course_exist = $this->courses_model->course_exists_in_id($this->get_update_id(), $course);
			
			if($course_exist) {
			
				$data = array(
					"id" => $this->input->post('id'),
					"course" => $this->input->post('course')
				);
				
				$update_course = $this->global_model->update($this->table, $data, $data['id']);
			
				$this->prompt_status = true;
			
			} else {
				
				$this->validation('add');
		
				if($this->form_validation->run() == TRUE) {
					
					$data = array(
						"course" => $this->input->post('course')
					);
					
					$update_course = $this->global_model->update($this->table, $data, $this->get_update_id());
					
					$this->prompt_status = true;
				
				} else {
					$this->prompt_status = false;
					//$this->validation_errors = validation_errors();
					$this->set_validation_errors(validation_errors());
					
				} 
			
			}
			
			
		} else {
			$this->prompt_status = false;
			//$this->validation_errors = validation_errors();
			$this->set_validation_errors(validation_errors());
		}
		
		$this->index();
	}
	
	private function prompt() {
		if($this->prompt_status === true) {
			$promp_data['message'] = "<p>Sucess</p>";
			$promp_data['class'] = "success";
			$this->load->view('tools/prompt', $promp_data);
		} else if($this->prompt_status === false) {
			$promp_data['message'] = $this->get_validation_errors();
			$promp_data['class'] = "error";
			$this->load->view('tools/prompt', $promp_data);
		}
	}
	
	private function validation($action) {
		
		$this->load->library('form_validation');
		
		if($action == "add") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('course', 'Course.', 'required|is_unique[courses.course]');
			
		}
		
		if($action == "update") {
			
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('course', 'Course.', 'required');
		
		
		}
	}
	
	public function link_add() {
	
		$course_id = $this->input->post('sub_id');
		$school_id = $this->input->post('main_id');
		
		if(!$this->input->post('sub_id') || !$this->input->post('main_id')) {
			
			$this->prompt_status = false;
			$this->validation_errors = "<p>School is required</p>";
			
		} else {
			
			$count_school_course_by_course_id = $this->school_courses_model->count_school_course_by_course_id($course_id);
			$count_school_course_by_course_id_and_school_id = $this->school_courses_model->count_school_course_by_course_id_and_school_id($course_id, $school_id);
			
			if($count_school_course_by_course_id != 0 && $count_school_course_by_course_id_and_school_id == 0) {
				
				$this->prompt_status = false;
				
				$get_school_id_by_course_id = $this->school_courses_model->get_school_id_by_course_id($course_id);
				
				foreach($get_school_id_by_course_id as $row_a) { 
					$course_school_id = $row_a->school_id;
				}
				
				$get_school_by_school_id = $this->schools_model->get_school_by_school_id($course_school_id);
				
				foreach($get_school_by_school_id as $row_b) {
					$course_school = $row_b->school;
				}
				
				$this->validation_errors = "<p>Already added <br /> in <br /> (". $course_school .")</p>";
				
			} elseif ($count_school_course_by_course_id != 0 && $count_school_course_by_course_id_and_school_id != 0) {
				
				$this->prompt_status = false;
				$this->validation_errors = "<p>Course already exists.</p>";
				
			} else {
				$data = array(
					"course_id" => $this->input->post('sub_id'),
					"school_id" => $this->input->post('main_id')
				);
		
				$add_school_course = $this->global_model->add($this->school_courses, $data);
				
				$this->prompt_status = true;
			}
		}
	
		$this->index();
	}
	
}





