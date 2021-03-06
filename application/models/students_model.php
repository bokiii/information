<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_model extends CI_Model {
	
	private $students_table = "students";
	private $students_others_table = "students_others";
	private $students_school_table = "students_school";
	private $students_course_table = "students_course";
	private $students_subject_table = "students_subject";
	private $students_grade_table = "students_grade";
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function add_student($data) {
		$query = $this->db->insert($this->students_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_student_others($data) {
		$query = $this->db->insert($this->students_others_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_student_school($data) {
		$query = $this->db->insert($this->students_school_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_student_course($data) {
		$query = $this->db->insert($this->students_course_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_student_subject($data) {
		$query = $this->db->insert($this->students_subject_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function add_student_subject_batch($data) {
		$query = $this->db->insert_batch('students_subject', $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function add_student_grade($data) {
		$query = $this->db->insert($this->students_grade_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function delete_student_grade_by_subject_id($subject_id) {
		$this->db->where_in('subject_id', $subject_id);
		$query = $this->db->delete($this->students_grade_table);
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_student_id_by_first_name_last_name_middle_name($first_name, $last_name, $middle_name) {
		$this->db->select('id');
		$this->db->where('first_name', $first_name);
		$this->db->where('last_name', $last_name);
		$this->db->where('middle_name', $middle_name);
		$query = $this->db->get($this->students_table);
		
		return $query->result();
	}
	
	function get_student_school_id_by_school_and_student_id($school, $student_id) {
		$this->db->select('id');
		$this->db->where('school', $school);
		$this->db->where('student_id', $student_id);
		$query = $this->db->get($this->students_school_table);
		return $query->result();
	}
	
	function get_student_course_id_by_course($course) {
		$this->db->select('id');
		$this->db->where('course', $course);
		$query = $this->db->get($this->students_course_table);
		return $query->result();
	}
	
	function get_student_course_by_student_id($student_id) {
		$this->db->select('course');
		$this->db->where('student_id', $student_id);
		$query = $this->db->get($this->students_course_table);
		return $query->result();
	}
	
	function get_students_course_course_id_by_student_id($student_id) {
		$this->db->select('id');
		$this->db->where('student_id', $student_id);
		
		$query = $this->db->get($this->students_course_table);
		
		return $query->result();
	
	}
	
	function get_students_subject_subject_id_by_descriptive_title($descriptive_title) {
		
		$this->db->select('id');
		$this->db->where('subject', $descriptive_title);
		$query = $this->db->get('students_subject');
		
		return $query->result();
		
		
	}
	
	function empty_table() {
		
		$this->db->empty_table('students');
		$this->db->empty_table('students_others');
		$this->db->empty_table('students_school');
		$this->db->empty_table('students_course');
		$this->db->empty_table('students_subject');
		
		echo "emptying executed..";
	}
	
	function get_subject_ids_by_student_id($student_id) {
		
		$this->db->select('id');
		$this->db->where('student_id', $student_id);
		$query = $this->db->get($this->students_subject_table);
		
		return $query->result();
		
	}
	
	function get_subject_main_credit_by_grade_subject_id($subject_id) {
		$this->db->select('students_subject.course_subject_id, course_subjects.subject_id, subjects.credit');
		$this->db->where('students_grade.subject_id', $subject_id);
		$this->db->from("students_grade");
		$this->db->join("students_subject", "students_subject.id = students_grade.subject_id");
		$this->db->join("course_subjects", "course_subjects.id = students_subject.course_subject_id");
		$this->db->join("subjects", "subjects.id = course_subjects.subject_id");
		$query = $this->db->get();
		return $query->result();
	}
	
	// below are for all the functions of selecting the data for students after enrolled
	
	function get_student_main_data_by_id($id) {
	
		$this->db->select('students.id, students.first_name, students.last_name, students.middle_name, students.username, students.string_password, students.password, students_others.age, students_others.gender, students_others.birth_date, students_others.civil_status, students_others.religion, students_others.address, students_others.place_of_birth, students_others.entrance_data, students_others.remarks, students_school.school, students_course.course, students_course.school_id, profile_image.file_name');                                          
		$this->db->from('students');
		$this->db->join('students_others', "students_others.student_id = students.id", 'left');
		$this->db->join('students_school', "students_school.student_id = students.id", 'left');
		$this->db->join('profile_image', "profile_image.student_id = students.id", 'left');
		$this->db->join('students_course', "students_course.student_id = students.id", 'left');
		
		$this->db->where('students.id', $id);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_student_subject_by_student_id($student_id) {
		$this->db->where('student_id', $student_id);
		$query = $this->db->get('students_subject');
		
		return $query->result();
	}
	
	function get_student_earned_credit_subject_grade_and_status_by_student_subject_id($subject_id) {	
		$this->db->select('earned_credit, grade, comp, status');
		$this->db->where('subject_id', $subject_id);
		$query = $this->db->get($this->students_grade_table);
		
		return $query->result();
	}
	
	function get_students_grade_by_subject_id($subject_id) {
		$this->db->where("subject_id", $subject_id);
		$query = $this->db->get($this->students_grade_table);
		return $query->result();
	}
	
	function get_student_grade_status_by_course_subject_id($course_subject_id) {
		$this->db->select("students_grade.status");
		$this->db->where("students_subject.course_subject_id", $course_subject_id);
		$this->db->from("students_subject");
		$this->db->join("students_grade", "students_grade.subject_id = students_subject.id");
		$query = $this->db->get();
		return $query->result();
	}
	
	// below are for updates in managing students 
	
	function update_student($id, $data) {
	
		$this->db->where('id', $id);
		$query = $this->db->update($this->students_table, $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function update_students_others($id, $other_data) {
		
		$data = array(
			"age" => $other_data['age'],
			"gender" => $other_data['gender'],
			"birth_date" => $other_data['birth_date'],
			"civil_status" => $other_data['civil_status'],
			"religion" => $other_data['religion'],
			"address" => $other_data['address'], 
			"place_of_birth" => $other_data['place_of_birth']
		);
		
		$this->db->where('student_id', $id);
		$query = $this->db->update($this->students_others_table, $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function update_student_grade_and_comp_by_subject_id($grade, $comp_grade,  $subject_id) {
		
		$data = array(
			'grade' => $grade,
			'comp' => $comp_grade, 
			'subject_id' => $subject_id
			
		);
		
		$this->db->where('subject_id', $subject_id);
		
		$query = $this->db->update($this->students_grade_table, $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function update_students_subject_subject_by_course_subject_id($data, $id) {
		$this->db->where('course_subject_id', $id);
		$query = $this->db->update($this->students_subject_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	function is_subject_exists($id) {
		$this->db->where('course_subject_id', $id);
		$count = $this->db->count_all_results($this->students_subject_table);
		
		return $count;
	}
	
	function update_student_grade_and_etc_by_subject_id($data, $subject_id) {
		$this->db->where('subject_id', $subject_id);
		$query = $this->db->update($this->students_grade_table, $data);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
	// below are the functions for the process of transcript   
	
	function get_transcript_data_by_student_id($student_id) {
		$this->db->select("students.first_name, students.last_name, students.middle_name, students_others.age, students_others.gender, DATE_FORMAT(students_others.birth_date, '%M %d, %Y') as birth_date, students_others.civil_status, students_others.religion, students_others.address, students_others.place_of_birth, students_others.entrance_data, students_others.remarks, students_school.school, students_course.course, students_course.id AS students_course_id", FALSE);
		$this->db->where('students.id', $student_id);
		$this->db->from("students");
		$this->db->join("students_others", "students_others.student_id = students.id");
		$this->db->join("students_school", "students_school.student_id = students.id");
		$this->db->join("students_course", "students_course.student_id = students.id");
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function get_student_subjects_by_students_course_course_id($student_course_id) {
		$this->db->select("students_subject.subject, students_subject.school_year, students_grade.earned_credit, students_grade.grade, students_grade.comp, students_grade.status");
		$this->db->where("students_subject.course_id", $student_course_id);
		$this->db->from("students_subject");
		$this->db->join("students_grade", "students_grade.subject_id = students_subject.id");
		$query = $this->db->get();  
	
		return $query->result_array();
	}
	
	function get_students_school_year_by_term_id_and_student_id($term_id, $student_id) {
		$this->db->select('school_year');
		$this->db->where('term_id', $term_id);  
		$this->db->where('student_id', $student_id);
		$this->db->from("students_subject");
		$this->db->group_by('school_year');
		$query = $this->db->get();
		return $query->result();
	}   
	
	function get_students_subject_by_term_id_and_school_year_and_student_id($term_id, $school_year, $student_id) {
		$this->db->select('students_subject.subject, students_grade.earned_credit, students_grade.grade, students_grade.comp, students_grade.status, subjects.course_no');
		$this->db->where('students_subject.term_id', $term_id);
		$this->db->where('students_subject.school_year', $school_year);
		$this->db->where('students_subject.student_id', $student_id);
		$this->db->from("students_subject");
		$this->db->join("students_grade", "students_grade.subject_id = students_subject.id");
		$this->db->join("course_subjects", "course_subjects.id = students_subject.course_subject_id");
		$this->db->join("subjects", "subjects.id = course_subjects.subject_id");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_student_id_by_username_and_password($username, $password) {
		$this->db->select('id');
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$query = $this->db->get('students');
		return $query->result();
	
	}
	
	function get_student_profile_image_by_student_id($student_id) {
	
		$this->db->where('student_id', $student_id);
		$query = $this->db->get("profile_image");
		
		return $query->result();
	
	}
	
	function delete_student_profile_image_by_student_id($student_id) {
		$this->db->where('student_id', $student_id);
		$query = $this->db->delete('profile_image');
		if($query) {
			return true;
		} else {
			return false;
		}
	}
	
}







