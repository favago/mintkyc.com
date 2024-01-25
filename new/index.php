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
  <form name="IndFormNew" action="../saved/index.php" method="post">
  <div class='section'>
    <h2>INITIAL INFORMATION</h2><br /><br />
    <p>First name</p><input type='text' name='IndFirstName' value='' class='input' autofocus><span>First name, e.g. Michael</span><br /><br />
    <p>Last name</p><input type='text' name='IndLastName' value='' class='input'><span>Last name, e.g. Lopez</span><br /><br />
  </div>
  <div class="buttons">
  <button type="submit" name="create_new" class="button">Create new KYC profile</button>
  </div>
  </form>
  <div class='footer'>
    Copyright &copy; 2016 - <?php echo date("Y") ?> mintKYC. All rights reserved.
  </div>
</body>
</html>