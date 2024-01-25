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
<link rel="shortcut icon" href="../RES/favicon.ico" type="image/x-icon">
<link rel="icon" href="../RES/favicon.ico" type="image/x-icon">
</head>
<body>


<?php

	require('../RES/config.php');

$db_con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

$cn_q = "SELECT * FROM kycprofiles";

$cn_rows = mysqli_num_rows(mysqli_query($db_con, $cn_q));

// odbieramy dane z formularza

if (isset($_POST['but_save'])) {

$IndID = $_GET['ID'];
$IndTitle = $_POST['IndTitle'];
$IndFirstName = $_POST['IndFirstName'];
$IndMiddleName = $_POST['IndMiddleName'];
$IndLastName = $_POST['IndLastName'];
$IndFormerName = $_POST['IndFormerName'];

$IndVerDoc = $_POST['IndVerDoc'];
$IndVerDocValidity = $_POST['IndVerDocValidity'];
$IndIDDocNo = $_POST['IndIDDocNo'];
$IndGender = $_POST['IndGender'];
$IndNationality = $_POST['IndNationality'];
$IndDoB = $_POST['IndDoB'];
$IndPoB = $_POST['IndPoB'];

$IndAddressVerDoc = $_POST['IndAddressVerDoc'];
$IndAddressVerDocValidity = $_POST['IndAddressVerDocValidity'];
$IndAddress1 = $_POST['IndAddress1'];
$IndAddress2 = $_POST['IndAddress2'];
$IndAddress3 = $_POST['IndAddress3'];
$IndAddressPC = $_POST['IndAddressPC'];
$IndAddressTC = $_POST['IndAddressTC'];
$IndPPoRS = $_POST['IndPPoRS'];

$IndSancs = $_POST['IndSancs'];
$IndPEPS = $_POST['IndPEPS'];
$IndAdvNewsS = $_POST['IndAdvNewsS'];

$IndSoF = $_POST['IndSoF'];

$q = "UPDATE `kycprofiles` SET
`IndTitle` = '" . $IndTitle . "',
`IndFirstName` = '" . $IndFirstName . "', 
`IndMiddleName` = '" . $IndMiddleName . "', 
`IndLastName` = '" . $IndLastName . "', 
`IndFormerName` = '" . $IndFormerName . "', 

`IndVerDoc` = '" . $IndVerDoc . "', 
`IndVerDocValidity` = '" . $IndVerDocValidity . "',
`IndIDDocNo` = '" . $IndIDDocNo . "',
`IndGender` = '" . $IndGender . "',
`IndNationality` = '" . $IndNationality . "',
`IndDoB` = '" . $IndDoB . "',
`IndPoB` = '" . $IndPoB . "',

`IndAddressVerDoc` = '" . $IndAddressVerDoc . "',
`IndAddressVerDocValidity` = '" . $IndAddressVerDocValidity . "',
`IndAddress1` = '" . $IndAddress1 . "',
`IndAddress2` = '" . $IndAddress2 . "',
`IndAddress3` = '" . $IndAddress3 . "',
`IndAddressPC` = '" . $IndAddressPC . "',
`IndAddressTC` = '" . $IndAddressTC . "',
`IndPPoRS` = '" . $IndPPoRS . "',

`IndSancs` = '" . $IndSancs . "',
`IndPEPS` = '" . $IndPEPS . "',
`IndAdvNewsS` = '" . $IndAdvNewsS . "',

`IndSoF` = '" . $IndSoF . "'

WHERE `IndID` = " . $IndID . "";

} elseif (isset($_POST['but_submit'])) {
	
$q = "UPDATE kycprofiles SET IndStatus = 2 WHERE IndID = " . $_GET['ID'] . "";
$q2 = "INSERT INTO `kycaudittrial` (`IndID`, `ATdate`, `ATtext`) VALUES ('" . $_GET['ID'] . "', CURRENT_TIMESTAMP, 'Submitted by Analyst to QC');";
mysqli_query($db_con, $q2);

} elseif (isset($_POST['create_new'])) {

$q = "INSERT INTO `kycprofiles` (`IndID`, `IndStatus`, `IndTitle`, `IndFirstName`, `IndMiddleName`, `IndLastName`, `IndFormerName`, `IndVerDoc`, `IndVerDocValidity`, `IndIDDocNo`, `IndGender`, `IndNationality`, `IndDoB`, `IndPoB`, `IndAddressVerDoc`, `IndAddressVerDocValidity`, `IndAddress1`, `IndAddress2`, `IndAddress3`, `IndAddressPC`, `IndAddressTC`, `IndPPoRS`, `IndSancs`, `IndPEPS`, `IndAdvNewsS`, `IndSoF`, `IndExpiry`, `IndCreatedDate`) VALUES (NULL, '1', '', '". $_POST['IndFirstName'] ."', '', '". $_POST['IndLastName'] ."', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '120', CURRENT_TIMESTAMP);";

} elseif (isset($_POST['but_qc_approve'])) {
	
$q = "UPDATE kycprofiles SET IndStatus = 3 WHERE IndID = " . $_GET['ID'] . "";
$q2 = "INSERT INTO `kycaudittrial` (`IndID`, `ATdate`, `ATtext`) VALUES ('" . $_GET['ID'] . "', CURRENT_TIMESTAMP, 'Approved by QC');";
mysqli_query($db_con, $q2);

} elseif (isset($_POST['but_qc_reject'])) {

$q = "UPDATE kycprofiles SET IndStatus = 1 WHERE IndID = " . $_GET['ID'] . "";
$q2 = "INSERT INTO `kycaudittrial` (`IndID`, `ATdate`, `ATtext`) VALUES ('" . $_GET['ID'] . "', CURRENT_TIMESTAMP, 'Rejected by QC to Analyst');";
mysqli_query($db_con, $q2);
	
} elseif ($_GET['dl3'] == 1) {

$q = "DELETE FROM kycprofiles ORDER BY IndID DESC limit 3";
	
}

?>

	<div style='height: 180px;'></div>
	<?php

if ($cn_rows >= 10 && isset($_POST['create_new'])) {
		echo "<div class='login_panel_header'><p>mintKYC</p></div>
		<div class='login_panel'>
			<h1>Hold on!</h1>
			<br />
			The number of KYC profiles in demo mode is limtied to 10.
			<br />
			<br />			
			<a href='../dashboard' style='font-size: 1.4em;'>Go to dashboard</a>
		</div>";
} else {
	
		if (mysqli_query($db_con, $q)) {
		echo "<div class='login_panel_header'><p>mintKYC</p></div>
		<div class='login_panel'>
			<h1>Got it!</h1>
			<br />
			<br />
			<a href='../dashboard' style='font-size: 1.4em;'>Go to dashboard</a>
		</div>";
	} else {
		echo "Error.";
	}
}

mysqli_close($db_con);
	
	?>
	
	
	<div class='footer' style="padding-top: 300px;">
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>
</body>
</html>