<?php

	function likePost($postID, $redir)
	{
		// 
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
		
		if(!isset($_SESSION["current_user"]))
		{
			header ("Location: ../index.php?error=noUser");
			exit();
		}
		
		$sql = "UPDATE posts SET postLikes = postLikes + 1 WHERE postID = $postID";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		
		unset($_POST["postID"]);
		header("Location: $redir");
		exit();
	}

	function createPost($image)
	{
		// include  'C:/xampp/htdocs/ams/config.php';
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

		if(!isset($_SESSION["current_user"]))
		{
			header ("Location: ../index.php?error=noUser");
			exit();
		}

		if (!$image)
		{
			header ("Location: ../index.php?error=noImage");
			exit();
		}

		$sql = "SELECT userID FROM users WHERE userLogin = '{$_SESSION['current_user']}'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$user = $stmt->fetch();

		if (!$user)
		{
			header ("Location: ../index.php?error=invalidUser");
			exit();
		}

		$sql = "INSERT INTO posts (postImage, userID) VALUES (?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$image, $user['userID']]);
		unset($_POST["postImage"]);
		header("Location: ../index.php");
		exit();
	}

	function deletePost($postID, $redir)
	{	
		// include  'C:/xampp/htdocs/ams/config.php';
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

		if(!isset($_SESSION["current_user"]))
		{
			header ("Location: ../index.php?error=noUser");
			exit();
		}
		if(!isset($postID))
		{
			header ("Location: ../index.php?error=invalidID");
			exit();
		}
		
		$sql = "SELECT * FROM posts WHERE postID = ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$postID]);
		$post = $stmt->fetch();

		if (!$post)
		{
			header ("Location: ../index.php?error=invalidPost");
			exit();
		}
		else
		{
			$sql = "DELETE FROM comments WHERE postID=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$postID]);
			$sql = "DELETE FROM posts WHERE postID=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$postID]);
		}
		$conn = null;
		unset($_POST["postID"]);
		switch ($redir) {
			case "/camagru/index.php":
				header("Location: $redir?success");
				break;
			case "/camagru/profile.php":
				header("Location: $redir?success");
				break;
			default:
				header("Location: ../index.php?success");
				break;
		}
	}

	// if (!isset($_POST["postID"]) && !isset($_POST["postImage"]))
	// {
	// 	header ("Location: ../index.php?error=missingdata");
	// 	exit();
	// }

	switch ($_GET["action"])
	{
		case "delete":
			deletePost($_POST["postID"], $_POST["redir"]);
			break;
		case "create":
			createPost($_POST["postImage"]);
			break;
		case "like":
			likePost($_POST["postID"], $_POST["redir"]);
			break;
	}
	// exit();

?>