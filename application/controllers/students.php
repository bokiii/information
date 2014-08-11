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
	
	function __construct() {
		parent::__construct();
		$this->load->model('school_courses_model');
		$this->load->model('courses_model');
		$this->load->model('course_subjects_model');
		$this->load->model('subjects_model');
		$this->load->model('students_model');
		$this->load->model('schools_model');
		$this->load->model('terms_model');
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
		
		// get terms below 
		
		$get_terms = $this->global_model->get('terms');
		
		$terms_data = array();
		
		if($get_terms != NULL) {
			foreach($get_terms as $row_terms) {
				$terms_data[] = array(
					"id" => $row_terms->id,
					"term" => ucwords($row_terms->term),
					"semester" => ucwords($row_terms->semester),
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
									<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester - {$terms_data[$i]['school_year']}</option>
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
						<td>
							<select name='age' id='age'>
								<option value>Select</option>
								<option value='15'>15</option>
								<option value='16'>16</option>
								<option value='17'>17</option>
								<option value='18'>18</option>
								<option value='19'>19</option>
								<option value='20'>20</option>
								<option value='21'>21</option>
								<option value='22'>22</option>
								<option value='23'>23</option>
								<option value='24'>24</option>
								<option value='25'>25</option>
								<option value='26'>26</option>
								<option value='27'>27</option>
								<option value='28'>28</option>
								<option value='29'>29</option>
								<option value='30'>30</option>
								<option value='31'>31</option>
								<option value='32'>32</option>
								<option value='33'>33</option>	
							</select>
						</td>
						<td><label for='gender'>Gender:</label></td>
						<td>
							<select name='gender' id='gender'>
								<option value>Select</option>
								<option value='male'>Male</option>
								<option value='female'>Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for='birth_date'>Birthdate:</label></td>
						<td><input type='text' name='birth_date' id='birth_date' /></td>
						<td><label for='civil_status'>Civil Status:</label></td>
						<td>
							<select name='civil_status' id='civil_status'>
								<option value>Select</option>
								<option>Single</option>
								<option>Married</option>
								<option>Widowed</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for='religion'>Religion:</label></td>
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
			"address" => $this->input->post('address'),
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
		
		$birth_date = trim($this->input->post('birth_date'));
		$set_birth_date = str_replace("/", "-", $birth_date);
		
		$student_others_data = array(
			"age" => trim($this->input->post('age')),
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
		
		// get all subjects by students via student_id
		
		$student_subjects = $this->students_model->get_subject_ids_by_student_id($student_id);
		
		if($student_subjects != NULL) {
			
			foreach($student_subjects as $row_subject) {
				$data = array(
					'grade' => 0,
					'subject_id' => $row_subject->id
				); 
				
				$this->students_model->add_student_grade($data);
			}
		
		}
		
	
		redirect('students');
		
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
	
	function manage_students() {
		
		// search table 
		
		$data['search_table'] = $this->table;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$id = $this->input->get('id');
			
		// get students main data by id
	
		$get_student_main_data_by_id = $this->students_model->get_student_main_data_by_id($id);
		
		foreach($get_student_main_data_by_id as $row) {
			$student_id = $row->id;
			$first_name = $row->first_name;
			$last_name = $row->last_name;
			$middle_name = $row->middle_name;
			$age = $row->age;
			$gender = $row->gender;
			$birth_date = $row->birth_date;
			$civil_status = $row->civil_status;
			$religion = $row->religion;
			$address = $row->address;
			$school = $row->school;
			$course = $row->course;
			$school_id = $row->school_id;
		}
		
		$update_main_data_action = base_url() . "index.php/". $this->table ."/update_student_main_data";
		$edit_image = base_url() . "images/modify.png";
		
		$data['content'] ="
			<form action='{$update_main_data_action}' method='post' id='main_data_form' class='full_width_3'>
				<h2>{$first_name} {$middle_name} {$last_name}</h2>
				<abbr title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
				<table>
					<tr>
						<td><label for='first_name'>Name:</label></td>
						<td><input type='text' id='first_name' name='first_name' value='{$first_name}' disabled /> <input type='text' id='middle_name' name='middle_name' value='{$middle_name}' disabled /> <input type='text' id='last_name' name='last_name' value='{$last_name}' disabled /> </td>                                                   
						<td><label for='birth_date'>Date of Birth: </label></td>
						<td><input type='text' id='birth_date' name='birth_date' value='{$birth_date}' disabled/></td>
					</tr>
					<tr>
						<td>Age:</td>
						<td><input type='text' id='age' name='age' value='{$age}' disabled /></td>
						<td>Gender:</td>
						<td><input type='text' id='gender' name='gender' value='{$gender}' disabled /></td>
					</tr>
					<tr>
						<td>Civil Status:</td>
						<td><input type='text' id='civil_status' name='civil_status' value='{$civil_status}' disabled /></td>
						<td>Religion:</td>
						<td><input type='text' id='religion' name='religion' value='{$religion}' disabled /></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><input type='text' id='address' name='address' value='{$address}' disabled /></td>
						<td><input type='hidden' name='id' value='{$student_id}' /></td>
						<td></td>
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
		
		// get students subject
		$data['subjects'] = array();
		
		$get_student_subject_by_student_id = $this->students_model->get_student_subject_by_student_id($id);
		
		foreach($get_student_subject_by_student_id as $row_subject) {
			
			$data['subjects'][] = array(
				"id" => $row_subject->id,
				"subject" => $row_subject->subject,
				"course_id" => $row_subject->course_id,
				"student_id" => $row_subject->student_id,
				"term_id" => $row_subject->term_id
			);
		}
		
		
		$update_academic_data_action = base_url() . "index.php/". $this->table ."/update_student_academic_data";
		
		$data['content'] .= "
			<form action='{$update_academic_data_action}' method='post' id='academic_data_form' class='full_width_3'>
				<h2>Subjects</h2>
				<abbr title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
				
				<div class='left'>
					<label for='school'>School</label>
					<p><input type='text' name='school' id='school' value='{$school}' disabled/></p>
				</div>
				
				<div class='right'>
					<label for='course'>Course</label>
					<p><input type='text' name='course' id='course' value='{$course}' disabled/></p>
				</div>
				
				<div class='clear'></div>
		";
		
		$data['content'] .= "
				<table>
				<tr>
					<th><input type='checkbox' class='main_check' disabled/></th>
					<th>Term</th>
					<th>Course No.</th>
					<th>Descriptive Title</th>
					<th>Credit</th>
					<th>Grade</th>
				</tr>
		";
		
			for($i = 0; $i < count($data['subjects']); $i++) {
				
				$subject_id = $data['subjects'][$i]['id'];
				$subject_subject = ucwords($data['subjects'][$i]['subject']);
				$subject_course_id = $data['subjects'][$i]['course_id'];
				$subject_student_id = $data['subjects'][$i]['student_id'];
				$subject_term_id = $data['subjects'][$i]['term_id'];
			
				// get term by term id
				$get_term_by_id = $this->terms_model->get_term_by_id($subject_term_id);
				
				//echo $subject_id . "<br />";
				
				
				foreach($get_term_by_id as $row_term) {
					$term = ucwords($row_term->term);
					$semester = ucwords($row_term->semester);
					$school_year = ucwords($row_term->school_year);
				}
				
				//get subject by descriptive title
				$get_subject_by_descriptive_title = $this->subjects_model->get_subject_by_descriptive_title($subject_subject);
				
				foreach($get_subject_by_descriptive_title as $row_subject) {
					$subject_course_no = $row_subject->course_no;
					$subject_descriptive_title = $row_subject->descriptive_title;
					$subject_credit = $row_subject->credit;
					$subject_term_id = $row_subject->term_id;
				}
				
				// get student grade by subject_id 
				
				$get_subject_grade = $this->students_model->get_student_subject_grade_by_student_subject_id($subject_id);
				
				foreach($get_subject_grade as $row_grade) {
					$subject_grade = $row_grade->grade;
				}
				
				$data['content'] .= "
					<input type='hidden' name='student_id' value='{$id}' />
					<input type='hidden' name='subject_id_update[]' value='{$subject_id}' />
					<tr>
						<td><input type='checkbox' name='subject_id_delete[]' value='{$subject_id}' class='subcheck' disabled/></td>
						<td>{$term} year - {$semester} semester - {$school_year}</td>
						<td>{$subject_course_no}</td>
						<td>{$subject_subject}</td>
						<td>{$subject_credit}</td>
						<td><input type='text' name='grade[]' id='grade' value='{$subject_grade}' disabled/></td>
					</tr>
				";
			} // end for loop for every subjects
		
		$data['content'] .= "
					<tr>
						<td><input type='submit' name='action' value='Delete' /></td>
						<td><input type='submit' name='action' value='Update' /></td>
						<td><button class='cancel'>Cancel</button></td>
						<td colspan='3'><input type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
	
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
		
	}
	
	function update_student_main_data() {
		
		$id = $this->input->post('id');
		
		$student_data = array(
			"first_name" => trim($this->input->post('first_name')),
			"last_name" => trim($this->input->post('last_name')),
			"middle_name" => trim($this->input->post('middle_name'))
		);
		
		
		$students_others_data = array(
			"age" => trim($this->input->post('age')),
			"gender" => trim($this->input->post('gender')),
			"birth_date" => trim($this->input->post('birth_date')),
			"civil_status" => trim($this->input->post('civil_status')),
			"religion" => trim($this->input->post('religion')),
			"address" => trim($this->input->post('address'))
		);
		
		$update_student_data = $this->students_model->update_student($id, $student_data);
		$update_students_others_date = $this->students_model->update_students_others($id, $students_others_data);
		
		redirect('students/manage_students?id=' . $id);
	
	}
	
	function update_student_academic_data() {
		
		$student_id = $this->input->post('student_id');
		
		$school = $this->input->post('school');
		$course = $this->input->post('course');
		
		$subject_id_delete = $this->input->post('subject_id_delete'); // this one is an array
		$subject_id_update = $this->input->post('subject_id_update'); // this one is an array
		$grade = $this->input->post('grade'); // this one is an array
		
		$action = $this->input->post('action');
		
		if($action == "Update") {
				
			for($u = 0; $u < count($subject_id_update); $u++) {
				
				$grade_id_to_update =  $grade[$u];
				$subject_id_to_update = $subject_id_update[$u];
				
				$update_student_grade_by_subject_id = $this->students_model->update_student_grade_by_subject_id($grade_id_to_update, $subject_id_to_update);
				
			}
	
		}
		
		if($action == "Delete") {
		
			$delete_student_subject_id = $this->global_model->delete('students_subject', $subject_id_delete);
			
		}
		
		redirect('students/manage_students?id=' . $student_id);
	
	} 
	
	
} // end class



















