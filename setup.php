<?php
	include 'config.php';
	try
	{
		$conn = new PDO("mysql:host=$servername", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
		$conn->query("use $dbname");
	}
	catch(PDOException $e)
	{
		echo $e->getMessage() . "<br>" . "Try updating your password.";
	}

	$sql = "CREATE TABLE IF NOT EXISTS users (
		userID int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		userLogin TINYTEXT NOT NULL,
		userFirstName TINYTEXT,
		userLastName TINYTEXT,
		userEmail LONGTEXT NOT NULL,
		userPass LONGTEXT NOT NULL,
		userPermissions int(4) default 3, 
		userEmailVerified BOOLEAN default 0,
		userPostCount int(11) default 0,
		userImage MEDIUMBLOB,
		userBio LONGTEXT,
		userPrivate BOOLEAN default 0,
		userCode LONGTEXT NOT NULL,
		userSubscribed BOOLEAN default 1
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$conn->exec($sql);

	$stmt = $conn->query("SELECT * FROM users where userLogin='Admin'");
	$user = $stmt->fetch();
	
	if (!$user)
	{
		$hash = password_hash("Admin", PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (userLogin, userEmail, userPass, userPermissions, userEmailVerified, userCode) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->execute(["Admin", "Admin@gmail.com", $hash, 7, 1, 1]);
	}

	$sql = "CREATE TABLE IF NOT EXISTS posts (
	 	postID int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		userID int(11) NOT NULL,
	 	FOREIGN KEY (userID) REFERENCES users(userID),
	 	postLikes int(11) default 0,
		postComments int(11) default 0,
		postDate TIMESTAMP default CURRENT_TIMESTAMP,
		postImage LONGTEXT NOT NULL
	 	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$conn->exec($sql);
	
	$sql = "CREATE TABLE IF NOT EXISTS comments (
		commentID int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
		postID int(11) NOT NULL,
		comment LONGTEXT NOT NULL,
		userID int(11),
		FOREIGN KEY (userID) REFERENCES users(userID),
		commentDate TIMESTAMP default CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$conn->exec($sql);


	$conn = null;
?>
