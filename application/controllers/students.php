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
	
	private $student_id;
	
	private $current_num_row;
	private $dummy_num_row;
	private $added_semester_title_status = false;
	
	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
		
		$this->load->model('school_courses_model');
		$this->load->model('courses_model');
		$this->load->model('course_subjects_model');
		$this->load->model('subjects_model');
		$this->load->model('students_model');
		$this->load->model('schools_model');
		$this->load->model('terms_model');
	
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

	function get_student_id() {
		return $this->student_id;
	}
	
	private function set_student_id($id) {
		$this->student_id = $id;
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
	
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $this->table ."</h1>
			<form class='has_slide student_slideshow_form' action='{$popup_form_action}' method='post' id='popup_form'>
		";
		
		$data['popup'] .= "
			<table id='first_div' class='slide_div'>
				<tr>
					<td><label for='first_name'>First Name</label></td>
					<td><input type='text' name='first_name' id='first_name' /></td>
					<td><label for='last_name'>Last Name</label></td>
					<td><input type='text' name='last_name' id='last_name' /></td>
				</tr>
				<tr>
					<td><label for='middle_name'>Middle Name</label></td>
					<td><input type='text' name='middle_name' id='middle_name' /></td>
				</tr>
			</table>
		";
		
		$data['popup'] .= "
				
				<table id='second_div' class='slide_div'>
					<tr>
						<td><label for='gender'>Gender</label></td>
						<td>
							<select name='gender' id='gender'>
								<option value>&nbsp;</option>
								<option value='male'>Male</option>
								<option value='female'>Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for='birth_date'>Birthdate</label></td>
						<td><input type='text' name='birth_date' id='birth_date' /></td>
						<td><label for='civil_status'>Civil Status:</label></td>
						<td>
							<select name='civil_status' id='civil_status'>
								<option value>&nbsp;</option>
								<option>Single</option>
								<option>Married</option>
								<option>Widowed</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for='religion'>Religion</label></td>
						<td><input type='text' name='religion' id='religion' /></td>
						<td><label for='address'>Address</label></td>
						<td><input type='text' name='address' id='address' /></td>
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
						<td><label for='school_id' class='right'>School</label></td>
						<td>
							<select name='school_id' id='school_id'>
								<option value>&nbsp;</option>
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
					<td><label for='course_id' class='right'>Course</label></td>
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
						<th>Manage</th>
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
					$manage_link = base_url() . "index.php/" . $this->table . "/manage_students?id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
							<td><a href='{$manage_link}'>Manage</a></td>
							
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
					$manage_link = base_url() . "index.php/" . $this->table . "/manage_students?id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
							<td><a href='{$manage_link}'>Manage</a></td>
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
		
		/*$start_year = date('Y');
		$end_year = date('Y', strtotime('+1 years'));
		$school_year = $start_year . "-" . $end_year;*/   
		
		$school_year = $this->input->post('school_year');
		
		$data = array(
			"term_id" => $this->input->post('term_id'),
			"first_name" => $this->input->post('first_name'),
			"last_name" => $this->input->post('last_name'),
			"middle_name" => $this->input->post('middle_name'),
			"gender" => $this->input->post('gender'),
			"birth_date" => $this->input->post('birth_date'),
			"civil_status" => $this->input->post('civil_status'),
			"religion" => $this->input->post('religion'),
			"address" => $this->input->post('address'),
			"school_id" => $this->input->post('school_id'),
			"course_id" => $this->input->post('course_id'),
			"subject" => $this->input->post('subject'), 
			"school_year" => $school_year
		);
		
	
		// set student data
		$student_data = array(
			"first_name" => trim($this->input->post('first_name')),
			"last_name" => trim($this->input->post('last_name')),
			"middle_name" => trim($this->input->post('middle_name')), 
			"student_type" => trim($this->input->post('student_type')), 
			"enrolled_term_id" => $this->input->post('term_id')
		);
		
		// insert student data 
		$add_student = $this->students_model->add_student($student_data);
		
		//get student id
		$get_student_id = $this->students_model->get_student_id_by_first_name_last_name_middle_name($student_data['first_name'], $student_data['last_name'], $student_data['middle_name']);
		
		foreach($get_student_id as $row_id) {
			$student_id = $row_id->id;
		}
		
		// set student others data
		
		$birth_date = trim($this->input->post('birth_date'));
		$set_birth_date = str_replace("/", "-", $birth_date);
		
		$student_others_data = array(
			"gender" => trim($this->input->post('gender')),
			"birth_date" => $set_birth_date,
			"civil_status" => trim($this->input->post('civil_status')),
			"religion" => trim($this->input->post('religion')),
			"address" => trim($this->input->post('address')),
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
		
			$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($set_subject_id[$i]);
			
			$get_course_subject_id = $this->course_subjects_model->get_course_subject_id_by_subject_id($set_subject_id[$i]);
			foreach($get_course_subject_id as $row_c) {
				$course_subject_id = $row_c->id;
			}
			
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
				"term_id" => $this->input->post('term_id'),
				"school_year" => $school_year,
				"course_subject_id" => $course_subject_id
			); 
				
			// insert student subject
			
			$add_student_subject = $this->students_model->add_student_subject($student_subject_data);
			
		} // end for loop
		
		// get all subjects by students via student_id
		
		$student_subjects = $this->students_model->get_subject_ids_by_student_id($student_id);
		
		if($student_subjects != NULL) {
			
			foreach($student_subjects as $row_subject) {
				$data = array(
					'earned_credit' => 0,
					'grade' => 0,
					'status' => 'enrolled', 
					'subject_id' => $row_subject->id
				); 
				
				$this->students_model->add_student_grade($data);
			}
		
		}
		
		redirect('students');
		
	}

	function delete_student() {
		
		$id = $this->input->post('id');
		
		foreach($id as $set_id) {
			
			$get_profile_image = $this->students_model->get_student_profile_image_by_student_id($set_id);                                          
		
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
				
				$delete_current_profile_image = $this->students_model->delete_student_profile_image_by_student_id($set_id);             
			}
			
		}
		
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
					<td><label for='course_id' class='right'>Course</label></td>
					<td>
						<select name='course_id' id='course_id'>
							<option value>&nbsp;</option>
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
					<td><label for='course_id' class='right'>Course</label></td>
					<td>Please go back and select school first.</td>
				</tr>
			";
		}
		
		echo json_encode($data);
		
	}

	function process_decision_to_insert_semester_title() {
		if($this->dummy_num_row == 0) {
			$this->added_semester_title_status = true;
		} else {
			if($this->current_num_row == $this->dummy_num_row) {
				$this->added_semester_title_status = false;
				$this->dummy_num_row == $this->current_num_row;
			} else {
				$this->added_semester_title_status = true;
			}
		}
	}

	function get_subjects() {
		
		$id = $this->input->get('id');
		$data = array();
		
		if(isset($id) && $id != NULL) {
			
			$get_course_subjects_by_course_id = $this->course_subjects_model->get_course_subjects_by_course_id($id);
			
			if($get_course_subjects_by_course_id != NULL) {
				
				// get terms then arrange it by order
				$get_terms = $this->terms_model->get_terms_with_order();
				
				$data['subjects'] = "";
				
				foreach($get_terms as $row_term) {
					
					$term_id = $row_term->id;
					$term = ucwords($row_term->term);
					$semester = ucwords($row_term->semester);
					$order = $row_term->order;
				
					$get_course_subjects = $this->course_subjects_model->get_course_subjects_by_term_id_and_course_id($term_id, $id);
					
					if($get_course_subjects != NULL) {
					
						$this->current_num_row = count($get_course_subjects);
						$this->dummy_num_row = count($get_course_subjects);
						
						foreach($get_course_subjects as $row) {
						
							$subject_id = $row->subject_id;
			
							$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($subject_id);
							
							foreach($get_subject_by_subject_id as $row_a) {
								
								$course_no = $row_a->course_no;
								$descriptive_title = $row_a->descriptive_title;
								$current_term_id = $row_a->term_id;
								
								$this->process_decision_to_insert_semester_title();
								
								if($this->added_semester_title_status == false) {
									$data['subjects'] .= "
										<h2>{$term} Year </h2>
										<p class='semester'>{$semester} Semester</p>
									";
									
									$this->dummy_num_row -= 1;
									$this->added_semester_title_status == true;
								}
								
								$data['subjects'] .= "
									<p><input type='checkbox' class='subjects {$current_term_id}' name='subject[]' disabled='disabled' value='{$subject_id}' />{$course_no} {$descriptive_title}</p>
								";
							}
						}
						
					} else {
						$data['subjects'] .= "
							<h2>{$term} Year</h2>
							<p class='semester'>{$semester} Semester</p>
						";
						
						
						$data['subjects'] .= "<p class='no_subject'>No subject added in this semester</p>";
					}
					
				} // end foreach loop
			
			
			} else {
				$data['subjects'] = "
					<h2>Subjects</h2>
					<p class='center'>No subjects added in the selected course. Please update subjects in the course module.</p>
				";
			}
			
		} else {
		
			$data['subjects'] = "
				<h2>Subjects</h2>
				<p class='center'>Please go back and select course first.</p>
			";
			
		} 
		
		
		
		// get current school year 
		$start_year = date('Y');
		$end_year = date('Y', strtotime('+1 years'));
		$school_year = $start_year . "-" . $end_year;
		
		// get terms below 
		
		$get_terms = $this->global_model->get('terms');
		
		$terms_data = array();
		
		if($get_terms != NULL) {
			foreach($get_terms as $row_terms) {
				$terms_data[] = array(
					"id" => $row_terms->id,
					"term" => ucwords($row_terms->term),
					"semester" => ucwords($row_terms->semester)
				); 
			}
		}
		
		$data['student_type'] = "
		
			<div id='student_type_div' class='left'>
				<label for='student_type'>Student Type</label>
				<select name='student_type' id='student_type'>
					<option value></option>     
					<option value='regular'>Regular</option>   
					<option value='irregular'>Irregular</option>
				</select>   
			</div>
		
			<div id='student_term_div' class='left'>
				<label for='term_id'>Term</label>
				<select name='term_id' id='term_id'>
					<option value></option>
		";   

			for($i = 0; $i < count($terms_data); $i++) {
				$data['student_type'] .= "
					<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester </option>
				";
			}
		
		$data['student_type'] .= "
				</select> 
			</div>  
			
			<div id='school_year_div' class='left'>  
				<label for='school_year'>School Year</label>
				<input type='text' name='school_year' id='school_year' placeholder='{$school_year}' />
			</div>
			
			
			<div class='clear'></div>
		";
	
		echo json_encode($data);
	}
	
	function empty_students_related_table() {
		$this->students_model->empty_table();
	}
	
	function manage_students() {
		
		// search table 
		
		$data['search_table'] = $this->table;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$id = $this->input->get('id');
	
		$get_student_course = $this->students_model->get_student_course_by_student_id($id);
		foreach($get_student_course as $row) {
			$course = $row->course;
		}
		
		$get_course_id = $this->courses_model->get_course_id_by_course($course);
		
		foreach($get_course_id as $row_course) {
			$course_id = $row_course->id;
		}
		
		$get_terms = $this->global_model->get('terms');
		$terms_data = array();
		if($get_terms != NULL) {
			foreach($get_terms as $row_terms) {
				$terms_data[] = array(
					"id" => $row_terms->id,
					"term" => ucwords($row_terms->term),
					"semester" => ucwords($row_terms->semester)
				); 
			}
		}
		
		$subject_source = base_url() . "index.php/". $this->table ."/get_student_subjects";
		$popup_form_action = base_url() . "index.php/". $this->table ."/add_subject";
	
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $course ."</h1>
			<form action='{$popup_form_action}' method='post' id='subject_popup_form'>
				<input type='hidden' name='subject_source' id='subject_source' value='{$subject_source}' />
				<input type='hidden' name='course_id' id='course_id' value='{$course_id}' />
				<input type='hidden' name='student_id' id='student_id' value='{$id}' />
				
				<div id='student_type_div'>  
				</div>
				
				<div id='subjects_container'>
					<h2>Subjects</h2>
					<p class='no'>There are no subjects to select</p>
				</div>
				
				<table>
					<tr>
					
						<td><label for='term_id'>Select Term</label></td>
						<td>
							<select name='term_id' id='term_id'>
							<option value>&nbsp;</option>
		";
							for($i = 0; $i < count($terms_data); $i++) {
								$data['popup'] .= "
									<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester </option>
								";
							}
							
		$data['popup'] .= "
							</select>
						</td>  
						<td><label for='school_year'>School Year</label></td>
						<td><input type='text' name='school_year' id='school_year' placeholder='2015-2016'/></td>
					</tr>
				</table>   
				
				<input type='submit' value='Add Subject' />
			</form>
		";
		
		$update_main_data_action = base_url() . "index.php/". $this->table ."/update_student_main_data";
		$edit_image = base_url() . "images/modify.png";
		//$profile_image = base_url() . "profiles/panoy.png"; 
		//$profile_image = "../../images/blank.png"; 
		$profile_image = "../../profiles/"; 
		$view_transcript_link = base_url() . "index.php/students/generate_transcript?id=" . $id;
		
		$data['content'] ="
			<div ng-controller='StudentAcademicCtrl'>
				<form action='{$update_main_data_action}' method='post' id='main_data_form' class='full_width_3'>
					
					<div id='profile'>
						<img width='120' height='120' ng-src='{$profile_image}{{mainData.file_name}}' alt='Student Image Profile'  />
						<h2>{{mainData.first_name}} {{mainData.middle_name}} {{mainData.last_name}}</h2>
						<p><a class='transcript_button' target='_blank' href='{$view_transcript_link}'>View Transcript</a></p>
					</div>
					
					<abbr title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
					<table>
						<tr>
							<td><label for='first_name'>Name:</label></td>
							<td><input type='text' id='first_name' name='first_name' value='{{mainData.first_name}}' disabled /> <input type='text' id='middle_name' name='middle_name' value='{{mainData.middle_name}}' disabled /> <input type='text' id='last_name' name='last_name' value='{{mainData.last_name}}' disabled /> </td>                                                   
							<td><label for='birth_date'>Date of Birth: </label></td>
							<td><input type='text' id='birth_date' name='birth_date' value='{{mainData.birth_date}}' disabled/></td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td><input type='text' id='gender' name='gender' value='{{mainData.gender}}' disabled /></td>
						</tr>
						<tr>
							<td>Civil Status:</td>
							<td><input type='text' id='civil_status' name='civil_status' value='{{mainData.civil_status}}' disabled /></td>
							<td>Religion:</td>
							<td><input type='text' id='religion' name='religion' value='{{mainData.religion}}' disabled /></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><input type='text' id='address' name='address' value='{{mainData.address}}' disabled /></td>
							<td>Place of Birth:</td>
							<td><input type='text' id='place_of_birth' name='place_of_birth' value='{{mainData.place_of_birth}}' disabled /></td>
						</tr> 
						<tr> 
							<td>Entrance Data:</td>
							<td><input type='text' id='entrance_data' name='entrance_data' value='{{mainData.entrance_data}}' disabled /></td>
							<td>Remarks</td>
							<td><input type='text' id='remarks' name='remarks' value='{{mainData.remarks}}' disabled /></td>
						</tr>
						<tr>  
							<td><label for='username'>Account Username:</label></td>
							<td><input type='text' id='username' name='username' value='{{mainData.username}}' disabled/></td>
							<td><label for='password'>Account Password: </label></td>
							<td><input type='text' id='password' name='password' value='{{mainData.string_password}}' disabled/></td>
							
						</tr>  
						
						<tr>
							<td><input type='hidden' name='id' value='{{mainData.student_id}}' /></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						
						<tr>
							<td class='action'><input type='submit' value='Update'/></td>
							<td><button class='cancel'>Cancel</button></td>
							<td><input type='reset' value='Reset'/></td>
							<td></td>
						</tr>
					</table>
				</form>
		";
		
		$update_academic_data_action = base_url() . "index.php/". $this->table ."/update_student_academic_data";
		
		$data['content'] .= "
			
				<form action='{$update_academic_data_action}' method='post' id='academic_data_form' class='full_width_3'>
					<h2>Subjects</h2>
					<abbr title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
					
					<div class='left'>
						<label for='school'>School</label>
						<p><input type='text' name='school' id='school' value='{{mainData.school}}' disabled/></p>
					</div>
					
					<div class='right'>
						<label for='course'>Course</label>
						<p><input type='text' name='course' id='course' value='{{mainData.course}}' disabled/></p>
					</div>
					
					<div class='clear'></div>   
					
		";
		
		$data['content'] .= "
					<table>
						<thead>
							<tr>
								<th><input type='checkbox' class='main_check' disabled/></th>
								<th>Course No.</th>
								<th>Descriptive Title</th>
								<th>Credit</th>
								<th>Grade</th>
								<th>Comp.</th>
								<th>Status</th>
							</tr>  
						</thead>
		";
		
		/*$data['content'] .= "
				<tr ng-repeat='subject in subjects'>
					<td><input type='checkbox' name='subject_id_delete[]' value='{{subject.id}}' class='subcheck' disabled='disabled'/></td>
					<td>{{subject.subject_semester}}</td>
					<td>{{subject.course_no}}</td>
					<td>{{subject.descriptive_title}}</td>
					<td>{{subject.credit}}</td>
					<td><input type='text' name='grade[]' class='grade' value='{{subject.subject_grade}}' maxlength='4' disabled='disabled'/></td>
					<td><input type='text' name='comp[]' class='comp' value='{{subject.comp}}' maxlength='4' disabled='disabled'/></td>
					<td>{{subject.status}}</td>
					<input type='hidden' name='student_id' value='{{academicData.id}}' />
					<input type='hidden' name='subject_id_update[]' value='{{subject.id}}' />
				</tr>
		";*/    
		
		$data['content'] .= "
			
			<tbody ng-repeat='(key, values) in subjects'>
				<tr> 
					<td style='padding-top: 30px; text-align: center; font-weight: bold;' colspan='8'>{{key}}</td>
				</tr>
				<tr ng-repeat='value in values'>  
					<td><input type='checkbox' name='subject_id_delete[]' value='{{value.id}}' class='subcheck' disabled='disabled'/></td>
					<td>{{value.course_no}}</td>
					<td>{{value.descriptive_title}}</td>
					<td>{{value.credit}}</td>
					<td><input type='text' name='grade[]' class='grade' value='{{value.grade}}' maxlength='4' disabled='disabled'/></td>
					<td><input type='text' name='comp[]' class='comp' value='{{value.comp}}' maxlength='4' disabled='disabled'/></td>
					<td>{{value.status}}</td>
					<input type='hidden' name='subject_id_update[]' value='{{value.id}}' />
				</tr>
			</tbody>        
		
		";
		
		
		$data['content'] .= "
						<tr>
							<td><input type='submit' id='academic_delete' name='action' value='Delete' /></td>
							<td><input type='submit' id='academic_update' name='action' value='Update' /></td>
							<td><input type='submit' id='add_subject' name='action' value='Add' /></td>
							<td><a class='academic_cancel' href='#'>Cancel</a></td>
							<td colspan='2'><input type='reset' value='Clear' /></td>
						</tr>
					</table>
				</form>
		";         
		
		
		$data['content'] .= "
				<button ng-click='getSubjects()' class='student_angular_trigger'>Trigger Student Angular</button>
				<button ng-click='getMainData()' class='student_angular_trigger'>Trigger Student Angular</button>
			</div> <!-- end ng-controller-->
		";
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
		
	}
	
	function update_student_main_data() {
	
		$id = $this->input->post('id');
		
		$student_data = array(
			"first_name" => trim($this->input->post('first_name')),
			"last_name" => trim($this->input->post('last_name')),
			"middle_name" => trim($this->input->post('middle_name')),  
			"username" => trim($this->input->post('username')),
			"string_password" => $this->input->post('password'),
			"password" => md5($this->input->post('password'))
		);
		
		$students_others_data = array(
			"gender" => trim($this->input->post('gender')),
			"birth_date" => trim($this->input->post('birth_date')),
			"civil_status" => trim($this->input->post('civil_status')),
			"religion" => trim($this->input->post('religion')),
			"address" => trim($this->input->post('address')), 
			"place_of_birth" => trim($this->input->post('place_of_birth')),  
			"entrance_data" => trim($this->input->post('entrance_data')),   
			"remarks" => trim($this->input->post('remarks'))
		);
		
		$update_student_data = $this->students_model->update_student($id, $student_data);
		$update_students_others_data = $this->students_model->update_students_others($id, $students_others_data);
		
		$data['status'] = true;
		
		echo json_encode($data);	
	}
	
	function update_student_academic_data() {
		
		$school = $this->input->post('school');
		$course = $this->input->post('course');
		
		$subject_id_delete = $this->input->post('subject_id_delete'); // this one is an array
		$subject_id_update = $this->input->post('subject_id_update'); // this one is an array
		$grade = $this->input->post('grade'); // this one is an array
		$comp = $this->input->post('comp');
		
		$action = $this->input->post('action');
		
		if($action == "Update") {
			
			for($u = 0; $u < count($subject_id_update); $u++) {
				$grade_id_to_update =  $grade[$u];
				$subject_id_to_update = $subject_id_update[$u];
				$comp_value_to_update = $comp[$u];
				
				$update_student_grade_by_subject_id = $this->students_model->update_student_grade_and_comp_by_subject_id($grade_id_to_update, $comp_value_to_update, $subject_id_to_update);                 
				
				$get_student_grade = $this->students_model->get_students_grade_by_subject_id($subject_id_to_update);
				
				foreach($get_student_grade as $row_g) {
					
					$current_grade = trim($row_g->grade);
					$comp_grade = trim($row_g->comp);
					
					if($current_grade == "INC") {
					
						if($comp_grade != "") {
							
							
							if($comp_grade <= 3) {
								
								$get_subject_credit = $this->students_model->get_subject_main_credit_by_grade_subject_id($subject_id_to_update);
								foreach($get_subject_credit as $row_f) {
									$credit = $row_f->credit;
								}
								
								$grade_data = array(
									"earned_credit" => $credit, 
									"status" => "passed"
								);
							
							} else {
							
								$grade_data = array(
									"earned_credit" => 0, 
									"status" => "failed"
								);
								
							}						
						
							
							
						} else {
							$grade_data = array(
								"earned_credit" => 0, 
								"status" => "incomplete"
							);   
						}
						
					}elseif($current_grade == 0) {
					
						$grade_data = array(
							"earned_credit" => 0, 
							"status" => "enrolled"
						);
						
					} elseif($current_grade <= 3) {
					
						$get_subject_credit = $this->students_model->get_subject_main_credit_by_grade_subject_id($subject_id_to_update);
						foreach($get_subject_credit as $row_c) {
							$credit = $row_c->credit;
						}
						
						$grade_data = array(
							"earned_credit" => $credit, 
							"status" => "passed"
						);
					
					} else {
						$grade_data = array(
							"earned_credit" => 0, 
							"status" => "failed"
						);
					}
					
					$update_student_grade = $this->students_model->update_student_grade_and_etc_by_subject_id($grade_data, $subject_id_to_update);
				
				}
				
			
			
			}
			
			$data['update_status'] = true;
		}
		
		if($action == "Delete") {
			$delete_student_subject_id = $this->global_model->delete('students_subject', $subject_id_delete);
			$delete_student_grade_by_subject_id = $this->students_model->delete_student_grade_by_subject_id($subject_id_delete);
			
			$data['delete_status'] = true;
		}
	
		echo json_encode($data);
	
	} 
	
	function get_student_academic_data_via_angular() {
		
		$id = $this->input->get('id');
		
		$data['id'] = $id;
		
		$data['subjects'] = array();
		
		$get_student_subject_by_student_id = $this->students_model->get_student_subject_by_student_id($id);
		
		foreach($get_student_subject_by_student_id as $row_subject) {
			
			$subject_id = $row_subject->id;
			$subject = trim($row_subject->subject);
			$course_id = $row_subject->course_id;
			$term_id = $row_subject->term_id;
			
			// get term by term id
			$get_term_by_id = $this->terms_model->get_term_by_id($term_id);
			
			foreach($get_term_by_id as $row_term) {
				$term = ucwords($row_term->term);
				$semester = ucwords($row_term->semester);
			}
			
			//get subject by descriptive title
			$get_subject_by_descriptive_title = $this->subjects_model->get_subject_by_descriptive_title($subject);
			
			foreach($get_subject_by_descriptive_title as $row_main_subject) {
				$subject_course_no = $row_main_subject->course_no;
				$subject_credit = $row_main_subject->credit;
			}
			
			$get_subject_grade = $this->students_model->get_student_earned_credit_subject_grade_and_status_by_student_subject_id($subject_id);
		
			foreach($get_subject_grade as $row_grade) {
				$earned_credit = $row_grade->earned_credit;
				$subject_grade = $row_grade->grade;
				$comp = $row_grade->comp;
				$status = $row_grade->status;
			}
			
			$data['subjects'][] = array(
				"id" => $subject_id,
				"subject_semester" => $term . " year - " . $semester . " semester", 
				"course_no" => $subject_course_no,
				"descriptive_title" => $subject,
				"credit" => $earned_credit,
				"subject_grade" => $subject_grade,  
				"comp" => $comp, 
				"status" => ucwords($status)
			);
			
		}
		
		echo json_encode($data);
		
	} // end main function       
	
	function get_student_academic_data_group_by_school_year() {
	
		$id = $this->input->get('id');  
		
		$data['subjects'] = array();  
		
		$get_school_year = $this->students_model->get_student_academic_school_year_by_student_id($id);  
	
		foreach($get_school_year as $row) {
			
			$school_year = $row->school_year;    
			$term_value = $row->term;  
			$semester_value = $row->semester;  
			
			$term_semester_school_year = ucfirst($term_value) . " Year - " . ucfirst($semester_value) . " Semester (" . $school_year . ")"; 
			
			$get_student_academic_data = $this->students_model->get_student_academic_data_by_student_id_and_school_year($id, $school_year);
			for($i = 0; $i < count($get_student_academic_data); $i++) {
			
			
				if($get_student_academic_data[$i]['semester'] == "first") {
					$semester = "First";
				}  
				
				if($get_student_academic_data[$i]['semester'] == "second") {
					$semester = "Second";
				}   
				
				$term_name = ucfirst($get_student_academic_data[$i]['term']) . " Year";  
				$semester_name = $semester . " Semester";   
				// this school year is at the top    
				
				$student_subject_id = $get_student_academic_data[$i]['id'];
				$course_no = $get_student_academic_data[$i]['course_no']; 
				$descriptive_title = $get_student_academic_data[$i]['descriptive_title'];       
				$credit = $get_student_academic_data[$i]['earned_credit'];     
				$grade = $get_student_academic_data[$i]['grade'];  
				$comp = $get_student_academic_data[$i]['comp']; 
				$status = $get_student_academic_data[$i]['status']; 
				
				
				$data['subjects'][$term_semester_school_year][] = array(
					'id' => $student_subject_id, 
					'term' => $term_name, 
					'semester' => $semester_name, 
					'school_year' => $school_year,  
					'course_no' => $course_no, 
					'descriptive_title' => $descriptive_title, 
					'credit' => $credit, 
					'grade' => $grade,   
					'comp' => $comp, 
					'status' => $status
				);
			
			}
		
		}
		
		echo json_encode($data); 
		
	} 
	
	function get_student_main_data_via_angular() {
		
		$id = $this->input->get('id');
		
		$data['id'] = $id;
		
		$get_student_main_data_by_id = $this->students_model->get_student_main_data_by_id($id);
		
		foreach($get_student_main_data_by_id as $row) {
			$data['student_id'] = $row->id;
			$data['first_name'] = trim($row->first_name);
			$data['last_name'] = trim($row->last_name);
			$data['middle_name'] = trim($row->middle_name);
			$data['student_type'] = trim($row->student_type);
			$data['username'] = trim($row->username);
			$data['string_password'] = trim($row->string_password);
			$data['password'] = trim($row->password);
			$data['gender'] = trim($row->gender);
			$data['birth_date'] = trim($row->birth_date);
			$data['civil_status'] = trim($row->civil_status);
			$data['religion'] = trim($row->religion);
			$data['address'] = trim($row->address);
			$data['place_of_birth'] = trim($row->place_of_birth);
			$data['entrance_data'] = trim($row->entrance_data);
			$data['remarks'] = trim($row->remarks);
			$data['school'] = trim($row->school);
			$data['course'] = trim($row->course);
			$data['school_id'] = $row->school_id;  
			$data['file_name'] = $row->file_name;
		}
		
		echo json_encode($data);
	}
	
	function get_student_subjects() {
	
		$id = $this->input->get('id');   
		$current_student_id = $this->input->get('current_student_id');  
		
		$data = array();
		
		$get_student_type_by_student_id = $this->students_model->get_student_type_by_student_id($current_student_id);  
		foreach($get_student_type_by_student_id as $row_a) {
			$student_type = $row_a->student_type;  
			$enrolled_term_id = $row_a->enrolled_term_id;
		}   
		
		if($student_type == "regular") {
			$other_type = "irregular";
		} else if($student_type == "irregular") {
			$other_type = "regular";
		}
	
		$studentTypeValue = ucfirst($student_type);
		$otherTypeValue =  ucfirst($other_type);
		
		$get_term = $this->terms_model->get_term_by_id($enrolled_term_id);
		foreach($get_term as $row_b) {
			$term_id_enrolled = $row_b->id;
			$term_enrolled = ucfirst($row_b->term);  
			$semester_enrolled = ucfirst($row_b->semester);
		}   
		
		$current_semester_enrolled = $term_enrolled . " year - " . $semester_enrolled . " semester";
	
		/*$data['student_type'] = "
			<label for='student_type'>Student Type</label>
			<select name='student_type' id='student_type'>
				<option value='{$student_type}'>{$studentTypeValue}</option>  
				<option value='{$other_type}'>{$otherTypeValue}</option>  
			</select>   
			<p><span class='current_semester'>(Current Semester)</span> {$current_semester_enrolled}</p>  
			<input type='hidden' name='term_id_enrolled' id='term_id_enrolled' value='{$term_id_enrolled}' />
		";*/     
		
		$data['student_type'] = "
			<p><span class='current_semester'>(Current Semester Enrolled)</span> {$current_semester_enrolled}</p>  
			<input type='hidden' name='term_id_enrolled' id='term_id_enrolled' value='{$term_id_enrolled}' />
		";
		
		
		if(isset($id) && $id != NULL) {
			
			$get_course_subjects_by_course_id = $this->course_subjects_model->get_course_subjects_by_course_id($id);
			
			if($get_course_subjects_by_course_id != NULL) {
				
				// get terms then arrange it by order
				$get_terms = $this->terms_model->get_terms_with_order();
				
				$data['subjects'] = "";
				
				foreach($get_terms as $row_term) {
					
					$term_id = $row_term->id;
					$term = ucwords($row_term->term);
					$semester = ucwords($row_term->semester);
					$order = $row_term->order;
				
					$get_course_subjects = $this->course_subjects_model->get_course_subjects_by_term_id_and_course_id($term_id, $id);
					
					if($get_course_subjects != NULL) {
					
						$this->current_num_row = count($get_course_subjects);
						$this->dummy_num_row = count($get_course_subjects);
						
						foreach($get_course_subjects as $row) {
						
							$subject_id = $row->subject_id;
							
							//$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id($subject_id);
							
							$get_subject_by_subject_id = $this->subjects_model->get_subject_by_subject_id_and_course_id_join_course_subjects($subject_id, $id);
					
							foreach($get_subject_by_subject_id as $row_a) {
								
								$course_no = $row_a->course_no;
								$descriptive_title = $row_a->descriptive_title;
								$current_term_id = $row_a->term_id;
								$course_subject_id = $row_a->course_subject_id;
								
								$this->process_decision_to_insert_semester_title();
								
								if($this->added_semester_title_status == false) {
									$data['subjects'] .= "
										<h2>{$term} Year </h2>
										<p class='semester'>{$semester} Semester</p>
									";
									
									$this->dummy_num_row -= 1;
									$this->added_semester_title_status == true;
								}
								
								$is_subject_exists = $this->students_model->revised_is_subject_exists($course_subject_id, $current_student_id);
								
								if($is_subject_exists > 0) {
								
									$get_student_subject_status = $this->students_model->get_student_grade_status_by_course_subject_id($course_subject_id);
								
									foreach($get_student_subject_status as $row_s) {
										$subject_status = trim($row_s->status);
									}
									
									if($subject_status == "failed") {
										$data['subjects'] .= "
											<p><input type='checkbox' class='subjects editable {$current_term_id}' name='subject[]' value='{$subject_id}'  />{$course_no} {$descriptive_title}</p>
										";
									
									} else {
										$data['subjects'] .= "
											<p><input type='checkbox' class='subjects non_editable {$current_term_id}' name='subject[]' value='{$subject_id}' checked disabled />{$course_no} {$descriptive_title}</p>   
										";
									}
								
								} else {
									$data['subjects'] .= "
										<p><input type='checkbox' class='subjects editable {$current_term_id}' name='subject[]' value='{$subject_id}' />{$course_no} {$descriptive_title}</p>
									";
								}
							
							}
						}
						
					} else {
						$data['subjects'] .= "
							<h2>{$term} Year</h2>
							<p class='semester'>{$semester} Semester</p>
						";
						
						
						$data['subjects'] .= "<p class='no_subject'>No subject added in this semester</p>";
					}
					
				} // end foreach loop
			
			
			} else {
				$data['subjects'] = "
					<h2>Subjects</h2>
					<p class='center'>No subjects added in the selected course. Please update subjects in the course module.</p>
				";
			}
			
		} else {
			$data['subjects'] = "
				<h2>Subjects</h2>
				<p class='center'>Please go back and select course first.</p>
			";
		}   
		

		echo json_encode($data);
	}     
	
	function add_subject() {
	
		/*$start_year = date('Y');
		$end_year = date('Y', strtotime('+1 years'));
		$school_year = $start_year . "-" . $end_year;*/ 
		
		$school_year = $this->input->post('school_year');
		
		
		$student_id = $this->input->post("student_id");
		$term_id = $this->input->post('term_id');
		
		$get_students_course_course_id_by_student_id = $this->students_model->get_students_course_course_id_by_student_id($student_id);
		
		foreach($get_students_course_course_id_by_student_id as $row_s) {
			$course_id = $row_s->id;
		}
	
		$set_subject_id = $this->input->post("subject");
		
		$insert_data = array();
		
		$insert_grade_data = array();
		
		for($i = 0; $i < count($set_subject_id); $i++ ) {
			
			$get_subjects = $this->subjects_model->get_subject_by_subject_id($set_subject_id[$i]);
			
			foreach($get_subjects as $row_a) {
				$descriptive_title = $row_a->descriptive_title;
			}
			
			$get_course_subject_id = $this->course_subjects_model->get_course_subject_id_by_subject_id($set_subject_id[$i]);
			foreach($get_course_subject_id as $row_c) {
				$course_subject_id = $row_c->id;
			}
			
			$subject_data = array(
				"subject" => $descriptive_title,
				"course_id" => $course_id,
				"student_id" => $student_id,
				"term_id" => $term_id,
				"school_year" => $school_year,
				"course_subject_id" => $course_subject_id
			);
			
			// insert subject
			$insert_subject = $this->global_model->add("students_subject", $subject_data);
			
			// get subject id by descriptive title 
			$get_new_subject_id = $this->students_model->get_students_subject_subject_id_by_descriptive_title($descriptive_title);
			foreach($get_new_subject_id as $row_e) {
				$subject_id = $row_e->id;
			}
			
			$grade_data = array(
				"earned_credit" => 0,
				"grade" => 0,
				"status" => "enrolled", 
				"subject_id" => $subject_id
			);
			
			// insert grade
			
			$insert_grade = $this->global_model->add("students_grade", $grade_data);
			
		}
		
		$data['status'] = true;
		
		echo json_encode($data);
	
	}
	
	function generate_transcript() {
	
		$student_id = $this->input->get('id');
		$get_student_data = $this->students_model->get_transcript_data_by_student_id($student_id);
		
		foreach($get_student_data as $row) {
			$students_course_id = $row->students_course_id;   
			
			$data['first_name'] = ucwords($row->first_name);
			$data['last_name'] = ucwords($row->last_name);
			$data['middle_name'] = ucwords($row->middle_name);
			$data['gender'] = ucwords($row->gender);
			$data['birth_date'] = ucwords($row->birth_date);
			$data['civil_status'] = ucwords($row->civil_status);  
			$data['religion'] = ucwords($row->religion);  
			$data['address'] =  ucwords($row->address);
			$data['place_of_birth'] = ucwords($row->place_of_birth);    
			$data['entrance_data'] = ucwords($row->entrance_data); 
			$data['remarks'] = ucwords($row->remarks);
			$data['school'] = ucwords($row->school);  
			$data['course'] = ucwords($row->course);  
			$data['students_course_id'] = $row->students_course_id;  
			
		}       
	
		$get_profile_image = $this->students_model->get_student_profile_image_by_student_id($student_id);
		if($get_profile_image != NULL) {
			
			foreach($get_profile_image as $row_f) {
				$data['file_name'] = $row_f->file_name;
			} 
			
		} else {
			$data['file_name'] = "blank.png";
		}
		
		$data['subjects'] = "";
	
		$get_terms = $this->terms_model->get_terms_with_order();
		foreach($get_terms as $row_term) {
			$term_id = $row_term->id;
			$term_name = strtoupper($row_term->term . " Year");   
			
			if($row_term->semester == "first") {
				$semester = "1ST";
			}  
			
			if($row_term->semester == "second") {
				$semester = "2nd";
			} 
			
			$semester_name = strtoupper($semester . " Semester");
	
			$get_term_school_year = $this->students_model->get_students_school_year_by_term_id_and_student_id($term_id, $student_id);
	
			foreach($get_term_school_year as $row_s) {
				$school_year = $row_s->school_year;
			
				$get_students_subject_by_term_id_and_school_year = $this->students_model->get_students_subject_by_term_id_and_school_year_and_student_id($term_id, $school_year, $student_id);
				$row_span = count($get_students_subject_by_term_id_and_school_year);
				
				$last_row = $row_span - 1;
				
				for($i = 0; $i < count($get_students_subject_by_term_id_and_school_year); $i++) {
					
					$course_no = $get_students_subject_by_term_id_and_school_year[$i]['course_no'];
					$descriptive_title = $get_students_subject_by_term_id_and_school_year[$i]['subject'];
					$final = $get_students_subject_by_term_id_and_school_year[$i]['grade'];
					$comp = $get_students_subject_by_term_id_and_school_year[$i]['comp'];  
					$credit = $get_students_subject_by_term_id_and_school_year[$i]['earned_credit'];
					
					if($i == 0) {
						$data['subjects'] .= '
							<tr>
								<td style="border-bottom: 1px solid #000;" width="100" rowspan="'. $row_span .'">
									' . $term_name . '<br />' .
									$semester_name . ' <br />' .
									$school_year . '   
								</td>
								<td width="72">' . $course_no . '</td>
								<td width="235">' . $descriptive_title . '</td>
								<td width="50">' . $final . '</td>
								<td width="55">' . $comp . '</td>
								<td width="55">' . $credit . '</td>
							</tr>
						';
					} else if($i == $last_row) {
						$data['subjects'] .= '
							<tr>
								<td style="border-bottom: 1px solid #000;" width="72">' . $course_no . '</td>
								<td style="border-bottom: 1px solid #000;" width="235">' . $descriptive_title . '</td>
								<td style="border-bottom: 1px solid #000;" width="50">' . $final . '</td>
								<td style="border-bottom: 1px solid #000;" width="55">' . $comp . '</td>
								<td style="border-bottom: 1px solid #000;" width="55">' . $credit . '</td>
							</tr>
						';
					} else {
		
						$data['subjects'] .= '
							<tr>
								<td width="72">' . $course_no . '</td>
								<td width="235">' . $descriptive_title . '</td>
								<td width="50">' . $final . '</td>
								<td width="55">' . $comp . '</td>
								<td width="55">' . $credit . '</td>
							</tr>
						';
					}
		
				}  
				
			} // end foreach loop
			
		} // end foreach loop  in getting terms with order 
	

		$this->load->helper('pdf_helper');
		$this->load->view('transcript_view', $data);
		
	}   
	
	function add_subject_to_regular() {
		
		$student_id = $this->input->get('student_id');   
		$data['subjects_added'] = array();
		
		$get_student_prime_data = $this->students_model->get_student_join_student_course_by_student_id($student_id);  
		foreach($get_student_prime_data as $row) {
			
			$student_course_course_id = $row->student_course_course_id;
			$student_type = $row->student_type;   
			$enrolled_term_id = $row->enrolled_term_id;   
			$course = $row->course;  
			$main_course_id = $row->id;
		}   
		
		if($student_type == "regular") {
		
			$get_course_subjects_join_to_subjects_by_term_id_and_course_id = $this->course_subjects_model->get_course_subjects_join_to_subjects_by_term_id_and_course_id($enrolled_term_id, $main_course_id);
			foreach($get_course_subjects_join_to_subjects_by_term_id_and_course_id as $row_a) {
				
				$course_subject_id = $row_a->id; 
				$subject_description = $row_a->descriptive_title;
				$check = $this->students_model->check_semester_subject_enrolled_to_student($enrolled_term_id, $course_subject_id, $student_id);
				
				if($check == NULL) {
			
					$start_year = date('Y');
					$end_year = date('Y', strtotime('+1 years'));
					$school_year = $start_year . "-" . $end_year;  
					
					$subject_data = array(
						"subject" => $subject_description,
						"course_id" => $student_course_course_id, 
						"student_id" => $student_id, 
						"term_id" => $enrolled_term_id, 
						"school_year" => $school_year,
						"course_subject_id" => $course_subject_id
					);      
					
					// insert subject
					$insert_subject = $this->global_model->add("students_subject", $subject_data);
					
					// get subject id by descriptive title 
					$get_new_subject_id = $this->students_model->get_students_subject_subject_id_by_descriptive_title($subject_description);
					foreach($get_new_subject_id as $row_e) {
						$subject_id = $row_e->id;
					}
					
					$grade_data = array(
						"earned_credit" => 0,
						"grade" => 0,
						"status" => "enrolled", 
						"subject_id" => $subject_id
					);
					
					// insert grade
					
					$insert_grade = $this->global_model->add("students_grade", $grade_data);
					
					$data['subjects_added'][] = $subject_description;
				
				}

			} // end foreach
		
		} // end if regular
		
		
		$data['status'] = true;  
		echo json_encode($data);
	
	}

	function test() {
		
		$student_id = 27;
		$get_student_data = $this->students_model->get_transcript_data_by_student_id($student_id);
		
		//echo "<p>Below is for student properties</p>";
		//$this->debug($get_student_data);
		foreach($get_student_data as $row) {
			$students_course_id = $row->students_course_id;   
			
			$data['first_name'] = ucwords($row->first_name);
			$data['last_name'] = ucwords($row->last_name);
			$data['middle_name'] = ucwords($row->middle_name);
			$data['age'] = ucwords($row->age);
			$data['gender'] = ucwords($row->gender);
			$data['birth_date'] = ucwords($row->birth_date);
			$data['civil_status'] = ucwords($row->civil_status);  
			$data['religion'] = ucwords($row->religion);  
			$data['address'] =  ucwords($row->address);
			$data['place_of_birth'] = ucwords($row->place_of_birth);    
			$data['entrance_data'] = ucwords($row->entrance_data); 
			$data['remarks'] = ucwords($row->remarks);
			$data['school'] = ucwords($row->school);  
			$data['course'] = ucwords($row->course);  
			$data['students_course_id'] = $row->students_course_id;
		}       
		
		$data['subjects'] = "<table class='grade' cellpadding='5'>";
		
		//echo "<p>Below is for the terms</p>";
		$get_terms = $this->terms_model->get_terms_with_order();
		//$this->debug($get_terms);
		foreach($get_terms as $row_term) {
			$term_id = $row_term->id;
			$term_name = $row_term->term . " Year";   
			$semester_name = $row_term->semester . " Semester";
		
			//echo "<p>Below is students subject by term and year</p>";
			$get_term_school_year = $this->students_model->get_students_school_year_by_term_id($term_id);
			//$this->debug($get_term_school_year);
	
			foreach($get_term_school_year as $row_s) {
				$school_year = $row_s->school_year;
				
				//echo "<p>Below is for school year subjects</p>";
				$get_students_subject_by_term_id_and_school_year = $this->students_model->get_students_subject_by_term_id_and_school_year($term_id, $school_year);
				//$this->debug($get_students_subject_by_term_id_and_school_year);
			
				for($i = 0; $i < count($get_students_subject_by_term_id_and_school_year); $i++) {
					
					$course_no = $get_students_subject_by_term_id_and_school_year[$i]['course_no'];
					$descriptive_title = $get_students_subject_by_term_id_and_school_year[$i]['subject'];
					$final = $get_students_subject_by_term_id_and_school_year[$i]['grade'];
					$comp = $get_students_subject_by_term_id_and_school_year[$i]['comp'];  
					$credit = $get_students_subject_by_term_id_and_school_year[$i]['earned_credit'];
					
					if($i == 0) {
						$data['subjects'] .= "
							<tr>
								<td  class='main' rowspan='3'>
									{$term_name} <br />
									{$semester_name} <br />
									{$school_year}
								</td>
								<td>{$course_no}</td>
								<td>{$descriptive_title}</td>
								<td>{$final}</td>
								<td>{$comp}</td>
								<td>{$credit}</td>
							</tr>
						";
					} else {
		
						$data['subjects'] .= "
							<tr>
								<td>{$course_no}</td>
								<td>{$descriptive_title}</td>
								<td>{$final}</td>
								<td>{$comp}</td>
								<td>{$credit}</td>
							</tr>
						";
					}
		
				}  
				
				
			
			} // end foreach loop
			
		} // end foreach loop  
		
		$data['subjects'] .= "</table>";   
		
		echo json_encode($data);
		
	} // end function
	

} // end class







































