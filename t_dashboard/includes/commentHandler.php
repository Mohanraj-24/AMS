<?php

	function email($email, $redir)
	{
		$message = "You have a new comment on your post!";
		$subject = "New comment!";
		$headers = "From: CameronSTaljaard@gmail.com"."\r\n";
		$headers .= "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

		mail($email, $subject, $message, $headers);
		header("Location: $redir");
	}

	function emailSender($postID, $redir)
	{
		require_once ('C:/xampp/htdocs/ams/config.php');
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "ams_db";

		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT * FROM posts WHERE postID=?";
			$stmt = $conn->prepare($sql);
		 	$stmt->execute([$postID]);
			$post = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
		 	header("Location: ../index.php?error=PDOerror");
		}
		
		if (!$post)
		{
			header ("Location: ../index.php?error=invalidPost");
			exit();
		}
		$sql = "SELECT * FROM users WHERE userID=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$post['userID']]);
		$user = $stmt->fetch();
		if ($user['userSubscribed'])
			email($user['userEmail'], $redir);
		else
			header ("Location: $redir");
	}

	function deleteComment($commentID, $redir)
	{
		require_once ('C:/xampp/htdocs/ams/config.php');
		require './Classes/User.class.php';
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "ams_db";

		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT * FROM comments WHERE commentID=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$commentID]);
			$comment = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			header("Location: ../index.php?error=PDOerror");
		}
		$user = new User($_SESSION['current_user']);
		if (!$user)
		{
			header ("Location: ../index.php?error=noUser");
			exit();
		}
		if ($user->userPermissions < 7)
		{
			if ($user->userID != $comment['userID'])
			{
				header ("Location: ../index.php?error=invalidPermissions");
				exit();
			}
		}
		// $var = strval($commentID);
		// echo "<script> console.log('$var'); </script>";
		$sql = "DELETE FROM comments WHERE commentID=$commentID";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		header ("Location: $redir");
	}

	function createComment($postID, $comment, $redir)
	{
		require_once ('C:/xampp/htdocs/ams/config.php');
		require './Classes/User.class.php';
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "ams_db";

		$comment = str_replace("<","&lt;",$comment);
			
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

		if (!$comment)
		{
			header ("Location: ../index.php?error=noComment");
			exit();
		}
		$user = new User($_SESSION['current_user']);
		if (!$user)
		{
			header ("Location: ../index.php?error=invalidUser");
			exit();
		}
		$sql = "INSERT INTO comments (postID, userID, comment) VALUES (?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$postID, $user->userID, $comment]);
		emailSender($postID, $redir);
	}

	if (session_status() == PHP_SESSION_NONE)
			session_start();

	if (!isset($_SESSION['current_user']))
	{
		header ("Location: ../index.php?error");
		exit();
	}

	if ((!isset($_POST["postID"]) || !isset($_POST["comment"])) && !isset($_POST["commentID"]))
	{
	 	header ("Location: ../index.php?error");
		exit();
	}

	switch ($_GET["action"])
	{
		case "create":
			createComment($_POST["postID"], $_POST["comment"], $_POST["redir"]);
			break;
		case "delete":
			deleteComment($_POST["commentID"], $_POST["redir"]);
			break;
		// case "getcomments";
		// 	getComments($_POST["postID"]);
		// 	break;
	}
	exit();

?>