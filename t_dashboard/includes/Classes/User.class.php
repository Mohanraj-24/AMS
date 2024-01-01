<?php

	class User
	{
		public $userID;
		public $userLogin;
		public $userPass;
		public $userFirstName;
		public $userLastName;
		public $userEmail;
		public $userImage;
		public $userBio;
		public $userPermissions;
		public $userVerified;
		public $userPrivate;
		public $userSubscribed;
		public $userPostCount;
		public $userCode;


		public function __construct($username)
		{
			//include './config.php';
			$servername = "127.0.0.1";
            $dbusername = "root";
            $password = "";
            $dbname = "ams_db";
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
			$sql = "SELECT * FROM users WHERE userLogin=?";
			$stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			if($user){
			$this->userID = $user["userID"];
			$this->userLogin = $user["userLogin"];
			$this->userPass = $user["userPass"];
			$this->userFirstName = $user["userFirstName"];
			$this->userLastName = $user["userLastName"];
			$this->userEmail = $user["userEmail"];
			$this->userImage = $user["userImage"];
			$this->userBio = $user["userBio"];
			$this->userPostCount = $user["userPostCount"];
			$this->userPermissions = $user["userPermissions"];
			$this->userVerified = $user["userEmailVerified"];
			$this->userPrivate = $user["userPrivate"];
			$this->userSubscribed = $user["userSubscribed"];
			$this->userCode = $user["userCode"];
			}

			$conn = null;
		}

		public function email()
		{
			$code = md5($this->userLogin);
			$message = "Welcome to Camagru!
			Please verify your email address by visiting this page:
			http://localhost/camagru/index.php?action=verify&code=$code";
			$subject = "Email verification required";
			$headers = "From: CameronSTaljaard@gmail.com"."\r\n";
			$headers .= "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

			mail($this->userEmail, $subject, $message, $headers);
		}

		public function verifyEmail($code)
		{
			 include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			if (password_verify($this->userID, $code))
			{
				try
				{
					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$sql = "UPDATE users SET userEmailVerified=1 WHERE userID=$this->userID";
					$stmt = $conn->prepare($sql);
					$stmt->execute([$hash]);
				}
				catch(PDOException $e)
				{
					return (FALSE);
				}
			}
			$conn = null;
			return (TRUE);
				
		}

		public function dump()
		{
			echo "<pre>";
			var_dump($this);
			echo "</pre>";
		}
		public function changePassword($password)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";

			if (strlen($password) < 8)
			{
				return (-1);
			}
			if (!preg_match('/[\'^£$%&*()}{@#~?>!<>,|=_+¬-]/', $password))
			{
				return (-2);
			}

			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$hash = password_hash($password, PASSWORD_DEFAULT);
				$sql = "UPDATE users SET userPass=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$hash]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (1);
		}

		public function setPassword($oldPassword, $newPassword)
		{
			include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$passwordCheck = password_verify($oldPassword, $this->userPass);
				if ($passwordCheck === FALSE)
				{
					return (FALSE);
				}
				else
				{
					$hash = password_hash($newPassword, PASSWORD_DEFAULT);
					$sql = "UPDATE users SET userPass=? WHERE userID=$this->userID";
					$stmt = $conn->prepare($sql);
					$stmt->execute([$hash]);
				}
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setEmail($oldPassword, $newEmail)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$passwordCheck = password_verify($oldPassword, $this->userPass);
				if ($passwordCheck === FALSE)
				{
					return (FALSE);
				}
				else
				{
					$sql = "UPDATE users SET userEmail=? WHERE userID=$this->userID";
					$stmt = $conn->prepare($sql);
					$stmt->execute([$newEmail]);
				}
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setLogin($login)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "SELECT * FROM users WHERE userLogin=?;";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$login]);

				if (count($stmt->fetchAll(PDO::FETCH_ASSOC)))
				{
					return (0);
				}

				$sql = "UPDATE users SET userLogin=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$login]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setFirstName($firstName)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userFirstName=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$firstName]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setLastName($lastName)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userLastName=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$lastName]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setPermissions($permissions)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userPermissions=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$permissions]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setVerified($verified)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userEmailVerified=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$verified]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setPostCount($postCount)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userPostCount=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$postCount]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setImage($image)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userImage=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$image]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setBio($bio)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userBio=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$bio]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}
		public function setPrivate($private)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userPrivate=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$private]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}

		public function setSubscribed($subscribed)
		{
			// include  './config.php';
			$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ams_db";
			
			try
			{
				$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "UPDATE users SET userSubscribed=? WHERE userID=$this->userID";
				$stmt = $conn->prepare($sql);
				$stmt->execute([$subscribed]);
			}
			catch(PDOException $e)
			{
				return (FALSE);
			}
			$conn = null;
			return (TRUE);
		}
	}

?>