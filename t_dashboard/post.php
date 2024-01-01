<style>
.comment-section {
	display: none;
    align-items: center;
    margin-bottom: 20px;
}
body {
    font-family: 'Source Sans Pro', sans-serif;
    margin: 0;
    padding: 0;
}

.button-container {
    text-align: center;
    margin: 20px 0;
}

button {
    padding: 10px;
    margin: 0 10px;
    cursor: pointer;
}
textarea {
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 10px;
}
.bin{
	margin-top: -90px;
	margin-right:-16px;
}
.profile-pic-container {
    position: relative;
}
.box {
	border:1.5px solid black;
}

    .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 290px;
        }

        .username {
            font-weight: bold;
            margin-bottom: 5px;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            display: none;
        }

        .profile-pic-container:hover .username {
            display: block;
        }
		.w3-comment{
			margin-right:280px;
			margin-top:-14px;
		}

</style>
<?php
	require_once "C:/xampp/htdocs/ams/config.php";
    require_once "C:/xampp/htdocs/ams/t_dashboard/header.php";
	require "includes/Classes/User.class.php";
	
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	$user=NULL;
	if (isset($_SESSION["current_user"]))
		$user = new User($_SESSION["current_user"]);

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT * FROM posts WHERE postID=?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_GET['postID']]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
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
		<div class="w3-container w3-main" style="margin-top:13vh;" id="main">
			<div class="w3-container w3-content" style="max-width:400px;">

				<?php

					$image = $result['postImage'];
					$likes = strval($result['postLikes']);
					$id = $result['postID'];

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

					$sql = "SELECT * FROM users WHERE userID = {$result['userID']};";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$result2 = $stmt->fetch();
					$username = $result2['userLogin'];
				?>
				<div class="w3-card-4 w3-display-container" id="<?=$id?>" style="color: black;">
					<?php
						if (($user !== null) &&($user->userID == $result['userID'] || $user->userPermissions == 7))
							echo '<button class="w3-large w3-button-cam w3-hover-red w3-display-topright" type="submit" id="delete-btn" onclick="delPost(\''.$id.'\',\''.$redir.'\')" title="Delete Post"><i class="fa fa-trash-o w3-text-black"></i></button> ';
					?>
					<img src="<?=$image?>" style="width: 100%;height:60%;cursor:pointer" id="postImg">
					<div class="w3-container w3-center" id="detailsWrap">
						<div class="w3-col w3-container">
							<p class="w3-text-black" style="float:inline-start;margin-top:10px;"id="likes">
								<button class="w3-button-nopad" onclick="likePost('<?=$id?>', '<?=$redir?>')"type="submit" id="like-btn"> <i class="fa fa-thumbs-o-up w3-text-black"></i></button><?=$likes?></p>
							<p class="w3-text-black" style="margin-right:160px;"><i class="fa fa-comment w3-text-black"></i><?="  ".$comments?></p>
							<p class="w3-text-black" id="postAuth" style="margin-right:-160px;margin-top:-40px;">Posted by: <a href="profile.php?user=<?=$username?>"><?=$username?></a></p>
						</div>
					</div>
				</div>

				<?php
					if (isset($_SESSION["current_user"])){
						$pid = $_GET['postID'];
						echo"";}?>
						<div class="button-container">
    						<button id="addCommentBtn" onclick="toggleComments('addComment')">Add a New Comment</button>
    						<button id="viewCommentsBtn" onclick="toggleComments('viewComments')">View Comments</button>
  						</div>
                      	<div id='addComment' class='comment-section'>
							<div class='w3-container cam-dark-grey' id='comment-box'>
								<form class='w3-container form-container' style='color:black;' name='update' id='comment-form' method='POST' action='includes/commentHandler.php?action=create'>
									<h3 class='w3-text-white'>Add A Comment:</h3>
									<textarea rows='4' placeholder='Type a comment' name='comment' id='new-comment' form='comment-form' required></textarea>
									<input type='hidden' name='postID' value="<?php echo $pid?>">
									<input type='hidden' name='redir' value="<?php echo $redir?>">
									<button type='submit' name='submit-comment' id='comment-btn' class='btn' value='COMMENT'>ADD COMMENT</button>
								</form>
							</div>
					</div>
				<?php
					try
					{
						$servername = "127.0.0.1";
						$username = "root";
						$password = "";
						$dbname = "ams_db";
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$sql = "SELECT * FROM comments WHERE postID=?";
						$stmt = $conn->prepare($sql);
						$stmt->execute([$_GET['postID']]);
						$result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						// header("Location:index.php?error=PDOerror");
						echo "Connection failed: " . $e->getMessage();
					}
				?>
				<div id="viewComments" class="comment-section">
				<?php foreach($result3 as $comment): ?>
				<?php
					$current_comment = $comment['comment'];
					$comment_id = $comment['commentID'];
					$uid = $comment['userID'];
					
					$sql = "SELECT * FROM users WHERE userID={$comment['userID']}";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$userF = $stmt->fetch();
					$userID = $userF['userID'];
					$userName = $userF['userLogin'];
					$userImage = $userF['userImage'];
				?>
					<div class="w3-container box w3-padding-16 w3-border-bottom w3-border-black w3-display-container cam-red" style="background-color: #3c8dbc;" id="<?=$comment_id?>">
						<div class="w3-row">
							<div class="w3-col w3-auto w3-medium w3-comment">
								<p class="w3-text-black"><?=$current_comment?></p>
							</div>
							<div class="w3-col m1 l1 profile-pic-container" >
								<img src="<?php echo('data:image/png;base64,'.base64_encode($userImage)) ?>" alt="User Avatar" class="profile-pic" style="width:50px;height:50px;background-color:#c9d6df;">
								<div style="margin-top:0px;margin-bottom:0px;margin-left:4px;font-weight:bold;" class="w3-text-black username"><?php echo $userName;?></div>
						    </div>
						</div>
						<?php
						if ($user->userID == $uid || $user->userPermissions == 7)
							echo '<button class="w3-button w3-large w3-hover-red bin w3-right cam-white" id="delete-btn" style="color:black;" onclick="delComment(\''.$comment_id.'\',\''.$redir.'\')" title="Delete Comment"><i class="fa fa-trash-o"></i></button>';
						?>
					</div>
					<?php endforeach; ?>
				</div>
				
			</div>
				</div>
		<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
			<!-- <p>© 2019 Camagru</p> -->
		</div>

        <script type="text/javascript" src="includes/scripts/like.js"></script>

        <script type="text/javascript" src="includes/scripts/delete.js"></script>
		<script>
			function toggleComments(sectionId) {
    const sections = document.getElementsByClassName('comment-section');

    for (let i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }

    document.getElementById(sectionId).style.display = 'block';
}
</script>

	</body>
</html>