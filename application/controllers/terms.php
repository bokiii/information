<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms extends CI_Controller {
	
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	private $table = "terms";
	private $add = "add_term";
	private $delete = "delete_term";
	
	public $search;
	public $search_status;
	public $keyword;
	
	// below are the variables for prompt 
	public $prompt_status;
	public $validation_errors;
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
	
		// call prompt below
		
		$this->prompt();
	
		// search table
		
		$data['search_table'] = $this->table;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/". $this->table ."/". $this->add . " ";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>". $this->table ."</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='term'>Term:</label></td>
						<td><input type='text' name='term' id'term' /></td>
						<td><label for='semester'>Semester:</label></td>
						<td><input type='text' name='semester' id='semester' /></td>
					</tr>
					<tr>
						<td><label for='school_year'>School Year:</label></td>
						<td><input type='text' name='school_year' id='school_year' /></td>
					</tr>
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		// content below 
		
		$content_action = base_url() . "index.php/". $this->table ."/". $this->delete . " ";
		$module_url = base_url() . "index.php/". $this->table ."";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>". $this->table ."</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>Term</th>
						<th>Semester</th>
						<th>School Year</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$term = $row->term;
					$semester = $row->semester;
					$school_year = $row->school_year;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$term}</a></td>
							<td>{$semester}</td>
							<td>{$school_year}</td>
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
			$get_content_data = $this->global_model->get($this->table);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$term = $row->term;
					$semester = $row->semester;
					$school_year = $row->school_year;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$term}</a></td>
							<td>{$semester}</td>
							<td>{$school_year}</td>
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
		$global_json_path = $this->load->view('tools/global_json_path', $path);
		
		$data['content'] .= "
				</table>
				<div id='actions'>
					{$global_json_path}
					<button id='add_button' value='". $this->table ."'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	}
	
	function add_term() {
		
		// call validation
		
		$this->validation('add');
		
		if($this->form_validation->run() == TRUE) {
			
			$data = array(
				"term" => $this->input->post('term'),
				"semester" => $this->input->post('semester'),
				"school_year" => $this->input->post('school_year')
			);
			
			$add_term = $this->global_model->add($this->table, $data);
			
			$this->prompt_status = true;
		} else {
			$this->prompt_status = false;
			$this->validation_errors = validation_errors();
			
		} 
		
		$this->index();
	}
	
	function delete_term() {
		
		$id = $this->input->post('id');
		$delete_term = $this->global_model->delete($this->table, $id);
		
		$this->index();
	}

	function update_term() {
		
		// call validation
		
		$this->validation('update');
		
		if($this->form_validation->run() == TRUE) {
		
			$data = array(
				"id" => $this->input->post('id'),
				"term" => $this->input->post('term'),
				"semester" => $this->input->post('semester'),
				"school_year" => $this->input->post('school_year')
			);
			
			$update_term = $this->global_model->update($this->table, $data, $data['id']);
			
			$this->prompt_status = true;
		} else {
			$this->prompt_status = false;
			$this->validation_errors = validation_errors();
		}
		
		$this->index();
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
	
	private function validation($action) {
		$this->load->library('form_validation');
		
		if($action == "add") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('term', 'Term', 'required');
			$this->form_validation->set_rules('semester', 'Semester', 'required');
			$this->form_validation->set_rules('school_year', 'School year', 'required');
		}
		
		if($action == "update") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			
			$this->form_validation->set_rules('term', 'Term', 'required');
			$this->form_validation->set_rules('semester', 'Semester', 'required');
			$this->form_validation->set_rules('school_year', 'School year', 'required');
		}
	}
	
	
}











