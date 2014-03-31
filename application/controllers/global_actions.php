<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Global_actions extends CI_Controller {
	
	private	$height1 = "30px";
	private	$height2 = "20px";
	
	
	function __construct() {
		parent::__construct();
	} 

	function students() {
		// set the search table
		$data['search_table'] = "students";
		
		// important set the height for the keyword input
		$data['keyword_height'] = $this->height2;
		
		$primary_view = base_url() . "index.php/students";
		$popup_form_action = base_url() . "index.php/students/add_student";

		$data['popup'] = '
			<a class="close" href="'. $primary_view .'">&#215;</a>
			<h1>Students</h1>
			<form action="' . $popup_form_action .' " method="post" id="add_form">
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
		
		$data['main_content'] = "tools/popup_option";
		$this->load->view('template/content', $data);
	}
	
}