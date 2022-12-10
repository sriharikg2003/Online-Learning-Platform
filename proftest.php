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
        }
        .one:hover{
            box-shadow: 2.5px 2.5px #DADBDB;
        }
        .flex{
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            align-content: space-between;
        }
        .sub{
            font-size: 25px;
            border:none;
            background-color:white;
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
        .left{
            width:50%;
            float:left;
        }
        .right{
            width:50%;
            float:right;
        }
    </style>
</head>
<body>

<form action="profAnnouncements.php" method="post">
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
    $semail = $_SESSION['email'];
    $coursecode = $_SESSION['coursecode'];
    $t = date("Y-m-d H:i:s"); 
    // echo $t;
    $sql="SELECT * FROM tests WHERE coursecode ='$coursecode' ";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        while($row = $res->fetch_assoc()){
            $sttime=$row['startTime'];
            $edtime=$row['endTime'];
            // echo $t;
            // echo "<br>";
            // echo $sttime;
            // echo "<br>";
            // echo $edtime;
            if($t<$sttime && $t <$edtime){
                echo "<br>";
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                $_SESSION["qno"]=1;
                // echo $id;
                // $qno=$_SESSION["qno"];
                echo "
                <div class='flex' >
                    <div class='one'>
                        <div class='inner'>
                        <form id='view_form' method='post' action='showques.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'>
                        <br><br>
                        </form>
                        </div>
                        <h5>Status: <span class='pending'></span> </h5>
                        <div class='bottom'>
                        <div class='left'>
                        <form id='view_form' method='post' action='profResp.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='resp' title='Responses' class='' value='Responses'>
                        </form>
                        </div>
                        <br>
                        <div class='right'>
                        <form id='view_form' method='post' action='figProf.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='Result' title='Result' class='' value='Result'>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>";
            }else if($t >$sttime && $t <$edtime){
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                echo "
                <div class='flex' >
                    <div class='one'>
                        <div class='inner'>
                        <form id='view_form' method='post' action='showques.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'> 
                        <br><br>
                        </form>
                        </div> 
                        <h5>Status:  <span class='ongoing'>Ongoing</span> </h5>
                        <div class='bottom'>
                        <div class='left'>
                        <form id='view_form' method='post' action='profResp.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='resp' title='Responses' class='' value='Responses'>
                        </form>
                        </div>
                        <br>
                        <div class='right'>
                        <form id='view_form' method='post' action='figProf.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='Result' title='Result' class='' value='Result'>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>";
            }else{
                $c=$row["testName"];
                $cc=$row["coursecode"];
                $id=$row["id"];
                echo "
                <div class='flex' >
                    <div class='one'>
                    <div class='inner'>
                        <form id='view_form' method='post' action='showques.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='dummy' title='$c' class='sub' value='$c'> 
                        <br><br>
                        </form>
                    </div>
                        <h5>Status:  <span class='comp'>Completed</span> </h5>
                        <div class='bottom'>
                        <div class='left'>
                        <form id='view_form' method='post' action='profResp.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='resp' title='Responses' class='' value='Responses'>
                        </form>
                        </div>
                        <br>
                        <div class='right'>
                        <form id='view_form' method='post' action='figProf.php'>
                        <input name='test_id' type='hidden' value='$id'>
                        <input type='submit' name='Result' title='Result' class='' value='Result'>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>";
            }                
        }            
    }else{
        echo"<br><br>";
        echo "<h3 color='blue'>No Upcoming tests</h3>";
    }

    $conn->close();

}

?>

</div>
</body>
</html>