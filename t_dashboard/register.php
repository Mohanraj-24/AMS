<?php
	require "header.php";
?>
<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/register.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Prints errors to console when registering and captcha not verified -->
	</head>
	<body>
		<div class="w3-container w3-content" style="max-width:362px;" id="main">
			<!-- <div class="w3-row">
				<div class="w3-col" style="max-width:330px;"> -->
					<div class="w3-card cam-blue w3-auto" style="margin-top:15vh;">
						<form class="w3-container form-container" style="max-width:330px;color:white;" action="includes/userHandler.php?action=register" name="login-form" id="login" method="POST">
							<h1>Register</h1>
							<label for="username"><b>Username</b></label>
							<input type="text" placeholder="Enter Username" name="userLogin">
							<?php
								if (isset($_GET['error']))
								{
									if ($_GET['error'] === "emptyfields")
										echo ("<p id='error'>Please fill in all fields.</p>");
									else if ($_GET['error'] === "usernametaken")
										echo ("<p id='error'>That username is already taken.</p>");
								}
							?>
							<label for="email"><b>Email</b></label>
							<input type="email" placeholder="Enter Email" name="userEmail">
							<label for="psw"><b>Password</b></label>
							<input type="password" placeholder="Enter Password" name="userPass">
							<label for="psw"><b>Repeat Password</b></label>
							<input type="password" placeholder="Repeat Password" name="userPassRepeat">
							<label for="myfile">Select a file:</label>
							<input type="file" id="myfile" name="myfile">
							<?php
								if (isset($_GET['error']))
								{
									if ($_GET['error'] === "passwordmismatch")
										echo ("<p id='error'>Passwords did not match.</p>");
									else if ($_GET['error'] === "shortpassword")
										echo ("<p id='error'>Password must be at least 8 characters long.</p>");
									else if ($_GET['error'] === "nospecial")
										echo ("<p id='error'>Password must contain special characters.</p>");
								}
							?>
							<button type="submit" name="register-submit" id="login-btn" class="btn" value="REGISTER">Register</button>
							<div class="g-recaptcha" data-sitekey="6Ldnd8MUAAAAALqs-BL0TMM5Hsa2Xzas2jmqzwLy"></div>
							<br>
						</form>
					</div>
			<!-- </div>
			</div> -->
		</div>
	<br>
	<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
		<p>© 2023 Virat</p>
	</div>
	</body>
</html>