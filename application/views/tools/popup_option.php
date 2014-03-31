<!-- popup css below -->
<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup_option.css" />

<div id="popup_option">
	<div id="popup_content">
		<?php
			if(isset($popup) && $popup != NULL) {
				echo $popup;
			}
		?>
	</div>
</div>