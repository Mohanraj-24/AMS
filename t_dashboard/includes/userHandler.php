<?php

	require_once "./Classes/User.class.php";
	function password_reset($email, $code)
	{
		$message = "Reset your email here! http://localhost/camagru/index.php?action=forgot&code=$code";
		$subject = "Reset your password!";
		$headers = "From: CameronSTaljaard@gmail.com"."\r\n";
		$headers .= "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

		mail($email, $subject, $message, $headers);
		header("Location: ../index.php");
	}
	function login() {
		// require __DIR__ . '/../config.php';
		require('C:/xampp/htdocs/ams/config.php');
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "ams_db";

		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			header("Location: ../index.php?error=PDOerror");
		}
		if (session_status() == PHP_SESSION_NONE)
			session_start();
			
		if(isset($_POST['login-submit']))
		{
			$username = $_POST["userLogin"];
			$password = $_POST["userPass"];
	
			if (empty($username) || empty($password)) {
				header("Location: ../login.php?error=emptyfields&uid=".$username);
				exit();
			}
			else
			{
				$sql = "SELECT * FROM users WHERE userLogin=?;";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$username]);
				$user = $stmt->fetch();
				if ($user)
				{
					if ($user['userPermissions'] == 0)
					{
						header ("Location: ../login.php?error=accountDeleted");
						exit();
					}
					if ($user['userEmailVerified'] == 0)
					{
						header ("Location: ../login.php?error=verificationRequired");
						exit();
					}
					$pwdCheck = password_verify($password, $user["userPass"]);
					if ($pwdCheck === false)
					{
						header("Location: ../login.php?error=wrongpassword&uid=".$username);
						exit();
					}
					else if ($pwdCheck === true)
					{
						if (session_status() == PHP_SESSION_NONE)
							session_start();

						$_SESSION["current_user"] = $user["userLogin"];
						header("Location: ../index.php?login=success");
						exit();
					}
					else
					{
						header("Location: ../login.php?error=typeerror&uid=".$username);
						exit();
					}
				}
				else
				{
					header("Location: ../login.php?error=invaliduser&uid=".$username);
					exit();
				}
			}
		}
		else
		{
			header("Location: ../login.php?error=forbiddenentry");
			exit();
		}
	}
	
	function logout() {
		if (session_status() == PHP_SESSION_NONE)
			session_start();
		session_unset();
		session_destroy();
		header("Location: ../index.php");
	}

	function register() {
		require('C:/xampp/htdocs/ams/config.php');
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";   
		$dbname = "ams_db";

		if (session_status() == PHP_SESSION_NONE)
			session_start();

		$captcha = $_POST['g-recaptcha-response'];
		if (!$captcha)
		{
			header("Location: ../register.php?error=noCaptcha");
			exit();
		}

		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			header("Location: ../index.php?error=PDOerror");
		}
		if (session_status() == PHP_SESSION_NONE)
			session_start();

		if(isset($_POST["register-submit"]))
		{	
			$username = $_POST["userLogin"];
			$email = $_POST["userEmail"];
			$password = $_POST["userPass"];
			$password_repeat = $_POST["userPassRepeat"];
			$verify = 1;
			$user_image=$_POST["myfile"];
			$data=file_get_contents("../images/$user_image");
	
			if (empty($username) || empty($password) || empty($password_repeat) || empty($email))
			{
				header("Location: ../register.php?error=emptyfields");
				$conn = null;
				exit();
			}
			else if ($password !== $password_repeat)
			{
				header("Location: ../register.php?error=passwordmismatch");
				$conn = null;
				exit();
			}
			else if (strlen($password) < 8)
			{
				header("Location: ../register.php?error=shortpassword");
				$conn = null;
				exit();
			}
			else if (!preg_match('/[\'^£$%&*()}{@#~?>!<>,|=_+¬-]/', $password))
			{
				header("Location: ../register.php?error=nospecial");
				$conn = null;
				exit();
			}
			else
			{
				$sql = "SELECT userLogin FROM users WHERE userLogin = ?";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$username]);
				$user = $stmt->fetch();
				if ($user)
				{
					header("Location: ../register.php?error=usernametaken");
					$conn = null;
					exit();
				}
				else
				{
					$hash = password_hash($password, PASSWORD_DEFAULT);
					$sql = 'INSERT INTO users (userLogin, userPass, userEmail, userEmailVerified, userCode, userImage) VALUES (?, ?, ?, ?, ?, ?)';
					$stmt = $conn->prepare($sql);
					$code = md5($username);
					$stmt->execute([$username, $hash, $email, $verify, $code, $data]);
					$user = new User($username);
					$user->email();
					header("Location: ../index.php?action=registered");
					$conn = null;
					exit();
				}
			}
		}
		$conn = null;
	}

	function unregister() {

		//require './config.php';
		require('C:/xampp/htdocs/ams/config.php');
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";   
		$dbname = "ams_db";
		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			header("Location: index.php?error=PDOerror");
		}

		if (session_status() == PHP_SESSION_NONE)
			session_start();
		if($conn === false)
		{
			$conn = null;
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		$sql = "UPDATE users SET userPermissions = 0 WHERE userlogin='{$_SESSION['current_user']}'";
		$conn->query($sql);
		session_destroy();
		session_unset();
		header ("Location: ../index.php");
		$conn = null;
		exit();
	}

	function forgot($username)
	{
		//require './config.php';
		require('C:/xampp/htdocs/ams/config.php');
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";   
		$dbname = "ams_db";

		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT * FROM users WHERE userLogin=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$username]);
			$user = $stmt->fetch();

			if (!$user)
			{
				header("Location: ../login.php?error=invalidUser");
				exit();
			}
		}
		catch(PDOException $e)
		{
			header("Location: index.php?error=PDOerror");
		}

		if (session_status() == PHP_SESSION_NONE)
			session_start();

		password_reset($user['userEmail'], $user['userCode']);

	}
	
	switch ($_GET["action"])
	{
		case "login":
			login();
			break;
		case "register":
			register();
			break;
		case "unregister":
			unregister();
			break;
		case "forgot":
			if (!isset($_POST['userLogin']))
			{
				header("Location: ../login.php?error=nousergiven");
				exit();
			}
			forgot($_POST['userLogin']);
			break;
		case "logout":
			logout();
			break;
	}

?>