<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends CI_Controller {
	
	public	$height1 = "30px";
	public	$height2 = "20px";
	
	public $table = "subjects";
	public $add = "add_subject";
	public $delete = "delete_subject";
	
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
						<td><label for='course_no'>Course No.:</label></td>
						<td><input type='text' name='course_no' id'course_no' /></td>
						<td><label for='descriptive_title'>Descriptive Title:</label></td>
						<td><input type='text' name='descriptive_title' id='descriptive_title' /></td>
					</tr>
					<tr>
						<td><label for='credit'>Credit:</label></td>
						<td><input type='text' name='credit' id='credit' /></td>
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
						<th>Course No.</th>
						<th>Descriptive Title</th>
						<th>Credit</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$course_no = $row->course_no;
					$descriptive_title = $row->descriptive_title;
					$credit = $row->credit;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course_no}</a></td>
							<td>{$descriptive_title}</td>
							<td>{$credit}</td>
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
					$course_no = $row->course_no;
					$descriptive_title = $row->descriptive_title;
					$credit = $row->credit;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$course_no}</a></td>
							<td>{$descriptive_title}</td>
							<td>{$credit}</td>
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
		
		$global_json_path = $this->load->view('tools/global_json_path');
		
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
	
	function add_subject() {
		
		// call validation
		
		$this->validation('add');
		
		if($this->form_validation->run() == TRUE) {
			
			$data = array(
				"course_no" => $this->input->post('course_no'),
				"descriptive_title" => $this->input->post('descriptive_title'),
				"credit" => $this->input->post('credit')
			);
			
			$add_subject = $this->global_model->add($this->table, $data);
			
			$this->prompt_status = true;
		} else {
			$this->prompt_status = false;
			$this->validation_errors = validation_errors();
			
		} 
		
		$this->index();
	
	}
	
	function delete_subject() {
	
		$id = $this->input->post('id');
		$delete_subject = $this->global_model->delete($this->table, $id);
	
		$this->index();
		
	}
	
	function update_subject() {
		
		// call validation
		
		$this->validation('update');
		
		if($this->form_validation->run() == TRUE) {
		
			$data = array(
				"id" => $this->input->post('id'),
				"course_no" => $this->input->post('course_no'),
				"descriptive_title" => $this->input->post('descriptive_title'),
				"credit" => $this->input->post('credit')
			);
			
			$update_subject = $this->global_model->update($this->table, $data, $data['id']);
			
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
			$this->form_validation->set_rules('course_no', 'Course no.', 'required|is_unique[subjects.course_no]');
			$this->form_validation->set_rules('descriptive_title', 'Descriptive Title', 'required');
			$this->form_validation->set_rules('credit', 'Credit', 'required|is_natural');
		}
		
		if($action == "update") {
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s already exists.');
			$this->form_validation->set_message('is_natural', '%s is not a valid number.');
			$this->form_validation->set_rules('course_no', 'Course no.', 'required');
			$this->form_validation->set_rules('descriptive_title', 'Descriptive Title', 'required');
			$this->form_validation->set_rules('credit', 'Credit', 'required|is_natural');
		}
	}
	
	
}










