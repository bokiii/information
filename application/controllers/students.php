<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {
	
	public	$height1 = "30px";
	public	$height2 = "20px";
	
	public $table = "students";
	public $add = "add_student";
	public $delete = "delete_student";
	
	public $search;
	public $search_status;
	public $keyword;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;
	
	function __construct() {
		parent::__construct();
		$this->load->model('school_courses_model');
		$this->load->model('courses_model');
		$this->load->model('course_subjects_model');
		$this->load->model('subjects_model');
		$this->load->model('students_model');
		$this->load->model('schools_model');
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
		
		// set below the method action
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		// get terms below 
		
		$get_terms = $this->global_model->get('terms');
		
		$terms_data = array();
		
		if($get_terms != NULL) {
			foreach($get_terms as $row_terms) {
				$terms_data[] = array(
					"id" => $row_terms->id,
					"term" => $row_terms->term,
					"semester" => $row_terms->semester,
					"school_year" => $row_terms->school_year
				); 
			}
		}
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $this->table ."</h1>
			<form class='has_slide student_slideshow_form' action='{$popup_form_action}' method='post' id='popup_form'>
				
				<table id='starting_div' class='slide_div'>
					<tr>
						<td><label for='term_id'>Terms</label></td>
						<td>
							<select name='term_id' id='term_id'>
								<option value>Select Term</option>
						
		";
							for($i = 0; $i < count($terms_data); $i++) {
								$data['popup'] .= "
									<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']}, {$terms_data[$i]['semester']} semester, {$terms_data[$i]['school_year']}</option>
								";
							}
		$data['popup'] .= "
							</select>
						</td>
					</tr>
				
				</table>
			
		";
		
		$data['popup'] .= "
			<table id='first_div' class='slide_div'>
				<tr>
					<td><label for='first_name'>First Name:</label></td>
					<td><input type='text' name='first_name' id='first_name' /></td>
					<td><label for='last_name'>Last Name:</label></td>
					<td><input type='text' name='last_name' id='last_name' /></td>
				</tr>
				<tr>
					<td><label for='middle_name'>Middle Name:</label></td>
					<td><input type='text' name='middle_name' id='middle_name' /></td>
				</tr>
			</table>
		";
		
		$data['popup'] .= "
				
				<table id='second_div' class='slide_div'>
					<tr>
						<td><label for='age'>Age:</label></td>
						<td><input type='text' name='age' id='age' /></td>
						<td><label for='gender'>Gender:</label></td>
						<td><input type='text' name='gender' id='gender' /></td>
					</tr>
					<tr>
						<td><label for='birth_date'>Birthdate:</label></td>
						<td><input type='text' name='birth_date' id='birth_date' /></td>
						<td><label for='civil_status'>Civil Status:</label></td>
						<td><input type='text' name='civil_status' id='civil_status' /></td>
					</tr>
					<tr>
						<td><label for='religion'>Religion:</label></td>
						<td><input type='text' name='religion' id='religion' /></td>
					</tr>
				</table>
		";
		
		
		// for third div get school and its courses data
		$get_schools = $this->global_model->get('schools');
		
		$schools_data = array();
		
		if($get_schools != NULL) {
			foreach($get_schools as $row) {
				$schools_data[] = array(
					"id" => $row->id,
					"school" => $row->school
				);
			}
		}
		
		$course_source = base_url() . "index.php/". $this->table ."/get_courses";
	
		$data['popup'] .= "
				<table id='third_div' class='slide_div'>
					<input type='hidden' name='course_source' id='course_source' value='{$course_source}' />
					<tr>
						<td><label for='school_id'>School:</label></td>
						<td>
							<select name='school_id' id='school_id'>
								<option value>Select School</option>
		";
		
						for($i = 0; $i < count($schools_data); $i++ ) {
							$data['popup'] .= "
								<option value='{$schools_data[$i]['id']}'>{$schools_data[$i]['school']}</option>
							";
						}
			
		$data['popup'] .= "
							</select>
						</td>
					</tr>
				</table>
		";		
		
		// the fourth div will be the container of the selected school courses
		$data['popup'] .= "
			<table id='fourth_div' class='slide_div'>
				<tr>
					<td><label for='course_id'>Course</label></td>
					<td>Please go back and select school first.</td>
				</tr>
			</table>
		";
		
		// the fifth div will be the container of the selected course subjects 
		$data['popup'] .= "
			<div id='fifth_div' class='slide_div'>
				<div>
					<h2>Subjects</h2>
					<p class='center'>Please go back and select course first.</p>
				</div>
			</div>
		";
		
		// the end div will be the container of the enroll now  
		$data['popup'] .= "
			<div id='end_div' class='slide_div'>
				<div>
					<p>Be sure that you already filled up the necessary details for the students.</p>
					<p><input type='submit' id='enroll_now' value='Enroll Now' /></p>
				</div>
			</div>
		";
	
		// below are for actions
		$data['popup'] .= "
				
				<table class='final_actions'>
					<tr>
						<td class='center' colspan='4'><input class='clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
				
				<div class='switch_actions'>
					<button class='left' id='prev'>&larr; Previous</button>
					<button class='right' id='next'>Next &rarr;</button>
					<div class='clear'></div>
				</div>
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
						<th>First Name</th>
						<th>Last Name</th>
						<th>Middle Name</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$first_name = $row->first_name;
					$last_name = $row->last_name;
					$middle_name = $row->middle_name;
					
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td style='text-align: center;' colspan='7'>No results found.</td>
					</tr>
				";
			}
		} else {
			$get_content_data = $this->global_model->get($this->table);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$first_name = $row->first_name;
					$last_name = $row->last_name;
					$middle_name = $row->middle_name;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td style='text-align: center;' colspan='7'>No ". $this->table ." added in the database</td>
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
					<button id='add_button' value='has_switch_actions'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	}
	
	function add_student() {
		
		$data = array(
			"term_id" => $this->input->post('term_id'),
			"first_name" => $this->input->post('first_name'),
			"last_name" => $this->input->post('last_name'),
			"middle_name" => $this->input->post('middle_name'),
			"age" => $this->input->post('age'),
			"gender" => $this->input->post('gender'),
			"birth_date" => $this->input->post('birth_date'),
			"civil_status" => $this->input->post('civil_status'),
			"religion" => $this->input->post('religion'),
			"school_id" => $this->input->post('school_id'),
			"course_id" => $this->input->post('course_id'),
			"subject" => $this->input->post('subject')
		);
		
		
		// set student data
		$student_data = array(
			"first_name" => trim($this->input->post('first_name')),
			"last_name" => trim($this->input->post('last_name')),
			"middle_name" => trim($this->input->post('middle_name'))
		);
		
		// insert student data 
		$add_student = $this->students_model->add_student($student_data);
		
		//get student id
		$get_student_id = $this->students_model->get_student_id_by_first_name_last_name_middle_name($student_data['first_name'], $student_data['last_name'], $student_data['middle_name']);
		
		foreach($get_student_id as $row_id) {
			$student_id = $row_id->id;
		}
		
		// set student others data
		$student_others_data = array(
			"age" => trim($this->input->post('age')),
			"gender" => trim($this->input->post('gender')),
			"birth_date" => trim($this->input->post('birth_date')),
			"civil_status" => trim($this->input->post('civil_status')),
			"religion" => trim($this->input->post('religion')),
			"student_id" => $student_id
		);
		
		// insert student others data 
		$add_student_others = $this->students_model->add_student_others($student_others_data);
		
		// get school by school id 
		$get_school_by_school_id = $this->schools_model->get_school_by_school_id($this->input->post('school_id'));
		foreach($get_school_by_school_id as $row_school) {
			$school = $row_school->school;
		}
		
		// set school student data
		$student_school_data = array(
			"school" => trim($school),
			"student_id" => $student_id
		);
		
		// insert student school data
		$add_student_school = $this->students_model->add_student_school($student_school_data);
		
		// get course by course_id
		$get_course_by_course_id = $this->courses_model->get_course_by_course_id($this->input->post('course_id'));
		foreach($get_course_by_course_id as $row_course) {
			$course = $row_course->course;
		} 
		
		// get student school id
		$get_student_school_id_by_school_and_student_id = $this->students_model->get_student_school_id_by_school_and_student_id($school, $student_id);
		foreach($get_student_school_id_by_school_and_student_id as $row_student_school) {
			$student_school_id = $row_student_school->id;
		}
		
		// set student course data
		$student_course_data = array(
			"course" => $course,
			"school_id" => $student_school_id,
			"student_id" => $student_id
		);
		
		// insert student course data
		$add_student_course = $this->students_model->add_student_course($student_course_data);
		
		// for subjects
		$set_subject_id = $this->input->post('subject');
		
		for($i = 0; $i < count($set_subject_id); $i++) {
			// get subject by subject id
			$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($set_subject_id[$i]);
			foreach($get_subject_by_subject_id as $row_subject_id) {
				$subject = $row_subject_id->descriptive_title;
			}
			
			// get course id by students course course
			$get_student_course_id_by_course = $this->students_model->get_student_course_id_by_course($course);
			foreach($get_student_course_id_by_course as $row_student_course) {
				$course_id = $row_student_course->id;
			}
			
			// set student subjects data
			$student_subject_data = array(
				"subject" => $subject,
				"course_id" => $course_id,
				"student_id" => $student_id,
				"term_id" => $this->input->post('term_id')
			); 
			
			// insert student subject
			
			$add_student_subject = $this->students_model->add_student_subject($student_subject_data);
			
		} // end for loop
		
		redirect('students');
		
		/*// call validation
		
		$this->validation('add');
		
		if($this->form_validation->run() == TRUE) {
			
			$data = array(
				"first_name" => $this->input->post('first_name'),
				"last_name" => $this->input->post('last_name'),
				"middle_name" => $this->input->post('middle_name')
			);
			
			$add_student = $this->global_model->add($this->table, $data);
			$this->prompt_status = true;
			
		} else {
			$this->prompt_status = false;
			$this->validation_errors = validation_errors();
		} 
		
		$this->index();*/
	}

	function delete_student() {
		
		$id = $this->input->post('id');
		$delete_student = $this->global_model->delete($this->table, $id);
		
		$this->index();
	}
	
	function update_student() {
		
		// call validation
		
		$this->validation('update');
		
		if($this->form_validation->run() == TRUE) {
		
			$data = array(
				"id" => $this->input->post('id'),
				"first_name" => $this->input->post('first_name'),
				"last_name" => $this->input->post('last_name'),
				"middle_name" => $this->input->post('middle_name')
			);
			
			$update_student = $this->global_model->update($this->table, $data, $data['id']);
			
			$this->prompt_status = true;
		} else {
			$this->prompt_status = false;
			$this->validation_errors = validation_errors();
		}
		
		$this->index();
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
	
	private function validation($action) {
		
		$this->load->library('form_validation');
		
		if($action == "add") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('first_name', 'First name', 'required');
			$this->form_validation->set_rules('last_name', 'Last name', 'required');
			$this->form_validation->set_rules('middle_name', 'Middle name', 'required');
		}
		
		if($action == "update") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('first_name', 'First name', 'required');
			$this->form_validation->set_rules('last_name', 'Last name', 'required');
			$this->form_validation->set_rules('middle_name', 'Middle name', 'required');
		}
	}

	function get_courses() {
	
		$id = $this->input->get('id');
		
		if(isset($id) && $id != NULL) {
		
			$subject_source = base_url() . "index.php/". $this->table ."/get_subjects";
			
			$data['courses'] = "
				<tr>
					<input type='hidden' name='subject_source' id='subject_source' value='{$subject_source}' />
					<td><label for='course_id'>Course</label></td>
					<td>
						<select name='course_id' id='course_id'>
							<option value>Select Course</option>
			";
			
			$get_school_courses_by_school_id = $this->school_courses_model->get_school_courses_by_school_id($id);
			
			foreach($get_school_courses_by_school_id as $row) {
			
				$course_id = $row->course_id;
				$get_course_by_course_id = $this->courses_model->get_course_by_course_id($course_id);
				
				foreach($get_course_by_course_id as $row_a) {
					
					$data['courses'] .= "
						<option value='{$course_id}'>". $row_a->course ."</option>
					";
			
				}
			}
			
			$data['courses'] .= "
						</select>
					</td>
				</tr>
			";
		} else {
			
			$data['courses'] = "
				<tr>
					<td><label for='course_id'>Course</label></td>
					<td>Please go back and select school first.</td>
				</tr>
			";
		}
		
		echo json_encode($data);
		
	}
	
	function get_subjects() {
		
		$id = $this->input->get('id');
		
		if(isset($id) && $id != NULL) {
			
			$data['subjects'] = "<h2>Subject</h2>";
			
			$get_course_subjects_by_course_id = $this->course_subjects_model->get_course_subjects_by_course_id($id);
			
			if($get_course_subjects_by_course_id != NULL) {
				
				foreach($get_course_subjects_by_course_id as $row) {
					$subject_id = $row->subject_id;
					
					$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($subject_id);
					
					foreach($get_subject_by_subject_id as $row_a) {
						
						$course_no = $row_a->course_no;
						$descriptive_title = $row_a->descriptive_title;
						
						$data['subjects'] .= "
							<p><input type='checkbox' class='subjects' name='subject[]' value='{$subject_id}' />{$course_no} {$descriptive_title}</p>
						";
						
					}
				}
				
			} else {
				$data['subjects'] = "
					<div>
						<h2>Subjects</h2>
						<p class='center'>No subjects added in the selected course. Please update subjects in the course module.</p>
					</div>
				";
			}
			
		
		} else {
		
			$data['subjects'] = "
				<div>
					<h2>Subjects</h2>
					<p class='center'>Please go back and select course first.</p>
				</div>
			";
			
		}
		
		echo json_encode($data);
		
	}
	
	function empty_students_related_table() {
		$this->students_model->empty_table();
	}
	

} // end class



















