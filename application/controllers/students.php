<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {
	
	private $table = "students";
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	public $search;
	public $search_status;
	public $keyword;
	
	function __construct() {
		parent::__construct();
		$this->search_status = false;
	}
	
	function index() {
	
		$data['search_table'] = $this->table;
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height1;
		
		// keyword 
		if($this->keyword != NULL) {
			$data['keyword'] = $this->keyword;
		}
		
		// popup below 
		
		$popup_form_action = base_url() . "index.php/students/add_student";
		
		$data['popup'] = "
			<a class='close' href='#'>&#215;</a>
			<h1>Students</h1>
			<form action='{$popup_form_action}' method='post' id='popup_form'>
				<table>
					<tr>
						<td><label for='first_name'>First Name:</label></td>
						<td><input type='text' name='first_name' id'first_name' /></td>
						<td><label for='last_name'>Last Name:</label></td>
						<td><input type='text' name='last_name' id='last_name' /></td>
					</tr>
					<tr>
						<td><label for='middle_name'>Middle Name:</label></td>
						<td><input type='text' name='middle_name' id='middle_name' /></td>
						<td><label for='address'>Address:</label></td>
						<td><input type='text' name='address' id='address' /></td>
					</tr>
					<tr>
						<td colspan='4'><input class='popup_actions' type='submit' value='Add'/><input class='popup_actions clear' type='reset' value='Clear' /></td>
					</tr>
				</table>
			</form>
		";
		
		// content below 
		
		$content_action = base_url() . "index.php/students/delete_student";
		$module_url = base_url() . "index.php/students";
		
		$data['content'] = "
			<h1><a href='{$module_url}'>Students</a></h1>
			<form action='{$content_action}'  method='post' id='delete_form'>
				<table>
					<tr>
						<th><input type='checkbox' class='main_check'  /></th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Middle Name</th>
						<th>Address</th>
					</tr>
		";
		
		
		if($this->search_status == true) {
			$get_content_data = $this->search;
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$first_name = $row->first_name;
					$last_name = $row->last_name;
					$middle_name = $row->middle_name;
					$address = $row->address;
				
					$update_link = base_url() . "index.php/global_actions/students?action=update&id={$id}";
					
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
							<td>{$address}</td>
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td colspan='5'>No results found.</td>
					</tr>
				";
			}
		} else {
			$get_content_data = $this->global_model->get($this->table);
			if($get_content_data != NULL) {
				foreach($get_content_data as $row) {
					$id = $row->id;
					$first_name = $row->first_name;
					$last_name = $row->last_name;
					$middle_name = $row->middle_name;
					$address = $row->address;
				
					$update_link = base_url() . "index.php/global_actions/students?action=update&id={$id}";
				
					$data['content'] .= "
						<tr>
							<td><input type='checkbox' name='id[]' value='{$id}' class='sub_check' /></td>
							<td><a href='{$update_link}'>{$first_name}</a></td>
							<td>{$last_name}</td>
							<td>{$middle_name}</td>
							<td>{$address}</td>
						</tr>
					";
				}
			} else {
				$data['content'] .= "
					<tr>
						<td colspan='5'>No students added in the database</td>
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
					<button id='add_button' value='students'>Add</button>
					<button id='delete_button'>Delete</button>
				</div>
			</form>
		";
		
		// load view below 
		
		$data['main_content'] = "main_view";
		$this->load->view('template/content', $data);
	}
	
	function add_student() {
		
		$data = array(
			"first_name" => $this->input->post('first_name'),
			"last_name" => $this->input->post('last_name'),
			"middle_name" => $this->input->post('middle_name'),
			"address" => $this->input->post('address')
		);
		
		$add_student = $this->global_model->add($this->table, $data);
		
		if($add_student) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect("students");
		
		//echo json_encode($data);
	}

	function delete_student() {
		
		$id = $this->input->post('id');
		$delete_student = $this->global_model->delete($this->table, $id);
		
		if($delete_student) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect("students");
	}
	
	function update_student() {
		
		$data = array(
			"id" => $this->input->post('id'),
			"first_name" => $this->input->post('first_name'),
			"last_name" => $this->input->post('last_name'),
			"middle_name" => $this->input->post('middle_name'),
			"address" => $this->input->post('address')
		);
		
		$update_student = $this->global_model->update($this->table, $data, $data['id']);
		
		if($update_student) {
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		
		redirect("students");
	}
	
	
} // end class