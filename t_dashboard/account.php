<?php

	if (session_status() == PHP_SESSION_NONE)
		session_start();
		
	if (!isset($_SESSION['current_user']))
		header ("Location: login.php");

	// require "./t_dashboard/header.php";
    require_once ('C:/xampp/htdocs/ams/t_dashboard/header.php');
	require "./includes/Classes/User.class.php";

	if ($_GET['error'])
		echo "<script type='text/javascript'> alert('There was a problem updating that information'); </script>";
		

	if (isset($_SESSION["current_user"]))
		$user = new User($_SESSION["current_user"]);

	if (isset($_POST["userLogin"]))
	{
		$login = str_replace("<","&lt;",$_POST["userLogin"]);
		if ($user->setLogin($login))
		{
			echo "<script type='text/javascript'> alert('Username Changed! Please login using new details.'); </script>";
			echo "<script type='text/javascript'> document.location = './includes/userHandler.php?action=logout'; </script>";
		}
		else
		{
			echo "<script type='text/javascript'> alert('Username already taken, please try taking a different one'); </script>";
		}
	}
	if (isset($_POST["userEmail"]) && isset($_POST["userPass"]))
	{
		$pass = str_replace("<","&lt;",$_POST["userPass"]);
		$email = str_replace("<","&lt;",$_POST["userEmail"]);
		if ($user->setEmail($pass,$email))
			echo "<script type='text/javascript'> alert('Email Updated!'); </script>";
		else
			header ("Location: account.php?error");
	}
	if (isset($_POST["userFirstName"]) && isset($_POST["userLastName"]))
	{
		$first = str_replace("<","&lt;",$_POST["userFirstName"]);
		$last = str_replace("<","&lt;",$_POST["userLastName"]);
		if ($user->setFirstName($first) && $user->setLastName($last))
			echo "<script type='text/javascript'> alert('Name & Surname updated!'); </script>";
		else
			header ("Location: account.php?error");
	}

	if (isset($_POST["userBio"]))
	{
		$bio = str_replace("<","&lt;",$_POST["userBio"]);
		if ($user->setBio($bio))
			echo "<script type='text/javascript'> alert('Bio Updated!'); </script>";
		else
			header ("Location: account.php?error");
	}
	if (isset($_POST["userOldPass"]) && isset($_POST["userNewPass"]) && isset($_POST["userNewPassToo"]))
	{
		if ($_POST["userNewPass"] == $_POST["userNewPassToo"]) {
			$old = str_replace("<","&lt;",$_POST["userOldPass"]);
			$new = str_replace("<","&lt;",$_POST["userNewPass"]);
			if ($user->setPassword($old,$new))
				echo "<script type='text/javascript'> alert('Password Updated!'); </script>";
			else
				header ("Location: account.php?error");
		}
		else
			echo "<script type='text/javascript'> alert('New Passwords do not match!'); </script>";
		

	}
	if (isset($_POST["subscribed"]))
		if ($_POST["subscribed"] === "1") {
			if ($user->setSubscribed(1))
				echo "<script type='text/javascript'> alert('Email Notifications Enabled!'); </script>";
			else
				header ("Location: account.php?error");
		}
		else {
			if ($user->setSubscribed(0))
				echo "<script type='text/javascript'> alert('Email Notifications Disabled!'); </script>";
			else
				header ("Location: account.php?error");
		}

	if (isset($_POST["resend"])) {
		if ($_POST["resend"] === "yes") {
			$user->email();
			echo "<script type='text/javascript'> alert('Verification Email Sent!'); </script>";
		}
	}

	if (isset($_FILES['fileToUpload'])) {
		if ($user->setImage(file_get_contents($_FILES['fileToUpload']['tmp_name'])))
			echo "<script type='text/javascript'> alert('Profile Picture Updated!'); </script>";
		else
			header ("Location: account.php?error");		
	}

	if (isset($_POST["delete"])) {
		if ($_POST["delete"] === "yes") {
			echo "<script type='text/javascript'> alert('Your account has been deleted!'); </script>";
			echo "<script type='text/javascript'> document.location = './includes/userHandler.php?action=unregister'; </script>";
		}
	}
?>

