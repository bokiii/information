<link rel="stylesheet" href="<?php echo base_url(); ?>styles/link_add.css" />

<div id="link_add_container">
	<div id="link_add_content">
		<a class='close' href='#'>&#215;</a>
		<h1><?php echo $link_add_datas['link_add_module']; ?></h1>
		<div>
			<?php
				
				/*echo "<pre>";
					print_r($link_add_datas);
				echo "</pre>";*/	
				
			?>
			<form action="<?php echo base_url(); ?>index.php/<?php echo $link_add_datas['link_add_table'] ?>/link_add" method="post">
				<?php
					
					if(isset($check_box)) {	
					
						for($i=0; $i < count($link_add_datas['link_add_data']); $i++) {
							echo "<p><input type='checkbox' name='main_id[]' value='". $link_add_datas['link_add_id'][$i] ."' /> <span class='link_add_text'>" . $link_add_datas['link_add_data'][$i] . "</span></p>";
						}
						
					} else {
					
						for($i=0; $i < count($link_add_datas['link_add_data']); $i++) {
							echo "<p><input type='radio' name='main_id' value='". $link_add_datas['link_add_id'][$i] ."' /> <span class='link_add_text'>" . $link_add_datas['link_add_data'][$i] . "</span></p>";
						}
						
					}
					
				?>
				<input type="submit" value="Update" />
			</form>
		</div>
	</div>
</div>