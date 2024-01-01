<?php
    require "header.php";
    require "includes/Classes/User.class.php";
    
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    if (!isset($_SESSION['current_user']))
    {
        header("Location: index.php?error=forbiddenentry");
        exit();
    }

    if (isset($_POST['userNewPass']) && isset($_POST['userNewPassToo']))
    {
        $user = new User($_SESSION['current_user']);
        if ($user->changePassword($_POST['userNewPass']) == -1)
            header("Location: reset.php?error=passwordtooshort");
        if ($user->changePassword($_POST['userNewPass']) == -2)
            header("Location: reset.php?error=no special characters");
        if ($user->changePassword($_POST['userNewPass']) == 1)
            header("Location: index.php?success");
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/reset.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
        <div class="w3-container w3-content" id="main">
            <div class="w3-card cam-blue w3-auto" style="margin-top:15vh;max-width:350px;">
                <form class="w3-container form-container" style="color:white;" action="" name="reset-form" id="reset" method="POST">
                    <h3>Reset Password</h3>
                    <label for="password"><b> New Password </b></label>
                    <input type="password" placeholder="Enter New Password" name="userNewPass" required>
                    <label for="password"><b> Confirm New Password </b></label>
                    <input type="password" placeholder="Confirm New Password" name="userNewPassToo" required>
                    <button type="submit" name="reset-pw-sub" id="pw-btn" class="btn" value="UPDATE">UPDATE PASSWORD</button>
                </form>
            </div>
        </div>

        <br>
        <div class="w3-container w3-right-align cam-dark-grey w3-padding-4" stlye="max-height:50px">
            <p>© 2019 Camagru</p>
        </div>
    </body>
</html>