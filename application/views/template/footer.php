
		<div id="footer" class="full_width">
			<p>&copy; <?php echo date("Y"); ?> <a href="http://mastermindtechnology.org/">Mastermind Technology</a>. All rights reserved.</p>
		</div>
	
	</div> <!-- end container -->
	
	<!-- load tools below -->
	<?php
		$this->load->view('tools/popup.php');
		$this->load->view('tools/yes_or_no.php');
		
		if(isset($link_add_data) && $link_add_data != NULL) {
			
			$data = array(
				"link_add_datas" => array(
					"link_add_module" => $link_add_module,
					"link_add_data" => $link_add_data,
					"link_add_id" => $link_add_id,
					'link_add_table' => $search_table
				)
			);
			
			if(isset($check_box)) {
				$data['check_box'] =  $check_box;
			}
			
			$this->load->view('tools/link_add.php', $data);
		}
	?>

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jqueryui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/script.js"></script>

</body>
</html>