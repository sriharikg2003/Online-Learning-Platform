<!DOCTYPE html>
<html>
<body>

<?php 
session_start();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_SESSION["email"];
$subject= $_SESSION['subject'] = $_POST['subject'];
$_SESSION["coursename"]=test_input($_POST["coursename"]);
$coursename = $_SESSION["coursename"];
$coursecode = rand(1000000000,9999999999);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE TABLE courses (profemail varchar(255),coursename varchar(255), coursecode varchar(255) PRIMARY KEY)";
    if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
    } else {
    echo "Error creating table: " . $conn->error;
    }

    $conn->close();
}

catch(Exception $e){
echo "";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO courses (profemail,coursename,subject,coursecode) VALUES ('$email','$coursename','$subject','$coursecode')";
$conn->query($sql);
$conn->close();

}

?>

<h1>CREATE COURSE</h1><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Course name:
    <input type="text" name="coursename" placeholder="Enter Course name eg.(CS 102)">
    <br><br>
    Subject:
    <input type="text" name="subject" placeholder="Enter subject name eg.(Computer Programming)">
    <br><br>
    <input type="submit" value='Create'>
</form>
<br>
<form action="professorHome.php">
    <input type="submit" value="Go back to Home">
</form>

</body>
</html>