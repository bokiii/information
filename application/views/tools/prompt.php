<link rel="stylesheet" href="<?php echo base_url(); ?>styles/prompt.css" />

<div id="prompt_container">
	<div id="prompt_content" class="<?php if(isset($class) && $class != NULL) { echo $class; } ?>">
		<a class='close' href='#'>&#215;</a>
		<h1>Execution Status</h1>
		<?php echo $message; ?>
	</div>
</div>