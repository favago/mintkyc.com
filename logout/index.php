<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>mintKYC DEMO</title>
<meta charset="utf-8">
<meta name="author" content="Piotr Antypiuk">
<link rel="stylesheet" href="../style.css">
<link href="https://fonts.googleapis.com/css?family=Julius+Sans+One|Lato|Baloo+Bhaina" rel="stylesheet">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="../RES/favicon.ico" type="image/x-icon">
<link rel="icon" href="../RES/favicon.ico" type="image/x-icon">
</head>
<body>
	
	<div style='height: 180px;'></div>
	<div class="login_panel_header"><p>mintKYC</p></div>
	<div class="login_panel">
		<h1>See you soon.</h1>
		<br />
		<br />
		<a href="../welcome" style="font-size: 1.4em;">Go back to login panel</a>
	</div>
	
	<div class='footer' style="padding-top: 300px;">
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>
	
</body>
</html>