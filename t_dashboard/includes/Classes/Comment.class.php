<?php

    class Comment
    {
        public $commentID;
        public $comment;
        public $userID;
        public $commentDate;

        public function __construct($commentID)
        {
            include  'C:/xampp/htdocs/ams/config.php';

            if (!$commentID)
            {
                echo "Connection failed: " . $e->getMessage();
            }
            
            try
			{
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM comments WHERE commentID=?;";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$commentID]);
                $comment = $stmt->fetch();
                
                $this->commentID = $commentID;
                $this->comment = $comment['comment'];
                $this->userID = $comment['userID'];
                $this->commentDate = $comment['commentDate'];
                
			}
			catch(PDOException $e)
			{
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function console_dump()
        {
            echo "<script> console.log('$this->commentID'); </script>";
            echo "<script> console.log('$this->comment'); </script>";
            echo "<script> console.log('$this->userID'); </script>";
            echo "<script> console.log('$this->commentDate'); </script>";
        }
    }