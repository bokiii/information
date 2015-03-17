<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_actions extends CI_Controller {
	
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	// variables for includes
	private $school;
	private $course;
	private $subject;
	private $teacher;

	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
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
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
		
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$course_no = $row->course_no;
				$descriptive_title = $row->descriptive_title;
				$credit = $row->credit;
				$term_id = $row->term_id;
			}
			
			// get term by term_id individually for update
			
			$get_term_by_term_id = $this->global_model->get_by_id('terms', $term_id);
			
			if($get_term_by_term_id != NULL) {
				foreach($get_term_by_term_id as $row_term_id) {
					$term = ucwords($row_term_id->term);
					$semester = ucwords($row_term_id->semester);
				}
			}
				
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";

			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&larr;</a>
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
							<td><label for="term_id">Term:</label></td>
							<td>
								<select name="term_id" id=term_id">
									<option value="'. $term_id .'">'. $term .' year - '. $semester .' semester</option>
			';
							for($i = 0; $i < count($terms_data); $i++) {
								$data['popup'] .= "
									<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester</option>
								";
							}
						
			$data['popup'] .= '		
								</select>
							</td> 
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
							<td><label for="term_id">Term</label></td>
							<td>
								<select name="term_id" id="term_id">
									<option value>Select Term</option>
			';
			
							for($i = 0; $i < count($terms_data); $i++) {
								$data['popup'] .= "
									<option value='{$terms_data[$i]['id']}'>{$terms_data[$i]['term']} year - {$terms_data[$i]['semester']} semester - {$terms_data[$i]['school_year']}</option>
								";
							}
			
			
			$data['popup'] .= '
								</select>
							</td>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
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
				$order = $row->order;
			}
			
			$popup_form_action = base_url() . "index.php/". $table ."/". $update ."";
			
			// below are conditions for term
			switch($term) {
				case "first":
					$term_option = '
						<option value="'. $term .'">First Year</option>
						<option value="second">Second Year</option>
						<option value="third">Third Year</option>
						<option value="fourth">Fourth Year</option>
					';
					break;
				case "second":
					$term_option = '
						<option value="'. $term .'">Second Year</option>
						<option value="first">First Year</option>
						<option value="third">Third Year</option>
						<option value="fourth">Fourth Year</option>
					';
					break;
				case "third":
					$term_option = '
						<option value="'. $term .'">Third Year</option>
						<option value="first">First Year</option>
						<option value="second">Second Year</option>
						<option value="fourth">Fourth Year</option>
					';
					break;
				case "fourth": 
					$term_option = '
						<option value="'. $term .'">Fourth Year</option>
						<option value="first">First Year</option>
						<option value="second">Second Year</option>
						<option value="third">Third Year</option>
					';
					break;
				default:
					$term_option = '
						<option value>Select Year</option>
						<option value="first">First Year</option>
						<option value="second">Second Year</option>
						<option value="third">Third Year</option>
						<option value="fourth">Fourth Year</option>
					';
			}
			
			// below are condition for semester
			
			switch($semester) {
				case "first":
					$semester_option = '
						<option value="'. $semester .'">First Semester</option>
						<option value="second">Second Semester</option>
					';
					break;
				case "second":
					$semester_option = '
						<option value="'. $semester .'">Second Semester</option>
						<option value="first">First Semester</option>
					';
					break;
				default:
					$semester_option = '
						<option value>Select Semester</option>
						<option value="first">First Semester</option>
						<option value="second">Second Semester</option>
					';
				
			}
			
			$data['popup'] = '
				<a class="close" href="'. $module_url .'">&larr;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<input type="hidden" name="id" value="'. $id .'"  />
					<table>
						<tr>
							<td><label for="term">Term:</label></td>
							<td>
								<select name="term" id="term">
									'. $term_option .'
								</select>
							</td>
							<td><label for="semester">Semester:</label></td>
							<td>
								<select name="semester" id="semester">
									'. $semester_option .'
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="order">Order</label></td>
							<td><input type="text" maxlength="1" name="order" id="order" value="'. $order .'" /></td>
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
				<a class="close" href="'. $module_url .'">&larr;</a>
				<h1><a href="'. $module_url .'">'. $table .'</a></h1>
				<form action="' . $popup_form_action .' " method="post" id="popup_option_form">
					<table>
						<tr>
							<td><label for="term">Term:</label></td>
							<td>
								<select name="term" id="term">
									<option value="first">First Year</option>
									<option value="second">Second Year</option>
									<option value="third">Third Year</option>
									<option value="fourth">Fourth Year</option>
								</select>
							</td>
							<td><label for="semester">Semester:</label></td>
							<td>
								<select name="semester" id="semester">
									<option value="first">First Semester</option>
									<option value="second">Second Semester</option>
								</select>
							</td>
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
			<a class='close' href='". $module_url ."'>&larr;</a>
			<h1><a href='". $module_url ."'>". $school ."</a></h1>
			<form action='" . $popup_form_action ." ' method='post' id='popup_option_form'>
				<table>
					<tr>
						<td><label for='course_id'>Course:</label></td>
						<td>
							<select name='course_id' id='course_id'>
		";
							$data['popup'] .= "
								<option value>Select course </option>
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
	
	function course_subjects() {
		
		// load necessary models
		$this->load->model('subjects_model');
		$this->load->model('course_subjects_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/subjects.php");
		include_once (dirname(__FILE__) . "/courses.php");
		
		// assign includes to a variable 
		$this->course = new Courses();
		$this->subject = new Subjects();
		
		if(!$this->input->get('id')) {
			show_404();
		}
		
		$course_id = $this->input->get('id');
		
		//set the main table
		$table = "course_subjects";
		$update = "update_course_subject";
		$add = "add_course_subject";
		
		// set the search table
		$data['search_table'] = "course_subjects";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// module url 
		$module_url = base_url() . "index.php/". $table ."?id=" . $course_id;
		
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
		
		$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";
		
		$data['popup'] = "
			<a class='close' href='". $module_url ."'>&larr;</a>
			<h1><a href='". $module_url ."'>". $course ."</a></h1>
			<form action='" . $popup_form_action ." ' method='post' id='popup_option_form'>
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
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
	function subject_teachers() {
		
		// load necessary models
		$this->load->model('teachers_model');
		$this->load->model('subject_teachers_model');
		
		// include necessary objects
		include_once (dirname(__FILE__) . "/teachers.php");
		include_once (dirname(__FILE__) . "/subjects.php");
		
		// assign includes to a variable 
		$this->subject = new Subjects();
		$this->teacher = new Teachers();
		
		if(!$this->input->get('id')) {
			show_404();
		}
		
		$subject_id = $this->input->get('id');
		
		//set the main table
		$table = "subject_teachers";
		$update = "update_subject_teacher";
		$add = "add_subject_teacher";
		
		// set the search table
		$data['search_table'] = "subject_teachers";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// module url 
		$module_url = base_url() . "index.php/". $table ."?id=" . $subject_id;
		
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
		
		// content below 
		
		$popup_form_action = base_url() . "index.php/". $table ."/". $add ."";
		
		$data['popup'] = "
			<a class='close' href='". $module_url ."'>&larr;</a>
			<h1><a href='". $module_url ."'>". $course_no . " " . $descriptive_title ."</a></h1>
			<form action='" . $popup_form_action ." ' method='post' id='popup_option_form'>
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
		
	
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
}


















