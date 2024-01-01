<?php
	require_once "../setup.php";
	require('C:/xampp/htdocs/ams/t_dashboard/header.php');
	require "includes/Classes/User.class.php";
	require_once "../config.php";
	
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	$user=NULL;
	if (isset($_SESSION["current_user"]))
		$user = new User($_SESSION["current_user"]);

	// if ($_GET["action"] === "forgot")
	// if (isset($_GET["action"]) && $_GET["action"] === "forgot")
	// {
	// 	try
	// 	{
	// 		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// 		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// 		$sql = "SELECT * FROM users WHERE userCode=?";
	// 		$stmt = $conn->prepare($sql);
	// 		$stmt->execute([$_GET["code"]]);
	// 		$user = $stmt->fetch();

	// 		if (!$user)
	// 		{
	// 			header("Location: index.php?error=criticalfailure");
	// 			exit();
	// 		}
	// 		$_SESSION['current_user'] = $user['userLogin'];
	// 		header("Location: reset.php");
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		header("Location: index.php?error=PDOerror");
	// 	}
	// }
	//if ($_GET["action"] === "verify")
	if (isset($_GET["action"]) && $_GET["action"] === "verify")
	{
		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT * FROM users WHERE userCode=?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$_GET['code']]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result)
			{
				$sql = "UPDATE users set userEmailVerified=1 WHERE userCode=?";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$_GET['code']]);
			}
		}
		catch(PDOException $e)
		{
			header("Location: index.php?error=PDOerror");
		}
		$conn = null;
	}
	//if ($_GET["action"] === "registered")
	if (isset($_GET["action"]) && $_GET["action"] === "registered")
		echo "<script> alert('E-Mail verification Done Now you can login to continue'); </script>";

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT * FROM posts ORDER BY postDate DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		header("Location: index.php?error=PDOerror");
	}

	$redir = $_SERVER['REQUEST_URI'];
?>

<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/index.css">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="w3-container w3-main" style="margin-top:72px;" id="main">
			<h1 class="w3-center" style="color: black;" id="welcome">Welcome, Guest! <a href='login.php'>Login Here</a></h1>
			<div class="w3-container w3-content" style="max-width:400px;">

				<?php foreach($result as $row):

					$image = $row['postImage'];
					$likes = strval($row['postLikes']);
					$id = $row['postID'];

					try
					{
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						$comments = strval($conn->query("select count(*) from comments where postID=$id")->fetchColumn());
					}
					catch(PDOException $e)
					{
						header("Location: index.php?error=PDOerror");
					}
					
					$sql = "SELECT * FROM users WHERE userID = {$row['userID']};";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$result2 = $stmt->fetch();
					$tusername = $result2['userLogin'];
					if ($result2['userPermissions'] == 0)
						continue;
					?>
					<div class="w3-card-4 w3-display-container" id="<?=$id?>" style="color: black;">
						<?php
							if (($user!=NULL) && ($user->userID == $row['userID'] || $user->userPermissions == 7))
								echo '<button class="w3-large w3-button-cam w3-hover-red w3-display-topright" type="submit" id="delete-btn" onclick="delPost(\''.$id.'\',\''.$redir.'\')" title="Delete Post"><i class="fa fa-trash-o w3-text-black"></i></button> ';
						?>
						<img src="<?=$image?>" style="width: 100%;height:60%;cursor:pointer" onclick= "location.href = 'post.php?postID=<?=$id?>'" id="postImg">
						<div class="w3-container w3-center" id="detailsWrap">
							<div class="w3-col w3-container">
								<p class="w3-text-black" style="float:inline-start"id="likes">
									<button class="w3-button-nopad" onclick="likePost('<?=$id?>', '<?=$redir?>')"type="submit" id="like-btn"> <i class="fa fa-thumbs-o-up w3-text-black"></i></button><?=$likes?>
								</p>
								<p class="w3-text-black" style="margin-right:160px;"><i class="fa fa-comment w3-text-black"></i><?="  ".$comments?></p>
								<p class="w3-text-black" id="postAuth" style="margin-right:-180px;margin-top:-40px;">Posted by: <a href="profile.php?user=<?=$tusername?>"><?=$tusername?></a></p>
							</div>

							<!-- <div class="w3-col w3-container">
								
							</div> -->

							<!-- <div class="w3-col w3-container w3-right" style="width:60%">
								
							</div> -->
						</div>
					</div>

					<br>

				<?php endforeach; ?>
			
			</div>
		</div>

		<?php
			if ($user && $user->userLogin !== NULL) {
				echo "<script type='text/javascript'> document.getElementById('welcome').innerHTML = 'Welcome, $user->userLogin!'; </script>";
			// } else {
			// 	echo "<script type='text/javascript'> document.getElementById('welcome').innerHTML = 'Welcome, Guest! <a href='login.php'>Login Here</a>'; </script>";
			}
		?>

		<br>

		<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
			<!-- <p>© 2019 Camagru</p> -->
		</div>

        <script type="text/javascript" src="includes/scripts/like.js"></script>

        <script type="text/javascript" src="includes/scripts/delete.js"></script>
	</body>
</html>