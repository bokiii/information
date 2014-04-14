
		<div id="footer" class="full_width">
			<p>&copy; <?php echo date("Y"); ?> <a href="http://mastermindtechnology.org/">Mastermind Technology</a>. All rights reserved.</p>
		</div>
	
	</div> <!-- end container -->
	
	<!-- load tools below -->
	<?php
		$this->load->view('tools/popup.php');
		$this->load->view('tools/yes_or_no.php');
	?>

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>scripts/script.js"></script>

</body>
</html>