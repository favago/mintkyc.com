<?php
session_start();

if ($_SESSION['login'] == NULL) {
	header('Location: ../welcome/');
}
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="../unhideDiv.js"></script>
<link rel="shortcut icon" href="../RES/favicon.ico" type="image/x-icon">
<link rel="icon" href="../RES/favicon.ico" type="image/x-icon">
</head>
<body>

	<div class="top_bar">
		<div class="top_bar_logo">
			<a>mintKYC</a>
			<div>
				<ul>
					<li><a href="../dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
					<li><a href="../logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Log out</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div style='height: 120px;'></div>	
	<div style='font-size:2em; float: left; width: 500px;'>Welcome, <?php
										if ($_SESSION['login'] == 'analyst') {
										echo "Analyst";
										} elseif ($_SESSION['login'] == 'qc') {
										echo "QC";	
										}	
										?>!
										</div>
	
	<div style='font-size:2em;'>Expiring KYC profiles</div>
	<div class="dashboard_button_container">
		<a href="../new"><div class="dashboard_button" id="dashboard_button"><i class="fa fa-plus fa-5x" aria-hidden="true"></i><br /><br />New profile</div></a>
		<span>Create new KYC profile.</span>
		<a href="../browse"><div class="dashboard_button"><i class="fa fa-list-ol fa-5x" aria-hidden="true"></i><br /><br />Existing profiles</div></a>
		<span>Browse existing KYC profiles.</span>
		<a href="#"><div class="dashboard_button" id="dashboard_button_inactive"><i class="fa fa-cog fa-5x" aria-hidden="true"></i><br /><br />Settings</div></a>
		<span style="background: #ffbfbf;">Settings are not available in demo mode. We're sorry.</span>
		<a href="../logout"><div class="dashboard_button"><i class="fa fa-sign-out fa-5x" aria-hidden="true"></i><br /><br />Log out</div></a>
		<span>Thank you for using mintKYC. See you soon.</span>
	</div>
	
	<?php
	
	require('../RES/config.php');
	
	$db_con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);
	
	$q = "SELECT IndID, IndFirstName, IndMiddleName, IndLastName, IndStatus, IndExpiry FROM `kycprofiles` WHERE IndExpiry <= 30 AND IndStatus <> 3 ORDER BY IndExpiry ASC LIMIT 7;";
	
	$result = mysqli_query($db_con, $q);
	
	?>
	
	<div class="dashboard_recent">
	<div class='kyc_profiles_list_short' style='background: #bbbbbb;'><span style='width: 70px;'>#</span><span style='width: 550px;'>Full Name</span><span>Status</span><span style='width: 300;'>Expires in (days)</span></div>
	<?php
	
	function give_color($color) { if ($color <= 15) { echo " style='color: #d84a4a;'"; } elseif ($color > 15 && $color <= 30) { echo " style='color: #cc8989;'"; } }
	
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<a href='../edit/index.php?ID=" . $row['IndID'] . "' style='text-decoration: none; padding: 0; margin: 0;'><div class='kyc_profiles_list_short'><span style='width: 70px;'>" . $row['IndID'] . "</span><span style='width: 550px;'>" . $row['IndLastName'] . ", " . $row['IndFirstName'] . " " . $row['IndMiddleName'] ."</span><span>"; if($row['IndStatus'] == 1) {echo "Analyst";} elseif($row['IndStatus'] == 2) {echo "QC";} echo "</span><span"; give_color($row['IndExpiry']); echo ">" . $row['IndExpiry'] . "</span></div></a>";
}}
	?>
	<div style='font-size:2em; margin-top: 30px; margin-bottom: 30px;'>Recent activity</div>
	<!-- CUT -->

	<div class='kyc_profiles_list_short' style='background: #bbbbbb;'><span style='width: 70px;'>#</span><span style='width: 550px;'>Action</span><span>Timestamp</span></div>
	<?php
	
	$q_log = "SELECT * FROM kycaudittrial ORDER BY ATdate DESC LIMIT 5";
	
	$result_log = mysqli_query($db_con, $q_log);
	
	if (mysqli_num_rows($result_log) > 0) {
    // output data of each row
    while($row_log = mysqli_fetch_assoc($result_log)) {
        echo "<a style='text-decoration: none; padding: 0; margin: 0;'><div class='kyc_profiles_list_short_nohl'><span style='width: 70px;'>" . $row_log['IndID'] . "</span><span style='width: 550px;'>" . $row_log['ATtext'] . "</span><span style='width: 230px;'>" . $row_log['ATdate'] . "</span></div></a>";
}}
	?>
	
	<!-- CUT -->
	</div>
	<div style="clear:both">	
	<div class='footer' style="padding-top: 80px;">
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>
</body>
</html>