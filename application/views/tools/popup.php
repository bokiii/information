<!-- popup css below -->
<link rel="stylesheet" href="<?php echo base_url(); ?>styles/popup.css" />

<div id="popup_container">
	<div id="popup_content">
		<?php
			if(isset($popup) && $popup != NULL) {
				echo $popup;
			}
		?>
	</div>
</div>