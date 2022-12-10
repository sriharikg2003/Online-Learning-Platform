<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .inner{
            margin-top: 0;
            padding: 10px;
            width: 241px;
            height: 40px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0px;
            text-align: center;
        }
        .one{
            margin:25px;
            width: 260px;
            height: 200px;
            border:1px solid #B7C4CF;
            border-radius: 10px;
            background-color: #abd9ff;
        }
        .one:hover{
            box-shadow: 2.5px 2.5px #DADBDB;
        }
        .flex{
            /* margin: auto;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            align-content:space-around; */
            margin:auto;
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            flex-direction: row;
            align-content: center;
        }
        .sub{
            font-size: 25px;
            border:none;
            background-color:#abd9ff;
            color:blue;
            text-align:center;
        }
        .bottom{
            text-align: center;
        }
        .pending{
            color:red;

        }
        .ongoing{
            color:yellow;
        }
        .comp{
            color:green;
        }
        .bottom{
            display: flex;
            justify-content: center;
            align-items: center;
            height:40px;
        }
    </style>
</head>
<body>

<form action="studentAnnouncements.php" method="post">
        <input type="submit" value="Back">
</form>
    
<!-- <div class="total"> -->
<div class="flex">
<?php
session_start();
date_default_timezone_set("Asia/Calcutta");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classroom";

// if(isset($_POST['Result'])){
//     header("Location:try.php");
// }

if($_SERVER['REQUEST_METHOD']=='POST'){

    

    $conn = new mysqli($servername, $username, $password, $dbname);
    $semail = $_SESSION['studentEmail'];
    $coursecode = $_SESSION['coursecode'];
    $t = date("Y-m-d H:i:s"); 
    // $t=date("Y-m-d",$k);
    // echo $t;
    $sql="SELECT * FROM tests WHERE coursecode ='$coursecode' ";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        while($row = $res->fetch_assoc()){
            $sttime=$row['startTime'];
            $edtime=$row['endTime'];
            // echo $sttime;
            // echo "<br>";
            // echo $edtime;
            if($t<$sttime && $t <$edtime){
                echo "<br>";
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                $_SESSION["qno"]=1;
                // $qno=$_SESSION["qno"];
                echo "
                <div class='flex' >
                    <div class='one'>
                        <div class='inner'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'> 
                        <br><br>
                        </div> 
                        <h5>Status: </h5><h4 class='pending'>Pending</h4>
                        <div class='bottom'>
                        <form id='view_form' method='post' action='try.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        </form>
                        </div>
                    </div>
                </div>";
            }else if($t >$sttime && $t <$edtime){
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                $_SESSION["qno"]=1;
                echo "
                <div class='flex' >
                    <div class='one'>
                        <div class='inner'>
                        <form id='view_form' method='post' action='testPage.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'> 
                        <br><br>
                        </form>
                        </div> 
                        <h5>Status: </h5> <h4 class='ongoing'>Ongoing</h4>
                        <div class='bottom'>
                        <form id='view_form' method='post' action='try.php'>
                        <input name='test_id' type='hidden' value='$id'>

                        </form>
                        </div>
                    </div>
                </div>";
            }else{
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                $_SESSION["qno"]=1;
                echo "
                <div class='flex' >
                    <div class='one'>
                        <div class='inner'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'> 
                        <br><br>
                        </div> 
                        <h5>Status: </h5> <h4 class='comp'>Completed</h4>
                        <div class='bottom'>
                        <form id='view_form' method='post' action='try.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='Result' title='Result' class='' value='Result'>
                        </form>
                        </div>
                    </div>
                </div>";
            }                
        }            
    }else{
        echo "No Upcoming tests ";
    }

    $conn->close();

}

?>
</div>
</body>
</html>