 <?php
$servername = "localhost";
$username = "mysql";
$password = "discworld42";
$db_name = "php_dev_forum_db";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?> 
