<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_access extends CI_Controller {  

	public $table = "students_access";
	
	function __construct() {
		parent::__construct();  
		$this->load->model("students_model"); 
		$this->load->model("terms_model");  
		$this->load->model("subjects_model");   
		
		if($this->session->userdata('student_access_allowed') != true) {
			redirect("login");
		}
		
	}  
	
	function debug($data) {
		echo "<pre>";
			print_r($data);
		echo "</pre>";
	}
	
	function index() {
	
		$id = $this->session->userdata('student_id');
		$popup_form_action = base_url() . "index.php/upload";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>Profile Image</h1>
			
			<form action='{$popup_form_action}' method='post' id='profile_upload'  enctype='multipart/form-data'>
			
				<div id='island_map_upload'>
					
					<input type='file' accept='image/*' name='profile_pic' id='profile_pic' size='20' /> 
					<input type='submit' value='Upload' />  
				
				</div>
		
			</form>
			
			
		";
		
		
		$update_main_data_action = base_url() . "index.php/". $this->table ."/update_student_main_data";
		$edit_image = base_url() . "images/modify.png";
		//$profile_image = base_url() . "profiles/panoy.png"; 
		//$profile_image = "../images/blank.png"; 
		$profile_image = "../profiles/"; 
		$view_transcript_link = base_url() . "index.php/students_access/generate_transcript?id=" . $id;
		
		$data['content'] ="
			<div ng-controller='StudentAccessAcademicCtrl'>
				<form action='{$update_main_data_action}' method='post' id='main_data_form' class='full_width_3'>
					
					<div id='profile'>
						<div id='profile_image_wrapper'>
							<a id='upload' href='#'>Change Profile</a>
							<img width='120' height='120' ng-src='{$profile_image}{{mainData.file_name}}' alt='Student Image Profile'  />
						</div>
						
						<h2>{{mainData.first_name}} {{mainData.middle_name}} {{mainData.last_name}}</h2>
						<p><a class='transcript_button' target='_blank' href='{$view_transcript_link}'>View Transcript</a></p>
					</div>
					
					<abbr title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
					<table>
						<tr>
							<td>Name:</td>
							<td class='main_data'>{{mainData.first_name}} {{mainData.middle_name}} {{mainData.last_name}}</td>                                                   
							<td>Date of Birth:</td>
							<td class='main_data'>{{mainData.birth_date}}</td>
						</tr>
						<tr>
							<td>Age:</td>
							<td class='main_data'>{{mainData.age}}</td>
							<td>Gender:</td>
							<td class='main_data'>{{mainData.gender}}</td>
						</tr>
						<tr>
							<td>Civil Status:</td>
							<td class='main_data'>{{mainData.civil_status}}</td>
							<td>Religion:</td>
							<td class='main_data'>{{mainData.religion}}</td>
						</tr>
						<tr>
							<td>Address:</td>
							<td class='main_data'>{{mainData.address}}</td>
							<td>Place of Birth:</td>
							<td class='main_data'>{{mainData.place_of_birth}}</td>
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
				
					<abbr style='display: none;' title='Edit'><img class='edit' src='{$edit_image}' alt='edit container' /></abbr>
					
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
						<tr>
							<th style='display: none;'><input type='checkbox' class='main_check' disabled/></th>
							<th>Term</th>
							<th>Course No.</th>
							<th>Descriptive Title</th>
							<th>Credit</th>
							<th>Grade</th>
							<th>Comp.</th>
							<th>Status</th>
						</tr>
		";
		
		$data['content'] .= "
				<tr ng-repeat='subject in subjects'>
					<td style='display: none;'><input type='checkbox' name='subject_id_delete[]' value='{{subject.id}}' class='subcheck' disabled='disabled'/></td>
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
		$this->load->view('template/student_content', $data);
		
		
	}      
	
	function get_student_main_data_via_angular() {
		
		$id = $this->input->get('id');  
		$id = $this->session->userdata('student_id');
		
		$data['id'] = $id;
		
		$get_student_main_data_by_id = $this->students_model->get_student_main_data_by_id($id);
		
		foreach($get_student_main_data_by_id as $row) {
			$data['student_id'] = $row->id;
			$data['first_name'] = trim($row->first_name);
			$data['last_name'] = trim($row->last_name);
			$data['middle_name'] = trim($row->middle_name);
			$data['username'] = trim($row->username);
			$data['string_password'] = trim($row->string_password);
			$data['password'] = trim($row->password);
			$data['age'] = trim($row->age);
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
	
	function get_student_academic_data_via_angular() {
		
		$id = $this->session->userdata('student_id');
		
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
		
	} 
	
	function update_student_main_data() {
	
		$id = $this->input->post('id');
		
		$student_account_data = array(
			"username" => trim($this->input->post('username')),
			"string_password" => $this->input->post('password'),
			"password" => md5($this->input->post('password'))
		);
		
		/*$student_data = array(
			"first_name" => trim($this->input->post('first_name')),
			"last_name" => trim($this->input->post('last_name')),
			"middle_name" => trim($this->input->post('middle_name')),  
			"username" => trim($this->input->post('username')),
			"string_password" => $this->input->post('password'),
			"password" => md5($this->input->post('password'))
		);
		
		$students_others_data = array(
			"age" => trim($this->input->post('age')),
			"gender" => trim($this->input->post('gender')),
			"birth_date" => trim($this->input->post('birth_date')),
			"civil_status" => trim($this->input->post('civil_status')),
			"religion" => trim($this->input->post('religion')),
			"address" => trim($this->input->post('address')), 
			"place_of_birth" => trim($this->input->post('place_of_birth'))
		);
		
		$update_student_data = $this->students_model->update_student($id, $student_data);
		$update_students_others_data = $this->students_model->update_students_others($id, $students_others_data);
		*/
		
		$update_student_account_data = $this->students_model->update_student($id, $student_account_data);
		
	
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
	
	function generate_transcript() {
	
		$student_id = $this->input->get('id');
		$get_student_data = $this->students_model->get_transcript_data_by_student_id($student_id);
		
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
			
		} // end foreach loop  
	
	
		
		$this->load->helper('pdf_helper');
		$this->load->view('transcript_view', $data); 
		
	}   
	
	
}  













