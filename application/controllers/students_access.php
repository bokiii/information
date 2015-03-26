<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_access extends CI_Controller {  

	function __construct() {
		parent::__construct();
	}  
	
	
	function index() {
		echo "<p>Hello lets access the sudents</p>";
	}


}