<?php
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    if (!isset($_SESSION['current_user']))
		header ("Location: login.php");

    require_once ('C:/xampp/htdocs/ams/t_dashboard/header.php');
    require "includes/Classes/User.class.php";
	include "../config.php";
    

    if (isset($_SESSION["current_user"]))
        $user = new User($_SESSION["current_user"]);

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user = new User($_SESSION['current_user']);

        $sql = "SELECT * FROM posts WHERE userID = $user->userID ORDER BY postDate DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        // header("Location: index.php?error=PDOerror");
        echo "<script> alert('PDOerror')</script>";

    }
?>

<html>
    <head>
        <link href="styles/w3.css" rel="stylesheet">
        <link href="styles/webcam.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="w3-container w3-main" style="margin-top:12vh;" id="main">
            <div class="w3-container w3-content" style="max-width:1400px;">
                <div class="w3-row">
                    <div class="w3-col m7 l7">
                        <div class="w3-card cam-blue w3-auto">
                            <div class="w3-container cam-blue">
                                <h3>Capture (or upload) an image, add some filters:</h3>
                            </div>

                            <br>

                            <!-- Stream video via webcam -->
                            <div class="w3-container w3-center w3-auto webcamcontainer" id="webcon">
                                <video class="webcam w3-auto w3-image" id="video" playsinline autoplay></video>
                                <canvas class="w3-image w3-auto preview" id="preview"></canvas>
                            </div>

                            <br>

                            <!-- Webcam video snapshot -->
                            <div class="w3-container w3-auto cam-white">
                                <div class="scroll">
                                    <?php
                                        $directory = "/images/super/";
                                        $superimgs = glob( $directory ."*" );
                                        $filecount = ($superimgs) ? count($superimgs) : 0;
                                        foreach ($superimgs as $key => $value) {
                                            $pathparts = pathinfo($value);
                                            ?>
                                                <img src="<?=$value?>" alt="<?=$pathparts['filename']?>" <?php echo ((strstr($value, "_2")) ? 
                                                ("id=\"".substr($pathparts['filename'], 0, strlen($pathparts['filename']) - 2)."\" hidden") : 
                                                ("onclick=\"paint(document.getElementById('".$pathparts['filename']."'))\""))?> >
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <br>

                            <!-- Trigger canvas web API -->
                            <div class="w3-container controller w3-center">
                                <button id="clear" class="btn">CLEAR STICKERS</button>
                            </div>

                            <br>

                            <div class="w3-container controller w3-center">
                                <button id="snap" class="btn">CAPTURE</button>
                            </div>

                            <br>

                            <div class="w3-container w3-center">
                                <input type='file' id="fileUpload" accept="image/*" style="color:black;"/>
                            </div>

                            <br>

                        </div>

                        <br> <!-- SPACING BETWEEN CARDS -->

                        <div class="w3-card cam-blue w3-auto">
                            <div class="w3-container cam-blue">
                                <h3>Ready to Post?</h3>
                            </div>

                            <br>

                            <div class="w3-container w3-center">
                                <canvas class="w3-image" style="background-color:white;" id="canvas" onchange="post.disabled = false"></canvas>
                            </div>

                            <br>

                            <div class="w3-container w3-center">    
                                <button class="btn" id="submit-post">POST IMAGE</button>
                            </div>
                        </div>

                        <br>
                    </div>

                    <div class="w3-col m4 l4 w3-right">
                        <div class="w3-container w3-card cam-blue">
                            <h3>Your Previous Posts:</h3>
                        </div>

                        <div class="w3-container w3-card cam-blue" id="prevPost">
                            <?php foreach($result as $row): ?>

                                <?php
                                    $image = $row['postImage'];
                                    $likes = strval($row['postLikes']);
                                    $comments = strval($row['postComments']);
                                    $id = $row['postID'];
                                ?>

                                <div class="w3-card-4" id="<?=$id?>" style="color: black;">
                                    <img <?php echo "src='$image'"; ?> style="width: 100%;">
                                </div>

                                <br>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="includes/scripts/photo.js"></script>

        <br>

		<div class="w3-container w3-right-align cam-dark-grey w3-padding-4">
			<!-- <p>© 2019 Camagru</p> -->
		</div>
    </body>
</html>

