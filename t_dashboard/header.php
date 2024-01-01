<head>
	<title>APARTMENT MANAGEMENT SYSTEM</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles/w3.css">
	<link rel="stylesheet" href="styles/header.css">
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<nav class="w3-sidebar w3-bar-block w3-animate-right cam-blue w3-top w3-text-light-grey w3-large" style="z-index:101;width:170px;font-weight:bold;display:none;right:0;" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-4"><i class="fa fa-times"></i>CLOSE</a> 
  <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="gallery-button"><i class="fa fa-image"></i>Gallery</a> 
  <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="login-button"><i class="fa fa-sign-in"></i>Login</a> 
  <a href="register.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="register-button"><i class="fa fa-user-plus"></i>Register</a> 
  <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="profile-button"><i class="fa fa-user"></i>My Profile</a> 
  <a href="webcam.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="image-button"><i class="fa fa-camera"></i>Post Image</a> 
  <a href="account.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="pref-button"><i class="fa fa-cog"></i>Account</a> 
  <a href="includes/userHandler.php?action=logout" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="logout-bar"><i class="fa fa-sign-out"></i>Logout</a>
  <a href="../t_dashboard.php" onclick="w3_close()" class="w3-bar-item w3-button w3-center w3-padding-8 cam-blue" id="logout-bar"><i class="fa fa-sign-in"></i>Exit</a> 
  
</nav>

<header class="w3-container w3-top w3-xxlarge w3-padding-4 cam-dark-grey cam-head" style="z-index:100">
	<a href="index.php" class="w3-bar-item w3-button" id="camagru">Bulletin Board<i class="fa fa-camera-retro"></i></a>
	<a href="javascript:void(0)" class="w3-right w3-button" onclick="w3_open()">☰</a>
	<a href="includes/userHandler.php?action=logout" onclick="w3_close()" class="w3-right cam-blue w3-button" style="margin-top:-7px"id="logout-button"><i class="fa fa-sign-out"></i></a>
	  
</header>

<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	if (isset($_SESSION["current_user"])) {
		echo "<script type='text/javascript' src='includes/scripts/currentUser.js'></script>";
	} else {
		echo "<script type='text/javascript' src='includes/scripts/currentGuest.js'></script>";
	}
?>

<script type="text/javascript" src="includes/scripts/sidebar.js"></script>