<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/account.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="w3-container w3-main" style="margin-top:85px;">
			<div class="w3-container w3-content" style="max-width:1200px;min-width:300px;">
				<div class="w3-row">
					<div class="w3-col m12 l12">
						<div class="cam-blue w3-card">
							<div class="w3-container">

								<h2 class="w3-center w3-text-black">ACCOUNT SETTINGS</h2>

								<hr>
								<!-- USERNAME -->
								<form class="w3-container form-container update" style="color:black;" name="update-form" id="update-uname" method="POST">
									<h3>Change Username</h3>
									<label for="username"><b>New Username</b></label>
									<input type="text" placeholder="Enter New Username" name="userLogin" required>
									<button type="submit" name="update-uname-sub" id="uname-btn" class="btn" value="UPDATE">UPDATE USERNAME & LOGOUT</button>
								</form>

								<hr>
								<!-- EMAIL -->
								<form class="w3-container form-container" style="color:black;" name="update-form" id="update-email" method="POST">
									<h3>Change Email</h3>
									<label for="email"><b> New Email</b></label>
									<input type="email" placeholder="Enter New Email" name="userEmail" required>
									<label for="pw"><b> Verify Password</b></label>
									<input type="password" placeholder="Verify Password" name="userPass" required>
									<button type="submit" name="update-email-sub" id="email-btn" class="btn" value="UPDATE">UPDATE EMAIL</button>
								</form>

								<hr>
								<!-- PASSWORD -->
								<form class="w3-container form-container" style="color:black;" name="update-form" id="update-pw" method="POST">
									<h3>Change Password</h3>
									<label for="password"><b> Current Password </b></label>
									<input type="password" placeholder="Enter Current Password" name="userOldPass" required>
									<label for="password"><b> New Password </b></label>
									<input type="password" placeholder="Enter New Password" name="userNewPass" required>
									<label for="password"><b> Confirm New Password </b></label>
									<input type="password" placeholder="Confirm New Password" name="userNewPassToo" required>
									<button type="submit" name="update-pw-sub" id="pw-btn" class="btn" value="UPDATE">UPDATE PASSWORD</button>
								</form>

								<hr>
								<!-- FIRST LAST NAME -->
								<form class="w3-container form-container update" style="color:black;" name="update-form" id="update-names" method="POST">
									<h3>Update Name & Surname</h3>
									<label for="name"><b> First Name</b></label>
									<input type="text" placeholder="Enter First Name" name="userFirstName" required>
									<label for="surname"><b>Last Name</b></label>
									<input type="text" placeholder="Enter Last Name" name="userLastName" required>
									<button type="submit" name="update-fl-name-sub" id="fl-name-btn" class="btn" value="UPDATE">UPDATE NAME</button>
								</form>

								<hr>
								<!-- BIO -->
								<form class="w3-container form-container" style="color:black;" name="update-bio-form" id="update-bio" method="POST">
									<h3>Change Bio</h3>
									<label for="bio"><b>Update Bio</b></label>
									<textarea rows='3' placeholder='Enter Bio' name='userBio' form='update-bio' required></textarea>
									<button type="submit" name="update-bio-sub" id="bio-btn" class="btn" value="UPDATE">UPDATE BIO</button>
								</form>

								<hr>
								<!-- PROFILE PICTURE -->
								<form class="w3-container form-container w3-text-black" name="update-pp-form" id="update-pp" method="post" enctype="multipart/form-data">
									<h3>Change Profile Photo</h3>
									<label for="propic"><b>Select image to upload:</b></label>
									<br>
									<input class="w3-image" type="file" name="fileToUpload" id="fileToUpload" accept="image/png">
									<br>
									<button type="submit" value="UPDATE" id="pp-btn" class="btn" name="submit-pp">UPDATE PROFILE PICTURE</button>
								</form>

								<hr>
								<!-- EMAIL SUB -->
								<form class="w3-container form-container update" style="color:black;" name="update-form" id="update-sub" method="POST">
									<h3>Email Notifications</h3>
									<label for="msg"><b>Enable email notifications when comments are made on your posts?</b></label>
									<br>
									<?php
										if ($user->userSubscribed)
											echo "<p id='sub-status'>CURRENTLY: ENABLED</p>";
										else
											echo "<p id='sub-status'>CURRENTLY: DISABLED</p>";
									?>
									<br>
									<input type="radio" name="subscribed" id="sub-true" value="1" checked> YES <br>
									<input type="radio" name="subscribed" id="sub-false" value="0"> NO <br>
									<br>
									<button type="submit" name="update-sub" id="sub-btn" class="btn" value="UPDATE">UPDATE NOTIFICATION</button>
								</form>

								<hr>
								<!-- EMAIL VERIF -->
								<form class="w3-container form-container update" style="color:black;" name="update-form" id="update-verif" method="POST">
									<h3>Resend Verification Email</h3>
									<input type="radio" name="resend" id="verif-true" value="yes" required> YES <br>
									<br>
									<button type="submit" name="send-verif" id="verif-btn" class="btn" value="UPDATE">RESEND EMAIL</button>
								</form>

								<hr>
								<!-- DELETE ACC -->
								<form class="w3-container form-container update" style="color:black;" name="update-form" id="update-del" method="POST">
									<h3>Delete Account</h3>
									<p id="sub-status">Are you absolutely certain you would like to delete your account? This action is irreversible!</p>
									<br>
									<input type="radio" name="delete" id="delete-true" value="yes" required> YES <br>
									<br>
									<button type="submit" name="delete-acc" id="delacc-btn" class="btn delete-acc-btn" value="DELETE">DELETE ACCOUNT</button>
								</form>

								<hr>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<br>

		<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
			<p>© 2019 Camagru</p>
		</div>

	</body>
</html>
