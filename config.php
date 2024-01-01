<?php

define('CURRENCY', 'Rs.');
define('WEB_URL', 'http://localhost/ams/');
define('ROOT_PATH', 'C:\xampp\htdocs\ams/');


$servername = "127.0.0.1";
$username = "root";
$password = "";   
$dbname = "ams_db";
   // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
   // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>