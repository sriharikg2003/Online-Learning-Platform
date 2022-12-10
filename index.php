
<?php
session_start();
session_destroy();


$servername = "localhost";
$username = "root";
$password = "";

// Create connection
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
// if ($conn->multi_query($sql) === TRUE) {
//   echo "New records created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seventh Sanctum Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>
<body> 
    <header class= "head">
            <div class="logo" >
                <h1>Seventh-Sanctum</h1>
            </div>
            <ul class="links">
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><button class="loginbtn"><a href="studentLogin.php">Student Login</a></button></li>
                <li><button class="loginbtn"><a href="professorLogin.php">Professor Login</a></button></li>
            </ul>
    </header>
        <main>
            <div class="left">
                <h2 class="title">SEVENTH SANCTUM</h2>
                <div class="reltext">
                    <h3 class="tagline">Connecting Brilliant Minds accross the Globe</h3>
                    <p class="lines">With the goal of delivering smooth flow course management this website
serves as an efficient solution</p>
                </div>
                <button class="btn">Learn More</button>
            </div>
            <div class="right">
                <img src="class.jpg" alt="" class="img">
            </div>
        </main>
    <footer>
    </footer>
</body>
</html>
