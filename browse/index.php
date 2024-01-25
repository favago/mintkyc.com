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
	<div style='font-size:2em;'>Select KYC Profile</div>
<?php

	require('../RES/config.php');

$db_con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$q = "SELECT * FROM kycprofiles";

$result = mysqli_query($db_con, $q);
$cn_rows = mysqli_num_rows($result);
echo "<div class='kyc_profiles_list' style='background: #bbbbbb;'><span style='width: 20px;'>#</span><span style='width: 485px;'>Full Name</span><span>Status</span><span>Type</span><span>Risk level</span><span>Jurisdiction</span><span>Expires in (days)</span></div>";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<a href='../edit/index.php?ID=" . $row['IndID'] . "' style='text-decoration: none; padding: 0; margin: 0;'><div class='kyc_profiles_list'><span style='width: 20px;'>" . $row['IndID'] . "</span><span style='width: 485px;'>" . $row['IndLastName'] . ", " . $row['IndFirstName'] . " " . $row['IndMiddleName'] . "</span><span>"; if ($row['IndStatus'] == 1) {
	echo "Analyst";
} elseif ($row['IndStatus'] == 2) {
	echo "QC";
} elseif ($row['IndStatus'] == 3) {
	echo "Approved";
} else {
	echo "Unknown";
} echo "</span><span>Individual</span><span>Standard</span><span>" . $row['IndPPoRS'] . "</span><span"; if ($row['IndExpiry'] <= 15) { echo " style='color: #d84a4a;'"; } elseif ($row['IndExpiry'] > 15 && $row['IndExpiry'] <= 30) { echo " style='color: #cc8989;'"; } echo "> " . $row['IndExpiry'] . "</span></div></a>";
    }
} else {
    echo "0 results";
}

mysqli_close($db_con);

?>
	<div class="rows_total">Total: <?php echo $cn_rows; ?></div><br><br>
	<a href='../saved/index.php?dl3=1'><div class='dl3'></div></a>
	
	<div class='footer'>
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>
</body>
</html>