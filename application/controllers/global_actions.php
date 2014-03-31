<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_actions extends CI_Controller {
	
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	
	function __construct() {
		parent::__construct();
	} 

	function students() {
		//set the main table
		$table = "students";
		
		// set the search table
		$data['search_table'] = "students";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		// set the module url
		$module_url = base_url() . "index.php/students";
		
		if($this->input->get('action') == "update" && $this->input->get('id')) {
			
			$id = $this->input->get('id');
			
			$get_by_id = $this->global_model->get_by_id($table, $id);
			
			foreach($get_by_id as $row) {
				$first_name = $row->first_name;
				$last_name = $row->last_name;
				$middle_name = $row->middle_name;
				$address = $row->address;
			}
			
			$primary_view = base_url() . "index.php/students";
			$popup_form_action = base_url() . "index.php/students/update_student";

			$data['popup'] = '
				<a class="close" href="'. $primary_view .'">&#215;</a>
				<h1><a href="'. $module_url .'">Students</a></h1>
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
			
			$primary_view = base_url() . "index.php/students";
			$popup_form_action = base_url() . "index.php/students/add_student";

			$data['popup'] = '
				<a class="close" href="'. $primary_view .'">&#215;</a>
				<h1><a href="'. $module_url .'">Students</a></h1>
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
	
}