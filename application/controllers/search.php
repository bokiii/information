<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	private $student;
	private $teacher;
	private $subject;
	private $course;
	private $school;
	private $term;
	
	function __construct() {
		parent::__construct();
		$this->load->model('search_model');
		
		include_once (dirname(__FILE__) . "/students.php");
		include_once (dirname(__FILE__) . "/teachers.php");
		include_once (dirname(__FILE__) . "/subjects.php");
		include_once (dirname(__FILE__) . "/courses.php");
		include_once (dirname(__FILE__) . "/schools.php");
		include_once (dirname(__FILE__) . "/terms.php");
		
		$this->student = new Students();
		$this->teacher = new Teachers();
		$this->subject = new Subjects();
		$this->course = new Courses();
		$this->school = new Schools();
		$this->term = new Terms();
		
	}
	
	function index() {
	
		if($this->input->get("search")) {
			
			$table = $this->input->get("search");
			
			$fields = $this->db->list_fields($table);
			$keyword = $this->input->get("keyword");
			
			$this->load->model('search_model');
			
			$search = $this->search_model->search($table, $fields, $keyword);
			
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
			
		} else {
			show_404();
		}
	}

}