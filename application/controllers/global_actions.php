<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_actions extends CI_Controller {
	
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	// variables for includes
	private $school;
	private $course;

	function __construct() {
		parent::__construct();
	} 

	function students() {
		//set the main table
		$table = "students";
		$update = "update_student";
		$add = "add_student";
		
		// set the search table
		$data['search_table'] = "students";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$first_name = $row->first_name;
				$last_name = $row->last_name;
				$middle_name = $row->middle_name;
				$address = $row->address;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="first_name">First Name:</label></td>
							<td><input type="text" name="first_name" id="first_name" value="'. $first_name .'" /></td>
							<td><label for="last_name">Last Name:</label></td>
							<td><input type="text" name="last_name" id="last_name" value="'. $last_name .'" /></td>
						</tr>
						<tr>
							<td><label for="middle_name">Middle Name:</label></td>
							<td><input type="text" name="middle_name" id="middle_name" value="'. $middle_name .'" /></td>
							<td><label for="address">Address:</label></td>
							<td><input type="text" name="address" id="address"  value="'. $address .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="first_name">First Name:</label></td>
							<td><input type="text" name="first_name" id="first_name" /></td>
							<td><label for="last_name">Last Name:</label></td>
							<td><input type="text" name="last_name" id="last_name" /></td>
						</tr>
						<tr>
							<td><label for="middle_name">Middle Name:</label></td>
							<td><input type="text" name="middle_name" id="middle_name" /></td>
							<td><label for="address">Address:</label></td>
							<td><input type="text" name="address" id="address" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function teachers() {	
		//set the main table
		$table = "teachers";
		$update = "update_teacher";
		$add = "add_teacher";
		
		// set the search table
		$data['search_table'] = "teachers";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// set the module url
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$first_name = $row->first_name;
				$last_name = $row->last_name;
				$middle_name = $row->middle_name;
				$address = $row->address;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="first_name">First Name:</label></td>
							<td><input type="text" name="first_name" id="first_name" value="'. $first_name .'" /></td>
							<td><label for="last_name">Last Name:</label></td>
							<td><input type="text" name="last_name" id="last_name" value="'. $last_name .'" /></td>
						</tr>
						<tr>
							<td><label for="middle_name">Middle Name:</label></td>
							<td><input type="text" name="middle_name" id="middle_name"  value="'. $middle_name .'" /></td>
							<td><label for="address">Address:</label></td>
							<td><input type="text" name="address" id="address"  value="'. $address .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="first_name">First Name:</label></td>
							<td><input type="text" name="first_name" id="first_name" /></td>
							<td><label for="last_name">Last Name:</label></td>
							<td><input type="text" name="last_name" id="last_name" /></td>
						</tr>
						<tr>
							<td><label for="middle_name">Middle Name:</label></td>
							<td><input type="text" name="middle_name" id="middle_name" /></td>
							<td><label for="address">Address:</label></td>
							<td><input type="text" name="address" id="address" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function subjects() {
		//set the main table
		$table = "subjects";
		$update = "update_subject";
		$add = "add_subject";
		
		// set the search table
		$data['search_table'] = "subjects";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$course_no = $row->course_no;
				$descriptive_title = $row->descriptive_title;
				$credit = $row->credit;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="course_no">Course No.:</label></td>
							<td><input type="text" name="course_no" id="course_no" value="'. $course_no .'" /></td>
							<td><label for="descriptive_title">Descriptive Title:</label></td>
							<td><input type="text" name="descriptive_title" id="descriptive_title" value="'. $descriptive_title .'" /></td>
						</tr>
						<tr>
							<td><label for="credit">Credit:</label></td>
							<td><input type="text" name="credit" id="credit"  value="'. $credit .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="course_no">Course No.:</label></td>
							<td><input type="text" name="course_no" id="course_no" /></td>
							<td><label for="descriptive_title">Descriptive Title:</label></td>
							<td><input type="text" name="descriptive_title" id="descriptive_title" /></td>
						</tr>
						<tr>
							<td><label for="credit">Credit:</label></td>
							<td><input type="text" name="credit" id="credit" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function courses() {
		//set the main table
		$table = "courses";
		$update = "update_course";
		$add = "add_course";
		
		// set the search table
		$data['search_table'] = "courses";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$course = $row->course;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="course">Course:</label></td>
							<td><input type="text" name="course" id="course" value="'. $course .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="course">Course:</label></td>
							<td><input type="text" name="course" id="course" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function schools() {
		//set the main table
		$table = "schools";
		$update = "update_school";
		$add = "add_school";
		
		// set the search table
		$data['search_table'] = "schools";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$school = $row->school;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="school">School:</label></td>
							<td><input type="text" name="school" id="school" value="'. $school .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="school">School:</label></td>
							<td><input type="text" name="school" id="school" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function terms() {	
		//set the main table
		$table = "terms";
		$update = "update_term";
		$add = "add_term";
		
		// set the search table
		$data['search_table'] = "terms";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// set the module url
		$module_url = base_url() . "index.php/". $table ."";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$term = $row->term;
				$semester = $row->semester;
				$school_year = $row->school_year;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="term">Term:</label></td>
							<td><input type="text" name="term" id="term" value="'. $term .'" /></td>
							<td><label for="semester">Semester:</label></td>
							<td><input type="text" name="semester" id="semester" value="'. $semester .'" /></td>
						</tr>
						<tr>
							<td><label for="school_year">School Year:</label></td>
							<td><input type="text" name="school_year" id="school_year"  value="'. $school_year .'" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Update"/><input class="popup_actions clear" type="reset" value="Reset" /></td>
						</tr>
					</table>
				</form>
			';
			
		} else {
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&#215;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="term">Term:</label></td>
							<td><input type="text" name="term" id="term" /></td>
							<td><label for="semester">Semester:</label></td>
							<td><input type="text" name="semester" id="semester" /></td>
						</tr>
						<tr>
							<td><label for="school_year">School Year:</label></td>
							<td><input type="text" name="school_year" id="school_year" /></td>
						</tr>
						<tr>
							<td colspan="4"><input class="popup_actions" type="submit" value="Add"/><input class="popup_actions clear" type="reset" value="Clear" /></td>
						</tr>
					</table>
				</form>
			';
		}
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function school_courses() {
		
		// load necessary models
		$this->load->model('courses_model');
		$this->load->model('school_courses_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/schools.php");
		include_once (dirname(__FILE__) . "/courses.php");
		
		// assign includes to a variable 
		$this->school = new Schools();
		$this->course = new Courses();
		
		if(!$this->input->get('id')) {
			show_404();
		}
		
		$school_id = $this->input->get('id');
		
		//set the main table
		$table = "school_courses";
		$update = "update_school_course";
		$add = "add_school_course";
		
		// set the search table
		$data['search_table'] = "school_courses";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// module url 
		$module_url = base_url() . "index.php/". $table ."?id=" . $school_id;
		
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
		
		
		$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";
		
		$data['popup'] = "
			<a class='close' href='". $module_url ."'>&#215;</a>
			<h1><a href='". $module_url ."'>". $school ."</a></h1>
			<form action='" . $popup_form_action ." ' method='post' id='popup_option_form'>
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
		
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
}





