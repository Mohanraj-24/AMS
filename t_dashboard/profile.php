<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['current_user']))
		header("Location: login.php");

	// require "./t_dashboard/header.php";
    require_once ('C:/xampp/htdocs/ams/t_dashboard/header.php');

	include_once ('C:/xampp/htdocs/ams/config.php');

	require "includes/Classes/User.class.php";


	if (isset($_SESSION['current_user']) || isset($_GET['user'])) {
		if (isset($_SESSION['current_user']))
			$user = new User($_SESSION['current_user']);
		elseif (isset($_GET['user']))
			$user = new User($_GET['user']);
	}

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$user = new User($_SESSION['current_user']);
		if (isset($_GET['user']))
			$user = new User($_GET['user']);

		$sql = "SELECT * FROM posts WHERE userID = $user->userID ORDER BY postDate DESC";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		header("Location: index.php?error=PDOerror");
        echo "<script> alert('PDOerror')</script>";

	}

	$redir = $_SERVER['REQUEST_URI'];
?>

<html>
	<head>
		<link rel="stylesheet" href="styles/w3.css">
		<link rel="stylesheet" href="styles/profile.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="w3-container w3-main" style="margin-top:13vh;" id="main">
			<div class="w3-container w3-content" style="max-width:1400px">
				<div class="w3-row">
					<div class="w3-col m4 l4">
						<div class="w3-card cam-blue w3-padding-4">
							<div class="w3-container" id="profile">
								<?php
									if (isset($_GET['user']))
										echo "<h3 style='color: white;' class='w3-center'>$user->userLogin's PROFILE</h3>";
									else
										echo '<h3 style="color: white;" class="w3-center">MY PROFILE</h3>';
								?>
								
								<hr>
								<p class="w3-center">
									<img src="<?php echo('data:image/png;base64,'.base64_encode($user->userImage)) ?>" class="w3-circle" alt="User Avatar" style="width:160px;height:160px;background-color:white;">
								</p>
								<hr>
								<p class="w3-xlarge w3-center" style="color:white">
									<?php
									if (!empty($user->userFirstName && !empty($user->userLastName)))
										echo "$user->userFirstName $user->userLastName";
									?>
								</p>
								<hr>
								<?php
									if (!isset($_GET['user']) || ($_GET['user'] == $_SESSION['current_user'])) {
										echo "<a href='account.php'><button class='btn cam-white w3-black-text'><i class='fa fa-cog'></i>Account Settings</button></a>";
										echo "<a href='webcam.php'><button class='btn cam-white w3-black-text'><i class='fa fa-camera'></i>Post Image</button></a>";
									}
								?>
							</div>
						</div>

						<br>

						<div class="w3-card cam-blue">
							<div class="w3-container">
								<h3 style="color: white;" class="w3-center">
									<?php
										echo "$user->userLogin's Bio";
									?>
								</h3>
								<hr>
								<p class="w3-large w3-center" style="color:white">
									<?php
										if (!empty($user->userBio))
											echo "$user->userBio";
										else
											echo "You can set your bio from the account page!";
									?>
								</p>
							</div>
						</div>

						<br>

					</div>
					<div class="w3-col m7 l7 w3-right">
					 <!-- IMAGES HERE INFI SCROLL -->
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
							$username = $result2['userLogin'];
							if ($result2['userPermissions'] == 0)
								continue;
							$userV = new User($_SESSION['current_user']);
							?>
							<div class="w3-card-4 w3-display-container" id="<?=$id?>" style="color:black;">
								<?php
									if ($userV->userID == $row['userID'] || $userV->userPermissions == 7)
										echo '<button class="w3-large w3-button-cam w3-hover-red w3-display-topright" type="submit" id="delete-btn" onclick="delPost(\''.$id.'\',\''.$redir.'\')" title="Delete Post"><i class="fa fa-trash-o w3-text-black"></i></button> ';
								?>
								<img src="<?=$image?>" style="width: 100%;cursor:pointer" onclick="location.href = 'post.php?postID=<?=$id?>'" id="postImg">
								<div class="w3-container w3-center">
									<div class="w3-col w3-container" style="width:20%">
										<p class="w3-text-black" style="float: left;" id="likes">
											<button class="w3-button-nopad" onclick="likePost('<?=$id?>', '<?=$redir?>')"type="submit" id="like-btn"> <i class="fa fa-thumbs-o-up w3-text-black"></i> </button>
											<?=$likes?>
										</p>
									</div>

									<div class="w3-col w3-container" style="width:20%">
										<p class="w3-text-black" style="float: left;"><i class="fa fa-comment w3-text-black"></i><?=$comments?></p>
									</div>

									<div class="w3-col w3-container w3-right" style="width:50%">
										<p class="w3-text-black" id="postAuth" style="float: right;">Posted by: <?=$username?></p>
									</div>
								</div>
							</div>
							
							<br>

						<?php endforeach; ?>
					</div>
				</div>
			</div>
			
		</div>

		<br>

		<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
			<!-- <p>© 2019 Camagru</p> -->
		</div>

		<script type="text/javascript" src="includes/scripts/like.js"></script>

		<script type="text/javascript" src="includes/scripts/delete.js"></script>

	</body>
</html>
