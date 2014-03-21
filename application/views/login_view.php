<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Online Student Information System</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>styles/login.css" />
</head>
<body>
	<div id="container">
		<div id="header">
			<img class="left" src="<?php echo base_url(); ?>images/graduate.png" alt="graduation hat" />
			<h1 class="left">Information <br />System</h1>
			<div class="clear"></div>
		</div>
		<div id="content">
			<div id="login">
				<img src="<?php echo base_url(); ?>images/anonymous.png" alt="Student Login Image" />
				<form action="<?php echo site_url(); ?>/login" method="post">
					<input class="login_input" type="text" name="username" placeholder="Username" />
					<input  class="login_input" type="password" name="password" placeholder="Password" />
					<input type="submit" value="Mag-sign in" />
				</form>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery2.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/script.js"></script>
	
	
</body>
</html>