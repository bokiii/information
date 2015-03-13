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
	
	function add_student_grade($data) {
		$query = $this->db->insert($this->students_grade_table, $data);
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
	
	
	// below are for all the functions of selecting the data for students after enrolled
	
	function get_student_main_data_by_id($id) {
	
		$this->db->select('students.id, students.first_name, students.last_name, students.middle_name, students_others.age, students_others.gender, students_others.birth_date, students_others.civil_status, students_others.religion, students_others.address, students_school.school, students_course.course, students_course.school_id');                                          
		$this->db->from('students');
		$this->db->join('students_others', "students_others.student_id = students.id", 'left');
		$this->db->join('students_school', "students_school.student_id = students.id", 'left');
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
	
	function get_student_subject_grade_by_student_subject_id($subject_id) {	
		$this->db->select('grade');
		$this->db->where('subject_id', $subject_id);
		$query = $this->db->get($this->students_grade_table);
		
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
			"address" => $other_data['address']
		);
		
		$this->db->where('student_id', $id);
		$query = $this->db->update($this->students_others_table, $data);
		
		if($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function update_student_grade_by_subject_id($grade, $subject_id) {
		
		$data = array(
			'grade' => $grade,
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
	
}







