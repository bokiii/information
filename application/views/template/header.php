<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Student Information System</title>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width_2.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width_3.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/dropdown.css" />
	
	<!--Link jquery ui css-->
	<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/redmond/jquery-ui.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/redmond.css" />
	
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
				<p class="left"><input style="height: <?php echo $keyword_height; ?>" type="text" name="keyword" id="keyword" placeholder="Search" value="<?php if(isset($keyword)) { echo $keyword; } ?>" /></p>                 
				<input type="hidden" name="search" value="<?php if(isset($search_table) && $search_table != NULL) { echo $search_table; } ?>" />
				<?php
					if(isset($search_manage_table) && $search_manage_table != NULL) {
						echo "<input type='hidden' name='search_manage_table' value='{$search_manage_table}' />";
						echo "<input type='hidden' name='search_manage_id' value='{$search_manage_id}' />";
					}
				?>
				<img class="left" src="<?php echo base_url(); ?>images/search_button.png" id="search_button" alt="Search Button" />
				<div class="clear"></div>
			</form>
			<ul class="right dropdown">
				<li class="main"><a href="#">Account</a>
					<ul class="sub_menu">
						<li><a href="#">Logout</a></li>
					</ul>
				</li>
				<li class="main"><a href="#">Maintenance</a>
					<ul class="sub_menu">
						<li><a href="<?php echo base_url(); ?>index.php/teachers">Teachers</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/terms">Terms</a></li>
					</ul>
				</li>
				<li class="main"><a href="#">Modules</a>
					<ul class="sub_menu">
						<li><a href="<?php echo base_url(); ?>index.php/students">Students</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/subjects">Subjects</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/courses">Courses</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/schools">Schools</a></li>
					</ul>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		