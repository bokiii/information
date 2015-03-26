<!DOCTYPE HTML>
<html lang="en-US" ng-app="information">
<head>
	<meta charset="UTF-8">
	<title>Student Information System</title>
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/style.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width_2.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/full_width_3.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/dropdown.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/manage_students.css" />
	
	<!--Link jquery ui css-->
	<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/redmond/jquery-ui.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/redmond.css" />
	
</head>
<body>
	<div id="container">
		<div id="header" class="full_width">
			<div id="logo" class="left">
				<img class="left" src="<?php echo base_url(); ?>images/graduate.png" alt="" />
				<h1 class="right">Student <br />Information <br /> System</h1>
				<div class="clear"></div>
			</div>
			
			<ul style="margin: 50px 0px 0px 20px;" class="right dropdown">
				<li class="main"><a href="#">Account</a>
					<ul class="sub_menu">
						<li><a href="<?php echo base_url(); ?>index.php/logout">Logout</a></li>
					</ul>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		
		
		
		