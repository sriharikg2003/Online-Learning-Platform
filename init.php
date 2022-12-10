
<?php
session_start();
session_destroy();


$servername = "localhost";
$username = "root";
$password = "";


$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
try{
$sql = file_get_contents('classroom.sql');
$conn->multi_query($sql);
}
catch (Exception $e) {
    echo "";
}


$conn->close();
?>
