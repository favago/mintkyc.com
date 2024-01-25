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

<?php

	require('../RES/config.php');

$db_con = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

// IndID

$IndID = $_GET['ID'];

$q = "SELECT * FROM kycprofiles WHERE IndID=" . $IndID . "";

$result = mysqli_query($db_con, $q);
$row = mysqli_fetch_assoc($result);

mysqli_close($db_con);

?>

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
		<div class="top_bar_profile_info">
			<a href="#"><i class="fa fa-file-text-o" aria-hidden="true" style="padding-right: 15px;"></i>Individual</a>
			<div style="text-align: center;">
				KYC Profile type cannot be modified in demo mode. We're sorry.
			</div>
			<a href="#"><i class="fa fa-flag" aria-hidden="true" style="padding-right: 15px;"></i>Standard</a>
			<div style="text-align: center;">
				KYC Profile risk rating cannot be modified in demo mode. We're sorry.
			</div>			
		</div>
	</div>

	<div style='height: 70px;'></div>
	<?php if ($_SESSION['login'] == 'qc' && $row['IndStatus'] == 2) {echo "<div class='demo_info'>QC comments are unavailable in demo mode. You can either approve or reject this KYC profile by selecting a respective button at the end of this page.</div>";} ?>
	<form name="IndForm" action="../saved/index.php?ID=<?php echo $IndID; ?>" method="post">
	<div class='section'>
		<h2>GENERAL INFORMATION</h2><br /><br />
		<p>Title</p><input type='text' name='IndTitle' value='<?php echo $row['IndTitle']; ?>' class='input' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Individual's (honorific) title, e.g. Mr, Sheikh</span><br /><br />
		<p>First name</p><input type='text' name='IndFirstName' value='<?php echo $row['IndFirstName']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>First name, e.g. Michael</span><br /><br />
		<p>Middle name</p><input type='text' name='IndMiddleName' value='<?php echo $row['IndMiddleName']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Middle name, e.g. Daniel</span><br /><br />
		<p>Last name</p><input type='text' name='IndLastName' value='<?php echo $row['IndLastName']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Last name, e.g. Lopez</span><br /><br />
		<p>Former name</p><input type='text' name='IndFormerName' value='<?php echo $row['IndFormerName']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Former name. It might be a maiden name for females, e.g. Smith</span><br /><br />
	</div>
	<div class='section'>
		<h2>ID VERIFICATION</h2><br /><br />
		<p>ID verification document</p>
			<select class='select' name='IndVerDoc'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndVerPassport"<?php $ValueIndVerDoc = "IndVerPassport"; if($ValueIndVerDoc==$row['IndVerDoc']) { echo "selected='selected'"; } ?>>Passport</option>
				<option value="IndVerNationalID"<?php $ValueIndVerDoc = "IndVerNationalID"; if($ValueIndVerDoc==$row['IndVerDoc']) { echo "selected='selected'"; } ?>>National ID Card</option>
				<option value="IndVerDL"<?php $ValueIndVerDoc = "IndVerDL"; if($ValueIndVerDoc==$row['IndVerDoc']) { echo "selected='selected'"; } ?>>Driving Licence</option>
			</select>
		<span>Select proper supporting document type</span>
		<br /><br />
		<p>Attach ID verification document</p><input type="file" class="input"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Attach proper supporting document</span><br /><br />
		<p>ID verification document validity</p>
			<select class='select' id='IndVerDocValidity' name='IndVerDocValidity' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndVerDocValid"<?php $ValueIndVerDocValidity = "IndVerDocValid"; if($ValueIndVerDocValidity==$row['IndVerDocValidity']) { echo "selected='selected'"; } ?>>Valid</option>
				<option value="IndVerDovInvalid"<?php $ValueIndVerDocValidity = "IndVerDovInvalid"; if($ValueIndVerDocValidity==$row['IndVerDocValidity']) { echo "selected='selected'"; } ?>>Expired</option>	
			</select>
			<span>Confirm supporting document validity</span>
			<div class='hr_notification0' id='hr_notification0'<?php if($row['IndVerDocValidity'] != "IndVerDovInvalid") {echo "style='display: none;'";} ?>>Expired document cannot be accepted. Obtain the current one.</div>	
		<br /><br />
		<p>ID verification document unique number</p><input type='text' name='IndIDDocNo' value='<?php echo $row['IndIDDocNo']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Document's unique ID number, i.e. ZS 8874273</span><br /><br />
		<p>Gender</p>
			<select class='select' name='IndGender'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="male"<?php $ValueIndGender = "male"; if($ValueIndGender==$row['IndGender']) { echo "selected='selected'"; } ?>>Male</option>
				<option value="female"<?php $ValueIndGender = "female"; if($ValueIndGender==$row['IndGender']) { echo "selected='selected'"; } ?>>Female</option>
			</select>
		<span>Confirm individual's gender</span>
		<br /><br />
		<p>Nationality</p>
			<select class='select' id='IndNationality' name='IndNationality'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="Jersey"<?php $ValueIndNationality = "Jersey"; if($ValueIndNationality==$row['IndNationality']) { echo "selected='selected'"; } ?>>Jersey</option>
				<option value="Russia"<?php $ValueIndNationality = "Russia"; if($ValueIndNationality==$row['IndNationality']) { echo "selected='selected'"; } ?>>Russia</option>
			</select>
			<span>Confirm individual's nationality. Please note that your answer may pose additional risk</span>
			<div class='hr_notification1' id='hr_notification1'<?php if($row['IndNationality'] != "Russia") {echo "style='display: none;'";} ?>>High risk jurisdiction has been identified. Consider adjusting the risk level.</div>
		<br /><br />
		<p>Date of Birth</p><input type='text' name='IndDoB' value='<?php echo $row['IndDoB']; ?>' class='input' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide date of birth, i.e. 22/04/1953</span><br /><br />
		<p>Place of Birth</p>
			<select class='select' id='IndPoB' name='IndPoB'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="" selected="selected">Select...</option>
				<option value="Jersey"<?php $ValueIndPoB = "Jersey"; if($ValueIndPoB==$row['IndPoB']) { echo "selected='selected'"; } ?>>Jersey</option>
				<option value="Russia"<?php $ValueIndPoB = "Russia"; if($ValueIndPoB==$row['IndPoB']) { echo "selected='selected'"; } ?>>Russia</option>
			</select>
			<span>Confirm individual's country of birth. Please note that your answer may pose additional risk</span>
			<div class='hr_notification3' id='hr_notification3'<?php if($row['IndPoB'] != "Russia") {echo "style='display: none;'";} ?>>High risk jurisdiction has been identified. Consider adjusting the risk level.</div>
		<br /><br />
	</div>
	<div class='section'>
		<h2>ADDRESS VERIFICATION</h2><br /><br />
		<p>Address verification document</p>
			<select class='select' name='IndAddressVerDoc'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndAddressVerBankStatement"<?php $ValueIndAddressVerDoc = "IndAddressVerBankStatement"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Bank statement</option>
				<option value="IndAddressVerUtBill"<?php $ValueIndAddressVerDoc = "IndAddressVerUtBill"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Utility bill</option>
				<option value="IndAddressVerGovCorr"<?php $ValueIndAddressVerDoc = "IndAddressVerGovCorr"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Government correspondence</option>
				<option value="IndAddressVerLoT"<?php $ValueIndAddressVerDoc = "IndAddressVerLoT"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Letter of introduction</option>
				<option value="IndAddressVerTenantC"<?php $ValueIndAddressVerDoc = "IndAddressVerTenantC"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Tenancy contract</option>
				<option value="IndAddressSiteVisit"<?php $ValueIndAddressVerDoc = "IndAddressSiteVisit"; if($ValueIndAddressVerDoc==$row['IndAddressVerDoc']) { echo "selected='selected'"; } ?>>Site visit</option>
			</select>
		<span>Select proper supporting document type</span>
		<br /><br />		
		<p>Attach address verification document</p><input type="file" class="input"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Attach proper supporting document</span><br /><br />
		<p>Address verification document validity</p>
			<select class='select' id='IndAddressVerDocValidity' name='IndAddressVerDocValidity' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndAddressVerDocValid"<?php $ValueIndAddressVerDocValidity = "IndAddressVerDocValid"; if($ValueIndAddressVerDocValidity==$row['IndAddressVerDocValidity']) { echo "selected='selected'"; } ?>>Valid</option>
				<option value="IndAddressVerDovInvalid"<?php $ValueIndAddressVerDocValidity = "IndAddressVerDovInvalid"; if($ValueIndAddressVerDocValidity==$row['IndAddressVerDocValidity']) { echo "selected='selected'"; } ?>>Expired</option>
			</select>
			<span>Confirm supporting document validity</span>
			<div class='hr_notification4' id='hr_notification4'<?php if($row['IndAddressVerDocValidity'] != "IndAddressVerDovInvalid") {echo "style='display: none;'";} ?>>Expired document cannot be accepted. Obtain the current one.</div>	
		<br /><br />
		<p>Address #1</p><input type='text' name='IndAddress1' value='<?php echo $row['IndAddress1']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide first line of the address, i.e. Business Tower</span><br /><br />
		<p>Address #2</p><input type='text' name='IndAddress2' value='<?php echo $row['IndAddress2']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide second line of the address, i.e. 12 High Street</span><br /><br />
		<p>Address #3</p><input type='text' name='IndAddress3' value='<?php echo $row['IndAddress3']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide third line of the address, i.e. Financial District</span><br /><br />
		<p>Post code</p><input type='text' name='IndAddressPC' value='<?php echo $row['IndAddressPC']; ?>' class='input' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide post code, i.e. 113-983</span><br /><br />
		<p>Town/City</p><input type='text' name='IndAddressTC' value='<?php echo $row['IndAddressTC']; ?>' class='input'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Provide name of the town or city, i.e. San Diego</span><br /><br />
		<p>Country</p>
			<select class='select' id='IndPPoRS' name='IndPPoRS'<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="Jersey"<?php $ValueIndPPoRS = "Jersey"; if($ValueIndPPoRS==$row['IndPPoRS']) { echo "selected='selected'"; } ?>>Jersey</option>
				<option value="Russia"<?php $ValueIndPPoRS = "Russia"; if($ValueIndPPoRS==$row['IndPPoRS']) { echo "selected='selected'"; } ?>>Russia</option>
			</select>
			<span>Confirm individual's country of residence. Please note that your answer may pose additional risk</span>
			<div class='hr_notification2' id='hr_notification2'<?php if($row['IndPPoRS'] != "Russia") {echo "style='display: none;'";} ?>>High risk jurisdiction has been identified. Consider adjusting the risk level.</div>
		<br /><br />
	</div>
	<div class='section'>
		<h2>SCREENING</h2><br /><br />
		<p>Attach screening results</p><input type="file" class="input"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><span>Attach screening results</span><br /><br />
		<p>Is the individual sanctioned?</p>
			<select class='select' id='IndSancs' name='IndSancs' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="Yes"<?php $ValueIndSancs = "Yes"; if($ValueIndSancs==$row['IndSancs']) { echo "selected='selected'"; } ?>>Yes</option>
				<option value="No"<?php $ValueIndSancs = "No"; if($ValueIndSancs==$row['IndSancs']) { echo "selected='selected'"; } ?>>No</option>
			</select>
			<span>Confirm sanctions screening results. Please note that your answer may pose additional risk</span>
			<div class='hr_notification6' id='hr_notification6'<?php if($row['IndSancs'] != "Yes") {echo "style='display: none;'";} ?>>Sanctions have been identified. Consult Compliance Team.</div>
		<br /><br />
		<p>PEP screening results</p>
			<select class='select' id='IndPEPS' name='IndPEPS' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndPEP"<?php $ValueIndPEPS = "IndPEP"; if($ValueIndPEPS==$row['IndPEPS']) { echo "selected='selected'"; } ?>>PEP</option>
				<option value="IndNonPEP"<?php $ValueIndPEPS = "IndNonPEP"; if($ValueIndPEPS==$row['IndPEPS']) { echo "selected='selected'"; } ?>>Non-PEP</option>
			</select>
			<span>Confirm PEP screening results. Please note that your answer may pose additional risk</span>
			<div class='hr_notification5' id='hr_notification5'<?php if($row['IndPEPS'] != "IndPEP") {echo "style='display: none;'";} ?>>Person has been identified as PEP. Consider adjusting the risk level.</div>
		<br /><br />
		<p>Material adverse news found?</p>
			<select class='select' id='IndAdvNewsS' name='IndAdvNewsS' style="width: 100px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>>
				<option value="">Select...</option>
				<option value="IndAdvNewsYes"<?php $ValueIndAdvNewsS = "IndAdvNewsYes"; if($ValueIndAdvNewsS==$row['IndAdvNewsS']) { echo "selected='selected'"; } ?>>Yes</option>
				<option value="IndAdvNewsNo"<?php $ValueIndAdvNewsS = "IndAdvNewsNo"; if($ValueIndAdvNewsS==$row['IndAdvNewsS']) { echo "selected='selected'"; } ?>>No</option>
			</select>
			<span>Confirm adverse news screening results. Please note that your answer may pose additional risk</span>
			<div class='hr_notification7' id='hr_notification7'<?php if($row['IndAdvNewsS'] != "IndAdvNewsYes") {echo "style='display: none;'";} ?>>Material adverse news found. Consult Compliance.</div>
		<br /><br />
	</div>
	<div class='section'>
		<h2>SOURCE OF FUNDS</h2><br /><br />
		<p style="position: relative; top: -150px;">Source of Funds</p>
		<textarea id='IndSoF' name='IndSoF' class="input" style="height: 150px;"<?php if ($row['IndStatus'] != 1 OR $_SESSION['login'] == 'qc') { echo " disabled"; } ?>><?php echo $row['IndSoF']; ?></textarea>
		<span>Summarise individual's source of funds</span>
	</div>
	<h2><br /></h2><br /><br />
	<div class="buttons">
		<?php
		
		if ($_SESSION['login'] == 'analyst') {
		
		if ($row['IndStatus'] != 1) { $buttton_inactive = " disabled"; } else { $buttton_inactive = NULL; }
		
		echo "<button type='submit' name='but_save' class='button'" . $buttton_inactive . ">Save</button>";
		if ($row['IndStatus'] != 1) { echo "<div>KYC Profile is either already approved or currently being reviewed by QC. You cannot save it.</div>"; }
		echo "<button type='submit' name='but_submit' class='button'" . $buttton_inactive . ">Submit for approval</button>";
		if ($row['IndStatus'] != 1) { echo "<div>KYC Profile is either already approved or currently being reviewed by QC. You cannot submit it.</div>"; }
		echo "<a href='../audittrial/index.php?ID=" . $IndID . "' style='margin: 0;'><button type='button' class='button'>Audit trial</button></a>";
		} elseif ($_SESSION['login'] == 'qc') {
			
		if ($row['IndStatus'] != 2) { $buttton_inactive = " disabled"; } else { $buttton_inactive = NULL; }		
		
		echo "<button type='submit' name='but_qc_approve' class='button'" . $buttton_inactive . ">Approve</button>";
		if ($row['IndStatus'] != 2) { echo "<div>KYC Profile is either already approved or currently being processed by Analyst. You cannot approve it.</div>"; }
		echo "<button type='submit' name='but_qc_reject' class='button'" . $buttton_inactive . ">Reject</button>";
		if ($row['IndStatus'] != 2) { echo "<div>KYC Profile is either already approved or currently being processed by Analyst. You cannot reject it.</div>"; }
		echo "<a href='../audittrial/index.php?ID=" . $IndID . "' style='margin: 0;'><button type='button' class='button'>Audit trial</button></a>";
		}	
		?>
	</div>
	</form>
	<div class='footer'>
		Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
	</div>
</body>
</html>