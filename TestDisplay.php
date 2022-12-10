<?php 
session_start();
date_default_timezone_set("Asia/Calcutta");
$t = time();
$b = strtotime($_SESSION['test-start-time']);
$stime = $_SESSION['test-start-time'];
$c = strtotime($_SESSION['test-end-time']);
$etime = $_SESSION['test-end-time'];
if($t > $b && $t< $c){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "test Started";
    echo $sql;
}
else if($t < $b){
    echo "<h1>No test found test will start at $stime</h1>";
}
else{
    echo "<h1>No test found test ended at $etime</h1>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    
</body>
</html>