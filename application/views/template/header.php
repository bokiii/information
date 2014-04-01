<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Student Information System</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/dropdown.css" />
</head>
<body>
	<div id="container">
		<div id="header" class="full_width">
			<div id="logo" class="left">
				<img class="left" src="<?php echo base_url(); ?>images/graduate.png" alt="" />
				<h1 class="right">Information <br /> System</h1>
				<div class="clear"></div>
			</div>
			<form action="<?php echo base_url(); ?>index.php/search" method="get" id="search_form" class="left">
				<p class="left"><input style="height: <?php echo $keyword_height ?>" type="text" name="keyword" id="keyword" placeholder="Search" value="<?php if(isset($keyword)) { echo $keyword; } ?>" /></p>                 
				<input type="hidden" name="search" value="<?php if(isset($search_table) && $search_table != NULL) { echo $search_table; } ?>" />
				<img class="right" src="<?php echo base_url(); ?>images/search_button.png" id="search_button" alt="Search Button" />
				<div class="clear"></div>
			</form>
			<ul class="right dropdown">
				<li><a href="#">Account</a>
					
				</li>
				<li><a href="#">Maintenance</a>
					<ul class="sub_menu">
						<li><a href="#">Teachers</a></li>
						<li><a href="#">Subjects</a></li>
					</ul>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		
		
		