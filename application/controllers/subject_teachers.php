<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_teachers extends CI_Controller {

	// variables for search height
	public $height1 = "30px";
	public $height2 = "20px";
	
	// variables for school courses
	public $table = "subject_teachers";
	public $add = "add_subject_teacher";
	public $delete = "delete_subject_teacher";
	
	// variables for search 
	public $search;
	public $search_status;
	public $keyword;
	
	// variables for includes
	public $subject;
	public $teacher;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;

	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
		
		// load necessary models
		$this->load->model('teachers_model');
		$this->load->model('subjects_model');
		$this->load->model('subject_teachers_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/subjects.php");
		include_once (dirname(__FILE__) . "/teachers.php");
		
		// assign includes to a variable
		$this->subject = new Subjects();
		$this->teacher = new Teachers();
		
	}
	
	function index($id=null) {
		
		if($this->input->get('id')) {
			$subject_id = $this->input->get('id'); 
		}
		
		if(!$this->input->get('id')) {
			$subject_id = $id; 
		}
	
		if(!isset($subject_id)) {
			show_404();
		}
		
		// call prompt below 
		$this->prompt();
		
		$data['search_table'] = $this->table;
		
		// set search manage variables if it is a manage
		$data['search_manage_table'] = $this->teacher->table;
		$data['search_manage_id'] = $subject_id;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// get subject data 
		
		$get_subject = $this->global_model->get_by_id($this->subject->table, $subject_id);
		
		foreach($get_subject as $row_subject) { 
			$course_no = $row_subject->course_no;
			$descriptive_title = $row_subject->descriptive_title;
		}
		
		// get data for teachers
		
		$get_teachers = $this->global_model->get($this->teacher->table);
		
		$teacher_data = array();
		
		foreach($get_teachers as $row_teacher) {
			$teacher_data[] = array(
				"id" => $row_teacher->id,
				"first_name" => $row_teacher->first_name,
				"last_name" => $row_teacher->last_name,
				"middle_name" => $row_teacher->middle_name
			);
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $course_no . " " . $descriptive_title . "</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='teacher_id'>Teacher:</label></td>
						<td>
							<select name='teacher_id' id='teacher_id'>
		";
							$data['popup'] .= "
								<option value>Select Teacher</option>
							";
							for($i = 0; $i < count($teacher_data); $i++) {
								
								$data['popup'] .= "
									<option value='{$teacher_data[$i]['id']}'>". $teacher_data[$i]['first_name'] . " " . $teacher_data[$i]['middle_name'] . " " . $teacher_data[$i]['last_name'] ."</option>         
								";
							
							}
		
		$data['popup'] .= "
							</select>
						</td>
						<input type='hidden' name='subject_id' value='{$subject_id}' />
					</tr>
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		
		// content below 
		
		$content_action = base_url() . "index.php/". $this->table ."/". $this->delete . " ";
		$module_url = base_url() . "index.php/". $this->table ."?id=". $subject_id ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $course_no . " " . $descriptive_title ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Teachers</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$teacher_id = $row->teacher_id;
					$subject_id = $row->subject_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/manage/". $this->table ."?id={$id}";*/
					
					$get_teacher_by_teachers_id = $this->teachers_model->get_teacher_by_teachers_id($teacher_id);
					
					foreach($get_teacher_by_teachers_id as $row_subject_teacher) {
						$first_name = $row_subject_teacher->first_name;
						$last_name = $row_subject_teacher->last_name;
						$middle_name = $row_subject_teacher->middle_name;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$first_name} {$middle_name} {$last_name}</td>
							<input type='hidden' name='subject_id' value='{$subject_id}' />
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
			$get_content_data = $this->subject_teachers_model->get_subject_teachers_by_subject_id($subject_id);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$teacher_id = $row->teacher_id;
					$subject_id = $row->subject_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/manage/". $this->table ."?id={$id}";*/
					
					$get_teacher_by_teachers_id = $this->teachers_model->get_teacher_by_teachers_id($teacher_id);
					
					foreach($get_teacher_by_teachers_id as $row_subject_teacher) {
						$first_name = $row_subject_teacher->first_name;
						$last_name = $row_subject_teacher->last_name;
						$middle_name = $row_subject_teacher->middle_name;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$first_name} {$middle_name} {$last_name}</td>
							<input type='hidden' name='subject_id' value='{$subject_id}' />
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
		$path['id'] = $subject_id;
		$global_json_path = $this->load->view('tools/global_json_path', $path);
		
		$data['content'] .= "
				</table>
				<div id='actions'>
					{$global_json_path}
					<button id='add_button' value='". $this->table . "?id=".  $subject_id ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	
	} 
	
	function add_subject_teacher() {
		
		$teacher_id = $this->input->post('teacher_id');
		$subject_id = $this->input->post('subject_id');
		
		if($teacher_id == "") {
			
			$this->prompt_status = false;
			$this->validation_errors = "<p>Teacher is required</p>";
			
		} else {
			
			$count_subject_teacher_by_teacher_id = $this->subject_teachers_model->count_subject_teacher_by_teacher_id($teacher_id);
			$count_subject_teacher_by_teacher_id_and_subject_id = $this->subject_teachers_model->count_subject_teacher_by_teacher_id_and_subject_id($teacher_id, $subject_id);
			
			if($count_subject_teacher_by_teacher_id != 0 && $count_subject_teacher_by_teacher_id_and_subject_id != 0) {
				$this->prompt_status = false;
				$this->validation_errors = "<p>Teacher already exists.</p>";
			} else {
				
				$data = array(
					"teacher_id" => $this->input->post('teacher_id'),
					"subject_id" => $this->input->post('subject_id')
				);
		
				$add_subject_teacher = $this->global_model->add($this->table, $data);
				
				$this->prompt_status = true;
			}

		}
	
		$this->index($subject_id);
		
	}
	
	function delete_subject_teacher() {
		
		$subject_id = $this->input->post('subject_id');
		
		$id = $this->input->post('id');
		
		$delete_subject_teacher = $this->global_model->delete($this->table, $id);
		
		$this->index($subject_id);
		
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






