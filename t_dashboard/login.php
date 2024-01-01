<?php
	require "header.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/login.css">
		<link rel="stylesheet" href="styles/modal.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
		<!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script> -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="w3-container w3-content" style="max-width:362px;" id="main">
			<!-- <div class="w3-row">
				<div class="w3-col" style="max-width:330px;"> -->
					<div class="w3-card cam-blue w3-auto" style="margin-top:15vh;">
						<form class="w3-container form-container" style="max-width:330px;color:white;" action="includes/userHandler.php?action=login" name="login-form" id="login" method="POST">
							<h1>Login</h1>
							<label for="username"><b>Username</b></label>
							<input type="text" placeholder="Enter Username" name="userLogin" required>
							<?php
								if (isset($_GET['error']))
								{
									if ($_GET['error'] === "invaliduser")
										echo ("<p id='error'>User does not exist.</p>");
								}
							?>
							<label for="psw"><b>Password</b></label>
							<input type="password" placeholder="Enter Password" name="userPass" required>
							<?php
							if (isset($_GET['error']))
								{
									if ($_GET['error'] === "accountDeleted")
										echo "<script> alert('This account has either been banned, or deleted'); </script>";
									if ($_GET['error'] === "emptyfields")
										echo ("<p id='error'>Please fill in all fields.</p>");
									else if ($_GET['error'] === "wrongpassword")
										echo ("<p id='error'>Incorrect password.</p>");
								}
							?>
							<button type="submit" name="login-submit" class="btn" value="LOGIN"> Login </button>
							<div class="w3-container w3-right-align">
								<p id="new-user">New User? <a href="register.php">Register.</a></p>
								<p id="new-user">Forgot Password? <a onclick="document.getElementById('reset').style.display='block'" href="#">Reset.</a></p>
							</div>
						</form>
					</div>
				<!-- </div>
			</div> -->
		</div>
		<div class="w3-modal" id="reset">
			<div class="w3-modal-content w3-card w3-animate-opacity w3-auto" style="max-width:330px;margin-left:auto;margin-right:auto;">
				<span class="w3-button-cam w3-xlarge w3-hover-red w3-display-topright" style="color:black;" onclick="document.getElementById('reset').style.display='none'" title="Close">&times;</span>
				<form class="w3-container form-container cam-blue w3-auto" style="color:black;max-width:330px;" action="includes/userHandler.php?action=forgot" name="pw-form" id="forgot" method="POST">
					<h1>Forgot Password</h1>
					<label for="username"><b>Enter Username</b></label>
					<input type="text" placeholder="Enter Username" name="userLogin" required>
					<button type="submit" name="reset-submit" class="btn" value="RESET"> Reset </button>
				</form>
			</div>
		</div>
	<br>
	<div class="w3-container w3-right-align cam-dark-grey w3-padding-4" stlye="max-height:50px">
		<!-- <p>© 2019 Camagru</p> -->
	</div>

	<script>
		var modal = document.getElementById('reset');

		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
	</body>
</html>
