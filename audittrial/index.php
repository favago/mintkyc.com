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
<?php

$IndID = $_GET['ID'];

	require('../RES/config.php');

$db_con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$q = "SELECT * FROM kycaudittrial WHERE `IndID` = " . $IndID . " ORDER BY ATdate ASC";
$q2 = "SELECT IndFirstName, IndMiddleName, IndLastName, IndCreatedDate FROM kycprofiles WHERE `IndID` = " . $IndID;

$result = mysqli_query($db_con, $q);
$result2 = mysqli_query($db_con, $q2);

$row2 = mysqli_fetch_assoc($result2);

echo "<div style='font-size:2em;'>Audit trial &mdash; " . $row2['IndLastName'] . ", " . $row2['IndFirstName'] . " " . $row2['IndMiddleName'] . "</div>";

echo "<div class='kyc_profiles_list' style='background: #bbbbbb;'><span style='width: 300px;'>Timestamp</span><span style='width: 600px;'>Action</span></div>";
echo "<div class='kyc_profiles_list'><span style='width: 300px;'>" . $row2['IndCreatedDate'] . "</span><span style='width: 600px;'>KYC profile created</span></div>";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='kyc_profiles_list'><span style='width: 300px;'>" . $row['ATdate'] . "</span><span style='width: 600px;'>" . $row['ATtext'] . "</span></div>";
}}

echo "<div style='margin-top: 25px; text-align: center;'><a href='../edit/index.php?ID=" . $IndID . "' style='margin: 0;'><button type='button' class='button'>Back</button></a></div>";

mysqli_close($db_con);

?>
	<a href='../saved/index.php?dl3=1'><div class='dl3'></div></a>
	
	<div class='footer'>
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>
</body>
</html>