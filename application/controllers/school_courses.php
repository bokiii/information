<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_courses extends CI_Controller {
	
	// variables for search height
	public $height1 = "30px";
	public	$height2 = "20px";
	
	// variables for school courses
	public $table = "school_courses";
	public $add = "add_school_course";
	public $delete = "delete_school_course";
	
	// variables for search 
	public $search;
	public $search_status;
	public $keyword;
	
	// set the variable for the global tools
	public $global_tool;
	
	// variables for includes
	public $school;
	public $course;
	

	function __construct() {
		parent::__construct();
		
		// load necessary models
		$this->load->model('courses_model');
		$this->load->model('school_courses_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/schools.php");
		include_once (dirname(__FILE__) . "/courses.php");
		
		// assign includes to a variable
		$this->school = new Schools();
		$this->course = new Courses();
	}
	
	function index($id=null) {
		
		if($this->input->get('id')) {
			$school_id = $this->input->get('id'); 
		}
		
		if(!$this->input->get('id')) {
			$school_id = $id; 
		}
	
		if(!isset($school_id)) {
			show_404();
		}
		
		$data['search_table'] = $this->table;
		
		// set search manage variables if it is a manage
		$data['search_manage_table'] = $this->course->table;
		$data['search_manage_id'] = $school_id;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// get school data 
		
		$get_school = $this->global_model->get_by_id($this->school->table, $school_id);
		
		foreach($get_school as $row_school) { 
			$school = $row_school->school;
		}
		
		// get data for courses
		
		$get_courses = $this->global_model->get($this->course->table);
		
		$course_data = array();
		
		foreach($get_courses as $row_course) {
			$course_data[] = array(
				"id" => $row_course->id,
				"course" => $row_course->course
			);
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $school ."</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='course_id'>Course:</label></td>
						<td>
							<select name='course_id'>
		";
							for($i = 0; $i < count($course_data); $i++) {
								
								$data['popup'] .= "
									<option value='{$course_data[$i]['id']}'>". $course_data[$i]['course'] ."</option>
								";
							
							}
		
		$data['popup'] .= "
							</select>
						</td>
						<input type='hidden' name='school_id' value='{$school_id}' />
					</tr>
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		// content below 
		
		$content_action = base_url() . "index.php/". $this->table ."/". $this->delete . " ";
		$module_url = base_url() . "index.php/". $this->table ."?id=". $school_id ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $school ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Course</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course_id = $row->course_id;
					$school_id = $row->school_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/manage/". $this->table ."?id={$id}";*/
					
					$get_course_by_course_id = $this->courses_model->get_course_by_course_id($course_id);
					
					foreach($get_course_by_course_id as $row_school_course) {
						$course = $row_school_course->course;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$course}</td>
							<input type='hidden' name='school_id' value='{$school_id}' />
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
			$get_content_data = $this->school_courses_model->get_school_courses_by_school_id($school_id);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course_id = $row->course_id;
					$school_id = $row->school_id;
				
					/*$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					$manage_link = base_url() . "index.php/manage/". $this->table ."?id={$id}";*/
				
					$get_course_by_course_id = $this->courses_model->get_course_by_course_id($course_id);
					
					foreach($get_course_by_course_id as $row_school_course) {
						$course = $row_school_course->course;
					}
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td>{$course}</td>
							<input type='hidden' name='school_id' value='{$school_id}' />
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
		$path['id'] = $school_id;
		$global_json_path = $this->load->view('tools/global_json_path', $path);
		
		$data['content'] .= "
				</table>
				<div id='actions'>
					{$global_json_path}
					<button id='add_button' value='". $this->table . "?id=".  $school_id ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
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
		
		$school_id = $this->input->post('school_id');
		
		$id = $this->input->post('id');
		$delete_school_course = $this->global_model->delete($this->table, $id);
		
		if($delete_school_course) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect($this->table ."?id=". $school_id ."");
	}
	
	
	
}