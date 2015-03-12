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
		
		if($this->session->userdata('allowed') != true) {
			redirect("login");
		}
	
		$this->load->model('terms_model');
		
	}
	
	function debug($data) {
		echo "<pre>";
			print_r($data);
		echo "</pre>";
	}
	
	private function get_validation_errors() {
		return $this->validation_errors;
	}
	
	private function set_validation_errors($error_value) {
		$this->validation_errors = $error_value;
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
						<td>
							<select name='term' id='term'>
								<option value='first'>First Year</option>
								<option value='second'>Second Year</option>
								<option value='third'>Third Year</option>
								<option value='fourth'>Fourth Year</option>
							</select>
						</td>
						
						<td><label for='semester'>Semester:</label></td>
						<td>
							<select name='semester' id='semester'>
								<option value='first'>First Semester</option>
								<option value='second'>Second Semester</option>
							</select>
						</td>
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
						<th class='order'>Order</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$term = ucwords($row->term);
					$semester = ucwords($row->semester);
					$order = $row->order;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$term}</a></td>
							<td>{$semester}</td>
							<td class='order'>{$order}</td>
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
			
			//$get_content_data = $this->global_model->get($this->table);
			$get_content_data = $this->terms_model->get_terms_with_order();
			
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$term = ucwords($row->term);
					$semester = ucwords($row->semester);
					$order = $row->order;
				
					$update_link = base_url() . "index.php/global_actions/". $this->table ."?action=update&id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$term}</a></td>
							<td>{$semester}</td>
							<td class='order'>{$order}</td>
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
		
		// set array posted data to variable
		$posted_term_data = $this->input->post();
	
		// call validation
		$add_validate = $this->add_validation($posted_term_data);
		
		if($add_validate) {
			
			$data = array(
				"term" => $this->input->post('term'),
				"semester" => $this->input->post('semester')
			);
			
			$add_term = $this->global_model->add($this->table, $data);
			
			$this->prompt_status = true;
			
		} else {
			$this->prompt_status = false;
		}
		
		$this->index();
	}
	
	function delete_term() {
		
		$id = $this->input->post('id');
		
		// delete term
		$delete_term = $this->global_model->delete($this->table, $id);
		
		// delete subjects included with the term
		$delete_subjects_by_term_id = $this->terms_model->delete_subjects_by_term_id($id);
	
		
		$this->index();
	}

	function update_term() {
		
		// set array posted data to variable
		
		$posted_term_data = $this->input->post();
		
		$update_validate = $this->update_validation($posted_term_data);
		
		if($update_validate) {
			
			$data = array(
				"id" => $this->input->post('id'),
				"term" => $this->input->post('term'),
				"semester" => $this->input->post('semester'),
				"order" => trim($this->input->post('order'))
			);
			
			$update_term = $this->global_model->update($this->table, $data, $data['id']);
			
			$this->prompt_status = true;
		} else {
			
			$this->prompt_status = false;
			$this->validation_errors = $this->get_validation_errors();
		}
		
		$this->index();
		
		
	}

	private function prompt() {
		if($this->prompt_status === true) {
			$promp_data['message'] = "<p>Sucess</p>";
			$promp_data['class'] = "success";
			$this->load->view('tools/prompt', $promp_data);
		} else if($this->prompt_status === false) {
			$promp_data['message'] = $this->get_validation_errors();
			$promp_data['class'] = "error";
			$this->load->view('tools/prompt', $promp_data);
		}
	}
	
	private function add_validation($data) {
	
		$term = $data['term'];
		$semester = $data['semester'];
		
		$empty_error = false;
		$exist_error = false;
		
		$errors = "";
		
		if($term == NULL || $semester == NULL) {
			$errors .= "<p>One of the fields is empty.</p>";
			$empty_error = true;
		} else {
			
			// check the term in database 
			$term_exists = $this->terms_model->term_exists($term);
			$semester_exists = $this->terms_model->semester_exists($semester);
			
			$term_and_semester_exists = $this->terms_model->term_and_semester_exists($term, $semester);
			
			if($term_and_semester_exists != NULL) {
				$all_fields_exists = true;
				$errors .= "<p>Term added already exists</p>";
				$exist_error = true;
			}
			
		
			
		}
		
		// check empty error and exist error for the return
		
		if($empty_error || $exist_error) {	
			$this->set_validation_errors($errors);
			return false;
		} else {
			return true;
		}
		
	} // end add vaidation
	
	private function update_validation($data) {
	
		$term = $data['term'];
		$semester = $data['semester'];
		$order = trim($data['order']);
		
		$have_error = false;
		
		$errors = "";
		
		if($term == NULL || $semester == NULL || $order == NULL) {
			$errors .= "<p>One of the fields is empty.</p>";
			$have_error = true;
		}

		if($order != NULL) {
			$valid_number = is_numeric($order);
			if($valid_number != true) {
				$errors .= "<p>Order is not a valid number.</p>";
				$have_error = true;
			}
		}
		
		if($have_error) {
			$this->set_validation_errors($errors);
			return false;
		} else {
			return true;
		}
		
	}
	

}












