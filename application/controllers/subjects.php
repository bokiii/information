<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends CI_Controller {
	
	public	$height1 = "30px";
	public	$height2 = "20px";
	
	public $table = "subjects";
	public $add = "add_subject";
	public $delete = "delete_subject";
	
	// variable for subject teachers
	public $subject_teachers = "subject_teachers";
	public $courses = "courses";
	public $course_subjects = "course_subjects";
	
	// below are for search variables 
	public $search;
	public $search_status;
	public $keyword;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;
	
	// below is the update id for the update
	
	private $update_id;
	
	// variable below if there is a single data to validate via update argument
	
	private $data_validate;
	
	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
		
		$this->load->model('course_subjects_model');
		$this->load->model('courses_model');
		$this->load->model('school_courses_model');
		$this->load->model('subjects_model');
		$this->load->model('students_model');
	}
	
	function debug($data) {
		echo "<pre>";
			print_r($data);
		echo "</pre>";
	}
	
	private function get_data_validate() {
		return $this->data_validate;
	}
	
	private function set_data_validate($data) {
		$this->data_validate = $data;
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
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $this->table ."</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='course_no'>Course No.:</label></td>
						<td><input type='text' name='course_no' id'course_no' /></td>
						<td><label for='descriptive_title'>Descriptive Title:</label></td>
						<td><input type='text' name='descriptive_title' id='descriptive_title' /></td>
					</tr>
					<tr>
						<td><label for='credit'>Credit:</label></td>
						<td><input type='text' name='credit' id='credit' /></td>
						<td><label for='term_id'>Term:</label></td>
						<td>
							<select name='term_id' id='term_id'>
								<option value>Select Term</option>
		";
		
						for($i = 0; $i < count($terms_data); $i++) {
							$data['popup'] .= "
								<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester</option>
							";
						}
		
		$data['popup'] .= "
							</select>
						</td>
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
						<th>Course No.</th>
						<th>Descriptive Title</th>
						<th>Credit</th>
						<th>Courses</th>
						<th>Term</th>
						<th>Teachers</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course_no = $row->course_no;
					$descriptive_title = $row->descriptive_title;
					$credit = $row->credit;
					$term_id = $row->term_id;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/". $this->subject_teachers ."?id={$id}";
					
					// get terms data by term_id
					
					$get_term_by_term_id = $this->global_model->get_by_id('terms', $term_id);
					
					foreach($get_term_by_term_id as $row_term) {
						$term = ucwords($row_term->term);
						$semester = ucwords($row_term->semester);
					}
					
					// get data for manage link 
					
					$get_course_id_id_by_subject_id = $this->course_subjects_model->get_course_id_id_by_subject_id($id);
					
					if($get_course_id_id_by_subject_id != NULL) {
						
						$course_id_data = array();
						
						foreach($get_course_id_id_by_subject_id as $row_a) {
							//$course_id = $row_a->course_id;
							array_unshift($course_id_data, $row_a->course_id);
						} 
						
						$course_data = array();
						
						foreach($course_id_data as $course_id) {
							
							$get_course_by_course_id = $this->courses_model->get_course_by_course_id($course_id);
							
							foreach($get_course_by_course_id as $row_b) {
								//$course = $row_b->course;
								array_unshift($course_data, $row_b->course);
							}
						}
						
						$course_count = count($course_data);
					
						$course = $course_data[0];
						
						for($i = 1; $i < count($course_data); $i++) {
							$course .= "<br />" . $course_data[$i];
						}
						
					} else {
						$course = "<a class='link_add' id='{$id}' href='#'>Update Course</a>";
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course_no}</a></td>
							<td>{$descriptive_title}</td>
							<td>{$credit}</td>
							<td>{$course}</td>
							<td>{$term} year - {$semester} semester</td>
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
			//$get_content_data = $this->subjects_model->get_subjects();
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course_no = $row->course_no;
					$descriptive_title = $row->descriptive_title;
					$credit = $row->credit;
					$term_id = $row->term_id;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/". $this->subject_teachers ."?id={$id}";
				
					// get terms data by term_id
					
					$get_term_by_term_id = $this->global_model->get_by_id('terms', $term_id);
					
					foreach($get_term_by_term_id as $row_term) {
						$term = ucwords($row_term->term);
						$semester = ucwords($row_term->semester);
					}
					
					// get data for manage link 
					
					$get_course_id_id_by_subject_id = $this->course_subjects_model->get_course_id_id_by_subject_id($id);
					
					if($get_course_id_id_by_subject_id != NULL) {
						
						$course_id_data = array();
						
						foreach($get_course_id_id_by_subject_id as $row_a) {
							//$course_id = $row_a->course_id;
							array_unshift($course_id_data, $row_a->course_id);
						} 
						
						$course_data = array();
						
						foreach($course_id_data as $course_id) {
							
							$get_course_by_course_id = $this->courses_model->get_course_by_course_id($course_id);
							
							foreach($get_course_by_course_id as $row_b) {
								//$course = $row_b->course;
								array_unshift($course_data, $row_b->course);
							}
						}
						
						$course_count = count($course_data);
					
						$course = $course_data[0];
						
						for($i = 1; $i < count($course_data); $i++) {
							$course .= "<br />" . $course_data[$i];
						}
						
					} else {
						$course = "<a class='link_add' id='{$id}' href='#'>Update Course</a>";
					}
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course_no}</a></td>
							<td>{$descriptive_title}</td>
							<td>{$credit}</td>
							<td>{$course}</td>
							<td>{$term} year - {$semester} semester</td>
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
		
		$get_courses = $this->global_model->get($this->courses);
		
		if($get_courses != NULL) {
			
			$link_add_data = array();
			$link_add_id = array();
			
			foreach($get_courses as $row_l) {
				
				$get_school_id_by_course_id = $this->school_courses_model->get_school_id_by_course_id($row_l->id);
				
				if($get_school_id_by_course_id != NULL) {
					array_unshift($link_add_data, $row_l->course);
					array_unshift($link_add_id, $row_l->id);
				}
			}
			
			$data['link_add_module'] = $this->courses;
			$data['link_add_id'] = $link_add_id;
			$data['link_add_data'] = $link_add_data;
			$data['check_box'] = true;
		}
	
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	}
	
	function add_subject() {
		
		// call validation
		
		$this->validation('add');
		
		if($this->form_validation->run() == TRUE) {
			
			$data = array(
				"course_no" => trim($this->input->post('course_no')),
				"descriptive_title" => trim($this->input->post('descriptive_title')),
				"credit" => trim($this->input->post('credit')),
				"term_id" => trim($this->input->post('term_id'))
			);
			
			$add_subject = $this->global_model->add($this->table, $data);
			
			$this->prompt_status = true;      
			
			
		} else {
			
			
			$this->prompt_status = false;
			//$this->validation_errors = validation_errors();
			$this->set_validation_errors(validation_errors());
			
		} 
		
		$this->index();
	
	}
	
	function delete_subject() {
	
		$id = $this->input->post('id');
		$delete_subject = $this->global_model->delete($this->table, $id);
	
		$this->index();
	}
	
	function update_subject() {
		
		// get id
		
		$id = $this->input->post('id');
		
		$this->set_update_id($id);
		
		// call validation
		
		$this->validation('update');
		
		if($this->form_validation->run() == TRUE) {
		
			$course_no = $this->input->post('course_no');
			$descriptive_title = $this->input->post('descriptive_title');
			
			$course_no_and_descriptive_title_exist = $this->subjects_model->course_no_and_descriptive_title_exist_in_id($this->get_update_id(), $course_no, $descriptive_title);       
			$course_no_exist = $this->subjects_model->course_no_exist_in_id($this->get_update_id(), $course_no);
			$descriptive_title_exist = $this->subjects_model->descriptive_title_exist_in_id($this->get_update_id(), $descriptive_title);
			
			if($course_no_and_descriptive_title_exist) {
				
				$data = array(
					"id" => $this->input->post('id'),
					"course_no" => trim($this->input->post('course_no')),
					"descriptive_title" => trim($this->input->post('descriptive_title')),
					"credit" => trim($this->input->post('credit')),
					"term_id" => $this->input->post('term_id')
				);
				
				$update_subject = $this->global_model->update($this->table, $data, $data['id']);
				
				// below is for other updates
				$this->other_updates($this->input->post('term_id'), $data['id'], $data['descriptive_title']);
			
			
				$this->prompt_status = true;
		
			} elseif($course_no_exist) {
				// update via descriptive title 
					
				// set specific variables 
				$descriptive_title = $this->input->post('descriptive_title');
				$credit = $this->input->post('credit');
				
				// set validation via single data via update argument
				$this->set_data_validate("descriptive_title");
				
				// call validation via update argument
				$this->validation('update');
				
				if($this->form_validation->run() == TRUE) {
				
					$update_via_descriptive_title = $this->subjects_model->update_via_descriptive_title($this->get_update_id(), $descriptive_title, $credit);
				
					// below is for other updates
					$this->other_updates($this->input->post('term_id'), $this->get_update_id(), $descriptive_title);
					
					$this->prompt_status = true;
					
				} else {
					$this->prompt_status = false;
					$this->set_validation_errors(validation_errors());
				}
				
			} elseif($descriptive_title_exist) {
			
				// update via course_no
				
				$course_no = $this->input->post('course_no');
				$credit = $this->input->post('credit');
				
				// set validation via single data via update argument
				$this->set_data_validate("course_no");
				
				// call validation via update argument
				$this->validation('update');
				
				if($this->form_validation->run() == TRUE) {
				
					$update_via_course_no = $this->subjects_model->update_via_course_no($this->get_update_id(), $course_no, $credit);
				
					// below is for other updates
					$this->other_updates($this->input->post('term_id'), $this->get_update_id(), $descriptive_title);
				
					$this->prompt_status = true;
					
				} else {
					$this->prompt_status = false;
					$this->set_validation_errors(validation_errors());
				}
				
			} else {
			
				$this->validation('add');
		
				if($this->form_validation->run() == TRUE) {
					
					$data = array(
						"course_no" => $this->input->post('course_no'),
						"descriptive_title" => $this->input->post('descriptive_title'),
						"credit" => $this->input->post('credit'),
						"term_id" => $this->input->post('term_id')
					);
					
					$update_subject = $this->global_model->update($this->table, $data, $this->get_update_id());
					
					// below is for other updates
					$this->other_updates($this->input->post('term_id'), $this->get_update_id(), $descriptive_title);
					
					$this->prompt_status = true;
				
				} else {
					$this->prompt_status = false;
					//$this->validation_errors = validation_errors();
					$this->set_validation_errors(validation_errors());
				} 
				
			} // end sub else 
			
			
		} else {
			$this->prompt_status = false;
			//$this->validation_errors = validation_errors();
			$this->set_validation_errors(validation_errors());
		} // end main else 
		
		$this->index();
	
	}
	
	
	private function other_updates($term_id, $id, $descriptive_title) {
		// update the term_id of course subject
		$course_subject_update_data = array(
			"term_id" => $term_id
		);
		$update_course_subject_term_id = $this->course_subjects_model->update_course_subject_term_id_by_subject_id($course_subject_update_data, $id);      
		$get_course_subject_id = $this->course_subjects_model->get_course_subject_id_by_subject_id($id);
		foreach($get_course_subject_id as $row_e) {
			$course_subject_id = $row_e->id;
		}
		$students_subject_update_data = array(
			"subject" => $descriptive_title
		);
		$update_student_subject_by_course_subject_id = $this->students_model->update_students_subject_subject_by_course_subject_id($students_subject_update_data, $course_subject_id);   
	}
	
	
	private function prompt() {
		if($this->prompt_status === true) {
			$promp_data['message'] = "<p>Sucess</p>";
			$promp_data['class'] = "success";
			$this->load->view('tools/prompt', $promp_data);
		} else if($this->prompt_status === false) {
			//$promp_data['message'] = $this->validation_errors;
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
			
			$this->form_validation->set_rules('course_no', 'Course no.', 'required|is_unique[subjects.course_no]');
			$this->form_validation->set_rules('descriptive_title', 'Descriptive Title', 'required|is_unique[subjects.descriptive_title]');
			$this->form_validation->set_rules('credit', 'Credit', 'required|is_natural');
			$this->form_validation->set_rules('term_id', 'Term', 'required');
			
		}
		
		if($action == "update") {
			
			if($this->get_data_validate() != NULL) {
				
				$this->form_validation->set_message('required', '%s is required');
				$this->form_validation->set_message('is_unique', '%s already exists.');
				$this->form_validation->set_message('is_natural', '%s is not a valid number.');
				
				if($this->get_data_validate() == "descriptive_title") {
					$this->form_validation->set_rules('descriptive_title', 'Descriptive Title', 'required|is_unique[subjects.descriptive_title]');
				}
				
				if($this->get_data_validate() == "course_no") {
					$this->form_validation->set_rules('course_no', 'Course No', 'required|is_unique[subjects.course_no]');
				}
			
			
			} else {
				$this->form_validation->set_message('required', '%s is required');
				$this->form_validation->set_message('is_unique', '%s already exists.');
				$this->form_validation->set_message('is_natural', '%s is not a valid number.');
				
				$this->form_validation->set_rules('course_no', 'Course no.', 'required');
				$this->form_validation->set_rules('descriptive_title', 'Descriptive Title', 'required');
				$this->form_validation->set_rules('credit', 'Credit', 'required|is_natural');
				$this->form_validation->set_rules('term_id', 'Term', 'required');
			}

		}
		
		
	}
	
	public function link_add() {
		
		$subject_id = $this->input->post('sub_id');
		$course_id = $this->input->post('main_id');
		
		if(!$this->input->post('sub_id') || !$this->input->post('main_id')) {
			
			$this->prompt_status = false;
			$this->validation_errors = "<p>Course is required</p>";
			
		} else {
			
			$get_subject_term_id = $this->subjects_model->get_subject_term_id_by_subject_id($subject_id);
			
			foreach($get_subject_term_id as $row_id) {
				$term_id = $row_id->term_id;
			}
			
			foreach($course_id as $row) {
				$data = array(
					"subject_id" => $subject_id,
					"course_id" => $row,
					"term_id" => $term_id
				);
				
				$add_course_subject = $this->global_model->add($this->course_subjects, $data);
			}
			
			$this->prompt_status = true;
		}
		
		redirect($this->table);
	}
	
}










