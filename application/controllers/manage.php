<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	private $school;
	private $course;
	private $school_course;
	
	function __construct() {
		parent::__construct();
		$this->load->model('courses_model');
		$this->load->model('school_courses_model');
	}
	
	function school_courses() {
		include_once (dirname(__FILE__) . "/schools.php");
		include_once (dirname(__FILE__) . "/courses.php");
		include_once (dirname(__FILE__) . "/school_courses.php");
		
		$this->school = new Schools();
		$this->course = new Courses();
		$this->school_course = new School_courses();
		
		if(!$this->input->get('id')) {
			show_404();
		}
		
		$school_id = $this->input->get('id'); 
		
		$data['search_table'] = $this->school->school_courses;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->school->height1;
		
		// keyword 
		if($this->school->keyword != NULL) {
			$data['keyword'] = $this->school->keyword;
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
		
		$popup_form_action = base_url() . "index.php/". $this->school_course->table ."/". $this->school_course->add . " ";
		
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
		
		$content_action = base_url() . "index.php/". $this->school_course->table ."/". $this->school_course->delete . " ";
		$module_url = base_url() . "index.php/manage/". $this->school_course->table ."?id=". $school_id ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $school ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Course</th>
					</tr>
		";
		
		
		if($this->school->search_status == true) {
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
						<td style='text-align: center;' colspan='5'>No ". $this->school_course->table ." added in the database</td>
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
					<button id='add_button' value='". $this->school_course->table ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "manage_view";
		$this->load->view('template/content', $data);
	
	}
	
}


