<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public $student;
	public $teacher;
	public $subject;
	public $course;
	public $school;
	public $term;
	public $school_course;
	private $course_subject;
	private $subject_teacher;
	
	function __construct() {
		parent::__construct();
		$this->load->model('search_model');
	
		include_once (dirname(__FILE__) . "/students.php");
		include_once (dirname(__FILE__) . "/teachers.php");
		include_once (dirname(__FILE__) . "/subjects.php");
		include_once (dirname(__FILE__) . "/courses.php");
		include_once (dirname(__FILE__) . "/schools.php");
		include_once (dirname(__FILE__) . "/terms.php");
		include_once (dirname(__FILE__) . "/school_courses.php");
		include_once (dirname(__FILE__) . "/course_subjects.php");
		include_once (dirname(__FILE__) . "/subject_teachers.php");
		
		$this->student = new Students();
		$this->teacher = new Teachers();
		$this->subject = new Subjects();
		$this->course = new Courses();
		$this->school = new Schools();
		$this->term = new Terms();
		$this->school_course = new School_courses();
		$this->course_subject = new Course_subjects();
		$this->subject_teacher = new Subject_teachers();
		
	}
	
	function index() {
	
		if($this->input->get("search")) {
			
			if($this->input->get('search_manage_table')) {
				
				$table = $this->input->get('search');
				
				$search_manage_table = $this->input->get('search_manage_table');
				$search_manage_id = $this->input->get('search_manage_id');
				
				$fields = $this->db->list_fields($table);
				$manage_fields = $this->db->list_fields($search_manage_table);
				$keyword = $this->input->get("keyword");
				
				// start the search
			
				$search = $this->search_model->search($search_manage_table, $manage_fields, $keyword);
				
				if($search != NULL) {
					$manage_data_id = array();
					foreach($search as $row) {
						array_unshift($manage_data_id, $row->id);
					}
					
					$manage_search = $this->search_model->search_by_id_and_main_id($table, $fields, $manage_data_id, $search_manage_id);
					
					// below are for manage modules 
					
					if($table == "school_courses") {
						$this->school_course->search_status = true;
						$this->school_course->search = $manage_search;
						$this->school_course->keyword = $keyword;
						$this->school_course->index($search_manage_id);
					}
					
					if($table == "course_subjects") {
						$this->course_subject->search_status = true;
						$this->course_subject->search = $manage_search;
						$this->course_subject->keyword = $keyword;
						$this->course_subject->index($search_manage_id);
					}
					
					if($table == "subject_teachers") {
						$this->subject_teacher->search_status = true;
						$this->subject_teacher->search = $manage_search;
						$this->subject_teacher->keyword = $keyword;
						$this->subject_teacher->index($search_manage_id);
					}
					
				} else {
					
					if($table == "school_courses") {
						$this->school_course->search_status = true;
						$this->school_course->search = NULL;
						$this->school_course->keyword = $keyword;
						$this->school_course->index($search_manage_id);
					}
					
					if($table == "course_subjects") {
						$this->course_subject->search_status = true;
						$this->course_subject->search = NULL;
						$this->course_subject->keyword = $keyword;
						$this->course_subject->index($search_manage_id);
					}
					
					if($table == "subject_teachers") {
						$this->subject_teacher->search_status = true;
						$this->subject_teacher->search = NULL;
						$this->subject_teacher->keyword = $keyword;
						$this->subject_teacher->index($search_manage_id);
					}
					
				}
				
			} else {
			
				$table = $this->input->get("search");
			
				$fields = $this->db->list_fields($table);
				$keyword = $this->input->get("keyword");
			
				$search = $this->search_model->search($table, $fields, $keyword);
				
				// below are for the standard modules 
				
				if($table == "students") {
					$this->student->search_status = true;
					$this->student->search = $search;
					$this->student->keyword = $keyword;
					$this->student->index();
				} 
				
				if($table == "teachers") {
					$this->teacher->search_status = true;
					$this->teacher->search = $search;
					$this->teacher->keyword = $keyword;
					$this->teacher->index();
				} 
				
				if($table == "subjects") {
					$this->subject->search_status = true;
					$this->subject->search = $search;
					$this->subject->keyword = $keyword;
					$this->subject->index();
				}
				
				if($table == "courses") {
					$this->course->search_status = true;
					$this->course->search = $search;
					$this->course->keyword = $keyword;
					$this->course->index();
				}
				
				if($table == "schools") {
					$this->school->search_status = true;
					$this->school->search = $search;
					$this->school->keyword = $keyword;
					$this->school->index();
				}
				
				if($table == "terms") {
					$this->term->search_status = true;
					$this->term->search = $search;
					$this->term->keyword = $keyword;
					$this->term->index();
				}
				
			}
			
		} else {
			show_404();
		}
	}

}